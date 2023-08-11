@extends('layouts.app')
@include('komponen.timepicker')
@include('komponen.datetimepicker')

@section('content')
<div class="header pt-5 bg-gradient-lighter pt-md-8">
    @if(isset($pengumuman)&&$pengumuman!='')
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
    @endif
    <main role="main" class="jumbotron" style="padding:0px;">
        <div class="jumbotron" style="padding:0 2rem;">
            <h1 class="display-4">Ahlan wasahlan
            @if($person->sex=='L')
                Ustadz
            @else
                Ustadzah
            @endif
            {{ auth()->user()->name }}!</h1>
            <p>
                <button class="btn bg-maroon btn-sm text-white" type="button" data-toggle="collapse" data-target="#collapseWidthExample"
                        aria-expanded="false" aria-controls="collapseWidthExample">
                    Lihat Ayat Quran (Acak) <i class="fas fa-angle-down"></i>
                </button>
            </p>
            <div>
                <div class="collapse width" id="collapseWidthExample">
                    {!! \App\SmartSystem\General::random_quran('','jumbotron') !!}
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" readonly class="form-control" value="" id="jammenu" style="font-size:50px;color:black;border:black;width:300px;margin-bottom:5px;">
                </div>
                <div class="col-md-6">
                    <div class="btn-group mb-3">
                        <a class="btn btn-primary" href="#" role="button" onclick="showabsenmodal()"><i class="fa fa-user-clock"></i> Absen </a>
                        <a href="#" class="btn btn-warning" onclick="showberitaacara()"><i class="fas fa-scroll"></i> Berita Acara</a>
                    </div>
                </div>
            </div>
            <p>
                <form class="form">
                    {{-- <div class="form-group mb-2" style="width:100px;">
                        <input type="text" readonly class="form-control" value="" id="jammenu">
                    </div>
                    <a class="btn btn-primary mb-2" href="#" role="button" onclick="showabsenmodal()"><i class="fa fa-user-clock"></i> Absen </a> --}}
                </form>
            </p>
            @php
                $no = 0;
                foreach($moduluser as $key=>$val)
                {
                    $modulnya = $modul->where('id',$val)->first()->toArray();
                    echo ($no!=0) ? '<hr/>' : '';
                    $menu1 = collect($menu)->where('modul_id',$val)->sortBy('seq')->toArray();

                    if(count($menu1)>0)
                    {
                        echo '<a class="btn btn-secondary" data-toggle="collapse" href="#m'.$val.'" role="button" aria-expanded="false" aria-controls="m'.$val.'">Menu '.$modulnya['name'].' <i class="fas fa-caret-down"></i></a>';
                        echo '<div class="row align-items-center collapse" id="m'.$val.'">';
                        $no = 1;
                        foreach($menu1 as $key1=>$val1)
                        {
                            echo '<div class="col-xl-3 col-md-6" style="padding:10px;">
                                    <a href="'.url($val1['slug']).'">
                                    <div class="card card-stats">
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0"><i class="'.$val1['menu_icon'].'"></i> '.$val1['menu'].'</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                   '.$no.'
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </a>
                                    </div>';
                            $no++;
                        }
                        echo '</div>';
                        $no++;
                    }
                }
            @endphp
          </div>
    </main>
    <div class="container card">
        <div class="row card-body">
            <div class="col-md-12 table-responsive">
                <h2>Rekap Absensi Anda</h2>
                <table class="table datatables table-striped">
                    <thead>
                        <tr>
                            <th style="width:5%">No.</th>
                            <th style="width:35%">Waktu</th>
                            <th style="width:15%">Durasi</th>
                            <th style="width:35%">Planning</th>
                            <th style="width:10%" class="text-right">Realisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $j=1; @endphp
                        @foreach ($hrAttendance as $key=>$val)
                            @php
                                $dateend = date('Y-m-d',strtotime('+1 day'.date('Y-m-d',strtotime($val['entry_timestamp']))));
                                // echo $dateend;
                                $udahapprove = ($val['is_accepted']=='1') ? '<span class="badge badge-success">Sudah di-approve</span>' : '<span class="badge badge-danger">Belum di-approve</span>';
                                $sudahadaberitaacara = ($val['exit_manual']=='') ? '<button class="btn btn-danger btn-sm" onclick="'."beritaacara('".$val['id']."')".'"><i class="fas fa-pen-alt"></i> Isi Berita Acara</button>' : '<button class="btn btn-success btn-sm" onclick="'."beritaacara('".$val['id']."')".'"><i class="fas fa-search"></i> Lihat Berita Acara</button><br/>'.$udahapprove;
                                $tombolkeluar = (strtotime(date('Y-m-d')) < strtotime($dateend)) ? '<button class="btn btn-primary btn-sm" onclick="'."absen('keluar','".$val['id']."')".'"><i class="fa fa-sign-out-alt"></i> Keluar</button>' : $sudahadaberitaacara;
                                echo '<input type="hidden" id="'.$val['id'].'hmasuk" value="'.$val['entry_timestamp'].'">';
                            @endphp
                            <tr>
                                <td>{{ $j }}</td>
                                <td>{{ $val['entry_timestamp'] }}
                                    <br> {!! ($val['exit_timestamp']=='') ? $tombolkeluar : $val['exit_timestamp'] !!}
                                    {{-- @if (strtotime(date('Y-m-d')) < strtotime($dateend)) --}}
                                    <br><a href="#" onclick="hapus({{ $val['id'] }})" class="badge badge-warning"><i class="fa fa-trash"></i> Hapus</a>
                                    {{-- @endif --}}
                                </td>
                                <td>{{ ($val['duration']!='') ? $val['duration'].' menit' : '' }} <br> {{ ($val['duration_manual']!='') ? $val['duration_manual'].' jam' : '' }}</td>
                                <td colspan="2">
                                    @php
                                        $i = 1;
                                        $duty = App\Models\HrAttendanceDuty::where('attendance_id','=',$val['id'])
                                            ->join('hr_component as aa','aa.id','=','duty_id')
                                            ->get();
                                        echo '<div class="card"><ul class="list-group list-group-flush">';
                                        foreach($duty as $k=>$v)
                                        {
                                            $status = '';
                                            if(is_null($v->is_done))
                                            {
                                                $status = '<span class="badge badge-warning">belum terealisasi</span>';
                                            }
                                            elseif($v->is_done=='0')
                                            {
                                                $status = '<span class="badge badge-warning">tidak terealisasi</span>';
                                            }
                                            else
                                            {
                                                $status = '<span class="badge badge-primary">'.$v->is_done.' jam</span>';
                                            }
                                            echo '<li class="list-group-item d-flex justify-content-between align-items-center">'.wordwrap($v->desc,20,"<br>\n").$status.'</li>';
                                        }
                                        echo '</ul></div>';
                                    @endphp
                                </td>
                                {{-- <td></td> --}}
                            </tr>
                        @php $j++; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">{{ $hrAttendance->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
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
@include('layouts.navbars.navs.absen')
@include('layouts.footers.auth')
@endsection
@push('js')
<script>
    setTimeout(function() {
        location.reload();
    }, 15*60000);
    @if($user->handphone == '')
    // $('#exampleModal').modal('show');
    // $('#SimpanHP').on('click',function(e){
    //     // e.preventDefault();
    //     isi = $('#handphone').val();
    //     if(isi!='')
    //     {
    //         url = '{{ url('home/hp') }}';
    //         $.post(url,{"_token": "{{ csrf_token() }}",hp:isi},function(data){
    //             if(data=='Berhasil')
    //             {
    //                 msgSukses('Nomor HP berhasil disimpan');
    //                 $('#exampleModal').modal('hide');
    //             }
    //             else
    //             {
    //                 msgError(data)
    //             }
    //         })
    //     }
    // })
    @endif
    function hapus(id)
    {

        Swal.fire({
            title: "Hapus?",
            text: "Data tidak bisa dikembalikan jika sudah dihapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('{{ url('home/hapusabsen') }}/'+id,function(data){
                    if(data=='Berhasil')
                    {
                        msgSukses('Absen Berhasil dihapus!');
                        location.reload();
                    }
                })
            }
        })
    }
</script>
@endpush
