<table class="table data-table table-striped" id="tabeeel">
    <thead>
        <tr>
            <th>TINGKAT</th>
            <th>KODE MATA PELAJARAN</th>
            <th>KOMPETENSI INTI (1/2/3/4)</th>
            <th>KOMPETENSI DASAR</th>
            <th>SUB KOMPETENSI DASAR</th>
            <th>DESKRIPSI KOMPETENSI DASAR</th>
        </tr>
    </thead>
    <tbody>
            @foreach ($alldata as $k => $v)
            <tr>
                <td>{{ $v['level'] }}</td>
                <td>{{ $v['subject_diknas_id'] }}</td>
                <td>{{ $v['core_competence'] }}</td>
                <td>{{ $v['basic_competence'] }}</td>
                <td>{{ $v['sub_basic_competence'] }}</td>
                <td>{{ $v['desc'] }}</td>
            </tr>
            @endforeach

    </tbody>
</table>

