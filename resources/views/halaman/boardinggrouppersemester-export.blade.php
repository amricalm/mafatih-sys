<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2">ID</th>
            <th rowspan="2">AYID</th>
            <th rowspan="2">TID</th>
            <th rowspan="2">NIS</th>
            <th rowspan="2">NAMA</th>
            @php
                $getId = \App\Models\BoardingActivity::select('id')->where('type',"ITEM")->orderBy('seq')->get();
                foreach($getId as $k=>$v):
                    echo '<th align="center">'.$v->id.'</th>';
                endforeach;
            @endphp
        </tr>
        <tr>
            @php
                $getName = \App\Models\BoardingActivity::select('name_ar')->where('type',"ITEM")->orderBy('seq')->get();
                foreach($getName as $k=>$v):
                    echo '<th>'.$v->name_ar.'</th>';
                endforeach;
            @endphp
        </tr>
    </thead>
    <tbody>
        @for($k=0;$k<count($alldata);$k++)
                <tr>
                    <td>{{ $alldata[$k]->id }}</td>
                    <td>{{ config('id_active_academic_year') }}</td>
                    <td>{{ config('id_active_term') }}</td>
                    <td>{{ $alldata[$k]->nis }}</td>
                    <td>{{ $alldata[$k]->name_ar }}</td>
                </tr>
        @endfor
    </tbody>
</table>
