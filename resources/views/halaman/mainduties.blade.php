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
                            <li class="breadcrumb-item" aria-current="page">{{ $judul }}</li>
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
                        <div class="col-md-4">
                            <div class="form-group input-group-sm focused">
                                <label class="form-control-label" for="religion">Posisi</label>
                                <select id="position" class="form-control">
                                    <option value="">Semua</option>
                                    @foreach($position as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <table class="table table-responsive table-striped data-table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Posisi</th>
                                    <th scope="col">Tugas Pokok & Fungsi</th>
                                    <th scope="col">Opsi</th>
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
                                        <label for="hrpid" class="control-label">Posisi</label>
                                        <div>
                                            <select name="hrpid" id="hrpid" class="form-control">
                                                @foreach($position as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Tugas Pokok & Fungsi</label>
                                        <div>
                                            <textarea id="desc" name="desc" required="" class="form-control" rows="8"></textarea>
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
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
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

        var i = 1;
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            paging: true,
            "language": {
                    "paginate": {
                        "previous": "&lt;",
                        "next": "&gt;"
                    },
                },

            ajax: {
                url: "{{ route('tupoksi.filter') }}",
                data: function(d) {
                    d.position = $('#position').val(),
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [{
                "render": function() {
                    return i++;
                }
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'desc',
                name: 'desc'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: "text-right"
            }],
            columnDefs: [{
                "searchable": false,
                "orderable": false,
                "targets": 0,
                render: function(data, type, full, meta) {
                    return "<div style='white-space:normal;'>" + data + "</div>";
                },
                targets: 2
            }],
            order: [
                [1, 'asc']
            ]
        });

        $('#position').change(function() {
            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

        $('#createNew').click(function() {
            $('#saveBtn').val("create");
            $('#id').val('');
            $('#hrpid').attr("style", "pointer-events: auto;");
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
                $('#hrpid').attr("style", "pointer-events: none;");
                $('#id').val(data.id);
                $('#hrpid').val(data.hrpid);
                $('#desc').val(data.desc);
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
                                'Deleted!', '{{ $judul }} sudah dihapus', 'success'
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
