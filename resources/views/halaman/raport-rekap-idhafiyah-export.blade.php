
<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nomor Induk</th>
            <th rowspan="2">Nama Lengkap</th>
            <th rowspan="2">Nama Dalam Arabic</th>
            <th rowspan="2">Kelas</th>
            <th rowspan="2">L/P</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">نتيجة كشف الدرجات</th>
            @php
                $mpGroup = collect($mudalfashl);
                $tmpgroup = array();
                $imp = 0;
                foreach($mpGroup as $kmpg=>$vmpg)
                {
                    $mp = collect($mf)->get($vmpg['id']);
                    $nilaimp = 0;
                    $tmpgroup[$imp]['group_ar'] = $vmpg['name_group_ar'];
                    $imp++;
                }
            @endphp
            <th class="text-center" {{ count($tmpgroup)!=0 ? 'colspan='.count($tmpgroup).'' : '' }}>نتيجة مواد الأساس</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">مقرر القرآن (مقرر الحلقة)</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">مقرر القرآن (مقرر المستوى)</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">ملاحظة قسم شؤون الطلاب</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">فعاليات ولي الأمر</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">النتيجة النهائية</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">رتبة النتيجة في الدفعة</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">رتبة النتيجة في الصف</th>
        </tr>
        <tr>
            @foreach($tmpgroup as $k=>$v)
            <th class="arabic" style="font-size:12px !important; text-align:center !important;">{{ $v['group_ar'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody class="list">
        @php $i=0; $nlTotal=0; $nlRataKls=0; @endphp
        @foreach ($siswa as $k=>$v)
        <tr>
            <td>{{ ($i+1) }}</td>
            <td>{{ $v->nis }}</td>
            <td><a href="{{ url('siswa/'.$v->pid.'/edit') }}">{{ $v->name }}</a></td>
            <td class="arabic">{{ $v->name_ar }}</td>
            <td class="arabic">{{ $v->desc_ar }}/{{ $v->class_name_ar }}</td>
            <td>{{ $v->sex }}</td>
            @php
                $ayid           = config('id_active_academic_year');
                $tid            = config('id_active_term');
                $getipk         = \App\Models\Gpa::getIPK($v->sid,$ayid,$tid);
                $nlipk          = number_format($getipk['ipk']);
                $ipk            = \App\SmartSystem\General::hasil_kelulusan($nlipk);
                $final          = \App\Models\FinalGrade::select('note_from_student_affairs','activities_parent','result')
                                    ->where('format_code','0')
                                    ->where('ayid',$ayid)
                                    ->where('tid',$tid)
                                    ->where('sid',$v->sid)
                                    ->first();
                $finaldtl       = \App\Models\FinalGradeDtl::select(['ep_subject.id','formative_val','final_grade'])
                                    ->join('ep_subject','ep_subject.id','=','subject_id')
                                    ->where('format_code','0')
                                    ->where('ayid',$ayid)
                                    ->where('tid',$tid)
                                    ->where('sid',$v->sid)
                                    ->get();
                $getBayanatResultDtl = \App\Models\BayanatResultDtl::getResultDtl($v->pid,$ayid,$tid);
                $mustawa        = \App\Models\Student::mustawa($v->sid,$ayid,$tid);
                $rankinglevel   = key(collect(\App\Models\Gpa::getRankingLevel($v->level,$v->sex))->where('sid',$v->sid)->toArray())+1;
                $rankingkelas   = key(collect(\App\Models\Gpa::getRankingClass($v->class_id))->where('sid',$v->sid)->toArray())+1;
                $nilaiquranhalaqah = '-';
                $nilaiqurantingkat = '-';
                if(count($getBayanatResultDtl)>0)
                {
                    $nilaiqurantingkat = ($getBayanatResultDtl[0]['mm']!='')
                        ? (int)$getBayanatResultDtl[0]['juz_has_tasmik'] >= (int)$getBayanatResultDtl[0]['level']
                        : false;
                    $nilaiqurantingkat = (int)$getBayanatResultDtl[0]['juz_has_tasmik'] >= (int)$mustawa;
                    $nilaiquranhalaqah = ($getBayanatResultDtl[0]['level']!='')
                        ? (int)$getBayanatResultDtl[0]['juz_has_tasmik'] >= (int)$getBayanatResultDtl[0]['mm']
                        : false;

                    $nilaiqurantingkat = ($nilaiqurantingkat) ? 'تم' : 'لم يتم';
                    $nilaiquranhalaqah = ($nilaiquranhalaqah) ? 'تم' : 'لم يتم';
                }
                $no = 1; $j = 0;
                $jmlhtot = 0;
                $anilaitotal = [];
            @endphp
            @foreach ($finaldtl as $key => $val)
            @php
                $jml = 0;
                $jmlht = 0;
                $formative_val = ($val->formative_val!='') ? $val->formative_val : '0';
                $anilaitotal[$j]['id'] = $val->id;
                $anilaitotal[$j]['val'] = $val->final_grade;
                $jmlhtot += $jml;
                $no++; $j++;
            @endphp
            @endforeach
            @php
                $no=0;
                $mpGroup = collect($mudalfashl);
                $tmpgroup = array();
                $imp = 0;
                foreach($mpGroup as $kmpg=>$vmpg)
                {
                    $mp = collect($mf)->get($vmpg['id']);
                    $nilaimp = 0;
                    $tmpgroup[$imp]['id'] = $vmpg['id'];
                    $tmpgroup[$imp]['group'] = $vmpg['name_group'];
                    $tmpgroup[$imp]['group_ar'] = $vmpg['name_group_ar'];
                    foreach($mp as $kmp=>$vmp)
                    {
                        for($annn=0;$annn<count($anilaitotal);$annn++)
                        {
                            if($anilaitotal[$annn]['id']==$vmp['subject_id'])
                            {
                                $nilaimp += (float)$anilaitotal[$annn]['val'];
                            }
                        }
                    }
                    $tmpgroup[$imp]['val'] = $nilaimp;
                    $tmpgroup[$imp]['count'] = count($mp);
                    $tmpgroup[$imp]['total'] = $tmpgroup[$imp]['val']/$tmpgroup[$imp]['count'];
                    $imp++;
                }
            @endphp
            <td class="arabic text-center">{{ $ipk }}</td>
            @foreach($tmpgroup as $k=>$v)
                <td class="arabic text-center">{{ \App\SmartSystem\General::angka_arab(number_format($v['total'],0,',','')) }}</td>
            @php $no++; @endphp
            @endforeach
            <td class="arabic text-center">{{ $nilaiquranhalaqah }}</td>
            <td class="arabic text-center">{{ $nilaiqurantingkat }}</td>
            <td class="arabic text-center">{{ ($final->note_from_student_affairs!='') ? \App\SmartSystem\General::pilihan_ar($final->note_from_student_affairs) : '-' }}</td>
            <td class="arabic text-center">{{ ($final->activities_parent!='') ? \App\SmartSystem\General::pilihan_ar($final->activities_parent) : '-' }}</td>
            <td class="arabic text-center">{{ \App\SmartSystem\General::pilihan_ar($final->result) }}</td>
            <td class="arabic text-center">{{ \App\SmartSystem\General::angka_arab($rankinglevel) }}</td>
            <td class="arabic text-center">{{ \App\SmartSystem\General::angka_arab($rankingkelas) }}</td>
        </tr>
        @php $i++; @endphp
        @endforeach
    </tbody>
</table>
