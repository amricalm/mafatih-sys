<div class="row align-items-center justify-content-xl-between" style="position: absolute;bottom: 0;width: 100%;">
    <div class="col-xl-12">
        @auth()
        <div class="copyright text-center text-xl-left text-muted">
            Copyright &copy; {{ now()->year }} <a href="https://mafatih.sch.id" class="font-weight-bold ml-1" target="_blank">SDIT MAFATIH</a>. Build with <span class="fa fa-heart text-danger"></span> by<a href="http://andhana.com" class="font-weight-bold ml-1" target="_blank">Andhana</a>.
        </div>
        @endauth
    </div>
    {{-- <div class="col-xl-6">
        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
            </li>
            <li class="nav-item">
                <a href="https://www.updivision.com" class="nav-link" target="_blank">Updivision</a>
            </li>
            <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
            </li>
        </ul>
    </div> --}}
</div>
