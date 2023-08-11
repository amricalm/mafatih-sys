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
                            @if($cekwalas)
                                . Klik <a href="{{ url('prosesnilai') }}" class="alert-link">disini</a> untuk proses nilai
                            @endif
                            <b>(Proses Nilai hanya untuk Walikelas).</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="subject">Mata Pelajaran</label>
                                            <select name="subject" id="subject" class="form-control form-control-sm" required>
                                                <option value=""> - Pilih salah satu - </option>
                                                @if(!empty($subject))
                                                    @foreach($subject as $key => $value)
                                                        <option value="{{ $value['id'] }}"{{ ($value['id']==$req->subject)?' selected="selected"':'' }}>{{ $value['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    @php
                                        $c = '12';
                                    @endphp
                                    @if ($req->post())
                                        <div class="col-md-6">
                                            <a href="#" data-toggle="modal" data-target="#modalImport" class="btn btn-sm btn-secondary"><i class="fas fa-file-excel"></i> Impor dari Excel</a>
                                            <a href="{{ url('rombel/'.$req->class.'/export/'.$req->subject.'/xls') }}" class="btn btn-sm btn-secondary"><i class="fas fa-file-export"></i> Ekspor Data</a>
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
                                    <input type="hidden" name="subject_id" value="{{ $req->subject }}">
                                    <table class="table table-stripe">
                                        <thead>
                                            <tr>
                                                <th width="10%">No.</th>
                                                <th>Nama</th>
                                                @foreach($grade as $key => $value)
                                                    <th width="10%">
                                                        @php
                                                        $desc = explode(' ',$value['desc']);
                                                        $txt = '';
                                                        if(count($desc)>2)
                                                        {
                                                            for($i=0;$i<count($desc);$i++)
                                                            {
                                                                $txt .= Str::substr($desc[$i],0,1);
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $txt = $value['desc'];
                                                        }
                                                        $txt = ($txt=='Tugas') ? 'Formatif' : $txt;
                                                        @endphp
                                                        {{ $txt }}
                                                    </th>
                                                @endforeach
                                                <th>Nilai Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1;@endphp
                                            @foreach($student as $key => $value)
                                                @php
                                                    $total = 0; $jmh=0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $value['name'] }}</td>
                                                    @foreach($grade as $ke => $va)
                                                        @php
                                                            $jmh++;
                                                            $nilai = '';
                                                            $weight = $va['val'];
                                                            $nilai = collect($assessment)
                                                                ->where('ayid',config('id_active_academic_year'))
                                                                ->where('tid',config('id_active_term'))
                                                                ->where('grade_type',$va['type'])
                                                                ->where('sid',$value['id'])->first();
                                                            $nilai = is_null($nilai) ? 0 : $nilai['val'];
                                                            $total += ($nilai!=0) ? number_format(($nilai*($va['val']/100)),2) : 0;
                                                        @endphp
                                                    <td>
                                                        <input type="number" min="0" max="100" class="form-control form-control-sm text-right" name="val[{{ $value['id'] }}][{{ $va['code'] }}]" id="val{{ $value['id'] }}{{ $va['type'] }}" style="width:70px" value="{{ $nilai }}"  onkeyup="if(this.value>100)this.value=100;">
                                                        <input type="hidden" class="form-control form-control-sm text-right" id="weight{{ $value['id'] }}{{ $va['type'] }}" value="{{ $weight }}">
                                                    </td>
                                                    @endforeach
                                                    <td><input type="text" class="form-control form-control-sm text-center" name="gradeval[]" id="gradeval{{ $value['id'] }}" style="width:70px;" value="{{ $total }}" readonly></td>
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
                                            <a href="{{ url('rombel/'.$req->class.'/export/'.$req->subject) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> Santri</a>
                                        </div>
                                    </div>
                                </li>
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
    $('#class').change(function(){
        id = $(this).val();
        $.post('{{ url('pemetaanpelajaran') }}/'+id+'/darikelas',{"_token": "{{ csrf_token() }}"},function(data){
            if(data !== null)
            {
                data = jQuery.parseJSON(data);
                $('#subject option:not(:first)').remove();
                $.each(data,function(i, datas){
                    $('#subject').append($('<option>',{value:datas.id,text:datas.name}));
                });
            }
        });
    });
    $('#btnSave').click(function()
    {
        mode = 'UAS';
        $.post('<?php echo e(url('cekpublikasi')); ?>',{"_token": "<?php echo e(csrf_token()); ?>",mode:mode},function(data)
        {
            if(data==1) {
                    alert('Nilai raport '+mode+' sudah di publikasi dan di kunci. Hubungi Admin!');
            }
            else
            {
                mode = 'UTS';
                $.post('<?php echo e(url('cekpublikasi')); ?>',{"_token": "<?php echo e(csrf_token()); ?>",mode:mode},function(data)
                {
                    if(data==1) {
                        alert('Nilai raport '+mode+' sudah di publikasi dan di kunci. Hubungi Admin!');
                        location.reload(true);
                    }
                    else
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
                            $('#btnSave').attr('disabled','disabled').html('Sedang proses...');
                            $.post('{{ url('inputnilai/simpan') }}',{"_token": "{{ csrf_token() }}",'data':frm},function(data){
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
                })
            }
        })
    });
    $('#btnProses').on('click',function(){
        mode = 'UAS';
        $.post('<?php echo e(url('cekpublikasi')); ?>',{"_token": "<?php echo e(csrf_token()); ?>",mode:mode},function(data)
        {
            if(data==1) {
                    alert('Nilai raport '+mode+' sudah di publikasi dan di kunci. Hubungi Admin!');
            }
            else
            {
                mode = 'UTS';
                $.post('<?php echo e(url('cekpublikasi')); ?>',{"_token": "<?php echo e(csrf_token()); ?>",mode:mode},function(data){
                    if(data==1) {
                        alert('Nilai raport '+mode+' sudah di publikasi dan di kunci. Hubungi Admin!');
                    }
                    else
                    {
                        var file_data = $('#file').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('file', file_data);
                        form_data.append("_token","{{ csrf_token() }}");
                        $('#btnProses').attr('disabled','disabled').html('Sedang Proses...');
                        $.ajax({
                            url: '{{ route('uploadnilai') }}',
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
                                        msgError('Mohon dilaporkan! <br>'+response);
                                    }
                                },
                        });
                    }
                })
            }
        })
    });
    function akumulasi(id)
    {
        jumlah = 0;
        $('input[id^=val'+id+']').each(function(){
            aidi = $(this).attr('id').split('val');
            pnjng = (aidi[1].length-3);
            type = aidi[1].substring(pnjng,aidi[1].length);
            aidi = aidi[1].substring(0,pnjng);
            weight = $('#weight'+aidi+type).val();
            vals = $(this).val();
            val = (vals!='') ? (vals*(weight/100)) : 0;
            jumlah += val;
        })
        $('#gradeval'+id).val(Math.round(jumlah));
    }
</script>
@endpush
