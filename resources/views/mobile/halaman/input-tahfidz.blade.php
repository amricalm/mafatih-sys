@extends('mobile.template')

@section('content')
    <div class="main-container">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col align-self-center">
                            <h6 class="float-left">Input Nilai Tahfidz</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="frmSimpan">
                                @csrf
                                <div class="form-group input-group-sm">
                                    <label class="form-control-label" for="date">Tanggal</label>
                                    <input type="date" name="date" class="form-control" value="{{ $dates }}" required>
                                </div>
                                <div class="form-group input-group-sm">
                                    <label class="form-control-label" for="name">Siswa</label>
                                    <select class="form-control select2" name="name" id="name" required>
                                        <option value=""></option>
                                        @foreach ($student as $rows)
                                        <option value="{{ $rows->id }}">{{ $rows->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group input-group-sm">
                                    <label class="form-control-label" for="page">Halaman</label>
                                    <input type="text" name="page" id="page" class="form-control" autocomplete="off" required>
                                </div>
                                <div class="form-group input-group-sm">
                                    <label class="form-control-label" for="line">Baris</label>
                                    <input type="text" name="line" id="line" class="form-control" autocomplete="off" required>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group input-group-sm text-right">
                                        <button type="button" class="btn btn-block btn-default rounded" id="submit"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $('#submit').click(function() {
        forms = $('#frmSimpan').serialize();
        $.post('{{ route('tahfidz.exec') }}',{"_token": "{{ csrf_token() }}","data":forms},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Tahfidz berhasil disimpan!');
            }
            else{
                msgError(datas);
            }
        });
    });
</script>
@endpush

