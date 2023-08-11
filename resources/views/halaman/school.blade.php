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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('sekolah') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="javascript:void(0)" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
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
                                    <th>Nama Sekolah</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
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
                                        <label for="name" class="control-label">Nama Sekolah</label>
                                        <div>
                                            <input type="text" class="form-control" id="name" name="name" value="" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            "language": {
                    "paginate": {
                        "previous": "&lt;",
                        "next": "&gt;"
                    },
            },
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: "text-right"
                },
            ]
        });

        $('#createNew').click(function() {
            $('#saveBtn').val("create");
            $('#id').val('');
            $('#form').trigger("reset");
            $('#modelHeading').html("Tambah {{ $judul }}");
            $('#ajaxModel').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
            var url = '{{ collect(request()->segments())->last() }}';
            $.get(url + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Edit {{ $judul }}");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#id').val(data.id);
                $('#name').val(data.name);
            })
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Simpan');

            $.ajax({
                data: $('#form').serialize(),
                url: "",
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#form').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Simpan');
                }
            });
        });

        $('body').on('click', '.delete', function() {
            var id = $(this).data("id");
            var url = '{{ collect(request()->segments())->last() }}';
            Swal.fire({
                title: 'Betul akan dihapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url + '/' + id,
                        success: function(data) {
                            Swal.fire(
                                'Deleted!',
                                '{{ $judul }} sudah dihapus',
                                'success'
                            )
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
            })
        });
    });
</script>
@endpush
