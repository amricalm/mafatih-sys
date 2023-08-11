<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Lengkap</th>
            <th>Nama Dalam Arabic</th>
            <th>Kelas</th>
            <th>L/P</th>
            @php $no=0; @endphp
            @foreach ($mapel as $v=>$k )
                <th style="text-align:right;">{{ $k->name }}</th>
                @php $no++; @endphp
            @endforeach
            <th>Total Nilai</th>
            <th>Rata-rata</th>
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
            $tampil = 0;
            $total = 0;
            $totaldurasi = 0;
            $jmhMapel = 0;
            $test = $nilai->where('sid',$v->sid);
            @endphp
            @foreach($mapel as $a=>$b)
                @php
                    $tampil = 0; $durasi = 0;
                    foreach($test as $t=>$u)
                    {
                        if($u->subject_id == $b->subject_id)
                        {
                            $tampil = $u->final_exam;
                            $total += $tampil;
                            break;
                        }
                    }
                $jmhMapel++;
                @endphp
            <td style="text-align:right;">{{ number_format($tampil,0,',','.') }}</td>
            @endforeach
            @php
                $nlRata = ($total!=0 && $jmhMapel!=0) ? round($total/$jmhMapel) : 0;
                $nlTotal += $total;
                $nlRataKls += $nlRata;
            @endphp
            <td style="text-align:right;">{{ number_format($total,0,',','.') }}</td>
            <td style="text-align: right;">{{ $nlRata }}</td>
        </tr>
        @php $i++; @endphp
        @endforeach
        @if ($i!=0)
        <tr>
            <th colspan="6"><b>RATA-RATA PER MATA PELAJARAN</b></th>
            @foreach($mapel as $a=>$b)
                @php
                    $nlRtMp = array();
                    $getnlMp = $nilai->where('subject_id', $b->subject_id);
                    foreach ($getnlMp as $k => $v) {
                        $nlRtMp[] = $v->final_exam;
                    }
                @endphp
                <th style="text-align:right;">{{ round(array_sum($nlRtMp)/$i) }}</th>
            @endforeach
            @php
                $nlRtTotal = ($nlTotal!=0 && $i!=0) ? round($nlTotal/$i) : 0;
                $nlRata = ($nlRataKls!=0 && $i!=0) ? round($nlRataKls/$i) : 0;
            @endphp
            <th style="text-align:right;">{{ $nlRtTotal }}</th>
            <th style="text-align: right;">{{ $nlRata }}</th>
        </tr>
        @endif
    </tbody>
</table>
