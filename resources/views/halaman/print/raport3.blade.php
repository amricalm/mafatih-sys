@extends('layouts.pdf-template-latin')
@section('header')
@endsection
@section('isi')
        <div class="wrapper">
            <table align="center" border="0" width="100%" style="font-size: 12px; padding-bottom: -10px;">
               <tr>
                 <td width="15%" style="font-size: 12px;">Nama Peserta Didik</td>
                 <td width="46%" style="font-size: 12px; text-transform: uppercase;">: {{ $student->name }}</td>
                 <td width="17%" style="font-size: 12px;">Kelas</td>
                 <td width="20%" style="font-size: 12px;">: {{ $student->class_name }}</td>
               </tr>
               <tr>
                 <td style="font-size: 12px;">Nomor Induk / NISN</td>
                 <td style="font-size: 12px; text-transform: uppercase;">: {{ $student->nis }} / {{ $student->nisn }}</td>
                 <td style="font-size: 12px;">Semester</td>
                 <td style="font-size: 12px;">: {{ config('id_active_term') }} ({{ \App\SmartSystem\General::terbilang(config('id_active_term')) }})</td>
               </tr>
               <tr>
                 <td width="22%" style="font-size: 12px;">Nama Sekolah</td>
                 <td width="41%" style="font-size: 12px; text-transform: uppercase;">:
                    @php
                        if($student->level>=1 && $student->level<=3) {
                            $school_type = collect($school_type)->where('id',2);
                            echo $school_type[2]->name;
                        } elseif($student->level>=4 && $student->level<=6) {
                            $school_type = collect($school_type)->where('id',3);
                            echo $school_type[3]->name;
                        }
                    @endphp
                 </td>
                 <td style="font-size: 12px;">Tahun Pelajaran</td>
                 <td style="font-size: 12px;">: {{ config('active_academic_year') }}</td>
               </tr>
               <tr>
                 <td style="font-size: 12px;">Alamat Sekolah</td>
                 <td style="font-size: 12px;">: {{ $school['address'] }}, {{ Str::title($school['districtname']) }}, {{ Str::title($school['cityname']) }}, {{ Str::title($school['provincename']) }}</td>
               </tr>
           </table>
           <hr color="black" width="2">
             <table align="center" width="100%" style="font-size: 12px; border-collapse: collapse;">
               <tr>
                 <td colspan="3" style="padding-top: 10px;font-weight: bold;font-size: 12px;">A. SIKAP</td>
               </tr>
               <tr>
                   <td colspan="3" style="padding-top: 10px;padding-bottom: 10px;font-weight: bold;font-size: 12px;">1. Sikap Spiritual</td>
                 </tr>
               <tr>
                 <td style="width: 20%; height: 40px; border:1px solid black;text-align:center;font-size: 12px; font-weight:bold;">Predikat</td>
                 <td style="width: 80%;border:1px solid black;text-align:center;font-size: 12px; font-weight:bold;">Deskripsi</td>
               </tr>
               @php $attitudespiritual = collect($raport)->where('letter_grade', 1)->where('id',1); @endphp
                @foreach ($attitudespiritual as $rows)
                    <tr>
                        <td style="border:1px solid black;padding-left:10px;font-size: 12px; text-align: middle;">{{ \App\SmartSystem\General::numbertolongPredikatDiknas($rows['final_grade']) }}</td>
                        <td style="border:1px solid black;padding:10px;font-size: 12px; text-align: middle;">
                            {{ $rows['knowledge_desc'] }}
                        </td>
                    </tr>
                @endforeach
             </table>
             <table align="center" width="100%" style="font-size: 12px; border-collapse: collapse;">
               <tr>
                   <td colspan="3" style="padding-top: 10px;padding-bottom: 10px;font-weight: bold;font-size: 12px;">2. Sikap Sosial</td>
               </tr>
               <tr>
                   <td style="width: 20%; height: 40px; border:1px solid black;text-align:center;font-size: 12px; font-weight:bold;">Predikat</td>
                   <td style="width: 80%;border:1px solid black;text-align:center;font-size: 12px; font-weight:bold;">Deskripsi</td>
               </tr>
               @php $attitudesocial = collect($raport)->where('letter_grade', 2)->where('id',2); @endphp
                @foreach ($attitudesocial as $rows)
                    <tr>
                        <td style="border:1px solid black;padding-left:10px;font-size: 12px;">{{ \App\SmartSystem\General::numbertolongPredikatDiknas($rows['final_grade']) }}</td>
                        <td style="border:1px solid black; padding: 10px; font-size: 12px; text-align: middle;">
                            {{ $rows['knowledge_desc'] }}
                        </td>
                    </tr>
                @endforeach
             </table>
             {{-- <br>
             <br>
             <br>
             <table align="right" width="30%" style="font-size: 12px; border-collapse: collapse;">
               <tr>
                   <td style="font-size: 12px;">Bogor, {{ $tgl_raport }}</td>
               </tr>
               <tr>
                   <td style="font-size: 12px;">Wali Kelas,</td>
               </tr>
               <tr>
                   <td style="height:70px;"></td>
               </tr>
               <tr>
                @foreach ($signed as $key => $val)
                    <td style="font-size: 12px; font-weight: bold;"><u>{{ $val->name }}</u></td>
                    @php break; @endphp
                @endforeach
               </tr>
               <tr>
                    @foreach ($signed as $key => $val)
                        <td style="font-size: 12px;">{{ $val->nip }}</td>
                        @php break; @endphp
                    @endforeach
               </tr>
             </table>
             <div style="page-break-before: always;"></div> --}}
             {{-- <table align="center" border="0" width="100%" style="font-size: 12px; padding-bottom: -10px;">
               <table align="center" border="0" width="100%" style="font-size: 12px; padding-bottom: 0px;">
               <tr>
                 <td width="15%" style="font-size: 12px;">Nama Peserta Didik</td>
                 <td width="46%" style="font-size: 12px; text-transform: uppercase;">: {{ $student->name }}</td>
                 <td width="17%" style="font-size: 12px;">Kelas</td>
                 <td width="20%" style="font-size: 12px;">: {{ $student->class_name }}</td>
               </tr>
               <tr>
                 <td style="font-size: 12px;">Nomor Induk / NISN</td>
                 <td style="font-size: 12px; text-transform: uppercase;">: {{ $student->nis }} / {{ $student->nisn }}</td>
                 <td style="font-size: 12px;">Semester</td>
                 <td style="font-size: 12px;">: {{ config('id_active_term') }} ({{ \App\SmartSystem\General::terbilang(config('id_active_term')) }})</td>
               </tr>
               <tr>
                 <td width="22%" style="font-size: 12px;">Nama Sekolah</td>
                 <td width="41%" style="font-size: 12px; text-transform: uppercase;">: {{ $school->name }}</td>
                 <td style="font-size: 12px;">Tahun Pelajaran</td>
                 <td style="font-size: 12px;">: {{ config('active_academic_year') }}</td>
               </tr>
               <tr>
                 <td style="font-size: 12px;">Alamat Sekolah</td>
                 <td style="font-size: 12px;">: Jl. Tegal Waru, Ciampea</td>
               </tr>
           </table>
           <hr color="black" width="2"> --}}
             <table id="tabel_nilai" align="center" style="width: 100%; border-collapse: collapse">
               <tr>
                 <td colspan="3" style="padding-top: 10px; font-size: 12px;font-weight:bold;">B. PENGETAHUAN</td>
               </tr>
               <tr>
                    <td colspan="3" style="font-size: 12px;">Ketuntasan Belajar Minimal : 71</td>
                </tr>
             </table>
             <table align="center" width="100%" style="border-collapse: collapse">
               <thead style="text-transform: none;">
                <tr style="">
                    <td rowspan="2" style="text-align:center; border:1px solid black; font-size: 12px; width: 5%;  font-weight:bold;">No</td>
                    <td rowspan="2" style="text-align:center; border:1px solid black; font-size: 12px; width: 17%;  font-weight:bold;">Mata Pelajaran</td>
                    <td colspan="3" style="text-align:center; border:1px solid black;font-size: 12px;  width: 78%; height: 30px; font-weight:bold;">Pengetahuan</td>
                  </tr>
                  <tr style="">
                    <td style="text-align:center; border:1px solid black;font-size: 12px; width: 6%;  font-weight:bold;">Nilai</td>
                    <td style="text-align:center; border:1px solid black;font-size: 12px; width: 9%;  font-weight:bold;">Predikat</td>
                    <td style="text-align:center; border:1px solid black;font-size: 12px; width: 50%;  font-weight:bold;">Deskripsi</td>
                </tr>
               </thead>
               <tbody>
                    <tr>
                        <td colspan="5" style="border:1px solid black;font-size: 12px; padding:5px;">Kelompok A (Umum)</td>
                    </tr>
                    @php $knowledgea = collect($raport)->where('letter_grade', 3)->where('is_mulok',0); $i=1; @endphp
                    @foreach ($knowledgea as $key => $rows)
                        <tr>
                            <td align="center" style="border:1px solid black;font-size: 12px">{{ $i }}</td>
                            <td style="border:1px solid black;font-size: 12px; padding:5px; line-height:13px;">{{ $rows['name'] }}</td>
                            <td align="center" style="border:1px solid black;font-size: 12px">{{ number_format($rows['final_grade'])!=0 ? number_format($rows['final_grade']) : '' }}</td>
                            <td align="center" style="border:1px solid black;font-size: 12px"> {{ number_format($rows['final_grade'])!=0 ?  \App\SmartSystem\General::predikatDiknas(number_format($rows['final_grade']))  : '' }}</td>
                            <td align="left" style="font-size: 12px;border:1px solid black; padding: 5px; text-align: justify;">{{ number_format($rows['final_grade'])!=0 ? $rows['knowledge_desc'] : ''; }}</td>
                        </tr>
                      @php $i++; @endphp
                    @endforeach
                    <tr>
                        <td colspan="5" style="border:1px solid black;font-size: 12px; padding:5px;">Kelompok B (Umum)</td>
                    </tr>
                    @php $knowledgeb = collect($raport)->where('letter_grade', 3)->where('is_mulok',1); @endphp
                    @foreach ($knowledgeb as $key => $rows)
                        <tr>
                            <td align="center" style="border:1px solid black;font-size: 12px">{{ $i }}</td>
                            <td style="border:1px solid black;font-size: 12px; padding:5px; line-height:13px;">{{ $rows['name'] }}</td>
                            <td align="center" style="border:1px solid black;font-size: 12px">{{ number_format($rows['final_grade'])!=0 ? number_format($rows['final_grade']) : '' }}</td>
                            <td align="center" style="border:1px solid black;font-size: 12px"> {{ number_format($rows['final_grade'])!=0 ? \App\SmartSystem\General::predikatDiknas(number_format($rows['final_grade'])) : '' }}</td>
                            <td align="left" style="font-size: 12px;border:1px solid black; padding: 5px; text-align: justify;">{{ number_format($rows['final_grade'])!=0 ? $rows['knowledge_desc'] : ''; }}</td>
                        </tr>
                      @php $i++; @endphp
                    @endforeach
                    <tr>
                        <td colspan="5" style="border:1px solid black;font-size: 12px; padding:5px;">Muatan Lokal</td>
                    </tr>
                    @php $knowledgec = collect($raport)->where('letter_grade', 3)->where('is_mulok',2); @endphp
                    @foreach ($knowledgec as $key => $rows)
                        <tr>
                            <td align="center" style="border:1px solid black;font-size: 12px">{{ $i }}</td>
                            <td style="border:1px solid black;font-size: 12px; padding:5px; line-height:13px;">{{ $rows['name'] }}</td>
                            <td align="center" style="border:1px solid black;font-size: 12px">{{ number_format($rows['final_grade'])!=0 ? number_format($rows['final_grade']) : '' }}</td>
                            <td align="center" style="border:1px solid black;font-size: 12px"> {{ number_format($rows['final_grade'])!=0 ? \App\SmartSystem\General::predikatDiknas(number_format($rows['final_grade'])) : '' }}</td>
                            <td align="left" style="font-size: 12px;border:1px solid black; padding: 5px; text-align: justify;">{{ number_format($rows['final_grade'])!=0 ? $rows['knowledge_desc'] : ''; }}</td>
                        </tr>
                      @php $i++; @endphp
                    @endforeach
                </tbody>
             </table>
             {{-- <br>
             <table align="right" width="30%" style="font-size: 12px; border-collapse: collapse;">
                <tr>
                    <td style="font-size: 12px;">Bogor, {{ $tgl_raport }}</td>
                </tr>
                <tr>
                    <td style="font-size: 12px;">Wali Kelas,</td>
                </tr>
                <tr>
                    <td style="height:70px;"></td>
                </tr>
                <tr>
                 @foreach ($signed as $key => $val)
                     <td style="font-size: 12px; font-weight: bold;"><u>{{ $val->name }}</u></td>
                     @php break; @endphp
                 @endforeach
                </tr>
                <tr>
                     @foreach ($signed as $key => $val)
                         <td style="font-size: 12px;">NIP.</td>
                         @php break; @endphp
                     @endforeach
                </tr>
            </table>
             <div style="page-break-before: always;"></div>
             <table align="center" border="0" width="100%" style="font-size: 12px; padding-bottom: -10px;">
               <tr>
                 <td width="15%" style="font-size: 12px;">Nama Peserta Didik</td>
                 <td width="46%" style="font-size: 12px; text-transform: uppercase;">: {{ $student->name }}</td>
                 <td width="17%" style="font-size: 12px;">Kelas</td>
                 <td width="20%" style="font-size: 12px;">: {{ $student->class_name }}</td>
               </tr>
               <tr>
                 <td style="font-size: 12px;">Nomor Induk / NISN</td>
                 <td style="font-size: 12px; text-transform: uppercase;">: {{ $student->nis }} / {{ $student->nisn }}</td>
                 <td style="font-size: 12px;">Semester</td>
                 <td style="font-size: 12px;">: {{ config('id_active_term') }} ({{ \App\SmartSystem\General::terbilang(config('id_active_term')) }})</td>
               </tr>
               <tr>
                 <td width="22%" style="font-size: 12px;">Nama Sekolah</td>
                 <td width="41%" style="font-size: 12px; text-transform: uppercase;">: {{ $school->name }}</td>
                 <td style="font-size: 12px;">Tahun Pelajaran</td>
                 <td style="font-size: 12px;">: {{ config('active_academic_year') }}</td>
               </tr>
               <tr>
                 <td style="font-size: 12px;">Alamat Sekolah</td>
                 <td style="font-size: 12px;">: Jl. Tegal Waru, Ciampea</td>
               </tr>
           </table>
           <hr color="black" width="2">  --}}
           <table id="tabel_nilai" align="center" style="width: 100%; border-collapse: collapse">
            <tr>
              <td colspan="3" style="padding-top: 10px; font-size: 12px;font-weight:bold;">C. KETERAMPILAN</td>
            </tr>
            <tr>
                 <td colspan="3" style="font-size: 12px;">Ketuntasan Belajar Minimal : 71</td>
             </tr>
          </table>
           <table align="center" width="100%" style="border-collapse: collapse">
             <thead style="text-transform: none;">
                <tr style="">
                    <td rowspan="2" style="text-align:center; border:1px solid black; font-size: 12px; width: 5%;  font-weight:bold;">No</td>
                    <td rowspan="2" style="text-align:center; border:1px solid black; font-size: 12px; width: 17%;  font-weight:bold;">Mata Pelajaran</td>
                    <td colspan="3" style="text-align:center; border:1px solid black;font-size: 12px;  width: 78%; height: 30px; font-weight:bold;">Keterampilan</td>
                  </tr>
                  <tr style="">
                    <td style="text-align:center; border:1px solid black;font-size: 12px; width: 6%;  font-weight:bold;">Nilai</td>
                    <td style="text-align:center; border:1px solid black;font-size: 12px; width: 9%;  font-weight:bold;">Predikat</td>
                    <td style="text-align:center; border:1px solid black;font-size: 12px; width: 50%;  font-weight:bold;">Deskripsi</td>
                  </tr>
             </thead>
             <tbody>
                <tr>
                    <td colspan="5" style="border:1px solid black;font-size: 12px; padding:5px;">Kelompok A (Umum)</td>
                </tr>
                @php $skilla = collect($raport)->where('letter_grade', 4)->where('is_mulok',0); $k=1; @endphp
                @foreach ($skilla as $key => $rows)
                    <tr>
                        <td align="center" style="border:1px solid black;font-size: 12px">{{ $k }}</td>
                        <td style="border:1px solid black;font-size: 12px; padding:5px; line-height:13px;">{{ $rows['name'] }}</td>
                        <td align="center" style="border:1px solid black;font-size: 12px">{{ number_format($rows['final_grade'])!=0 ? number_format($rows['final_grade']) : '' }}</td>
                        <td align="center" style="border:1px solid black;font-size: 12px"> {{ number_format($rows['final_grade'])!=0 ? \App\SmartSystem\General::predikatDiknas(number_format($rows['final_grade'])) : '' }}</td>
                        <td align="left" style="font-size: 12px;border:1px solid black; padding: 5px; text-align: justify;">{{ number_format($rows['final_grade'])!=0 ? $rows['skill_desc'] : ''; }}</td>
                    </tr>
                    @php $k++; @endphp
                @endforeach
                <tr>
                    <td colspan="5" style="border:1px solid black;font-size: 12px; padding:5px;">Kelompok B (Umum)</td>
                </tr>
                @php $skillb = collect($raport)->where('letter_grade', 4)->where('is_mulok',1); @endphp
                @foreach ($skillb as $key => $rows)
                    <tr>
                        <td align="center" style="border:1px solid black;font-size: 12px">{{ $k }}</td>
                        <td style="border:1px solid black;font-size: 12px; padding:5px; line-height:13px;">{{ $rows['name'] }}</td>
                        <td align="center" style="border:1px solid black;font-size: 12px">{{ number_format($rows['final_grade'])!=0 ? number_format($rows['final_grade']) : '' }}</td>
                        <td align="center" style="border:1px solid black;font-size: 12px"> {{ number_format($rows['final_grade'])!=0 ? \App\SmartSystem\General::predikatDiknas(number_format($rows['final_grade'])) : '' }}</td>
                        <td align="left" style="font-size: 12px;border:1px solid black; padding: 5px; text-align: justify;">{{ number_format($rows['final_grade'])!=0 ? $rows['skill_desc'] : ''; }}</td>
                    </tr>
                    @php $k++; @endphp
                @endforeach
                <tr>
                    <td colspan="5" style="border:1px solid black;font-size: 12px; padding:5px;">Muatan Lokal</td>
                </tr>
                @php $skillc = collect($raport)->where('letter_grade', 4)->where('is_mulok',2); @endphp
                @foreach ($skillc as $key => $rows)
                    <tr>
                        <td align="center" style="border:1px solid black;font-size: 12px">{{ $k }}</td>
                        <td style="border:1px solid black;font-size: 12px; padding:5px; line-height:13px;">{{ $rows['name'] }}</td>
                        <td align="center" style="border:1px solid black;font-size: 12px">{{ number_format($rows['final_grade'])!=0 ? number_format($rows['final_grade']) : '' }}</td>
                        <td align="center" style="border:1px solid black;font-size: 12px"> {{ number_format($rows['final_grade'])!=0 ? \App\SmartSystem\General::predikatDiknas(number_format($rows['final_grade'])) : '' }}</td>
                        <td align="left" style="font-size: 12px;border:1px solid black; padding: 5px; text-align: justify;">{{ number_format($rows['final_grade'])!=0 ? $rows['skill_desc'] : ''; }}</td>
                    </tr>
                    @php $k++; @endphp
                @endforeach
              </tbody>
           </table>
             {{-- <br>
             <table align="right" width="30%" style="font-size: 12px; border-collapse: collapse;">
                <tr>
                    <td style="font-size: 12px;">Bogor, {{ $tgl_raport }}</td>
                </tr>
                <tr>
                    <td style="font-size: 12px;">Wali Kelas,</td>
                </tr>
                <tr>
                    <td style="height:70px;"></td>
                </tr>
                <tr>
                 @foreach ($signed as $key => $val)
                     <td style="font-size: 12px; font-weight: bold;"><u>{{ $val->name }}</u></td>
                     @php break; @endphp
                 @endforeach
                </tr>
                <tr>
                     @foreach ($signed as $key => $val)
                         <td style="font-size: 12px;">NIP.</td>
                         @php break; @endphp
                     @endforeach
                </tr>
            </table> --}}
             <div style="page-break-before: always;"></div>
             <table align="center" border="0" width="100%" style="font-size: 12px; padding-bottom: -10px;">
                <tr>
                  <td width="15%" style="font-size: 12px;">Nama Peserta Didik</td>
                  <td width="46%" style="font-size: 12px; text-transform: uppercase;">: {{ $student->name }}</td>
                  <td width="17%" style="font-size: 12px;">Kelas</td>
                  <td width="20%" style="font-size: 12px;">: {{ $student->class_name }}</td>
                </tr>
                <tr>
                  <td style="font-size: 12px;">Nomor Induk / NISN</td>
                  <td style="font-size: 12px; text-transform: uppercase;">: {{ $student->nis }} / {{ $student->nisn }}</td>
                  <td style="font-size: 12px;">Semester</td>
                  <td style="font-size: 12px;">: {{ config('id_active_term') }} ({{ \App\SmartSystem\General::terbilang(config('id_active_term')) }})</td>
                </tr>
                <tr>
                  <td width="22%" style="font-size: 12px;">Nama Sekolah</td>
                  <td width="41%" style="font-size: 12px; text-transform: uppercase;">:
                    @php
                        if($student->level>=1 && $student->level<=3) {
                            $school_type = collect($school_type)->where('id',2);
                            echo $school_type[2]->name;
                        } elseif($student->level>=4 && $student->level<=6) {
                            $school_type = collect($school_type)->where('id',3);
                            echo $school_type[3]->name;
                        }
                    @endphp
                  </td>
                  <td style="font-size: 12px;">Tahun Pelajaran</td>
                  <td style="font-size: 12px;">: {{ config('active_academic_year') }}</td>
                </tr>
                <tr>
                  <td style="font-size: 12px;">Alamat Sekolah</td>
                  <td style="font-size: 12px;">: {{ $school['address'] }}, {{ Str::title($school['districtname']) }}, {{ Str::title($school['cityname']) }}, {{ Str::title($school['provincename']) }}</td>
                </tr>
            </table>
           <hr color="black" width="2">
              <table style="border-collapse:collapse;width: 100%; " align="center">
               <thead style="text-transform: none;">
                 <tr>
                   <td style="font-weight: bold;font-size: 12px;padding: 10px 0px;" colspan="2">D. EKSTRAKURIKULER</td>
                 </tr>
                 <tr style="text-align:center;">
                    <td style="font-weight: bold;font-size: 12px;height:34.015748031px;width:4.5%;border:1px solid black;  font-weight:bold; text-align:center;">No</td>
                    <td style="border:1px solid black;width:40%;font-weight: bold;font-size: 12px;  font-weight:bold; text-align:center;">Kegiatan Ekstrakurikuler</td>
                    <td style="border:1px solid black;font-weight: bold;font-size: 12px;  font-weight:bold; text-align:center;">Keterangan</td>
                  </tr>
               </thead>
               <tbody>
                    @foreach ($extraculiculer as $key=>$val)
                        <tr>
                            <td align="center" style="border:1px solid black;font-size: 12px">{{ $key+1 }}</td>
                            <td style="border:1px solid black;font-size: 12px; padding:5px; line-height:13px;">{{ ($val->subject_id==15) ? $val->group_name : $val->activity_name }}</td>
                            <td align="left" style="border:1px solid black;font-size: 12px; padding:5px;">{{ \App\SmartSystem\General::shorttolongPredikatDiknas($val->letter_grade) }}</td>
                        </tr>
                    @endforeach
               </tbody>
             </table>
           <table style="margin-top:10px;border-collapse:collapse;width: 100%;" align="center">
               <thead style="text-transform: none;">
                 <tr>
                   <td colspan="3" style="font-weight: bold;font-size: 12px;padding-bottom:10px;">E. PRESTASI</td>
                 </tr>
                 <tr style="text-align:center;">
                   <td style="font-weight: bold;font-size: 12px;height:34.015748031px;width:4.5%;border:1px solid black;  font-weight:bold; text-align:center;">No</td>
                   <td style="border:1px solid black;width:40%;font-weight: bold;font-size: 12px;  font-weight:bold; text-align:center;">Jenis Kegiatan</td>
                   <td style="border:1px solid black;font-weight: bold;font-size: 12px;  font-weight:bold; text-align:center;">Keterangan</td>
                 </tr>
               </thead>
               <tbody>
                @foreach ($achievement as $key=>$val)
                    <tr>
                        <td align="center" style="border:1px solid black;font-size: 12px">{{ $key+1 }}</td>
                        <td style="border:1px solid black;font-size: 12px; padding:5px; line-height:13px;">{{ $val->name }}</td>
                        <td style="border:1px solid black;font-size: 12px; padding:5px;">{{ $val->desc }}</td>
                    </tr>
                @endforeach
               </tbody>
             </table>
             <table style="width: 50%; margin-top:10px; border-collapse: collapse;">
               <tr>
                   <td colspan="3" style="font-size: 12px;font-weight:bold;padding-bottom:10px;">F. KETIDAKHADIRAN</td>
               </tr>
               <tr>
                   <td style="font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding:5px 5px 5px 10px; width: 40%;">Sakit</td>
                   <td style="font-size: 12px;border-top: 1px solid black;border-bottom: 1px solid black; width: 5%">:</td>
                   <td style="font-size: 12px;text-align:left;border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">{{ $student->absent_s }}&nbsp;&nbsp;&nbsp;&nbsp;Hari</td>
               </tr>
               <tr>
                   <td style="padding:5px 5px 5px 10px;font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">Ijin</td>
                   <td style="font-size: 12px;border-top: 1px solid black;border-bottom: 1px solid black;">:</td>
                   <td style="font-size: 12px;text-align:left;border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">{{ $student->absent_i }}&nbsp;&nbsp;&nbsp;&nbsp;Hari</td>
               </tr>
               <tr>
                   <td style="padding:5px 5px 5px 10px;font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;text-align:left;">Tanpa Keterangan</td>
                   <td style="font-size: 12px;border-top: 1px solid black;border-bottom: 1px solid black;">:</td>
                   <td style="font-size: 12px;text-align:left;border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">{{ $student->absent_a }}&nbsp;&nbsp;&nbsp;&nbsp;Hari</td>
               </tr>
             </table>
             <table style="border-collapse:collapse;width: 100%; margin-top:10px;" align="center">
               <tr>
                 <td style="font-weight: bold;font-size: 12px; padding-bottom: 10px;">G. CATATAN WALI KELAS</td>
               </tr>
             </table>
             <div style="border:1px solid black;width:100%; font-size: 12px; height:80px;padding:10px; text-align:center;">{{ $student_from_diknas->note_from_student_affairs }}</div>
           {{-- <table style="border-collapse:collapse;width: 100%; " align="center">
             <tr>
               <td colspan="4" height="30px">
                 <?php
                 // $kelas_lama = str_replace('+',' ',$this->uri->segment(3));
                 // $naik_kelas = array('I'=>'II ( DUA )','II'=>'III ( TIGA )','III'=>'IV ( EMPAT )','IV'=>'V ( LIMA )','V'=>'VI ( ENAM )','VI'=>'LULUS');
                 //   foreach($naik_kelas as $keynaik_kelas=>$valuenaik_kelas)
                 //   {
                 //     if(trim($kelas_lama) == $keynaik_kelas) {
                 //       echo "<b>Naik ke Kelas : ".$valuenaik_kelas."</b>";
                 //     }
                 //   }
               ?>
               </td>
             </tr>
           </table> --}}
           <br>
           <br>
           <table style="border-collapse:collapse;width: 100%;" align="center">
                <tr>
                    <td style="font-size: 12px; width:33,3%;">Mengetahui</td>
                    <td style="font-size: 12px; width:33,3%;"></td>
                    <td style="font-size: 12px; width:33,3%;">Bogor, {{ $tgl_raport }}</td>
                </tr>
                <tr>
                    <td style="font-size: 12px">Orang Tua/Wali,</td>
                    <td style="font-size: 12px">Wali Kelas,</td>
                    <td style="font-size: 12px">Kepala Sekolah</td>
                </tr>
                <tr>
                    <td style="height:70px;"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: 12px">...................................</td>
                    @foreach ($signed as $key => $val)
                        <td style="font-size: 12px; font-weight: bold;"><u>{{ $val->name }}</u></td>
                    @endforeach
                </tr>
                <tr>
                    <td style="font-size: 12px"></td>
                    @foreach ($signed as $key => $val)
                        <td style="font-size: 12px;">NIP.</td>
                    @endforeach
                </tr>
            </table>
    </div>
@endsection
