@extends('layouts.app')

@section('content')
<div class="header pt-5 bg-gradient-lighter pb-8 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <p>
                <button class="btn bg-maroon btn-sm text-white" type="button" data-toggle="collapse" data-target="#collapseWidthExample"
                        aria-expanded="false" aria-controls="collapseWidthExample">
                    Lihat Ayat Quran (Acak) <i class="fas fa-angle-down"></i>
                </button>
            </p>
            <div>
                <div class="collapse width" id="collapseWidthExample">
                    {!! \App\SmartSystem\General::random_quran('','jumbotron') !!}
                </div>
            </div>
            <hr class="my-4">
            @if (isset($course))
            <h2>Rombongan Belajar</h2>
            <a class="btn btn-secondary" data-toggle="collapse" href="#mkelas" role="button" aria-expanded="false" aria-controls="m">Lihat Semua <i class="fas fa-caret-down"></i></a>
            <div class="row align-items-center collapse" id="mkelas">
                @foreach ($course as $k=>$v)
                <div class="col-xl-3 col-md-6 p-2">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">{{ $v->name }}</h5>
                                    <span class="h2 mb-0 arabic">{{ $v->name_ar }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        @php
                                        $detail = DB::table('ep_course_class_dtl')->where('ccid',$v->id)->join('aa_student','sid','=','aa_student.id')->join('aa_person','pid','=','aa_person.id')->where('ayid',config('id_active_academic_year'));
                                        $ndetail = $detail->count();
                                        @endphp
                                        {{ $ndetail }}
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <a href="{{ url('rombel?pilih='.$v->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            <hr>
            {{-- <div class="row">
                <div class="col-md-12 arabic">
                    @php
                        echo \App\SmartSystem\General::random_quran();
                    @endphp
                </div>
            </div> --}}
            @php
                $no = 0;
                foreach($modul as $key=>$val)
                {
                    echo ($no!=0) ? '<hr/>' : '';
                    $menu1 = collect($menu)->where('modul_id',$val->id)->sortBy('seq')->toArray();

                    if(count($menu1)>0)
                    {
                        echo '<a class="btn btn-secondary" data-toggle="collapse" href="#m'.$val->id.'" role="button" aria-expanded="false" aria-controls="m'.$val->id.'">Menu '.$val->name.' <i class="fas fa-caret-down"></i></a>';
                        echo '<div class="row align-items-center collapse" id="m'.$val->id.'">';
                        $no = 1;
                        foreach($menu1 as $key1=>$val1)
                        {
                            echo '<div class="col-xl-3 col-md-6" style="padding:10px;">
                                    <a href="'.url($val1['slug']).'">
                                    <div class="card card-stats">
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0"><i class="'.$val1['menu_icon'].'"></i> '.$val1['menu'].'</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                   '.$no.'
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </a>
                                    </div>';
                            $no++;
                        }
                        echo '</div>';
                        $no++;
                    }
                }
            @endphp
        </div>
    </div>
</div>


@include('layouts.footers.auth')

@endsection

@push('js')
<script>
    function goto(url) {
        window.location.href = url;
    }

</script>
@endpush
