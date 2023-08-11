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
                            <li class="breadcrumb-item active" aria-current="page">{{ $judul }}</li>
                        </ol>
                    </nav>
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
                                    <th>Kelas</th>
                                    <th>Wali Kelas</th>
                                    <th>Nama Dalam Arabic</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
                data: 'class',
                name: 'class'
            }, {
                data: 'homeroom',
                name: 'homeroom'
            }, {
                data: 'name_ar',
                name: 'name_ar'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: "text-right"
            }, ]
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
            window.location = '{{ url('walikelas') }}/' + id + '/edit';

        });
    });
</script>
@endpush
