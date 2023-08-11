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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('siswa') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" data-toggle="modal" data-target="#modalImport" class="btn btn-sm btn-secondary"><i class="fas fa-file-excel"></i> Impor dari Excel</a>
                    </div>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('siswa.baru') }}" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="padding:10px;">
        <div class="col">
            <div class="card">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12" style="padding:10px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <a class="btn btn-default btn-sm" data-toggle="collapse" href="#collapseFilter" role="button" aria-expanded="{{ ($cari!='') ? true : false }}" aria-controls="collapseFilter"><i class="fa fa-filter"></i> Filter</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    {{-- <a class="btn btn-primary btn-sm" href="javascript:import()"><i class="fas fa-file-import"></i> Import</a>
                                    <a class="btn btn-primary btn-sm" href="javascript:export()"><i class="fas fa-file-export"></i> Export</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body collapse {{ ($cari!='') ? 'show' : '' }}" id="collapseFilter">
                                <form id="formFilter">
                                    {{-- <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-10">
                                            <select name="kelas" id="cariKelas" class="form-control">
                                                <option value=""> - Pilih Salah Satu - </option>
                                                @foreach ($kelas as $key=>$val)
                                                <option value="{{ $val['id'] }}">{{ $val['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Cari</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="cari" id="cariDetail" placeholder="Cari Nama" value="{{ $cari }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button class="btn btn-success btn-sm"><i class="fas fa-search"></i> Terapkan filter</button>
                                                <a href="{{url('siswa')}}" class="btn btn-warning btn-sm"><i class="fas fa-times"></i> Bersihkan</a>
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
                        <table class="table datatables">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nama dalam Arabic</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student as $key => $value)
                                    @php
                                        $fotoprofil = $foto->where('pid',$value->id)->where('desc','Foto Personal')->toArray();
                                        $fotoprofil = reset($fotoprofil);
                                        $fotoprofilnya = (!isset($fotoprofil['original_file'])) ? url('assets').'/img/no-profile.png' : url('/').'/'.$fotoprofil['original_file'];
                                    @endphp
                                    <tr>
                                        <td>{{ $value->nis }}</td>
                                        <td>
                                            {{-- <div class="avatar-group"><img alt="Image placeholder" src="{{ $fotoprofilnya }}"></div> --}}
                                            <div class="media align-items-center">
                                                <span class="avatar avatar-sm rounded-circle">
                                                    <img alt="Foto Profil {{ $value->name }}" src="{{ $fotoprofilnya }}">
                                                </span>
                                                {{-- <div class="media-body  ml-2  d-none d-lg-block">
                                                    <span class="mb-0 text-sm  font-weight-bold">{{ $value->name }}</span>
                                                </div> --}}
                                            </div>
                                        </td>
                                        <td>{{ $value->name }}</td>
                                        <td class="arabic text-right">{{ $value->name_ar }}</td>
                                        <td class="text-right">
                                            {{-- <a href="{{ url('siswa/'.$value->id.'/show') }}" class="btn btn-success btn-sm text-white" onclick="show({{ $value->id }})" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Lihat {{ $value->name }}"><i class="fas fa-search"></i></a> --}}
                                            <a href="{{ url('siswa/'.$value->id.'/edit') }}" class="btn btn-warning btn-sm text-white" onclick="show({{ $value->id }})" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Edit {{ $value->name }}"><i class="fas fa-pen"></i></a>
                                            <a href="{{ url('siswa/'.$value->id.'/hapus') }}" class="btn btn-default btn-sm text-white" onclick="return confirm('Yakin akan dihapus?')" id="btnDelete" data-toggle="tooltip" data-placement="top" title="Hapus {{ $value->name }}"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {!! $student->links() !!}
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
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tahapan Impor Dari Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmImpor">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ol>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-9">
                                            Download Template >>>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <a href="{{ url('siswa/export') }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> Template</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            Isi data-data santri
                                            <img src="{{ asset('uploads/copy-paste-santri-input-nilai.png') }}" alt="ilustrasi" width="100%">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <b>Save As</b> data yang sudah sesuai Fieldnya dengan nama file yang memudahkan Anda.
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="files">Upload Filenya disini</label>
                                                <input type="file" class="form-control-file" name="file" id="file">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            Klik Tombol <b>Proses Impor</b> dibawah. Lalu tunggu sampai ada notifikasi berhasil.
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnProses"><i class="fa fa-gear"></i> Proses Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $('#btnProses').on('click',function(){
        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append("_token","{{ csrf_token() }}");

        $.ajax({
            url: '{{ route('uploadsiswa') }}',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
                success: function(response){
                    if(response=='Berhasil'){
                        msgSukses('Berhasil import nilai');
                        location.reload();
                    }else{
                        msgError('Mohon dilaporan!');
                    }
                },
        });
    });
</script>
@endpush
