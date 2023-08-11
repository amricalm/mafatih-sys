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
                            <li class="breadcrumb-item active" aria-current="page"><a href="">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" id="createNew" onclick="$('#formmenu').trigger('reset')" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#tambahMenu"><i class="fa fa-plus"></i> Tambah</a>
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
                                    <th>Peran</th>
                                    <th>Deskripsi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peran as $key => $value)
                                    <tr>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->desc }}</td>
                                        <td class="text-right">
                                            <a href="javascript:detail({{ $value->id }})" class="btn btn-primary btn-sm text-white" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Detail {{ $value->name }}"><i class="fas fa-bezier-curve"></i></a>
                                            <a href="javascript:edit({{ $value->id }})" class="btn btn-warning btn-sm text-white" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Edit {{ $value->name }}"><i class="fas fa-pen"></i></a>
                                            <a href="javascript:hapus({{ $value->id }})" class="btn btn-default btn-sm text-white" onclick="return confirm('Yakin akan dihapus?')" id="btnDelete" data-toggle="tooltip" data-placement="top" title="Hapus {{ $value->name }}"><i class="fas fa-trash"></i></a>
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
</div>
<!-- Modal -->
<div class="modal fade" id="tambahMenu" tabindex="-1" role="dialog" aria-labelledby="labelTambahMenu" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">Peran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formmenu">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name">Nama Peran</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Nama Peran">
                    </div>
                    <div class="form-group">
                        <label for="name">Deskripsi</label>
                        <textarea type="text" class="form-control" id="desc" name="desc"></textarea>
                    </div>
                    <hr>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Keluar</button>
                        <button type="button" class="btn btn-primary" id="btnsave" ><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="detailPeran" tabindex="-1" role="dialog" aria-labelledby="labelTambahMenu" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">Peran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formmenu">
                    <input type="hidden" id="idperan" name="id">
                    <div class="form-group">
                        <label for="name">Nama Peran</label>
                        <input type="text" class="form-control form-control-sm" id="namePeran" name="name" placeholder="Nama Peran" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Deskripsi</label>
                        <textarea type="text" class="form-control" id="descPeran" name="desc" readonly></textarea>
                    </div>
                    <hr>
                    <table id="tblMenu" class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Menu</th>
                            <th>#</th>
                        </thead>
                        <tbody id="bodytblmenu">

                        </tbody>
                        <tfoot>
                            <td colspan="2">
                                <select name="menuperan" id="menuperan" class="form-control form-control-sm">
                                    <option value=""> - Pilih Salah Satu - </option>
                                    @php
                                        $menuutama = collect($menu)->where('menu_parent','0')->toArray();
                                    @endphp
                                    @foreach ($menuutama as $key=>$val)
                                        <optgroup label="{{ $val['menu'] }}">
                                            @php
                                                $menumenu = collect($menu)->where('menu_parent',$val['id'])->toArray();
                                            @endphp
                                            @foreach ($menumenu as $kk=>$vv)
                                                <option value="{{ $vv['id'] }}">{{ $vv['menu'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" id="btnSaveDetail" onclick="insertmenu()"><i class="fa fa-save"></i></button>
                            </td>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function detail(id)
    {
        $.post('{{ url('peran') }}/'+id+'/load',{"_token": "{{ csrf_token() }}"},function(data){
            datas = JSON.parse(data);
            $('#idperan').val(datas.peran.id);
            $('#namePeran').val(datas.peran.name);
            $('#descPeran').val(datas.peran.desc);
            text = '';
            $('#bodytblmenu').html(datas.detail);
            $('#detailPeran').modal('show');
        });
    }
    function edit(id)
    {
        $('#labelTambahMenu').html('Edit Menu');
        $.post('{{ url('peran') }}/'+id+'/load',{"_token": "{{ csrf_token() }}"},function(data){
            datas = JSON.parse(data);
            $('#id').val(datas.peran.id);
            $('#name').val(datas.peran.name);
            $('#desc').val(datas.peran.desc);
            $('#tambahMenu').modal('show');
        })
    }
    function hapus(id)
    {
        $.post('{{ url('peran') }}/'+id+'/hapus',{"_token": "{{ csrf_token() }}"},function(data){
            if(data=='Berhasil')
            {
                location.reload();
            }
        })
    }
    $('#btnsave').on('click',function(){
        ur = $('#urutan').val();
        mn = $('#menu').val();
        sl = $('#slug').val();
        mp = $('#menu_parent').val();
        mi = $('#menu_icon').val();
        ml = $('#menu_level').val();
        (ur==''||ur=='') ? alert('isi urutan!') : '';
        (mn==''||mn==' ') ? alert('isi menu!') : '';
        (sl==''||sl==' ') ? alert('isi url!') : '';
        (mi==''||mi==' ') ? alert('isi icon!') : '';
        (ml==''||ml==' ') ? alert('isi level') : '';
        frm = $('#formmenu').serialize();
        $.post('{{ url('peran/simpan') }}',{"_token": "{{ csrf_token() }}",'data':frm},function(data){
            if(data=='Berhasil')
            {
                location.reload();
            }
        })
    });
    function insertmenu()
    {
        id = $('#idperan').val();
        menu = $('#menuperan option:checked').val();
        $('#btnSaveDetail').html("<i class='fa fa-circle-o-notch fa-spin'></i>");
        $.post('{{ url('peran') }}/'+id+'/update',{"_token": "{{ csrf_token() }}","menu":menu},function(data){
            $('#btnSaveDetail').html('<i class="fa fa-save"></i>');
            $('#detailPeran').modal('hide');
            detail(id);
        });
    }
    function deletemenu(id)
    {
        if(confirm('Menu akan dihapus?'))
        {
            ids = $('#idperan').val();
            $.post('{{ url('peran') }}/'+ids+'/hapusmenu/'+id,{"_token": "{{ csrf_token() }}"},function(data){
                if(data=='Berhasil')
                {
                    detail(ids);
                }
            })
        }
    }
</script>
@endpush
