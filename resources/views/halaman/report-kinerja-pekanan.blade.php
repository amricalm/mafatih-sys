@extends('layouts.app')
@include('komponen.dataTables')
{{-- @include('komponen.select2') --}}

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('report-pegawai') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{-- <a href="javascript:void(0)" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="row p-4">
                    <div class="col-md-12">
                        <h3>Rekapitulasi</h3>
                    </div>
                </div> --}}
                <div class="row pl-4 pr-4">
                    {{-- <div class="col-md-6">
                        <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#divfrmFilter" role="button" aria-expanded="true" aria-controls="collapseExample"><i class="fa fa-filter"></i> Filter</a>
                    </div>
                    <div class="col-md-6 text-right">

                    </div> --}}
                    <div class="col-md-12 collapse show py-4" id="divfrmFilter">
                        <form id="frmFilter">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-4 col-form-label">
                                            Pilih Bulan <br>
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="bulan" id="bulan" class="form-control">
                                                <option value="0" selected="selected">Pilih salah satu</option>
                                                @foreach ($bulan as $k=>$v)
                                                @php $selected=($k==date('m')) ? 'selected="selected"' : ''; @endphp
                                                <option value="{{ $k }}" {{ $selected }}>{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-4 col-form-label">
                                            Pilih Tahun <br>
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="tahun" id="tahun" class="form-control">
                                                <option value="0" selected="selected">Pilih salah satu</option>
                                                @php
                                                    $tahundepan = 2030;
                                                @endphp
                                                @for($i=2022;$i<=$tahundepan;$i++)
                                                @php $selected=($i==date('Y')) ? 'selected="selected"' : ''; @endphp
                                                <option value="{{ $i }}" {{ $selected }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-4 col-form-label">
                                            Pilih Karyawan <br>
                                            <small style="font-size:10px;"><u><a href="javascript:$('#employe_id option').prop('selected',false);$('#employe_id option:first').prop('selected', 'selected');">pilih semua</a></u></small>
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="employe_id[]" id="employe_id" class="form-control" multiple>
                                                <option value="0" selected="selected">Pilih Semua</option>
                                                @foreach ($karyawan as $k=>$v)
                                                <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-4 col-form-label">
                                            Pilih Komponen <br>
                                            <small style="font-size:10px;"><u><a href="javascript:$('#component_id option').prop('selected',false);$('#component_id option:first').prop('selected', 'selected');">pilih semua</a></u></small>
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="component_id[]" id="component_id" class="form-control" multiple>
                                                <option value="0" selected="selected">Pilih Semua</option>
                                                @foreach ($komponen as $k=>$v)
                                                <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    {{-- <div class="row">
                                        <div class="col-md-12 p-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="timeline" id="timeline1" value="dayly" checked="checked">
                                                <label class="form-check-label" for="timeline1">Harian</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="timeline" id="timeline2" value="weekly">
                                                <label class="form-check-label" for="timeline2">Mingguan</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="timeline" id="timeline3" value="monthly">
                                                <label class="form-check-label" for="timeline3">Bulanan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"> --}}
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" id="btnFilter" onclick="filter()" class="btn btn-warning"><i class="fa fa-filter"></i> Proses</button>
                                            <button class="btn btn-primary" id="btnExport" style="display:none;" data-toggle="collapse" href="#" onclick="eksport()"  role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-file-excel"></i> Export</button>
                                            </div>
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive py-4">
                    <div class="container" id="tmptTable">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ url('assets') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    $.fn.datepicker.defaults.format = "yyyy-mm-dd";
    $("#datepicker").datepicker( {
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months"
    });
    function filter()
    {
        var frm = $('#frmFilter').serialize();
        $('#btnFilter').attr('disabled','disabled');
        $('#btnFilter').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        $.post('{{ url()->current() }}',{_token: "{{ csrf_token() }}",data:frm},function(data){
            $('#btnExport').show();
            $('#tmptTable').html(data);
            $('#btnFilter').removeAttr('disabled');
            $('#btnFilter').html('<i class="fa fa-filter"></i> Proses');
        });
    }
    function eksport()
    {
        var frm = $('#frmFilter').serialize();
        $('#frmFilter').attr('action','{{ url()->current() }}/export');
        $('#frmFilter').attr('method','POST');
        $('#frmFilter').attr('target','_blank');
        $('#frmFilter').submit();
    }
</script>
@endpush
