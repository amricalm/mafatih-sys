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
                        <a href="javascript:void(0)" id="createNew" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#ajaxModel"><i class="fa fa-plus"></i> Tambah</a>
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
                                    <th width="20%">Komponen Nilai</th>
                                    <th width="35%">Komponen Nilai (arabic)</th>
                                    <th width="15%">Grup Test Lisan</th>
                                    <th>Bobot</th>
                                    <th width="10%">#</th>
                                </tr>
                            </thead>
                            <tbody id="bodykomponen">
                                @foreach ($mapel as $k=>$v)
                                <tr>
                                    <td>{{ $v->name }}</td>
                                    <td class="arabic text-right">{{ $v->name_ar }}</td>
                                    <td>{!! ($v->is_group=='1') ? '<i class="fas fa-check-square"></i>' : '<i class="fas fa-times-circle"></i>' !!}</td>
                                    <td>{{ $v->weight }}</td>
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
                        <label for="name" class="control-label">Komponen Nilai</label>
                        <div>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_ar" class="control-label">Komponen Nilai Dalam Bhs.Arab</label>
                        <div>
                            <input type="text" class="form-control arabic text-right" id="name_ar" autocomplete="off" name="name_ar" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="weight" class="control-label">Bobot</label>
                        <div>
                            <input type="number" max="100" class="form-control" id="weight" autocomplete="off" name="weight" value="">
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_group" name="is_group">
                        <label for="is_group" class="control-label">Tes Lisan</label>
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
    $('#saveBtn').click(function(e) {
        e.preventDefault();
        data = $('#form').serialize()
        $.post('{{ url('bayanat-quran/komponen-nilai/exec') }}',{"_token":"{{ csrf_token() }}",data:data,'tipe':'insert'},function(data){
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
        $.post('{{ url('bayanat-quran/komponen-nilai/exec') }}',{"_token":"{{ csrf_token() }}",'tipe':'show','id':id,'data':''},function(data){
            datas = JSON.parse(data);
            $('#ajaxModel').modal('show');
            $('#id').val(datas.id);
            $('#name').val(datas.name);
            $('#name_ar').val(datas.name_ar);
            $('#weight').val(datas.weight);
            $('#is_group').prop('checked',false);
            if(datas.is_group=='1')
            {
                $('#is_group').prop('checked',true);
            }
            $('#saveBtn').html('<i class="fa fa-pencil"></i> Update');
        })
    }
    function hapus(id)
    {
        if(confirm('Betul akan dihapus?'))
        {
            $.post('{{ url('bayanat-quran/komponen-nilai/exec') }}',{"_token":"{{ csrf_token() }}",'tipe':'delete','id':id,'data':''},function(data){
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
