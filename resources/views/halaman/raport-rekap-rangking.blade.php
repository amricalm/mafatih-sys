@extends('layouts.app')
@include('komponen.tabledata')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url($aktif) }}">Raport Rekap</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @if ($req->pilihlevel)
                        <a href="{{ url()->full().'&file=xls' }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> XlS</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Rekap Nilai Rangking</h3>
                    <form action="" method="GET" style="padding-bottom: 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="staticLembaga" class="sr-only">Level</label>
                                            <select name="pilihlevel" id="pilihlevel" class="form-control">
                                                <option value="0"> - Pilih Salah Satu - </option>
                                                @foreach ($level as $k=>$v)
                                                @php
                                                    $selected = ($v->level==$req->pilihlevel) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $v->level }}" {{ $selected }}>Level {{ $v->level }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="staticLembaga" class="sr-only">Banin/Banat</label>
                                            <select name="pilihjkl" id="pilihjkl" class="form-control">
                                                <option value="0"> - Pilih Salah Satu - </option>
                                                @php
                                                    $sex = ['L'=>'Banin','P'=>'Banat'];
                                                @endphp
                                                @foreach ($sex as $k=>$v)
                                                @php
                                                    $selected = ($k==$req->pilihjkl) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $k }}" {{ $selected }}>{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
                                    @if (count($murid)!=0)
                                        @foreach ($ipk as $k=>$v)
                                        @php
                                            $data = $murid->where('sid',$v['sid'])->toArray();
                                            $data = reset($data);
                                        @endphp
                                        <tr>
                                            <td>{{ ($i+1) }}</td>
                                            <td>{{ $data['nis'] }}</td>
                                            <td><a href="{{ url('siswa/'.$data['pid'].'/edit') }}">{{ $data['name'] }}</a></td>
                                            <td class="arabic">{{ $data['name_ar'] }}</td>
                                            <td class="arabic">{{ $data['classname'] }}</td>
                                            <td>{{ number_format($v['ipk'],2,',','.') }}</td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
