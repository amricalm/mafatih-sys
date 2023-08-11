@extends('layouts.app')
@include('komponen.dataTables')

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
                        <a href="{{ route('studentmutation') }}" class="btn btn-sm btn-neutral"><i class="fa fa-arrows"></i> Proses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
            <form id="frmFilter">
                @csrf
                <div class="card-body row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Tahun Mutasi</label>
                            <div class="col-sm-10">
                                <select name="ayid" id="ayid" class="form-control">
                                    <option value=""> - Pilih Salah Satu - </option>
                                    @foreach ($academicyear as $key=>$val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="button" id="lihat" class="btn btn-primary"><i class="fas fa-info-circle"></i> Lihat</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button class="btn btn-primary" id="btnExport" style="display:none;" data-toggle="collapse" href="#" onclick="eksport()"  role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-file-excel"></i> Export</button>
                    </div>
                </div>
                <div class="card-body table-responsive py-4">
                    <div class="container">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th style="width:20%">#</th>
                                    <th style="width:20%">Nama Lengkap</th>
                                    <th style="width:20%">NIS</th>
                                    <th style="width:20%">NISN</th>
                                    <th style="width:20%">Jenis Kelamin</th>
                                </tr>
                            </thead>
                            <tbody id="bodytable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
@push('js')
<script type="text/javascript">
    $('#lihat').on('click',function(){
        post = $('#ayid option:selected').val();
        if(post==''||post=='0')
        {
            alert('Mohon pilih salah satu tahun kelulusan. Lalu klik tombol Lihat!');
            return;
        }
        showbaris(post);
    })
    function showbaris(id)
    {
        $('#bodytable').html('');
        $.get('{{ url('mutasi') }}/'+id+'/show',function(data){
            $('#bodytable').html(data);
            $('#btnExport').show();
        })
    }
    function eksport()
    {
        // var ayid = $('#ayid option:selected').val();

        // $.post('{{ url('alumni/export') }}',{"_token": "{{ csrf_token() }}",ayid:ayid});


        var ayid = $('#frmFilter').serialize();
        $('#frmFilter').attr('action','{{ url()->current() }}/export');
        $('#frmFilter').attr('method','POST');
        $('#frmFilter').attr('target','_blank');
        $('#frmFilter').submit();
    }
</script>
@endpush
