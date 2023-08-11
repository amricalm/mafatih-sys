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
                        <a href="#" onclick="lihatsemua()" id="createNew" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#ajaxModel"><i class="fa fa-search"></i> Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Pilih Posisi</label>
                            <div class="col-sm-10">
                                <select name="position_id" id="position_id" class="form-control">
                                    <option value=""> - Pilih Salah Satu - </option>
                                    @foreach ($posisi as $key=>$val)
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
                <div class="card-body table-responsive py-4">
                    <div class="container">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th style="width:20%">Kode</th>
                                    <th style="width:20%">Nama Komponen</th>
                                    <th style="width:20%">Deskripsi</th>
                                    <th style="width:10%">Min. Durasi</th>
                                    {{-- <th style="width:10%">Wajib</th> --}}
                                    <th style="width:10%">Lembur</th>
                                    <th style="width:10%">#</th>
                                </tr>
                            </thead>
                            <tbody id="bodytable">

                            </tbody>
                            <tfoot>
                                <form id="frmtambah">
                                <tr>
                                    <td colspan="3">
                                        <select name="component_id" id="component_id" class="form-control">
                                            <option value=""> - Pilih Salah Satu - </option>
                                            @foreach ($komponen as $key=>$val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control" name="duration_min" id="duration_min"></td>
                                    {{-- <td>
                                        <label class="switch">
                                            <input type="checkbox" name="is_mandatory" id="is_mandatory" class="primary" value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </td> --}}
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" name="is_overtime" id="is_overtime" class="primary" value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td><button onclick="tambahbaris()" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button></td>
                                </tr>
                                </form>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
<div class="modal" id="modalAll" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Semua</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="accordion">
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($posisi as $key=>$val)
                        <div class="card">
                            <div class="card-header" id="heading{{ $no }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $val->id }}" aria-expanded="false" aria-controls="collapse{{ $val->id }}">{{ $val->name }}</button>
                                </h5>
                            </div>
                            <div id="collapse{{ $val->id }}" class="collapse" aria-labelledby="heading{{ $no }}" data-parent="#accordion">
                                <div class="card-body" id="cardbody{{ $no }}"></div>
                            </div>
                        </div>
                        @php
                            $no++;
                        @endphp
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $('#lihat').on('click',function(){
        post = $('#position_id option:selected').val();
        if(post==''||post=='0')
        {
            alert('Mohon pilih salah satu posisi. Lalu klik tombol Lihat!');
            return;
        }
        showbaris(post);
    })
    function tambahbaris()
    {
        post = $('#position_id option:selected').val();
        komp = $('#component_id option:selected').val();
        durm = $('#duration_min').val();
        if(post==''||post=='0')
        {
            alert('Mohon pilih salah satu posisi. Lalu klik tombol Lihat!');
            return;
        }
        if(komp=='' || durm=='')
        {
            alert('Mohon isi Komponen serta MInimal Durasinya.');
            return;
        }
        tmbh = $('#frmtambah').serialize()
        $.post('{{ url('pemetaankomponenkinerja/save') }}',{"_token": "{{ csrf_token() }}",'position_id':post,'data':tmbh},function(data){
            if(data=='Berhasil')
            {
                showbaris(post);
            }
        })
    }
    function showbaris(id)
    {
        $('#bodytable').html('');
        $.get('{{ url('pemetaankomponenkinerja') }}/'+id+'/show',function(data){
            $('#bodytable').html(data);
        })
    }
    function hapus(id)
    {
        if(confirm('Betul akan dihapus?'))
        {
            post = $('#position_id option:selected').val();
            $.get('{{ url('pemetaankomponenkinerja') }}/'+id+'/delete',function(data){
                datas = data.split('|');
                if(datas[0]=='Berhasil')
                {
                    showbaris(datas[1]);
                }
            });
        }
    }
    function lihatsemua()
    {
        no = 0;
        $('#modalAll').modal('show');
        var json = $.getJSON('{{ url('pemetaankomponenkinerja/showall') }}',function(emp){
            $.each(emp,function(key,val){
                var ada = '';
                var htmls = '<ul class="list-group">';
                $.each(val.data,function(k,v){
                    ada = (v.component_name===null) ? 'tidak' : 'ada';
                    htmls += '<li class="list-group-item">';
                    htmls += '<div class="row"><div class="col-md-6">' + v.component_name + " ("+v.duration_min+' jam) </div><div class="col-md-6 text-right">';
                    // htmls += (v.is_mandatory=='1') ? '<span class="badge badge-primary">wajib</span>' : '';
                    htmls += (v.is_overtime=='1') ? '<span class="badge badge-warning">lembur</span>' : '';
                    htmls += '</div></div></li>';
                });
                htmls += '</ul>';
                htmls = (ada=='tidak') ? '' : htmls;
                $('#cardbody'+no).html(htmls);
                no++;
            });
        });
    }
</script>
@endpush
