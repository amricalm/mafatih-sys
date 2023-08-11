<h5>Rekapitulasi</h5>

<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Nama</th>
            <th rowspan="2" class="text-center" style="vertical-align:middle;">Posisi</th>
            <th colspan="{{ ($datas['days']['jumlah']*2) }}" class="text-center">Tanggal</th>
            <th rowspan="2" class="text-center">Total</th>
        </tr>
        <tr>
        @php
            $jmhrow = count($datas['component_id']);
            for($i=0;$i<$datas['days']['jumlah'];$i++)
            {
                $dtglbefore = $datas['days']['detail'][$i];
                echo '<th class="text-center" colspan="2">'.$dtglbefore.'</th>';
            }
        @endphp
        </tr>
    </thead>
    <tbody>
        @php
            $totalperkomponen = array();
            $komponen = array();
            $komponen = App\Models\HrComponent::whereIn('id',$datas['component_id'])->get();
            $semuadata = array(); $baris = 0;
            for($k=0;$k<count($alldata);$k++)
            {
                for($m=0;$m<count($datas['component_id']);$m++)
                {
                    $semuadata[$baris]['nama_pegawai'] = $alldata[$k]['name'];
                    $semuadata[$baris]['position'] = $alldata[$k]['position'];
                    $totalkomponen = 0;
                    for($l=0;$l<count($alldata[$k]['durasi']);$l++)
                    {
                        $semuadata[$baris]['nama_komponen'.$l] = $alldata[$k]['durasi'][$l][$m]['name'];
                        $semuadata[$baris]['durasi_komponen'.$l] = $alldata[$k]['durasi'][$l][$m]['durasi'];
                        $totalkomponen += $alldata[$k]['durasi'][$l][$m]['durasi'];
                    }
                    $semuadata[$baris]['total'] = $totalkomponen;
                    $baris++;
                }
            }
        @endphp
        @php
            $namanya = '';
            for($i=0;$i<count($semuadata);$i++)
            {
                echo '<tr>';
                if($namanya!=$semuadata[$i]['nama_pegawai'])
                {
                    echo '<td rowspan="'.$jmhrow.'">'.htmlentities($semuadata[$i]['nama_pegawai']).'</td>';
                    echo '<td rowspan="'.$jmhrow.'">'.htmlentities($semuadata[$i]['position']).'</td>';
                    $namanya = $semuadata[$i]['nama_pegawai'];
                }
                for($j=0;$j<$datas['days']['jumlah'];$j++)
                {
                    echo '<td>'.htmlentities($semuadata[$i]['nama_komponen'.$j]).'</td>';
                    echo '<td>'.$semuadata[$i]['durasi_komponen'.$j].'</td>';
                }
                echo '<td>'.$semuadata[$i]['total'].'</td>';
                echo '</tr>';
            }
        @endphp
    </tbody>
</table>
