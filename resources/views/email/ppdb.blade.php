@extends('email.index')

@section('body')
<h1>Ahlan Wasahlan!</h1>
@if(!empty($user)&&$user=='1')
<p class="mt-0 mb-5">
    Alhamdulillah wa syukrulillah Abah dan Umah akan mendaftarkan Ananda yang sebentar lagi menjadi bagian dari keluarga besar Ma'had Wakaf Syaraful Haramain dengan data awal sebagai berikut:
</p>
<p>
Nama Lengkap : {{ $name }} <br>
Username : {{ $email }} <br>
Password : {{ $password }}
</p>
<p class="mt-0 mb-5" style="font-weight: bold;">Terima kasih telah memilih Ma'had Syaraful Haramain, untuk menitipkan putri/putri Anda. Semoga Allah swt memberikan kita kemudahan dan keberkahan. Aamiin.</p>
@endif
@if(!empty($noregis)&&$noregis!='')
<p class="mt-0 mb-5">Jangan lupa Nomor Registrasi anda : <b>{{ $noregis }}</b></p>
@endif
<p class="mt-0 mb-5">Tinggal beberapa tahapan lagi dalam pendaftaran secara lengkap di Ma'had Syafahul Haramain. Berikut rinciannya (ceklis ✔️ berarti sudah lengkap, silang merah ❌ berarti belum lengkap) : </p>
<div class="row">
    <div class="col-md-12 table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <td>NO</td>
                    <td>Tahapan</td>
                    <td>#</td>
                </tr>
            </thead>
            <tbody>
                @php
                $array = [
                'Membuat akun (email dan password).',
                'Daftarkan nama calon santri, beserta kelengkapan datanya',
                'Membayar uang pendaftaran dan wakaf.',
                'Mengisi kuisioner dan dokumen kelengkapan lain',
                'Konfirmasi kelengkapan melalui WA',
                ];
                $no = 1;
                @endphp
                @foreach($array as $key=>$value)
                    @php
                        $tanda = '❌';
                        if(!empty($yes))
                        {
                            for($i=0;$i<count($yes);$i++)
                            {
                                if($yes[$i]==$key)
                                {
                                    $tanda='✔️' ;
                                    break;
                                }
                            }
                        }
                    @endphp <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $value }}</td>
                    <td>{{ $tanda }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
