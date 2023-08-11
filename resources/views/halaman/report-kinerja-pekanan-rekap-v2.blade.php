<h5>Rekapitulasi</h5>

<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Nama</th>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Komponen</th>
            <th colspan="4" class="text-center">Pekan</th>
            <th rowspan="2" class="text-center">Total</th>
        </tr>
        <tr>
        @php
            for($i=0;$i<4;$i++)
            {
                echo '<th class="text-center">'.($i+1).'</th>';
            }
        @endphp
        </tr>
    </thead>
    <tbody>
        @php
            $koleksi = collect($data);
        @endphp
        @foreach($data as $k=>$v)
        @php
            // $jamtotal = floor($v['total'] / 60);
            // $menittotal = floor($v['total'] % 60);
        @endphp
        <tr>
            <td rowspan="{{ $jmhrow }}">{{ $v['nama'] }}</td>
            @php
                for($h=0;$h<$jmhrow;$h++)
                {
                    $total = 0;
                    echo ($h>0) ? '</tr><tr>' : '';
                    echo '<td>'.$v['durasi'][$h][0]['name'].'</td>';
                    for($i=0;$i<4;$i++)
                    {
                        $jam = floor($v['durasi'][$h][$i]['durasi'] / 60);
                        $menit = floor($v['durasi'][$h][$i]['durasi'] % 60);
                        echo '<td class="text-center">'.$v['durasi'][$h][$i]['durasi'].'</td>';
                        $total += $v['durasi'][$h][$i]['durasi'];
                    }
                    echo '<td class="text-center">'.$total.'</td>';
                }
            @endphp
        </tr>
        @endforeach
    </tbody>
</table>
