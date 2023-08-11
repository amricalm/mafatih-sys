<!-- Fixed navbar -->
<header class="header" style="background-image:url({{ asset('assets/img/adn/bg-msh-miring.png') }});-webkit-background-size: auto;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center middle;background-origin: content-box;">
    <div class="row">
        <div class="col-auto px-0">
            <button class="menu-btn btn btn-40 btn-link" type="button">
                <span class="material-icons">menu</span>
            </button>
        </div>
        <div class="text-left col align-self-center">
            <a class="navbar-brand" href="#">
                <h5 class="mb-0">{{ config('app.name','Dashboard') }}</h5>
            </a>
        </div>
        {{-- <div class="ml-auto col-auto pl-0">
            <a href="{{ url('mobile/notifikasi') }}" class="btn btn-40 btn-link">
                <span class="material-icons">notifications_none</span>
                <span class="counter"></span>
            </a>
        </div> --}}
    </div>
</header>
