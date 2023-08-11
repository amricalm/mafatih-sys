@extends('layouts.app')
@include('komponen.dataTables')
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
                            <li class="breadcrumb-item active" aria-current="page">{{ $judul }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <form id="cari" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="cari">
                                    <div class="input-group-append">
                                      <input type="submit" class="btn btn-primary btn-sm" value="Cari">
                                    </div>
                                  </div>
                            </form>
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-sm btn-primary" onclick="goToClass()"><i class="ni ni-bold-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th class="col-1"></th>
                                <th class="col-1">No</th>
                                <th class="col-2">NIS</th>
                                <th class="col-8">Nama</th>
                            </tr>
                        </thead>
                        <tbody id="showStudentOutClass">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-md-1">
                            <!-- <img id="gambarloading" name="gambarloading" alt="" /> -->
                            <button class="btn btn-sm btn-primary" onclick="outOfClass()"><i class="ni ni-bold-left"></i></button>
                            <!-- <a href="#!" class="btn btn-sm btn-primary">Pilih Semua <i class="ni ni-bold-down"></i></a> -->
                        </div>
                        <div class="col-md-5">
                            <form id="cari-dalam" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="cariDalam" id="cariDlm">
                                    <div class="input-group-append">
                                      <input type="submit" class="btn btn-primary btn-sm" value="Cari">
                                    </div>
                                  </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right input-group-sm">
                            <select class="form-control" id="classes" name="classes" required>
                                <option>- Pilih Kelas -</option>
                                @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th class="col-1"></th>
                                <th class="col-1">No</th>
                                <th class="col-2">NIS</th>
                                <th class="col-8">Nama</th>
                            </tr>
                        </thead>
                        <tbody id="showStudentInClass">
                        </tbody>
                    </table>
                </div>
            </div>
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

        $(document).ready(function() {
            @if ($pilihkelas!='')
                $('#classes').val('{{ $pilihkelas }}');
                $('#classes').trigger('change');
            @endif

            $("#cari").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('outside.studygroup') }}",
                    type: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        showStudentOutClass(data.studentsOutClass);
                    }
                });
            });

            $('#classes').bind('change', function(e) {
                //Menampilkan daftar siswa yang belum mendapat kelas
                $.ajax({
                    url: "{{ route('outside.studygroup') }}",
                    type: "POST",
                    data: {
                        ccid: ''
                    },
                    success: function(data) {
                        showStudentOutClass(data.studentsOutClass);
                    }
                })

                //Menampilkan daftar siswa yang sudah mendapat kelas
                var ccid = e.target.value;
                $.ajax({
                    url: "{{ route('inside.studygroup') }}",
                    type: "POST",
                    data: {
                        ccid: ccid,
                    },
                    success: function(data) {
                        showStudentInClass(data.studentsInClass);
                    }
                })

                $("#cari-dalam").submit(function(e) {
                    e.preventDefault();
                    var cariDlm = $('#cariDlm').val();
                    $.ajax({
                        url: "{{ route('inside.studygroup') }}",
                        type: 'post',
                        data: {
                            ccid: ccid,
                            cariDalam: cariDlm
                        },
                        success: function(data) {
                            showStudentInClass(data.studentsInClass);
                        }
                    });
                });
            });
            $('#classes').trigger('change');
        });

        //Membuat table tbody siswa yang belum mendapat kelas
        function showStudentOutClass(data) {
            var eTable = ""
            $.each(data, function(index, row) {
                eTable += "<tr>";
                $.each(row, function(key, value) {
                    if (key == 'id') {
                        eTable += "<td><input type='checkbox' id=" + value + " name='studentsOutClass[]' value=" + value + " /></td>"
                        eTable += "<td>" + (index + 1) + "</td>";
                    } else {
                        eTable += "<td>" + value + "</td>";
                    }
                });
                eTable += "</tr>";
            });
            $('#showStudentOutClass').html(eTable);
        }

        //Membuat table tbody siswa yang sudah mendapat kelas
        function showStudentInClass(data) {
            var eTable = ""
            $.each(data, function(index, row) {
                eTable += "<tr>";
                $.each(row, function(key, value) {
                    if (key == 'id') {
                        eTable += "<td><input type='checkbox' id=" + value + " name='studentsInClass[]' value=" + value + " /></td>"
                        eTable += "<td>" + (index + 1) + "</td>";
                    } else {
                        eTable += "<td>" + value + "</td>";
                    }
                });
                eTable += "</tr>";
            });
            $('#showStudentInClass').html(eTable);
        }
    });

    //Proses memasukan siswa ke kelas
    function goToClass() {
        var myurl = "{{url('')}}";
        var ccid = $('#classes').val();
        var chks = document.getElementsByName('studentsOutClass[]');
        // $('#gambarloading').attr('src', myurl + '/assets/img/icons/ajax-loader.gif');
        var studentId = new Array();
        var j = 0;
        for (var x = 1; x <= parseInt(chks.length); x++) {
            if (chks[x - 1].checked) {
                studentId[j] = String(chks[x - 1].id);
                j++;
            }
        }
        if (ccid != '') {
            $.ajax({
                type: "POST",
                url: "{{ route('studygroup.exec') }}",
                data: "tipe=gotoclass&ccid=" + ccid + "&sid=" + studentId,
                success: function(data) {
                    $("#classes").val(data.ccid).change();
                }
            });
        } else {
            alert('Pilih kelas terlebih dahulu!');
        }
    }

    //Proses mengeluarkan siswa dari kelas
    function outOfClass() {
        var ccid = $('#classes').val();
        var chks = document.getElementsByName('studentsInClass[]');
        // $('#gambarloading').attr('src', myurl + 'edusis_asset/edusisimg/ajax-loader.gif');
        var studentId = new Array();
        var j = 0;
        for (var x = 1; x <= parseInt(chks.length); x++) {
            if (chks[x - 1].checked) {
                studentId[j] = String(chks[x - 1].id);
                j++;
            }
        }
        if (ccid != '') {
            $.ajax({
                type: "POST",
                url: "{{ route('studygroup.exec') }}",
                data: "tipe=outofclass&ccid=" + ccid + "&sid=" + studentId,
                success: function(data) {
                    $("#classes").val(data.ccid).change();
                }
            });
        } else {
            alert('Pilih kelas terlebih dahulu!');
        }
    }
</script>
@endpush
