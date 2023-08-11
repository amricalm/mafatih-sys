<table class="table data-table table-striped">
    <thead>
        <tr>
            <th rowspan="2">ID</th>
            <th rowspan="2">NIS</th>
            <th rowspan="2">NAMA</th>
            <th colspan="3">Absen (Nilai Angka)</th>
            <th colspan="3">Prilaku (Nilai Huruf : A - E)</th>
            <th>Lainnya (isi nilai seperti dibawah)</th>
            <th>Catatan Wali Kelas</th>
            <th>Lainnya (isi nilai seperti dibawah)</th>
        </tr>
        <tr>
            <th>Absen</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Kebersihan</th>
            <th>Kedisiplinan</th>
            <th>Prilaku</th>
            {{-- <th>Menghafal Al-Quran (Sempurna/Tidak Sempurna)</th> --}}
            <th>Kegiatan Wali (Aktif/Tidak Aktif)</th>
            <th>DI Raport DIKNAS</th>
            <th>Hasil Akhir (Lulus/Lulus dengan Syarat/Gagal)</th>
        </tr>
    </thead>
    <tbody>
        @for($k=0;$k<count($alldata);$k++)
            <tr>
                <td>{{ $alldata[$k]->id }}</td>
                <td>{{ $alldata[$k]->nis }}</td>
                <td>{{ $alldata[$k]->name }}</td>
                @php
                    if(count($isi)>0)
                    {
                        $isione = collect($isi)->where('sid',$alldata[$k]->id)->toArray();
                        $isitwo = collect($isidiknas)->where('sid',$alldata[$k]->id)->toArray();
                        $isione = reset($isione);
                        $isitwo = reset($isitwo);
                        echo '<td>'.$isione['absent_a'].'</td>';
                        echo '<td>'.$isione['absent_i'].'</td>';
                        echo '<td>'.$isione['absent_s'].'</td>';
                        echo '<td>'.$isione['cleanliness'].'</td>';
                        echo '<td>'.$isione['discipline'].'</td>';
                        echo '<td>'.$isione['behaviour'].'</td>';
                        echo '<td>'.$isione['activities_parent'].'</td>';
                        echo '<td>'.$isitwo['note_from_student_affairs'].'</td>';
                        echo '<td>'.$isione['result'].'</td>';
                    }
                @endphp
            </tr>
        @endfor
    </tbody>
</table>
