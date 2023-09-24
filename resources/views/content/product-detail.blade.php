@extends('layouts.frontend')

@section('title', $template->title.' | Template | Designer Online | WAYAK')

@section('meta')
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="{{ $template->width }}x{{ $template->height }}{{ $template->measureUnits }}. Customize this template, change the text and images as you wish. After that, preview and save your work, your design will be ready to print, share or download." />
<meta name="title" content="{{ $template->title }} | Template | Design Online | WAYAK" />
<meta name="keywords" content="{{ $template->title }}" />
<meta property="og:url" content="{{  URL::current() }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $template->title }} | Template | Design Online | WAYAK" />
<meta property="og:description" content="Template ready for customization, get ready to download in minutes. Edit Online, choose between thousands of free design templates." />
<meta property="og:image" content="{{ asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] ) }}" />

<meta name="product-id" content="{{ $template->_id }}">
<meta name="customer-id" content="">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
<style>
    /* Style for notifications */
    /* body {
        font-family: Arial, sans-serif;
        padding: 20px;
    } */

    .notification {
        position: fixed;
        bottom: 10px;
        right: 10px;
        background-color: #444;
        color: #fff;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 320px;
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.4s ease, transform 0.4s ease;
        z-index: 2147483647;
    }

    .notification-content {
        flex: 1;
    }

    .notification-content a {
        color: #FFD700;
        text-decoration: none;
    }

    .notification-close {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        font-size: 18px;
        margin-left: 10px;
    }

    .notification-close:focus {
        outline: none;
    }
</style>
<style>
    /* STYLE FOR LOGIN FORM  */
    
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 4;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .close {
            position: absolute;
            right: 10px;
            top: 5px;
            cursor: pointer;
        }
    
</style>
@endsection

@section('content')
<!-- Trigger button -->
<button id="showModalBtn">Login</button>

<!-- The Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h2>Login</h2>
        <form id="loginForm">
            <div>
                <label for="usernameInput">Email:</label>
                <input type="email" id="usernameInput" required>
            </div>
            <div>
                <label for="passwordInput">Password:</label>
                <input type="password" id="passwordInput" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</div>


<div itemscope itemtype="https://schema.org/Product">
    <meta itemprop="sku" content="{{ $template->_id }}" />
    <div itemprop="brand" itemtype="http://schema.org/Brand" itemscope>
        <meta itemprop="name" content="Wayak" />
    </div>
    <div itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
        <link itemprop="url" href="{{ urlencode(URL::current().'?utm_source=microdata') }}" />
        <meta itemprop="availability" content="https://schema.org/InStock" />
        <meta itemprop="priceCurrency" content="USD" />
        <meta itemprop="itemCondition" content="https://schema.org/NewCondition" />
        <meta itemprop="price" content="0" />
    </div>
    <div class="page__canvas">
        <div class="canvas">
            <div class="canvas__header">
            </div>
            <div class="js-canvas__body canvas__body">
                <div class="grid-container">
                </div>
                <div class="context-header ">
                    <div class="grid-container ">
                        <nav class="breadcrumbs h-text-truncate ">
                            <a href="{{ url('') }}">{{ __('product.home') }}</a>
                            @foreach ($breadcrumbs as $breadcrumb)
                            <a class="js-breadcrumb-category" href="{{ $breadcrumb->url.'?source=breadcrumbs' }}">{{ $breadcrumb->name }}</a>
                            @endforeach
                        </nav>
                    </div>
                </div>
                <div class="content-main" id="content">
                    <div class="grid-container">
                        <div class="content-s js-adi-data-wrapper adi-variant-2">
                            <div class="box--no-padding">
                                <div class="item-preview ">
                                    <img class="img-fluid" alt="{{ $template->title }}" itemprop="image" src="{{ $preview_image }}">
                                    <div class="item-preview__actions">
                                        <div class="item-preview__preview-buttons--social" data-view="socialButtons">
                                            <div class="btn-group">
                                                <!-- <div class="btn btn--label btn--group-item">Share</div> -->
                                                <a class="btn btn--group-item fb" data-social-network="Facebook" data-social-network-link="" href="https://www.facebook.com/sharer/sharer.php?display=popup&u={{ urlencode(URL::current().'?utm_source=sharepi') }}">
                                                    <img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2072%2072%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h72v72H0z%22%2F%3E%3Cpath%20class%3D%22icon%22%20fill%3D%22%23fff%22%20d%3D%22M68.812%2015.14c-2.348%201.04-4.87%201.744-7.52%202.06%202.704-1.62%204.78-4.186%205.757-7.243-2.53%201.5-5.33%202.592-8.314%203.176C56.35%2010.59%2052.948%209%2049.182%209c-7.23%200-13.092%205.86-13.092%2013.093%200%201.026.118%202.02.338%202.98C25.543%2024.527%2015.9%2019.318%209.44%2011.396c-1.125%201.936-1.77%204.184-1.77%206.58%200%204.543%202.312%208.552%205.824%2010.9-2.146-.07-4.165-.658-5.93-1.64-.002.056-.002.11-.002.163%200%206.345%204.513%2011.638%2010.504%2012.84-1.1.298-2.256.457-3.45.457-.845%200-1.666-.078-2.464-.23%201.667%205.2%206.5%208.985%2012.23%209.09-4.482%203.51-10.13%205.605-16.26%205.605-1.055%200-2.096-.06-3.122-.184%205.794%203.717%2012.676%205.882%2020.067%205.882%2024.083%200%2037.25-19.95%2037.25-37.25%200-.565-.013-1.133-.038-1.693%202.558-1.847%204.778-4.15%206.532-6.774z%22%2F%3E%3C%2Fsvg%3E">
                                                </a>
                                                <a class="btn btn--group-item tw" data-social-network="Twitter" data-social-network-link="" href="https://twitter.com/intent/tweet?text={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}&url={{ urlencode(URL::current().'?utm_source=sharetw') }}">
                                                    <img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2072%2072%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h72v72H0z%22%2F%3E%3Cpath%20class%3D%22icon%22%20fill%3D%22%23fff%22%20d%3D%22M68.812%2015.14c-2.348%201.04-4.87%201.744-7.52%202.06%202.704-1.62%204.78-4.186%205.757-7.243-2.53%201.5-5.33%202.592-8.314%203.176C56.35%2010.59%2052.948%209%2049.182%209c-7.23%200-13.092%205.86-13.092%2013.093%200%201.026.118%202.02.338%202.98C25.543%2024.527%2015.9%2019.318%209.44%2011.396c-1.125%201.936-1.77%204.184-1.77%206.58%200%204.543%202.312%208.552%205.824%2010.9-2.146-.07-4.165-.658-5.93-1.64-.002.056-.002.11-.002.163%200%206.345%204.513%2011.638%2010.504%2012.84-1.1.298-2.256.457-3.45.457-.845%200-1.666-.078-2.464-.23%201.667%205.2%206.5%208.985%2012.23%209.09-4.482%203.51-10.13%205.605-16.26%205.605-1.055%200-2.096-.06-3.122-.184%205.794%203.717%2012.676%205.882%2020.067%205.882%2024.083%200%2037.25-19.95%2037.25-37.25%200-.565-.013-1.133-.038-1.693%202.558-1.847%204.778-4.15%206.532-6.774z%22%2F%3E%3C%2Fsvg%3E">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-l sidebar-right js-sso-checkout-experiment">
                            <div class="pricebox-container js-author-driven-pricing-experiment">
                                <div class="box -radius-all">
                                    <div id="purchase-form" class="purchase-form">
                                        <div id="listing-page-cart" class="wt-display-flex-lg wt-flex-direction-column-md wt-flex-lg-3 wt-pl-md-4 wt-pr-md-4 wt-pl-lg-0 wt-pr-lg-5 wt-pl-xs-2 wt-pr-xs-2">

                                            <div data-buy-box-region="price">
                                                @if(isset($sale) && $sale != null )
                                                    <p class="wt-text-title-01 sale-ending-soon wt-mb-xs-1">
                                                        Sale ends in <span id="countdown"></span>
                                                    </p>
                                                @endif
                                                <div class="wt-display-flex-xs wt-align-items-center wt-justify-content-space-between">
                                                    <div class="wt-display-flex-xs wt-align-items-center wt-flex-wrap">
                                                        <p class="wt-text-title-03 wt-mr-xs-1">
                                                            <span class="wt-screen-reader-only">Price:</span>
                                                            <span>
                                                                @if(isset($sale) && $sale != null )
                                                                    MX${{ $template->prices['price'] }}
                                                                @else
                                                                    MX${{ $template->prices['original_price'] }}
                                                                @endif
                                                            </span>
                                                        </p>
                                                        @if(isset($sale) && $sale != null )
                                                            <div class="wt-display-flex-xs wt-text-caption wt-text-gray">
                                                                <div class="wt-text-strikethrough wt-mr-xs-1">
                                                                    <span class="wt-screen-reader-only">Original Price:</span>
                                                                    MX${{ $template->prices['original_price'] }}
                                                                </div>
                                                                <div class="wt-mr-xs-1">
                                                                    ({{ $template->prices['discount_percent'] }}% Off)
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="wt-spinner wt-spinner--01 wt-display-none" aria-live="assertive" data-buy-box-price-spinner="">
                                                            <span class="wt-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                                    <circle fill="transparent" cx="12" cy="12" r="10"></circle>
                                                                </svg></span>
                                                            Loading
                                                        </div>

                                                    </div>
                                                    <div data-buy-box-region="stock_indicator">
                                                    </div>
                                                </div>

                                            </div>

                                            <div data-buy-box-region="vat_messaging">
                                                <div class="wt-text-gray wt-text-caption wt-pt-xs-1 wt-pb-xs-1">
                                                    VAT Included
                                                </div>
                                            </div>
                                            <div class="wt-mb-xs-2">
                                                <h1 class="wt-text-body-01 wt-line-height-tight wt-break-word wt-mt-xs-1" data-buy-box-listing-title="true">
                                                    {{ $template->title }}
                                                </h1>

                                            </div>
                                            <div class="">
                                                <div data-action="follow-shop-listing-header" class=" wt-mb-xs-1">
                                                    <div class="wt-display-flex-xs wt-align-items-center">
                                                        <p class="wt-text-body-01">
                                                            <a class="wt-text-link-no-underline" aria-label="View more products from store owner {{ $template->studioName }}">
                                                                <span aria-hidden="true">
                                                                    {{ $template->studioName }}
                                                                </span>
                                                            </a>
                                                        </p>

                                                        <div data-action="follow-shop-button-container" class="wt-display-flex-xs wt-align-items-center" data-template-id="{{ $template->_id }}">
                                                            <!-- <input type="hidden" class="id" name="user_id" value="16374284"> -->
                                                            <a rel="16374284" data-downtime-overlay-type="favorite" data-supplemental-state--use_follow_text="true" class="inline-overlay-trigger favorite-shop-action wt-btn wt-btn--small wt-btn--transparent follow-shop-button-listing-header-v3" aria-label="Follow shop" data-action="follow-shop-button" data-template-id="{{ $template->_id }}" data-shop-id="9116151" data-source-name="listing_header" data-module-name="">
                                                                @if($logged_id == 0 || ($logged_id > 0 && $isFavorite == false) )
                                                                    <span class="etsy-icon wt-icon--smaller" data-not-following-icon="" data-template-id="{{ $template->_id }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                                            <path d="M12,21C10.349,21,2,14.688,2,9,2,5.579,4.364,3,7.5,3A6.912,6.912,0,0,1,12,5.051,6.953,6.953,0,0,1,16.5,3C19.636,3,22,5.579,22,9,22,14.688,13.651,21,12,21ZM7.5,5C5.472,5,4,6.683,4,9c0,4.108,6.432,9.325,8,10,1.564-.657,8-5.832,8-10,0-2.317-1.472-4-3.5-4-1.979,0-3.7,2.105-3.721,2.127L11.991,8.1,11.216,7.12C11.186,7.083,9.5,5,7.5,5Z">
                                                                            </path>
                                                                        </svg>
                                                                    </span>
                                                                    <span class="etsy-icon wt-icon--smaller wt-display-none wt-text-brick" data-following-icon=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                                            <path d="M16.5,3A6.953,6.953,0,0,0,12,5.051,6.912,6.912,0,0,0,7.5,3C4.364,3,2,5.579,2,9c0,5.688,8.349,12,10,12S22,14.688,22,9C22,5.579,19.636,3,16.5,3Z">
                                                                            </path>
                                                                        </svg></span>
                                                                    <span data-following-message="" class="wt-ml-xs-1 listing-header-v3-message wt-display-inline-block wt-position-relative wt-display-none ">Following</span>
                                                                    <span data-not-following-message="" class="wt-ml-xs-1 listing-header-v3-message wt-display-inline-block wt-position-relative ">Follow</span>
                                                                @elseif( $logged_id > 0 && $isFavorite == true )
                                                                    <span class="etsy-icon wt-icon--smaller wt-display-none " data-not-following-icon="" data-template-id="{{ $template->_id }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                                            <path d="M12,21C10.349,21,2,14.688,2,9,2,5.579,4.364,3,7.5,3A6.912,6.912,0,0,1,12,5.051,6.953,6.953,0,0,1,16.5,3C19.636,3,22,5.579,22,9,22,14.688,13.651,21,12,21ZM7.5,5C5.472,5,4,6.683,4,9c0,4.108,6.432,9.325,8,10,1.564-.657,8-5.832,8-10,0-2.317-1.472-4-3.5-4-1.979,0-3.7,2.105-3.721,2.127L11.991,8.1,11.216,7.12C11.186,7.083,9.5,5,7.5,5Z">
                                                                            </path>
                                                                        </svg>
                                                                    </span>
                                                                    <span class="etsy-icon wt-icon--smaller wt-text-brick" data-following-icon=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                                            <path d="M16.5,3A6.953,6.953,0,0,0,12,5.051,6.912,6.912,0,0,0,7.5,3C4.364,3,2,5.579,2,9c0,5.688,8.349,12,10,12S22,14.688,22,9C22,5.579,19.636,3,16.5,3Z">
                                                                            </path>
                                                                        </svg></span>
                                                                    <span data-following-message="" class="wt-ml-xs-1 listing-header-v3-message wt-display-inline-block wt-position-relative">Following</span>
                                                                    <span data-not-following-message="" class="wt-ml-xs-1 listing-header-v3-message wt-display-inline-block wt-position-relative wt-display-none">Follow</span>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>


                                                    <div>
                                                        <div class="wt-display-inline-flex-xs wt-align-items-center wt-flex-wrap wt-mb-xs-1">
                                                            <div class="wt-flex-basis-lg-full wt-flex-basis-xl-auto wt-mb-xs-1">
                                                                <div class="star-seller-badge ">
                                                                    <div class="wt-popover star-seller-badge-listing-page wt-display-flex-xs" data-wt-popover="">
                                                                        <button data-wt-popover-trigger="" class="wt-popover__trigger wt-popover__trigger--underline wt-display-inline-flex-xs wt-align-items-center" aria-describedby="popover-content-01">

                                                                            <span class="wt-icon wt-icon--smaller-xs wt-icon--core wt-fill-lavender-light wt-flex-shrink-xs-0 wt-nudge-t-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                                                    <path d="M20.902 7.09l-2.317-1.332-1.341-2.303H14.56L12.122 2 9.805 3.333H7.122L5.78 5.758 3.341 7.09v2.667L2 12.06l1.341 2.303v2.666l2.318 1.334L7 20.667h2.683L12 22l2.317-1.333H17l1.341-2.303 2.317-1.334v-2.666L22 12.06l-1.341-2.303V7.09h.243zm-6.097 6.062l.732 3.515-.488.363-2.927-1.818-3.049 1.697-.488-.363.732-3.516-2.56-2.181.121-.485 3.537-.243 1.341-3.273h.488l1.341 3.273 3.537.243.122.484-2.44 2.303z">
                                                                                    </path>
                                                                                </svg></span>

                                                                            <p class="wt-text-caption-title wt-ml-xs-1">
                                                                                Star Seller
                                                                            </p>
                                                                        </button>

                                                                        <div class="wt-p-xs-3 seller-badge-popover" id="popover-content-01" role="tooltip" style="position: absolute; margin: 0px; inset: auto auto 20px -105px;" data-popper-placement="top">
                                                                            <p class="wt-mb-xs-1 wt-text-title-01">
                                                                                Star Seller
                                                                            </p>

                                                                            <p class="wt-mb-xs-1 wt-text-caption">
                                                                                Star Sellers have an outstanding
                                                                                track record for providing a
                                                                                great customer experience—they
                                                                                consistently earned 5-star
                                                                                reviews, shipped orders on time,
                                                                                and replied quickly to any
                                                                                messages they received.
                                                                            </p>
                                                                            <span class="wt-popover__arrow" style="position: absolute; left: 143px;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <span class="wt-ml-xs-1 wt-mr-xs-1 wt-mb-xs-1 wt-show-xs wt-hide-lg wt-show-xl" style="color: #e1e3df;">|</span>

                                                            <span class="wt-mb-xs-1 wt-display-inline-block">

                                                                <span class="wt-text-caption ">
                                                                    {{ $template->sales }} sales
                                                                </span>
                                                            </span>

                                                            <span class="wt-ml-xs-1 wt-mr-xs-1 wt-mb-xs-1 wt-display-inline-block" style="color: #e1e3df;">|</span>

                                                            <span class="wt-mb-xs-1 wt-display-inline-block">
                                                                <a class="wt-text-link-no-underline ssh-review-stars-text-decoration-none wt-display-inline-flex-xs wt-align-items-center wt-nudge-b-1" style="vertical-align: top;" href="#reviews">

                                                                    <span class="wt-display-inline-block wt-mr-xs-1">
                                                                        <input type="hidden" name="initial-rating" value="{{ $template->stars }}">
                                                                        <input type="hidden" name="rating" value="{{ $template->stars }}">
                                                                        <span class="wt-screen-reader-only">
                                                                            {{ $template->stars }} out of 5 stars</span>

                                                                        <span>
                                                                            @for ($i = 1; $i <= $template->stars; $i++)
                                                                                <span class="wt-icon wt-nudge-b-1 wt-icon--smallest" data-rating="0"><svg xmlns="http://www.w3.org/2000/svg" viewBox="3 3 18 18" aria-hidden="true" focusable="false">
                                                                                        <path d="M20.83,9.15l-6-.52L12.46,3.08h-.92L9.18,8.63l-6,.52L2.89,10l4.55,4L6.08,19.85l.75.55L12,17.3l5.17,3.1.75-.55L16.56,14l4.55-4Z">
                                                                                        </path>
                                                                                    </svg>
                                                                                </span>
                                                                                @endfor
                                                                        </span>
                                                                    </span>

                                                                </a>
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="purchase-form__button">
                                            <a class="js-item-header__cart-button e-btn--3d -color-primary -size-m" rel="nofollow" title="Add to Cart" href="{{ 
                                                            route('editor.demoTemplate',[
                                                            'country' => $country,
                                                            'template_key' => $template->_id
                                                        ] )
                                                    }}">
                                                <span class="t-heading -size-m -color-light -margin-none">
                                                    Try Demo
                                                </span>
                                            </a>
                                        </div>
                                        <hr>
                                        <div class="purchase-form__button">
                                            Buy it Now:
                                            <div id="smart-button-container">
                                                <div style="text-align: center;">
                                                    <div id="paypal-button-container"></div>
                                                </div>
                                            </div>
                                            <a class="js-item-header__cart-button e-btn--3d -color-primary -size-m" rel="nofollow" title="Add to Cart" href="{{ 
                                                            route('code.validate.form',[
                                                            'country' => $country,
                                                            'product_id' => $template->_id,
                                                            'ref' => url()->full()
                                                        ] )
                                                    }}">
                                                <span class="t-heading -size-m -color-light -margin-none">
                                                    Use Code
                                                </span>
                                            </a>
                                        </div>
                                        <p class="t-body -size-s" itemprop="description">
                                            <!-- The size of this template is {{ $template->width }}x{{ $template->height }}{{ $template->measureUnits }}. Click “Use This Template“, start your own design. Then you can change the text and images as you wish. After that, preview and save your work, your design will be ready to print, share or download. -->
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="box -radius-all">
                                <div class="rating-detailed--has-no-ratings">
                                    <div class="MuiGrid-root MuiGrid-container MuiGrid-direction-xs-column mui-p2asnn">
                                        <span class="MuiTypography-root MuiTypography-text MuiTypography-alignLeft mui-1d3vavr-templateTitle">
                                            About this Template
                                        </span>
                                        <div class="MuiBox-root mui-1uc6yu5-iconBox">
                                            <div class="MuiBox-root mui-k008qs"><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium mui-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 32 32" data-testid="Illustrations.svgIcon">
                                                    <path d="M16 21.6c1.2-.267 2.933-.667 4.933-2.667 4.933-4.933 7.733-10 7.867-10.267l.533-1.333-4-4L24 3.866c-.267.133-5.2 2.8-10.267 7.867-2 2-2.267 3.733-2.533 4.933-2.533 1.2-3.467 4.667-3.867 6.267l-.533 2.8 2.533-.533c1.733-.4 5.467-1.067 6.667-3.6zm-.4-8c3.6-3.6 7.733-6.267 9.067-6.8l1.2 1.2c-.533 1.2-3.2 5.333-6.8 9.067-1.6 1.6-3.2 2-3.733 2l-1.733-1.733c0-.533.4-2.133 2-3.733zm-3.467 5.467l1.467 1.467c-.933 1.067-2.133 1.733-3.733 2.133.533-1.467 1.2-2.667 2.267-3.6zM2.667 30h24l2.667-2.667h-24L2.667 30z">
                                                    </path>
                                                </svg>
                                                <h6 class="MuiTypography-root MuiTypography-body1 MuiTypography-alignCenter mui-usehnw-iconText">
                                                    100% fully customizable
                                                </h6>
                                            </div>
                                            <div class="MuiBox-root mui-k008qs"><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium mui-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 32 32" data-testid="ArrowDown.svgIcon">
                                                    <path d="M23.067 16.533l-5.733 5.733V5.999h-2.667v16.267l-5.733-5.733L7.067 18.4 16 27.333l8.933-8.933z">
                                                    </path>
                                                </svg>
                                                <h6 class="MuiTypography-root MuiTypography-body1 MuiTypography-alignCenter mui-usehnw-iconText">
                                                    Edit and download on the go
                                                </h6>
                                            </div>
                                            <div class="MuiBox-root mui-k008qs"><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium mui-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 32 32" data-testid="Collections.svgIcon">
                                                    <path d="M16 9.333v-4H2.667v21.333H24c2.946 0 5.333-2.388 5.333-5.333v-12zm10.667 12C26.667 22.806 25.473 24 24 24H5.333V8h8v2.667c0 .736.597 1.333 1.333 1.333h12z">
                                                    </path>
                                                </svg>
                                                <h6 class="MuiTypography-root MuiTypography-body1 MuiTypography-alignCenter mui-usehnw-iconText">
                                                    Share and publish anywhere</h6>
                                            </div>
                                            <div class="MuiBox-root mui-k008qs"><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium mui-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 32 32" data-testid="Blog.svgIcon">
                                                    <path d="M14.8 4.133H3.6v11.2h11.2v-11.2zm-2.533 8.8H6.134V6.666h6.267v6.267zm10.666 2.534c3.067 0 5.6-2.533 5.6-5.6s-2.533-5.6-5.6-5.6-5.6 2.4-5.6 5.467 2.533 5.733 5.6 5.733zm0-8.8C24.666 6.667 26 8.134 26 9.734s-1.467 3.067-3.067 3.067-3.067-1.467-3.067-3.067 1.333-3.067 3.067-3.067zM2.667 29.2h14.267L9.867 16.667 2.667 29.2zm4.266-2.533l2.8-4.933 2.8 4.933h-5.6zM22.8 16.133l-6.533 6.533 3.2 6.533H26l3.2-6.533-6.4-6.533zm1.733 10.534h-3.467L19.333 23.2l3.467-3.467 3.467 3.467-1.733 3.467z">
                                                    </path>
                                                </svg>
                                                <h6 class="MuiTypography-root MuiTypography-body1 MuiTypography-alignCenter mui-usehnw-iconText">
                                                    No special software required, edit online</h6>
                                            </div>
                                            <div class="MuiBox-root mui-k008qs"><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium mui-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 32 32" data-testid="Rotate.svgIcon">
                                                    <path d="M28 17.333C28 10 22 4 14.667 4 12.4 4 10.4 4.533 8.534 5.6L6.667 2.667l-2.667 8h8l-2-2.933c1.467-.667 3.067-1.067 4.667-1.067 5.867 0 10.667 4.8 10.667 10.667h2.667z">
                                                    </path>
                                                    <path d="M4 28h13.333c2.933 0 5.333-2.4 5.333-5.333v-9.333H3.999v14.667zm2.667-2.667V16H20v6.667c0 1.467-1.2 2.667-2.667 2.667H6.666z">
                                                    </path>
                                                </svg>
                                                <h6 class="MuiTypography-root MuiTypography-body1 MuiTypography-alignCenter mui-usehnw-iconText">
                                                    Instant access to your template</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box -radius-all">
                                <div class="meta-attributes " data-view="CondenseItemInfoPanel">
                                    <table class="meta-attributes__table" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <!-- <tr>
                                                        <td class="meta-attributes__attr-name">Last Update</td>
                                                        <td class="meta-attributes__attr-detail">
                                                            <time class="updated" datetime="2021-01-05T10:16:16+11:00">
                                                                {{ $template->updatedAt }}
                                                            </time>
                                                        </td>
                                                    </tr> -->
                                            <!-- <tr>
                                                        <td class="meta-attributes__attr-name">Created</td>
                                                        <td class="meta-attributes__attr-detail">
                                                            <span>
                                                                {{ $template->createdAt }}
                                                            </span>
                                                        </td>
                                                    </tr> -->
                                            <tr>
                                                <td class="meta-attributes__attr-name">{{ __('product.category') }}</td>
                                                <td class="meta-attributes__attr-detail">
                                                    <!-- <a rel="nofollow" href="/attributes/print-dimensions/4x4"> -->
                                                    <a rel="nofollow" href="{{ $breadcrumb->url }}">
                                                        {{ $breadcrumb->name }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="meta-attributes__attr-name">{{ __('product.format') }}</td>
                                                <td class="meta-attributes__attr-detail">
                                                    <!-- <a rel="nofollow" href="/attributes/print-dimensions/4x4"> -->
                                                    {{ $template->format }}
                                                    <!-- </a> -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="meta-attributes__attr-name">{{ __('product.dimensions') }}</td>
                                                <td class="meta-attributes__attr-detail">
                                                    <!-- <a rel="nofollow" href="/attributes/print-dimensions/4x4"> -->
                                                    {{ $template->width }}x{{ $template->height }} {{ $template->measureUnits }}
                                                    <!-- </a> -->
                                                </td>
                                            </tr>
                                            @if( isset($template->tags) && sizeof($template->tags) > 0 )
                                            <tr>
                                                <td class="meta-attributes__attr-name">Tags</td>
                                                <td>
                                                    <span class="meta-attributes__attr-tags">
                                                        @foreach($template->tags as $tag)
                                                        <a title="artist flyer" rel="nofollow" href="/artist%20flyer-graphics">
                                                            {{ $tag->name }}
                                                        </a>,
                                                        @endforeach
                                                    </span>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box -radius-all">
                                <div class="rating-detailed--has-no-ratings">
                                    <strong>{{ __('product.colors') }}</strong> &nbsp;&nbsp;
                                    <ul class="DM08FA">
                                        @foreach( $colors as $hex_color )
                                        <li class="Gu5L1Q" style="background-color: {{ $hex_color }};">
                                            <div class="_-pFsfA">{{ $hex_color }}</div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container pt-4 may-also-like">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="wt-text-heading-01">You may also like</h4>
                            </div>
                        </div>
                        <div class="row pt-3">
                            @foreach ($related_templates as $r_template)
                            <div class="col-6 col-sm-4 col-md-3">
                                <a href="{{ route( 'template.productDetail', ['country' => $country,'slug' => $r_template->slug,'source'=>'related'] ) }}">
                                    <img class="img-fluid" alt="{{ $r_template->title }}" src="{{  $r_template->preview_image }}" loading="lazy">
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2">
                                    <a class="btn btn-secondary" href="{{ route( 'user.search', ['country' => $country] ) }}?category={{ urlencode( $template->mainCategory )}}">Explore More Like This</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="page__overlay" data-view="offCanvasNavToggle" data-off-canvas="close"></div>
    </div>
</div>
<div data-site="Wakay" data-view="CsatSurvey" data-experiment-id="csat_survey" class="is-visually-hidden">
    <div id="js-customer-satisfaction-survey">
        <div class="e-modal">
            <div class="e-modal__section" id="js-customer-satisfaction-survey-iframe-wrapper">
            </div>
        </div>
    </div>
</div>
<div id="notification" class="notification">
    <div class="notification-content"></div>
    <button class="notification-close" onclick="closeNotification()">✕</button>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const customerId = getCustomerId();
        const metaElement = document.querySelector('meta[name="product-id"]');
        const productId = metaElement.getAttribute('content');
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute("content") : null;

        function getCustomerId() {
            // Try to get customerId from the meta tag
            let metaTag = document.querySelector('meta[name="customer-id"]');
            let customerId = metaTag ? metaTag.getAttribute('content') : null;

            // If meta tag is empty, try to get customerId from localStorage
            if (!customerId) {
                customerId = localStorage.getItem('customerId');
            }

            // If customerId is still not found, generate a new one and store it in localStorage
            if (!customerId) {
                customerId = Math.random().toString(36).substr(2, 10);
                localStorage.setItem('customerId', customerId);
            }

            return customerId;
        }

        function saveProductHistory() {
            let productHistory = localStorage.getItem('productHistory');
            const currentTime = Date.now();

            if (productHistory) {
                productHistory = JSON.parse(productHistory);
                if (productHistory[productId]) {
                    productHistory[productId].count++;
                    productHistory[productId].lastVisited = currentTime;
                } else {
                    productHistory[productId] = {
                        count: 1,
                        lastVisited: currentTime
                    };
                }
            } else {
                productHistory = {};
                productHistory[productId] = {
                    count: 1,
                    lastVisited: currentTime
                };
            }

            localStorage.setItem('productHistory', JSON.stringify(productHistory));
            syncProductHistory(customerId, productHistory);
        }

        function shouldRunSyncProductHistory() {
            const lastSynced = localStorage.getItem('lastSynced');
            const currentTime = Date.now();
            const timeSinceLastSync = currentTime - lastSynced; // Time in milliseconds
            // 24 * 60 * 60 * 1000; // 24 hours in milliseconds
            const timeToNextSync = 600000 - timeSinceLastSync; // 600,000 milliseconds (10 minutes)

            if (!lastSynced || timeSinceLastSync > 600000) { // 600,000 milliseconds (10 minutes)
                console.debug("Time for the next update.");
                return true;
            } else {
                const remainingMinutes = Math.ceil(timeToNextSync / 60000); // Convert to minutes
                console.debug(`Next update in ${remainingMinutes} minute(s).`);
                return false;
            }
        }

        function syncProductHistory(customerId, productHistory) {
            if (shouldRunSyncProductHistory()) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/syncProductHistory', true);
                if (csrfToken) {
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
                }
                const formData = new FormData();
                formData.append('customerId', customerId);
                formData.append('productHistory', JSON.stringify(productHistory));

                // Add an event listener for the 'load' event on the XMLHttpRequest object
                xhr.addEventListener('load', function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Success: Clear the product history in localStorage
                        localStorage.setItem('productHistory', JSON.stringify({}));
                        // Upon successful sync, update 'lastSynced' in localStorage
                        localStorage.setItem('lastSynced', Date.now());
                    } else {
                        // Error: Handle it if necessary
                        console.error('Sync failed');
                    }
                });

                // Send the request
                xhr.send(formData);
            }
        }

        function removeProductFromServer(customerId, productId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/removeProductFromHistory', true);
            if (csrfToken) {
                xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
            }
            const formData = new FormData();
            formData.append('customerId', customerId);
            formData.append('productId', productId);

            // Add an event listener for the 'load' event on the XMLHttpRequest object
            xhr.addEventListener('load', function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Success: Remove the product from local storage
                    let productHistory = localStorage.getItem('productHistory');
                    if (productHistory) {
                        productHistory = JSON.parse(productHistory);
                        delete productHistory[productId];
                        localStorage.setItem('productHistory', JSON.stringify(productHistory));
                    }
                } else {
                    // Error: Handle it if necessary
                    console.error('Failed to remove product from server');
                }
            });

            // Send the request
            xhr.send(formData);
        }

        function deleteProductFromHistory(productId) {
            // Attempt to remove the product from the server first
            removeProductFromServer(customerId, productId);
        }

        window.addEventListener('beforeunload', function() {
            saveProductHistory();
        });

        // saveProductHistory();
    });
</script>


<script>
    function displayNotification(contentText, actionText, actionURL, durationInSeconds) {
        const notification = document.getElementById("notification");
        const notificationContent = document.querySelector(".notification-content");

        // Update notification content
        notificationContent.innerHTML = `${contentText} <a href="${actionURL}" target="_blank">${actionText}</a>?`;

        // Display the notification with animation
        notification.style.opacity = "1";
        notification.style.transform = "translateY(0)";

        // Remove notification after the specified duration if there's no user interaction
        setTimeout(function() {
            if (notification.style.opacity !== "0") {
                closeNotification();
            }
        }, durationInSeconds * 1000);
    }

    function closeNotification() {
        const notification = document.getElementById("notification");
        notification.style.opacity = "0";
        notification.style.transform = "translateY(50px)";
    }
</script>
<script>
    // Add to favorites
    document.querySelector("#listing-page-cart > div:nth-child(4) > div > div.wt-display-flex-xs.wt-align-items-center > div > a").addEventListener('click', function(event) {

        console.log("OPIPIPIP");
    
        // Try to get customerId from the meta tag
        let templateIdTag = document.querySelector('meta[name="product-id"]');
        let templateId = templateIdTag ? templateIdTag.getAttribute('content') : null;

        const customerId = localStorage.getItem('customerId');
        const loggedIn = localStorage.getItem('loggedIn');
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute("content") : null;
        
        let favorites = JSON.parse(localStorage.getItem('favorites')) || {};


        if (!favorites[templateId]) {
        
            // Send to backend if user is logged in
            if (loggedIn) {
                fetch("/favorites/add", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        "template-id": templateId,
                        "customerId": customerId,
                        "collectionName": "default" // TODO: Implement collection selection
                    })
                })
                .then(response => {
                    if (response.status === 401) {
                        // Handle the 401 Unauthorized error
                        console.error('Unauthorized. Please login again.');
                        // Optionally, redirect the user to the login page or show a modal asking them to log in.
                        // window.location.href = '/login';
                        // localStorage.setItem('pendingFavorite', templateId);
                        favorites[templateId] = new Date().toISOString();
                        localStorage.setItem('favorites', JSON.stringify(favorites));
                        localStorage.setItem('loggedIn', false);
                        showAddedToFavoritesNotification();
                        toggleFavoritesButton();

                    } else if (response.ok) {
                        favorites[templateId] = new Date().toISOString();
                        localStorage.setItem('favorites', JSON.stringify(favorites));
                        // showAddedToFavoritesNotification();
                        toggleFavoritesButton();
                    } else if (!response.ok) {
                        // Handle other errors
                        return response.json().then(data => {
                            console.error('Error:', data.message);
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
            } else {
                favorites[templateId] = new Date().toISOString();
                localStorage.setItem('favorites', JSON.stringify(favorites));
                showAddedToFavoritesNotification();
                toggleFavoritesButton();
            }
        }
    });

    function toggleFavoritesButton(){
        const favoritedIconBtn = document.querySelector("#listing-page-cart > div > div > div.wt-display-flex-xs.wt-align-items-center > div > a > span.etsy-icon.wt-icon--smaller.wt-text-brick");
        const favoritedLabelBtn = document.querySelector("#listing-page-cart > div > div > div.wt-display-flex-xs.wt-align-items-center > div > a > span.wt-ml-xs-1.listing-header-v3-message.wt-display-inline-block.wt-position-relative");
        
        const addTofavoriteLabelBtn = document.querySelector("#listing-page-cart > div > div > div.wt-display-flex-xs.wt-align-items-center > div > a > span:nth-child(1)");
        const addTofavoriteIconBtn = document.querySelector("#listing-page-cart > div:nth-child(4) > div > div.wt-display-flex-xs.wt-align-items-center > div > a > span:nth-child(4)");

        if(favoritedIconBtn){
            /// create code to check if favoritedIconBtn has class "wt-display-none", if it has, then remove it, if it doesn't have, then add it
            if(favoritedIconBtn.classList.contains("wt-display-none")){
                favoritedIconBtn.classList.remove("wt-display-none");
            } else {
                favoritedIconBtn.classList.add("wt-display-none");
            }
        }
    
        if(favoritedLabelBtn){
            /// create code to check if favoritedLabelBtn has class "wt-display-none", if it has, then remove it, if it doesn't have, then add it
            if(favoritedLabelBtn.classList.contains("wt-display-none")){
                favoritedLabelBtn.classList.remove("wt-display-none");
            } else {
                favoritedLabelBtn.classList.add("wt-display-none");
            }
        }
        
        if(addTofavoriteLabelBtn){
            /// create code to check if addTofavoriteLabelBtn has class "wt-display-none", if it has, then remove it, if it doesn't have, then add it
            if(addTofavoriteLabelBtn.classList.contains("wt-display-none")){
                addTofavoriteLabelBtn.classList.remove("wt-display-none");
            } else {
                addTofavoriteLabelBtn.classList.add("wt-display-none");
            }
        }
        
        if(addTofavoriteIconBtn){
            /// create code to check if addTofavoriteIconBtn has class "wt-display-none", if it has, then remove it, if it doesn't have, then add it
            if(addTofavoriteIconBtn.classList.contains("wt-display-none")){
                addTofavoriteIconBtn.classList.remove("wt-display-none");
            } else {
                addTofavoriteIconBtn.classList.add("wt-display-none");
            }
        }
    }

    function showAddedToFavoritesNotification() {
        const notificationText = "This favorite won't last! Sign in or register to save items for more than 7 days. Do you want to";
        const actionButtonText = "Sign in";
        const actionURL = "https://www.ups.com/track?loc=en_US&requester=ST/";
        const displayDuration = 10; // Display for 10 seconds
        displayNotification(notificationText, actionButtonText, actionURL, displayDuration);
    }

    // Check for pending favorites after login
    if (localStorage.getItem('redirectTo') && localStorage.getItem('pendingFavorite')) {
        const templateId = localStorage.getItem('pendingFavorite');
        const customerId = localStorage.getItem('customerId');
        fetch("/favorite/add", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "template-id": templateId,
                "customerId": customerId,
                "collectionName": "default"
            })
        }).then(() => {
            window.location.href = localStorage.getItem('redirectTo');
            localStorage.removeItem('redirectTo');
            localStorage.removeItem('pendingFavorite');
        });
    }

    // Assuming each favorite product is displayed in a div with a class 'favorite-item'
    // and each 'remove' button within this div has a class 'remove-favorite-btn'
    document.querySelectorAll(".favorite-item .remove-favorite-btn").forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            const templateId = event.target.closest('.favorite-item').getAttribute('data-template-id');
            const customerId = localStorage.getItem('customerId');
            // const loggedIn = (customerId && customerId !== "");
            const loggedIn = false;
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute("content") : null;

            // Remove from local storage
            let favorites = JSON.parse(localStorage.getItem('favorites')) || {};
            if (favorites[templateId]) {
                delete favorites[templateId];
                localStorage.setItem('favorites', JSON.stringify(favorites));
            }

            // Send removal request to backend if user is logged in
            if (loggedIn) {
                fetch("/favorite/remove", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        "template-id": templateId,
                        "customerId": customerId,
                        "collectionName": "default" // Assuming default collection for this example
                    })
                }).then(response => {
                    if (response.status === 200) {
                        // Successfully removed from backend
                        // Remove the product from the display
                        event.target.closest('.favorite-item').remove();
                    } else {
                        // Handle error, maybe show an alert or a message to the user
                        alert("There was an issue removing the product from favorites.");
                    }
                });
            } else {
                // Remove the product from the display for non-logged in users
                event.target.closest('.favorite-item').remove();
            }
        });
    });

</script>
<script>
    document.querySelector('#loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const username = document.querySelector('#usernameInput').value;
        const password = document.querySelector('#passwordInput').value;

        ajaxLogin(username, password);
    });

    async function ajaxLogin(username, password) {
        try {
            const response = await fetch('/login', { // Adjust the URL if needed
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest', // Important for Laravel to recognize AJAX request
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for Laravel
                },
                body: JSON.stringify({
                    username,
                    password
                })
            });

            const data = await response.json();

            if (data.success) {
                localStorage.setItem('loggedIn', 'true');
                window.location.href = data.redirect_url; // Redirect to the intended URL
            } else {
                // Handle login failure, maybe show an error message
                alert(data.message);
            }
        } catch (error) {
            console.error('Error logging in:', error);
        }
    }

      // Get modal and trigger elements
      const modal = document.getElementById('loginModal');
    const showModalBtn = document.getElementById('showModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Show modal
    showModalBtn.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    // Close modal
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close modal if clicked outside content
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Handle login form submission (you can integrate the ajaxLogin function here)
    document.querySelector('#loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const email = document.querySelector('#usernameInput').value;
        const password = document.querySelector('#passwordInput').value;

        // Call your login function here
        // ajaxLogin(email, password);
    });
</script>
<script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
    function initPayPalButton() {
        paypal.Buttons({
                style: {
                    shape: 'rect',
                    color: 'gold',
                    layout: 'vertical',
                    label: 'paypal',

                },

                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            "description": "Wayak Template",
                            "amount": {
                                "currency_code": "USD",
                                "value": {{ $template->prices['original_price'] }}
                            }
                        }]
                    });
                },

                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {

                            // Full available details
                            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                            // Show a success message within this page, e.g.
                            // const element = document.getElementById('paypal-button-container');
                            // element.innerHTML = '';
                            // element.innerHTML = '<h3>Thank you for your payment!</h3>';

                            // Or go to another URL:  
                            actions.redirect('{{
                                route('editor.openTemplate',[
                                                            'country' => $country,
                                                            'template_key' => $template->_id
                                                        ] )
                            }}');


                    });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton();

    function countdown(secondsRemaining, elementToUpdate) {
        // update the count down every second
        const x = setInterval(function() {

            // calculate the time remaining
            const days = Math.floor(secondsRemaining / (24 * 60 * 60));
            const hours = Math.floor((secondsRemaining % (24 * 60 * 60)) / (60 * 60));
            const minutes = Math.floor((secondsRemaining % (60 * 60)) / 60);
            const seconds = Math.floor(secondsRemaining % 60);

            // format the countdown text
            const countdownText = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

            // update the HTML element
            elementToUpdate.innerText = countdownText;

            // decrement the time remaining
            secondsRemaining--;

            // check if the countdown has finished
            if (secondsRemaining < 0) {
                clearInterval(x);
                elementToUpdate.innerText = "Countdown finished";
            }
        }, 1000);
    }

    function remainingSecondsUntilUtcDate(dateString) {
        var date = new Date(dateString);
        var remainingSeconds = (date.getTime() - Date.now()) / 1000;
        return remainingSeconds;
    }

    @if($sale != null)

    var date = '{{ $sale['sale_ends_at'] }}';
    var remainingSeconds = remainingSecondsUntilUtcDate(date);
    console.log('Remaining seconds until ' + date + ': ' + remainingSeconds);

    // const secondsRemaining = 3600; // 1 hour
    const elementToUpdate = document.getElementById("countdown");
    countdown(remainingSeconds, elementToUpdate);

    @endif
</script>
@endsection