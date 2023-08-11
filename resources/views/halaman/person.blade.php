@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.datepicker')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('karyawan') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('siswa.baru') }}" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
                        <a href="{{ route('siswa.baru') }}" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-file-excel"></i> Import</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <a class="btn btn-default btn-sm" data-toggle="collapse" href="#collapseFilter" role="button" aria-expanded="false" aria-controls="collapseFilter"><i class="fa fa-filter"></i> Filter</a>
                            </p>
                            <div class="card-body row collapse" id="collapseFilter">
                                <form class="w-100" action="">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input class="form-control form-control-sm" type="text" name="cari" placeholder="cari">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button class="btn btn-success btn-sm"><i class="fas fa-search"></i> Terapkan filter</button>
                                                <a href="{{url('purchase-cust')}}" class="btn btn-warning btn-sm"><i class="fas fa-times"></i> Bersihkan</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive py-4">
                    <div class="container">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Nama dalam Arabic</th>
                                    <th>Pilih</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($person as $key => $value)
                                    <tr>
                                        <td>{{ $value->name }}</td>
                                        <td class="arabic text-right">{{ $value->name_ar }}</td>
                                        <td class="text-right">
                                           <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline1">Siswa</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline2">Karyawan</label>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ url('person/'.$value->id.'/edit') }}" class="btn btn-warning btn-sm text-white" onclick="show({{ $value->id }})" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Edit {{ $value->name }}"><i class="fas fa-pen"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Halaman : {{ $person->currentPage() }} <br/>
                    </div>
                    <div class="col-md-4">
                        Jumlah Data : {{ $person->total() }} <br/>
                    </div>
                    <div class="col-md-4">
                        Data Per Halaman : {{ $person->perPage() }} <br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{ $person->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form" name="form" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="one-tab" data-toggle="pill" href="#one" role="tab" aria-controls="one" aria-selected="true">[ 1 ]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="two-tab" data-toggle="pill" href="#two" role="tab" aria-controls="two" aria-selected="false">[ 2 ]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="three-tab" data-toggle="pill" href="#three" role="tab" aria-controls="three" aria-selected="false">[ 3 ]</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
                            <div class="form-group">
                                <label for="nis" class="control-label">NIS</label>
                                <div>
                                    <input type="text" class="form-control" id="nis" name="nis" value="" maxlength="50" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nisn" class="control-label">NISN</label>
                                <div>
                                    <input type="text" class="form-control" id="nisn" name="nisn" value="" maxlength="50" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Nama Lengkap</label>
                                <div>
                                    <input type="text" class="form-control" id="name" name="name" value="" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
                        </div>
                        <div class="tab-pane fade" id="three" role="tabpanel" aria-labelledby="three-tab">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush
