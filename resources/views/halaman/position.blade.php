@extends('layouts.app')

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
                        <a href="#" data-toggle="modal" data-target="#tambahModal" class="btn btn-sm btn-neutral mr-2"><i class="fa fa-plus"></i> Tambah</a>
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
                                    <th>No</th>
                                    <th>Nama {{ $judul }}</th>
                                    <th>Nama {{ $judul }} dalam Arabic</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($position as $key=>$rows)
                                    <tr>
                                        <td class="text-wrap">{{ $key + 1 }}</td>
                                        <td class="text-wrap">{{ $rows->name }}</td>
                                        <td class="text-wrap">{{ $rows->name_ar }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-warning btn-sm text-white" onclick="show({{ $rows->id }})" id="btnEdit"><i class="fas fa-pen"></i> Edit</button>
                                            <button type="button" class="btn btn-default btn-sm text-white" onclick="hapus({{ $rows->id }})" id="btnDelete"><i class="fas fa-trash"></i> Hapus</button>
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

<!-- Add Modal -->
<div class="modal fade" id="tambahModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTambahModal" name="formTambahModal" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title" id="modelItemHeading">Tambah {{ $judul }}</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Nama {{ $judul }}</label>
                                <div>
                                    <input type="text" class="form-control" name="name" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_ar" class="control-label">Nama {{ $judul }} dalam Arabic</label>
                                <div>
                                    <input type="text" class="form-control arabic text-right" name="name_ar" autocomplete="off" required>
                                </div>
                            </div>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditModal" name="formEditModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Edit {{ $judul }}</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="e_id" name="id" required>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="e_name" class="control-label">Nama {{ $judul }}</label>
                                <div>
                                    <input type="text" class="form-control" id="e_name" name="name" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="e_name_ar" class="control-label">Nama {{ $judul }} dalam Arabic</label>
                                <div>
                                    <input type="text" class="form-control arabic text-right" id="e_name_ar" name="name_ar" autocomplete="off" required>
                                </div>
                            </div>
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
    function show(id) {
        $.get("{{ url('posisi') }}/" + id + '/edit',
            function(datas) {
                data = jQuery.parseJSON(datas);
                $('#e_id').val(data.id);
                $('#e_name').val(data.name);
                $('#e_name_ar').val(data.name_ar);
                $('#editModal').modal('show');
        });
    }

    // Simpan Rincian Aktifitas Santri
    $('#simpanItem').click(function(e) {
        e.preventDefault();
        $(this).html('Simpan');

        $.ajax({
            data: $('#formTambahModal').serialize(),
            url: "{{ url('posisi/simpan') }}",
            type: 'POST',
            dataType: 'text',
            success: function(data) {
                msgSukses('Berhasil simpan');
                // $('#formTambahModal').reset();
                $('#tambahModal').modal('dispose');
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
            data: $('#formEditModal').serialize(),
            url: "{{ url('posisi/update') }}",
            type: "POST",
            dataType: 'text',
            success: function(data) {
                msgSukses('Berhasil update');
                // $('#formEditModal').reset();
                $('#editModal').modal('dispose');
                location.reload();
            },
            error: function(data) {
                msgError('Ada kesalahan. ' + data);
            }
        });
    });

    function hapus(id) {
        if (confirm('Yakin akan dihapus?')) {
            $.get("{{ url('posisi') }}/" + id + '/hapus',
                function(data) {
                    if (data == 'Berhasil') {
                        window.location.href = "{{ url('posisi') }}";
                    } else {
                        msgError('Ada kesalahan. ' + data);
                    }
                })
        }
    }
</script>
@endpush
