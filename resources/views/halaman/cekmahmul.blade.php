<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ asset('assets/img/adn/edusis.ico') }}" rel="icon" type="image/png">
    <title>Refresh Mahmul</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        h3 {
            margin-top: 2rem;
        }

        .row {
            margin-bottom: 1rem;
        }

        .row .row {
            margin-top: 1rem;
            margin-bottom: 0;
        }

        [class*="col-"] {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: rgba(86, 61, 124, .15);
            border: 1px solid rgba(86, 61, 124, .2);
        }

        hr {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: yellow;
            color: black;
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
        }

        #myBtn:hover {
            background-color: black;
            color : yellow;
        }
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.dataTables.min.css">
</head>

<body>
    <div class="container">
        <h1>Manual Cek Mahmul</h1>
        <p class="lead">Apakah mahmul sudah sesuai dengan penampakan di setiap tahun ajar atau tidak.</p>

        <h3>Penyesuaian Nilai-nilai Mahmul</h3>
        <p>
            Jika satu pelajaran, hanya memiliki satu baris mahmul, berarti masih salah,
            kecuali jika mahmulnya pada saat tahun ajaran ini <b>LULUS</b>.<br>
            <b>Tahun ajaran aktif : {{ config('active_academic_year') }} - {{ config('active_term') }}</b>
        </p>
        <p>
            <button class="btn btn-warning btn-block" id="tmbl"  onclick="proses()">Refresh semua!</button>
        </p>

        <div class="table-responsive">
            <table class="table table-striped dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Detail</th>
                        <th>#</th>
                    </tr>
                </thead>
                @php
                    $no = 0;
                    $mahmuls = collect($mahmul)->sortBy(['person','subject'])->groupBy('sid')->toArray();
                @endphp
                <tbody>
                    @foreach ($mahmuls as $itemk=>$itemv)
                    <tr>
                        <td>{{ ($no+1) }}</td>
                        <td>
                            {{ $itemv[0]['person'] }}
                            <br>
                            <button class="btn btn-warning btn-sm" id="tmbl{{ $itemk }}" onclick="proses({{ $itemk }})"><i class="bi bi-arrow-repeat"></i> Refresh</button>
                        </td>
                        <td>
                            <ul class="list-group">
                            @php
                                $pelajaran = '';
                            @endphp
                            @foreach ($itemv as $k=>$v)
                                @if ($pelajaran!=$v['subject'])
                                <li class="list-group-item">
                                    <div class="row" style="margin:0px;">
                                        <div class="col-md-6 col-sm-12" style="background-color: inherit; border:none; padding:0px;">
                                            {{ $v['subject'] }} - KKM : {{ $v['grade_pass'] }}
                                            <br>Tahun Ajar : {{ $v['name'].'-'.$v['tid'] }}
                                            <br>Nilai Awal : {{ $v['grade_before'] }}
                                        </div>
                                        <div class="col-md-6 col-sm-12 float-right text-right" style="background-color: inherit; border: none;padding:0px;">
                                            <button class="btn btn-sm btn-warning" id="tmbl{{ $itemk.$v['subject_id'] }}"  onclick="proses({{ $itemk }},{{ $v['subject_id'] }})"><i class="bi bi-arrow-repeat"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger" id="tmblhapus{{ $itemk.$v['subject_id'] }}" onclick="hapuspelajaran({{ $itemk }},{{ $v['subject_id'] }})"><i class="bi bi-trash3"></i></button>
                                        </div>
                                    </div>
                                    <br>Nilai {{ $v['name'].'-'.$v['tid'] }} : {{ $v['grade_after'] }}
                                    @php
                                        $pelajaran = $v['subject'];
                                    @endphp
                                @else
                                    <br>Nilai {{ $v['name'].'-'.$v['tid'] }} : {{ $v['grade_after'] }}
                                    @if($v['is_passed']=='1')
                                        <span class="badge bg-success text-white">Lulus</span>
                                    @else
                                        <a href="javascript:hapus({{ $v['mahmulid'] }})"><span class="badge bg-danger text-white">hapus</span></a>
                                    @endif
                                @endif
                                @if($pelajaran!=$v['subject'])
                                </li>
                                @endif
                            @endforeach
                            </ul>
                        </td>
                        <td>
                        </td>
                    </tr>
                    @php
                        $no++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> <!-- /container -->
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="bi bi-arrow-up-circle"></i> ke atas</button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
    <script>
        let mybutton = document.getElementById("myBtn");
        window.onscroll = function() {scrollFunction()};
        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
            }
            function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>
    <script>
        $(document).ready( function () {
            $('.table').DataTable({
                fixedHeader: {
                    header: true,
                    footer: true
                },
                "paging": true,
                "language": {
                    "emptyTable": "Tidak ada data",
                    "info": "Tampil _START_ sampai _END_ dari _TOTAL_ data",
                    "lengthMenu": "Lihat _MENU_ data",
                    "paginate": {
                        "previous": "&lt;",
                        "next": "&gt;"
                    },
                    "search": "Cari :",
                },
                "searching": true,
            });
        } );
        function proses(id='',idc='')
        {
            const data = new Object();
            data._token = '{{ csrf_token() }}';
            data.id = id;
            if(id!='')
            {
                $('#tmbl'+id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $('#tmbl'+id).attr('disabled','disabled');
            }
            data.subjectid = idc;
            if(idc!='')
            {
                $('#tmbl'+id+idc).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $('#tmbl'+id+idc).attr('disabled','disabled');
            }
            if(id==''&&idc=='')
            {
                $('#tmbl').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $('#tmbl').attr('disabled','disabled');
            }
            data.type = 'exe';
            $.post('{{ url('cek-mahmul') }}',data,function(data){
                if(data=='Berhasil')
                {
                    location.reload();
                }
            })
        }
        function hapus(id)
        {
            if(confirm('Yakin akan hapus?'))
            {
                const data = new Object();
                data._token = '{{ csrf_token() }}';
                data.type = 'hapus';
                data.id = id;
                $.post('{{ url('cek-mahmul') }}',data,function(data){
                    if(data=='Berhasil')
                    {
                        location.reload();
                    }
                })
            }
        }
        function hapuspelajaran(id,subjectid)
        {
            if(confirm('Yakin akan hapus?'))
            {
                const data = new Object();
                data._token = '{{ csrf_token() }}';
                data.type = 'hapuspelajaran';
                data.id = id;
                data.subjectid = subjectid;
                $.post('{{ url('cek-mahmul') }}',data,function(data){
                    if(data=='Berhasil')
                    {
                        location.reload();
                    }
                })
            }
        }
    </script>
</body>

</html>
