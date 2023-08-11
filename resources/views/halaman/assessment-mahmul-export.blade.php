@extends('layouts.pdf-template')
@section('header')
@endsection
@section('isi')
<h3>Rekap Mahmul {{ $namakelas }}</h3>
<table class="table table-striped align-items-center datatables">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th style="width:30%">Nama Siswa</th>
            <th>Kelas</th>
            <th>Level</th>
            <th>Periode</th>
            <th>Mata Pelajaran</th>
            <th>Nilai</th>
            <th>Nilai Terbaru</th>
            <th>Lulus/Tidak</th>
        </tr>
    </thead>
    <tbody class="list">
        @php
        $no = 1;
        @endphp
        @foreach ($siswa as $k=>$v)
            @foreach($student as $ks=>$vs)
                @if ($v['id'] == $ks)
                @php
                    $mahmuls = collect($mahmul)->where('sid',$v['id']);
                    $jmhmahmuls = (count($mahmuls)>1) ? 'rowspan="'.count($mahmuls).'"' : '';
                @endphp
                <tr>
                    <td {!! $jmhmahmuls !!}>{{ $no }}</td>
                    <td {!! $jmhmahmuls !!}>{{ $v['name'] }} </td>
                    <td {!! $jmhmahmuls !!}>{{ $v['class_name'] }}</td>
                    <td {!! $jmhmahmuls !!}>{{ $v['desc_ar'] }}</td>
                    <td>
                        @php $jmh=0; @endphp
                        @foreach ($mahmuls as $km=>$vm)
                            {{ substr($vm['nameay'],0,4).'/'.substr($vm['nameay'],4,strlen($vm['nameay'])) }} - {{ $vm['tid'] }}
                            </td><td>
                            {{ $vm['pelajaran'] }}
                            </td><td>
                            {{ $vm['grade_before'] }}
                            </td><td>
                            {{ $vm['grade_after'] }}
                            </td><td>
                            {{ ($vm['is_passed']=='1') ? 'LULUS' : 'BELUM LULUS' }}
                            {!! ($jmh!=((int)$jmhmahmuls-1)) ? '</td><tr><td>' : '</td>' !!}
                            @php
                                $jmh++;
                            @endphp
                        @endforeach
                </tr>
                @php
                    $no++;
                @endphp
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
@endsection
