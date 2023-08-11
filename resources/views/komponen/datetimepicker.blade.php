@push('css')
    {{-- <link href="{{ asset('assets/vendor/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    {{-- <script src="{{ asset('assets/vendor/moment.min.js') }}" type="text/javascript"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script> --}}
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script>
        $(function() {
            $('#n_entry_timestamp').datetimepicker({
                footer: true,
                modal: true,
                format: 'yyyy-mm-dd HH:MM',
                uiLibrary: 'bootstrap4',
            });
            $('#n_exit_timestamp').datetimepicker({
                footer: true,
                modal: true,
                format: 'yyyy-mm-dd HH:MM',
                uiLibrary: 'bootstrap4',
            });
        });
    </script>
@endpush
