@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.select2')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('pelanggaran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" data-toggle="modal" data-target="#tambahModal" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <form id="frmFilter">
                    @csrf
                    <div class="card-body">
                        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="class">Kelas</label>
                                        <select name="ccid" id="ccid" class="form-control form-control-sm">
                                            <option value=""> - Pilih Salah Satu - </option>
                                            @foreach ($courseclass as $key=>$val)
                                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" data-toggle="modal" data-target="#modalImport" class="btn btn-sm btn-secondary"><i class="fas fa-file-excel"></i> Impor dari Excel</a>
                                    <button class="btn btn-sm btn-secondary" id="btnExport" style="display:none;" data-toggle="collapse" href="#" onclick="eksport()"  role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-file-excel"></i> Expor Data</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-warning btn-sm" id="lihat"><i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive py-4">
                        <div class="container">
                            <table class="table datatables" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Pelanggaran</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="bodytable">

                                </tbody>
                                <tfoot>
                                    {{ $riwayat->links() }}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formTambahModal" name="formTambahModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Tambah Pelanggaran Santri</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pid" class="control-label">Pilih Santri</label>
                                <div>
                                    <select name="pid" id="pid" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach ($santri as $key=>$val)
                                            <option value="{{ $val->pid }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date" class="control-label">Tanggal</label>
                                <div>
                                    <input type="text" class="form-control datepicker" name="date" id="date"  value="{{ date('Y-m-d') }}" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pid" class="control-label">Kategori Pelanggaran</label>
                                <div>
                                    @php $level = ['1'=>'Ringan','2'=>'Sedang','3'=>'Berat Bertahap','4'=>'Berat Tidak Bertahap']; @endphp
                                    <select name="level" id="level" class="form-control" required>
                                        <option value=""></option>
                                        @foreach ($level as $klevel=>$vlevel)
                                            <option value="{{ $klevel }}">{{ $vlevel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date" class="control-label">Pelanggaran</label>
                                <div>
                                    <input type="text" class="form-control" name="name" id="name" value="" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="desc" class="control-label">Tindakan</label>
                                <div>
                                    <textarea class="form-control" id="desc" name="desc" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSave"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditModal" name="formEditModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Edit Pelanggaran</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="eid" id="eid" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="epid" class="control-label">Pilih Santri</label>
                                <div>
                                    <select name="epid" id="epid" class="form-control select2" readonly>
                                        @foreach ($santri as $key=>$val)
                                            <option value="{{ $val->pid }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edate" class="control-label">Tanggal</label>
                                <div>
                                    <input type="text" class="form-control datepicker" name="edate" id="edate"  value="{{ date('Y-m-d') }}" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="elevel" class="control-label">Kategori Pelanggaran</label>
                                <div>
                                    <select name="elevel" id="elevel" class="form-control" required>
                                        @foreach ($level as $klevel=>$vlevel)
                                            <option value="{{ $klevel }}">{{ $vlevel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ename" class="control-label">Pelanggaran</label>
                                <div>
                                    <input type="text" class="form-control" name="ename" id="ename" value="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edesc" class="control-label">Tindakan</label>
                                <div>
                                    <textarea class="form-control" id="edesc" name="edesc" value="" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnUpdate" onclick="update()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
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
                                            @php $employe = $employe!='' ? $employe->id : 0; @endphp
                                            <a href="{{ url('rombel-pengasuhan/'.$employe.'/export-pelanggaran') }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i> Santri</a>
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
<script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        showbaris();
	});

    $('.datepicker').datepicker({
        'setDate': new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        zIndexOffset: 999
    });
    function show(id){
        $.get('{{ url('pelanggaran') }}/'+id+'/edit',function(data){
            data = jQuery.parseJSON(data);
            $('#eid').val(data.id);
            $("#epid").val(data.pid).trigger('change');
            $('#edate').val(data.date);
            $('#ename').val(data.name);
            $('#elevel').val(data.level);
            $('#edesc').val(data.desc);
            $('#editModal').modal('show');
        });
    }

    $('#formTambahModal').submit(function(e) {
        e.preventDefault();
        var data = $('#formTambahModal').serialize();
        $('#btnSave').attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin'></i> Sedang proses ...");
        $.post('{{ url('pelanggaran/simpan') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil simpan');
                $('#formTambahModal').trigger("reset");
                $('#pid').val(null).trigger('change');
                $('#formTambahModal').modal('dispose');
                $('#btnSave').html("<i class='fa fa-save'></i> Simpan");
                $('#btnSave').prop("disabled", false);
            }
            else
            {
                msgError('Ada kesalahan. '+data);
            }
        })
    });
    function update()
    {
        $('#btnUpdate').attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin'></i> Sedang proses ...");
        var data = $('#formEditModal').serialize();
        $.post('{{ url('pelanggaran/update') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil update');
                $('#formTambahModal').trigger("reset");
                $('#pid').val(null).trigger('change');
                $('#editModal').modal('hide');
                location.reload();
            }
            else
            {
                msgError('Ada kesalahan. '+data);
            }
        });
    }
    function hapus(id)
    {
        if(confirm('Yakin akan dihapus?'))
        {
            $.get('{{ url('pelanggaran') }}/'+id+'/hapus',function(data){
                if(data=='Berhasil')
                {
                    window.location.href = '{{ url('pelanggaran') }}';
                }
                else
                {
                    msgError('Ada kesalahan. '+data);
                }
            })
        }
    }

    //Filter per kelas
    $('#lihat').on('click',function(){
        post = $('#ccid option:selected').val();
        if(post==''||post=='0')
        {
            alert('Mohon pilih salah satu tahun pelajaran. Lalu klik tombol Lihat!');
            return;
        }
        showbaris(post);
    })
    function showbaris(id)
    {
        $('#bodytable').html('');
        $.get('{{ url('pelanggaran') }}/'+id+'/show',function(data){
            $('#bodytable').html(data);
            $('#btnExport').show();
        })
    }
    function eksport()
    {
        var ccid = $('#frmFilter').serialize();
        $('#frmFilter').attr('action','{{ url()->current() }}/export');
        $('#frmFilter').attr('method','POST');
        $('#frmFilter').attr('target','_blank');
        $('#frmFilter').submit();
    }

    $('#btnProses').on('click',function(e){
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
                importnilai();
            }
        })
    }

    function importnilai()
    {
        var file_data = $('#file').prop('files')[0];
        if(typeof file_data!=="undefined") {
            var el = $('#btnProses');
            el.addClass('disabled');
            el.html("<i class='fa fa-spinner fa-spin'></i> Sedang proses ...");
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append("_token","{{ csrf_token() }}");

            $.ajax({
                url: '{{ route('uploadpelanggaran') }}',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                    success: function(response){
                        if(response=='Berhasil'){
                            msgSukses('Berhasil import catatan pelanggaran');
                            el.html("<i class='fa fa-gear'></i> Proses Impor");
                            el.removeClass('disabled');
                            location.reload();
                        }else{
                            msgError('Mohon dilaporan!');
                        }
                    },
            });
        } else {
            msgError('Tidak ada file yang diupload');
        }
    }
</script>
@endpush
