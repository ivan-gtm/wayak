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
<main class="content">
    <div id="app" class="appReady">
        <div class="Pwa91aRM">
            <main class="nEpAyrlb">
                <section class="brjUfGeW CTPdOQUg">
                    <div class="M9td4zg0">
                        <div class="QLzW0Tal">
                            @if( sizeof($templates) == 0 )
                                <h3>No results found. Try broadening your search or changing categories.</h3>
                            @endif
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
                                <div class="hZFJ5g_b">
                                    @if( $current_page > 1  )
                                        <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ route( 'user.search', [ 'country' => $country, 'page' => 1, 'sale' => 1, 'sort' => 'popular' ] ) }}">
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
                                        <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ route( 'user.search', [ 'country' => $country, 'page' => $current_page-1, 'sale' => 1, 'sort' => 'popular' ] ) }}">
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
                                                    <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ route( 'user.search', [ 'country' => $country, 'page' => $i, 'sale' => 1, 'sort' => 'popular', 'searchQuery' => $search_query ] ) }}">
                                                        {{ $i }}
                                                    </a>
                                                @endif
                                            </span>
                                        </div>
                                    @endfor
                                    @if( ($current_page+1) <= $last_page  )
                                        <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ route( 'user.search', [ 'country' => $country, 'page' => $current_page+1, 'sale' => 1, 'sort' => 'popular', 'searchQuery' => $search_query ] ) }}">
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
            </main>
        </div>
    </div>
</main>
@endsection