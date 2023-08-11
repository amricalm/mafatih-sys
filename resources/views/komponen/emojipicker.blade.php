@push('css')
    <link href="{{ asset('assets/vendor/emoji-picker-main/lib/css/emoji.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script src="{{ asset('assets/vendor/emoji-picker-main/lib/js/config.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/emoji-picker-main/lib/js/util.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/emoji-picker-main/lib/js/jquery.emojiarea.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/emoji-picker-main/lib/js/emoji-picker.min.js') }}"></script>
    <script>
    $(function() {
        window.emojiPicker = new EmojiPicker({
        emojiable_selector: '[data-emojiable=true]',
        assetsPath: '{{ asset('assets/vendor/emoji-picker-main/lib/img/') }}',
        popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
    });
    </script>
@endpush
