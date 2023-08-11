
<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nomor Induk</th>
            <th rowspan="2">Nama Lengkap</th>
            <th rowspan="2">Nama Dalam Arabic</th>
            <th rowspan="2">Kelas</th>
            <th rowspan="2">L/P</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">مشرف الحلقة</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">الحلقة</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">الجرء الذي تم تسميعه</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">الجزء المقرر</th>
            <th colspan="4" class="arabic" style="font-size:12px !important; text-align:center !important;"> مقرر القرآن</th>
            @php $no=0; @endphp
            @foreach ($weight as $v=>$k)
                <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">{{ $k->name_ar }}</th>
                @php $no++; @endphp
            @endforeach
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">مجموعة النتيجة</th>
            <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">ملاحظة المشرف</th>
        </tr>
        <tr>
            <th class="arabic" style="font-size:12px !important; text-align:center !important;">(نتيجة مقرر الحلقة)</th>
            <th class="arabic" style="font-size:12px !important; text-align:center !important;">(التقدير)</th>
            <th colspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">(مقرر المستوى)</th>
        </tr>
    </thead>
    <tbody class="list">
        @php $i=0; $nlTotal=0; $nlRataKls=0; @endphp
        @foreach ($siswa as $k=>$v)
        <tr>
            <td>{{ ($i+1) }}</td>
            <td>{{ $v->nis }}</td>
            <td>{{ $v->name }}</td>
            <td class="arabic">{{ $v->name_ar }}</td>
            <td class="arabic">{{ $v->desc_ar }}/{{ $v->class_name_ar }}</td>
            <td>{{ $v->sex }}</td>
            @php
                $app['result'] = \App\Models\BayanatResultDtl::getResultDtl($v->pid,config('id_active_academic_year'),config('id_active_term'));
                $halaqahnamear = (count($app['result'])>0) ? $app['result'][0]['name_ar'] : '-';
                $teachernamear = (count($app['result'])>0) ? $app['result'][0]['teachernamear'] : '-';
                $teachersex = (count($app['result'])>0) ? $app['result'][0]['teachersex'] : '-';
                $juz_has_tasmik = (count($app['result'])>0) ? $app['result'][0]['juz_has_tasmik'] : '';
                $juz_is_study = (count($app['result'])>0) ? $app['result'][0]['juz_is_study'] : '-';
                $result_decision_set = (count($app['result'])>0) ? $app['result'][0]['result_decision_set'] : '-';
                $result_set = (count($app['result'])>0) ? $app['result'][0]['result_set'] : '';
                $result_appreciation = (count($app['result'])>0) ? $app['result'][0]['result_appreciation'] : '-';
                $result_notes = (count($app['result'])>0) ? $app['result'][0]['result_notes'] : '-';
                $mustawa = \App\Models\Student::mustawa($v->sid,config('id_active_academic_year'),config('id_active_term'));
                $app['muqorrormustawa'] = \App\Models\BayanatLevel::where('level',$mustawa)->first();
                $juz_tasmik = '0'; $hasil = ''; $app['result_decision_level'] = 'Tidak Sempurna';
                if($juz_has_tasmik!='')
                {
                    $juz_tasmik = !empty($juz_has_tasmik) ? (int)$juz_has_tasmik : 0;
                    $juz_tasmik = (is_numeric($juz_tasmik)) ? $juz_tasmik : '0';
                }
                $nilaiqurantingkat = '-';
                if(count($app['result'])>0)
                {
                    $nilaiqurantingkat = ($app['result'][0]['mm']!='')
                        ? (int)$app['result'][0]['juz_has_tasmik'] >= (int)$app['result'][0]['level']
                        : false;
                    $nilaiqurantingkat = (int)$app['result'][0]['juz_has_tasmik'] >= (int)$mustawa;
                    $nilaiquranhalaqah = ($app['result'][0]['level']!='')
                        ? (int)$app['result'][0]['juz_has_tasmik'] >= (int)$app['result'][0]['mm']
                        : false;

                    $nilaiqurantingkat = ($nilaiqurantingkat) ? 'تم' : 'لم يتم';
                }
                $app['nilaiqurantingkat'] = (count($app['result'])>0) ? collect($app['result'])->first()['result_decision_level'] : '-';
                $nilaiquranhalaqah = (count($app['result'])>0) ? collect($app['result'])->first()['result_decision_set'] : '-';
                $app['nilaiquranhalaqah'] = '-';
                if($nilaiquranhalaqah!='-')
                {
                    $app['nilaiquranhalaqah'] = ($nilaiquranhalaqah=='ناجح') ? 'تم' : 'لم يتم';
                }

            @endphp
            <td class="arabic text-center">{{ \App\SmartSystem\General::ustadz($teachersex).' '.$teachernamear }}</td>
            <td class="arabic text-center">{{ str_replace('(بنات)','',str_replace('(بنين)','',$halaqahnamear)) }}</td>
            <td class="arabic text-center">{{ Lang::get('juz_has_tasmik.'.$juz_tasmik,[],'ar') }}</td>
            <td class="arabic text-center">{{ $juz_is_study }}</td>
            <td class="arabic text-center">{{ $result_decision_set }}</td>
            <td class="arabic text-center">{{ $result_appreciation }}</td>
            <td class="arabic text-center">{{ Lang::get('juz_has_tasmik.'.$mustawa,[],'ar') }}</td>
            <td class="arabic text-center">{{ $nilaiqurantingkat }}</td>
            @foreach($weight as $v=>$k)
                <td class="arabic text-center">{{ (count($app['result'])>0) ? \App\SmartSystem\General::angka_arab(number_format($app['result'][$v]['result_evaluation'])) : '-';}}</td>
            @endforeach
            <td class="arabic text-center">{{ ($result_set!='') ? \App\SmartSystem\General::angka_arab(number_format($result_set,2,'.',',')) : '-' }}</td>
            <td>{{ $result_notes }}</td>
        </tr>
        @php $i++; @endphp
        @endforeach
    </tbody>
</table>
