<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2">ID</th>
            <th rowspan="2">NIS</th>
            <th rowspan="2">NAMA</th>
            <th rowspan="2">TANGGAL</th>
            <th>KATEGORI PELANGGARAN</th>
            <th>PELANGGARAN</th>
            <th>TINDAKAN</th>
        </tr>
        <tr>
            <th>ISI DENGAN 1/2/3/4</th>
        </tr>
    </thead>
    <tbody>
        @for($k=0;$k<count($alldata);$k++)
                <tr>
                    <td>{{ $alldata[$k]->id }}</td>
                    <td>{{ $alldata[$k]->nis }}</td>
                    <td>{{ $alldata[$k]->name }}</td>
                </tr>
        @endfor
    </tbody>
</table>
