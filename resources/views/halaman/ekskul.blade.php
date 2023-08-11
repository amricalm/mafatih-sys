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
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">Daftar Ekskul</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('tambah-siswa') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i> Tambah Ekskul</a>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabs">
            <div class="table-responsive">
                <div>
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Kode</th>
                                <th scope="col" class="sort" data-sort="budget">Nama Ekskul</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @php
                                $foto = ['../../assets/img/theme/team-1.jpg', '../../assets/img/theme/team-2.jpg', '../../assets/img/theme/team-3.jpg', '../../assets/img/theme/team-4.jpg'];
                                $list = [
                                    [
                                        'foto' => $foto[0],
                                        'namalengkap' => 'FTS',
                                        'ttl' => 'Futsal',
                                        'namaortu' => 'Arumi Astagafi',
                                        'alamat' => 'Jl. Gempol GG Daman I No. 33 A',
                                        'telpon' => '08567853114',
                                    ],
                                    [
                                        'foto' => $foto[0],
                                        'namalengkap' => 'LKS',
                                        'ttl' => 'Lukis',
                                        'namaortu' => 'Ahmad Bukhori',
                                        'alamat' => 'Prabumulih',
                                        'telpon' => '08567853114',
                                    ],
                                    [
                                        'foto' => $foto[0],
                                        'namalengkap' => 'SLTi',
                                        'ttl' => 'Pencak Silat',
                                        'namaortu' => 'Mohammad Jack..',
                                        'alamat' => 'Jl. Sasak Jikin',
                                        'telpon' => '081388395638',
                                    ],
                                    [
                                        'foto' => $foto[0],
                                        'namalengkap' => 'NLS',
                                        'ttl' => 'Penulis Cilik',
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
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $val['namalengkap'] }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ $val['ttl'] }}
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="#"><i class="fa fa-pencil"></i> Edit</a>
                                                <a class="dropdown-item" href="#" id="hapus"><i class="fa fa-trash"></i> Hapus</a>
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
        @include('layouts.footers.auth')
    </div>
@endsection
@push('js')
    <script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            'setDate': new Date(),
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            zIndexOffset: 999
        });

        $('#hapus').on('click',function(){
            Swal.fire({
                title: 'Betul akan dihapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Siswa sudah dihapus',
                    'success'
                    )
                }
            })
        })
    </script>
@endpush
