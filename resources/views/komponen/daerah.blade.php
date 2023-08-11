@push('js')
<script>
    function onChangeSelect(url, id, name) {
        // send ajax request to get the cities of the selected province and append to the select tag
        $.ajax({
            url: url
            , type: 'GET'
            , data: {
                id: id
            }
            , success: function(data) {
                $('#' + name).empty();
                $('#' + name).append('<option> - Pilih Salah Satu - </option>');
                $.each(data, function(key, value) {
                    $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }
    $(function() {
        $('#provinsi').on('change', function() {
            onChangeSelect('{{ route("kota") }}', $(this).val(), 'kota');
        });
        $('#kota').on('change', function() {
            onChangeSelect('{{ route("kec") }}', $(this).val(), 'kecamatan');
        })
        $('#kecamatan').on('change', function() {
            onChangeSelect('{{ route("desa") }}', $(this).val(), 'desa');
        })
    });

</script>
@endpush
