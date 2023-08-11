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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('matapelajaran') }}">{{ $judul }}</a></li>
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
                        @php
                            $masingkelas = collect($subjectclass)->where('level',$item->level)->where('tid','1')->toArray();
                        @endphp
                        <div class="tab-pane" id="pills-{{ $item->level }}" role="tabpanel" aria-labelledby="pills-{{ $item->level }}-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            Level {{ $item->level }} - Semester 1
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <th>No</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Min</th>
                                                    <th>Jam/Pekan</th>
                                                    <th style="width:10%">#</th>
                                                </thead>
                                                <tbody id="body{{ $item->level }}1">
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
                                                        <button class="btn btn-primary btn-sm btn-block" onclick="tambah({{ $item->level }},'1')"><i class="fas fa-plus-circle"></i> Tambah Pelajaran</button>
                                                    </th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            Level {{ $item->level }} - Semester 2
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <th>No</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Min</th>
                                                    <th>Jam/Pekan</th>
                                                    <th style="width:10%">#</th>
                                                </thead>
                                                <tbody id="body{{ $item->level }}2">
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
                                                        <button class="btn btn-primary btn-sm btn-block" onclick="tambah({{ $item->level }},'2')"><i class="fas fa-plus-circle"></i> Tambah Pelajaran</button>
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
    <div class="modal-dialog modal-lg">
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
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 col-form-label col-form-label-sm"><small>Level</small> </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="level" name="level" readonly >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 col-form-label col-form-label-sm"><small>Semester</small> </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="semester" name="semester" readonly >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 col-form-label col-form-label-sm"><small>Urutan</small> </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="urutan" name="urutan" style="width:50%;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label col-form-label-sm"><small>Mata Pelajaran</small> </label>
                                <div class="col-sm-8">
                                    <select name="pelajaran" id="pelajaran" class="form-control form-control-sm select2">
                                        @foreach ($subject as $ks=>$vs)
                                        <option value="{{ $vs->id }}">{{ $vs->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 col-form-label col-form-label-sm"><small>Minimal Nilai</small> </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="kkm" name="kkm">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 col-form-label col-form-label-sm"><small>Jumlah Jam/Pekan</small> </label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="durasi" name="durasi">
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Guru</th>
                        </thead>
                        <tbody id="bodykelas">

                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpanpelajaran()"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="labelModalDetail" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Mata Pelajaran Per Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodyDetail">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditModal" name="formEditModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Pemetaan Mata Pelajaran</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Nama Kelas</label>
                                <div>
                                    <input type="text" class="form-control" id="name" name="name" value="" maxlength="50" disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_ar" class="control-label">Nama Kelas dalam Arab</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="name_ar" name="name_ar" value="" maxlength="50" disabled="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ceklis Mata Pelajaran, Guru, KKM & Jam Perminggu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($subject as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-2"><input class="check" name="subjectbasic[]" id="check{{ $item->id }}" type="checkbox" value="{{ $item->id }}"></div>
                                                <div class="col-md-4"><label for="check{{ $item->id }}">{{ $item->name }}</label></div>
                                                <div class="col-md-4">
                                                    <select name="e{{ $item->id }}" class="form-control form-control-sm" id="e{{ $item->id }}">
                                                        <option value=""> - Pilih salah satu - </option>
                                                        @foreach($employee as $key => $value)
                                                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-1 text-right"><input type="number" class="form-control form-control-sm" name="value{{ $item->id }}" id="value{{ $item->id }}" style="width:50px" max="100"></div>
                                                <div class="col-md-1 text-right"><input type="number" class="form-control form-control-sm" name="duration{{ $item->id }}" id="duration{{ $item->id }}" style="width:50px" max="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="simpan()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
@endsection
@push('js')
<script type="text/javascript">
    $('a[data-toggle="pill"]').on('shown.bs.tab', function (event) {
        level = $(this).html().split(' ')[1];
        getDataKelas(level,1);
        getDataKelas(level,2);
    })
    function tambah(lvl,sms)
    {
        $('#frmTambah').trigger('reset');
        $('#tambahPelajaran').modal('show');
        $('#level').val(lvl);
        $('#semester').val(sms);
        getKelas(lvl,sms,'');
    }
    function simpanpelajaran()
    {
        frm = $('#frmTambah').serialize();
        lvl = $('#level').val();
        tid = $('#semester').val();
        plj = $('#pelajaran').val();
        uru = $('#urutan').val();
        kkm = $('#kkm').val();
        dur = $('#durasi').val();
        if(uru=='') { alert('Urutan untuk tampil di raport'); return false; }
        if(kkm=='') { alert('Isi Nilai Minimal'); return false; }
        if(plj=='') { alert('Isi Pelajaran'); return false; }
        if(dur=='') { alert('Isi Jumlah Jam/Pekan'); return false; }
        $.post('{{ url('pemetaanpelajaran/simpan') }}',{"_token": "{{ csrf_token() }}",data:frm},function(data){
            if(data=='Berhasil')
            {
                getDataKelas(lvl,tid);
                $('#tambahPelajaran').modal('hide');
            }
        })

    }
    function getKelas(id,ids,plj)
    {
        var isi = '';
        var url = '{{ url('pemetaanpelajaran') }}/'+id+'/edit/'+ids;
        url = (plj!='') ? url+'.'+plj : url;
        $.get(url,function(data){
            $('#bodykelas').html(data);
        });
    }
    function getDataKelas(id,ids)
    {
        $('#body'+id+ids).empty();
        $.post('{{ url('pemetaanpelajaran/load') }}',{"_token": "{{ csrf_token() }}",id:id,'ids':ids},function(data){
            datas = JSON.parse(data);
            text = '';
            no = 1;
            $.each(datas,function(index,value){
                text += '<tr><td>'+value.seq+'</td><td>'+value.name+'</td><td>'+value.grade_pass+'</td><td>'+value.week_duration+'</td>';
                text += '<td>';
                text += '<div class="btn-group" role="group" aria-label="Basic example">';
                text += '<button class="btn btn-sm btn-success" onclick="edit('+value.level+','+value.tid+','+value.subject_id+')"><i class="fa fa-edit"></i></button>';
                text += '<button class="btn btn-sm btn-warning" onclick="hapus('+value.level+','+value.tid+','+value.subject_id+')"><i class="fa fa-trash"></i></button>';
                text += '</div></td></tr>';
                no++;
            })
            $('#body'+id+ids).html(text);
        })
    }
    function getDataPelajaran(id,ids,sbj)
    {
        $.post('{{ url('pemetaanpelajaran/load') }}',{"_token": "{{ csrf_token() }}",id:id,'ids':ids,'subject':sbj},function(data){
            datas = JSON.parse(data);
            $('#urutan').val(datas[0].seq);
            $('#pelajaran').val(datas[0].subject_id).trigger('change');
            $('#kkm').val(datas[0].grade_pass);
            $('#durasi').val(datas[0].week_duration);
        })
    }
    function edit(lvl,sms,plj)
    {
        $('#frmTambah').trigger('reset');
        $('#tambahPelajaran').modal('show');
        $('#level').val(lvl);
        $('#semester').val(sms);
        getKelas(lvl,sms,plj);
        getDataPelajaran(lvl,sms,plj);
    }
    function simpan(lvl)
    {
        $('.btnTambah').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        frm = $('#frmtmbh'+lvl).serialize();
        mpl = $('#subject_id'+lvl).val();
        grd = $('#grade_pass'+lvl).val();
        wek = $('#week_duration'+lvl).val();
        if(mpl=='')
        {
            alert('Mata Pelajaran harus diisi');
            return;
        }
        if(grd=='' || grd=='0')
        {
            alert('Nilai Minimum');
            return
        }
        if(wek=='' || wek=='0')
        {
            alert('Jumlah Jam/Pekan harus diisi');
            return;
        }
        $.post('{{ url('pemetaanpelajaran/simpan') }}',{"_token": "{{ csrf_token() }}",data:frm},function(data){
            if(data=='Berhasil')
            {
                get(lvl);
                $('.btnTambah').html('<i class="fa fa-plus"></i> Tambah')
            }
        });
    }
    function get(id,ids)
    {
        var isi = '';
        $.get('{{ url('pemetaanpelajaran') }}/'+id+'/edit/'+ids,function(data){
            datas = data.split('|');
            if(datas[0]='Berhasil')
            {
                isi = datas[1];
                $('#tbody'+id).html(isi);
            }
        });
    }
    $(function() {
        var no = 1;
        $('ul#pills-tab li.nav-item a.nav-link').each(function(index){
            get(no);
            no++;
        })
    });
    function lihat(id,ids)
    {
        $.post('{{ url('pemetaanpelajaran/load') }}',{"_token": "{{ csrf_token() }}",id:id,ids:ids},function(data){
            $('#bodyDetail').html(data);
            $('#modalDetail').modal('show');
        });
    }
    function hapus(id,ids,sbj)
    {
        if(confirm('Mata Pelajaran akan dihapus? '))
        {
            $.post('{{ url('pemetaanpelajaran/hapus') }}',{"_token": "{{ csrf_token() }}",id:id,ids:ids,sbj:sbj},function(data){
                if(data=='Berhasil')
                {
                    getDataKelas(id,ids);
                }
            })
        }
    }
    function simpanguru(lvl,sbj,cc)
    {
        $('.btnSimpanGuru').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        guru = $('#eid'+lvl+'_'+sbj+'_'+cc+' option:selected').val();
        if(guru=='')
        {
            $('.btnSimpanGuru').html('<i class="fa fa-save"></i>');
        }
        $.post('{{ url('pemetaanpelajaran/simpandetail') }}',{"_token": "{{ csrf_token() }}",lvl:lvl,sbj:sbj,cc:cc,guru:guru},function(data){
            lihat(lvl,sbj);
            $('.btnSimpanGuru').html('<i class="fa fa-save"></i>');
            if(guru=='') {
                msgError('Pilih guru terlebih dahulu!');
            } else {
                msgSukses('Berhasil disimpan');
            }
        })
    }
</script>
@endpush
