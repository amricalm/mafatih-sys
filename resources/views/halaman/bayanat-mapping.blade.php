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
        <div class="col">
            <div class="card">
                <div class="table-responsive py-4">
                    <div class="container">
                        <table class="table datatables">
                            <thead>
                                <tr>
                                    <th width="15%">Kelompok/Tingkat</th>
                                    <th width="10%">Musyrif</th>
                                    <th width="70%">Santri</th>
                                    <th width="5%">#</th>
                                </tr>
                            </thead>
                            <tbody id="bodykomponen">
                                @foreach ($mapping as $k=>$v)
                                <tr>
                                    <td class="arabic text-right">{{ $v['classname'] }} <br> {{ $v['level'] }} <br> {{ ($v['mm']!='') ? Lang::get('juz_has_tasmik.'.$v['mm'],[],'ar') : '-' }}</td>
                                    <td>{{ $v['teachername'] }}</td>
                                    <td>
                                        <p class="text-wrap" style="font-size: .8125rem;">
                                            @php
                                                $mappingdtls = collect($mappingdtl)->where('hdr_id',$v['id']);
                                                $no = 0;
                                            @endphp
                                            @foreach ($mappingdtls as $kk=>$vv)
                                            @if ($no>0)
                                            , &nbsp;
                                            @endif
                                            (<b>{{ ($no+1) }}</b>) {{ $vv['name'] }}
                                            @php
                                                $no++;
                                            @endphp
                                            @endforeach
                                        </p>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" style="">
                                                <a class="dropdown-item edit" href="javascript:edit({{ $v['id'] }})"><i class="fa fa-pencil"></i> Edit</a>
                                                <a class="dropdown-item delete" href="javascript:hapus({{ $v['id'] }})"><i class="fa fa-trash"></i> Hapus</a>
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
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Kelompok</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Ikhwan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Akhwat
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level" class="control-label">Pilih Tingkat Bayanat</label>
                                <div>
                                    <select name="level" id="level" class="form-control">
                                        <option value=""> - Pilih Tingkat - </option>
                                        @foreach ($level as $levelkey=>$levelval)
                                        <option value="{{ $levelval->id }}" class="arabic text-right">({{ \App\SmartSystem\General::angka_arab($levelval->level) }}){{ $levelval->name }} : {{ $levelval->name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ccid" class="control-label">Pilih Halaqah</label>
                                <div>
                                    <select name="ccid" id="ccid" class="form-control">
                                        <option value=""> - Pilih Kelas - </option>
                                        @foreach ($kelas as $levelkcc=>$levelcc)
                                        <option value="{{ $levelcc->id }}" class="arabic text-right">{{ $levelcc->name }} : {{ $levelcc->name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mm" class="control-label">Pilih Muqarrar Halqah</label>
                                <div>
                                    <select name="mm" id="mm" class="form-control">
                                        <option value=""> - Pilih Muqarrar - </option>
                                        @for ($mmi=1;$mmi<=30;$mmi++)
                                        <option value="{{ $mmi }}">{{ $mmi }} Juz</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight" class="control-label">Pilih Musyrif</label>
                                <div>
                                    <select name="pid" id="pid" class="select2 form-control">
                                        <option value=""> - Pilih Musyrif - </option>
                                        @foreach ($musyrif as $musykey=>$musyval)
                                        <option value="{{ $musyval->id }}">{{ $musyval->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="80%">Nama</th>
                                        <th width="5%">#</th>
                                    </tr>
                                </thead>
                                <tbody id="bodytable">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <select name="pids" id="pids" class="select2 form-control">
                                                <option value=""> - Pilih Santri - </option>
                                                @foreach ($santri as $santrikey=>$santrival)
                                                <option value="{{ $santrival->id }}">{{ $santrival->nis.' - '.$santrival->name }}</option>
                                                @endforeach
                                            </select>
                                        </th>
                                        <th><button type="button" class="btn btn-warning btn-sm" onclick="tambahsantri()"><i class="fas fa-angle-double-up"></i></button></th>
                                    </tr>
                                </tfoot>
                            </table>
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
@endsection
@push('js')
<script type="text/javascript">
    $('#ajaxModel').on('show.bs.modal',function(event){
        $('#id').val('');
        $('#level').val('');
        $('#ccid').val('')
        $('#pid').val('')
        $('#pid').trigger('change');
        $('#bodytable').html('');
        $('#saveBtn').html('<i class="fa fa-save"></i> Simpan');
    })
    function tambahsantri()
    {
        id = $('#pids').val();
        name = $('#pids option[value='+id+']').html();
        if(id!='')
        {
            baris = $('#bodytable tr').length + 1;
            no = 0;
            $('#bodytable tr').each(function(){
               ids = $(this).attr('id').split('baris');
               vall = $('#pidss'+ids[1]).val();
               if(vall==id)
               {
                    no = 1;
                    return;
               }
            });
            if(no==0)
            {
                text = '<tr id="baris'+baris+'">';
                text += '<td>'+name+'</td>';
                text += '<td>';
                text += '<input type="hidden" name="pidss[]" id="pidss'+baris+'" value="'+id+'">';
                text += '<button type="button" class="btn btn-danger btn-sm" onclick="hapussantri('+baris+')"><i class="fas fa-trash-alt"></i></button>';
                text += '</td>';
                text += '</tr>';
                $('#bodytable').append(text);
            }
        }
    }
    function hapussantri(id)
    {
        $('#baris'+id).remove();
    }
    function loadsantri(id)
    {

    }
    $('#saveBtn').click(function(e) {
        e.preventDefault();
        tingkat = $('#level').val();
        kelas = $('#ccid').val();
        pid = $('#pid').val();
        if(tingkat==''){ return;}
        if(kelas==''){ return;}
        if(pid==''){return;}
        data = $('#form').serialize()
        $(this).html('<i class="fas fa-spinner"></i> Loading');
        $.post('{{ url('bayanat-quran/pembagian-halaqah/exec') }}',{"_token":"{{ csrf_token() }}",data:data,'tipe':'insert'},function(data){
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
        $.post('{{ url('bayanat-quran/pembagian-halaqah/exec') }}',{"_token":"{{ csrf_token() }}",'tipe':'show','id':id,'data':''},function(data){
            datas = JSON.parse(data);
            komp = datas.komponen;
            $('#ajaxModel').modal('show');
            $('#id').val(komp.id);
            $('#level').val(komp.level);
            $('#ccid').val(komp.ccid)
            $('#pid').val(komp.pid)
            $('#mm').val(komp.mm);
            $('#pid').trigger('change');
            no = 0;
            $.each(datas.komponendtl,function(index,value){
                text = '<tr id="baris'+no+'">';
                text += '<td>'+value.name+'</td>';
                text += '<td>';
                text += '<input type="hidden" name="pidss[]" id="pidss'+no+'" value="'+value.pid+'">';
                text += '<button type="button" class="btn btn-danger btn-sm" onclick="hapussantri('+no+')"><i class="fas fa-trash-alt"></i></button>';
                text += '</td>';
                text += '</tr>';
                no++;
                $('#bodytable').append(text);
            })
            $('#saveBtn').html('<i class="fa fa-pencil"></i> Update');
        })
    }
    function hapus(id)
    {
        $.post('{{ url('bayanat-quran/pembagian-halaqah/exec') }}',{"_token":"{{ csrf_token() }}",'tipe':'delete','id':id,'data':''},function(data){
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
</script>
@endpush
