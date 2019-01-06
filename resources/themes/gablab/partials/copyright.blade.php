<div class="row">
    <div class="col-12 col-md-9 text-center text-md-left">
        <p class="small login-copyright">
            Copyright &copy; 2018 - {{ date('Y') }} <a href="https://gablab.eu/" target="_blank">GabLab EU</a>.
        </p>
    </div>
    <div class="col-12 col-md-3 text-center text-md-right">
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                <i class="fas fa-globe mr-2"></i>{{ strtoupper($_active_locale) }}
            </a>
            <div class="dropdown-menu">
                @foreach (array_diff($_locales, [$_locales[$_active_locale]]) as $key => $value)
                <a class="dropdown-item" href="?l={{ $key }}">{{ $value }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>