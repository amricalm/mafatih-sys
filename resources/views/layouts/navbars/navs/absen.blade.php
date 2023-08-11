<div class="fixed-bottom" style="margin-top:50px;">
    <div class="row" style="margin-left:10px;margin-bottom:10px;">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary shadow flip-button-icon" style="" onclick="showabsenmodal()">
                <i class="fa fa-user-clock"></i> Absen
            </button>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="beritaacaraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="beritaacaraModalLabel">Berita Acara Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAbsen">
                    <input type="hidden" id="idAbsen" name="idAbsen">
                    <div class="form-group">
                        <label for="exit_timestamp_manual">Detail</label>
                        <textarea name="" class="form-control" id="detailKehadiran" rows="2" disabled="disabled"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exit_timestamp_manual">Jam Keluar</label>
                        <input type="time" class="form-control" id="exit_manual" name="exit_manual">
                    </div>
                    <div class="form-group">
                        <label for="duration_manual">Durasi Manual (<b>JAM</b>)</label>
                        <input type="number" onKeyPress="if(this.value.length==3) return false;" class="form-control" id="duration_manual" name="duration_manual">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Alasan Tidak Absen Keluar</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Tupoksi</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody id="bodytableberitaacara"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Keluar</button>
                        <button type="button" class="btn btn-primary" id="btnBeritaAcara" onclick="saveberitaacara()"><i class="fa fa-save"></i> Simpan Berita Acara</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="absenModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Klik </h4>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
            </div>
            <div class="modal-body">
                <h1 id="jammodal" class="text-center"></h1>
                @php
                    $hariIni = \Carbon\Carbon::now()->locale('id');
                @endphp
                <h2 class="text-center">{{ $hariIni->dayName.' '.$hariIni->day.' '.$hariIni->monthName.' '.$hariIni->year }}</h2>
                <div class="row">
                    <div class="col-md-12 p-2">
                        <button class="btn btn-lg btn-primary btn-block" onclick="absen('masuk')"><i class="fa fa-sign-in"></i> Masuk</button>
                    </div>
                    {{-- <div class="col-md-6 p-2">
                        <button class="btn btn-lg btn-primary btn-block" onclick="absen('keluar')"><i class="fa fa-sign-out-alt"></i> Keluar</button>
                    </div> --}}
                    {{-- <div class="col-md-12 p-2">
                        <button class="btn btn-lg btn-warning btn-block" onclick="absen('keluar')"><i class="fa fa-sticky-note"></i> Rekapitulasi</button>
                    </div> --}}
                    {{-- <div class="col-md-6 p-2">
                        <button class="btn btn-lg btn-warning btn-block" onclick="absen('sakit')"><i class="fa fa-clinic-medical"></i> Sakit</button>
                    </div>
                    <div class="col-md-6 p-2">
                        <button class="btn btn-lg btn-danger btn-block" onclick="absen('izin')"><i class="fa fa-suitcase-rolling"></i> Izin</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="absenMasuk" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Rencana Kerja</h4>
                <button class="close" data-dismiss="modal" aria-label="Close" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body table-responsive">
                <form action="" class="form" id="frmwork">
                    {{-- <input type="text" class="form-control" name="timestamp" id="timestamp" value="" readonly> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Jam Masuk</div>
                                </div>
                                <input type="text" class="form-control" name="timestamp" id="timestamp" value="" placeholder="Jam Masuk" style="padding-left:10px;color:black;" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:10%">#</th>
                                        <th style="width:90%;">Tupoksi</th>
                                    </tr>
                                </thead>
                                <tbody class="absenmasukbody">

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" id="btnsimpanwork"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="absenKeluar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pelaksanaan Kerja</h4>
                <button class="close" data-dismiss="modal" aria-label="Close" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body table-responsive">
                <form action="" class="form" id="frmworkkeluar">
                    <input type="hidden" id="attendance_id" name="attendance_id" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:#E9ECEF;">Jam Masuk</div>
                                </div>
                                <input type="text" class="form-control" name="timestampmasuk" id="timestampmasuk" value="" placeholder="Jam Masuk" style="padding-left:10px;color:black;" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:#E9ECEF;">Jam Keluar</div>
                                </div>
                                <input type="text" class="form-control" name="timestampkeluar" id="timestampkeluar" value="" placeholder="Jam Keluar"  style="padding-left:10px;color:black;" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:#E9ECEF;">Durasi</div>
                                </div>
                                <input type="number" class="form-control" name="duration" id="duration" value="" placeholder="Isi Durasi (Total Menit)" style="padding-left:10px;color:black;" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text" style="background-color:#E9ECEF;">menit</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:#E9ECEF;">Durasi</div>
                                </div>
                                <input type="number" class="form-control" name="durationj" id="durationj" value="" placeholder="Isi Durasi (Total Jam)" style="padding-left:10px;color:black;" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text" style="background-color:#E9ECEF;">jam</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:#E9ECEF;">Durasi Manual</div>
                                </div>
                                <input type="number" class="form-control" name="durationmanual" id="durationmanual" value="" placeholder="Silahkan diisi" style="padding-left:10px;" >
                                <div class="input-group-append">
                                    <div class="input-group-text" style="background-color:#E9ECEF;">jam</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:60%;">Tupoksi</th>
                                        <th style="width:40%;">Jam</th>
                                    </tr>
                                </thead>
                                <tbody class="absenkeluarbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-8">
                            <p class="small" style="font-size:9px;">*) Yang disimpan adalah durasi menit, karena durasi jam, menggunakan rumus pembulatan. Jika lebih besar dari 0,5, dikeataskan. lebih kecil dari 0,5 kebawah.</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="btn btn-primary" id="btnsimpanworkkeluar"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="beritaAcaraModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Berita Acara</h4>
                <button class="close" data-dismiss="modal" aria-label="Close" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body table-responsive">
                <form action="" class="form" id="frmterlambat">
                    {{-- <input type="text" class="form-control" name="timestamp" id="timestamp" value="" readonly> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                {{-- <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:#DCDCDC;color:black;">Jam Masuk</div>
                                </div> --}}
                                <label for="n_entry_timestamp">Jam Masuk</label>
                                <input type="text" class="form-control datetimepicker" name="entry_timestamp" id="n_entry_timestamp" value="" placeholder="Format : YYYY-MM-DD HH:MM:SS" style="padding-left:10px;color:black;">
                            </div>
                            <div class="mb-2">
                                {{-- <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:#DCDCDC;color:black;">Jam Keluar</div>
                                </div> --}}
                                <label for="n_exit_timestamp">Jam Keluar</label>
                                <input type="text" class="form-control datetimepicker" name="exit_timestamp" id="n_exit_timestamp" value="" placeholder="Format : YYYY-MM-DD HH:MM:SS" style="padding-left:10px;color:black;">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color:#DCDCDC;color:black;">Durasi</div>
                                </div>
                                <input type="number" class="form-control" name="duration_manual" id="n_duration_manual" value="" onKeyPress="if(this.value.length==3) return false;" style="padding-left:10px;color:black;">
                                <div class="input-group-append">
                                    <div class="input-group-text">Jam</div>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <textarea class="form-control" id="notes" name="n_notes" rows="3" placeholder="Keterangan"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:10%">#</th>
                                        <th style="width:90%;">Tupoksi</th>
                                    </tr>
                                </thead>
                                <tbody class="absenberitaacara">
                                    @php
                                        foreach($tupoksi as $k=>$v)
                                        {
                                            echo '<tr><td colspan="2">';
                                            echo '<div class="row">
                                                    <div class="col-md-6 col-sm-12"><label for="chk'.$v['id'].'">'.wordwrap($v['name'],30,"<br>\n").'</label></div>
                                                    <div class="col-md-6 col-sm-12"><input type="hidden" name="idchk[]" value="'.$v['id'].'"><input type="number" class="form-control" name="is_chk_done[]" id="is_chk_done'.$v['id'].'" value="0" onKeyPress="if(this.value.length==3) return false;"></div>
                                                </div>';
                                            echo '</td></tr>';
                                        }
                                    @endphp
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" id="btnsimpanlambat"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    function updateTime(k) {
        if (k < 10) {
            return "0" + k;
        }
        else {
            return k;
        }
    }
    function currentTime() {
        var date = new Date(); /* creating object of Date class */
        var hour = date.getHours();
        var min = date.getMinutes();
        var sec = date.getSeconds();
        hour = updateTime(hour);
        min = updateTime(min);
        sec = updateTime(sec);

        (!document.getElementById('jammenu')) ? '' : document.getElementById("jammenu").value = hour + " : " + min + " : " + sec; /* adding time to the div */
        document.getElementById("jammodal").innerText = hour + " : " + min + " : " + sec; /* adding time to the div */
        var t = setTimeout(function(){ currentTime() }, 1000); /* setting timer */
        return hour + ":" + min + ":" + sec;
    }
    currentTime();
    function showabsenmodal()
    {
        gettime('timestamp');
        $('#absenModal').modal('show');
    }
    function showberitaacara()
    {
        $('#beritaAcaraModal').modal('show');
    }
    function gettime(id)
    {
        var date = new Date(); /* creating object of Date class */
        var hour = date.getHours();
        var min = date.getMinutes();
        var sec = date.getSeconds();
        var day = date.getDate();
        var mon = date.getMonth() + 1;
        var year = date.getFullYear();
        hour = updateTime(hour);
        min = updateTime(min);
        sec = updateTime(sec);
        $('#'+id).val(year+'-'+mon+'-'+day+' '+currentTime());
    }
    function absen(tipe,id='',msk='')
    {
        switch (tipe) {
            case 'masuk':
                $.get('{{ url('home/gettupoksi') }}',function(data){
                    $('.absenmasukbody').html(data);
                    $('#absenMasuk').modal('show');
                });
                break;
            case 'keluar':
                $('#timestampmasuk').val($('#'+id+'hmasuk').val());
                msk = new Date($('#timestampmasuk').val());
                gettime('timestampkeluar');
                klr = new Date($('#timestampkeluar').val());
                var diff = parseInt(Math.abs((klr - msk)/1000)/60);
                var diffj = Math.round(diff/60);
                $('#duration').val(diff);
                $('#durationj').val(diffj);
                $.get('{{ url('home/getrealisasi') }}',{id:id},function(data){
                    // datas = data.split('|');
                    $('#attendance_id').val(id);
                    $('.absenkeluarbody').html(data);
                    $('#absenKeluar').modal('show');
                });
                break;
            default:
                break;
        }
    }
    $('#btnsimpanwork').on('click',function(){
        frm = $('#frmwork').serialize();
        var checked = $("input:checked").length;
        if(checked==0)
        {
            alert('Ceklis Rencana Kegiatan Anda!');
        }
        else
        {
            $('#btnsimpanwork').attr('disabled','disabled');
            $.post('{{ url('home/simpantupoksi') }}',{"_token": "{{ csrf_token() }}","data":frm},function(datas){
                if(datas=='Berhasil'){
                    msgSukses('Absen berhasil disimpan!');
                    location.reload();
                }
                else{
                    msgError(datas);
                }
            });
        }
    });
    $('#btnsimpanlambat').on('click',function(){
        frm = $('#frmterlambat').serialize();
        tot = $('#n_duration_manual').val();
        str = $('#n_entry_timestamp').val();
        let current_date = new Date();
        tglll = str.split(' ')[0];
        let inputYear = tglll.split("-")[0];
        let inputMonth = tglll.split("-")[1];
        let inputDate = tglll.split("-")[2];
        if (current_date.getFullYear() == inputYear
            && current_date.getMonth() == inputMonth - 1
            && current_date.getDate() == inputDate)
        {
            alert('Form berita acara adalah untuk mengisi absen dihari lain, bukan hari ini. Gunakan tombol Absen!')
            $('#beritaAcaraModal').modal('hide');
            return false;
        }
        det = 0;
        var checked = $("input[name^=is_chk_done]").length;
        if(checked==0)
        {
            alert('Isi tupoksi ');
            return false;
        }
        else
        {
            $('input[name^=is_chk_done]').each(function(){
                det += parseInt($(this).val());
            });
            if(tot<det)
            {
                alert('Mohon isi durasi tupoksi sesuai dengan durasi manual!');
                return false;
            }
            // $(this).attr('disabled','disabled');
            $.post('{{ url('home/simpanterlambat') }}',{"_token": "{{ csrf_token() }}","data":frm},function(datas){
                if(datas=='Berhasil'){
                    msgSukses('Absen berhasil disimpan!');
                    location.reload();
                }
                else{
                    // console.log(datas);
                    // msgError(datas);
                }
            });
        }
    });
    $('#btnsimpanworkkeluar').on('click',function(){
        frm = $('#frmworkkeluar').serialize();
        drs = $('#durationmanual').val();
        tot = 0;
        $('input[name^=is_done]').each(function(){
            tot += parseInt($(this).val());
        });
        if(tot>drs)
        {
            alert('Mohon isi durasi tupoksi sesuai dengan durasi manual!');
            return false;
        }
        else{
            $(this).attr('disabled','disabled');
            $.post('{{ url('home/simpantupoksikeluar') }}',{"_token": "{{ csrf_token() }}","data":frm},function(datas){
                if(datas=='Berhasil'){
                    msgSukses('Absen berhasil disimpan!');
                    location.reload();
                }
                else{
                    msgError(datas);
                }
            });
        }
    });
    function beritaacara(id)
    {
        $('#idAbsen').val(id);
        $('#beritaacaraModal').modal('show');
        entry = 'Masuk : '+$('#'+id+'hmasuk').val();
        $('#detailKehadiran').val(entry);
        $.post('{{ url('home/beritaacaraabsen') }}/'+id,{"_token": "{{ csrf_token() }}"},function(datas){
            datass = JSON.parse(datas);
            if(datass.header.exit_manual !== null)
            {
                $('#exit_manual').val(datass.header.exit_manual);
                $('#notes').val(datass.header.notes);
                $('#duration_manual').val(datass.header.duration_manual);
                $('#exit_manual').attr('disabled','disabled');
                $('#notes').attr('disabled','disabled');
                $('#duration_manual').attr('disabled','disabled');
                $('#btnBeritaAcara').attr('disabled','disabled');
            }
            else
            {
                $('#exit_manual').val('');
                $('#notes').val('');
                $('#duration_manual').val('');
                $('#exit_manual').removeAttr('disabled');
                $('#notes').removeAttr('disabled');
                $('#duration_manual').removeAttr('disabled');
                $('#btnBeritaAcara').removeAttr('disabled');
            }
            text = ''; no = 0;
            $.each(datass.detail,function(index,value){
                no++;
                text += '<tr><td colspan="3">';
                text += '<div class="row">';
                text += '<div class="col-md-6 col-sm-12"><label for="chk_ba'+value.id+'">'+value.name+'</label></div>';
                disabl = (datass.header.exit_manual!==null) ? 'disabled="disabled"' : '';
                valu = (value.is_done!=''&&value.is_done!='0') ? value.is_done : '0';
                text += '<div class="col-md-6 col-sm-12"><input type="hidden" name="id_ba[]" value="'+value.id+'"><input type="number" class="form-control" name="is_done_ba[]" id="is_done_ba'+value.id+'" value="'+valu+'" onKeyPress="if(this.value.length==3) return false;" '+disabl+'></div>';
                text += '</div>';
                text += '</td></tr>';
            })
            // console.log(text);
            $('#bodytableberitaacara').html(text);
        })
    }
    function saveberitaacara()
    {
        id = $('#idAbsen').val();
        ex = $('#exit_manual').val();
        nt = $('#notes').val();
        dm = $('#duration_manual').val();
        to = 0;
        $('input[name^=is_done_ba]').each(function(){
            to += parseInt($(this).val());
        });
        if(ex=='' || ex==' ')
        {
            alert('Isi jam keluar!');
            $('#exit_manual').focus();
            return;
        }
        if(nt=='' || nt==' ')
        {
            alert('Isi Alasan tidak melakukan absen pulang!');
            $('#notes').focus();
            return;
        }
        if(dm<to)
        {
            alert('Durasi tupoksi tidak boleh lebih dari durasi manual!');
            return;
        }
        frm = $('#frmAbsen').serialize();

        Swal.fire({
            title: "Yakin?",
            text: "Data tidak bisa diedit!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin'
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).attr('disabled','disabled');
                $.post('{{ url('home/saveberitaacara') }}/'+id,{"_token": "{{ csrf_token() }}",data:frm},function(datas){
                    if(datas=='Berhasil')
                    {
                        msgSukses('Berita acara sudah disimpan!');
                        location.reload();
                    }
                })
            }
        })
    }
    function cekdurasi()
    {
        dr = $('#durationmanual').val();
        total = 0;
        $('input[name^=is_done]').each(function(){
            total += $(this).val();
        });
    }
</script>
@endpush
