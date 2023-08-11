<h5>Rekapitulasi</h5>

<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Nama</th>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Posisi</th>
            <th colspan="{{ $jmhrow }}" class="text-center" style="vertical-align:middle;">Komponen</th>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Total</th>
        </tr>
        <tr>
        @php
            for($jmhi=0;$jmhi<count($komponen);$jmhi++)
            {
                echo '<th class="text-center">'.$komponen[$jmhi]['name'].'</th>';
            }
        @endphp
        </tr>
    </thead>
    <tbody>
        @php
            $koleksi = collect($data);
        @endphp
        @foreach($data as $k=>$v)
        <tr>
            <td>{{ $v['nama'] }}</td>
            <td>{{ $v['position'] }}</td>
            @php
                $total = 0;
                for($h=0;$h<$jmhrow;$h++)
                {
                    $jam = floor($v['durasi'][$h]['durasi'] / 60);
                    $menit = floor($v['durasi'][$h]['durasi'] % 60);
                    echo '<td class="text-center">'.$v['durasi'][$h]['durasi'].'</td>';
                    $total += $v['durasi'][$h]['durasi'];
                }
                echo '<td class="text-center">'.$total.'</td>';
            @endphp
        </tr>
        @endforeach
    </tbody>
</table>
