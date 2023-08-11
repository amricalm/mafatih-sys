@extends('layouts.app')
{{-- @include('komponen.dataTables') --}}

@section('content')
<div class="header pt-3 pt-md-5">
    {{-- @if(isset($pengumuman)&&$pengumuman!='')
    <div class="row pt-3 pr-5 pl-5">
        <div class="col-md-12">
            <div class="alert bg-maroon text-white alert-dismissible fade show" role="alert">
                <span class="alert-inner--text"><strong>Pengumuman</strong><br>{{ $pengumuman }}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif --}}
    {{-- <div class="header pb-3 d-flex align-items-center" style="min-height: 500px; background-image: url({{ asset('assets') }}/img/adn/bg.png); background-size: cover; background-position: center top;">
        <span class="mask bg-gradient-default opacity-8"></span>
        <div class="container-fluid d-flex align-items-center">
            <div class="row ">
                <div class="col-lg-4 col-sm-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ $profil['foto'] }}" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <h1 class="display-2 text-white">
                        {{ $profil['person']->name }}
                        <span class="arabic">{{ $profil['person']->name_ar }}</span>
                    </h1>
                </div>
                <div class="col-md-12 mt-5">
                    <h5 class="h3">
                        Jessica Jones<span class="font-weight-light">, 27</span>
                    </h5>
                    <div class="h5 font-weight-300">
                        <i class="ni location_pin mr-2"></i>Bucharest, Romania
                    </div>
                    <div class="h5 mt-4">
                        <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                    </div>
                    <div>
                        <i class="ni education_hat mr-2"></i>University of Computer Science
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <div class="card card-profile mt-5">
            {{-- <img src="../assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top"> --}}
            {{-- <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                        <a href="#">
                            <img src="../assets/img/theme/team-4.jpg" class="rounded-circle">
                        </a>
                    </div>
                </div>
            </div> --}}
            <div class="card-body">
                <div class="text-center">
                    <h5 class="h3">
                        Jessica Jones<span class="font-weight-light">, 27</span>
                    </h5>
                    <div class="h5 font-weight-300">
                        <i class="ni location_pin mr-2"></i>Bucharest, Romania
                    </div>
                    <div class="h5 mt-4">
                        <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                    </div>
                    <div>
                        <i class="ni education_hat mr-2"></i>University of Computer Science
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="mb-2">
            <div class="row">
                <div class="col-md-4 card" style="cursor:pointer;" onclick="location.href='{{ url('ppdb') }}'" >
                    <div class="card-body">
                        <div class="icon icon-shape bg-gradient-primary rounded-circle text-white mb-3">
                            <i class="far fa-address-book"></i>
                        </div>
                        <h6>Profil</h6>
                        <p class="description">Lengkapi profil Putra/Putri Ummi dan Abi sekalian.</p>
                    </div>
                </div>
                <div class="col-md-4 card" style="cursor:pointer;" onclick="location.href='{{ url('list_siswa') }}'">
                    <div class="card-body">
                        <div class="icon icon-shape bg-gradient-danger rounded-circle text-white mb-3">
                            <i class="ni ni-circle-08"></i>
                        </div>
                        <h6>Siswa/Calon Siswa</h6>
                        <p class="description">Lihat putra/putri Ibu/Bapak yang sudah terdaftar sebagai calon siswa maupun sudah menjadi siswa.</p>
                    </div>
                </div>
                <div class="col-md-4 card" style="cursor:pointer;" onclick="location.href='{{ url('biaya-pendidikan') }}'" >
                    <div class="card-body">
                        <div class="icon icon-shape bg-gradient-warning rounded-circle text-white mb-3">
                            <i class="ni ni-basket"></i>
                        </div>
                        <h6>Lihat Daftar Pembayaran</h6>
                        <p class="description">Lihat pembayaran apa saja yang masih tertagih, juga pembayaran apa saja yang sudah dibayar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nomor HP.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Mohon masukkan nomor HP Anda, untuk mendapatkan notifikasi dan lain-lain.
                <form>
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <label class="sr-only" for="inlineFormInputGroup">Nomor Handphone</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+62</div>
                                </div>
                                <input type="text" class="form-control" id="handphone" placeholder="812345678">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-primary" id="SimpanHP"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    @if($user->handphone == '')
    $('#exampleModal').modal('show');
    $('#SimpanHP').on('click',function(e){
        // e.preventDefault();
        isi = $('#handphone').val();
        if(isi!='')
        {
            url = '{{ url('home/hp') }}';
            $.post(url,{"_token": "{{ csrf_token() }}",hp:isi},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Nomor HP berhasil disimpan');
                    $('#exampleModal').modal('hide');
                }
                else
                {
                    msgError(data)
                }
            })
        }
    })
    @endif

</script>
@endpush
