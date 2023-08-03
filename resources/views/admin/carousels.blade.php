@extends('layouts.admin')

@section('title', 'Results for: "'.$search_query.'" | Online Template Editor | Wayak')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">

<meta data-rh="true" charset="UTF-8">
<meta data-rh="true" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    
{{--
        <meta data-rh="true" name="google-site-verification" content="">
        <meta data-rh="true" name="apple-itunes-app" content="">
        <meta data-rh="true" name="google" content="no-translate">
--}}

@endsection

@section('content')
<div class="col-12">
        <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('admin.carousels',['country' => $country]) }}">
            @csrf
            <div class="sc-dmlrTW guKkvw">
                <input type="text" autocomplete="off" name="searchQuery" class="sc-kfzAmx sc-fKFyDc fTLfYv zomHz proxima-regular___3FDdY" placeholder="{{ __('home.search_placeholder') }}" value="" style="padding-left: 20px;" autofocus>
            </div>
            <div class="inputControls___BVQJr left___1UDlV"></div>
            <div class="inputControls___BVQJr right___3zI72">
                <button type="submit" class="sc-gsTCUz bhdLno sc-dlfnbm llxIqU searchBtn___3JEWS" data-categ="homeSearchForm" data-value="submit">
                    <svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4138 15.8368L21.8574 20.2857C22.0558 20.5064 22.046 20.8443 21.8352 21.0532L21.0575 21.8317C20.9532 21.937 20.8113 21.9962 20.6632 21.9962C20.5151 21.9962 20.3731 21.937 20.2688 21.8317L15.8252 17.3828C15.7023 17.2596 15.5907 17.1256 15.4919 16.9824L14.6587 15.8701C13.2802 16.9723 11.5682 17.5724 9.80409 17.5719C6.16878 17.5845 3.00983 15.0738 2.19744 11.5261C1.38504 7.97844 3.13601 4.34066 6.41372 2.76643C9.69143 1.1922 13.6211 2.10166 15.8763 4.95639C18.1314 7.81111 18.1102 11.8492 15.8252 14.68L16.9361 15.4475C17.1096 15.5586 17.2698 15.6892 17.4138 15.8368ZM4.24951 9.78627C4.24951 12.8576 6.73635 15.3475 9.80402 15.3475C11.2772 15.3475 12.69 14.7616 13.7317 13.7186C14.7733 12.6757 15.3585 11.2612 15.3585 9.78627C15.3585 6.7149 12.8717 4.22507 9.80402 4.22507C6.73635 4.22507 4.24951 6.7149 4.24951 9.78627Z"></path>
                    </svg>
                </button>
            </div>
        </form>
</div>
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
                                <div class="grid-container">
                                    @foreach($templates as $template)
                                    <a onclick="addTemplate(this)" id="template{{ $template->_id }}" data-template-id="{{ $template->_id }}">
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
                <!-- <div class="AA1EE83D">
                    <div class="jBXcSG6t">
                        <h3 class="SNcU6rNK">Featured Graphic Templates</h3>
                    </div>
                </div> -->
            </main>
        </div>
    </div>
</main>

<script>
    function addTemplate(element){
        
        console.log("element");
        console.log(element);
        console.log(element.id);
        console.log(element.dataset.templateId);


        storeTemplateIDLocally(element.dataset.templateId);
        getTemplates();
    }

    function getTemplates() {
        let idQueue = JSON.parse(localStorage.getItem("idQueue")) || [];
        console.log(`Stored IDs: ${idQueue.join(", ")}`);
    }

    function storeTemplateIDLocally(id) {
        if (typeof(Storage) !== "undefined") {
            // Retrieve the existing queue from local storage
            let queue = JSON.parse(localStorage.getItem("idQueue")) || [];

            // Add the new ID to the end of the queue if it doesn't already exist
            if (!queue.includes(id)) {
                queue.push(id);
            }

            // Keep only the last 10 IDs in the queue
            queue = queue.slice(-10);

            // Store the updated queue in local storage
            localStorage.setItem("idQueue", JSON.stringify(queue));

            console.log(`ID ${id} stored locally.`);
        } else {
            console.log("Local storage is not supported by this browser.");
        }
    }

    function clearLocalStorage() {
        localStorage.clear();
    }


</script>
@endsection