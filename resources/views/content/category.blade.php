@extends('layouts.frontend')

@section('title', __('category.meta_title', ['cat_name' => $category_obj->name ]) )

@section('meta')
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="title" content="{{ __('category.meta_title', ['cat_name' => $category_obj->name ]) }}" />
    <meta name="description" content="{{ __('category.meta_description', ['cat_name' => $category_obj->name ]) }}" />
    <meta name="keywords" content="{{ $category_obj->name }}" />
    
    <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">
@endsection

@section('content')
<main class="content">
    <div id="app" class="appReady">
        <div class="Pwa91aRM">
            <main class="nEpAyrlb">
                <header class="SJ5W7Cap">
                    <div class="ufwFRNuO">
                        <div class="iiyeEkHc">
                            <div class="qJyzQBny">
                                <ul class="T5vuSnA9" role="navigation" aria-label="Breadcrumbs" data-test-selector="breadcrumbs-list">
                                    
                                    <li class="M5DAz63W" data-test-selector="breadcrumbs-list-item">
                                        <a class="TDnT_QDN" href="{{ url('/'.$country) }}">{{ __('product.home') }}</a>
                                    </li>
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        <li class="M5DAz63W" data-test-selector="breadcrumbs-list-item">
                                            <a class="TDnT_QDN" href="{{ $breadcrumb->url.'?source=breadcrumbs' }}">
                                                {{ $breadcrumb->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="hILQ5O1m">
                                <h1 class="r9m1sI3F">{{ $category_obj->name }}</h1>
                                {{-- <aside class="kb2fhv7t">
                                    <h2 class="gxUHa9Js"><span class="mIDWdUGM" data-test-selector="top-article-visible">Customizeable wireframe print
                                            templates</span><br></h2>
                                </aside> --}}
                            </div>
                        </div>
                    </div>
                </header>
                <div data-test-selector="page-items-id-graphic-templates-slug-graphic-templates">
                    <section class="brjUfGeW CTPdOQUg">
                        <div class="M9td4zg0">
                            <div class="QLzW0Tal">
                                {{-- <div class="Ocm_Mx1a">
                                    <div class="FpTCNow5">
                                        <div class="jF8YvPxc">
                                            <div class="HyLWiDjH BiroUOAJ"><button class="bhgufQ6f" type="button"><svg class="f0hiXs2f C6Lv3KAO" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 12" role="img" aria-label="Arrow left bold">
                                                        <path d="M0.22 6.72001C0.0793078 6.57949 0.00017505 6.38885 0 6.19V5.81001C0.00230401 5.61159 0.0811163 5.42173 0.22 5.28L5.36 0.150005C5.45388 0.0553485 5.58168 0.00210571 5.715 0.00210571C5.84832 0.00210571 5.97612 0.0553485 6.07 0.150005L6.78 0.860005C6.87406 0.952168 6.92707 1.07832 6.92707 1.21C6.92707 1.34169 6.87406 1.46784 6.78 1.56L2.33 6L6.78 10.44C6.87466 10.5339 6.9279 10.6617 6.9279 10.795C6.9279 10.9283 6.87466 11.0561 6.78 11.15L6.07 11.85C5.97612 11.9447 5.84832 11.9979 5.715 11.9979C5.58168 11.9979 5.45388 11.9447 5.36 11.85L0.22 6.72001Z">
                                                        </path>
                                                    </svg></button></div>
                                            <div class="lzjNLhdd"><button class="x_UP53cd icCCJwMz" type="button"><svg class="f0hiXs2f C6Lv3KAO" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 12" role="img" aria-label="Arrow right bold">
                                                        <path d="M6.78016 5.2801C6.92086 5.42061 6.99999 5.61125 7.00016 5.8101V6.1901C6.99786 6.38851 6.91905 6.57838 6.78016 6.7201L1.64017 11.8501C1.54628 11.9448 1.41848 11.998 1.28516 11.998C1.15185 11.998 1.02405 11.9448 0.930165 11.8501L0.220165 11.1401C0.126101 11.0479 0.0730934 10.9218 0.0730934 10.7901C0.0730934 10.6584 0.126101 10.5323 0.220165 10.4401L4.67017 6.0001L0.220165 1.5601C0.125509 1.46621 0.0722656 1.33842 0.0722656 1.2051C0.0722656 1.07178 0.125509 0.94398 0.220165 0.850096L0.930165 0.150096C1.02405 0.0554401 1.15185 0.00219727 1.28516 0.00219727C1.41848 0.00219727 1.54628 0.0554401 1.64017 0.150096L6.78016 5.2801Z">
                                                        </path>
                                                    </svg></button></div>
                                            <div class="pjq8xm0j">
                                                <div class="twAYSZt2">
                                                    <div class="xPhOeJTI"><svg class="f0hiXs2f zsm934mk" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-label="Icon Star Outlined"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M2.20143 9.85425C2.03248 9.73123 1.96025 9.51452 2.02161 9.31473L2.10153 9.06496C2.15996 8.86756 2.33563 8.72781 2.5411 8.71527L8.92493 8.20573L11.3726 2.32101C11.4547 2.11485 11.6607 1.98554 11.8821 2.00129H12.1418C12.3505 1.99687 12.539 2.12523 12.6114 2.32101L15.069 8.20573L21.4528 8.71527C21.6583 8.72781 21.8339 8.86756 21.8924 9.06496L21.9723 9.31473C22.0403 9.50821 21.9805 9.72355 21.8224 9.85425L17.0071 13.9905L18.4857 20.195C18.5344 20.3936 18.4596 20.6021 18.2959 20.7245L18.0061 20.8843C17.8371 20.9986 17.6157 20.9986 17.4467 20.8843L12.0119 17.5873L6.54723 20.9143C6.37823 21.0286 6.15676 21.0286 5.98777 20.9143L5.76798 20.7645C5.60419 20.642 5.52945 20.4335 5.57816 20.2349L7.01677 13.9905L2.20143 9.85425Z" fill="#505050"></path>
                                                            </svg></svg>Trending:</div>
                                                    <ul class="AGuHURAT">
                                                        <li class="PNW7Som0"><a class="m58ZY2dp" href="/graphic-templates/graphic+design+portfolio+template"><img class="OyjilzK5" src="https://elements-cover-images.imgix.net/825854d1-a2d1-4a95-9794-54cf845e5e6e?crop=top&amp;fit=crop&amp;fm=jpeg&amp;h=40&amp;q=80&amp;w=60&amp;s=30e0682819f521fce3be8e8065b487fb" alt="graphic design portfolio template"><span class="K2M1i3S_">graphic design portfolio
                                                                    template</span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="twAYSZt2">
                                                    <div class="xPhOeJTI"><svg class="f0hiXs2f zsm934mk" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-label="Icon Heart"><svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                                <title>heart</title>
                                                                <path d="M22,8.5A5.5,5.5,0,0,0,16.5,3,6.36,6.36,0,0,0,12,5.07,6.36,6.36,0,0,0,7.5,3,5.5,5.5,0,0,0,2,8.5C2,12.42,6.75,16.75,9,19l2.28,2.28a.75.75,0,0,0,.53.22h.38a.75.75,0,0,0,.53-.22L15,19C17.25,16.75,22,12.42,22,8.5Z" fill="#505050"></path>
                                                            </svg></svg>Popular:</div>
                                                    <ul class="AGuHURAT">
                                                        <li class="PNW7Som0"><a class="m58ZY2dp" href="/graphic-templates/business+card"><img class="OyjilzK5" src="https://elements-cover-images.imgix.net/3b258d23-5126-4674-ac84-596955eb9ed5?crop=top&amp;fit=crop&amp;fm=jpeg&amp;h=40&amp;q=80&amp;w=60&amp;s=2e4af5429db79720235ecff96bf4117c" alt="business card"><span class="K2M1i3S_">business card</span></a></li>
                                                        <li class="PNW7Som0"><a class="m58ZY2dp" href="/graphic-templates/logo"><img class="OyjilzK5" src="https://elements-cover-images.imgix.net/79f53511-6014-4e4d-a7a4-02711036ecc9?crop=top&amp;fit=crop&amp;fm=jpeg&amp;h=40&amp;q=80&amp;w=60&amp;s=cc0013b4106748b7811d9e9691d7388e" alt="logo"><span class="K2M1i3S_">logo</span></a></li>
                                                        <li class="PNW7Som0"><a class="m58ZY2dp" href="/graphic-templates/flyer"><img class="OyjilzK5" src="https://elements-cover-images.imgix.net/f7eb16f4-e5bc-4412-ac6d-cd8bb25da55d?crop=top&amp;fit=crop&amp;fm=jpeg&amp;h=40&amp;q=80&amp;w=60&amp;s=27f1a55294b408e9be24dbf9f0344e2f" alt="flyer"><span class="K2M1i3S_">flyer</span></a></li>
                                                        <li class="PNW7Som0"><a class="m58ZY2dp" href="/graphic-templates/brochure"><img class="OyjilzK5" src="https://elements-cover-images.imgix.net/934a1407-170c-41a1-a307-9a0325f68f79?crop=top&amp;fit=crop&amp;fm=jpeg&amp;h=40&amp;q=80&amp;w=60&amp;s=fb298a91ecff091bff5a1d6a5195dc6d" alt="brochure"><span class="K2M1i3S_">brochure</span></a></li>
                                                        <li class="PNW7Som0"><a class="m58ZY2dp" href="/graphic-templates/logo+mockup"><img class="OyjilzK5" src="https://elements-cover-images.imgix.net/e32d3ae4-4c81-4603-a4c7-4b351072b13b?crop=top&amp;fit=crop&amp;fm=jpeg&amp;h=40&amp;q=80&amp;w=60&amp;s=3e46e03a37ac91ed6d272fbdc4ce1ba1" alt="logo mockup"><span class="K2M1i3S_">logo
                                                                    mockup</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="SrnSv3qf">
                                    <div>
                                        <div class="LNTJGgij"></div>
                                    </div>
                                    <div class="WxjErMSd">
                                        <div class="yByqVOIe"><select class="eLC5tHwk">
                                                <option value="popular" aria-label="Popular">Sort by Popular
                                                </option>
                                                <option value="latest" aria-label="New">New</option>
                                            </select><svg class="f0hiXs2f WEqlS_5G" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 16" role="img" aria-label="Arrow down">
                                                <path d="M24,1.9c0,0.4-0.1,0.8-0.4,1L13.2,15.2c-0.3,0.4-0.8,0.6-1.2,0.6s-0.9-0.2-1.2-0.6L0.4,2.9c-0.6-0.8-0.5-1.8,0.2-2.4 c0.4-0.3,0.7-0.4,1.1-0.4s0.9,0.2,1.1,0.6L12,11.5l9.1-10.7c0.3-0.3,0.7-0.6,1.1-0.6s0.9,0.1,1.2,0.4C23.8,1,24,1.4,24,1.9z">
                                                </path>
                                            </svg></div>
                                    </div>
                                </div> --}}
                                <div class="">
                                    <div class="search-grid-container">
                                        @foreach($templates as $template)
                                        <a href="{{ route( 'template.productDetail', [ 'country' => $country, 'slug' => $template->slug, 'coupon' => $coupon ] ) }}">
                                            <figure>
                                                <img alt="{{ $template->title }}" crossorigin="anonymous" loading="lazy" data-categ="invitations" data-value="{{ $template->_id }}" src="{{ str_replace('_carousel','_product_preview',$template->preview_image) }}" class="itemImg">
                                                <figcaption>
                                                    <a href="{{ route( 'template.productDetail', [ 'country' => $country, 'slug' => $template->slug ] ) }}">
                                                        <div class="dMnq_Lr8">
                                                            <span>
                                                                {{ $template->title }}
                                                            </span>
                                                        </div>
                                                    </a>
                                                    <div class="_n0J0gGK">
                                                        <div class="d6YhEXPR">
                                                            <div class="utcowRMZ">
                                                                <a href="{{ route( 'template.productDetail', [ 'country' => $country, 'slug' => $template->slug ] ) }}">
                                                                    By
                                                                </a>
                                                                <a href="{{ route( 'template.productDetail', [ 'country' => $country, 'slug' => $template->slug ] ) }}">
                                                                    {{ $template->studioName }}
                                                                </a>
                                                            </div>
                                                            <div class="n-listing-card__price  wt-display-block wt-text-title-01 lc-price">
                                                            <p class="wt-text-title-01 lc-price ">
                                                                    <span class="wt-screen-reader-only">
                                                                        Sale Price MX$
                                                                        @if($sale != null )
                                                                            {{ $template->prices['price'] }}
                                                                        @else
                                                                            {{ $template->prices['original_price'] }}
                                                                        @endif
                                                                    </span>
                                                                    <span aria-hidden="true">
                                                                        <span class="currency-symbol">MX$</span>
                                                                        <span class="currency-value">
                                                                            @if($sale != null )
                                                                                {{ $template->prices['price'] }}
                                                                            @else
                                                                                {{ $template->prices['original_price'] }}
                                                                            @endif
                                                                        </span>
                                                                    </span>
                                                                </p>
                                                                @if($sale != null )
                                                                <p class="wt-text-caption search-collage-promotion-price wt-text-slime wt-text-truncate wt-no-wrap">
                                                                    <span class="wt-text-strikethrough " aria-hidden="true">
                                                                        <span class="currency-symbol">MX$</span>
                                                                        <span class="currency-value">{{ $template->prices['original_price'] }}</span>
                                                                    </span>
                                                                    <span class="wt-screen-reader-only">
                                                                        Original Price MX${{ $template->prices['original_price'] }}
                                                                    </span>
                                                                    <span>
                                                                        ({{ $template->prices['discount_percent'] }}% off)
                                                                    </span>
                                                                </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{-- <div class="EnawCRza wnbOpC0l">
                                                            <div class="iA5PAkih HbV3rXzN fZgJpwQj" role="tooltip" tabindex="0">
                                                                <a href="{{ route( 'template.productDetail', [ 'country' => $country, 'slug' => $template->slug ] ) }}" class="ROjO8oOw" data-test-selector="collection-popup-button" type="button">
                                                                    <div class="hxFZwp8w">
                                                                        <img src="https://img.icons8.com/ios/300/search-more.png"
                                                                            class="fMdfaJgH" alt="Explore more like this">
                                                                    </div>
                                                                </a>
                                                                <span class="Y8B0rMYR LBIWVYxj SgR6kXef">
                                                                    Explore more like this</span>
                                                            </div>
                                                        </div> --}}
                                                        <div class="iA5PAkih MnYus99x MHpx2FCM HbV3rXzN" role="tooltip" tabindex="0">
                                                            <a href="{{ route( 'template.productDetail', [ 'country' => $country, 'slug' => $template->slug ] ) }}" data-test-selector="item-card-download-button" class="Y2SkMErw" type="button">
                                                                <img src="https://img.icons8.com/material-outlined/300/shopping-cart--v1.png"
                                                                        class="RN7zpzqN" alt="View Details">
                                                            </a>
                                                            <span class="Y8B0rMYR LBIWVYxj">View Details</span>
                                                        </div>
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </a>
                                        @endforeach
                                    </div>
                                    <div class="hZFJ5g_b" data-test-selector="pagination">
                                        @if( $current_page > 1  )
                                            <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ $current_url }}?page=1">
                                                <span class="lplK5odP LQ9zKnGb tUz8vpIk vHgjkrLA">
                                                    <svg class="f0hiXs2f" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 24" role="img" aria-label="Arrow left">
                                                        <path d="M14 24c-.2 0-.5-.1-.6-.2l-13-11c-.3-.2-.4-.5-.4-.8 0-.3.1-.6.4-.8l13-11c.4-.4 1.1-.3 1.4.1.4.4.3 1.1-.1 1.4L2.5 12l12.1 10.2c.4.4.5 1 .1 1.4-.1.3-.4.4-.7.4z">
                                                        </path>
                                                        <path d="M26 24c-.2 0-.5-.1-.6-.2l-13-11c-.3-.2-.4-.5-.4-.8 0-.3.1-.6.4-.8l13-11c.4-.4 1.1-.3 1.4.1.4.4.3 1.1-.1 1.4L14.5 12l12.1 10.2c.4.4.5 1 .1 1.4-.1.3-.4.4-.7.4z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </a>
                                        @endif
                                        @if( ($current_page-1) > 0  )
                                            <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ $current_url . "?page=" . ($current_page-1) }}">
                                                <span class="LQ9zKnGb tUz8vpIk vHgjkrLA">
                                                    <svg class="f0hiXs2f" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 24" role="img" aria-label="Arrow left">
                                                        <path d="M14 24c-.2 0-.5-.1-.6-.2l-13-11c-.3-.2-.4-.5-.4-.8 0-.3.1-.6.4-.8l13-11c.4-.4 1.1-.3 1.4.1.4.4.3 1.1-.1 1.4L2.5 12l12.1 10.2c.4.4.5 1 .1 1.4-.1.3-.4.4-.7.4z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </a>
                                        @endif
                                        
                                        @for($i = $pagination_begin; $i <= $pagination_end; $i++)
                                            <div class="cpiMRmby">
                                                <span class="SLi2_6Jp">
                                                    @if( $current_page == $i )
                                                        <span data-test-selector="pagination-link-page-1-disabled" class="LQ9zKnGb zWRu8yhu tUz8vpIk">{{ $i }}</span>
                                                    @else
                                                        <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ $current_url . "?page=" . $i }}">
                                                            {{ $i }}
                                                        </a>
                                                    @endif
                                                </span>
                                            </div>
                                        @endfor
                                        @if( ($current_page+1) <= $last_page  )
                                            <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ route( 'user.search', [ 'country' => $country, 'page' => $current_page+1, 'searchQuery' => $search_query ] ) }}">
                                                <svg class="f0hiXs2f" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 24" role="img" aria-label="Arrow right">
                                                    <path d="M1 24c-.3 0-.6-.1-.8-.4-.4-.4-.3-1.1.1-1.4L12.5 12 .4 1.8C0 1.4-.1.8.3.4c.4-.4 1-.5 1.4-.1l13 11c.2.2.4.5.4.8 0 .3-.1.6-.4.8l-13 11c-.2 0-.5.1-.7.1z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    {{--
                    <div class="AA1EE83D">
                        <div class="jBXcSG6t">
                            <h3 class="SNcU6rNK">Featured Graphic Templates</h3>
                        </div>
                    </div>
                    --}}
                </div>
            </main>
            {{--
            <div class="yducsd44">
                <nav class="aeEIJ0Oi"><a class="vs3__w6e" href="/"><svg class="f0hiXs2f KlMn5auq" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 18" role="img" aria-label="Icon Home">
                            <path d="M18.5556 9.24V17C18.5556 17.5523 18.1067 18 17.5529 18H13.5422C12.9885 18 12.5396 17.5523 12.5396 17V11.5C12.5396 11.2239 12.3151 11 12.0382 11H7.0249C6.74802 11 6.52357 11.2239 6.52357 11.5V17C6.52357 17.5523 6.07466 18 5.5209 18H1.51024C0.956478 18 0.507568 17.5523 0.507568 17V9.24C0.50827 8.44462 0.825644 7.68207 1.38992 7.12L8.23813 0.29C8.42489 0.105256 8.67696 0.00110462 8.93999 0H10.1231C10.3862 0.00110462 10.6383 0.105256 10.825 0.29L17.6732 7.12C18.2375 7.68207 18.5549 8.44462 18.5556 9.24Z">
                            </path>
                        </svg><span>Home</span></a><a class="vs3__w6e yNxzCqtd" href="/all-items"><svg class="f0hiXs2f KlMn5auq" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 14" role="img" aria-label="Icon Panorama">
                            <path d="M6.5 1.68762V12.2924C6.50974 12.7745 6.17312 13.1946 5.7 13.291L5.43 13.3509L2.93 13.9001C2.645 13.9678 2.35294 14.0013 2.06 14H1.5C0.947715 14 0.5 13.5529 0.5 13.0014V0.998605C0.5 0.447111 0.947715 3.73468e-05 1.5 3.73468e-05H2.06C2.35294 -0.00127969 2.645 0.032242 2.93 0.0998942L5.43 0.649107L5.7 0.709021C6.16567 0.803938 6.5001 1.21303 6.5 1.68762ZM21.5 3.73468e-05H20.94C20.6471 -0.00127969 20.355 0.032242 20.07 0.0998942L17.57 0.649107L17.3 0.709021C16.8269 0.805356 16.4903 1.22552 16.5 1.70759V12.2924C16.4903 12.7745 16.8269 13.1946 17.3 13.291L17.58 13.3509L20.07 13.9001C20.355 13.9678 20.6471 14.0013 20.94 14H21.5C22.0523 14 22.5 13.5529 22.5 13.0014V0.998605C22.5 0.447111 22.0523 3.73468e-05 21.5 3.73468e-05ZM13.43 1.24825C12.79 1.24825 12.14 1.31815 11.5 1.31815C10.86 1.31815 10.21 1.31815 9.57 1.24825C9.29338 1.23044 9.02177 1.32808 8.82 1.51786C8.61678 1.70606 8.50089 1.97005 8.5 2.24682V11.7332C8.50089 12.01 8.61678 12.274 8.82 12.4622C9.02177 12.652 9.29338 12.7496 9.57 12.7318C10.21 12.7318 10.86 12.6619 11.5 12.6619C12.14 12.6619 12.79 12.6619 13.43 12.7318C13.7066 12.7496 13.9782 12.652 14.18 12.4622C14.3832 12.274 14.4991 12.01 14.5 11.7332V2.24682C14.4991 1.97005 14.3832 1.70606 14.18 1.51786C13.9782 1.32808 13.7066 1.23044 13.43 1.24825Z">
                            </path>
                        </svg><span>Categories</span></a><button class="vs3__w6e" type="button"><svg class="f0hiXs2f KlMn5auq" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21" role="img" aria-label="Icon Bookmarks">
                            <path d="M16.5 19C16.5007 19.3639 16.3037 19.6994 15.9856 19.8762C15.6676 20.0529 15.2786 20.0429 14.97 19.85L9.03 16.13C8.70573 15.9273 8.29427 15.9273 7.97 16.13L2.03 19.85C1.72143 20.0429 1.33245 20.0529 1.01436 19.8762C0.696265 19.6994 0.499273 19.3639 0.500002 19V2C0.500002 0.89543 1.39543 0 2.5 0H14.5C15.6046 0 16.5 0.89543 16.5 2V19ZM19.5 2H18.5V18H19.5C20.0523 18 20.5 17.5523 20.5 17V3C20.5 2.44772 20.0523 2 19.5 2Z">
                            </path>
                        </svg><span>My Collections</span></button><a class="vs3__w6e" href="/sign-in"><svg class="f0hiXs2f KlMn5auq" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 20" role="img" aria-label="Icon Account">
                            <path d="M10.5 0C4.97715 0 0.5 4.47715 0.5 10C0.5 15.5228 4.97715 20 10.5 20C16.0228 20 20.5 15.5228 20.5 10C20.5 7.34784 19.4464 4.8043 17.5711 2.92893C15.6957 1.05357 13.1522 0 10.5 0ZM10.5 3C12.1569 3 13.5 4.34315 13.5 6C13.5 7.65685 12.1569 9 10.5 9C8.84315 9 7.5 7.65685 7.5 6C7.5 4.34315 8.84315 3 10.5 3ZM16.12 14.16C14.7994 15.9384 12.7151 16.9868 10.5 16.9868C8.28493 16.9868 6.20056 15.9384 4.88 14.16C4.67921 13.8633 4.65251 13.4818 4.81 13.16L5.02 12.72C5.51488 11.671 6.57012 11.0012 7.73 11H13.27C14.4136 11.0015 15.4568 11.6531 15.96 12.68L16.19 13.15C16.3514 13.4745 16.3246 13.8609 16.12 14.16Z">
                            </path>
                        </svg><span>Sign in</span></a></nav>
            </div>
            --}}
        </div>
    </div>

</main>
@endsection