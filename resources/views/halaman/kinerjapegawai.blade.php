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
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __('Rekap Absensi') }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
    </div>
    <div class="container card">
        <div class="row card-body">
            <div class="col-md-12 pb-5">
                <form action="{{ url('kinerjapegawai') }}" method="GET" id="form" class="">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="karyawan" class="col-sm-3 col-form-label">Karyawan</label>
                                <div class="col-sm-9">
                                    <select name="karyawan" id="karyawan" class="form-control form-control-sm">
                                        <option value=""{{ ($karyawan=='')?'selected="selected"':'' }}> - Pilih Salah satu --</option>
                                        @foreach ($employe as $item)
                                        @php
                                            $terpilih = ($karyawan!=''&&$karyawan==$item->pid) ? 'selected="selected"' : '';
                                        @endphp
                                        <option value="{{ $item->pid }}" {{ $terpilih }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="waktu" class="col-sm-3 col-form-label">Pilih Waktu</label>
                                <div class="col-sm-9">
                                    <input type="text" name="waktu" id="waktu" class="form-control form-control-sm datepicker" value="{{ $waktu }}">
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label for="tgl_awal">Pilih Tanggal</label>
                                <div class="input-daterange datepicker row align-items-center" aria-describedby="emailHelp">
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                </div>
                                                <input class="form-control" name="tgl_awal" placeholder="Tanggal Awal" type="text" value="{{ ($tgl_awal!='') ? $tgl_awal : date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                </div>
                                                <input class="form-control" name="tgl_akhir" placeholder="Tanggal Akhir" type="text" value="{{ ($tgl_akhir!='') ? $tgl_akhir : date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="beritaacara" class="col-sm-3 col-form-label">Pilih Berita Acara</label>
                                <div class="col-sm-9">
                                    <select name="beritaacara" id="beritaacara" class="form-control form-control-sm">
                                        <option value="0"> - Pilih Salah Satu - </option>
                                        @php
                                            $array = array('1'=>'Tepat Waktu','2'=>'Berita Acara');
                                            foreach($array as $ka=>$va)
                                            {
                                                $selected = ($beritaacara==$ka) ? 'selected="selected"' : '';
                                                echo '<option value="'.$ka.'" '.$selected.'>'.$va.'</option>';
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary" id="filterform"><i class="fa fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 table-responsive">
                {{ $hrAttendance->appends(request()->all())->links()}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th width="45%">Nama</th>
                            {{-- <th width="30%">Absen</th> --}}
                            <th width="50%">Tupoksi</th>
                            {{-- <th>#</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <td colspan="4">{{ $hrAttendance->links() }}</td>
                        </tr> --}}
                        @php $j=1; @endphp
                        @foreach ($hrAttendance as $key=>$val)
                        @php
                            $sdatang = explode(' ', $val['entry_timestamp']);
                            $tdatang = explode('-', $sdatang[0]);
                            $wdatang = explode(':', $sdatang[1]);
                            $karyawan = collect($employe)->where('id',$val['pid'])->toArray();
                            $karyawan = reset($karyawan);
                            $datang = \Carbon\Carbon::create($tdatang[0],$tdatang[1],$tdatang[2],$wdatang[0],$wdatang[1],$wdatang[2])->locale('id');
                            $pulang = '';
                            if($val['exit_manual']!='')
                            {
                                $val['exit_timestamp'] = $val['exit_manual'];
                            }
                            if($val['exit_timestamp']!='')
                            {
                                $spulang = explode(' ', $val['exit_timestamp']);
                                $tpulang = explode('-', $spulang[0]);
                                $wpulang = explode(':', $spulang[1]);

                                $pulang = \Carbon\Carbon::create($tpulang[0],$tpulang[1],$tpulang[2],$wpulang[0],$wpulang[1],$wpulang[2])->locale('id');
                            }
                        @endphp
                            <tr>
                                <td>{{ $j }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4 style="padding:0;margin-bottom:0px;font-weight:bolder;">{{ $val['name'] }}</h4>
                                            <h5>{{  $karyawan['position_name'] ?? '' }}</h5>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            @if (auth()->user()->role=='1')
                                            <a href="javascript:void(0)" class="btn btn-sm btn-warning" title="Detail" onclick="detail({{ $val['id'] }})"><i class="fas fa-user-clock"></i>
                                            @endif</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($val['notes']!='')
                                            Berita Acara :
                                            <p style="border:1px solid #636059;padding:10px;border-radius: 2px;font-size:12px;width:100%;max-width:400px;">{!! wordwrap($val['notes'],30,"<br>\n") !!}</p>
                                            @endif
                                        {{-- </td>
                                        <td> --}}
                                            Datang : <b>{{ $datang->day.' '.$datang->format('M').' '.$datang->year.' '.$datang->format('G').':'.$datang->format('i').':'.$datang->format('s') }}</b><br>
                                            Pulang : <b>{{ ($pulang=='') ? '-' : $pulang->day.' '.$pulang->format('M').' '.$pulang->year.' '.$pulang->format('G').':'.$pulang->format('i').':'.$pulang->format('s') }}</b>
                                            @if ($val['exit_manual']!='')
                                            <i class="fas fa-question-circle" style="color:red" data-toggle="tooltip" data-placement="top" title="Ada di Berita Acara"></i>
                                            @endif <br>
                                            Durasi : <b>{{ $val['duration'] }} menit</b> / <b><u>+</u> {{ round($val['duration']/60) }} jam</b>
                                            <br>
                                            @if ($val['exit_manual']!='')
                                            <div class="btn-group mt-2" role="group" aria-label="Basic example">
                                                <button type="button" id="btnapprove{{ $val['id'] }}" class="btn {{ ($val['is_accepted']=='1') ? 'btn-warning' : 'btn-primary' }} btn-sm" onclick="approve({{ $val['id'] }})" {{ ($val['is_accepted']=='1') ? 'disabled="disabled"' : '' }}>{!! ($val['is_accepted']=='1') ? '<i class="far fa-check-circle"></i>' : '<i class="fas fa-cog"></i>' !!} Approve</button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $i = 1;
                                        $duty = App\Models\HrAttendanceDuty::where('attendance_id','=',$val['id'])
                                            ->join('hr_component as aa','aa.id','=','duty_id')
                                            ->get();
                                        echo '<div class="card"><ul class="list-group list-group-flush">';
                                        foreach($duty as $k=>$v)
                                        {
                                            $classrtl = ''; $spanrtl = '';
                                            $status = '';
                                            if (preg_match('/[اأإء-ي]/ui', $v->desc)) {
                                                $classrtl = 'arabic';
                                                $spanrtl = 'nonarabic';
                                            }
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
                                            echo '<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">';
                                            echo '<div class="d-flex w-100 justify-content-between"><h5 class="mb-1">'.$v->name.'</h5>'.$status.'</div>';
                                            // echo '<br><small>'.wordwrap($v->desc,50,"<br>\n").'</small>';
                                            echo '</li>';
                                            // echo $v->name.'<br/><small style="font-size:6px;" class="'.$classrtl.'">'.wordwrap($v->desc,50,"<br>\n").'</small>'.$status.'</li>';
                                        }
                                        echo '</ul></div>';
                                    @endphp
                                </td>
                            </tr>
                        @php $j++; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">{{ $hrAttendance->appends(request()->all())->links()}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="loading" id="rowloading" style="margin:auto;text-align:center;width:100%;padding:100px;">
                    <i class="fas fa-spinner fa-pulse fa-10x"></i>
                </div>
                <form id="frm">
                    <input type="hidden" id="id" name="id">
                    <div class="row" id="rowutama" style="display:none;">
                        <div class="col-md-6">
                            <h6 id="nama">Detail</h6>
                            <div class="form-group row">
                                <label for="datang" class="col-sm-4 col-form-label col-form-label-sm">Datang</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control form-control-sm" maxlength="20" id="datang"
                                            value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pulang" class="col-sm-4 col-form-label col-form-label-sm">Pulang</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control form-control-sm" maxlength="20" id="pulang"
                                            value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="durasi" class="col-sm-4 col-form-label col-form-label-sm">Durasi</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control form-control-sm" maxlength="20" id="durasi"
                                            value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="catatan" readonly class="col-sm-4 col-form-label col-form-label-sm">Catatan</label>
                                <div class="col-sm-8">
                                    <textarea type="text" readonly class="form-control form-control-sm" id="catatan"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pulangmanual" class="col-sm-4 col-form-label col-form-label-sm">Pulang Manual</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control form-control-sm" maxlength="20"
                                            id="pulangmanual" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="durasimanual" class="col-sm-4 col-form-label col-form-label-sm">Durasi Manual</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" maxlength="20" id="durasimanual" name="durasimanual" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea class="form-control form-control-sm" id="detaillokasi" readonly rows="7" style="overflow: scroll"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Tabel Kegiatan</h6>
                            <table class="table" id="tableDetail">
                                <tr>
                                    <td>No</td>
                                    <td>Kegiatan</td>
                                    <td>#</td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                            <button type="button" class="btn btn-primary" id="tombolsimpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
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
    function approve(id)
    {
        if(confirm('Yakin akan approve?'))
        {
            $('#btnapprove'+id).attr('disabled','disabled');
            $.post('{{ url('kinerjapegawai/approve') }}/'+id,{"_token": "{{ csrf_token() }}"},function(data){
                if(data=='Berhasil')
                {
                    $('#btnapprove'+id).html('<i class="far fa-check-circle"></i> Approve');
                    $('#btnapprove'+id).removeClass('btn-success');
                    $('#btnapprove'+id).addClass('btn-warning');
                }
                else
                {
                    $('#btnapprove'+id).removeAttr('disabled');
                }
            });
        }
    }
    function cek()
    {
        test = $('#form').serialize;
        return false;
    }
    $('#modalDetail').on('show.bs.modal',function(){
        $('#rowloading').show();
        $('#rowutama').hide();
    })
    function detail(id)
    {
        $('#id').val(id);
        $('#modalDetail').modal('show');
        $.get('{{ url('kinerjapegawai/get') }}/'+id,function(data){
            $('#rowloading').hide();
            $('#rowutama').show();
            datas = JSON.parse(data);
            $.each(datas,function(i,v){
                if(i==0)
                {
                    $('#nama').html(datas[i]['name']);
                    $('#datang').val(datas[i]['entry_timestamp']);
                    $('#pulang').val(datas[i]['exit_timestamp']);
                    $('#durasi').val(datas[i]['duration']);
                    $('#catatan').val(datas[i]['notes'])
                    $('#pulangmanual').val(datas[i]['exit_manual']);
                    $('#durasimanual').val(datas[i]['duration_manual']);
                    lokasi = 'IP : ' + datas[i]['lokasi'].ip + "\r\n";
                    lokasi += 'Kota : ' + datas[i]['lokasi'].city +"\r\n";
                    lokasi += 'Latitude : ' + datas[i]['lokasi'].latitude + "\r\n";
                    lokasi += 'Longitude : ' + datas[i]['lokasi'].longitude + "\r\n";
                    lokasi += 'Provider : ' + datas[i]['lokasi'].org + "\r\n";
                    $('#detaillokasi').html('Detail Absen Datang : '+"\r\n"+lokasi)
                }
                else
                {
                    text = '';
                    $.each(datas[i],function(ii,vv){
                        text += "<tr>";
                        text += '<td style="width:75%;">'+vv.name+"</td>";
                        text += '<td style="width:25%;"><input readonly type="number" class="form-control form-control-sm text-right" value="'+vv.is_done+'"/></td>';
                        text += "</tr>";
                    });
                    $('#tableDetail').html(text);
                }
            });
        });
    }
    $('#tombolsimpan').on('click',function(){
        html = $(this).html();
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang Proses ...');
        frm = $('#frm').serialize();
        id = $('#id').val();
        man = $('#durasimanual').val();
        $.post('{{ url('kinerjapegawai/save') }}/'+id,{"_token": "{{ csrf_token() }}","durasimanual":man},function(data){
            $(this).html(html);
            if(data=='Berhasil')
            {
                msgSukses('Berhasil disimpan');
                location.reload();
            }
        });
    });
</script>
@endpush
