@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.emojipicker')

@push('css')
<style>
    div.kecil{
        max-width: 500px;
        word-break: break-all;
        white-space: normal;
    }
</style>
@endpush
@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('tahunajaran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#ajaxModel" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="py-4">
                    <div class="container table-responsive">
                        <table class="table datatables">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Pesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notif as $ky=>$vl)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-auto">
                                                @if ($vl->notif_datetime!=null)
                                                <span class="badge badge-primary"><i class="fas fa-check-circle"></i></span>
                                                @else
                                                <a href="{{ url('konfigurasi/notif_android/'.$vl->id.'/kirim') }}" class="btn btn-primary btn-sm"> Kirim</a>
                                                <a href="{{ url('konfigurasi/notif_android/'.$vl->id.'/edit') }}" class="btn btn-primary btn-sm"> Edit</a>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <div class="kecil"><b>{{ $vl->notif_title }}</b></div>
                                                <div class="kecil">{{ $vl->notif_datetime }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="kecil">{{ $vl->notif_message }}</div>
                                        @if ($vl->notif_url!='')
                                        <div class="kecil">Link : <a href="{{ $vl->notif_url }}" target="_blank">{{ $vl->notif_url }}</a></div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="5">{{ $notif->links() }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form" name="form" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Tambah Notif Android</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="title" class="control-label">Judul</label>
                        <div class="emoji-picker-container">
                            <input type="text" class="form-control" id="title" name="title" value="" maxlength="50" required="" data-emojiable="true">
                        </div>
                    </div>
                    <div class="form-group pesan">
                        <label for="message" class="control-label">Pesan</label>
                        <div class="emoji-picker-container">
                            <textarea id="message" name="message" class="form-control" style="height:300px" rows="10" data-emojiable="true" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url" class="control-label">URL</label>
                        <div>
                            <input type="url" id="url" name="url" required="required" class="form-control" placeholder="https://www.youtube.com/watch?v=oedj8yq-I-U"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="simpankirim()" class="btn btn-primary" id="saveBtn" value="create"><i class="fas fa-paper-plane"></i> Simpan & Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    function simpankirim()
    {
        judul = $('#title').val();
        if(judul==''||judul==' '||judul=='0'||judul=='-')
        {
            alert('Judul mohon untuk diisi!')
        }
        pesan = $('#message').val();
        if(pesan==''||pesan==' '||pesan=='0'||pesan=='-')
        {
            alert('Pesan mohon untuk diisi!');
        }
        form = $('#form').serialize();
        $.post(
            '{{ url('konfigurasi/notif-android/simpan') }}',
            {"_token": "{{ csrf_token() }}",data:form},
            function(data)
            {
                if(data=='Berhasil')
                {
                    location.href="{{ url()->current() }}"
                }
            }
        );
    }
</script>
@endpush
