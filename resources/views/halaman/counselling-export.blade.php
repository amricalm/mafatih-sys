<table class="table data-table table-striped">
    <thead>
        <tr>
            <th>NO</th>
            <th>TANGGAL</th>
            <th>NIS</th>
            <th>NAMA LENGKAP</th>
            <th>PRESTASI</th>
            <th>DESKRIPSI</th>
        </tr>
    </thead>
    <tbody>
        @for($k=0;$k<count($alldata);$k++)
            <tr>
                <td>{{ $k + 1 }}</td>
                <td>{!! \App\SmartSystem\General::convertDate($alldata[$k]->date) !!}</td>
                <td>{{ $alldata[$k]->nis }}</td>
                <td>{{ $alldata[$k]->santri }}</td>
                <td>{{ $alldata[$k]->name }}</td>
                <td>{{ $alldata[$k]->desc }}</td>
            </tr>
        @endfor
    </tbody>
</table>
