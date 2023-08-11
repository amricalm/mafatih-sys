<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th colspan="3" class="text-left">REKAP NILAI PENGASUHAN TA {{ $thajar->name }} {{ $term->desc }}</th>
        </tr>
        <tr>
            <th class="text-left">MS :</th>
            <th colspan="2" class="text-left">{{ $ms->name }}</th>
        </tr>
    </thead>
</table>
<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Nama Dalam Arabic</th>
            <th>Kelas</th>
            @foreach ($finalboardingdtl as $rows)
            @foreach ($rows['nilai'] as $nilai)
                <th class="text-center">{{ $nilai['name_ar'] }}</th>
            @endforeach
            @break
            @endforeach
            <th class="text-left">Komentar MS</th>
        </tr>
    </thead>
    <tbody class="list">
        @php $i=0; @endphp
        @foreach ($finalboardingdtl as $rows)
        <tr>
            <td class="text-center">{{ ($i+1) }}</td>
            <td class="text-center">{{ \App\SmartSystem\General::angka_arab($rows['nis']) }}</td>
            <td>{{ $rows['name'] }}</td>
            <td class="text-right">{{ $rows['name_ar'] }}</td>
            <td class="text-right">{{ $rows['class'] }}</td>
            @php $note = "";  @endphp
            @foreach ($rows['nilai'] as $nilai)
                @if ($nilai['type']=='ITEM')
                    <td class="text-center">{{ $nilai['letter_grade'] }}</td>
                @else
                    <td class="text-center">{{ number_format($nilai['final_grade']) }}</td>
                @endif
                @php $note = $nilai['note'];  @endphp
            @endforeach
            <td class="text-left">{{ $note }}</td>
        </tr>
        @php $i++; @endphp
        @endforeach
    </tbody>
</table>
