<table class="table data-table table-striped">
    <thead>
        <tr>
            <th>NO</th>
            <th>TANGGAL</th>
            <th>NIS</th>
            <th>NAMA LENGKAP</th>
            <th>KATEGORI PELANGGARAN</th>
            <th>PELANGGARAN</th>
            <th>TINDAKAN</th>
        </tr>
    </thead>
    <tbody>
        @php
            $level = ['1'=>'Ringan','2'=>'Sedang','3'=>'Berat Bertahap','4'=>'Berat Tidak Bertahap'];
            $levelName = '';
        @endphp
        @for($k=0;$k<count($alldata);$k++)
        @foreach ($level as $klevel=>$vlevel)
            @php
                if ($alldata[$k]->level == $klevel) {
                    $levelName = $vlevel;
                }
            @endphp
        @endforeach
            <tr>
                <td>{{ $k + 1 }}</td>
                <td>{!! \App\SmartSystem\General::convertDate($alldata[$k]->date) !!}</td>
                <td>{{ $alldata[$k]->nis }}</td>
                <td>{{ $alldata[$k]->santri }}</td>
                <td>{{ $levelName }}</td>
                <td>{{ $alldata[$k]->name }}</td>
                <td>{{ $alldata[$k]->desc }}</td>
            </tr>
        @endfor
    </tbody>
</table>
