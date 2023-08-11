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
                                        <div class="card">
                                            <div class="card-body">
                                                <h1 class="card-title">Proses Nilai</h1>
                                                <h6 class="card-subtitle mb-2 text-muted">Menu untuk memproses nilai</h6>
                                                <p class="card-text">
                                                    Beberapa hal yang harus diperhatikan :
                                                    <ol>
                                                        <li>Proses ini membutuhkan waktu satu menit atau lebih</li>
                                                        <li>Proses ini membuat nilai akhir dari semua nilai yang telah diinput</li>
                                                        <li>Mohon diisi Form berikut untuk komponen-komponen di Raport</li>
                                                    </ol>
                                                </p>
                                                <form>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Pilih Mode</label>
                                                        <select name="mode" id="mode" class="form-control">
                                                            <option value="UTS">UTS (Pertengahan Semester)</option>
                                                            <option value="UAS">UAS (Akhir Semester)</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-primary" id="tombolproses"><i class="fas fa-sync"></i> Proses Nilai Akademik</button>
                                                        <button type="button" class="btn btn-primary" id="tombolprosespengasuhan"><i class="fas fa-sync"></i> Proses Nilai Pengasuhan</button>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-primary" id="tombolprosesquran"><i class="fas fa-sync"></i> Proses Nilai Al-Qur'an</button>
                                                        <button type="button" class="btn btn-primary" id="tombolprosesdiknas"><i class="fas fa-sync"></i> Proses Nilai Diknas</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Kelas-->
<div class="modal fade" id="modalPilihKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Kelas untuk diproses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pilihkelas">
                @php
                $kelas = collect($kelas);
                @endphp
                <div class="modal-body">
                    @foreach($tingkat as $k=>$v)
                    <div class="card">
                        <div class="card-body">
                            <b><u>{{ 'LEVEL '.$v->level }}</u></b>
                            @php
                            $kelass = $kelas->where('level',$v->level)->toArray();
                            @endphp
                            @foreach($kelass as $ks=>$vs)
                            <div class="form-check" style="padding-top:5px;">
                                <input type="checkbox" name="chk[]" value="{{ $vs['id'] }}" class="form-check-input" id="chk{{ $vs['id'] }}">
                                <label class="form-check-label" for="chk{{ $vs['id'] }}">{{ $vs['name'] }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-primary btn-proses" onclick="proses()"><i class="fa fa-cog"></i> Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Musyrif Sakan -->
<div class="modal fade" id="modalPilihMusyrif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Musyrif Sakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pilihms">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            @foreach($musyrifsakan as $kms=>$vms)
                            <div class="form-check" style="padding-top:5px;">
                                <input type="checkbox" name="chkms[]" value="{{ $vms['id'] }}" class="form-check-input" id="chkms{{ $vms['id'] }}">
                                <label class="form-check-label" for="chkms{{ $vms['id'] }}">{{ $kms+1 }}. {{ $vms['name'] }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-primary btn-proses" onclick="prosespengasuhan()"><i class="fa fa-cog"></i> Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Musyrif Quran -->
<div class="modal fade" id="modalPilihMusyrifQuran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pilihkelasmsq">
                @php
                $kelas = collect($kelas);
                @endphp
                <div class="modal-body">
                    @foreach($tingkat as $k=>$v)
                    <div class="card">
                        <div class="card-body">
                            <b><u>{{ 'LEVEL '.$v->level }}</u></b>
                            @php
                            $kelass = $kelas->where('level',$v->level)->toArray();
                            @endphp
                            @foreach($kelass as $ks=>$vs)
                            <div class="form-check" style="padding-top:5px;">
                                <input type="checkbox" name="chkmsq[]" value="{{ $vs['id'] }}" class="form-check-input" id="chkmsq{{ $vs['id'] }}">
                                <label class="form-check-label" for="chkmsq{{ $vs['id'] }}">{{ $vs['name'] }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-primary btn-proses" onclick="prosesquran()"><i class="fa fa-cog"></i> Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Kelas Diknas-->
<div class="modal fade" id="modalPilihKelasDiknas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Kelas untuk diproses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pilihkelasdiknas">
                @php
                $kelas = collect($kelas);
                @endphp
                <div class="modal-body">
                    @foreach($tingkat as $k=>$v)
                    <div class="card">
                        <div class="card-body">
                            <b><u>{{ 'LEVEL '.$v->level }}</u></b>
                            @php
                            $kelass = $kelas->where('level',$v->level)->toArray();
                            @endphp
                            @foreach($kelass as $ks=>$vs)
                            <div class="form-check" style="padding-top:5px;">
                                <input type="checkbox" name="chkdiknas[]" value="{{ $vs['id'] }}" class="form-check-input" id="chkdiknas{{ $vs['id'] }}">
                                <label class="form-check-label" for="chkdiknas{{ $vs['id'] }}">{{ $vs['name'] }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-primary btn-proses" onclick="prosesdiknas()"><i class="fa fa-cog"></i> Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="fa-5x">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
                <h1>Silahkan tunggu!</h1>
                <h3>Proses rekapitulasi nilai sedang berjalan!</h3>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        'setDate': new Date(), autoclose: true, format: 'yyyy-mm-dd', todayHighlight: true, zIndexOffset: 999,
    });
    $('#tombolproses').on('click',function(){
        tg = $('#date_legalization').val();
        tgh = $('#hijri_date_legalization').val();
        // if(tg=='' || tgh=='')
        // {
        //     alert('Mohon isi tanggal dan tanggal hijriah untuk diraport terlebih dahulu!');
        //     return;
        // }
        // if(confirm('Betul akan diproses?'))
        // {
            mode = $('#mode').val();
            cekpublikasi(mode,'kelas');
            // $('#modalPilihKelas').modal('show');
        // }
    });
    $('#tombolprosesquran').on('click',function(){
        mode = $('#mode').val();
        if(mode=='UAS')
        {
            cekpublikasi(mode,'quran');
        }
        else
        {
            alert('Pilih Mode UAS (Akhir Semester) untuk melanjutkan proses nilai Alquran');
        }
    });
    $('#tombolprosespengasuhan').on('click',function(){
        mode = $('#mode').val();
        if(mode=='UAS')
        {
            cekpublikasi(mode,'musyrif');
            // $('#modalPilihMusyrif').modal('show');
        } else {
            alert('Pilih Mode UAS (Akhir Semester) untuk melanjutkan proses nilai pengasuhan');
        }
    });
    $('#tombolprosesdiknas').on('click',function(){
        mode = $('#mode').val();
        if(mode=='UAS')
        {
            cekpublikasi(mode,'diknas');
        }
        else
        {
            alert('Pilih Mode UAS (Akhir Semester) untuk melanjutkan proses diknas');
        }
    });

    function cekpublikasi(mode,type)
    {
        $.post('{{ url('cekpublikasi') }}',{"_token": "{{ csrf_token() }}",mode:mode},function(data){
            if(data==1) {
                alert('Nilai raport '+mode+' sudah di publikasi dan di kunci. Hubungi Admin!');
                $('#modalPilihKelas').modal('hide');
                $('#modalPilihMusyrif').modal('hide');
            }
            else
            {
                if(type=='kelas')
                {
                    $('#modalPilihKelas').modal('show');
                }
                else if(type=='musyrif')
                {
                    $('#modalPilihMusyrif').modal('show');
                }
                else if(type=='quran')
                {
                    $('#modalPilihMusyrifQuran').modal('show');
                }
                else if(type=='diknas')
                {
                    $('#modalPilihKelasDiknas').modal('show');
                }
            }
        })
    }

    function proses()
    {
        no = 0;
        $('input[name^=chk]:checked').map(function() {
            no++;
        });
        if(no==0)
        {
            alert('Pilih kelas!');
            return;
        }
        if(no>4)
        {
            alert('Maksimal 4 kelas dalam satu kali proses!');
            return;
        }
        $("#loadMe").modal({
                backdrop: "static",
                keyboard: false,
                show: true
            });
        mode = $('#mode').val();
        kls = $('#pilihkelas').serialize();
        $.post('{{ url('prosessekarang') }}',{"_token": "{{ csrf_token() }}",mode:mode,kls:kls},function(data){
            if(data=='Berhasil')
            {
                $('#loadMe').modal('hide');
                $('#modalPilihKelas').modal('hide');
                msgSukses('Alhamdulillah.<br/>Proses Rekap Nilai berhasil!');
                location.reload();
            }
            else
            {
                msgError(data);
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        })
    }
    function prosesquran()
    {
        no = 0;
        $('input[name^=chkmsq]:checked').map(function() {
            no++;
        });
        if(no==0)
        {
            alert('Pilih kelas!');
            return;
        }
        if(no>4)
        {
            alert('Maksimal 4 kelas dalam satu kali proses!');
            return;
        }
        $("#loadMe").modal({
                backdrop: "static",
                keyboard: false,
                show: true
            });
        mode = $('#mode').val();
        kls = $('#pilihkelasmsq').serialize();
        $.post('{{ url('prosessekarang/quran') }}',{"_token": "{{ csrf_token() }}",mode:mode,kls:kls},function(data){
            if(data=='Berhasil')
            {
                $('#loadMe').modal('hide');
                $('#modalPilihMusyrifQuran').modal('hide');
                msgSukses('Alhamdulillah.<br/>Proses Rekap Nilai Alquran berhasil!');
                location.reload();
            }
            else
            {
                msgError(data);
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        })
    }
    function prosespengasuhan()
    {
        no = 0;
        $('input[name^=chkms]:checked').map(function() {
            no++;
        });
        if(no==0)
        {
            alert('Pilih musyrif sakan!');
            return;
        }
        $("#loadMe").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
        musyrif = $('#pilihms').serialize();
        $.post('{{ url('prosessekarangpengasuhan') }}',{"_token": "{{ csrf_token() }}",mode:mode,musyrif:musyrif},function(data){
            if(data=='Berhasil')
            {
                $('#loadMe').modal('hide');
                $('#modalPilihMusyrif').modal('hide');
                msgSukses('Alhamdulillah.<br/>Proses Rekap Nilai Pengasuhan berhasil!');
                location.reload();
            }
            else
            {
                msgError(data);
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        })
    }
    function prosesdiknas()
    {
        no = 0;
        $('input[name^=chkdiknas]:checked').map(function() {
            no++;
        });
        if(no==0)
        {
            alert('Pilih kelas!');
            return;
        }
        if(no>4)
        {
            alert('Maksimal 4 kelas dalam satu kali proses!');
            return;
        }
        $("#loadMe").modal({
                backdrop: "static",
                keyboard: false,
                show: true
            });
        mode = $('#mode').val();
        kls = $('#pilihkelasdiknas').serialize();
        $.post('{{ url('prosessekarang/diknas') }}',{"_token": "{{ csrf_token() }}",mode:mode,kls:kls},function(data){
            if(data=='Berhasil')
            {
                $('#loadMe').modal('hide');
                $('#modalPilihKelasDiknas').modal('hide');
                msgSukses('Alhamdulillah.<br/>Proses Nilai Raport Diknas berhasil!');
                location.reload();
            }
            else
            {
                msgError(data);
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        })
    }

    function blurs()
    {
        masehi = $('#date_legalization').val();
        if(masehi=='')
        {
            alert('Isi tanggal masehinya terlebih dahulu!');
            $('#date_legalization').focus();
            return;
        }
        masehi = masehi.split('-');
        urls = '{{ url('masehi2hijriah') }}/';
        urls = urls+masehi[0]+'/'+masehi[1]+'/'+masehi[2];
        $.get(urls,function(data){
            $('#hijri_date_legalization').val(data);
        });
    }

</script>
@endpush
