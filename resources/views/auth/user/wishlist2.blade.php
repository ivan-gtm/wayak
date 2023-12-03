@extends('layouts.frontend')

@section('meta')
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/search.css') }}" media="all">
@endsection

@section('content')
<main class="content">
    <div id="app" class="appReady">
        <div class="Pwa91aRM">
            <main class="nEpAyrlb">
                <header class="SJ5W7Cap">
                    <div class="ufwFRNuO">
                        <div class="iiyeEkHc">
                            @if(!Auth::guest())
                                <div class="qJyzQBny">
                                    <ul class="T5vuSnA9" role="navigation" aria-label="Breadcrumbs" data-test-selector="breadcrumbs-list">
                                        <li class="M5DAz63W" data-test-selector="breadcrumbs-list-item">
                                            <a class="TDnT_QDN" href="{{ url('/'.$country.'/profile') }}">User</a>
                                        </li>
                                        <li class="M5DAz63W" data-test-selector="breadcrumbs-list-item">
                                            <a class="TDnT_QDN" href="{{ url('/'.$country.'/user/favorites') }}">Favorite items</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            @endif
                            <div class="hILQ5O1m">
                                <h1 class="r9m1sI3F">Favorite items</h1>
                                @if(Auth::guest())
                                <aside class="kb2fhv7t">
                                    <h2 class="gxUHa9Js">
                                        <span class="mIDWdUGM" data-test-selector="top-article-visible">
                                            Don't lose your faves! <a href="{{ url('/login') }}"><button>Sign in</button></a> or create an account.
                                            Guest favorites are only saved to your device for 7 days, or until you clear your cache. <a href="{{ url('/login') }}"><button>Sign in</button></a> or create an account to hang on to your picks.
                                        </span><br>
                                    </h2>
                                </aside>
                                @endif
                            </div>
                        </div>
                    </div>
                </header>
                <div data-test-selector="page-items-id-graphic-templates-slug-graphic-templates">
                    <section class="brjUfGeW CTPdOQUg">
                        <div class="M9td4zg0">
                            <div class="QLzW0Tal">
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
        </div>
    </div>

</main>
@endsection