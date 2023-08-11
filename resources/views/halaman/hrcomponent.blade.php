@extends('layouts.app')
@include('komponen.dataTables')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('tahunajaran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" onclick="$('#form').trigger('reset');$('#desc').html('')" id="createNew" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#ajaxModel"><i class="fa fa-plus"></i> Tambah</a>
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
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Komponen</th>
                                    <th>Deskripsi</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($data as $key=>$val)
                                <tr>
                                    <td>{{ $val->code }}</td>
                                    <td>{{ $val->name }}</td>
                                    <td>{{ $val->desc }}</td>
                                    <td class="text-right">
                                       <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                            <button id="btnEdit" onclick="show({{ $val->id }})" type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</button>
                                            <button id="btnHapus" onclick="hapus({{ $val->id }})" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
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
            <form id="form" name="form" class="form-horizontal" method="POST" action="{{ url('komponenkinerja/save') }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="control-label">Kode</label>
                        <div>
                            <input type="text" class="form-control" id="code" name="code" value="" maxlength="5" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Komponen</label>
                        <div>
                            <input type="text" class="form-control" id="name" name="name" value="" maxlength="30" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Deskripsi</label>
                        <div>
                            <textarea id="desc" name="desc" required="" class="form-control"></textarea>
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
    function show(id)
    {
        $('#ajaxModel').modal('show');
        $.get('{{ url('komponenkinerja') }}/'+id+'/show',function(data){
            var obj = jQuery.parseJSON(data);
            $('#id').val(obj.id);
            $('#code').val(obj.code);
            $('#name').val(obj.name);
            $('#desc').html(obj.desc);
            $('#score').val(obj.score);
            $('#duration_min').val(obj.duration_min);
            (obj.is_mandatory=='1') ? $('#is_mandatory').prop('checked',true) : $('#is_mandatory').prop('checked',false);
            (obj.is_overtime=='1') ? $('#is_overtime').prop('checked',true) : $('#is_overtime').prop('checked',false);
        })
    }
    function hapus(id)
    {
        if(confirm('Betul akan dihapus?'))
        {
            post = $('#id option:selected').val();
            $.get('{{ url('komponenkinerja') }}/'+id+'/delete',function(data){
                location.reload();
            });
        }
    }
</script>
@endpush
