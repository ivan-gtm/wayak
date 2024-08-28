<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charSet="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/menu.css') }}" media="all">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/autocomplete.css') }}" media="all">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/notification.css') }}" media="all">
    <!-- <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/promobar.css') }}" media="all"> -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/footer.css') }}" media="all">
    
    <meta name="customer-id" content="{{ $customer_id }}">
    @yield('css')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FQVV2SLQED"></script>
    
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-FQVV2SLQED');
    </script>

</head>

<body>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <header>
        @if( $sale != null && isset($sale['status']) && $sale['status'] > 0)
            @php
                // Convert sale_ends_at to a Carbon instance for easy comparison
                $saleEndsAt = \Carbon\Carbon::parse( $sale['sale_ends_at'] );

                // Check if the current date is before the sale ends
                $isNotExpired = now()->lte($saleEndsAt);

                // Check if the status is equal to 1
                $isActive = $sale['status'] == 1;
            
            @endphp
            @if($isActive && $isNotExpired)
                <div class="site-banner" data-v-f3f1b72a="" data-v-9440fe54="">
                    <p class="site-banner__content" data-v-f3f1b72a="">
                        <span class="site-banner__text" data-v-f3f1b72a="">
                            {{ $sale['site_banner_txt'] }}
                        </span>
                        <a href="{{ route('user.search',['country'=>$country,'sale'=> 1, 'sort'=>'popular','utm_source'=>'banner']) }}" class="site-banner__link large-screen-hidden u-type-label-small" data-v-f3f1b72a="">
                            {{ $sale['site_banner_btn'] }}
                        </a>
                        <a href="{{ route('user.search',['country'=>$country,'sale'=> 1, 'sort'=>'popular','utm_source'=>'banner']) }}" class="mobile-hidden btn btn--secondary btn--small btn--animated" data-v-5e31f9cb="" data-v-f3f1b72a="">
                            <span class="btn__inner" data-v-5e31f9cb="">
                                {{ $sale['site_banner_btn'] }}
                            </span>
                        </a>
                    </p>
                    <a data-test-close="" class="site-banner__close-button" data-v-f3f1b72a="">
                        <span data-v-f3f1b72a="">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg" svg-inline="" role="presentation" focusable="false" tabindex="-1">
                                <path d="M1.563 10.688l9.374-9.376M10.938 10.688L1.562 1.312" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            @endif
        @endif
        <nav class="navbar -nomargin" id="nav">
            <div class="logo-container">
                <a id="logo" href="{{ url('/') }}" title="Go to the home page" class="embedded-remove-url">
                    <div class="logo-wrapper"> 
                        <img class="logo-img" src="{{ url('assets/img/logo.svg') }}" alt="Wayak Logo" />
                    </div>
                </a>
            </div>
            <div class="primary-nav visible-small-laptop visible-desktop" id="nav-primary-items">
                <div class="nav-item-container for-user" id="my-stuff-nav-item">
                    <a class="nav-item {{ (\Route::current()->getName() == 'showHome' || \Route::current()->getName() == 'user.homepage') ? 'active' : null }}" href="{{ url('/'.$country).'?source=menu'  }}">
                        {{ __('menu.home') }}
                    </a>
                </div>
                <div class="nav-item-container hide-for-student">
                    <a class="nav-item {{ (request()->is($country.'/templates/*')) ? 'active' : null }}" href="javascript:void(0);">
                        {{ __('menu.templates') }}
                    </a>
                    <div class="dropdown-list">
                        <div class="list-container">
                            <ul class="list" id="nav-sizes-list">
                                @for($i = 0; $i < sizeof($menu->templates) / 3; $i++)
                                    <li class="list-item ">
                                        <a class="item" href="{{ $menu->templates[$i]->url.'?source=menu' }}">
                                            {{ $menu->templates[$i]->name }}
                                        </a>
                                    </li>
                                @endfor
                                    {{-- <li class="list-item">
                                        <a class="item" cta animate-icon" href="https://wayak.app/index.php/posters/sizes?utm_source=nav&utm_content=viewallsizes&utm_medium=link&utm_campaign=templategallerynav">
                                            View All <i class="icon-to-animate icon-caret-right"></i>
                                        </a>
                                    </li> --}}
                            </ul>
                            <ul class="list">
                                @for($i = (sizeof($menu->templates) / 3)+1; $i < ((sizeof($menu->templates) / 3) * 2)+1; $i++)
                                    <li class="list-item ">
                                        <a class="item" href="{{ $menu->templates[$i]->url.'?source=menu' }}">
                                            {{ $menu->templates[$i]->name }}
                                        </a>
                                    </li>
                                    @endfor
                                    {{-- <li class="list-item"><a class="item cta animate-icon" href="https://wayak.app/index.php/posters/gallery?utm_source=nav&utm_content=viewalltheme&utm_medium=link&utm_campaign=templategallerynav">View All <i class="icon-caret-right icon-to-animate"></i></a></li> --}}
                            </ul>
                            <ul class="list">
                                @for($i = ((sizeof($menu->templates) / 3)*2)+1; $i < sizeof($menu->templates); $i++)
                                    <li class="list-item ">
                                        <a class="item" href="{{ $menu->templates[$i]->url.'?source=menu' }}">
                                            {{ $menu->templates[$i]->name }}
                                        </a>
                                    </li>
                                    @endfor
                                    {{-- <li class="list-item"><a class="item cta animate-icon" href="https://wayak.app/index.php/posters/gallery?utm_source=nav&utm_content=viewalltheme&utm_medium=link&utm_campaign=templategallerynav">View All <i class="icon-caret-right icon-to-animate"></i></a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                @if($sale != null)
                <div class="nav-item-container" id="marketing-nav-item">
                    <a class="nav-item sale" href="{{ route('user.search',['country'=>$country,'sale'=> 1, 'sort'=>'popular','utm_source'=>'banner']) }}" title="Sales">
                        <svg width="17" height="17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 7" svg-inline="" role="presentation" focusable="false" tabindex="-1">
                            <path fill="currentColor" fill-rule="evenodd" d="M6.814 3.673l-1.741.822c-.15.048-.299.193-.448.435L3.78 6.62c-.15.194-.497.194-.597 0L2.338 4.93c-.05-.145-.2-.29-.448-.435L.15 3.673c-.2-.145-.2-.483 0-.58l1.74-.821c.15-.049.299-.194.448-.436l.845-1.69c.15-.194.498-.194.597 0l.845 1.69c.05.146.2.29.448.436l1.74.821c.25.145.25.484 0 .58"></path>
                        </svg>
                        Sale
                    </a>
                </div>
                @endif
                <a class="action-btn-container side-btn for-anon" id="nav-login-signup-cta" href="{{ route('code.validate.form', [
                            'country' => $country
                        ]) }}" title="Claim Code">
                    <span class="action-btn-text login-btn-text">
                        {{ __('menu.claim_code') }}
                    </span>
                </a>
            </div>
            <div class="user-options">
                <form action="{{ route('user.search',['country' => $country]) }}" class="inline-search-form" name="nav-search-form" id="nav-search-form" method="GET" onclick="document.getElementById('nav-search-input').focus();" accept-charset="utf-8" autocomplete="off">
                    @csrf
                    <input type="hidden" id="search-customer-id" name="customerId">
                    <label for="nav-search-input" class="_hidden">{{ __('menu.search_btn_label') }}</label>
                    <input class="search-input" name="searchQuery" type="text" id="nav-search-input" aria-label="{{ __('menu.search_btn_label') }}" placeholder="{{ __('menu.mobile_search_placeholder') }}" value="{{ $search_query }}" />
                    <i class="search-submit icon-search" onclick="document.forms['nav-search-form'].submit();">
                        <svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4138 15.8368L21.8574 20.2857C22.0558 20.5064 22.046 20.8443 21.8352 21.0532L21.0575 21.8317C20.9532 21.937 20.8113 21.9962 20.6632 21.9962C20.5151 21.9962 20.3731 21.937 20.2688 21.8317L15.8252 17.3828C15.7023 17.2596 15.5907 17.1256 15.4919 16.9824L14.6587 15.8701C13.2802 16.9723 11.5682 17.5724 9.80409 17.5719C6.16878 17.5845 3.00983 15.0738 2.19744 11.5261C1.38504 7.97844 3.13601 4.34066 6.41372 2.76643C9.69143 1.1922 13.6211 2.10166 15.8763 4.95639C18.1314 7.81111 18.1102 11.8492 15.8252 14.68L16.9361 15.4475C17.1096 15.5586 17.2698 15.6892 17.4138 15.8368ZM4.24951 9.78627C4.24951 12.8576 6.73635 15.3475 9.80402 15.3475C11.2772 15.3475 12.69 14.7616 13.7317 13.7186C14.7733 12.6757 15.3585 11.2612 15.3585 9.78627C15.3585 6.7149 12.8717 4.22507 9.80402 4.22507C6.73635 4.22507 4.24951 6.7149 4.24951 9.78627Z"></path>
                        </svg>
                    </i>
                </form>
                <div id="mobile-search-options"> <input type="checkbox" class="mobile-search-checkbox" value="1"
                        id="mobile-search-bar" /> <label
                        class="mobile-search-container action-btn-container -white -passive side-btn"
                        for="mobile-search-bar" id="mobile-search-bar-label"
                        onclick="document.getElementById('nav-mobile-search-input').focus();"
                        aria-label="Search for inspiration"> <span class="_hidden">Search for inspiration</span> <i
                            class="icon-search action-btn-icon"></i> </label>
                    <div id="mobile-search" class="inline-search-form -mobile">
                        <form action="https://wayak.app/index.php/posters/search" class="mobile-search-form"
                            name="mobile-search-form" id="mobile-search-form" method="GET"
                            onclick="document.getElementById('nav-mobile-search-input').focus();"
                            accept-charset="utf-8">
                            <label for="nav-mobile-search-input" class="_hidden">Search for inspiration</label> <input
                                class="mobile-search-input search-input" name="s" type="text"
                                aria-label="Search for inspiration" id="nav-mobile-search-input"
                                placeholder="Try &lsquo;sale flyer&rsquo;" maxlength="50" /> <i
                                class="icon-search search-submit mobile-search-submit"
                                onclick="document.forms['mobile-search-form'].submit();"></i>
                        </form>
                    </div>
                </div>
                <div class="wt-flex-shrink-xs-0" data-primary-nav-container="">
                    <nav aria-label="Main">
                        <ul class="wt-display-flex-xs wt-justify-content-space-between wt-list-unstyled wt-m-xs-0 wt-align-items-center">
                            
                            <li>
                                @auth
                                    {{auth()->user()->name}}
                                    <div class="text-end">
                                        <a style="color: black;" href="javascript:void(0)" onclick="logout()" class="btn btn-outline-light me-2">Logout</a>
                                    </div>
                                @endauth
                                @guest
                                    <div class="text-end">
                                        <a style="color: black;" href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Sign in</a>
                                        <!-- <a style="color: black;" href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a> -->
                                    </div>
                                @endguest
                            </li>
                            <li data-favorites-nav-container="">
                                <span class="wt-tooltip wt-tooltip--disabled-touch" data-wt-tooltip="">
                                    <a href="{{ route('user.favorites',['country'=>$country]) }}"
                                        class="wt-tooltip__trigger wt-tooltip__trigger--icon-only wt-btn wt-btn--transparent wt-btn--icon reduced-margin-xs header-button"
                                        data-favorites-nav-link="" aria-labelledby="ge-tooltip-label-favorites">

                                        <span class="etsy-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M20.877 12.52c.054-.076.103-.157.147-.239A6 6 0 0 0 12 4.528a6 6 0 0 0-9.024 7.753c.044.082.093.162.147.24l.673.961a6 6 0 0 0 .789.915L12 21.422l7.415-7.025c.293-.278.557-.584.789-.915l.673-.961Zm-14.916.425L12 18.667l6.04-5.722c.195-.185.371-.39.525-.61l.673-.961a.335.335 0 0 0 .044-.087 4 4 0 1 0-7.268-2.619v.003L12 8.667l-.013.004v-.002a3.975 3.975 0 0 0-1.237-2.574 4 4 0 0 0-6.031 5.193c.009.03.023.058.043.086l.673.961a4 4 0 0 0 .526.61Z">
                                                </path>
                                            </svg>
                                        </span>
                                    </a>

                                    <span id="ge-tooltip-label-favorites" role="tooltip"
                                        data-favorites-label-tooltip="">
                                        Favorites
                                    </span>
                                </span>
                            </li>
                            
                            <li>
                                <span class="wt-tooltip wt-tooltip--bottom-left wt-tooltip--disabled-touch"
                                    data-wt-tooltip="" data-header-cart-button="">
                                    <a data-header-cart-nav-anchor="" aria-label="Cart"
                                        href="{{ route('user.purchases',['country' => $country]) }}?ref=hdr-cart"
                                        class="wt-tooltip__trigger wt-tooltip__trigger--icon-only wt-btn wt-btn--transparent wt-btn--icon header-button">
                                        <span id="mini-cart-description" class="wt-screen-reader-only">
                                            Cart preview displayed
                                        </span>
                                        <span class="wt-z-index-1 wt-no-wrap wt-display-none ge-cart-badge wt-badge wt-badge--notificationPrimary wt-badge--small wt-badge--outset-top-right"
                                            data-selector="header-cart-count" aria-hidden="true">
                                            0
                                        </span>
                                        <span class="wt-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="m5.766 5-.618-3H1v2h2.518l2.17 10.535L6.18 17h14.306l2.4-12H5.767ZM7.82 15l-1.6-8h14.227l-1.6 8H7.82Z">
                                                </path>
                                                <path
                                                    d="M10.666 20.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm8.334 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z">
                                                </path>
                                            </svg>
                                        </span>
                                    </a>
                                    <span id="ge-tooltip-label-favorites" role="tooltip"
                                        data-favorites-label-tooltip="">
                                        Purchases
                                    </span>
                                    <div id="mini-cart"></div>
                                </span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </nav>
        <div class="nav-spacer"></div>
    </header>

    @yield('content')

    <div id="footer" class="site-footer js-site-footer" role="contentinfo">
        <div class="container-large">
            <div class="footer-lower-content">
                <div>{{ __('footer.copyright') }}</div>
                <div class="remote-locations-container">
                    {{ __('footer.made_with') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        localStorage.setItem('logoutUrl', "{{ route('logout.perform',['country'=> $country]) }}");
        localStorage.setItem('autocompleteURL', "{{ route('autocomplete',['country'=> $country]) }}");
        localStorage.setItem('popularSearchesURL',"{{ route('getTopSearches',['country'=> $country]) }}");
    </script>
    
    <script src="{{ asset('assets/js/store/init-min.js') }}"></script>
    <script src="{{ asset('assets/js/store/autocomplete-min.js') }}"></script>

    @yield('scripts')

    <!-- <div id="overlay"></div> -->
    <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="loader"></div> <!-- Add your spinner or loading animation here -->
            <p style="color: white;padding-top: 20px;text-align: center;">Processing your transaction...</p>
        </div>
    </div>

    <style>
        .loader {
            border: 10px solid #f3f3f3;
            border-top: 10px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin: auto;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .alert.alert-success {
            padding: 15px 0px;
            text-align: center;
            font-size: 17px;
            background-color: green;
            color: white;
            margin: 0px 0px 4px;
        }

    </style>

</body>

</html>