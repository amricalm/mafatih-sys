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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('bayanat-quran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="javascript:void(0)" id="createNew" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#ajaxModel"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form action="" method="POST" style="padding-bottom: 10px;">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="staticLembaga">Mata Pelajaran</label>
                                            <select name="pilihmapel" id="pilihmapel" class="form-control" required>
                                                <option value="0"> - Pilih Mata Pelajaran - </option>
                                                @foreach ($mapel as $k=>$v)
                                                @php
                                                    $selected = ($v->id==$pilihmapel) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $v->id }}" {{ $selected }}>{{ $v->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="staticLembaga">Tingkat lanut</label>
                                            <select name="pilihtingkat" id="pilihtingkat" class="form-control" required>
                                                <option value="0"> - Pilih Tingkat - </option>
                                                @foreach ($level as $k=>$v)
                                                @php
                                                    $selected = ($v->level==$pilihtingkat) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $v->level }}" {{ $selected }}>{{ $v->level }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex flex-grow-1 justify-content-center align-items-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Filter</button>
                                        </div>
                                    </div>
                                    @if ($req->post())
                                        <div class="col-md-12">
                                            <a href="#" data-toggle="modal" data-target="#modalImport" class="btn btn-sm btn-secondary"><i class="fas fa-file-excel"></i> Impor dari Excel</a>
                                            <a href="{{ url('diknas/'.$req->pilihtingkat.'/export/'.$req->pilihmapel.'/xls') }}" class="btn btn-sm btn-secondary"><i class="fas fa-file-export"></i> Ekspor Data</a>
                                        </div>
                                        @php $c = '6'; @endphp
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <div class="container">
                            <table class="table datatables stripe">
                                <thead>
                                    <tr>
                                        <th width="15%">Kompetensi Inti</th>
                                        <th width="10%">Kompetensi Dasar</th>
                                        <th width="70%">Deskripsi Kompetensi Dasar</th>
                                        <th width="5%">#</th>
                                    </tr>
                                </thead>
                                <tbody id="bodykomponen">
                                    @foreach ($subject as $k=>$v)
                                    <tr>
                                        <td>{{ $v->core_competence }}</td>
                                        <td>{{ $v->core_competence }}.{{ $v->basic_competence }}{{ $v->sub_basic_competence!=0 ? '.'.$v->sub_basic_competence : '' }}</td>
                                        <td>
                                            <p class="text-wrap" style="font-size: .8125rem;">{{ $v->desc }}</p>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" style="">
                                                    <a class="dropdown-item edit" href="javascript:edit({{ $v->id }})"><i class="fa fa-pencil"></i> Edit</a>
                                                    <a class="dropdown-item delete" href="javascript:hapus({{ $v->id }})"><i class="fa fa-trash"></i> Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form" name="form" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ccid" class="control-label">Pilih Mata Pelajaran</label>
                                <div>
                                    <select name="subject" id="subject" class="form-control">
                                        <option value=""> - Pilih Mata Pelajaran - </option>
                                        @foreach ($mapel as $k=>$v)
                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level" class="control-label">Pilih Tingkat</label>
                                <div>
                                    <select name="level" id="level" class="form-control">
                                        <option value=""> - Pilih Tingkat - </option>
                                        @foreach ($level as $key=>$val)
                                        <option value="{{ $val->level }}">{{ $val->level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="weight" class="control-label">Pilih Kompetensi Inti</label>
                                <div>
                                    <select name="core" id="core" class="form-control">
                                        <option value=""> - Pilih Kompetensi Inti - </option>
                                        @foreach ($core as $key=>$val)
                                        <option value="{{ $val->id }}">KI {{ $val->id }} - {{ $val->desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="weight" class="control-label">Kompetensi Dasar</label>
                                <div>
                                    <input type="number" class="form-control" name="basic" id="basic">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="weight" class="control-label">Sub Kompetensi Dasar</label>
                                <div>
                                    <input type="number" class="form-control" name="subbasic" id="subbasic">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight" class="control-label">Deskripsi Kompetensi Dasar</label>
                                <div>
                                    <textarea class="form-control" name="desc" id="desc" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tahapan Impor Dari Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmImpor">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ol>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-9">
                                            Download Template >>>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <a href="{{ url('diknas/'.$req->pilihtingkat.'/export/'.$req->pilihmapel) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> Template</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            Isi data-data nilai yang ada disamping Kode Mata Pelajaran
                                            {{-- <img src="{{ asset('uploads/copy-paste-santri-input-nilai.png') }}" alt="ilustrasi" width="100%"> --}}
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <b>Save As</b> data yang sudah sesuai Fieldnya dengan nama file yang memudahkan Anda.
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="files">Upload Filenya disini</label>
                                                <input type="file" class="form-control-file" name="file" id="file">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            Klik Tombol <b>Proses Impor</b> dibawah. Lalu tunggu sampai ada notifikasi berhasil.
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnProses"><i class="fa fa-gear"></i> Proses Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $('#ajaxModel').on('show.bs.modal',function(event){
        $('#id').val('');
        $('#subject').val('');
        $('#subject').trigger('change');
        $('#level').val('');
        $('#core').val('');
        $('#basic').val('');
        $('#subbasic').val('');
        $('#desc').val('');
        $('#saveBtn').html('<i class="fa fa-save"></i> Simpan');
    })
    $('#saveBtn').click(function(e) {
        e.preventDefault();
        tingkat = $('#level').val();
        subject = $('#subject').val();
        core = $('#core').val();
        basic = $('#basic').val();
        subbasic = $('#sub_basic').val();
        desc = $('#desc').val();
        if(tingkat==''){ return;}
        if(subject==''){return;}
        if(core==''){ return;}
        if(basic==''){ return;}
        if(subbasic==''){ return;}
        if(desc==''){ return;}
        data = $('#form').serialize()
        $(this).html('<i class="fas fa-spinner"></i> Loading');
        $.post('{{ url('diknas/kompetensi/exec') }}',{"_token":"{{ csrf_token() }}",data:data,'tipe':'insert'},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil disimpan');
                location.reload();
            }
            else
            {
                msgError(data);
            }
            $(this).html('<i class="fa fa-save"></i> Simpan');
            console.log(data);
        })
    });
    function edit(id)
    {
        $.post('{{ url('diknas/kompetensi/exec') }}',{"_token":"{{ csrf_token() }}",'tipe':'show','id':id,'data':''},function(data){
            datas = JSON.parse(data);
            komp = datas.komponen;
            $('#ajaxModel').modal('show');
            $('#id').val(komp.id);
            $('#level').val(komp.level);
            $('#subject').val(komp.subject_diknas_id)
            $('#subject').trigger('change');
            $('#core').val(komp.core_competence);
            $('#basic').val(komp.basic_competence);
            $('#subbasic').val(komp.sub_basic_competence);
            $('#desc').val(komp.desc);
            $('#saveBtn').html('<i class="fa fa-pencil"></i> Update');
        })
    }
    function hapus(id)
    {
        $.post('{{ url('diknas/kompetensi/exec') }}',{"_token":"{{ csrf_token() }}",'tipe':'delete','id':id,'data':''},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil dihapus');
                location.reload();
            }
            else
            {
                console.log(data);
            }
        })
    }

    $('#btnProses').on('click',function(){
        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append("_token","{{ csrf_token() }}");
        $('#btnProses').attr('disabled','disabled').html('Sedang Proses...');
        $.ajax({
            url: '{{ route('uploadkompetensidasar') }}',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
                success: function(response){
                    if(response=='Berhasil'){
                        msgSukses('Berhasil import nilai');
                        location.reload();
                    }else{
                        msgError('Mohon dilaporkan! <br>'+response);
                    }
                },
        });

    });
</script>
@endpush
