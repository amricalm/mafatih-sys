@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-7">
        <div class="header">
            <div class="header-body">
                <div class="row">
                    <div class="col-lg-6">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">Profil</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 text-right">
                        {{-- <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('tambah-siswa') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i> Tambah Karyawan</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div id="tabs">
            @if(Session::has('errors'))
                <h1>ERROR</h1>
            @endif
            {{-- <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                            href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                            <i class="fa fa-sign-in-alt mr-2"></i>Username
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                            href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                            <i class="fa fa-user-tie mr-2"></i> Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                            href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                            <i class="fa fa-upload mr-2"></i> Upload
                        </a>
                    </li>
                </ul>
            </div> --}}
            <form action="{{ route('profile.update') }}">
                @method('PUT')
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Alamat Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ auth()->user()->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password">Password (maksimal 8 karakter)</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="xxx">
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama Siswa</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Tulis Nama Lengkap">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama Siswa dalam Bahasa Arab</label>
                                            <input type="text" class="form-control arabic" id="name_ar" name="name_ar" placeholder="الاسم بالعربي">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <div>
                                        <table class="table align-items-center">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="sort" data-sort="name">Nama Lengkap</th>
                                                    <th scope="col" class="sort" data-sort="budget">TTL</th>
                                                    <th scope="col">Alamat</th>
                                                    <th scope="col" class="sort" data-sort="completion">Telpon</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="list">
                                                @php
                                                    $foto = ['../../assets/img/theme/team-1.jpg', '../../assets/img/theme/team-2.jpg', '../../assets/img/theme/team-3.jpg', '../../assets/img/theme/team-4.jpg'];
                                                    $list = [
                                                        [
                                                            'foto' => $foto[0],
                                                            'namalengkap' => 'Ammar Rasheed Amanullah',
                                                            'ttl' => '14-05-2012',
                                                            'namaortu' => 'Arumi Astagafi',
                                                            'alamat' => 'Jl. Gempol GG Daman I No. 33 A',
                                                            'telpon' => '08567853114',
                                                        ],
                                                        [
                                                            'foto' => $foto[0],
                                                            'namalengkap' => 'Achmad Irsyad Shaleh',
                                                            'ttl' => '26-12-2008',
                                                            'namaortu' => 'Ahmad Bukhori',
                                                            'alamat' => 'Prabumulih',
                                                            'telpon' => '08567853114',
                                                        ],
                                                        [
                                                            'foto' => $foto[0],
                                                            'namalengkap' => 'Adnan Fathurrahman Dzaki',
                                                            'ttl' => '15-11-2011',
                                                            'namaortu' => 'Mohammad Jack..',
                                                            'alamat' => 'Jl. Sasak Jikin',
                                                            'telpon' => '081388395638',
                                                        ],
                                                        [
                                                            'foto' => $foto[0],
                                                            'namalengkap' => 'Ainul Mardhiyah',
                                                            'ttl' => '11-06-2013',
                                                            'namaortu' => 'Satiya Mulya',
                                                            'alamat' => 'Jl Pintu Air No.89',
                                                            'telpon' => '087887671124',
                                                        ],
                                                    ];
                                                @endphp
                                                @foreach ($list as $key => $val)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="media align-items-center">
                                                                <a href="#" class="avatar rounded-circle mr-3">
                                                                    <img alt="Image placeholder" src="{{ $val['foto'] }}">
                                                                </a>
                                                                <div class="media-body">
                                                                    <span
                                                                        class="name mb-0 text-sm">{{ $val['namalengkap'] }}</span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="budget">
                                                            {{ $val['ttl'] }}
                                                        </td>
                                                        <td>
                                                            {{ $val['alamat'] }}
                                                        </td>
                                                        <td>
                                                            {{ $val['telpon'] }}
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="dropdown">
                                                                <a class="btn btn-sm btn-icon-only text-light" href="#"
                                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </a>
                                                                <div
                                                                    class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                                    <a class="dropdown-item" href="#"><i
                                                                            class="fa fa-pencil"></i> Edit</a>
                                                                    <a class="dropdown-item" href="#" id="hapus"><i
                                                                            class="fa fa-trash"></i>
                                                                        Hapus</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1">
                                                    <i class="fa fa-angle-left"></i>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">
                                                    <i class="fa fa-angle-right"></i>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                                aria-labelledby="tabs-icons-text-3-tab">
                                <p class="description">Raw denim you probably haven't heard of them jean shorts Austin.
                                    Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor,
                                    williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher
                                    synth.</p>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>

        </div>
        @include('layouts.footers.auth')
    @endsection

    @push('js')
    @endpush
