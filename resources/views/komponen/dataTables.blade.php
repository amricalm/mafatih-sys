@component('layouts.widgets')
@slot('header')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}">
@endslot
@slot('footer')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>
<script>
    // $(document).ready(function() {
    //     $('.data-table').DataTable({
    //         "pageLength": 50,
    //         "language": {
    //             "paginate": {
    //                 "previous": "&lt;",
    //                 "next": "&gt;"
    //             },
    //         }
    //     } );
    // } );
</script>
@endslot
@endcomponent
