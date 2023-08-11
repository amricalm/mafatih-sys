<table class="table data-table table-striped">
    <thead>
        @if (config('id_active_term')==2)
            <tr>
                <th rowspan="2">ID</th>
                <th rowspan="2">AYID</th>
                <th rowspan="2">TID</th>
                <th rowspan="2">EID</th>
                <th rowspan="2">NIS</th>
                <th rowspan="2">NAMA</th>
                <th>CATATAN AKADEMIK</th>
                <th rowspan="2">CATATAN PENGASUHAN</th>
            </tr>
            <tr>
                <th>Memenuhi Syarat / Tidak Memenuhi Syarat</th>
            </tr>
        @else
            <tr>
                <th>ID</th>
                <th>AYID</th>
                <th>TID</th>
                <th>EID</th>
                <th>NIS</th>
                <th>NAMA</th>
                <th>CATATAN PENGASUHAN</th>
        @endif
    </thead>
    <tbody>
        @for($k=0;$k<count($alldata);$k++)
                <tr>
                    <td>{{ $alldata[$k]->id }}</td>
                    <td>{{ config('id_active_academic_year') }}</td>
                    <td>{{ config('id_active_term') }}</td>
                    <td>{{ $alldata[$k]->eid }}</td>
                    <td>{{ $alldata[$k]->nis }}</td>
                    <td>{{ $alldata[$k]->name_ar }}</td>
                </tr>
        @endfor
    </tbody>
</table>
