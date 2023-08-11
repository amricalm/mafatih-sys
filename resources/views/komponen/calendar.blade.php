@push('css')
    <link rel="stylesheet" href="{{ asset('argon/vendor/fullcalendar/lib/main.min.css') }}">
@endpush
@push('js')
    <script src="{{ asset('argon/vendor/fullcalendar/lib/main.min.js') }}"></script>
    <script>
        $(function() {
            $('#calendar').fullCalendar({
                dayClick: function() {
                    alert('a day has been clicked!');
                }
            });
        });
    </script>
@endpush
