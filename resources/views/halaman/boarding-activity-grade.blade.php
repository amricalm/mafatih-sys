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
                        <a href="#" data-toggle="modal" data-target="#tambahItemModal" class="btn btn-sm btn-neutral mr-2"><i class="fa fa-plus"></i> Periode</a>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $rows)
                                    <tr>
                                        @php
                                        $periode = \App\SmartSystem\General::periode($rows->periode);
                                        @endphp
                                        <td class="text-wrap">{{ $periode }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-warning btn-sm text-white" onclick="show_item({{ $rows->periode }})" id="btnEdit"><i class="fas fa-pen"></i> Edit</button>
                                            <button type="button" class="btn btn-default btn-sm text-white" onclick="hapusActivity({{ $rows->periode }})" id="btnDelete"><i class="fas fa-trash"></i> Hapus</button>
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
<div class="modal fade" id="tambahItemModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTambahItemModal" name="formTambahItemModal" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" id="modelItemHeading">Tambah Pemetaan Kegiatan Santri per Bulan</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_item" id="id_item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="periode" class="control-label">Periode</label>
                                <div>
                                    <input type="text" class="form-control datepicker" name="periode" autocomplete="off" placeholder="Sep 1999" id="periode" required>
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
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($activityItem as $key=>$actItem)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1">{{ $key + 1 }}</div>
                                                <div class="col-md-9"><label for="e_item_check{{ $actItem['id'] }}">{{ $actItem['name'] }}</label></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-md-2 text-right">
                                                @if ($actItem['bypass']==0)
                                                    <input type="number" class="form-control form-control-sm" name="item[{{$actItem['id']}}]" id="item{{$actItem['id']}}" style="width:60px" min="0" max="100">
                                                @else
                                                    <input type="hidden" class="form-control form-control-sm" name="item[{{$actItem['id']}}]" id="item{{$actItem['id']}}" style="width:60px" min="0" max="100">
                                                @endif
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
                    <h4 class="modal-title" id="modelHeading">Edit Pemetaan Kegiatan Santri per Bulan</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="periode" class="control-label">Periode</label>
                                <div>
                                    <input type="hidden" class="form-control datepicker" id="old_periode" name="old_periode" maxlength="50" required="" autocomplete="off">
                                    <input type="text" class="form-control datepicker" id="e_periode" name="periode" maxlength="50" required="" autocomplete="off">
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
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($activityItem as $key=>$item)
                                    <input type="hidden" class="form-control form-control-sm checkItemEdit" name="gradeId[{{$item['id']}}]" id="e_gradeId{{$item['id']}}" style="width:60px" min="0" max="100">
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1">{{ $key + 1 }}</div>
                                                <div class="col-md-9"><label for="e_item_check{{ $item['id'] }}">{{ $item['name'] }}</label></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-md-2 text-right">
                                                @if ($item['bypass']==0)
                                                    <input type="number" class="form-control form-control-sm checkItemEdit" name="item[{{$item['id']}}]" id="e_item{{$item['id']}}" style="width:60px" min="0" max="100">
                                                @else
                                                    <input type="hidden" class="form-control form-control-sm checkItemEdit" name="item[{{$item['id']}}]" id="e_item{{$item['id']}}" style="width:60px" min="0" max="100">
                                                @endif
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
                    <button type="submit" class="btn btn-primary" id="updateItem"><i class="fa fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('js')
<script type="text/javascript">
    function show_item(id) {
        $.get("{{ url('pemetaankegiatansantri') }}/" + id + '/edit',
            function(data) {
                data = jQuery.parseJSON(data);
                const dataperiode = data.periode;
                const srtperiode = dataperiode.slice(0,4)+'-'+dataperiode.slice(4,6);
                const dateperiode = new Date(srtperiode);
                var periode = dateperiode.toLocaleDateString('dsb-DE', {
                    year: 'numeric',
                    month: 'short',
                });
                $('#e_periode').val(periode);
                $('#old_periode').val(data.periode);
                $('.checkItemEdit').each(function(j, obj) {
                    idItem = $(this).attr('id');
                    idItem = idItem.split('e_item')[1];
                    $.each(data.detailItem, function(j, datas) {
                        if (datas.id == idItem) {
                            $('#e_item'+ idItem).val(datas.memberItem);
                            $('#e_gradeId'+ idItem).val(datas.gradeId);
                        }
                    });
                });
                $('#editItemModal').modal('show');
        });
    }

    // Simpan Rincian Aktifitas Santri
    $('#simpanItem').click(function(e) {
        e.preventDefault();
        periode = $('#periode').val();
        if(periode=='')
        {
            alert('Mohon isi periode!');
            return;
        }
        var el = $(this);
        el.addClass('disabled');
        el.html("<i class='fa fa-spinner fa-spin'></i> Sedang proses ...");

        $.ajax({
            data: $('#formTambahItemModal').serialize(),
            url: "{{ url('pemetaankegiatansantri/simpan') }}",
            type: 'POST',
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
        periode = $('#e_periode').val();
        if(periode=='')
        {
            alert('Mohon isi periode!');
            return;
        }
        var el = $(this);
        el.addClass('disabled');
        el.html("<i class='fa fa-spinner fa-spin'></i> Sedang proses ...");

        $.ajax({
            data: $('#formEditItemModal').serialize(),
            url: "{{ url('pemetaankegiatansantri/update') }}",
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

    function hapusActivity(id) {
        if (confirm('Yakin akan dihapus?')) {
            $.get("{{ url('pemetaankegiatansantri') }}/" + id + '/hapus',
                function(data) {
                    if (data == 'Berhasil') {
                        window.location.href = "{{ url('pemetaankegiatansantri') }}";
                    } else {
                        msgError('Ada kesalahan. ' + data);
                    }
                })
        }
    }
</script>
<script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
        $('.datepicker').datepicker({
            autoclose: true,
            format: "M yyyy",
            viewMode: "months",
            minViewMode: "months",
            zIndexOffset: 999
        });
</script>
@endpush
