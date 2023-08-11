@extends('layouts.pdf-template')
@section('header')
@endsection
@section('isi')
<h3>REKAP NILAI RAPORT PESERTA DIDIK KELAS {{ strtoupper($namakelas) }}</h3>
<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA</th>
            <th rowspan="2">NIS</th>
            <th rowspan="2">L/P</th>
            <th rowspan="2">NISN</th>
            @php $ket = ['3'=>'PENG','4'=>'KET']; @endphp
            @foreach($mapel as $kmapel=>$vmapel)
                <th colspan="{{ count($ket) }}"> {{ $vmapel->short_name }}</th>
            @endforeach
        </tr>
        <tr class="text-center">
            @foreach($mapel as $k=>$v)
                @foreach ($ket as $kket=>$vket)
                    <th>{{ $vket }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody class="list">
        @if ($req->pilihkelas!='')
        @php
        $i = 1;
        @endphp
        @foreach ($murid as $k=>$v)
        <tr>
            <td align="center">{{ $i }}</td>
            <td>{{ $v->name }}</td>
            <td align="center">{{ $v->nis }}</td>
            <td align="center">{{ $v->sex }}</td>
            <td align="center">{{ $v->nisn }}</td>
            @for($j=0;$j<count($mapel);$j++)
            @php
                $kgn = array();
                foreach($nilaipengetahuan as $keykgn=>$valkgn)
                {
                    if($valkgn['sid']==$v->sid)
                    {
                        $dataskgn = $valkgn['detail'];
                        $kgn = isset($dataskgn[$j]) ? $dataskgn[$j] : array('0'=>'0');
                    }
                }

                $psk = array();
                foreach($nilaiketerampilan as $keypsk=>$valpsk)
                {
                    if($valpsk['sid']==$v->sid)
                    {
                        $dataspsk = $valpsk['detail'];
                        $psk = isset($dataspsk[$j]) ? $dataspsk[$j] : array('0'=>'0');
                    }
                }
            @endphp
            <td style="text-align:center;">{{ (isset($dataskgn[$j])) ? round($kgn['final_grade']) : '0' }}</td>
            <td style="text-align:center;">{{ (isset($dataspsk[$j])) ? round($psk['final_grade']) : '0' }}</td>
            @endfor
        </tr>
        @php
        $i++;
        @endphp
        @endforeach
        @endif
    </tbody>
</table>
@endsection
