@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.datepicker')

@push('css')
<style>
    @media (min-width: 768px) {
        .modal-xl {
            width: 90%;
            max-width:1200px;
        }
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url($aktif) }}">Raport Rekap</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ url('cek-mahmul') }}" class="btn btn-sm btn-warning" target="_blank"><i class="fas fa-sync"></i> Sesuaikan</a>
                        @if ($req->filter)
                        <a href="{{ url('rekap-mahmul?pilihkelas='.$req->pilihkelas.'&pilihpelajaran='.$req->pilihpelajaran.'&filter=yes&file=xls') }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> XlS</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Rekap Mahmul</h3>
                    <form action="" method="GET" style="padding-bottom: 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="staticLembaga" class="sr-only">Kelas</label>
                                            <select name="pilihkelas" id="pilihkelas" class="form-control">
                                                <option value="0"> - Pilih Salah Satu Kelas - </option>
                                                @foreach ($kelas as $k=>$v)
                                                @php
                                                    $selected = ($v->id==$pilihkelas) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $v->id }}" {{ $selected }}>{{ $v->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="staticLembaga" class="sr-only">Mata Pelajaran</label>
                                            <select name="pilihpelajaran" id="pilihpelajaran" class="form-control">
                                                <option value="0"> - Pilih Salah Satu Pelajaran - </option>
                                                @foreach ($pelajaran as $k=>$v)
                                                @php
                                                    $selected = ($v->id==$pilihpelajaran) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $v->id }}" {{ $selected }}>{{ $v->name . ' (' . $v->name_ar.')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" name="filter" value="yes" class="btn btn-primary"><i class="fa fa-check"></i> Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-items-center datatables">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa / Kelas</th>
                                    <th style="width:60%;">Mata Pelajaran Mahmul / Nilai Awal / Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $nox = 1;
                                @endphp
                                @foreach ($siswa as $k=>$v)
                                    @foreach($student as $ks=>$vs)
                                        @if ($v['id'] == $ks)
                                            <tr>
                                                <td valign="top">{{ $nox }}</td>
                                                <td valign="top">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            {{ $v['name'] }}
                                                        </div>
                                                        <div class="col-sm-6 arabic text-right">
                                                            {{ $v['name_ar'] }}
                                                            <br>
                                                            <i>({{ $v['class_name'].' / '.$v['desc_ar'] }})</i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul class="list-group list-group-flush">
                                                        @php
                                                            $mahmuls = collect($mahmul)->where('sid',$v['id'])->sortBy([['nameay'],['tid'],['pelajaran']]);
                                                            $mahmulsatu = collect($mahmuls)->groupBy('course_subject_id');
                                                        @endphp
                                                        @foreach($mahmulsatu as $km=>$vm)
                                                        <li class="list-group-item" id="li-{{ $vm[0]['id'] }}">
                                                            <div class="form-group row" style="margin:0px;">
                                                                <div class="col-md-12 card-head">
                                                                    <label for="grade_after{{ $vm[0]['id'] }}" class="col-form-label float-left">
                                                                        <span class="arabic">{{ $vm[0]['pelajaran_ar'] }}</span>
                                                                        <br>
                                                                        <span>{{ $vm[0]['ayidname'] }} - Semester {{ $vm[0]['tid'] }}</span>
                                                                    </label>
                                                                    {{-- <span class="float-right alight-right">
                                                                        <button class="btn btn-success btn-sm"><i class="fas fa-sync-alt"></i></button>
                                                                    </span> --}}
                                                                </div>
                                                                <div class="col-md-12 card-body">
                                                                    @php
                                                                        $jumlahayid = count($vm);
                                                                        $no = 0;
                                                                        foreach($vm as $kmd=>$vmd):
                                                                    @endphp
                                                                    @php
                                                                        // echo $no;
                                                                    // if($vmd['grade_after']!='0')
                                                                    //     dd($vmd);
                                                                    @endphp
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            {{ $vmd['ayidname'] }} - {{ $vmd['tid'] }}
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <input type="number" readonly class="form-control form-control-sm" value="{{ $vmd['grade_before'] }}">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <input type="number" max="100" class="form-control form-control-sm" name="grade_after[{{ $vmd['id'] }}]" id="grade_after{{ $vmd['id'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" onkeyup="if(this.value>100)this.value=100;" value="{{ $vmd['grade_after'] }}">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            @if ($no+1 >= $jumlahayid)
                                                                            <input class="form-check-input" data-toggle="tooltip" data-placement="top" title="Luluskan {{ $vmd['name'] }}" type="checkbox" value="1" id="lulus{{ $vmd['id'] }}" style="width:20px;height:20px;" {{ ($vmd['is_passed']!=''&&$vmd['is_passed']!='0') ? 'checked="checked"' : '' }} >
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            @php
                                                                                $no++;
                                                                            @endphp
                                                                            @if ($jumlahayid==$no)
                                                                            <button onclick="simpanmahmul({{ $vmd['id'] }},{{ $vmd['ayid'] }},{{ $vmd['tid'] }})" id="btnsave{{ $vmd['id'] }}" type="button" class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        endforeach;
                                                                    @endphp
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @php
                                            $nox++;
                                        @endphp
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function simpanmahmul(id,ayid,tid)
    {
        nilai = $('#grade_after'+id).val();
        if(nilai==''||nilai=='0')
        {
            alert('Isi Nilai untuk referensi!');
            return;
        }
        $.post('{{ url('cekpublikasi') }}',{"_token": "{{ csrf_token() }}",mode:'UAS'},function(data){
            if(data==0||data=='') {
                alert('Gagal simpan, Nilai raport UAS belum di publikasi dan di kunci. Hubungi Admin!');
                location.reload();
                // $('#grade_after'+id).val('0');
                // $('#lulus'+id).prop('checked',false);
                return;
            }
            else
            {
                lulus = ($('#lulus'+id).is(':checked')) ? '1' : '0';
                // $('#btnsave'+id).attr('disabled','disabled');
                // $('#btnsave'+id).html('<i class="fas fa-sync fa-spin"></i>');
                $.post('{{ url('rekap-mahmul-exec') }}',{"_token": "{{ csrf_token() }}",id:id,nilai:nilai,lulus:lulus},function(data){
                    if(data=='Berhasil')
                    {
                        // $('#btnsave'+id).removeAttr('disabled','disabled').html('<i class="fa fa-save"></i>');
                    }
                    else
                    {
                        $('#grade_after'+id).focus();
                        // $('#btnsave'+id).removeAttr('disabled').html('<i class="fa fa-save"></i>');
                    }
                });
            }
        });
    }
</script>
@endpush
