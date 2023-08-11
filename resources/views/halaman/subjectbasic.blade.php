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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('matapelajaran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" data-toggle="modal" data-target="#tambahModal" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
                        {{-- @if($data->isEmpty() && $activeAy > 1) --}}
                            {{-- <button id="copy" class="btn btn-sm btn-danger"><i class="fa fa-copy"></i> Copy dari {{ $prevAy[0]->name }}</button> --}}
                        {{-- @endif --}}
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
                                    <th>Level</th>
                                    <th>Nama Grup</th>
                                    <th>Nama Grup Arabic</th>
                                    <th>Mata Pelajaran</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($basic as $item)
                                @php
                                $member = ''; $no=0;
                                foreach($data as $items)
                                {
                                    if($items['id']==$item->id)
                                    {
                                        $member .= ($no!=0) ? ', '.$items['member'] : $items['member'];
                                        $no++;
                                    }
                                }
                                $memberen = ''; $no=0;
                                foreach($data as $items)
                                {
                                    if($items['id']==$item->id)
                                    {
                                        $memberen .= ($no!=0) ? ', '.$items['member_en'] : $items['member_en'];
                                        $no++;
                                    }
                                }
                                $memberar = ''; $no=0;
                                foreach($data as $items)
                                {
                                    if($items['id']==$item->id)
                                    {
                                        $memberar .= ($no!=0) ? ', '.$items['member_ar'] : $items['member_ar'];
                                        $no++;
                                    }
                                }
                                @endphp
                                <tr>
                                    <td>{{ $item->level }}</td>
                                    <td>{{ $item->name_group }}</td>
                                    <td class="arabic text-right">{{ $item->name_group_ar }}</td>
                                    <td><p class="text-wrap">{{ $member }}<br>{{ $memberen }}<!--<br><div class="arabic">{{ $memberar }}</div>--></p></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-warning btn-sm text-white" onclick="show({{ $item->id }})" id="btnEdit"><i class="fas fa-pen"></i> Edit</button>
                                        <button type="button" class="btn btn-default btn-sm text-white" onclick="hapus({{ $item->id }})" id="btnDelete"><i class="fas fa-trash"></i> Hapus</button>
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
<div class="modal fade" id="tambahModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTambahModal" name="formTambahModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Mata Pelajaran</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="level" class="control-label">Level</label>
                                <div>
                                    <select name="level" id="level" class="form-control">
                                        @foreach($level as $kl=>$vl)
                                        <option  value="{{ $vl->level }}">Level {{ $vl->level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Nama Grup</label>
                                <div>
                                    <input type="text" class="form-control" id="name_group" name="name_group" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_ar" class="control-label">Nama Grup dalam Arab</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="name_group_ar" name="name_group_ar" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12 table-responsive">
                            <table class="table datatablesnopage">
                                <thead>
                                    <tr>
                                        <th>Tambah Mata Pelajaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($subject as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-2"><input class="checkadd" name="subjectbasic[]" id="check{{ $item->id }}" type="checkbox"  value="{{ $item->id }}"></div>
                                                <div class="col-md-10"><label for="check{{ $item->id }}">{{ $item->name }}</label></div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditModal" name="formEditModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Mata Pelajaran</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="eid" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="elevel" class="control-label">Level</label>
                                <div>
                                    <select name="level" id="elevel" class="form-control">
                                        @foreach($level as $kl=>$vl)
                                        <option  value="{{ $vl->level }}">Level {{ $vl->level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Nama Grup</label>
                                <div>
                                    <input type="text" class="form-control" id="ename" name="name_group" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_ar" class="control-label">Nama Grup dalam Arab</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="ename_ar" name="name_group_ar" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12 table-responsive">
                            <table class="table datatablesnopage">
                                <thead>
                                    <tr>
                                        <th>Tambah Mata Pelajaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($subject as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-2"><input class="checkedit" name="subjectbasic[]" id="echeck{{ $item->id }}" type="checkbox" value="{{ $item->id }}"  ></div>
                                                <div class="col-md-10"><label for="echeck{{ $item->id }}">{{ $item->name }}</label></div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="update()"><i class="fa fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('css')
<style>
.dataTables_wrapper .dataTables_filter {
    width:100% !important;
    text-align:center !important;
}
</style>
@endpush
@push('js')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function show(id){
        $('.checkedit').each(function(i,obj){
            $(this).removeAttr('checked');
        })
        $('#editModal').modal('show');
        $.get('{{ url('muatanpelajaran') }}/'+id+'/edit',function(data){
            data = jQuery.parseJSON(data);
            $('#eid').val(data.id);
            $('#elevel option[value='+data.level+']').attr('selected','selected');
            $('#ename').val(data.name_group);
            $('#ename_ar').val(data.name_group_ar);
            $.each(data.detail,function(i, datas){
                $('#echeck'+datas.idmember).attr('checked','checked');
            });
        });
    }
    function tambah()
    {
        var data = $('#formTambahModal').serialize();
        $.post('{{ url('muatanpelajaran/simpan') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil simpan');
                $('#tambahModal').modal('dispose');
                location.reload();
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
        $.post('{{ url('muatanpelajaran/update') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil update');
                $('#editModal').modal('hide');
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
            $.get('{{ url('muatanpelajaran') }}/'+id+'/hapus',function(data){
                if(data=='Berhasil')
                {
                    window.location.href = '{{ url('muatanpelajaran') }}';
                }
                else
                {
                    msgError('Ada kesalahan. '+data);
                }
            })
        }
    }

    $('#copy').click(function(e) {
        if (confirm('Yakin akan mengcopy grup mata pelajaran dari tahun sebelumnya?')) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('muatanpelajaran/copy') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    msgSukses('Kelas Berhasil di Copy');
                    $('#copy').css("display", "none");
                    location.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
    });
</script>
@endpush
