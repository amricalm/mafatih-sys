@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.datepicker')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('tahunajaran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="javascript:void(0)" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="table-responsive py-4">
                    <div class="container">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <th>Keterangan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form" name="form" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="control-label">Tahun Pelajaran</label>
                        <div>
                            <input type="text" class="form-control" id="name" name="name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Keterangan</label>
                        <div>
                            <textarea id="desc" name="desc" required="" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDetail" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formDetail" name="formDetail">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="ayid" id="ayid">
                    <div class="row">
                        <div class="col-md-6 card">
                            <div class="card-body">
                                <h3>Semester 1</h3>
                                <div class="form-group form-horizontal">
                                    <label for="tgl_uts1" class="control-label">Tanggal UTS</label>
                                    <div>
                                        <input type="date" class="form-control" id="tgl_uts1" name="tgl_uts1">
                                    </div>
                                </div>
                                <div class="form-group form-horizontal">
                                    <label for="tgl_uts_hijri1" class="control-label">Tanggal UTS Hijriah <span onclick="blurs('uts',1)" class="badge badge-success">konversi dari masehinya</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="tgl_uts_hijri1" name="tgl_uts_hijri1">
                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="publish_uts1" id="publish_uts1" value="1">
                                    <label class="form-check-label" for="publish_uts1">Publikasikan UTS Semester 1</label>
                                </div>
                                <hr>
                                <div class="form-group form-horizontal">
                                    <label for="tgl_uas1" class="control-label">Tanggal UAS</label>
                                    <div>
                                        <input type="date" class="form-control" id="tgl_uas1" name="tgl_uas1">
                                    </div>
                                </div>
                                <div class="form-group form-horizontal">
                                    <label for="tgl_uas_hijri1" class="control-label">Tanggal UAS Hijriah <span onclick="blurs('uas',1)" class="badge badge-success">konversi dari masehinya</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="tgl_uas_hijri1" name="tgl_uas_hijri1">
                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="publish_uas1" name="publish_uas1" value="1">
                                    <label class="form-check-label" for="publish_uas1">Publikasikan UAS Semester 1</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 card">
                            <div class="card-body">
                                <h3>Semester 2</h3>
                                <div class="form-group form-horizontal">
                                    <label for="tgl_uts2" class="control-label">Tanggal UTS</label>
                                    <div>
                                        <input type="date" class="form-control" id="tgl_uts2" name="tgl_uts2">
                                    </div>
                                </div>
                                <div class="form-group form-horizontal">
                                    <label for="tgl_uts_hijri2" class="control-label">Tanggal UTS Hijriah <span onclick="blurs('uts',2)" class="badge badge-success">konversi dari masehinya</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="tgl_uts_hijri2" name="tgl_uts_hijri2">
                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="publish_uts2" name="publish_uts2" value="1">
                                    <label class="form-check-label" for="publish_uts2">Publikasikan UTS Semester 2</label>
                                </div>
                                <hr>
                                <div class="form-group form-horizontal">
                                    <label for="tgl_uas2" class="control-label">Tanggal UAS </label>
                                    <div>
                                        <input type="date" class="form-control" id="tgl_uas2" name="tgl_uas2">
                                    </div>
                                </div>
                                <div class="form-group form-horizontal">
                                    <label for="tgl_uas_hijri2" class="control-label">Tanggal UAS Hijriah <span onclick="blurs('uas',2)" class="badge badge-success">konversi dari masehinya</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="tgl_uas_hijri2" name="tgl_uas_hijri2">
                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="publish_uas2" name="publish_uas2" value="1">
                                    <label class="form-check-label" for="publish_uas2">Publikasikan UAS Semester 2</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveDetailBtn" value="create"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            "language": {
                    "paginate": {
                        "previous": "&lt;",
                        "next": "&gt;"
                    },
            },
            processing: true
            , serverSide: true
            , ajax: ""
            , columns: [{
                    data: 'name'
                    , name: 'name'
                }
                , {
                    data: 'desc'
                    , name: 'desc'
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: false
                    , searchable: false
                    , className: "text-right"
                }
            , ]
        });

        $('#createNew').click(function() {
            $('#saveBtn').val("create");
            $('#id').val('');
            $('#form').trigger("reset");
            $('#modelHeading').html("Tambah {{ $judul }}");
            $('#ajaxModel').modal({
                backdrop: 'static'
                , keyboard: false
            });
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
            var url = '{{ collect(request()->segments())->last() }}';
            $.get(url + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Edit {{ $judul }}");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal({
                    backdrop: 'static'
                    , keyboard: false
                });
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#desc').val(data.desc);
            })
        });
        $('body').on('click', '.detail', function() {
            var id = $(this).data('id');
            $.get('{{ url('tahunajar/detail') }}' + '/' + id + '/edit', function(data) {
                $('#modalHeading').html("Detail {{ $judul }}");
                $('#modalDetail').modal({
                    backdrop: 'static'
                    , keyboard: false
                });
                $('#ayid').val(id);
                data = $.parseJSON(data);
                $.each(data,function(index,value){
                    $('#tgl_uts'+value.tid).val(value.mid_exam_date);
                    $('#tgl_uts_hijri'+value.tid).val(value.hijri_mid_exam_date);
                    $('#tgl_uas'+value.tid).val(value.final_exam_date);
                    $('#tgl_uas_hijri'+value.tid).val(value.hijri_final_exam_date);
                    $('#publish_uts'+value.tid).prop('checked',value.publish_mid_exam);
                    $('#publish_uas'+value.tid).prop('checked',value.publish_final_exam);
                })
            })
        });
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Simpan');

            $.ajax({
                data: $('#form').serialize()
                , url: ""
                , type: "POST"
                , dataType: 'json'
                , success: function(data) {

                    $('#form').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();

                }
                , error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Simpan');
                }
            });
        });
        $('#saveDetailBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Simpan');
            $.ajax({
                data: {datas:$('#formDetail').serialize()}
                , url: "{{ url('tahunajar/detail/simpandetail') }}"
                , type: "POST"
                , success: function(data) {
                    if(data=='Berhasil')
                    {
                        $('#formDetail').trigger("reset");
                        $('#modalDetail').modal('hide');
                        msgSukses('Berhasil disimpan!');
                    }
                }
                , error: function(data) {
                    console.log('Error:', data);
                    $('#saveDetailBtn').html('Simpan');
                }
            });
        });

        $('body').on('click', '.delete', function() {
            var id = $(this).data("id");
            var url = '{{ collect(request()->segments())->last() }}';

            Swal.fire({
                title: 'Betul akan dihapus?'
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE"
                        , url: url + '/' + id
                        , success: function(data) {
                            Swal.fire(
                                'Deleted!'
                                , '{{ $judul }} sudah dihapus'
                                , 'success'
                            )
                            table.draw();
                        }
                        , error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
            })
        });
    });

    function blurs(type,tid)
    {
        masehi = $('#tgl_'+type+tid).val();
        if(masehi=='')
        {
            alert('Isi tanggal masehinya terlebih dahulu!');
            $('#tgl_'+type+tid).focus();
            return;
        }
        masehi = masehi.split('-');
        urls = '{{ url('masehi2hijriah') }}/';
        urls = urls+masehi[0]+'/'+masehi[1]+'/'+masehi[2];
        $.get(urls,function(data){
            $('#tgl_'+type+'_hijri'+tid).val(data);
        });
    }
</script>
@endpush
