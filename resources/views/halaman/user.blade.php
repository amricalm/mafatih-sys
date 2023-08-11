@extends('layouts.app')
@include('komponen.tabledata')
{{-- @include('komponen.datepicker') --}}

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('user') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    {{-- <div class="btn-group" role="group" aria-label="Basic example"> --}}
                        @if($page!='users')<a href="#" id="prosesGenerate" class="btn btn-sm bg-purple" style="color:white;"><i class="fas fa-user-plus"></i> Generate dari Siswa</a>@endif
                        <a href="#" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('user') }}">Semua</a>
                        </li>
                        @foreach($roles as $kk=>$vv)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('user') }}/users?kat={{ $vv->name }}">{{ $vv->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div> --}}
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <div class="container">
                            <table class="table" id="datatables">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Peran</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user as $key => $value)
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->rolesname }}</td>
                                            <td class="text-right">
                                                @if ($value->email!='admin@msh.com')
                                                <a href="javascript:reset({{ $value->id }})" class="btn btn-default btn-sm text-white" id="btnReset" data-toggle="tooltip" data-placement="top" title="Reset Password {{ $value->name }}"><i class="fas fa-sync"></i></a>
                                                <a href="javascript:edit({{ $value->id }})" class="btn btn-warning btn-sm text-white" id="btnEdit" data-toggle="tooltip" data-placement="top" title="Edit {{ $value->name }}"><i class="fas fa-pen"></i></a>
                                                <a href="javascript:hapus({{ $value->id }})" class="btn btn-danger btn-sm text-white" onclick="return confirm('Yakin akan dihapus?')" id="btnDelete" data-toggle="tooltip" data-placement="top" title="Hapus {{ $value->name }}"><i class="fas fa-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{-- {!! $user->links() !!} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form" name="form" class="form-horizontal">
                <input type="hidden" id="iduser" name="id">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
                </div>
                <div class="modal-body">
                    {{-- <input type="hidden" name="role" id="role" value=""> --}}
                    <div class="form-group">
                        <label for="pid" class="control-label">{{ ($page=='users') ? 'Guru/Karyawan' : 'Pilih Siswa' }}</label>
                        <div>
                            <select name="pid" id="pid" class="form-control">
                                <option value=""> - Pilih Salah Satu - </option>
                                @php
                                    $data = ($page!='orang-tua') ? $karyawan : $siswa;
                                @endphp
                                @foreach ($data as $k=>$v)
                                <option value="{{ $v->pid }}">{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nis" class="control-label">Email</label>
                        <div>
                            <input type="email" class="form-control" id="email" name="email" value="" maxlength="50" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Password</label>
                        <div>
                            <input type="password" class="form-control" id="password" name="password" value="" autocomplete="off" required>
                        </div>
                    </div>
                    @if ($page!='orang-tua')
                    <div class="form-group">
                        <label for="name" class="control-label">Peran</label>
                        <div>
                            <select name="role" id="role" class="form-control">
                                <option value=""> - Pilih Salah Satu - </option>
                                @foreach ($roles as $k=>$v)
                                <option value="{{ $v->id }}"{{ ($v->name=='Guru')?'selected="selected"':'' }}>{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="moduls">
                        <hr>
                        <table class="table table-striped">
                            <tr>
                                <th>#</th>
                                <th>Modul</th>
                            </tr>
                            @php
                            foreach($modul as $k=>$v)
                            {
                                echo '<tr>';
                                echo '<td><input type="checkbox" name="chk[]" id="chk'.$v->id.'" value="'.$v->id.'"></td>';
                                echo '<td><label for="chk'.$v->id.'">'.$v->name.'</label></td>';
                                echo '</tr>';
                                $menu1 = collect($menu)->unique('menu')->where('modul_id',$v->id)->toArray();
                                if(count($menu1)>0)
                                {
                                    echo '<tr>';
                                    echo '<td colspan="2"><div class="row"><div class="col-md-12" style="width:300px;"><p class="text-wrap">';
                                    foreach($menu1 as $kk=>$vv)
                                    {
                                        echo '<a href="#" class="badge badge-warning"><i class="'.$vv['menu_icon'].'"></i> '.$vv['menu'].'</a>';
                                    }
                                    echo '</p></div></div></td>';
                                    echo '</tr>';
                                }
                            }
                            @endphp
                        </table>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="fa-5x">
                    <i class="fas fa-spinner fa-pulse"></i>
                </div>
                <h1>Silahkan tunggu!</h1>
                <h3>Proses Generate User dari NIS dan TGL LAHIR sedang proses.</h3>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="generateForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Generate User dari Siswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <form id="pilihkelas">
                    <div class="col-md-12" id="divproses">
                        <p>Klik tombol dibawah ini untuk generate semua siswa yang sudah memiliki NIS dengan username <b>NIS@msh.com</b>
                            dan <b>tanggal lahir</b> sebagai password.</p>
                        <p>Pilih Kelas : </p>
                        @foreach ($level as $item)
                        <div class="card">
                            <div class="card-body">
                                <b><u>{{ 'LEVEL '.$item->level }}</u></b>
                                @php
                                $kelass = collect($kelas)->where('level',$item->level);
                                @endphp
                                @foreach($kelass as $ks=>$vs)
                                <div class="form-check" style="padding-top:5px;">
                                    <input type="checkbox" name="chk[]" value="{{ $vs->id }}" class="form-check-input" id="chk{{ $vs->id }}">
                                    <label class="form-check-label" for="chk{{ $vs->id }}">{{ $vs->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        <button type="button" class="btn btn-primary btn-block" id="buttonproses"><i class="fas fa-cogs"></i>
                            Proses</button>
                    </div>
                </form>
                <div class="col-md-12 text-center" id="divloading" style="display:none;">
                    <div class="fa-5x">
                        <i class="fas fa-spinner fa-pulse"></i>
                    </div>
                    <h1>Silahkan tunggu!</h1>
                    <h3>Proses generate user siswa sedang berjalan!</h3>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('js')
<script>
    $('#datatables').DataTable({
        "paging": true,
        "pageLength": {{ config('paging') }},
        "language": {
            "paginate": {
                "previous": "&lt;",
                "next": "&gt;"
            },
            "search": "Cari :",
        },
        "searching": true,
        "info": false,
    } );
    $('#createNew').on('click',function(e){
        $('#form').trigger("reset");
        $('#email').removeAttr('readonly');
        $('#password').attr('required','required');
        $('#form select').trigger("change");
        $('#modelHeading').html('Tambah User');
        $('#saveBtn').html('<i class="fa fa-save"></i> Simpan');
        $('#ajaxModel').modal('show');
        $('#moduls').hide();
    });
    $('#form').on('submit',function(e){
        // pid = $('#pid').
        e.preventDefault();
        frm = $(this).serialize();
        $.post('{{ route('user.simpan') }}',{"_token": "{{ csrf_token() }}","data":frm},function(datas){
            if(datas=='Berhasil'){
                msgSukses('User berhasil disimpan!');
                location.reload();
            }
            else{
                msgError(datas);
            }
        })
    });
    function reset(id)
    {
        if(confirm('Betul akan Reset Password menjadi "default123" ?'))
        {
            $.post('{{ url('user/reset-password') }}',{"_token": "{{ csrf_token() }}",id:id},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Reset Password Berhasil!');
                }
            })
        }
    }
    function edit(id)
    {
        $.post('{{ url('user/load') }}',{"_token": "{{ csrf_token() }}",id:id},function(data){
            dt = JSON.parse(data);
            user = dt.user;
            modul = dt.modul;
            no = 0;
            $('#modelHeading').html('Edit User');
            $('#password').removeAttr('required');
            $('#password').val('');
            $('#pid option[value='+user.pid+']').prop('selected',true);
            $('#email').val(user.email).attr('readonly','readonly');
            $('#iduser').val(user.id);
            $('#role').val(user.role);
            $('input[type=checkbox]').each(function(){
                $(this).prop('checked',false);
            })
            modul.forEach(function(){
                $('#chk'+modul[no]['modul_id']).prop('checked',true);
                no++;
            });
            $('#saveBtn').html('<i class="fa fa-pencil"></i> Update');
            $('#ajaxModel').modal('show');
        })
    }
    function hapus(id)
    {
        $.post('{{ url('user/hapus') }}',{"_token": "{{ csrf_token() }}",id:id},function(data){
            if(data=='Berhasil')
            {
                location.reload();
            }
        });
    }
    $('#prosesGenerate').on('click',function(){
        $('#generateForm').modal('show');
    });
    $('#buttonproses').on('click',function(){
        no = 0;
        $('input[name^=chk]:checked').map(function() {
            no++;
        });
        if(no==0)
        {
            alert('Pilih kelas!');
            return;
        }
        if(no>1)
        {
            alert('Mohon untuk memilih satu kelas saja!');
            return;
        }
        if(confirm('Yakin akan generate user dari siswa? '))
        {
            kls = $('#pilihkelas').serialize();
            $('#divproses').hide();
            $('#divloading').show();
            $.post('{{ url('user/generate') }}',{"_token": "{{ csrf_token() }}",kls:kls},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Proses Generate sudah selesai');
                    location.reload();
                }
                else
                {
                    console.log(data);
                }
            })
        }
    });
</script>
@endpush
