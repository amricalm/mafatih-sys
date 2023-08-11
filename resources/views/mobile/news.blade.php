<div class="main-container">
    <div class="container">
        <h5>Artikel Terakhir</h5>
        @php
        $feed = collect($feed)->take(8)->toArray();
        @endphp
        <div class="row">
            @for($i=0;$i<count($feed);$i++)
            @php
            $image=($feed[$i]->featured_media!='0') ?
                collect(\App\SmartSystem\WpLibrary::getFeatureImage($feed[$i]->featured_media))->toArray() :
                array('source_url'=>'');
                $judulartikel = $feed[$i]->title;
                $link = $feed[$i]->link;
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card border-0 mb-4 overflow-hidden">
                        <div class="card-body h-150 position-relative">
                            @if ($i==0)
                            <div class="bottom-left m-2">
                                <button class="btn btn-sm btn-default rounded">Baru</button>
                            </div>
                            @endif
                            <a href="product.html" class="background" style="background-image: url('{{ $image['source_url'] }}');">
                                <img src="{{ $image['source_url'] }}" alt="" style="display: none;">
                            </a>
                        </div>
                        <div class="card-body ">
                            {{-- <p class="mb-0"><a class="text-secondary">lebih lanjut</a></p> --}}
                            <a href="{{ $link.'?browser=1' }}">
                                <p class="mb-0">{!! $judulartikel->rendered !!}</p>
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
        </div>
        <div class="row text-center">
            <div class="col-6 col-md-4 col-lg-3 mx-auto">
                <a class="btn btn-sm btn-outline-secondary rounded" href="https://mahadsyarafulharamain.sch.id/informasi/">Lihat lebih  lengkap</a>
            </div>
        </div>
    </div>
</div>
