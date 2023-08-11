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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('medical-record') }}">{{ $judul }}</a></li>
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
                <div class="table-responsive py-4">
                    <div class="container">
                        <table class="table datatables">
                            <thead>
                                <tr>
                                    <th>Nama Santri</th>
                                    <th>Keterangan</th>
                                    <th>Penanganan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $item)
                                <tr>
                                    <td>
                                        {{ $item->santri }}
                                        <br>
                                        {!! ($item->is_finish=='1') ? '<span class="badge badge-primary">Sudah ditangani</span>' : '<span class="badge badge-danger">Belum ditangani</span>' !!}
                                    </td>
                                    <td><p class="text-wrap" style="font-size: .8125rem;">Terjadi : {!! \App\SmartSystem\General::convertDate($item->date).'<br/>'. $item->name.' > '.$item->desc !!}</p></td>
                                    <td><p class="text-wrap" style="font-size: .8125rem;">{!! 'Ditangani oleh : '.$item->guru.'<br>'.$item->handle !!}</p></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-warning btn-sm text-white" onclick="show({{ $item->id }})" id="btnEdit"><i class="fas fa-pen"></i> Edit</button>
                                        <button type="button" class="btn btn-default btn-sm text-white" onclick="hapus({{ $item->id }})" id="btnDelete"><i class="fas fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                {{ $riwayat->links() }}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formTambahModal" name="formTambahModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Tambah Riwayat Kesehatan</h4>
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
                                <label for="date" class="control-label">Tanggal Kejadian</label>
                                <div>
                                    <input type="text" class="form-control datepicker" name="date" id="date"  value="{{ date('Y-m-d') }}" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date" class="control-label">Nama Penyakit</label>
                                <div>
                                    <input type="text" class="form-control" name="name" id="name" value="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="desc" class="control-label">Keterangan</label>
                                <div>
                                    <textarea class="form-control" id="desc" name="desc" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pid" class="control-label">Ditangani oleh</label>
                                <div>
                                    <select name="handle_by" id="handle_by" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($guru as $key=>$val)
                                            <option value="{{ $val->pid }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="desc" class="control-label">Penanganan</label>
                                <div>
                                    <textarea class="form-control" id="handle" name="handle" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="is_finish" name="is_finish" value="1">
                                <label class="form-check-label" for="is_finish">Selesai ditangani</label>
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
                    <h4 class="modal-title" id="modelHeading">Edit Riwayat Kesehatan</h4>
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
                                <label for="edate" class="control-label">Tanggal Kejadian</label>
                                <div>
                                    <input type="text" class="form-control datepicker" name="edate" id="edate"  value="{{ date('Y-m-d') }}" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ename" class="control-label">Nama Penyakit</label>
                                <div>
                                    <input type="text" class="form-control" name="ename" id="ename" value="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edesc" class="control-label">Keterangan</label>
                                <div>
                                    <textarea class="form-control" id="edesc" name="edesc" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ehandle_by" class="control-label">Ditangani oleh</label>
                                <div>
                                    <select name="ehandle_by" id="ehandle_by" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($guru as $key=>$val)
                                            <option value="{{ $val->pid }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ehandle" class="control-label">Penanganan</label>
                                <div>
                                    <textarea class="form-control" id="ehandle" name="ehandle" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-check">
                                <input type="checkbox" class="checkedit" id="eis_finish" name="eis_finish" value="1">
                                <label class="form-check-label" for="eis_finish">Selesai ditangani</label>
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
    $('.datepicker').datepicker({
        'setDate': new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        zIndexOffset: 999
    });
    function show(id){
        $.get('{{ url('medical-record') }}/'+id+'/edit',function(data){
            data = jQuery.parseJSON(data);
            $('#eid').val(data.id);
            $("#epid").val(data.pid).trigger('change');
            $('#edate').val(data.date);
            $('#ename').val(data.name);
            $('#edesc').val(data.desc);
            $("#ehandle_by").val(data.guruid).trigger('change');
            $('#ehandle').val(data.handle);
            $('#eis_finish').val(data.is_finish);
            if(data.is_finish==1)
            {
                $('#eis_finish').prop('checked',true);
            } else {
                $('#eis_finish').prop('checked',false);
            }

            $('#editModal').modal('show');
        });
    }
    function tambah()
    {
        var data = $('#formTambahModal').serialize();
        $.post('{{ url('medical-record/simpan') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil simpan');
                location.reload();
            }
            else
            {
                msgError('Ada kesalahan. '+data);
            }
        })
    }

    $('.checkedit').change(function() {
        if(this.checked) {
            $('.checkedit').val('1');
        }
    });
    function update()
    {
        var data = $('#formEditModal').serialize();
        $.post('{{ url('medical-record/update') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil update');
                location.reload();
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
            $.get('{{ url('medical-record') }}/'+id+'/hapus',function(data){
                if(data=='Berhasil')
                {
                    window.location.href = '{{ url('medical-record') }}';
                }
                else
                {
                    msgError('Ada kesalahan. '+data);
                }
            })
        }
    }
</script>
@endpush
