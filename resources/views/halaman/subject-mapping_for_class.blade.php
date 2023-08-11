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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('matapelajaran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{-- <a href="#" data-toggle="modal" data-target="#tambahModal" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a> --}}
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
                                    <th>Kelas</th>
                                    <th>Kelas (Arabic)</th>
                                    <th>Mata Pelajaran (KKM - Jam Perminggu)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelas as $item)
                                @php
                                    $member = ''; $no=0;
                                    foreach($subjectclass as $items)
                                    {
                                        if($items['id']==$item->id)
                                        {
                                            $member .= ($no!=0) ? ', '.$items['subject_name'].' ('.$items['grade_pass'].' - '.$items['week_duration'].')' : $items['subject_name'].' ('.$items['grade_pass'].' - '.$items['week_duration'].')';
                                            $no++;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="arabic text-right">{{ $item->name_ar }}</td>
                                    <td><p class="text-wrap"><small>{{ $member }}</small></p></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-warning btn-sm text-white" onclick="show({{ $item->id }})" id="btnEdit"><i class="fa fa-directions"></i> Petakan</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditModal" name="formEditModal" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Pemetaan Mata Pelajaran</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Nama Kelas</label>
                                <div>
                                    <input type="text" class="form-control" id="name" name="name" value="" maxlength="50" disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name_ar" class="control-label">Nama Kelas dalam Arab</label>
                                <div>
                                    <input type="text" class="form-control arabic" id="name_ar" name="name_ar" value="" maxlength="50" disabled="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ceklis Mata Pelajaran, Guru, KKM & Jam Perminggu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($subject as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-2"><input class="check" name="subjectbasic[]" id="check{{ $item->id }}" type="checkbox" value="{{ $item->id }}"></div>
                                                <div class="col-md-4"><label for="check{{ $item->id }}">{{ $item->name }}</label></div>
                                                <div class="col-md-4">
                                                    <select name="e{{ $item->id }}" class="form-control form-control-sm" id="e{{ $item->id }}">
                                                        <option value=""> - Pilih salah satu - </option>
                                                        @foreach($employee as $key => $value)
                                                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-1 text-right"><input type="number" class="form-control form-control-sm" name="value{{ $item->id }}" id="value{{ $item->id }}" style="width:50px" max="100"></div>
                                                <div class="col-md-1 text-right"><input type="number" class="form-control form-control-sm" name="duration{{ $item->id }}" id="duration{{ $item->id }}" style="width:50px" max="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="simpan()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    function show(id){
        $('#formEditModal').trigger('reset');
        $.get('{{ url('pemetaanpelajaran') }}/'+id+'/edit',function(data){
            data = jQuery.parseJSON(data);
            $('#id').val(id);
            $('#name').val(data.name);
            $('#name_ar').val(data.name_ar);
            $('.check').each(function(i,obj){
                yes = 0;
                ids = $(this).attr('id');
                ids = ids.split('check')[1];
                t = '';
                grade = '';
                $.each(data.items,function(i, datas){
                    if(datas.subject_id==ids)
                    {
                        yes = 1;
                        t = datas.eid;
                        grade = datas.grade_pass;
                        duration = datas.week_duration;
                    }
                });
                if(yes==1)
                {
                    $('#check'+ids).prop('checked',true);
                    $('#e'+ids+' option[value='+t+']').prop('selected',true);
                    $('#value'+ids).val(grade);
                    $('#duration'+ids).val(duration);
                }
            });

            $('#editModal').modal('show');
        });
    }
    function simpan()
    {
        var data = $('#formEditModal').serialize();
        $.post('{{ url('pemetaanpelajaran/simpan') }}',{"_token": "{{ csrf_token() }}",data:data},function(data){
            if(data=='Berhasil')
            {
                msgSukses('Berhasil simpan');
                window.location.href="{{ url($aktif) }}";
            }
            else
            {
                msgError('Ada kesalahan. '+data);
            }
        })
    }
</script>
@endpush
