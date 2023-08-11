@extends('layouts.pdf-template')
@section('header')
@endsection
@section('isi')
<h3>Rekap Rangking Level {{ $req->pilihlevel }} {{ config('active_academic_year') }} {{ config('active_term') }}</h3>
<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nama Lengkap</th>
            <th>Nama Dalam Arabic</th>
            <th>Kelas</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody class="list">
        @if ($req->pilihlevel!='' && $req->pilihlevel!='0')
        @php
            $i = 0;
        @endphp
        @foreach ($ipk as $k=>$v)
        @php
            $data = $murid->where('sid',$v['sid'])->toArray();
            $data = reset($data);
        @endphp
        <tr>
            <td>{{ ($i+1) }}</td>
            <td>{{ $data['nis'] }}</td>
            <td>{{ $data['name'] }}</td>
            <td class="arabic">{{ $data['name_ar'] }}</td>
            <td class="arabic">{{ $data['classname'] }}</td>
            <td>{{ number_format($v['ipk'],2,',','.') }}</td>
        </tr>
        @php
            $i++;
        @endphp
        @endforeach
        @endif
    </tbody>
</table>
@endsection
