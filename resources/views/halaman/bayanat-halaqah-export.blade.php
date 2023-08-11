<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2">ID</th>
            <th rowspan="2">NIS</th>
            <th rowspan="2">NAMA</th>
            @php
                foreach($bobot as $k=>$v):
                    echo '<th>'.$v->name.'</th>';
                endforeach;
            @endphp
            <th rowspan="2">CATATAN</th>
            <th rowspan="2">JUZ YANG SEMPURNA</th>
        </tr>
        <tr>
            @php
                foreach($bobot as $k=>$v):
                    echo '<th>'.$v->id.'</th>';
                endforeach;
            @endphp
        </tr>
    </thead>
    <tbody>
        @for($k=0;$k<count($alldata);$k++)
            <tr>
                <td>{{ $alldata[$k]->id }}</td>
                <td>{{ $alldata[$k]->nis }}</td>
                <td>{{ $alldata[$k]->name }}</td>
                @php
                    foreach($bobot as $kv=>$vv):
                        echo '<td></td>';
                    endforeach;
                @endphp
                <td></td>
            </tr>
        @endfor
    </tbody>
</table>
