@extends('mobile.template')

@section('content')
    <div class="main-container">
        <div class="container">
            <div class="container">
                <div class="card">
                    <div class="card-body px-0">
                        <div class="list-group list-group-flush">
                            @foreach ($notif as $ky=>$vl)
                            @php
                                $url = ($vl->notif_url!='') ? $vl->notif_url.'" target="_blank' : '#';
                            @endphp
                            <a class="list-group-item" href="{!! $url !!}">
                                <div class="row">
                                    <div class="col-auto align-self">
                                        <i class="material-icons text-default">check_circle</i>
                                    </div>
                                    <div class="col pl-0">
                                        <div class="row mb-1">
                                            <div class="col">
                                                <p class="mb-0">{{ $vl->notif_title }}</p>
                                            </div>
                                            <div class="col-auto pl-0">
                                                <p class="small text-secondary">{{ $vl->notif_datetime }}</p>
                                            </div>
                                        </div>
                                        <p class="small text-secondary">{!! $vl->notif_message !!}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-6 col-md-4 col-lg-3 mx-auto">
                            {{ $notif->links('mobile.paging') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
