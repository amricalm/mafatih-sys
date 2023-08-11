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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('ppdb/setting') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    @if (count($all)==0)
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="javascript:void(0)" id="btnHapus" onclick="hapus({{ $ppdbset['id'] }})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ $ppdbset['name'] }}
                    @if ($ppdbset['is_publish']=='1')
                    <span class="badge badge-warning"><i class="fas fa-check-circle"></i> PPDB AKTIF!</span>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">Tanggal : {{ $ppdbset['start_date'] }} s.d {{ $ppdbset['end_date'] }}</h5>
                    <p class="card-text">{{ $ppdbset['desc'] }}</p>
                    <p></p>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">Yang Mendaftar</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{ $mendaftar }} orang</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                        <i class="fas fa-cog fa-2xl"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">Yang lulus</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{ $lulus }} orang</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                        <i class="fas fa-check fa-2xl"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-right">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    {{-- @if (auth()->user()->role=='1') --}}
                                    <a href="#" class="btn btn-warning" onclick="edit({{ $ppdbset['id'] }})"><i class="fa fa-pencil"></i> Edit Detail</a>
                                    {{-- @endif --}}
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="card">
            @if (auth()->user()->role=='1')
            <form action="" method="GET">
                <div class="card-header">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="filterKomponen">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="sekolah">Sekolah dituju</label>
                                                <select name="sekolah" id="sekolah" class="form-control form-control-sm">
                                                    <option value="0"> - Pilih Salah Satu - </option>
                                                    @foreach ($school as $ky=>$vl)
                                                    @php $pilih = ($sekolah==$vl['id']) ? 'selected="selected"' : ''; @endphp
                                                    <option value="{{ $vl['id'] }}" {{ $pilih }}>{{ $vl['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <div class="btn-group">
                                                <button type="button" id="btnExport" class="btn btn-secondary btn-sm"><i class="fa fa-file-excel"></i>Export</button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>Terapkan</button>
                                                <a href="{{ url('ppdb/setting') }}" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i> Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <form action="" method="GET">
                <div class="card-header">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="filterKomponen">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="sekolah" id="sekolah" value="{{ $school[0]->id }}">
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <div class="btn-group">
                                                <button type="button" id="btnExport" class="btn btn-secondary btn-sm"><i class="fa fa-file-excel"></i>Export</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
            <div class="card-body">
                <div class="col-md-12 table-responsive">
                    <table class="table datatables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Lulus</th>
                                <th>No Regis.</th>
                                <th>Nama</th>
                                <th>Sekolah Dituju</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($all as $val)
                            @php
                                $adr = \App\Models\Address::where('pid',$val['pid'])->first();
                                $adr = (!empty($adr)) ? $adr : array('address'=>'');
                                // $disditerima = 'disabled';
                                // $btnditerima = ' btn-disable';
                                $disditerima = (auth()->user()->role=='1'||auth()->user()->like_admin=='1') ? '' : 'disabled="disabled"';
                                $btnditerima = (auth()->user()->role=='1'||auth()->user()->like_admin=='1') ? '' : ' btn-disable';
                                $hrefditerima = (auth()->user()->role=='1'||auth()->user()->like_admin=='1') ? 'javascript:lulus('.$val['pid'].','."'".str_replace("'","",$val['name'])."'".')' : '#';
                                $pembayaran = ($val['invoice_id']=='') ? 'secondary' : 'success';
                                $akunortu = ($val['role']!='2') ? 'secondary' : 'success';
                            @endphp
                                <tr>
                                    {{-- <td><input type="checkbox" style="form-control-check" value="1" name="chk{{ $val['id'] }}" id="chk{{ $val['id'] }}"></td> --}}
                                    <td>{{ $no }}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Pembayaran Pendaftaran" class="btn btn-sm btn-{{ $pembayaran }}"><i class="fas fa-file-invoice-dollar"></i></a>
                                        {{-- <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Akun Orang Tua" class="btn btn-sm btn-{{ $akunortu }}"><i class="far fa-user-circle"></i></a> --}}
                                    </td>
                                    <td>
                                        <input type="hidden" id="is_granted{{ $val['pid'] }}" value="{{ $val['is_granted'] }}">
                                        @if ($val['is_granted']=='1')
                                        <button type="button" onclick="tidaklulus({{ $val['pid'] }},'{{ $val['name'] }}')" class="btn btn-sm btn-success {{ $btnditerima }}" {{ $disditerima }}><i class="fa fa-check"></i></button>
                                        {{-- <input type="hidden" id="nis{{ $val['pid'] }}" value="{{ $val['nis'] }}"> --}}
                                        {{-- <input type="hidden" id="nisn{{ $val['pid'] }}" value="{{ $val['nisn'] }}"> --}}
                                        @else
                                        <span id="tombolLulus{{ $val['pid'] }}"><a href="{{ $hrefditerima }}" class="btn btn-sm bg-gradient-red text-white{{ $btnditerima }}" {{ $disditerima }}><i class="fa fa-gear"></i></a></span>
                                        @endif
                                    </td>
                                    <td>{{ $val['regid'] }}</td>
                                    <td>{{ $val['name'] }} {!! ($val['is_accepted']=='1') ? '<span class="badge badge-info">siswa</span>' : '' !!}</td>
                                    {{-- <td title="{{ $adr['address'] }}"><span class="d-inline-block text-truncate" style="max-width: 150px;">{{ $adr['address'] }}</span></td> --}}
                                    <td>{{ $val['school_name'] }}</td>
                                    <td>
                                        {{-- <div class="btn-group text-white" role="group" aria-label="Basic example">
                                        <a href="{{ route('ppdb.edit',['id'=>$val['pid']]) }}" type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Klik untuk Edit Profil"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url('ppdb/'.$val['pid'].'/pembayaran') }}" type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Pembayaran"><i class="fa fa-hand-holding-usd"></i></a>
                                        </div> --}}
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="{{ route('ppdb.edit',['id'=>$val['pid']]) }}" class="dropdown-item" style="color:black;"><i class="fa fa-pencil"></i> Edit</a>
                                                <a href="{{ url('ppdb/'.$val['pid'].'/pembayaran') }}" class="dropdown-item" style="color:black"><i class="fa fa-hand-holding-usd"></i> Pembayaran</a>
                                                @if ($val['invoice_id']=='')
                                                <a href="{{ url('ppdb/'.$val['pid'].'/hapus') }}" onclick="return confirm('Yakin akan dihapus?')" class="dropdown-item" style="color:black"><i class="fa fa-trash"></i> Hapus</a>
                                                @endif
                                                @if ($val['is_granted']=='1')
                                                <a href="javascript:terima({{ $val['pid'] }})" class="dropdown-item" style="color:black"><i class="fas fa-check-double"></i> Jadikan Siswa</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah</h5>
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
                            @foreach ($ay as $it)
                            <option value="{{ $it->id }}">{{ $it->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Ppdb</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="desc">Deskripsi</label>
                        <textarea name="desc" id="desc" class="form-control form-control-sm"></textarea>
                    </div>
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
                <div class="form-group" id="tabel-item">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Item Biaya</th>
                                        <th style="width:40%">Jumlah</th>
                                        <th style="width:20%">#</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">

                                </tbody>
                                <tfoot id="tfoot">
                                    <tr>
                                        <form action="" id="frmItem" class="form-group form-sm">
                                            <td>
                                                <select name="pilihitem" id="pilihitem" class="form-control form-control-sm">
                                                    <option value=""></option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="jumlahitem" id="jumlahitem"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <button type="button" id="tambahitem" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </form>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="diterimaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Status Diterima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <p>Dengan ini, ditentukan bahwa calon dibawah ini : </p> --}}
                <div class="table-responsive tableisi"></div>
                <hr style="margin:5px;margin-bottom:10px">
                <form id="frmDiterima">
                    <input type="hidden" value="" id="idditerima">
                    <p>Pilih diterima atau tidak, lalu isi NIS &amp; NISN (jika ada), tekan tombol Simpan NIS &amp; NISN
                    </p>
                    <fieldset class="form-group row" style="margin:0px;">
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="diterima" id="checkditerima" value="1" onchange="enable()">
                                <label class="form-check-label" for="checkditerima">Diterima </label>
                            </div>
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="radio" name="diterima" id="radios0" value="0" onchange="enable(0)">
                                <label class="form-check-label" for="radios2">
                                    Tidak Diterima
                                </label>
                            </div> --}}
                        </div>
                    </fieldset>
                    <hr style="margin:5px;margin-bottom:10px">
                    <div id="formlainnya">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label col-form-label-sm">NIS</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" disabled id="nisditerima" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label col-form-label-sm">NISN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" disabled id="nisnditerima" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <button type="button" class="btn btn-primary" onclick="simpannis()"><i class="fa fa-save"></i> Terima Siswa</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function pilihbiaya(id,am)
    {
        check = $('#check'+id).prop('checked');
        total = parseFloat($('#totalit').html());
        total = (check) ? total+parseFloat(am) : total-parseFloat(am);
        $('#totalit').html(total);
    }
    function eInd(x){
        return x.toLocaleString('id-ID');
    }
    function enable()
    {
        i = $('#radios1').prop('checked');
        if(i===false)
        {
            $('#formlainnya').find('input,select,button').each(function () {
                $(this).attr('disabled', 'disabled');
                $(this).addClass('disabled');
            });
        }
        else
        {
            $('#formlainnya').find('input,select,button').each(function () {
                $(this).removeAttr('disabled');
                $(this).removeClass('disabled');
            });
        }
    }
    $(function() {
       
    });
    $('#createNew').on('click',function(){
        $('#id').val('');
        $('#tambahModalLabel').html('Tambah');
        $('#frmTambah').trigger('reset');
        $('#tambahModal').modal('show');
        $('#simpan').html('<i class="fa fa-save"></i> Tambah');
        $('#tabel-item').hide();
    })
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
                edit(datas[1]);
            }
            else
            {
                msgError(data);
            }
        })
    });
    $('#btnExport').on('click',function(){
        idsekolah = $('#sekolah').val();
        window.open("{{ url('ppdb/export/siswa/') }}/"+idsekolah, "_blank");
    });
    function terima(ids)
    {
        $('#frmDiterima').trigger('reset');
        diterima = $('#is_accepted'+ids).val();
        $('#nisditerima').val($('#nis'+ids).val());
        $('#nisnditerima').val($('#nisn'+ids).val());
        $.post('{{ url('ppdb') }}/'+ids+'/load',{'_token':'{{ csrf_token() }}','type':'data'},function(data){
            datas = data.split('|^|');
            $('.tableisi').html(datas[0]);
            $('#idditerima').val(ids);
            if(datas[1]=='1')
            {
                $('#checkditerima').prop('checked',true);
                $('#checkditerima').attr('disabled');
                $('#formlainnya').find('input,select,button').each(function () {
                    $(this).attr('disabled', 'disabled');
                    $(this).addClass('disabled');
                });
            }
            if(datas[2]!=undefined)
            {
                datass = datas[2].split(',');
                $('#nisditerima').val(datass[0]);
                $('#nisnditerima').val(datass[1]);
            }
            $('#diterimaModal').modal('show');
        });
    }

    function lulus(ids,nama)
    {
        if(confirm('Betul akan meluluskan '+nama+' ?'))
        {
            $.post('{{ url('ppdb') }}/'+ids+'/lulus',{'_token':'{{ csrf_token() }}'},function(data){
                if(data=='Berhasil')
                {
                    msgSukses(nama+' lulus');
                    location.reload();
                }
                else
                {
                    msgError(data);
                }
            });
        }
    }
    function tidaklulus(ids,nama)
    {
        if(confirm('Betul akan mentidakluluskan '+nama+' ?'))
        {
            $.post('{{ url('ppdb') }}/'+ids+'/lulus',{'_token':'{{ csrf_token() }}'},function(data){
                if(data=='Berhasil')
                {
                    msgSukses(nama+' tidak lulus');
                    location.reload();
                }
                else
                {
                    msgError(data);
                }
            });
        }
    }
    function simpannis()
    {
        id = $('#idditerima').val();
        nis = $('#nisditerima').val();
        if(nis=='')
        {
            alert('Isi NIS!');
            $('#nisditerima').focus();
            return;
        }
        nisn = $('#nisnditerima').val();
        // if(nisn=='')
        // {
        //     alert('Isi NISN!');
        //     $('#nisnditerima').focus();
        //     return;
        // }
        $.post('{{ url('ppdb') }}/'+id+'/diterima',{'_token':'{{ csrf_token() }}',id:id,nis:nis,nisn:nisn},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil diterima');
                location.reload();
            }
            else
            {
                msgError(data);
            }
        })
    }
    function edit(id)
    {
        $.post('{{ url('ppdb/setting/get') }}',{"_token":"{{ csrf_token() }}",id:id},function(data){
            datas = $.parseJSON(data);
            var options = ''; table = '';
            $('#tambahModalLabel').html('Update');
            $('#id').val(datas['id']);
            $('#ayid option[value="'+datas['ayid']+'"]').prop('selected',true);
            $('#name').val(datas['name']);
            $('#desc').val(datas['desc']);
            $('#start_date').val(datas['start_date']);
            $('#end_date').val(datas['end_date']);
            $('#simpan').html('<i class="fa fa-pencil"></i> Update');
            $('#tambahModal').modal('show');
            $('#tabel-item').show();
            for(var i=0;i<datas['cost'].length;i++)
            {
                table += "<tr>";
                table += '<td style="width:40%">'+datas['cost'][i]['name']+'</td>';
                table += '<td style="width:40%">'+datas['cost'][i]['amount']+'</td>';
                table += '<td style="width:20%"><a href="#" class="btn btn-danger btn-sm" onclick="hapusitem('+datas['id']+','+datas['cost'][i]['cost_id']+')" alt="Hapus Item '+datas['cost'][i]['name']+'"><i class="fa fa-times"></i></a></td>';
                table += "</tr>";
            }
            $('#tbody').html(table);
            for (var i = 0; i < datas['allcost'].length; i++) {
                options += '<option value="' + datas['allcost'][i]['id'] + '">' + datas['allcost'][i]['name'] + '</option>';
            }
            $("#pilihitem").html(options);
        });
    }
    function hapus(id)
    {
        if(confirm('Hapus PPDB Set?'))
        {
            $.post('{{ url('ppdb/setting/hapus') }}',{"_token":"{{ csrf_token() }}",id:id},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Berhasil hapus!');
                    window.location.href = "{{ url('ppdb/setting') }}";
                }
                else
                {
                    msgError(data);
                }
            });
        }
    }
    function hapusitem(id,ids)
    {
        if(confirm('Hapus Item?'))
        {
            $.post('{{ url('ppdb/setting/hapusitem') }}',{"_token":"{{ csrf_token() }}",id:id,ids:ids},function(data){
                if(data=='Berhasil')
                {
                    getitemsetting(id);
                }
                else
                {
                    msgError(data);
                }
            });
        }
    }
    $('#tambahitem').on('click',function(){
        frmi = $('#frmItem').serialize();
        am = $('#jumlahitem').val();
        id = $('#id').val();
        if(am==''||am=='0')
        {
            alert('Isi Nominal Item Biaya!');
            return;
        }
        $.post('{{ url('ppdb/setting/tambahitem') }}',{"_token":"{{ csrf_token() }}",id:id,data:frmi},function(data){
            datas = data.split('|')
            if(datas[0]=='Berhasil')
            {
                getitemsetting(datas[1]);
            }
            else
            {
                msgError(data);
            }
        })
    })
    function getitemsetting(id)
    {
        $.post('{{ url('ppdb/setting/getitem') }}',{"_token":"{{ csrf_token() }}",id:id},function(data){
            datas = $.parseJSON(data);
            var table='';
            for(var i=0;i<datas.length;i++)
            {
                table += "<tr>";
                table += '<td style="width:40%">'+datas[i]['name']+'</td>';
                table += '<td style="width:40%">'+datas[i]['amount']+'</td>';
                table += '<td style="width:20%"><a href="#" class="btn btn-danger btn-sm" onclick="hapusitem('+id+','+datas[i]['id']+')" alt="Hapus Item '+datas[i]['name']+'"><i class="fa fa-times"></i></a></td>';
                table += "</tr>";
            }
            $('#tbody').html(table);
        })
    }
</script>
@endpush
