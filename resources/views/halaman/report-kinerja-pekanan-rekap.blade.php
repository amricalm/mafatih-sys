<h5>Rekapitulasi</h5>

<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Nama</th>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Posisi</th>
            <th colspan="4" class="text-center">Pekan</th>
            <th rowspan="2" class="text-center">Total</th>
        </tr>
        <tr>
        @php
            for($i=0;$i<4;$i++)
            {
                echo '<th class="text-center">Pekan '.($i+1).'</th>';
            }
        @endphp
        </tr>
    </thead>
    <tbody>
        @php
            // $data = $data['data'];
        @endphp
        @foreach($data as $k=>$v)
        @php
            $jamtotal = floor($v['total'] / 60);
            $menittotal = floor($v['total'] % 60);
        @endphp
        <tr>
            <td>{{ $v['nama'] }}</td>
            <td>{{ $v['position'] }}</td>
            @php
                for($i=0;$i<4;$i++)
                {
                    $jam = floor($v['durasi'][$i] / 60);
                    $menit = floor($v['durasi'][$i] % 60);
                    $isi = ($v['durasi'][$i]=='') ? '0' : $v['durasi'][$i];
                    echo '<td class="text-center">'.$jam.':'.$menit.'</td>';
                }
            @endphp
            <td>{{ $jamtotal }}:{{ $menittotal }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
