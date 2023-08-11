<h5>Rekapitulasi</h5>

<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="3" class="text-center" style="vertical-align:middle;">Nama</th>
            <th rowspan="3" class="text-center" style="vertical-align:middle;">Posisi</th>
            <th colspan="{{ ($datas['days']['jumlah']*2) }}" class="text-center">Tanggal</th>
            <th rowspan="2" class="text-center">Total</th>
        </tr>
        <tr>
        @php
            for($i=0;$i<$datas['days']['jumlah'];$i++)
            {
                $dtglbefore = $datas['days']['detail'][$i];
                echo '<th class="text-center" colspan="2">'.$dtglbefore.'</th>';
            }
        @endphp
        </tr>
        <tr>
        @php
            for($i=0;$i<($datas['days']['jumlah']);$i++)
            {
                echo '<th class="text-center">A</th>';
                echo '<th class="text-center">M</th>';
            }
        @endphp
            <th class="text-center">A</th>
            <th class="text-center">M</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalperkomponen = array();
            $komponen = array();
            $komponen = App\Models\HrComponent::whereIn('id',$datas['component_id'])->get();
        @endphp
        @for($k=0;$k<count($alldata);$k++)
            @php
                $jamtotal = floor($alldata[$k]['total']['auto'] / 60);
                $menittotal = floor($alldata[$k]['total']['auto'] % 60);
                $manualtotal = $alldata[$k]['total']['manual'];
            @endphp
            <tr>
                <td>{{ $alldata[$k]['name'] }}</td>
                <td>{{ $alldata[$k]['position'] }}</td>
                @for ($l=0;$l<count($alldata[$k]['durasi']);$l++)
                <td class="text-center">
                    @php
                        $hours = floor($alldata[$k]['durasi'][$l]['auto'] / 60);
                        $minutes = floor($alldata[$k]['durasi'][$l]['auto'] % 60);
                    @endphp
                    {{ (is_null($alldata[$k]['durasi'][$l]['auto'])) ? '0:0' : $hours.':'.$minutes }}</td>
                <td class="text-center">{{ $alldata[$k]['durasi'][$l]['manual'] }}</td>
                    {{-- {!! (is_null($alldata[$k]['durasi'][$l]['manual'])) ? '<br> 0 jam' : '<br>'.$alldata[$k]['durasi'][$l]['manual'].' jam' !!} --}}
                @endfor
                <td class="text-center">
                    {{ $jamtotal }}:{{ $menittotal }}
                </td>
                <td class="text-center">
                    {{ $manualtotal }}
                </td>
            </tr>
        @endfor
        @php
            // echo '<pre>';
            // print_r($totalperkomponen);
        @endphp
    </tbody>
</table>
