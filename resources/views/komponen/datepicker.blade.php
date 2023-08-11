@push('css')
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
@endpush
@push('js')
    <script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            'setDate': new Date(), autoclose: true, format: 'yyyy-mm-dd', todayHighlight: true, zIndexOffset: 999,
        });
    </script>
@endpush
