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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('konseling') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" data-toggle="modal" data-target="#tambahModal" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <form id="frmFilter">
                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-10">
                                    <select name="ccid" id="ccid" class="form-control">
                                        <option value=""> - Pilih Salah Satu - </option>
                                        @foreach ($courseclass as $key=>$val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="button" id="lihat" class="btn btn-primary"><i class="fas fa-info-circle"></i> Lihat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-primary" id="btnExport" style="display:none;" data-toggle="collapse" href="#" onclick="eksport()"  role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-file-excel"></i> Export</button>
                        </div>
                    </div>
                    <div class="table-responsive py-4">
                        <div class="container">
                            <table class="table datatables" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Konseling</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="bodytable">

                                </tbody>
                                <tfoot>
                                    {{ $riwayat->links() }}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formTambahModal" name="formTambahModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Tambah Konseling Santri</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pid" class="control-label">Pilih Santri</label>
                                <div>
                                    <select name="pid" id="pid" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($santri as $key=>$val)
                                            <option value="{{ $val->pid }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date" class="control-label">Tanggal</label>
                                <div>
                                    <input type="text" class="form-control datepicker" name="date" id="date"  value="{{ date('Y-m-d') }}" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date" class="control-label">Konseling Santri</label>
                                <div>
                                    <textarea class="form-control" name="name" id="name" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="desc" class="control-label">Solusi Guru BK</label>
                                <div>
                                    <textarea class="form-control" id="desc" name="desc" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="tambah()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditModal" name="formEditModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Edit Konseling</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="eid" id="eid" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="epid" class="control-label">Pilih Santri</label>
                                <div>
                                    <select name="epid" id="epid" class="form-control select2" readonly>
                                        @foreach ($santri as $key=>$val)
                                            <option value="{{ $val->pid }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edate" class="control-label">Tanggal</label>
                                <div>
                                    <input type="text" class="form-control datepicker" name="edate" id="edate"  value="{{ date('Y-m-d') }}" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ename" class="control-label">Konseling Santri</label>
                                <div>
                                    <textarea class="form-control" name="ename" id="ename" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edesc" class="control-label">Solusi Guru BK</label>
                                <div>
                                    <textarea class="form-control" id="edesc" name="edesc" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="update()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        showbaris();
	});

    $('.datepicker').datepicker({
        'setDate': new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        zIndexOffset: 999
    });
    function show(id){
        $.get('{{ url('konseling') }}/'+id+'/edit',function(data){
            data = jQuery.parseJSON(data);
            $('#eid').val(data.id);
            $("#epid").val(data.pid).trigger('change');
            $('#edate').val(data.date);
            $('#ename').val(data.name);
            $('#edesc').val(data.desc);
            $('#editModal').modal('show');
        });
    }
    function tambah()
    {
        var data = $('#formTambahModal').serialize();
        $.post('{{ url('konseling/simpan') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil simpan');
                e.preventDefault();
                $('#formTambahModal').reset();
                $('#tambahModal').modal('dispose');
            }
            else
            {
                msgError('Ada kesalahan. '+data);
            }
        })
    }
    function update()
    {
        var data = $('#formEditModal').serialize();
        $.post('{{ url('konseling/update') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil update');
                $('#formEditModal').reset();
                $('#editModal').modal('dispose');
            }
            else
            {
                msgError('Ada kesalahan. '+data);
            }
        });
    }
    function hapus(id)
    {
        if(confirm('Yakin akan dihapus?'))
        {
            $.get('{{ url('konseling') }}/'+id+'/hapus',function(data){
                if(data=='Berhasil')
                {
                    window.location.href = '{{ url('konseling') }}';
                }
                else
                {
                    msgError('Ada kesalahan. '+data);
                }
            })
        }
    }

    //Filter per kelas
    $('#lihat').on('click',function(){
        post = $('#ccid option:selected').val();
        if(post==''||post=='0')
        {
            alert('Mohon pilih salah satu tahun pelajaran. Lalu klik tombol Lihat!');
            return;
        }
        showbaris(post);
    })
    function showbaris(id)
    {
        $('#bodytable').html('');
        $.get('{{ url('konseling') }}/'+id+'/show',function(data){
            $('#bodytable').html(data);
            $('#btnExport').show();
        })
    }
    function eksport()
    {
        var ccid = $('#frmFilter').serialize();
        $('#frmFilter').attr('action','{{ url()->current() }}/export');
        $('#frmFilter').attr('method','POST');
        $('#frmFilter').attr('target','_blank');
        $('#frmFilter').submit();
    }
</script>
@endpush
