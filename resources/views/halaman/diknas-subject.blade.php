@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.select2')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('diknas') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{-- <a href="#" data-toggle="modal" data-target="#tambahModal" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   Mata Pelajaran Diknas
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>Nama Singkatan</th>
                            <th>Mata Pelajaran</th>
                            <th>#</th>
                        </thead>
                        <tbody id="body">
                            <tr>
                                <td colspan="5">
                                    <div class="fa-5x">
                                        <i class="fas fa-spinner fa-pulse"></i>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <th colspan="5">
                                <button class="btn btn-primary btn-sm btn-block" onclick="tambah()"><i class="fas fa-plus-circle"></i> Tambah Pelajaran</button>
                            </th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahPelajaran" tabindex="-1" aria-labelledby="tambahPelajaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPelajaranLabel">Update Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmTambah">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label col-form-label-sm">Mata Singkatan</label>
                                <div class="col-sm-8">
                                    <input type="hidden" class="form-control form-control-sm" id="id" name="id">
                                    <input type="text" class="form-control form-control-sm" id="nama_singkat" name="nama_singkat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label col-form-label-sm">Mata Pelajaran</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="nama" name="nama">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                        <button type="button" class="btn btn-primary btnTambah" onclick="simpan()"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $( document ).ready(function() {
        get();
    });
    function tambah()
    {
        $('.btnTambah').removeAttr('disabled');
        $('#frmTambah').trigger('reset');
        $('#tambahPelajaran').modal('show');
    }
    function simpan()
    {
        frm = $('#frmTambah').serialize();
        short_name = $("#nama_singkat").val();
        name = $("#nama").val();
        if(name==''||name=='')
        {
            alert('Nama Mata Pelajaran untuk Diknas harus diisi!');
            return;
        }
        $('.btnTambah').attr('disabled','disabled');
        $('.btnTambah').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...');
        $.post('{{ url('diknas/matapelajaran/save') }}',{"_token": "{{ csrf_token() }}",data:frm},function(data){
            if(data=='Berhasil')
            {
                $('.btnTambah').removeAttr('disabled');
                $('.btnTambah').html('<i class="fa fa-plus"></i> Tambah');
                $('#nama_singkat').val('');
                $('#nama').val('');
                get();
            }
            else
            {
                console.table(data);
            }
        });
    }
    function edit(id)
    {
        $('#frmTambah').trigger('reset');
        $('#tambahPelajaran').modal('show');
        $('.btnTambah').html('<i class="fa fa-save"></i> Simpan');
        var url = '{{ url('diknas/matapelajaran/') }}/'+id+'/edit';
        $.get(url,function(data) {
            $('#id').val(data.id);
            $('#nama_singkat').val(data.short_name);
            $('#nama').val(data.name);
        });
    }
    function get()
    {
        var isi = '';
        $.post('{{ url('diknas/matapelajaran/load') }}',{"_token": "{{ csrf_token() }}"},function(data){
            $('#body').html(data);
        });
    }
    function hapus(id)
    {
        if(confirm('Mata Pelajaran akan dihapus? '))
        {
            $.post('{{ url('diknas/matapelajaran/hapus') }}',{"_token": "{{ csrf_token() }}",id:id},function(data){
                if(data=='Berhasil')
                {
                    get();
                }
            })
        }
    }
</script>
@endpush
