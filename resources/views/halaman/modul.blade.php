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
                        <a href="#" id="createNew" class="btn btn-sm btn-neutral" data-toggle="modal"
                            data-target="#tambahMenu"><i class="fa fa-plus"></i> Tambah Modul</a>
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
                                    <th>No.</th>
                                    <th>Nama Modul</th>
                                    <th>Deskripsi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=0; @endphp
                                @foreach($menu as $key => $value)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->desc }}</td>
                                    <td class="text-right">
                                        <a href="javascript:detail({{ $value->id }},'')"
                                            class="btn btn-primary btn-sm text-white" id="btnDetail"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Detail {{ $value->name }}"><i class="fas fa-search"></i></a>
                                        <a href="javascript:edit({{ $value->id }})"
                                            class="btn btn-warning btn-sm text-white" id="btnEdit" data-toggle="tooltip"
                                            data-placement="top" title="Edit {{ $value->name }}"><i
                                                class="fas fa-pen"></i></a>
                                        <a href="javascript:hapus({{ $value->id }})"
                                            class="btn btn-default btn-sm text-white"
                                            onclick="return confirm('Yakin akan dihapus?')" id="btnDelete"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Hapus {{ $value->name }}"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @php
                                    $no++;
                                    $menumodul = $modul->where('modul_id',$value->id);
                                    if(count($menumodul)>0)
                                    {
                                        echo '<tr>';
                                        echo '<td colspan="4"><div class="row" id="tr'.$value->id.'">';
                                        foreach($menumodul as $kk=>$vv)
                                        {
                                            echo '<div class="col-md-3" style="padding:5px;"><button type="button" class=""><div><i class="'.$vv['menu_icon'].'"></i> <span>'.$vv['menu'].'</span></div></button></div>';
                                        }
                                        echo '</div></td>';
                                        echo '</tr>';
                                    }
                                @endphp
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
<div class="modal fade" id="tambahMenu" tabindex="-1" role="dialog" aria-labelledby="labelTambahMenu"
    aria-hidden="true">
    <form id="form">
        <input type="hidden" id="idmodul" name="id">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelTambahMenu">Tambah Modul</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Nama Modul</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nama Modul">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="desc" class="col-sm-4 col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="desc" id="desc" placeholder="Deskripsi Modul">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Keluar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal -->
<div class="modal fade" id="detailModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title" id="modul_name"></h5>
                        <p class="card-text" id="modul_desc"></p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width:15%">icon</th>
                                <th style="width:50%">Nama Menu</th>
                                {{-- <th style="width:15%">Urutan</th> --}}
                                <th style="width:35%">#</th>
                            </tr>
                        </thead>
                        <tbody id="tbodymenu">
                            {{-- @php
                                $menu0 = $menus->where('menu_parent','0');
                                foreach($menu0 as $k=>$v)
                                {
                                    echo '<tr>';
                                    echo '<td><i class="'.$v->menu_icon.'"></i></td>';
                                    echo '<td>'.$v->menu.'</td>';
                                    echo '<td></td>';
                                    echo '</tr>';
                                    $menuanak = $menus->where('menu_parent',$v->id);
                                    if(count($menuanak)>1)
                                    {
                                        echo '<tr>';
                                        echo '<td colspan="3"><ul class="list-group">';
                                        foreach($menuanak as $kk=>$vv)
                                        {
                                            echo '<li class="list-group-item">';
                                            echo '<div class="row">';
                                            echo '<div class="col-md-2"><input type="checkbox" id="chk'.$vv->id.'" name="chk'.$vv->id.'"></div>';
                                            echo '<div class="col-md-6"><i class="'.$vv->menu_icon.'"></i> '.$vv->menu.'</div>';
                                            echo '<div class="col-md-3"><input type="number" class="form-control form-control-sm" id="val'.$vv->id.'" name="val'.$vv->id.'"></div>';
                                            echo '</div></li>';
                                        }
                                        echo '</ul></td>';
                                        echo '</tr>';
                                    }
                                }
                            @endphp --}}

                        </tbody>
                        <tfoot>
                            <form id="frmCheck">
                                <input type="hidden" name="idheader" id="idheader">
                                <tr>
                                    <th colspan="2">
                                        <select name="idmenu" id="idmenu" class="form-control form-control-sm">
                                            <option value=""> - Pilih Salah Satu Menu - </option>
                                            @php
                                            $menufirst = $menus->where('menu_parent','0')->toArray();
                                            foreach($menufirst as $kmf=>$vmf)
                                            {
                                            echo '<optgroup label="'.$vmf['menu'].'">';
                                                $menusecond = $menus->where('menu_parent',$vmf['id'])->unique('menu')->toArray();
                                                foreach($menusecond as $kms=>$vms)
                                                {
                                                    echo '<option value="'.$vms['id'].'">'.$vms['menu'].'</option>';
                                                }
                                                echo '</optgroup>';
                                            }
                                            @endphp
                                        </select>
                                    </th>
                                    <th><button type="button" id="btnTambahBaris" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </form>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closebtn"><i class="fa fa-times"></i> Keluar</button>
                {{-- <button type="button" id="btnSimpan" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-save"></i> Simpan</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $('#createNew').on('click',function(e){
        $('#form').trigger('reset');
        $('#labelTambahMenu').html('Tambah Modul');
        $('#tambahMenu').modal('show');
    });
    $('#closebtn').on('click',function(e){
        location.reload();
    });
    $('#form').on('submit',function(e){
        e.preventDefault();
        frm = $(this).serialize();
        $.post('{{ url('modul/simpan') }}',{"_token": "{{ csrf_token() }}","data":frm},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Modul berhasil disimpan!');
                location.reload();
            }
            else{
                msgError(datas);
            }
        })
    });
    function edit(id)
    {
        $.post('{{ url('modul') }}/'+id+'/edit',{"_token": "{{ csrf_token() }}"},function(data){
            datas = JSON.parse(data);
            $('#idmodul').val(datas.id);
            $('#name').val(datas.name);
            $('#desc').val(datas.desc);
            $('#labelTambahMenu').html('Edit Modul');
            $('#tambahMenu').modal('show')
        });
    }
    function hapus(id)
    {
        $.post('{{ url('modul') }}/'+id+'/hapus',{'_token':'{{ csrf_token() }}'},function(data){
            if(data=='Berhasil')
            {
                location.reload();
            }
        });
    }
    function loaddetail(id,datasdetail,datas)
    {
        no = 0;
        text = '';
        datasdetail.forEach(function(){
            text+='<div class="col-md-3" style="padding:5px;"><button type="button" class=""><div><i class="'+datas.detail[no]['menu_icon']+'"></i> <span>'+datas.detail[no]['menu']+'</span></div></button></div>';
            no++;
        });
        text += '';
        $('#tr'+id).html(text);
    }
    function detail(id,opt)
    {
        $.post('{{ url('modul') }}/'+id+'/detail',{"_token": "{{ csrf_token() }}"},function(data){
            datas = JSON.parse(data);
            $('#idheader').val(id);
            $('#exampleModalLabel').html('Menu pada Modul');
            $('#modul_name').html(datas.header.name);
            $('#modul_desc').html(datas.header.desc);
            var datasdetail = Object.entries(datas.detail);
            var no = 0;
            var text = '';
            datasdetail.forEach(function(){
                text += '<tr>';
                text += '<td><i class="'+datas.detail[no]['menu_icon']+'"></i></td>';
                text += '<td>'+datas.detail[no]['menu']+'</td>';
                // text += '<td>'+datas.detail[no]['seq']+'</td>';
                // text += '<td><div class="btn-group" role="group" aria-label="First group"><button type="button" onclick="turun('+datas.detail[no]['menu_id']+','+datas.detail[no]['modul_id']+')" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-down"></i></button><button type="button" onclick="naik('+datas.detail[no]['id']+','+datas.detail[no]['modul_id']+')" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-up"></i></button><button type="button" onclick="hapusdetail('+datas.detail[no]['id']+','+datas.detail[no]['modul_id']+')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></div></td>';
                text += '<td><div class="btn-group" role="group" aria-label="First group"><select id="id'+datas.detail[no]['id']+'ids'+datas.detail[no]['modul_id']+'" class="form-control form-control-sm">';
                for(i=0;i<20;i++)
                {
                    slctd = (datas.detail[no]['seq']==i) ? 'selected="selected"' : '';
                    text += '<option value="'+i+'" '+slctd+'>'+i+'</option>';
                }
                text += '</select><button type="button" onclick="pindahdetail('+datas.detail[no]['id']+','+datas.detail[no]['modul_id']+')" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button><button type="button" onclick="hapusdetail('+datas.detail[no]['id']+','+datas.detail[no]['modul_id']+')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></div></td>';
                text += '</tr>';
                $('#chk'+datas.detail[no]['id']).prop('checked',true);
                $('#val'+datas.detail[no]['id']).val(datas.detail[no]['seq']);
                no++;
            });
            $('#tbodymenu').html(text);
            if(opt=='')
            {
                $('#detailModel').modal('show')
            }
            loaddetail(id,datasdetail,datas);
        });
    }
    $('#btnTambahBaris').on('click',function(){
        frm = $('#frmCheck').serialize();
        slc = $('#idmenu').val();
        idh = $('#idheader').val();
        if(slc=='')
        {
            alert('Pilih Menu');
            return;
        }
        $.post('{{ url('modul/simpandetail') }}',{"_token": "{{ csrf_token() }}",data:frm},function(data){
            if(data=='Berhasil')
            {
                detail(idh,'no');
            }
        });
    });
    function hapusdetail(id,ids)
    {
        $.post('{{ url('modul/hapusdetail') }}',{"_token": "{{ csrf_token() }}",menu_id:id,modul_id:ids},function(data){
            if(data=='Berhasil')
            {
                detail(ids,'no');
            }
        })
    }
    function pindahdetail(id,ids)
    {
        seq = $('#id'+id+'ids'+ids).val();
        $.post('{{ url('modul/pindahdetail') }}',{"_token": "{{ csrf_token() }}",'menu_id':id,'modul_id':ids,seq:seq},function(data){
            if(data=='Berhasil')
            {
                detail(ids,'no');
            }
        })
    }
</script>
@endpush
