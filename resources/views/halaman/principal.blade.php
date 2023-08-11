@extends('layouts.app')
@include('komponen.tabledata')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('walikelas') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="javascript:edit({{ $signed[0]->id ?? '' }})" id="createNew" class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#ajaxModel"><i class="fa fa-pen"></i> Edit</a>
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
                        <table class="table datatables">
                            <thead>
                                <tr>
                                    <th width="45%">Posisi</th>
                                    <th width="45%">Nama Lengkap</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kepala Sekolah</td>
                                    <td>{{ $principal->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Waka Kurikulum</td>
                                    <td>{{ $curriculum->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Waka Kesiswaan</td>
                                    <td>{{ $studentaffair->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Ketua Musyrif Sakan Banin</td>
                                    <td>{{ $housemaster_male->name ?? '' }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Ketua Musyrif Sakan Banat</td>
                                    <td>{{ $housemaster_female->name ?? '' }}</td>
                                    <td></td>
                                </tr>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form" name="form" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Tahun Ajaran {{ config('active_academic_year') }}</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <input type="hidden" name="id" id="id" value="{{ $signed[0]->id ?? '' }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="principal" class="control-label">Kepala Sekolah</label>
                                <div>
                                    <select name="principal" id="principal" class="form-control">
                                        <option value=""> - Pilih Kepala Sekolah - </option>
                                        @foreach ($employe as $rows)
                                        <option value="{{ $rows->id }}" {{ ($rows->id==($principal->id ?? ''))?' selected="selected"':'' }}>{{ $rows->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name_ar" class="control-label">Waka Kesiswaan</label>
                                <div>
                                    <select name="studentaffair" id="studentaffair" class="form-control">
                                        <option value=""> - Pilih Waka Kesiswaan - </option>
                                        @foreach ($employe as $rows)
                                        <option value="{{ $rows->id }}" {{ ($rows->id==($studentaffair->id ?? ''))?' selected="selected"':'' }}>{{ $rows->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="curriculum" class="control-label">Waka Kurikulum</label>
                                <div>
                                    <select name="curriculum" id="curriculum" class="form-control">
                                        <option value=""> - Pilih Kepala Sekolah - </option>
                                        @foreach ($employe as $rows)
                                        <option value="{{ $rows->id }}" {{ ($rows->id==($curriculum->id ?? ''))?' selected="selected"':'' }}>{{ $rows->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="housemaster_male" class="control-label">Ketua Musyrif Sakan Banin</label>
                                <div>
                                    <select name="housemaster_male" id="housemaster_male" class="form-control">
                                        <option value=""> - Pilih Ketua Musyrif Sakan Banin - </option>
                                        @foreach ($employe as $rows)
                                        <option value="{{ $rows->id }}" {{ ($rows->id==($housemaster_male->id ?? ''))?' selected="selected"':'' }}>{{ $rows->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="housemaster_female" class="control-label">Ketua Musyrif Sakan Banat</label>
                                <div>
                                    <select name="housemaster_female" id="housemaster_female" class="form-control">
                                        <option value=""> - Pilih Ketua Musyrif Sakan Banat - </option>
                                        @foreach ($employe as $rows)
                                        <option value="{{ $rows->id }}" {{ ($rows->id==($housemaster_female->id ?? ''))?' selected="selected"':'' }}>{{ $rows->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
<!-- Modal -->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodymodaldetail">

            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $('#saveBtn').click(function(e) {
        e.preventDefault();
        data = $('#form').serialize()
        $.post('{{ url('kepala-sekolah/simpan') }}',{"_token":"{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil disimpan');
                location.reload();
            }
            else
            {
                msgError(data);
            }
            console.log(data);
        })
    });
    function edit(id)
    {
        $.get('{{ url('kepala-sekolah/') }}/'+id+'/edit',function(data){
            datas = JSON.parse(data);
            $('#ajaxModel').modal('show');
            $('#id').val(datas.id);
            $('#principal').val(datas.principal);
            $('#curriculum').val(datas.curriculum);
            $('#studentaffair').val(datas.studentaffair);
            $('#housemaster_male').val(datas.housemaster_male);
            $('#housemaster_female').val(datas.housemaster_female);
        })
    }
</script>
@endpush
