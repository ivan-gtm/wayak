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
    
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    
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

    <style>
        /*! CSS Used to promo bar */
        ::selection{background:var(--default-color);color:#fff;text-shadow:none;}
        a{transition:color .25s;outline:0 none;color:var(--default-link-color);-webkit-text-decoration:var(--default-link-text-decoration);text-decoration:var(--default-link-text-decoration);}
        a:hover{color:var(--default-link-hover-color);}
        a svg{color:var(--default-color);}
        svg:not(:root){overflow:hidden;}
        svg:focus{outline:unset;outline-style:unset;}
        :focus-visible{outline:2px solid var(--accessible-outline-color);}
        .u-type-label-small-semibold{font-size:14px;line-height:14px;font-family:Filson Pro,sans-serif;font-weight:500;}
        html[data-theme=legacy] .u-type-label-small-semibold{font-family:Averta,sans-serif;font-weight:700;}
        /*! CSS Used from: https://d3ui957tjb5bqd.cloudfront.net/css/global_slim.css?768d1ea9cb */
        p{font-size:14px;line-height:22px;margin:0 0 20px;}
        @media screen and (max-width:767px){
        .mobile-hidden{display:none!important;}
        }
        /*! CSS Used from: Embedded */
        .btn[data-v-5e31f9cb]{display:inline-flex;position:relative;align-items:center;justify-content:center;width:var(--btn-width, initial);height:var(--btn-height);padding:0 var(--btn-padding, 24px);overflow:hidden;transition:.2s cubic-bezier(0.32, 0, 0.59, 0.03);transition-property:color,background-color,border-color;border:var(--btn-border-width, 2px) solid var(--btn-border-color);border-radius:var(--btn-border-radius);background-color:var(--btn-bg-color);color:var(--btn-text-color);font-family:var(--btn-font-family, var(--default-font-family));font-size:var(--btn-font-size, 16px);font-weight:var(--btn-font-weight, 600);text-decoration:none;cursor:pointer;}
        .btn__inner[data-v-5e31f9cb]{display:flex;z-index:1;align-items:center;justify-content:center;}
        .btn[data-v-5e31f9cb]:before{content:"";position:absolute;top:0;left:50%;width:160%;transform:translate(-50%, var(--btn-circle-y, -125%));transition:1.6s cubic-bezier(0.25, 1, 0.5, 1);border-radius:999999999999px;background-color:var(--btn-bg-color-hover, var(--btn-text-color));pointer-events:none;aspect-ratio:1;}
        @media (hover: hover){
        .btn[data-v-5e31f9cb]:hover:not([disabled]){border-color:var(--btn-border-color-hover, var(--btn-border-color));background-color:var(--btn-bg-color-hover, var(--btn-text-color));color:var(--btn-text-color-hover, var(--btn-bg-color));}
        }
        .btn--secondary[data-v-5e31f9cb]{--btn-bg-color:#ffffff;--btn-text-color:#121314;--btn-border-color:#121314;}
        html[data-theme=legacy] .btn--secondary[data-v-5e31f9cb]{--btn-text-color:#088178;--btn-text-color-hover:#003a37;--btn-border-color:#088178;--btn-border-color-hover:#088178;--btn-bg-color-hover:#dff8f6;}
        .btn--small[data-v-5e31f9cb]{--btn-height:32px;--btn-font-size:14px;--btn-padding:12px;}
        /*! CSS Used from: Embedded */
        .site-banner[data-v-f3f1b72a]{display:flex;position:relative;align-items:center;justify-content:center;padding:12px 24px;background-color:var(--site-banner-bg-color);text-align:center;}
        .site-banner--cyber[data-v-f3f1b72a]{background-color:#ffd8ea;}
        html[data-theme=legacy] .site-banner--cyber .btn--secondary[data-v-f3f1b72a]{--btn-text-color:#e070af;--btn-text-color-hover:#da60a5;--btn-border-color:#e070af;--btn-border-color-hover:#e070af;--btn-bg-color-hover:#fbf4f6;}
        .site-banner__content[data-v-f3f1b72a]{font-size:14px;line-height:14px;font-family:Filson Pro, sans-serif;font-weight:400;display:-webkit-box;max-width:280px;margin-bottom:0;overflow:hidden;text-overflow:ellipsis;-webkit-line-clamp:3;-webkit-box-orient:vertical;}
        html[data-theme=legacy] .site-banner__content[data-v-f3f1b72a]{font-family:Averta, sans-serif;font-weight:normal;}
        @media (min-width: 768px){
        .site-banner__content[data-v-f3f1b72a]{font-size:16px;line-height:28px;font-family:Filson Pro, sans-serif;font-weight:600;max-width:600px;}
        html[data-theme=legacy] .site-banner__content[data-v-f3f1b72a]{font-family:AvertaBold, sans-serif;font-weight:normal;}
        }
        @media (min-width: 1024px){
        .site-banner__content[data-v-f3f1b72a]{font-size:16px;line-height:28px;font-family:Filson Pro, sans-serif;font-weight:600;max-width:unset;}
        html[data-theme=legacy] .site-banner__content[data-v-f3f1b72a]{font-family:AvertaBold, sans-serif;font-weight:normal;}
        }
        @media (min-width: 1024px){
        .site-banner__text[data-v-f3f1b72a]{margin-right:20px;}
        }
        .site-banner__link[data-v-f3f1b72a]{text-decoration:underline;}
        @media (min-width: 768px){
        .site-banner__link[data-v-f3f1b72a]{font-size:16px;line-height:28px;font-family:Filson Pro, sans-serif;font-weight:600;}
        html[data-theme=legacy] .site-banner__link[data-v-f3f1b72a]{font-family:AvertaBold, sans-serif;font-weight:normal;}
        }
        .site-banner__close-button[data-v-f3f1b72a]{position:absolute;top:50%;right:0%;margin-right:24px;transform:translate(0%, -50%);cursor:pointer;}
        .site-banner__close-button[data-v-f3f1b72a]  svg{color:#121314;}
        @media (min-width: 1024px){
        .site-banner .large-screen-hidden[data-v-f3f1b72a]{display:none!important;}
        }
        @media (max-width: 1023px){
        .site-banner .mobile-hidden[data-v-f3f1b72a]{display:none!important;}
        }
        /*! CSS Used from: Embedded */
        .btn[data-v-5e31f9cb]{display:inline-flex;position:relative;align-items:center;justify-content:center;width:var(--btn-width, initial);height:var(--btn-height);padding:0 var(--btn-padding, 24px);overflow:hidden;transition:.2s cubic-bezier(0.32, 0, 0.59, 0.03);transition-property:color,background-color,border-color;border:var(--btn-border-width, 2px) solid var(--btn-border-color);border-radius:var(--btn-border-radius);background-color:var(--btn-bg-color);color:var(--btn-text-color);font-family:var(--btn-font-family, var(--default-font-family));font-size:var(--btn-font-size, 16px);font-weight:var(--btn-font-weight, 600);text-decoration:none;cursor:pointer;}
        .btn__inner[data-v-5e31f9cb]{display:flex;z-index:1;align-items:center;justify-content:center;}
        .btn[data-v-5e31f9cb]:before{content:"";position:absolute;top:0;left:50%;width:160%;transform:translate(-50%, var(--btn-circle-y, -125%));transition:1.6s cubic-bezier(0.25, 1, 0.5, 1);border-radius:999999999999px;background-color:var(--btn-bg-color-hover, var(--btn-text-color));pointer-events:none;aspect-ratio:1;}
        @media (hover: hover){
        .btn[data-v-5e31f9cb]:hover:not([disabled]){border-color:var(--btn-border-color-hover, var(--btn-border-color));background-color:var(--btn-bg-color-hover, var(--btn-text-color));color:var(--btn-text-color-hover, var(--btn-bg-color));}
        }
        .btn--secondary[data-v-5e31f9cb]{--btn-bg-color:#ffffff;--btn-text-color:#121314;--btn-border-color:#121314;}
        html[data-theme=legacy] .btn--secondary[data-v-5e31f9cb]{--btn-text-color:#088178;--btn-text-color-hover:#003a37;--btn-border-color:#088178;--btn-border-color-hover:#088178;--btn-bg-color-hover:#dff8f6;}
        .btn--small[data-v-5e31f9cb]{--btn-height:32px;--btn-font-size:14px;--btn-padding:12px;}

    </style>
    
    <style>
        .autocomplete-results {
            position: absolute;
            border: 1px solid #ccc;
            color:black;
            max-height: 315px;
            overflow-y: auto;
            background-color: #fff;
            z-index: 9999;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .autocomplete-item a{
            color: black;
        }

        .autocomplete-item {
            color: black;
            cursor: pointer;
            padding: 8px 12px;
        }

        .autocomplete-item.active, 
        .autocomplete-item:hover {
            color: black;
            background-color: #f7f7f7;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* semi-transparent black */
            z-index: 100; /* adjust this value if needed to ensure it's behind the header and results but above everything else */
            display: none; /* hidden by default */
        }

        #nav {
            z-index: 101;
        }

        /* ensure header and autocomplete results are above the overlay */
        header, .autocomplete-results {
            z-index: 100; /* adjust this value if needed */
        }


    </style>
</head>

<body>
    <header>
        @if( $sale != null && $sale['status'] > 0)
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
                <div class="nav-item-container hide-for-student">
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
                                        <a class="item cta animate-icon" href="https://wayak.app/index.php/posters/sizes?utm_source=nav&utm_content=viewallsizes&utm_medium=link&utm_campaign=templategallerynav">
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
                                    <a href="https://www.etsy.com/guest/favorites?ref=hdr-fav"
                                        class="wt-tooltip__trigger wt-tooltip__trigger--icon-only wt-btn wt-btn--transparent wt-btn--icon reduced-margin-xs header-button"
                                        data-favorites-nav-link="" aria-labelledby="ge-tooltip-label-favorites">

                                        <span class="etsy-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M20.877 12.52c.054-.076.103-.157.147-.239A6 6 0 0 0 12 4.528a6 6 0 0 0-9.024 7.753c.044.082.093.162.147.24l.673.961a6 6 0 0 0 .789.915L12 21.422l7.415-7.025c.293-.278.557-.584.789-.915l.673-.961Zm-14.916.425L12 18.667l6.04-5.722c.195-.185.371-.39.525-.61l.673-.961a.335.335 0 0 0 .044-.087 4 4 0 1 0-7.268-2.619v.003L12 8.667l-.013.004v-.002a3.975 3.975 0 0 0-1.237-2.574 4 4 0 0 0-6.031 5.193c.009.03.023.058.043.086l.673.961a4 4 0 0 0 .526.61Z">
                                                </path>
                                            </svg></span>
                                    </a>

                                    <span id="ge-tooltip-label-favorites" role="tooltip"
                                        data-favorites-label-tooltip="">Favorites</span>
                                </span>
                            </li>
                            <li>
                                <span class="wt-tooltip wt-tooltip--bottom-left wt-tooltip--disabled-touch"
                                    data-wt-tooltip="" data-header-cart-button="">
                                    <a data-header-cart-nav-anchor="" aria-label="Cart"
                                        href="https://www.etsy.com/cart?ref=hdr-cart"
                                        class="wt-tooltip__trigger wt-tooltip__trigger--icon-only wt-btn wt-btn--transparent wt-btn--icon header-button">
                                        <span id="mini-cart-description" class="wt-screen-reader-only">Cart preview
                                            displayed</span>
                                        <span
                                            class="wt-z-index-1 wt-no-wrap wt-display-none ge-cart-badge wt-badge wt-badge--notificationPrimary wt-badge--small wt-badge--outset-top-right"
                                            data-selector="header-cart-count" aria-hidden="true">
                                            0
                                        </span>
                                        <span class="wt-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="m5.766 5-.618-3H1v2h2.518l2.17 10.535L6.18 17h14.306l2.4-12H5.767ZM7.82 15l-1.6-8h14.227l-1.6 8H7.82Z">
                                                </path>
                                                <path
                                                    d="M10.666 20.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm8.334 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z">
                                                </path>
                                            </svg></span>
                                    </a>
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

    <script>
        const logoutUrl = "{{ route('logout.perform',['country' => $country]) }}";
        function logout() {
            // Clear local storage
            localStorage.clear();

            // Redirect to the Laravel logout route
            window.location.href = logoutUrl;
        }
    </script>
    
    <script>
        
        // Debounce function: Ensures that the given function is not called until after the specified time has elapsed since the last time it was called
        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        // Function to fetch results from the server using AJAX
        function fetchData(query, callback) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `http://localhost:8001/search?prefix=${query}`, true);
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    const results = JSON.parse(this.responseText);
                    callback(results);
                }
            };
            xhr.send();
        }

        // Function to display the results
        function displayResults(results, container) {
            // Clear previous results
            container.innerHTML = '';
            
            results.forEach(item => {
                const div = document.createElement('div');
                const anchor = document.createElement('a');
                const searchInput = document.getElementById('nav-search-input');
                const resultsContainer = document.querySelector('.autocomplete-results');

                div.classList.add('autocomplete-item');
                
                anchor.innerText = item;

                // anchor.href = item;

                // Assigning an onclick handler directly to the anchor element
                anchor.onclick = function() {
                    // alert('Button was clicked!');
                    searchInput.value = item;
                    searchInput.form.submit(); // assuming the input is within a form, this will submit it
                        
                    resultsContainer.innerHTML = ''; // Clear the results to hide them
                };
                
                div.appendChild(anchor);
                container.appendChild(div);
            });
        }

        function displayPopularSearches(resultsContainer) {
            // Get the parsed data from localStorage
            const popularSearchesData = JSON.parse(localStorage.getItem('popularSearches'));

            // Extract terms from the data
            const terms = popularSearchesData.map(item => item.term);

            // Use the displayResults function to display the terms
            displayResults(terms, resultsContainer);
        }

        function positionResultsContainer(input, container) {
            const rect = input.getBoundingClientRect();
            container.style.top = (rect.bottom + window.scrollY) + 'px';
            container.style.left = (rect.left + window.scrollX) + 'px';
            container.style.width = rect.width + 'px';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const searchInput = document.getElementById('nav-search-input');
            // const mobileSearchInput = document.getElementById('nav-mobile-search-input');
            const resultsContainer = document.createElement('div');
            resultsContainer.classList.add('autocomplete-results');
            var currentHighlightIndex = -1; // to keep track of currently highlighted item

            // Append results container to the body (can be adjusted based on design requirements)
            document.body.appendChild(resultsContainer);

            // Event listener for search input using debouncing
            searchInput.addEventListener('keyup', debounce(function(e) {
                const query = e.target.value;

                if (searchInput.value === "") {
                    console.log(searchInput.value);
                    displayPopularSearches(resultsContainer);
                    positionResultsContainer(searchInput, resultsContainer);
                } else if (query.length > 2) { // Only fetch data if query length is greater than 3
                    fetchData(query, function(results) {
                        displayResults(results, resultsContainer);
                        positionResultsContainer(searchInput, resultsContainer);
                    });
                }
            }, 300)); // 300ms debounce time

            // New focus event listener for searchInput
            searchInput.addEventListener('focus', function() {
                if (searchInput.value === "") {
                    console.log(searchInput.value);
                    displayPopularSearches(resultsContainer);
                    positionResultsContainer(searchInput, resultsContainer);
                } else if (searchInput.value.length > 2) { // Only fetch data if query length is greater than 3
                    fetchData(searchInput.value, function(results) {
                        displayResults(results, resultsContainer);
                        positionResultsContainer(searchInput, resultsContainer);
                    });
                }
            });

            const autocompleteResults = document.querySelector('body > div.autocomplete-results');
            let inputBlurred = false;
            let autocompleteBlurred = false;
            var overlay = document.querySelector("#overlay");

            // function checkBothBlurred() {
            //     if (inputBlurred && autocompleteBlurred) {
            //         console.log('Both elements are blurred!');
            //         autocompleteResults.innerHTML = ''; // Clear the results to hide them
            //     }
            // }

            searchInput.addEventListener("focus", function() {
                overlay.style.display = "block";
                // inputBlurred = false;
                // autocompleteBlurred = false;
                // checkBothBlurred();
            });

            searchInput.addEventListener("blur", function() {
                overlay.style.display = "none";
                // inputBlurred = true;
                // // autocompleteBlurred = true;
                // // console.log('inputBlurred' + inputBlurred);
                // checkBothBlurred();
            });

            // autocompleteResults.addEventListener('blur', function() {
            //     overlay.style.display = "none";
            //     autocompleteBlurred = true;
            //     checkBothBlurred();
            // });

            // document.addEventListener("mouseover", function(event) {
            //     if (!event.target.classList.contains("autocomplete-item")) {
            //         // document.querySelector("#nav-search-input").value = event.target.innerText;
            //         // event.target.classList.add('active');
            //         autocompleteBlurred = true;
            //     } else {
            //         autocompleteBlurred = false;
            //     }
            //     // if (event.target === event) {
            //     //     document.querySelector("#nav-search-form").submit();
            //     //     console.log("hello");
            //     // }
            // });

            // Event listener for arrow key navigation
            // searchInput.addEventListener('keydown', function(e) {
            //     const items = resultsContainer.querySelectorAll(".autocomplete-item");

            //     // Remove existing active states
            //     items.forEach(item => {
            //         item.classList.remove('active');
            //     });

            //     // Down arrow key
            //     if (e.keyCode === 40) {
            //         currentHighlightIndex = (currentHighlightIndex + 1) % items.length;
            //         items[currentHighlightIndex].classList.add('active');
            //         resultsContainer.scrollTop = items[currentHighlightIndex].offsetTop;
            //         items[currentHighlightIndex].focus(); // Focus on the active item
            //     }
                
            //     // Up arrow key
            //     else if (e.keyCode === 38) {
            //         currentHighlightIndex = (currentHighlightIndex - 1 + items.length) % items.length;
            //         items[currentHighlightIndex].classList.add('active');
            //         resultsContainer.scrollTop = items[currentHighlightIndex].offsetTop;
            //         items[currentHighlightIndex].focus(); // Focus on the active item
            //     }

            //     // Any other key
            //     else {
            //         searchInput.focus();
            //     }
            // });

            
            // Function to fetch and store data in local storage
            const fetchDataAndStorePopularSearches = () => {
                const currentTime = Date.now();

                const lastUpdated = localStorage.getItem('lastUpdatedSearchTerms');
                if (lastUpdated && (currentTime - lastUpdated < 2 * 60 * 60 * 1000)) {
                    // Data is less than 2 hours old, so no need to refetch
                    return;
                }

                fetch('http://localhost:8001/us/search/popular-searches')
                    .then(response => response.json())
                    .then(data => {
                        localStorage.setItem('popularSearches', JSON.stringify(data));
                        localStorage.setItem('lastUpdatedSearchTerms', currentTime.toString());
                    })
                    .catch(error => {
                        console.error('Error fetching popular searches:', error);
                    });
            };

            // Fetch data once page is loaded
            fetchDataAndStorePopularSearches();

            // displayPopularSearches(resultsContainer);

            // Set an interval to fetch data every 2 hours
            setInterval(fetchDataAndStorePopularSearches, 2 * 60 * 60 * 1000); // 2 hours in milliseconds
        });

    </script>

    <script>
        function getCustomerId() {
            // Try to get customerId from the meta tag
            let customerMetaTag = document.querySelector('meta[name="customer-id"]');
            let customerId = customerMetaTag ? customerMetaTag.getAttribute("content") : null;

            // If customerId exists from server session
            if(customerId) {
                console.log("If customerId exists from server session")
                localStorage.setItem('customerId', customerId);
            
            }
            
            // If meta tag is empty, try to get customerId from localStorage
            if (!customerId) {
                console.log("If meta tag is empty, try to get customerId from localStorage")
                customerId = localStorage.getItem('customerId');
            }
            
            // If customerId is still not found, generate a new one and store it in localStorage
            if (!customerId) {
                console.log("If customerId is still not found, generate a new one and store it in localStorage");
                customerId = Math.random().toString(36).substr(2, 10);
                localStorage.setItem('customerId', customerId);
            }

            return customerId;
        }

        // Assign customer ID
        document.addEventListener("DOMContentLoaded", function() {
            
            let customerId = getCustomerId();

            // Update any input elements with name="customer-id" to have the value of customerId
            const customerInputs = document.querySelectorAll('input[name="customerId"]');
            customerInputs.forEach(input => {
                input.value = customerId;
            });

        });
    </script>

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

    @yield('scripts')

    <div id="overlay"></div>

</body>

</html>