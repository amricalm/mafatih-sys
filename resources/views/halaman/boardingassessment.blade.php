@extends('layouts.app')
@include('komponen.daerah')
@include('komponen.select2')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __($judul) }}</a></li>
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
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Catatan : </strong> Nilai tidak akan masuk ke raport, sebelum di-<b>Proses Nilai</b>
                            @if($cekmusyrif)
                                . Klik <a href="{{ url('prosesnilai') }}" class="alert-link">disini</a> untuk proses nilai 
                            @endif
                            <b>(Proses Nilai Pengasuhan hanya untuk Musyrif Sakan).</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="col-md-12">
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="class">Musyrif Sakan</label>
                                            <select name="class" id="class" class="form-control form-control-sm">
                                                <option value=""> - Pilih salah satu - </option>
                                                @foreach($employe as $key => $value)
                                                    <option value="{{ $value['id'] }}"{{ ($value['id']==$req->class)?' selected="selected"':'' }}>{{ $value['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="periode">Periode</label>
                                            <select name="periode" id="periode" class="form-control form-control-sm" required>
                                                <option value=""> - Pilih salah satu - </option>
                                                    @foreach($periode as $key => $value)
                                                        @php
                                                        $periode = \App\SmartSystem\General::periode($value->periode);
                                                        @endphp
                                                        <option value="{{ $value['periode'] }}"{{ ($value['periode']==$req->periode)?' selected="selected"':'' }}>{{ $periode }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="form-control-label" for="student">Santri</label>
                                            <select name="student" id="student" class="form-control select2 form-control-sm" required>
                                                <option value=""> - Pilih salah satu - </option>
                                                    @foreach($student as $key => $value)
                                                        <option value="{{ $value['id'] }}"{{ ($value['id']==$req->student)?' selected="selected"':'' }}>{{ $value['nis'] }} - {{ $value['name_ar'] }}</option>
                                                    @endforeach
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
                                    <input type="hidden" name="ccid" value="{{ $req->class }}">
                                    <input type="hidden" name="periode_id" value="{{ $req->periode }}">
                                    <input type="hidden" name="student_id" value="{{ $req->student }}">
                                    <table class="table table-stripe">
                                        <thead>
                                            <tr>
                                                <th width="10%">No.</th>
                                                <th>Aktifitas Santri</th>
                                                <th>Target</th>
                                                <th>Kehadiran</th>
                                                <th>Rukhshah</th>
                                                <th>Capaian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; $total=0; $jmh=0; @endphp
                                            @foreach($activity as $key => $value)
                                                @php
                                                    $score = is_numeric($value['score']) ? $value['score'] : 0;
                                                    $remission = is_numeric($value['remission']) ? $value['remission'] : 0;
                                                    $total = $score + $remission;
                                                    $over = '';
                                                    if($total > $value['score_total']) {
                                                        $over = 'text-danger';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $value['name'] }}</td>
                                                    <td><input type="text" class="form-control form-control-sm text-center" name="target[{{ $value['id'] }}]" style="width:50px" value="{{ $value['score_total'] ?? '' }}" readonly></td>
                                                    <td>
                                                        <input type="number" max="31" class="form-control form-control-sm" name="val[{{ $value['id'] }}]" id="val{{ $value['id'] }}HDR" style="width:70px" value="{{ $value['score'] ?? '' }}">
                                                        <input type="hidden" class="form-control form-control-sm text-right" id="weight{{ $value['id'] }}HDR" value="{{ $value['score'] ?? 0 }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" max="31" class="form-control form-control-sm" name="rem[{{ $value['id'] }}]" id="val{{ $value['id'] }}RSH" style="width:70px" value="{{ $value['remission'] ?? '' }}">
                                                        <input type="hidden" class="form-control form-control-sm text-right" id="weight{{ $value['id'] }}RSH" value="{{ $value['remission'] ?? 0 }}">
                                                    </td>
                                                    <td>
                                                    <input type="text" class="form-control form-control-sm text-center {{ $over }}" name="gradeval[]" id="gradeval{{ $value['id'] }}" style="width:70px;" value="{{ round($total) }}" readonly></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="{{ $no+3 }}" class="text-right" >
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
                                            <a href="{{ url('rombel-pengasuhan/'.$req->class.'/export/'.$req->periode) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> Santri</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            Isi data-data nilai yang ada disamping Nama.
                                            <img src="{{ asset('uploads/copy-paste-santri-input-nilai-pengasuhan.png') }}" alt="ilustrasi" width="100%">
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
    $('#class').change(function(){
        id = $(this).val();
        $.post('{{ url('pemetaanpengasuhan') }}/'+id+'/darikelas',{"_token": "{{ csrf_token() }}"},function(data){
            if(data !== null)
            {
                data = jQuery.parseJSON(data);
                $('#student option:not(:first)').remove();
                $.each(data,function(i, datas){
                    $('#student').append($('<option>',{value:datas.id,text:datas.nis+' - '+datas.name_ar}));
                });
            }
        });
    });
    $('#btnSave').click(function(e){
        var mode = "UAS";
        cekpublikasi(mode,'simpan');
    });

    $('#btnProses').click(function(e) {
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
                    var el = $('#btnSave');
                    el.addClass('disabled');
                    el.html("<i class='fa fa-spinner fa-spin'></i> Sedang proses ...");
                    simpannilai();
                }
                else if(type=='import')
                {
                    var el = $('#btnProses');
                    el.addClass('disabled');
                    el.html("<i class='fa fa-spinner fa-spin'></i> Sedang proses ...");
                    importnilai();
                }
            }
        })
    }

    function simpannilai()
    {
        frm = $('#frmSimpan').serialize();
        $.post('{{ url('inputnilai-pengasuhan/simpan') }}',{"_token": "{{ csrf_token() }}",'data':frm},function(data){
           if(data=='Berhasil'){
                msgSukses('Penilaian berhasil disimpan');
                location.reload();
            }else if(data=='LebihDariTarget'){
                msgSukses('Berhasil import nilai & sistem mengkosongkan nilai yang melebihi target');
                location.reload();
            } else {
                msgError('Mohon dilaporan!');
            }
        });
    }

    function importnilai()
    {
        var file_data = $('#file').prop('files')[0];
        if(typeof file_data!=="undefined") {
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append("_token","{{ csrf_token() }}");

            $.ajax({
                url: '{{ route('uploadnilaipengasuhan') }}',
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
                            el.html("<i class='fa fa-gear'></i> Proses Impor");
                        }else if(response=='LebihDariTarget'){
                            msgSukses('Berhasil import nilai & sistem mengkosongkan nilai yang melebihi target');
                            location.reload();
                            el.html("<i class='fa fa-gear'></i> Proses Impor");
                        } else {
                            msgError('Mohon dilaporan!');
                        }
                    },
                    error: function(response) {
                        console.log('Error:', response);
                        msgError('Proses Import Gagal');
                        // location.reload();
                        el.html("<i class='fa fa-gear'></i> Proses Impor");
                    }
            });
        } else {
            msgError('Tidak ada file yang diupload');
        }
    }
</script>
@endpush
