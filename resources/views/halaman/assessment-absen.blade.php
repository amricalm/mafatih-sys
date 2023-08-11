@extends('layouts.app')
@include('komponen.daerah')

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
                        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="class">Kelas</label>
                                            <select name="class" id="class" class="form-control form-control-sm" required>
                                                <option value=""> - Pilih salah satu - </option>
                                                @foreach($kelas as $key => $value)
                                                    <option value="{{ $value['id'] }}"{{ ($value['id']==$req->class)?' selected="selected"':'' }}>{{ $value['name'] }}</option>
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
                                            <a href="{{ url('rombel/'.$req->class.'/export/lainnya/xls') }}" class="btn btn-sm btn-secondary"><i class="fas fa-file-export"></i> Ekspor Data</a>
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
                            <div class="col-md-12 p-3">
                                <nav>
                                    <ul class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active p-3" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                                            aria-controls="nav-home" aria-selected="true">Absen (Nilai Angka)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link p-3" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                                            aria-controls="nav-profile" aria-selected="false">Perilaku (Nilai Huruf)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link p-3" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
                                            aria-controls="nav-contact" aria-selected="false">Lainnya</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link p-3" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab"
                                            aria-controls="nav-notes" aria-selected="false">Catatan Wali Kelas</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-md-12">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active row" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="col-md-12 table-responsive">
                                            @if(!empty($student))
                                            <form id="frmabsen" name="frmabsen">
                                                <input type="hidden" name="ccid" value="{{ $req->class }}">
                                                <table class="table table-stripe">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">No.</th>
                                                            <th width="60%">Nama</th>
                                                            <th>Sakit</th>
                                                            <th>Izin</th>
                                                            <th>Absen</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $no=1; @endphp
                                                        @foreach($student as $key => $value)
                                                            @php $sakit='';$izin='';$alpha=''; @endphp
                                                            @foreach ($finalgrade as $k=>$v)
                                                                @php
                                                                    if($v['sid']==$value['id'])
                                                                    {
                                                                        $sakit = $v['absent_s'];
                                                                        $izin = $v['absent_i'];
                                                                        $alpha = $v['absent_a'];
                                                                        break;
                                                                    }
                                                                @endphp
                                                            @endforeach
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $value['name'] }}</td>
                                                                <td><input type="number" name="s[{{ $value['id'] }}]" id="s{{ $value['id'] }}" class="form-control" autocomplete="off" style="width:70px;" value="{{ $sakit }}"></td>
                                                                <td><input type="number" name="i[{{ $value['id'] }}]" id="s{{ $value['id'] }}" class="form-control" autocomplete="off" style="width:70px;" value="{{ $izin }}"></td>
                                                                <td><input type="number" name="a[{{ $value['id'] }}]" id="s{{ $value['id'] }}" class="form-control" autocomplete="off" style="width:70px;" value="{{ $alpha }}"></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="{{ $no+3 }}" class="text-right" >
                                                                <button type="button" class="btn btn-primary" id="btnSaveAbsen"><i class="fa fa-save"></i> Simpan</button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="col-md-12 table-responsive">
                                            @if(!empty($student))
                                            <form id="frmperilaku" name="frmperilaku">
                                                <input type="hidden" name="ccid" value="{{ $req->class }}">
                                                <table class="table table-stripe">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">No.</th>
                                                            <th width="60%">Nama</th>
                                                            <th>Kebersihan</th>
                                                            <th>Kedisiplinan</th>
                                                            <th>Perilaku</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $no=1; @endphp
                                                        @foreach($student as $key => $value)
                                                        @php $a='';$b='';$c=''; @endphp
                                                            @foreach ($finalgrade as $k=>$v)
                                                                @php
                                                                    if($v['sid']==$value['id'])
                                                                    {
                                                                        $a = ($v['cleanliness']=='0') ? '-' : $v['cleanliness'];
                                                                        $b = ($v['discipline']=='0') ? '-' : $v['discipline'];
                                                                        $c = ($v['behaviour']=='0') ? '-' : $v['behaviour'];
                                                                        break;
                                                                    }
                                                                @endphp
                                                            @endforeach
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $value['name'] }}</td>
                                                                <td class="text-center"><input type="text" name="cleanliness[{{ $value['id'] }}]" id="cleanliness{{ $value['id'] }}" class="form-control text-center" autocomplete="off" onkeypress="return /[A-D]/i.test(event.key)" style="width:70px;" value="{{ $a }}"></td>
                                                                <td class="text-center"><input type="text" name="discipline[{{ $value['id'] }}]" id="discipline{{ $value['id'] }}" class="form-control text-center" autocomplete="off" onkeypress="return /[A-D]/i.test(event.key)" style="width:70px;" value="{{ $b }}"></td>
                                                                <td class="text-center"><input type="text" name="behaviour[{{ $value['id'] }}]" id="behaviour{{ $value['id'] }}" class="form-control text-center" autocomplete="off" onkeypress="return /[A-D]/i.test(event.key)" style="width:70px;" value="{{ $c }}"></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="{{ $no+3 }}" class="text-right" >
                                                                <button type="button" class="btn btn-primary" id="btnSavePerilaku"><i class="fa fa-save"></i> Simpan</button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="col-md-12 table-responsive">
                                            @if(!empty($student))
                                            <form id="frmlainnya" name="frmlainnya">
                                                <input type="hidden" name="ccid" value="{{ $req->class }}">
                                                <table class="table table-stripe">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">No.</th>
                                                            <th width="40%">Nama</th>
                                                            {{-- <th class="text-center">
                                                                Menghafal Al-Quran <br><div dir="rtl">تسميع مقرَّر القرآن</div>
                                                            </th> --}}
                                                            <th class="text-center">
                                                                Kegiatan Wali <br><div dir="rtl">فعّاليات ولي الأمر</div>
                                                            </th>
                                                            <th class="text-center">
                                                                Hasil akhir <br> <div dir="rtl">النتيجة النهائية </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $no=1; @endphp
                                                        @foreach($student as $key => $value)
                                                        @php $a='';$b='';$c=''; @endphp
                                                            @foreach ($finalgrade as $k=>$v)
                                                                @php
                                                                    if($v['sid']==$value['id'])
                                                                    {
                                                                        // $a = $v['memorizing_quran'];
                                                                        $b = $v['activities_parent'];
                                                                        $c = $v['result'];
                                                                        break;
                                                                    }
                                                                @endphp
                                                            @endforeach
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $value['name'] }}</td>
                                                                {{-- <td>
                                                                    @php $pilihan = \App\SmartSystem\General::pilihan('sempurna'); @endphp
                                                                    <select name="tahfidz[{{ $value['id'] }}]" id="tahfidz{{ $value['id'] }}" class="form-control" >
                                                                        <option value=""> - Pilih Salah Satu - </option>
                                                                        @foreach ($pilihan as $k=>$v)
                                                                            <option value="{{ $v }}"{!! ($v==$a)?' selected="selected"':'' !!}>{{ $v }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td> --}}
                                                                <td>
                                                                    @php $pilihan = \App\SmartSystem\General::pilihan('aktif'); @endphp
                                                                    <select name="aktifortu[{{ $value['id'] }}]" id="aktifortu{{ $value['id'] }}" class="form-control">
                                                                        <option value=""> - Pilih Salah Satu - </option>
                                                                        @foreach ($pilihan as $k=>$v)
                                                                            <option value="{{ $v }}"{!! ($v==$b)?' selected="selected"':'' !!}>{{ $v }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    @php $pilihan = \App\SmartSystem\General::pilihan('berhasil'); @endphp
                                                                    <select name="result[{{ $value['id'] }}]" id="result{{ $value['id'] }}" class="form-control">
                                                                        <option value=""> - Pilih Salah Satu - </option>
                                                                        @foreach ($pilihan as $k=>$v)
                                                                            <option value="{{  $v  }}"{!! ($v==$c)?' selected="selected"':'' !!}>{{ $v }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="{{ $no+3 }}" class="text-right" >
                                                                <button type="button" class="btn btn-primary" id="btnSaveLainnya"><i class="fa fa-save"></i> Simpan</button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                                        <div class="col-md-12 table-responsive">
                                        @if(!empty($student))
                                            <form id="frmcatatan" name="frmcatatan">
                                                <input type="hidden" name="ccid" value="{{ $req->class }}">
                                                <table class="table table-stripe">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">No.</th>
                                                            <th width="30%">Nama</th>
                                                            <th class="text-center">Catatan Wali Kelas di Raport Diknas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $no=1; @endphp
                                                        @foreach($student as $key => $value)
                                                            @php $note=''; $a='';@endphp
                                                            @foreach ($finalgradediknas as $k=>$v)
                                                                @php
                                                                    if($v['sid']==$value['id'])
                                                                    {
                                                                        $note = $v['note_from_student_affairs'];
                                                                        break;
                                                                    }
                                                                @endphp
                                                            @endforeach
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $value['name'] }}</td>
                                                                <td class="text-center">
                                                                    <textarea name="notes[{{ $value['id'] }}]" id="notes{{ $value['id'] }}" class="form-control">{{ $note }}</textarea>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="{{ $no+3 }}" class="text-right" >
                                                                <button type="button" class="btn btn-primary" id="btnSaveNotes"><i class="fa fa-save"></i> Simpan</button>
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
                                            <a href="{{ url('rombel/'.$req->class.'/export/lainnya') }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> Santri</a>
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
    var mode = "UAS";
    $('#btnSaveAbsen').click(function(){
        cekpublikasi(mode,'absen');
    });
    $('#btnSavePerilaku').click(function(){
        cekpublikasi(mode,'perilaku');
    });
    $('#btnSaveLainnya').click(function(){
        cekpublikasi(mode,'lainnya');
    });
    $('#btnSaveNotes').click(function(){
        cekpublikasi(mode,'catatan');
    });

    $('#btnProses').on('click',function(){
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
                if(type=='absen') {
                    simpan('absen');
                } else if(type=='perilaku') {
                    simpan('perilaku');
                } else if(type=='lainnya') {
                    simpan('lainnya');
                } else if(type=='catatan') {
                    simpan('catatan');
                } else if(type=='import') {
                    importnilai();
                }
            }
        })
    }

    function simpan(frm)
    {

        Swal.fire({
            title: "Simpan?",
            text: "Yakin akan disimpan?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#btnProses').prop('disabled',true);
                form = $('#frm'+frm).serialize();
                $.post('{{ url('inputlain/simpan') }}',{"_token": "{{ csrf_token() }}",tipe:frm,data:form},function(data){
                    if(data=='Berhasil')
                    {
                        msgSukses('Data '+capitalize(frm)+' berhasil disimpan');
                        $('#btnProses').prop('disabled',false);
                        // location.reload();
                    }
                    else
                    {
                        msgError(data);
                    }
                });
            }
        })
        return false;
    }

    function importnilai()
    {
        var el = $('#btnProses');
            el.addClass('disabled');
            el.html("<i class='fa fa-spinner fa-spin'></i> Sedang proses ...");
        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append("_token","{{ csrf_token() }}");

        $.ajax({
            url: '{{ route('uploadnilailainnya') }}',
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
                        location.reload();
                    }else{
                        msgError('Mohon dilaporan!');
                    }
                },
        });
    }

    function capitalize(str) {
        strVal = '';
        str = str.split(' ');
        for (var chr = 0; chr < str.length; chr++)
        {
            strVal +=str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' ';
        }
        return strVal
    }
</script>
@endpush
