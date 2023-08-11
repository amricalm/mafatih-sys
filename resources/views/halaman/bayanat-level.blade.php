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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('bayanat-quran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" id="createNew" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#ajaxModel"><i class="fa fa-plus"></i> Tambah</a>
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
                                    <th width="33%">Tingkat Bayanat</th>
                                    <th width="33%">Level Bayanat</th>
                                    <th width="33%">Nama</th>
                                    <th width="10%">#</th>
                                </tr>
                            </thead>
                            <tbody id="bodykomponen">
                                @foreach ($level as $k=>$v)
                                <tr>
                                    <td class="">{{ $v->level }}</td>
                                    <td class="arabic text-right">{{ $v->name }}</td>
                                    <td class="arabic text-right">{{ $v->name_ar }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" style="">
                                                <a class="dropdown-item edit" href="javascript:edit({{ $v->id }})"><i class="fa fa-pencil"></i> Edit</a>
                                                <a class="dropdown-item delete" href="javascript:hapus({{ $v->id }})"><i class="fa fa-trash"></i> Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
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
                    <div class="form-group">
                        <label for="name" class="control-label">Tingkat Bayanat</label>
                        <div>
                            <input type="number" class="form-control" id="level" name="level" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Level Bayanat</label>
                        <div>
                            <input type="text" class="form-control arabic text-right" id="name" name="name" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_ar" class="control-label">Juz</label>
                        <div>
                            <input type="text" class="form-control arabic text-right" id="name_ar" autocomplete="off" name="name_ar" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $('#createNew').on('click',function(){
        $('#saveBtn').html('<i class="fa fa-save"></i> Simpan')
        $('#form').trigger('reset');
    })
    $('#saveBtn').click(function(e) {
        e.preventDefault();
        data = $('#form').serialize()
        $.post('{{ url('bayanat-quran/level/exec') }}',{"_token":"{{ csrf_token() }}",data:data,'tipe':'insert'},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil disimpan');
                location.reload();
            }
            else
            {
                msgError(data);
            }
            console.log(data);
        })
    });
    function edit(id)
    {
        $.post('{{ url('bayanat-quran/level/exec') }}',{"_token":"{{ csrf_token() }}",'tipe':'show','id':id,'data':''},function(data){
            datas = JSON.parse(data);
            $('#ajaxModel').modal('show');
            $('#id').val(datas.id);
            $('#level').val(datas.level);
            $('#name').val(datas.name);
            $('#name_ar').val(datas.name_ar);
            $('#saveBtn').html('<i class="fa fa-pencil"></i> Update');
        })
    }
    function hapus(id)
    {
        if(confirm('Betul akan dihapus?'))
        {
            $.post('{{ url('bayanat-quran/level/exec') }}',{"_token":"{{ csrf_token() }}",'tipe':'delete','id':id,'data':''},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Berhasil dihapus');
                    location.reload();
                }
                else
                {
                    console.log(data);
                }
            })
        }
    }
</script>
@endpush
