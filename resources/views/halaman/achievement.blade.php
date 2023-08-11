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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('prestasi') }}">{{ $judul }}</a></li>
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
                                <label for="student" class="col-sm-2 col-form-label">Santri</label>
                                <div class="col-sm-10">
                                    <select name="student" id="student" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($santri as $key=>$val)
                                            <option value="{{ $val->pid }}">{{ $val->name }}</option>
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
                            <button class="btn btn-primary" id="btnExport" style="display:none;" data-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-file-excel"></i> Export</button>
                        </div>
                    </div>
                    <div class="table-responsive py-4">
                        <div class="container">
                            <table class="table datatables" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Santri</th>
                                        <th>Prestasi</th>
                                        <th>File</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="bodytable">

                                </tbody>
                                {{-- <tfoot>
                                    {{ $riwayat->links() }}
                                </tfoot> --}}
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
                    <h4 class="modal-title" id="modelHeading">Tambah Prestasi Santri</h4>
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
                                    <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date" class="control-label">Prestasi</label>
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
                                <label for="desc" class="control-label">Upload Berkas</label>
                                <div>
                                    <input type="file" name="file" class="form-control" id="file" accept="image/jpeg,.pdf">
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
                    <h4 class="modal-title" id="modelHeading">Edit Prestasi</h4>
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
                                    <input type="date" class="form-control" name="edate" id="edate"  value="{{ date('Y-m-d') }}" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ename" class="control-label">Prestasi</label>
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
        showbaris('','');
	});
    function show(id){
        $.get('{{ url('prestasi') }}/'+id+'/edit',function(data){
            data = jQuery.parseJSON(data);
            $('#eid').val(data.id);
            $("#epid").val(data.pid).trigger('change');
            $('#edate').val(data.date);
            $('#ename').val(data.name);
            $('#edesc').val(data.desc);
            $('#efile').val(data.file);
            $('#editModal').modal('show');
        });
    }
    $('#file').change(function() {
        var fileExtension = ['jpeg', 'jpg', 'pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)
        {
            alert("Silahkan upload file "+fileExtension.join(', '));
        }
    });
    function tambah()
    {
        var file_desc = 'Prestasi : ' + $('#name').val();
        var form_data = new FormData();
        form_data.append("_token","{{ csrf_token() }}");
        form_data.append('data', $('#formTambahModal').serialize());
        form_data.append('file', $('#file').prop('files')[0]);
        $.ajax({
            url: '{{ url('prestasi/simpan') }}',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
                if(data=='Berhasil')
                {
                    msgSukses(file_desc+' berhasil diupload');
                    $('#formTambahModal').trigger('reset');
                    $('#tambahModal').modal('hide');
                }
                else
                {
                    msgError(data);
                }
            }
        });
        return false;
        $.post('{{ url('prestasi/simpan') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                upload();
                msgSukses('Berhasil simpan');
                $('#formTambahModal').trigger('reset');
                $('#tambahModal').modal('hide');
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
        $.post('{{ url('prestasi/update') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil update');
                $('#formEditModal').trigger('reset');
                $('#editModal').modal('hide');
                window.location.reload();
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
            $.get('{{ url('prestasi') }}/'+id+'/hapus',function(data){
                if(data=='Berhasil')
                {
                    window.location.href = '{{ url('prestasi') }}';
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
        ccid = $('#ccid option:selected').val();
        student = $('#student option:selected').val();
        if(ccid==''&&student=='')
        {
            alert('Mohon pilih salah satu kelas. Lalu klik tombol Lihat!');
            return;
        }
        showbaris(ccid,student);
    })
    $('#ccid').change(function(){
        id = $(this).val();
        $.post('{{ url('prestasi') }}/'+id+'/darikelas',{"_token": "{{ csrf_token() }}"},function(data)
        {
            if(data !== null)
            {
                data = jQuery.parseJSON(data);
                $('#student option:not(:first)').remove();
                $.each(data,function(i, datas){
                    $('#student').append($('<option>',{value:datas.id,text:datas.name}));
                });
            }
        });
    });
    function showbaris(ccid='',student='')
    {
        $('#bodytable').html('');
        $.get('{{ url('prestasi') }}/show?ccid='+ccid+'&student='+student,function(data){
            $('#bodytable').html(data);
            $('#btnExport').show();
            eksport(ccid,student);
        })
    }
    function eksport(ccid='',student='')
    {
        $('#btnExport').on('click',function(){
            var ccid = $('#frmFilter').serialize();
            $('#frmFilter').attr('action','{{ url()->current() }}/export');
            $('#frmFilter').attr('method','POST');
            $('#frmFilter').attr('target','_blank');
            $('#frmFilter').submit();
        });
    }

    function upload()
    {
        var file_data = $('#file').prop('files')[0];
        var file_desc = 'Prestasi : ' + $('#name').val();
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('pid','{{ auth()->user()->pid }}');
        form_data.append('desc',file_desc);
        form_data.append("_token","{{ csrf_token() }}");
        $.ajax({
            url: '{{ route('upload') }}',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
                datas = data.split('|');
                if(datas[0]=='Berhasil')
                {
                    if(datas[1]=='jpg'||datas[1]=='gif'||datas[1]=='png'||datas[1]=='jpeg')
                    {
                        {{--
                        text = '<div class="alert alert-light alert-dismissible fade show" role="alert" id="foto_gambar"><input type="hidden" id="foto_desc" value="{{ $val['desc'] }}"><a href="{{ url('/') }}/'+datas[2]+'" target="_blank"><img src="{{ url('/') }}/'+datas[2]+'" alt="Foto Personal" height="200px"></a><button type="button" class="close" aria-label="Close" onclick="hapusfile('+"'"+tipe+"'"+')"><span aria-hidden="true">&times;</span></button></div>';
                        $('#frmUpload'+tipe).html(text);
                        --}}
                    }
                    msgSukses(file_desc+' berhasil diupload');
                }
                else
                {
                    msgError(data);
                }
            }
        });
    }
</script>
@endpush
