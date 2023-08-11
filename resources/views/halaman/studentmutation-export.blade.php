<table class="table data-table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>NAMA</th>
            <th>NIS</th>
            <th>NOMOR INDUK SISWA NASIONAL (NISN)</th>
            <th>NAMA PANGGILAN</th>
            <th>NAMA ARAB</th>
            <th>NOMOR INDUK KEPENDUDUKAN (NIK)</th>
            <th>NOMOR KARTU KELUARGA (KK)</th>
            <th>NOMOR REGISTRASI AKTA LAHIR</th>
            <th>JENIS KELAMIN</th>
            <th>TEMPAT LAHIR</th>
            <th>TANGGAL LAHIR</th>
            <th>ANAK KE</th>
            <th>JUMLAH SAUDARA KANDUNG</th>
            <th>JUMLAH SAUDARA TIRI</th>
            <th>JUMLAH SAUDARA ANGKAT</th>
            <th>KEWARGANEGARAAN</th>
            <th>AGAMA</th>
            <th>BAHASA SEHARI-HARI</th>
            <th>TINGGI BADAN</th>
            <th>BERAT BADAN</th>
            <th>GOLONGAN DARAH</th>
            <th>HP</th>
            <th>EMAIL</th>
        </tr>
    </thead>
    <tbody>
        @for($k=0;$k<count($alldata);$k++)
            <tr>
                <td>{{ $k + 1 }}</td>
                <td>{{ $alldata[$k]->name }}</td>
                <td>{{ $alldata[$k]->nis }}</td>
                <td>{{ $alldata[$k]->nisn }}</td>
                <td>{{ $alldata[$k]->nickname }}</td>
                <td>{{ $alldata[$k]->name_ar }}</td>
                <td>{{ $alldata[$k]->nik }}</td>
                <td>{{ $alldata[$k]->kk }}</td>
                <td>{{ $alldata[$k]->aktalahir }}</td>
                <td>{{ $alldata[$k]->sex }}</td>
                <td>{{ $alldata[$k]->pob }}</td>
                <td>{{ $alldata[$k]->dob }}</td>
                <td>{{ $alldata[$k]->son_order }}</td>
                <td>{{ $alldata[$k]->siblings }}</td>
                <td>{{ $alldata[$k]->stepbros }}</td>
                <td>{{ $alldata[$k]->adoptives }}</td>
                <td>{{ $alldata[$k]->citizen }}</td>
                <td>{{ $alldata[$k]->religion }}</td>
                <td>{{ $alldata[$k]->languages }}</td>
                <td>{{ $alldata[$k]->height }}</td>
                <td>{{ $alldata[$k]->weight }}</td>
                <td>{{ $alldata[$k]->blood }}</td>
                <td>{{ $alldata[$k]->hp }}</td>
                <td>{{ $alldata[$k]->email }}</td>
            </tr>
        @endfor
    </tbody>
</table>
