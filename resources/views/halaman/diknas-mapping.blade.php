@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.select2')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('diknas') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{-- <a href="#" data-toggle="modal" data-target="#tambahModal" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @foreach ($level as $item)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-{{ $item->level }}-tab" data-toggle="pill" href="#pills-{{ $item->level }}" role="tab" aria-controls="pills-{{ $item->level }}" aria-selected="true">Level {{ $item->level }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @foreach ($level as $item)
                        <div class="tab-pane" id="pills-{{ $item->level }}" role="tabpanel" aria-labelledby="pills-{{ $item->level }}-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            Level {{ $item->level }} - Tahun Ajaran {{ config('active_academic_year') }} Semester {{ config('id_active_term') }}
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <th>No</th>
                                                    <th width="30%">Mata Pelajaran</th>
                                                    <th width="50%">Mata Pelajaran MSH</th>
                                                    <th width="10%">Mulok</th>
                                                    <th width="10%">#</th>
                                                </thead>
                                                <tbody id="body{{ $item->level }}">
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="fa-5x">
                                                                <i class="fas fa-spinner fa-pulse"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <th colspan="5">
                                                        <button class="btn btn-primary btn-sm btn-block" onclick="tambah({{ $item->level }})"><i class="fas fa-plus-circle"></i> Tambah Pelajaran</button>
                                                    </th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahPelajaran" tabindex="-1" aria-labelledby="tambahPelajaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPelajaranLabel">Update Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmTambah">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 col-form-label col-form-label-sm">Level </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="level" name="level" readonly  style="width:50%;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 col-form-label col-form-label-sm">Urutan </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="urutan" name="urutan" style="width:50%;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 col-form-label col-form-label-sm">Mata Pelajaran</label>
                                <div class="col-sm-8">
                                    <select id="subject_diknas" name="subject_diknas" class="form-control form-control-sm">
                                        <option value=""> - Pilih Salah Satu - </option>
                                        @foreach ($subject_diknas as $k=>$v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label col-form-label-sm">Kelompok</label>
                                <div class="col-sm-8">
                                    @php $arrKelompok = ['0'=>'Kelompok A (Umum)','1'=>'Kelompok B (Umum)','2'=>'Muatan Lokal']  @endphp
                                    <select id="mulok" name="mulok" class="form-control form-control-sm">
                                        @foreach ($arrKelompok as $k=>$v)
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran untuk digabung</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody id="bodymp">

                        </tbody>
                    </table>
                    <table class="table">
                        <tr>
                            <th style="width:85%">
                                <select id="pilihmp" class="form-control form-control-sm">
                                    <option value=""> - Pilih Salah Satu - </option>
                                    @foreach ($subject as $k=>$v)
                                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th style="width:15%"><button onclick="tambahMapel()" type="button" class="btn btn-sm btn-primary btn-block"><i class="fa fa-plus"></i></button></th>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                        <button type="button" class="btn btn-primary btnTambah" onclick="simpan()"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    function tambahMapel()
    {
        id = $('#pilihmp option:selected').val();
        txt = $('#pilihmp option:selected').text();
        if(id!='')
        {
            ada = '';
            $('input[name^=mpid]').each(function(index,value){
                ada = ($(this).val()==id) ? '1' : '';
            });
            if(ada=='')
            {
                text = '<tr id="tr'+id+'">';
                text += '<td><input type="hidden" name="mpid[]" id="mp'+id+'" class="form-control" value="'+id+'"/>'+txt+'</td>';
                text += '<td><button type="button" class="btn btn-sm btn-warning" onclick="hapusbaris('+id+')"><i class="fa fa-trash"></i></button></td>';
                text += "</tr>";
                $('#bodymp').append(text);
            }
        }
    }
    function hapusbaris(id)
    {
        $('#tr'+id).remove();
    }
    function tambah(lvl)
    {
        $('.btnTambah').removeAttr('disabled');
        $('#frmTambah').trigger('reset');
        $('#tambahPelajaran').modal('show');
        $('#level').val(lvl);
    }
    function simpan(lvl)
    {
        frm = $('#frmTambah').serialize();
        urutan = $('#urutan').val();
        subject_diknas = $("#subject_diknas").val();
        lvl = $('#level').val();
        if(urutan==''||urutan=='0')
        {
            alert('Urutan harus diisi!');
            return;
        }
        if(subject_diknas=='')
        {
            alert('Nama Mata Pelajaran untuk Diknas harus diisi!');
            return;
        }
        no = 0;
        $('input[name^=mpid]').each(function(i,v){
            no++;
        });
        if(no==0)
        {
            alert('Isi mata pelajaran yang akan digabung');
            return;
        }
        $('.btnTambah').attr('disabled','disabled');
        $('.btnTambah').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...');
        $.post('{{ url('diknas/pemetaan/save') }}',{"_token": "{{ csrf_token() }}",data:frm},function(data){
            if(data=='Berhasil')
            {
                $('.btnTambah').removeAttr('disabled');
                $('.btnTambah').html('<i class="fa fa-plus"></i> Tambah');
                $('#urutan').val('');
                $('#mulok').val('');
                $('#pilihmp').val('');
                $('#bodymp').empty();
                get(lvl);
            }
            else
            {
                console.table(data);
            }
        });
    }
    function edit(id)
    {
        $('#frmTambah').trigger('reset');
        $('#tambahPelajaran').modal('show');
        $('.btnTambah').html('<i class="fa fa-save"></i> Simpan');
        var url = '{{ url('diknas/pemetaan/') }}/'+id+'/edit';
        $.get(url,function(data) {
            $('#id').val(data.id);
            $('#urutan').val(data.seq);
            $("#subject_diknas select").val(data.subject_diknas_id).change();
        });
    }
    function get(id)
    {
        var isi = '';
        $.post('{{ url('diknas/pemetaan/load') }}',{"_token": "{{ csrf_token() }}",level:id},function(data){
            $('#body'+id).html(data);
        });
    }
    $(function() {
        var no = 1;
        $('ul#pills-tab li.nav-item a.nav-link').each(function(index){
            get(no);
            no++;
        })
    });
    $('a[data-toggle="pill"]').on('shown.bs.tab', function (event) {
        level = $(this).html().split(' ')[1];
        get(level);
    })
    function hapus(level,id)
    {
        if(confirm('Mata Pelajaran akan dihapus? '))
        {
            $.post('{{ url('diknas/pemetaan/hapus') }}',{"_token": "{{ csrf_token() }}",id:id},function(data){
                if(data=='Berhasil')
                {
                    get(level);
                }
            })
        }
    }
</script>
@endpush
