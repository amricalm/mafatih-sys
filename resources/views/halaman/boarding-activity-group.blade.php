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
                            <li class="breadcrumb-item active" aria-current="page">{{ $judul }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" data-toggle="modal" data-target="#tambahModal" class="btn btn-sm btn-neutral mr-2"><i class="fa fa-plus"></i> Grup</a>
                        <a href="#" data-toggle="modal" data-target="#tambahItemModal" class="btn btn-sm btn-neutral mr-2"><i class="fa fa-plus"></i> Kegiatan</a>
                        <a href="#" data-toggle="modal" data-target="#tambahRincianItemModal" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Rincian Kegiatan</a>
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
                        <table class="table datatables" id="datatable">
                            <thead>
                                <tr>
                                    <th>Grup</th>
                                    <th>Kegiatan Santri<span class="p-9">Rincian Kegiatan Santri</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group as $rows)
                                    <tr>
                                        <td class="text-wrap arabic"><a href="#" onclick="javascript:show({{ $rows->id }})">{{ $rows->name_ar }}. {{ $rows->seq }}</a></td>
                                        <td>
                                        <table>
                                            @php
                                            $member = array(); $no=0; $p = '';
                                                foreach($data as $items)
                                                {
                                                    $item = ''; $noItem=0;
                                                    $n = '';
                                                    if($items['name_group']==$rows->name)
                                                    {
                                                        $member_id = $items['member_id'];
                                                        $member_item = '<span class="badge badge-info bg-sm">'.$items['type'].'</span> <a href="#" onclick="javascript:show_item('.$member_id.')">'.$items['member'].' .'.$items['member_seq'].'</a>';
                                                        $member[] .= $member_item;
                                                        $no++;

                                                        foreach($dataItem as $activity)
                                                        {
                                                            if($activity['activity_id']==$items['member_id'])
                                                            {
                                                                $nonAktif = isset($activity['non_active']) ? 'text-decoration: line-through' : '';
                                                                $itemId = $activity['activity_id'];
                                                                $item .= ($noItem!=0) ? '</br> '.'<a href="#" onclick="javascript:show_item_dtl('.$activity['member_id'].')" style="'.$nonAktif.'">'.$activity['member_seq'].'. '.$activity['member'].'</a>' : '<a href="#" onclick="javascript:show_item_dtl('.$activity['member_id'].')" style="'.$nonAktif.'">'.$activity['member_seq'].'. '.$activity['member'].'</a>';
                                                                $noItem++;

                                                            }
                                                        }
                                                        echo '<tr><td class="text-wrap arabic">'.$member_item.'</td><td class="text-wrap">'.$item.'</td></tr>';
                                                    }
                                                }
                                            @endphp
                                            </table>
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

<!-- Add Activity Modal -->
<div class="modal fade" id="tambahModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTambahModal" name="formTambahModal" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Tambah Grup Kegiatan Santri</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_ar" class="control-label">Urutan</label>
                                <div>
                                    <input type="number" class="form-control" id="seq" name="seq" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Daftar Kegiatan Santri</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($subject as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-2"><input class="checkadd" name="subjectbasic[]" id="check{{ $item->id }}" type="checkbox" value="{{ $item->id }}"></div>
                                                <div class="col-md-10"><label for="check{{ $item->id }}" class="arabic">{{ $item->name_ar }}</label></div>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm text-white" onclick="hapusActivity({{ $item->id }})" id="btnDelete"><i class="fas fa-trash"></i> Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditModal" name="formEditModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Edit Grup Kegiatan Santri</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="eid" value="">
                    <div class="row">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_ar" class="control-label">Urutan</label>
                                <div>
                                    <input type="number" class="form-control" id="eseq" name="seq" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Daftar Kegiatan Santri</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($subject as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1"><input class="checkedit" name="subjectbasic[]" id="echeck{{ $item->id }}" type="checkbox" value="{{ $item->id }}"></div>
                                                <div class="col-md-11">{{ $item->seq }}. <label for="echeck{{ $item->id }}" class="arabic">{{ $item->name_ar }}</label> ({{ $item->name }})</div>
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
                    <button type="button" class="btn btn-default text-white mr-auto" id="hapus"><i class="fa fa-trash"></i> Hapus</button>
                    <button type="submit" class="btn btn-primary" id="update"><i class="fa fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Activity Modal -->
<div class="modal fade" id="tambahItemModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTambahItemModal" name="formTambahItemModal" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" id="modelItemHeading">Tambah Kegiatan Santri</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_item" id="id_item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="activity_name" class="control-label">Nama Kegiatan</label>
                                <div>
                                    <input type="text" class="form-control" id="activity_name" name="activity_name" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="activity_name_ar" class="control-label">Nama Kegiatan dalam Arab</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="activity_name_ar" name="activity_name_ar" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                <label for="item" class="control-label">Merupakan Item Kegiatan </label>
                                    <input type="checkbox" id="item" name="item" value="ITEM" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Daftar Rincian Kegiatan Santri</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($activityItem as $actItem)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1"><input class="checkaddItem" name="subjectbasic[]" id="checkItem{{ $actItem->id }}" type="checkbox" value="{{ $actItem->id }}"></div>
                                                <div class="col-md-11"><label for="checkItem{{ $actItem->id }}">{{ $actItem->seq }}. {{ $actItem->name }}</label> <span class="pull-right">({{ $actItem->name_ar }})</span></div>
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
                    <button type="submit" class="btn btn-primary" id="simpanItem"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editItemModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditItemModal" name="formEditItemModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Edit Kegiatan Santri</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="e_activity_id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="activity_name" class="control-label">Nama Rincian Kegiatan</label>
                                <div>
                                    <input type="text" class="form-control" id="e_activity_name" name="activity_name" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="activity_name_ar" class="control-label">Nama Rincian Kegiatan dalam Arab</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="e_activity_name_ar" name="activity_name_ar" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="activity_name_ar" class="control-label">Urutan</label>
                                <div>
                                    <input type="number" class="form-control arabic" id="e_seq" name="seq" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                <label for="item" class="control-label">Merupakan Item Kegiatan </label>
                                    <input type="checkbox" id="itemEdit" name="itemEdit" value="ITEM" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Daftar Rincian Kegiatan Santri</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($activityItem as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1"><input class="checkItemEdit" name="activityitem[]" id="e_item_check{{ $item->id }}" type="checkbox" value="{{ $item->id }}"></div>
                                                <div class="col-md-11"><label for="e_item_check{{ $item->id }}">{{ $item->seq }}. {{ $item->name }}</label> ({{ $item->name_ar }})</div>
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
                    <button type="button" class="btn btn-default text-white mr-auto" id="hapusItem"><i class="fa fa-trash"></i> Hapus</button>
                    <button type="submit" class="btn btn-primary" id="updateItem"><i class="fa fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="tambahRincianItemModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTambahRincianItemModal" name="formTambahRincianItemModal" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" id="modelItemHeading">Tambah Rincian Kegiatan Santri</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_item_dtl" id="id_item_dtl">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="item_name" class="control-label">Nama Rincian Kegiatan</label>
                                <div>
                                    <input type="text" class="form-control" id="item_name" name="item_name" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="item_name_ar" class="control-label">Nama Rincian Kegiatan dalam Arab</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="item_name_ar" name="item_name_ar" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="item_seq" class="control-label">Urutan</label>
                                <div>
                                    <input type="number" class="form-control" id="item_seq" name="item_seq" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="simpanRincianItem"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editRincianItemModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditRincianItemModal" name="formEditRincianItemModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Edit Rincian Kegiatan Santri</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="e_item_id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="e_item_name" class="control-label">Nama Rincian Kegiatan</label>
                                <div>
                                    <input type="text" class="form-control" id="e_item_name" name="item_name" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="e_item_name_ar" class="control-label">Nama Rincian Kegiatan dalam Arab</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="e_item_name_ar" name="item_name_ar" value="" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="seq" class="control-label">Urutan</label>
                                <div>
                                    <input type="number" class="form-control" id="e_item_seq" name="item_seq" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="seq" class="control-label"></label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk-aktif" name="aktif" tabindex="17">
                                    <span class="custom-control-label">Non Aktifkan Rincian Kegiatan</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default text-white mr-auto" id="hapusRincianItem"><i class="fa fa-trash"></i> Hapus</button>
                    <button type="submit" class="btn btn-primary" id="updateRincianItem"><i class="fa fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        $('#editModal').on('hide', function() {
            window.location.reload(true);
        });
    });

    // Show Aktifitas Santri
    function show(id) {
        $.get("{{ url('grup-kegiatansantri') }}/" + id + '/edit',
            function(data) {
                data = jQuery.parseJSON(data);
                $('#eid').val(data.id);
                $('#ename').val(data.name);
                $('#ename_ar').val(data.name_ar);
                $('#eseq').val(data.seq);
                $('.checkedit').each(function(i, obj) {
                    yes = 0;
                    id = $(this).attr('id');
                    id = id.split('check')[1];
                    $.each(data.detail, function(i, datas) {
                        if (datas.idmember == id) {
                            yes = 1;
                        }
                    });
                    if (yes == 1) {
                        $('#echeck' + id).prop('checked', true);
                    } else {
                        $('#echeck' + id).prop('checked', false);
                    }
                });

                $('#editModal').modal('show');
            });
    }

    // Simpan Aktifitas Santri
    $('#simpan').click(function(e) {
        e.preventDefault();
        $(this).html('Simpan');

        $.ajax({
            data: $('#formTambahModal').serialize(),
            url: "{{ url('grup-kegiatansantri/simpan') }}",
            type: "POST",
            dataType: 'text',
            success: function(data) {
                msgSukses('Berhasil simpan');
                $('#tambahModal').modal('dispose');
                location.reload();
            },
            error: function(data) {
                msgError('Ada kesalahan. ' + data);
            }
        });
    });

    // Update Aktifitas Santri
    $('#update').click(function(e) {
        e.preventDefault();
        $(this).html('Update');

        $.ajax({
            data: $('#formEditModal').serialize(),
            url: "{{ url('grup-kegiatansantri/update') }}",
            type: "POST",
            dataType: 'text',
            success: function(data) {
                msgSukses('Berhasil update');
                $('#editModal').modal('dispose');
                location.reload();
            },
            error: function(data) {
                msgError('Ada kesalahan. ' + data);
            }
        });
    });

    // Hapus Aktifitas Santri
    $('#hapus').click(function(e) {
        name = $('#ename_ar').val();
        if (confirm('Yakin akan dihapus '+ name +' ?')) {
            id = $('#eid').val();
            $.get("{{ url('grup-kegiatansantri') }}/" + id + '/hapus',
                function(data, status) {
                    if (data == 'Berhasil') {
                        window.location.href = "{{ url('grup-kegiatansantri') }}";
                    } else {
                        msgError('Ada kesalahan. ' + data);
                    }
                })
        }
    });

    document.getElementById('item').onchange = function() {
        @php $no = 1; @endphp
        @foreach($activityItem as $actItem)
            document.getElementById('checkItem{!! $actItem->id !!}').disabled = this.checked;
        @endforeach
    };

    document.getElementById('itemEdit').onchange = function() {
        @php $no = 1; @endphp
        @foreach($activityItem as $actItem)
            document.getElementById('e_item_check{!! $actItem->id !!}').disabled = this.checked;
        @endforeach
    };

    // Show Rincian Aktifitas Santri
    function show_item(id) {
        $.get("{{ url('kegiatansantri') }}/" + id + '/edit',
            function(data) {
                data = jQuery.parseJSON(data);
                $('#e_activity_id').val(data.id);
                $('#e_activity_name').val(data.name);
                $('#e_activity_name_ar').val(data.name_ar);
                $('#e_seq').val(data.seq);
                if(data.type == "ITEM") {
                    $('#itemEdit').prop('checked', true);;
                }

                $('.checkItemEdit').each(function(j, obj) {
                    yes = 0;
                    idItem = $(this).attr('id');
                    idItem = idItem.split('e_item_check')[1];
                    $.each(data.detailItem, function(j, datas) {
                        if (datas.idmemberItem == idItem) {
                            yes = 1;
                        }
                    });
                    if (yes == 1) {
                        $('#e_item_check' + idItem).prop('checked', true);
                    } else {
                        $('#e_item_check' + idItem).prop('checked', false);
                    }
                });

                $('#editItemModal').modal('show');
            });
    }

    // Simpan Rincian Aktifitas Santri
    $('#simpanItem').click(function(e) {
        e.preventDefault();
        $(this).html('Simpan');

        $.ajax({
            data: $('#formTambahItemModal').serialize(),
            url: "{{ url('kegiatansantri/simpan') }}",
            type: "POST",
            dataType: 'text',
            success: function(data) {
                msgSukses('Berhasil simpan');
                $('#tambahItemModal').modal('dispose');
                location.reload();
            },
            error: function(data) {
                msgError('Ada kesalahan. ' + data);
            }
        });
    });

    // Update Rincian Aktifitas Santri
    $('#updateItem').click(function(e) {
        e.preventDefault();
        $(this).html('Update');

        $.ajax({
            data: $('#formEditItemModal').serialize(),
            url: "{{ url('kegiatansantri/update') }}",
            type: "POST",
            dataType: 'text',
            success: function(data) {
                msgSukses('Berhasil update');
                $('#editItemModal').modal('dispose');
                location.reload();
            },
            error: function(data) {
                msgError('Ada kesalahan. ' + data);
            }
        });
    });

    // Hapus Rincian Aktifitas Santri
    $('#hapusItem').click(function() {
        name = $('#e_activity_name_ar').val();
        if (confirm('Yakin akan dihapus '+ name +' ?')) {
            id = $('#e_activity_id').val();
            $.get("{{ url('kegiatansantri') }}/" + id + '/hapus',
                function(data) {
                    if (data == 'Berhasil') {
                        window.location.href = "{{ url('grup-kegiatansantri') }}";
                    } else {
                        msgError('Ada kesalahan. ' + data);
                    }
                })
        }
    });

    // Show Rincian Kegiatan Santri
    function show_item_dtl(id) {
        $.get("{{ url('item-kegiatansantri') }}/" + id + '/edit',
            function(data) {
                data = jQuery.parseJSON(data);
                $('#e_item_id').val(data.id);
                $('#e_item_name').val(data.name);
                $('#e_item_name_ar').val(data.name_ar);
                $('#e_item_seq').val(data.seq);
                $("#chk-aktif").prop('checked', (Boolean(Number(data.non_active))));
                $('#editRincianItemModal').modal('show');
            });
    }

    // Simpan Rincian Kegiatan Santri
    $('#simpanRincianItem').click(function(e) {
        e.preventDefault();
        $(this).html('Simpan');

        $.ajax({
            data: $('#formTambahRincianItemModal').serialize(),
            url: "{{ url('item-kegiatansantri/simpan') }}",
            type: "POST",
            dataType: 'text',
            success: function(data) {
                msgSukses('Berhasil simpan');
                $('#tambahRincianItemModal').modal('dispose');
                location.reload();
            },
            error: function(data) {
                msgError('Ada kesalahan. ' + data);
            }
        });
    });

    // Update Rincian Kegiatan Santri
    $('#updateRincianItem').click(function(e) {
        e.preventDefault();
        $(this).html('Update');

        $.ajax({
            data: $('#formEditRincianItemModal').serialize(),
            url: "{{ url('item-kegiatansantri/update') }}",
            type: "POST",
            dataType: 'text',
            success: function(data) {
                msgSukses('Berhasil update');
                $('#editRincianItemModal').modal('dispose');
                location.reload();
            },
            error: function(data) {
                msgError('Ada kesalahan. ' + data);
            }
        });
    });

    // Hapus Rincian Kegiatan Santri
    $('#hapusRincianItem').click(function() {
        name = $('#e_item_name').val();
        if (confirm(name+' Yakin akan dihapus?')) {
            id = $('#e_item_id').val();
            $.get("{{ url('item-kegiatansantri') }}/" + id + '/hapus',
                function(data) {
                    if (data == 'Berhasil') {
                        window.location.href = "{{ url('grup-kegiatansantri') }}";
                    } else {
                        msgError('Ada kesalahan. ' + data);
                    }
                })
        }
    });

</script>
@endpush
