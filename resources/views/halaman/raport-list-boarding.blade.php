@extends('layouts.app')
@include('komponen.daerah')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __($judul) }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="employe">Musyrif Sakan</label>
                                            <select name="employe" id="employe" class="form-control form-control-sm" required>
                                                <option value=""> - Pilih salah satu - </option>
                                                @foreach($employe as $key => $value)
                                                    <option value="{{ $value['id'] }}"{{ ($value['id']==$req->employe)?' selected="selected"':'' }}>{{ $value['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-warning btn-sm" id="filter"><i class="fa fa-filter"></i> Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-12 table-responsive">
                                @if(!empty($student))
                                <form id="frmSimpan" name="frmSimpan">
                                    @csrf
                                    <input type="hidden" name="ccid" value="{{ $req->employe }}">
                                    <table class="table table-stripe">
                                        <thead>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th width="30%">Nama</th>
                                                <th width="30%" class="text-right">Nama Dalam Arabic</th>
                                                <th class="text-right">Pengasuhan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; @endphp
                                            @foreach($student as $key => $value)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td><a href="{{ url('siswa/'.$value->pid.'/view') }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Lihat Profil {{ $value['name'] }}">{{ $value['name'] }}</a></td>
                                                    <td><a class="arabic float-right" href="{{ url('siswa/'.$value->pid.'/view') }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Lihat Profil {{ $value['name_ar'] }}">{{ $value['name_ar'] }}</a></td>
                                                    <td>
                                                        @if(isset($value['pengasuhan']))
                                                            <a href="{{ url('raport/'.$value['id'].'/2/print') }}" class="btn btn-sm btn-primary float-right" target="_blank"><i class="fa fa-print"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    // $('#class').change(function(){
    //     id = $(this).val();
    //     $.post('{{ url('pemetaanpelajaran') }}/'+id+'/darikelas',{"_token": "{{ csrf_token() }}"},function(data){
    //         if(data !== null)
    //         {
    //             data = jQuery.parseJSON(data);
    //             $('#subject option:not(:first)').remove();
    //             $.each(data,function(i, datas){
    //                 $('#subject').append($('<option>',{value:datas.id,text:datas.name}));
    //             });
    //         }
    //     });
    // });
    $('#btnSave').click(function(){
        frm = $('#frmSimpan').serialize();
        $.post('{{ url('inputnilai/simpan') }}',{"_token": "{{ csrf_token() }}",'data':frm},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Penilaian berhasil disimpan');
            }
            else
            {
                msgError($data);
            }
        });
    });
</script>
@endpush
