{{-- <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url(../assets/img/adn/pola-01.png); background-size: cover; background-position: center top; background-repeat:repeat;"> --}}
<div class="header pt-5 pt-lg-8 d-flex align-items-center" style="background-image:url(assets/img/adn/pola-01.png); -webkit-background-size: auto;-moz-background-size: auto;-o-background-size: auto;background-size: auto;">
    <!-- Mask -->
    <span class="mask opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-md-12 {{ $class ?? '' }}">
                <h1 class="display-2 maroon">{!! $title !!}</h1>
                @if (isset($description) && $description)
                <p class="maroon mt-0 mb-5">{!! $description !!}</p>
                @endif
            </div>
        </div>
    </div>
</div>
