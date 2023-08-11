@if (isset($nomenu))

@else
<nav class="navbar navbar-top navbar-expand-md navbar-light bg-emas" id="navbar-main">
    <div class="container-fluid" id="toptray">
        <!-- Brand -->
        <a class="h4 mb-0 text-uppercase d-none d-lg-inline-block" href="#">
            @php echo config('active_school'); @endphp
        </a>
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item">
                <a href="{{ url('notifikasi') }}" class="nav-link" >
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle bg-maroon">
                            <i class="far fa-bell"></i>
                        </span>
                    </div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-2-800x800.jpg">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <a href="{{ url('lihat-file') }}" class="dropdown-item">
                        <i class="far fa-folder-open"></i>
                        <span>Lihat File</span>
                    </a>
                    <a href="{{ url('profile') }}" class="dropdown-item">
                        <i class="ni ni-circle-08"></i>
                        <span>Ganti Password</span>
                    </a>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
@endif
