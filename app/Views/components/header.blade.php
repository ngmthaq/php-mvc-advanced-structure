{{-- Name: Header Component --}}
{{-- Note: If header id changed, please change HEADER_ID in public/js/const.js --}}
{{-- Note: If scroll-to-top id changed, please change SCROLL_TOP_BUTTON_ID in public/js/const.js --}}
<header id="main-header">
    <div class="container-fluid">
        <div class="row align-items-center h-100">
            <div class="col-lg-2">
                <div class="main-header-wrapper">
                    <a href="/" class="main-header-logo">LOGO</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="main-header-wrapper">
                    <ul class="navbar-wrapper">
                        <li class="navbar-item">
                            <a href="/"
                                class="{{ currentUri() === '/' ? 'active' : '' }}">{{ trans('header_home') }}</a>
                        </li>
                        <li class="navbar-item">
                            <a href="#"
                                class="{{ currentUri() === '#' ? 'active' : '' }}">{{ trans('header_template') }}</a>
                        </li>
                        <li class="navbar-item">
                            <a href="#"
                                class="{{ currentUri() === '#' ? 'active' : '' }}">{{ trans('header_contact') }}</a>
                        </li>
                        <li class="navbar-item">
                            <a href="#"
                                class="{{ currentUri() === '#' ? 'active' : '' }}">{{ trans('header_account') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="main-header-wrapper">
                    <form action="/" method="get">
                        <input class="form-control form-control-sm" type="text"
                            placeholder="{{ trans('header_search') }}">
                    </form>
                </div>
            </div>
            <div class="col-lg-1">
                <div class="main-header-wrapper">
                    <form action="/" method="get">
                        <select class="form-control form-control-sm w-auto text-uppercase">
                            @foreach (locales() as $locale)
                                <option value="{{ $locale }}" class="text-uppercase"
                                    {{ locale() === $locale ? 'selected' : '' }}>
                                    {{ $locale }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="scroll-to-top">
        <i class="fa-solid fa-chevron-up"></i>
    </div>
</header>
