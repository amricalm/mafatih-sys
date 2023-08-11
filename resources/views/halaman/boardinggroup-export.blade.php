<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2">ID</th>
            <th rowspan="2">PERIODE</th>
            <th rowspan="2">AYID</th>
            <th rowspan="2">TID</th>
            <th rowspan="2">NIS</th>
            <th rowspan="2">NAMA</th>
            <th rowspan="2">ACT</th>
            @foreach($boardingItem as $k=>$v)
                <th align="center">{{ $v['id'] }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach($boardingItem as $k=>$v)
                <th>{{ $v['name'] }} ({{ $v['score_total'] }})</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @for($i=0;$i<count($alldata);$i++)
            @for ($j=1;$j<=2;$j++)
                <tr>
                    <td>{{ $alldata[$i]->id }}</td>
                    <td>{{ $periode }}</td>
                    <td>{{ config('id_active_academic_year') }}</td>
                    <td>{{ config('id_active_term') }}</td>
                    @if ($j==1)
                        <td rowspan="2" valign="middle">{{ $alldata[$i]->nis }}</td>
                        <td rowspan="2" valign="middle">{{ $alldata[$i]->name_ar }}</td>
                        <td>HDR</td>
                    @else
                        <td>RSH</td>
                    @endif
                </tr>
            @endfor
        @endfor
    </tbody>
</table>
