@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.datepicker')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('karyawan') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" id="createNew" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            {{-- <td>Nama</td> --}}
                            <td>Periode</td>
                            <td>Tanggal</td>
                            <td>Aktif</td>
                            <td>#</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($ppdbset as $k=>$v)
                        <tr>
                            <td>{{ $no++ }}</td>
                            {{-- <td>{{ $v->name }}</td> --}}
                            <td>{{ $v->ayname }}</td>
                            <td>{{ \App\SmartSystem\General::convertDate($v->start_date).' s/d
                                '.\App\SmartSystem\General::convertDate($v->end_date) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm {{ ($v->is_publish=='1') ? 'btn-primary' : 'btn-secondary' }}" onclick="aktif({{ $v->id }})">
                                    @if ($v->is_publish=='1')
                                    <i class="far fa-check-circle"></i>
                                    @else
                                    <i class="far fa-times-circle"></i>
                                    @endif
                                </button>
                            </td>
                            <td style="text-align:right;">
                                <a class="btn btn-sm btn-warning" href="{{ url('ppdb/setting').'/'.$v->id.'/edit' }}" ><i class="fa fa-pencil"></i> Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmTambah">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="form-group">
                        <label for="name">Pilih Tahun Ajaran</label>
                        <select type="text" class="form-control form-control-sm" id="ayid" name="ayid">
                            <option value=""> - Pilih Salah Satu - </option>
                            @foreach ($tahunajar as $it)
                            <option value="{{ $it->id }}">{{ $it->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label for="name">Nama Ppdb</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="desc">Deskripsi</label>
                        <textarea name="desc" id="desc" class="form-control form-control-sm"></textarea>
                    </div> --}}
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="text" class="form-control form-control-sm datepicker" id="start_date" autocomplete="off" name="start_date">
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="text" class="form-control form-control-sm datepicker" id="end_date" name="end_date" autocomplete="off">
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                            Close</button>
                        <button type="button" class="btn btn-primary" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function cekurl()
    {

    }
    $('#simpan').on('click',function(){
        ar = $('#frmTambah').serialize();
        str = $('#start_date').val()
        dstr = new Date(str);
        end = $('#end_date').val()
        dend = new Date(end);
        if(str=='' || end=='')
        {
            alert('Masukkan Tanggal PPDB');
            return;
        }
        if(dstr >= dend)
        {
            alert('Tanggal Mulai harus lebih kecil');
            return;
        }
        $.post('{{ url('ppdb/setting/simpan') }}',{'_token':'{{ csrf_token() }}',data:ar},function(data){
            datas = data.split('|')
            if(datas[0]=='Berhasil')
            {
                msgSukses('Berhasil disimpan');
                location.reload();
            }
            else
            {
                msgError(data);
            }
        })
    })
    function aktif(id)
    {
        $.post('{{ url('ppdb/setting/aktif') }}',{"_token": "{{ csrf_token() }}",id:id},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil diaktifkan');
                setInterval(
                    function(){
                        location.reload();
                    }
                ,1000);
            }
        })
    }
</script>
@endpush
