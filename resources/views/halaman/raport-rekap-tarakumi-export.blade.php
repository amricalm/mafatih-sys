@extends('layouts.pdf-template')
@section('header')
@endsection
@section('isi')
<h3>Rekap Nilai Tarakumi {{ $namakelas }}</h3>
<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Lengkap</th>
            <th>Nama Dalam Arabic</th>
            @for($i=0;$i<6;$i++) <th>
                Semester
                @php
                $j=$i+1;
                echo $j;
                @endphp
                </th>
                @endfor
                {{-- <th>Total Nilai</th>
                <th>Rata-rata</th> --}}
        </tr>
    </thead>
    <tbody class="list">
        @if ($req->pilihkelas!='')
        @php
        $i = 0;
        @endphp
        @foreach ($murid as $k=>$v)
        <tr>
            <td>{{ ($i+1) }}</td>
            <td>{{ $v->nis }}</td>
            <td>{{ $v->name }}</td>
            <td class="arabic">{{ $v->name_ar }}</td>
            @php $totalgpa = 0; $jmh = 0; @endphp
            @for($j=0;$j<6;$j++) @php $data=array(); foreach($ipk as $keyitem=>$valitem)
                {
                if($valitem['sid']==$v->sid)
                {
                $datas = $valitem['detail'];
                $data = isset($datas[$j]) ? $datas[$j] : array('gpa'=>'0');
                $jmh = isset($datas[$j]) ? $jmh+1 : $jmh;
                }
                }
                $totalgpa += $data['gpa'];
                @endphp
                <td style="text-align:right;">{{ (isset($datas[$j])) ? number_format(($totalgpa/$jmh),2,',','.') : '0' }} </td>
                @endfor
                {{-- <td style="text-align:right;">{{ sprintf('%0.2f',round($totalgpa,2)) }}</td> --}}
                {{-- <td style="text-align:right;">{{ ($jmh!=0) ? sprintf('%0.2f',round($totalgpa/$jmh,2)) : '0' }}</td> --}}
        </tr>
        @php
        $i++;
        @endphp
        @endforeach
        @endif
    </tbody>
</table>
@endsection
