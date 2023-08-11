@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
@endpush
@push('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        @if (isset($costumdatatable))
        $(document).ready( function () {
            $('.datatables').DataTable({
                "paging": true,
                "language": {
                    "emptyTable": "Tidak ada data",
                    "info": "Tampil _START_ sampai _END_ dari _TOTAL_ data",
                    "lengthMenu": "Lihat _MENU_ data",
                    "paginate": {
                        "previous": "&lt;",
                        "next": "&gt;"
                    },
                    "search": "Cari :",
                },
                "searching": true,
            });
        } );
        @else
        $(document).ready(function() {
            $('.datatables').DataTable({
                "paging": true,
                "pageLength": {{ config('paging') }},
                "language": {
                    "emptyTable": "Tidak ada data",
                    "info": "Tampil _START_ sampai _END_ dari _TOTAL_ data",
                    "lengthMenu": "Lihat _MENU_ data",
                    "paginate": {
                        "previous": "&lt;",
                        "next": "&gt;"
                    },
                    "search": "Cari :",
                },
                "searching": true,
                "ordering": false,
                "info": false,
            } );
        } );
        @endif
    </script>
@endpush
