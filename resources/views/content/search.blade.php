@extends('layouts.frontend')

@section('title', 'Results for: "'.$search_query.'" | Online Template Editor | Wayak')

@section('meta')
<meta data-rh="true" charset="UTF-8">
<meta data-rh="true" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
@endsection
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/home.css') }}" media="all" preload>
<link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">
@endsection

@section('content')
<div data-test-selector="page-items-id-graphic-templates-slug-graphic-templates">
    <section>
        @if( sizeof($templates) == 0 )
            <h3>No results found. Try broadening your search or changing categories.</h3>
        @endif
    </section>
    <section class="brjUfGeW CTPdOQUg">
        <div class="M9td4zg0">
            <div class="i94YxDkb">
                <div class="r7v1tCEj e5eD2gJO">
                    <div class="XYCsUlYA">
                        <div><button class="v4WgTyT_ T4lpbmGC" data-test-selector="filters-toggle" type="button"><span class="TMHd9Lax">Filters</span>
                                <div class="KyAyUQmZ">
                                    <h2 class="VlpOYM00">
                                        <svg class="f0hiXs2f gekjrsF9" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" role="img" aria-label="">
                                            <path d="M16 13a2.67 2.67 0 00-5.16-.59H.45a.45.45 0 00-.44.45v.89a.44.44 0 00.44.44h10.37A2.66 2.66 0 0016 13zm-2.65 1.19a.89.89 0 11.89-.89.89.89 0 01-.91.92zm2.22-7.11H10.5a2.66 2.66 0 00-5 0h-5a.45.45 0 00-.5.48v.88a.45.45 0 00.44.45H5.5a2.66 2.66 0 005 0h5.05a.45.45 0 00.45-.45v-.88a.45.45 0 00-.45-.45zM8 8.89A.89.89 0 118.89 8a.89.89 0 01-.89.89zm7.55-7.11H5.18a2.67 2.67 0 10-3 3.52 2.69 2.69 0 003-1.74h10.37a.45.45 0 00.45-.45v-.89a.44.44 0 00-.45-.44zM2.67 3.56a.89.89 0 11.89-.89.89.89 0 01-.89.89z">
                                            </path>
                                        </svg>
                                        <span class="DtykxMwy">Filters</span>
                                    </h2>
                                    <svg class="f0hiXs2f ypactJsB" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 16" role="img" aria-label="Arrow down">
                                        <path d="M24,1.9c0,0.4-0.1,0.8-0.4,1L13.2,15.2c-0.3,0.4-0.8,0.6-1.2,0.6s-0.9-0.2-1.2-0.6L0.4,2.9c-0.6-0.8-0.5-1.8,0.2-2.4 c0.4-0.3,0.7-0.4,1.1-0.4s0.9,0.2,1.1,0.6L12,11.5l9.1-10.7c0.3-0.3,0.7-0.6,1.1-0.6s0.9,0.1,1.2,0.4C23.8,1,24,1.4,24,1.9z">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                            <div class="c88IgiwA">
                                <div class="PLuX7k7n">
                                    <div class="fapNh0Iu" role="navigation" aria-label="Refinements">
                                        <div class="ebyGwQyL">
                                            <div class="fhssKYaK">Refine by</div><a aria-label="Reset refine by" class="ZI9838HJ" href="/graphic-templates">Clear</a>
                                        </div>
                                        <ul class="Rrx7jwxJ">
                                            <li class="Q2H_DJ8K">
                                                <div class="ib54zM_m" data-test-selector="categories">
                                                    Event Type
                                                </div>
                                                @foreach($filterData['category_totals'] as $category)
                                                <div class="Rvuu9xD7">
                                                    <div class="GPDfT3WP">
                                                        <a class="IAr4Hv03" href="/graphic-templates">
                                                            <div class="oIUzvJFF" data-test-selector="print-templates-category-checkbox">
                                                                <svg class="f0hiXs2f Vozs7WCS" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6.8 5.2" role="img" aria-label="Tick">
                                                                    <path d="M6.7.8L2.9 5c-.1.1-.3.2-.4.2-.1 0-.3-.1-.4-.2l-2-2c-.1-.2-.1-.5 0-.7s.5-.2.7 0L2.5 4 6 .2c.2-.2.5-.2.7 0 .2.1.2.4 0 .6z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <div class="jyCy5IJL">
                                                                {{ $category{'_id'} }}
                                                            </div>
                                                        </a>
                                                        <div class="ms_KgHmN">
                                                            <span class="N7_NKKFl">
                                                                {{ $category{'count'} }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </li>
                                            <li class="Q2H_DJ8K">
                                                <div class="ib54zM_m" data-test-selector="colorSpace">
                                                    Style
                                                </div>
                                                @foreach($filterData['top_keywords'] as $filterKeyword)
                                                <div class="Rvuu9xD7">
                                                    <div class="GPDfT3WP"><a class="IAr4Hv03" rel="nofollow" href="/graphic-templates/print-templates/color-space-rgb">
                                                            <div class="oIUzvJFF" data-test-selector="rgb-category-checkbox">
                                                            </div>
                                                            <div class="jyCy5IJL">{{ $filterKeyword->_id }}</div>
                                                        </a>
                                                        <div class="ms_KgHmN"><span class="N7_NKKFl">{{ $filterKeyword->count }}</span></div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </li>
                                            <li class="Q2H_DJ8K">
                                                <div class="ib54zM_m" data-test-selector="orientation">
                                                    Color Scheme
                                                </div>
                                                <div class="Rvuu9xD7">
                                                    <div class="GPDfT3WP"><a class="IAr4Hv03" rel="nofollow" href="/graphic-templates/print-templates/orientation-landscape">
                                                            <div class="oIUzvJFF" data-test-selector="landscape-category-checkbox">
                                                            </div>
                                                            <div class="jyCy5IJL">
                                                                Based on the "format" field
                                                            </div>
                                                        </a>
                                                        <div class="ms_KgHmN"><span class="N7_NKKFl">17,623</span></div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="Q2H_DJ8K">
                                                <div class="ib54zM_m" data-test-selector="orientation">
                                                    Size
                                                </div>
                                                <div class="Rvuu9xD7">
                                                    <div class="GPDfT3WP"><a class="IAr4Hv03" rel="nofollow" href="/graphic-templates/print-templates/orientation-landscape">
                                                            <div class="oIUzvJFF" data-test-selector="landscape-category-checkbox">
                                                            </div>
                                                            <div class="jyCy5IJL">
                                                                Using "width" and "height" fields
                                                                Standard sizes like 5x7, 4x6, etc.
                                                            </div>
                                                        </a>
                                                        <div class="ms_KgHmN"><span class="N7_NKKFl">17,623</span></div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="Q2H_DJ8K">
                                                <div class="ib54zM_m" data-test-selector="graphicTemplatesApplicationsSupported">
                                                    Price Range
                                                </div>
                                                <div class="Rvuu9xD7">
                                                    <div class="slidecontainer">
                                                        <input type="range" min="{{ $filterData['price_range'][0]['minPrice'] }}" max="{{ $filterData['price_range'][0]['maxPrice'] }}" value="{{ $filterData['price_range'][0]['minPrice'] }}" class="priceSlider" id="myRange">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="Q2H_DJ8K">
                                                <div class="ib54zM_m" data-test-selector="properties">Exclusivity
                                                </div>
                                                <div class="Rvuu9xD7">
                                                    <div class="GPDfT3WP">
                                                        <a class="IAr4Hv03" rel="nofollow" href="/graphic-templates/print-templates/properties-vector">
                                                            <div class="oIUzvJFF" data-test-selector="isvector-category-checkbox">
                                                            </div>
                                                            <div class="jyCy5IJL">All Templates</div>
                                                        </a>
                                                        <div class="ms_KgHmN"><span class="N7_NKKFl">58,942</span></div>
                                                    </div>
                                                    <div class="GPDfT3WP">
                                                        <a class="IAr4Hv03" rel="nofollow" href="/graphic-templates/print-templates/properties-vector">
                                                            <div class="oIUzvJFF" data-test-selector="isvector-category-checkbox">
                                                            </div>
                                                            <div class="jyCy5IJL">Subscriber-Only</div>
                                                        </a>
                                                        <div class="ms_KgHmN"><span class="N7_NKKFl">58,942</span></div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="Q2H_DJ8K">
                                                <div class="ib54zM_m" data-test-selector="properties">
                                                    Orientation:
                                                </div>
                                                <div class="Rvuu9xD7">
                                                    <div class="GPDfT3WP">
                                                        <a class="IAr4Hv03" rel="nofollow" href="/graphic-templates/print-templates/properties-vector">
                                                            <div class="oIUzvJFF" data-test-selector="isvector-category-checkbox">
                                                            </div>
                                                            <div class="jyCy5IJL">
                                                                Derived from "width" and "height" ratios
                                                                Portrait
                                                            </div>
                                                        </a>
                                                        <div class="ms_KgHmN"><span class="N7_NKKFl">58,942</span></div>
                                                    </div>
                                                    <div class="GPDfT3WP">
                                                        <a class="IAr4Hv03" rel="nofollow" href="/graphic-templates/print-templates/properties-vector">
                                                            <div class="oIUzvJFF" data-test-selector="isvector-category-checkbox">
                                                            </div>
                                                            <div class="jyCy5IJL">
                                                                Landscape
                                                            </div>
                                                        </a>
                                                        <div class="ms_KgHmN"><span class="N7_NKKFl">58,942</span></div>
                                                    </div>
                                                    <div class="GPDfT3WP">
                                                        <a class="IAr4Hv03" rel="nofollow" href="/graphic-templates/print-templates/properties-vector">
                                                            <div class="oIUzvJFF" data-test-selector="isvector-category-checkbox">
                                                            </div>
                                                            <div class="jyCy5IJL">
                                                                Square
                                                            </div>
                                                        </a>
                                                        <div class="ms_KgHmN"><span class="N7_NKKFl">58,942</span></div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- New Arrivals:
                                                Using "created_at" field
                                                Example: Added in the last 30 days


                                            Special Offers:
                                                Based on "in_sale" and "prices.discount_percent" fields
                                                Options: On Sale, Discounted Items


                                            Theme:
                                                Derived from "keywords" and "title"
                                                Examples: Floral, Geometric, Vintage, etc. -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="QLzW0Tal">
                <div class="Ocm_Mx1a">
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
                </div>
                <div class="">
                    <div class="search-grid-container">
                        @foreach($templates as $template)
                        <a href="{{ route( 'template.productDetail', [ 'country' => $country, 'slug' => $template->slug ] ) }}">
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
        <div class="hZFJ5g_b" data-test-selector="pagination"><span class="lplK5odP LQ9zKnGb tUz8vpIk vHgjkrLA"><svg class="f0hiXs2f" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 24" role="img" aria-label="Arrow left">
                    <path d="M14 24c-.2 0-.5-.1-.6-.2l-13-11c-.3-.2-.4-.5-.4-.8 0-.3.1-.6.4-.8l13-11c.4-.4 1.1-.3 1.4.1.4.4.3 1.1-.1 1.4L2.5 12l12.1 10.2c.4.4.5 1 .1 1.4-.1.3-.4.4-.7.4z">
                    </path>
                    <path d="M26 24c-.2 0-.5-.1-.6-.2l-13-11c-.3-.2-.4-.5-.4-.8 0-.3.1-.6.4-.8l13-11c.4-.4 1.1-.3 1.4.1.4.4.3 1.1-.1 1.4L14.5 12l12.1 10.2c.4.4.5 1 .1 1.4-.1.3-.4.4-.7.4z">
                    </path>
                </svg></span><span class="LQ9zKnGb tUz8vpIk vHgjkrLA"><svg class="f0hiXs2f" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 24" role="img" aria-label="Arrow left">
                    <path d="M14 24c-.2 0-.5-.1-.6-.2l-13-11c-.3-.2-.4-.5-.4-.8 0-.3.1-.6.4-.8l13-11c.4-.4 1.1-.3 1.4.1.4.4.3 1.1-.1 1.4L2.5 12l12.1 10.2c.4.4.5 1 .1 1.4-.1.3-.4.4-.7.4z">
                    </path>
                </svg></span>
            <div class="cpiMRmby"><span class="SLi2_6Jp"><span data-test-selector="pagination-link-page-1-disabled" class="LQ9zKnGb zWRu8yhu tUz8vpIk">1</span><a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="/graphic-templates/print-templates/pg-2">2</a><a class="LQ9zKnGb" data-test-selector="pagination-link-page-3" rel="nofollow" href="/graphic-templates/print-templates/pg-3">3</a><a class="LQ9zKnGb" data-test-selector="pagination-link-page-4" rel="nofollow" href="/graphic-templates/print-templates/pg-4">4</a><a class="LQ9zKnGb" data-test-selector="pagination-link-page-5" rel="nofollow" href="/graphic-templates/print-templates/pg-5">5</a></span>
            </div><a class="LQ9zKnGb vHgjkrLA" rel="nofollow" href="/graphic-templates/print-templates/pg-2"><svg class="f0hiXs2f" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 24" role="img" aria-label="Arrow right">
                    <path d="M1 24c-.3 0-.6-.1-.8-.4-.4-.4-.3-1.1.1-1.4L12.5 12 .4 1.8C0 1.4-.1.8.3.4c.4-.4 1-.5 1.4-.1l13 11c.2.2.4.5.4.8 0 .3-.1.6-.4.8l-13 11c-.2 0-.5.1-.7.1z">
                    </path>
                </svg></a>
        </div>
</div>
</div>
</div>
</section>
</div>
@endsection