@extends('layouts.app')
@include('komponen.dataTables')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ url('mutasi') }}">Mutasi</a></li>
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
                        <div class="col-md-5 input-group-sm">
                            <select class="form-control" id="classes" name="classes" required>
                                <option value="">- Pilih Kelas -</option>
                                @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
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
                        <div class="col-md-2 text-right">
                            <button class="btn btn-sm btn-primary" onclick="outOfClass()"><i class="ni ni-bold-right"></i></button>
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
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-right">
                            <button class="btn btn-sm btn-primary" onclick="goToClass()"><i class="ni ni-bold-left"></i></button>
                        </div>
                        <div class="col-md-5">
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
                        <div class="col-md-5 input-group-sm">
                            <select class="form-control" id="ay" name="ay" required>
                                <option value="">- Pilih Tahun Mutasi -</option>
                                @foreach ($academicyear as $key=>$val)
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
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
    </div>
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
                        <label for="nis" class="control-label">NIS</label>
                        <div>
                            <input type="text" class="form-control" id="nis" name="nis" value="" maxlength="50" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Lengkap</label>
                        <div>
                            <input type="text" class="form-control" id="name" name="name" value="" maxlength="50" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Sekolah Tujuan</label>
                        <div>
                            <input type="text" class="form-control" id="school_destination" name="school_destination" value="" maxlength="50">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Alasan Pindah</label>
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
            @if (!empty($pilihkelas))
                $('#classes').val('{{ $pilihkelas }}');
                $('#classes').trigger('change');
            @endif

            @if (!empty($pilihay))
                $('#ay').val('{{ $pilihay }}');
                $('#ay').trigger('change');
            @endif

            $("#cari").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('outside.mutation') }}",
                    type: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        showStudentOutClass(data.studentsOutClass);
                    }
                });
            });

            $('#classes').bind('change', function(e) {
                //Menampilkan daftar siswa per kelas
                var ccid = e.target.value;
                $.ajax({
                    url: "{{ route('inclass.mutation') }}",
                    type: "POST",
                    data: {
                        ccid: ccid,
                    },
                    success: function(data) {
                        showStudentInClass(data.studentsInClass);
                    }
                })

                //Menampilkan daftar siswa yang sudah lulus per tahun ajar
                var ayid = $('#ay').val();
                $.ajax({
                    url: "{{ route('outside.mutation') }}",
                    type: "POST",
                    data: {
                        ayid: ayid,
                    },
                    success: function(data) {
                        showStudentOutClass(data.studentsOutClass);
                    }
                })

                $("#cari-dalam").submit(function(e) {
                    e.preventDefault();
                    var cariDlm = $('#cariDlm').val();
                    $.ajax({
                        url: "{{ route('inclass.mutation') }}",
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
            // $('#classes').trigger('change');

            $('#ay').bind('change', function(e) {
                //Menampilkan daftar siswa yang belum mendapat kelas
                var ayid = e.target.value;
                $.ajax({
                    url: "{{ route('outside.mutation') }}",
                    type: "POST",
                    data: {
                        ayid: ayid,
                    },
                    success: function(data) {
                        showStudentOutClass(data.studentsOutClass);
                    }
                })

                //Menampilkan daftar siswa yang sudah mendapat kelas
                var ccid = $('#classes').val();
                $.ajax({
                    url: "{{ route('inclass.mutation') }}",
                    type: "POST",
                    data: {
                        ccid: ccid,
                    },
                    success: function(data) {
                        showStudentInClass(data.studentsInClass);
                    }
                })

                $("#cari").submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('outside.mutation') }}",
                        type: 'post',
                        data: $(this).serialize(),
                        success: function(data) {
                            showStudentOutClass(data.studentsOutClass);
                        }
                    });
                });
            });
            // $('#ay').trigger('change');
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
        var ayid = $('#ay').val();
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
            if (ayid != '') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('studentmutation.exec') }}",
                    data: "tipe=gotoclass&ccid=" + ccid + "&sid=" + studentId,
                    success: function(data) {
                        $("#classes").val(data.ccid).change();
                    }
                });
            } else {
                alert('Pilih tahun kelulusan terlebih dahulu!');
            }
        } else {
            alert('Pilih kelas terlebih dahulu!');
        }
    }

    //Proses mengeluarkan siswa dari kelas
    function outOfClass() {
        var ccid = $('#classes').val();
        var ayid = $('#ay').val();
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
            if (ayid != '') {
                if(studentId.length != 0) {
                    var id = studentId;
                    var url = '{{ collect(request()->segments())->last() }}';
                    $.get(url + '/' + id + '/desc', function(data) {
                        $('#modelHeading').html("{{ $judul }}");
                        $('#ajaxModel').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#id').val(data.id);
                        $('#nis').val(data.nis);
                        $('#name').val(data.name);
                    })

                    $('#saveBtn').click(function(e) {
                        e.preventDefault();
                        $(this).html('Simpan');

                        var school_destination = $('#school_destination').val();
                        var desc = $('#desc').val();

                        $.ajax({
                            url: "{{ route('studentmutation.exec') }}",
                            data: "tipe=outofclass&ccid=" + ccid + "&sid=" + studentId+ "&ayid=" + ayid+ "&school_destination=" + school_destination+ "&desc=" + desc,
                            type: "POST",
                            success: function(data) {
                                $("#classes").val(data.ccid).change();
                                $("#ay").val(data.ayid).change();
                                setTimeout(function() { $('#form').trigger('reset'); }, 1000);
                                setTimeout(function() { $('#ajaxModel').modal('hide'); }, 1000);
                            }, error: function(data) {
                                console.log('Error:', data);
                                $('#saveBtn').html('Simpan');
                            }
                        });
                    });

                } else {
                    alert('Pilih siswa terlebih dahulu!');
                }
            } else {
                alert('Pilih tahun mutasi terlebih dahulu!');
            }
        } else {
            alert('Pilih kelas terlebih dahulu!');
        }
    }
</script>
@endpush
