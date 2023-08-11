@extends('layouts.app')
@include('komponen.daerah')

@section('content')
<div class="container-fluid pt-7" style="margin-bottom:50px;">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('bayanat-quran') }}">Bayanat Quran</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="pengampu">Pengampu</label>
                                            <select name="pengampu" id="pengampu" class="form-control form-control-sm" required>
                                                <option value=""> - Pilih salah satu - </option>
                                                @if(!empty($mapping))
                                                    @foreach($mapping as $key => $value)
                                                        <option value="{{ $value['id'] }}"{{ ($value['id']==$pilihGuru)?' selected="selected"':'' }}>{{ $value['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="class">Halqoh</label>
                                            <select name="class" id="class" class="form-control form-control-sm" required>
                                                <option value=""> - Pilih salah satu - </option>
                                                @php
                                                    if($req->post())
                                                    {
                                                        $kelasss = collect($kelas)->where('pid',$pilihGuru);
                                                        foreach($kelasss as $k=>$v)
                                                        {
                                                            $selected = ($v['id']==$pilihlevel) ? 'selected="selected"' : '';
                                                            echo '<option value="'.$v['id'].'" class="arabic"'.$selected.'>'.$v['name'].':'.$v['name_ar'].'</option>';
                                                        }
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>
                                    @php
                                        $c = '12';
                                    @endphp
                                    @if ($req->post())
                                        <div class="col-md-6">
                                            <a href="#" data-toggle="modal" data-target="#modalImport" class="btn btn-sm btn-secondary"><i class="fas fa-file-excel"></i> Impor dari Excel</a>
                                        </div>
                                        @php $c = '6'; @endphp
                                    @endif
                                    <div class="col-md-{{ $c }} text-right">
                                        <button type="submit" class="btn btn-warning btn-sm" id="filter"><i class="fa fa-filter"></i> Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-12 table-responsive">
                                @if(!empty($student))
                                <form id="frmSimpan" name="frmSimpan">
                                    @csrf
                                    <input type="hidden" name="ccid" value="{{ $pilihlevel }}">
                                    <input type="hidden" name="eid" value="{{ $pilihGuru }}">
                                    <table class="table table-stripe table-sm">
                                        <thead>
                                            <tr>
                                                <th width="10%">No.</th>
                                                <th>Nama</th>
                                                {{-- <th> --}}
                                                @foreach($grade as $key => $value)
                                                    <th>
                                                        <span class="arabic" style="font-size:15px !important;">{{ $value['name_ar'] }}</span>
                                                    </th>
                                                @endforeach
                                                {{-- </th> --}}
                                                {{-- <th>Nilai Akhir</th> --}}
                                                <th width="25%">Catatan</th>
                                                <th width="15%">Juz Sudah Tasmik</th>
                                                {{-- <th width="15%">Hasil Total</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1;@endphp
                                            @foreach($student as $key => $value)
                                                @php
                                                    $total = 0; $jmh=0;
                                                @endphp
                                                <tr>
                                                    <input type="hidden" name="pid[]" id="pid{{ $value['id'] }}" value="{{ $value['id'] }}">
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $value['name'] }}</td>
                                                    {{-- <td>
                                                        @foreach($grade as $ke => $va)
                                                        @php
                                                            $jmh++;
                                                            $nilai = '0';
                                                            if(!is_null($assessment))
                                                            {
                                                                $awal = $assessment->where('pid',$value['id'])
                                                                    ->where('sub',$va['id'])->toArray();
                                                                if(count($awal)>0)
                                                                {
                                                                    $awal = reset($awal);
                                                                    $nilai = $awal['grade'];
                                                                }
                                                            }
                                                            $weight = $va['weight'];
                                                        @endphp
                                                        <div class="form-group row">
                                                            <label for="inputEmail3" class="col-sm-2  col-form-label">{{ $value['name_ar'] }}</label>
                                                            <div class="col-sm-10"><input type="number" min="0" max="100" class="form-control form-control-sm text-right" name="val[{{ $value['id'] }}][{{ $va['id'] }}]" id="val{{ $value['id'] }}{{ $va['id'] }}" style="width:70px" value="{{ $nilai }}" onblur="akumulasi({{ $value['id'] }})" onkeyup="if(this.value>100)this.value=100;" value="{{ $nilai }}"></div>
                                                            <input type="hidden" class="form-control form-control-sm text-right" id="weight{{ $value['id'] }}{{ $va['id'] }}" value="{{ $va['weight'] }}">
                                                        </div>
                                                        @endforeach
                                                    </td> --}}
                                                    {{-- <td> --}}
                                                    @foreach($grade as $ke => $va)
                                                        @php
                                                            $jmh++;
                                                            $nilai = '0';
                                                            if(!is_null($assessment))
                                                            {
                                                                $awal = $assessment->where('pid',$value['id'])
                                                                    ->where('sub',$va['id'])->toArray();
                                                                if(count($awal)>0)
                                                                {
                                                                    $awal = reset($awal);
                                                                    $nilai = $awal['grade'];
                                                                }
                                                            }
                                                            $weight = $va['weight'];
                                                        @endphp
                                                    <td>
                                                        <input type="number" min="0" max="100" class="form-control form-control-sm text-right float-left" name="val[{{ $value['id'] }}][{{ $va['id'] }}]" id="val{{ $value['id'] }}{{ $va['id'] }}" style="width:60px" value="{{ $nilai }}" onblur="akumulasi({{ $value['id'] }})" onkeyup="if(this.value>100)this.value=100;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" value="{{ $nilai }}">
                                                        <input type="hidden" class="form-control form-control-sm text-right" id="weight{{ $value['id'] }}{{ $va['id'] }}" value="{{ $va['weight'] }}">
                                                    </td>
                                                    @endforeach
                                                    {{-- </td> --}}
                                                    {{-- <td><input type="number" class="form-control form-control-sm text-right" name="gradeval[]" id="gradeval{{ $value['id'] }}" style="width:60px;" value="{{ ($total) }}" readonly></td> --}}
                                                    @php
                                                        $onecatatan = '';
                                                        $onejuz = '';
                                                        $oneresult = '';
                                                        if($catatan!=null)
                                                        {
                                                            for($i=0;$i<count($catatan);$i++)
                                                            {
                                                                if($catatan[$i]['pid']==$value['id'])
                                                                {
                                                                    $onecatatan = $catatan[$i]['result_notes'];
                                                                    $onejuz = $catatan[$i]['juz_has_tasmik'];
                                                                    $oneresult = $catatan[$i]['result_decision_level'];
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <td><textarea class="form-control" name="catatan[{{ $value['id'] }}]" id="catatan{{ $value['id'] }}" rows="2">{{ $onecatatan }}</textarea></td>
                                                    <td><input type="number" class="form-control form-control-sm text-right" name="juz_has_tasmik[{{ $value['id'] }}]" id="juz_has_tasmik{{ $value['id'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  pattern="[0-9]+" onkeyup="if(this.value>30)this.value=30;" value="{{ $onejuz }}" ></td>
                                                    {{-- <td>
                                                        <select name="result_decision_level[{{ $value['id'] }}]" id="result_decision_level{{ $value['id'] }}" class="form-control form-control-sm text-right">
                                                            <option value=""> - Pilih Salah Satu - </option>
                                                            @php
                                                                $pilihan = \App\SmartSystem\General::pilihan('sempurna');
                                                                foreach($pilihan as $it)
                                                                {
                                                                    $selected = ($oneresult==$it) ? 'selected="selected"' : '';
                                                                    echo '<option value="'.$it.'" '.$selected.'>'.$it.'</option>';
                                                                }
                                                            @endphp
                                                        </select>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="{{ $no+5 }}" class="text-right" >
                                                    <button type="button" class="btn btn-primary" id="btnSave"><i class="fa fa-save"></i> Simpan</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                            Download Data Santri >>>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <a href="{{ url('bayanat-quran/halaqah/export/'.$pilihGuru.'/'.$pilihlevel) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> Santri</a>
                                        </div>
                                    </div>
                                </li>
                                {{-- <li>
                                    <div class="row p-2">
                                        <div class="col-md-9">
                                            Download Template Input Nilai >>>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <a href="{{ asset('uploads/templates/inputnilai.xlsx') }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> Template</a>
                                        </div>
                                    </div>
                                </li> --}}
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            Isi data-data nilai yang ada disamping Nama.
                                            <img src="{{ asset('uploads/copy-paste-santri-input-nilai.png') }}" alt="ilustrasi" width="100%">
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
<script>
    var lvl = {!! json_encode($kelas) !!};
    $('#pengampu').on('change',function(){
        v = $(this).val();
        $('#class option:not(:first)').remove();
        $.each(lvl,function(index,value){
            if(v==value.pid)
            {
                $('#class').append('<option value="'+value.id+'" class="arabic">'+value.name_ar+':'+value.name+'</option>');
            }
        });
    })
    // $('#class').change(function(){
    //     id = $(this).val();
    //     $.post('{{ url('pemetaanpelajaran') }}/'+id+'/darikelas',{"_token": "{{ csrf_token() }}"},function(data){
    //         if(data !== null)
    //         {
    //             data = jQuery.parseJSON(data);
    //             $('#subject option:not(:first)').remove();
    //             $.each(data,function(i, datas){
    //                 $('#subject').append($('<option>',{value:datas.id,text:datas.name}));
    //             });
    //         }
    //     });
    // });
    $('#btnSave').click(function(){
        var mode = "UAS";
        cekpublikasi(mode,'simpan');
    });
    $('#btnProses').on('click',function(){
        var mode = "UAS";
        cekpublikasi(mode,'import');
    });

    function cekpublikasi(mode,type)
    {
        $.post('{{ url('cekpublikasi') }}',{"_token": "{{ csrf_token() }}",mode:mode},function(data){
            if(data==1) {
                alert('Nilai raport '+mode+' sudah di publikasi dan di kunci. Hubungi Admin!');
                location.reload(true);
            }
            else
            {
                if(type=='simpan')
                {
                    simpannilai();
                }
                else if(type=='import')
                {
                    importnilai();
                }
            }
        })
    }

    function simpannilai()
    {
        frm = $('#frmSimpan').serialize();
        yes = 1;
        $('input[name^="val"]').each(function(){
            vall = $(this).val();
            if(vall>100)
            {
                yes = 0;
                $(this).focus();
                return;
            }
        });
        if(yes==1)
        {
            $.post('{{ url('bayanat-quran/penilaian/simpan') }}',{"_token": "{{ csrf_token() }}",'type':'simpan','data':frm},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Penilaian berhasil disimpan');
                    location.reload(true);
                }
                else
                {
                    msgError(data);
                }
            });
        }
        else
        {
            alert('Tidak boleh lebih dari 100!');
        }
    }

    function importnilai()
    {
        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append("_token","{{ csrf_token() }}");

        $.ajax({
            url: '{{ route('uploadnilaibayanat') }}',
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
                        msgError('Mohon dilaporan!');
                    }
                },
        });    
    }

    function akumulasi(id)
    {
        jumlah = 0;
        $('input[id^=val'+id+']').each(function(){
            iddd = $(this).attr('id').split('val');
            valu = $(this).val();
            weig = $('#weight'+iddd[1]).val();
            jumlah += (valu*weig)/100;
        })
        $('#gradeval'+id).val(jumlah);
    }
</script>
@endpush
