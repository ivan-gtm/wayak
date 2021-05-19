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
    @endsection
    
    @section('css')
        <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    @endsection

@section('content')
        <div class="page" itemscope itemtype="https://schema.org/Product">
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
                                        <a class="js-breadcrumb-category" 
                                            href="{{ $breadcrumb->url }}">{{ $breadcrumb->name }}</a>
                                    @endforeach
                                    
                                </nav>
                                <div class="item-header" data-view="itemHeader">
                                    <div class="item-header__top">
                                        <div class="item-header__title">
                                            <h1 class="t-heading -color-inherit -size-l h-m0 is-hidden-phone"
                                                itemprop="name">
                                                {{ $template->title }}
                                            </h1>
                                            <h1 class="t-heading -color-inherit -size-xs h-m0 is-hidden-tablet-and-above">
                                                {{ $template->title }}
                                            </h1>
                                        </div>
                                        <div class="item-header__price">
                                            <a class="js-item-header__cart-button e-btn--3d -color-primary -size-m" 
                                                rel="nofollow" title="Add to Cart" 
                                                href="{{ 
                                                        route('editor.openTemplate',[
                                                        'country' => $country,
                                                        'template_key' => $template->_id
                                                    ] )
                                                }}">
                                                <!-- <span class="item-header__cart-button-icon">
                                                    <i class="e-icon -icon-cart -margin-right"></i>
                                                </span> -->
                                                <span class="t-heading -size-m -color-light -margin-none">
                                                    Use this Template
                                                </span>
                                            </a>      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-main" id="content">
                            <div class="grid-container">
                                <div class="content-s js-adi-data-wrapper adi-variant-2">
                                    <div class="box--no-padding">
                                        <div class="item-preview ">
                                            <img alt="{{ $template->title }}"
                                            itemprop="image"
                                            src="{{ $preview_image }}">
                                            <div class="item-preview__actions">
                                                <div class="item-preview__preview-buttons--social" data-view="socialButtons">
                                                    <div class="btn-group">
                                                        <!-- <div class="btn btn--label btn--group-item">Share</div> -->
                                                        <a class="btn btn--group-item fb" data-social-network="Facebook" data-social-network-link="" href="https://www.facebook.com/sharer/sharer.php?display=popup&u={{ urlencode(URL::current().'?utm_source=sharepi') }}">
                                                            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yr/r/zSKZHMh8mXU.png">
                                                        </a>
                                                        <a class="btn btn--group-item tw" data-social-network="Twitter" data-social-network-link="" href="https://twitter.com/intent/tweet?text={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}&url={{ urlencode(URL::current().'?utm_source=sharetw') }}">
                                                            <img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2072%2072%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h72v72H0z%22%2F%3E%3Cpath%20class%3D%22icon%22%20fill%3D%22%23fff%22%20d%3D%22M68.812%2015.14c-2.348%201.04-4.87%201.744-7.52%202.06%202.704-1.62%204.78-4.186%205.757-7.243-2.53%201.5-5.33%202.592-8.314%203.176C56.35%2010.59%2052.948%209%2049.182%209c-7.23%200-13.092%205.86-13.092%2013.093%200%201.026.118%202.02.338%202.98C25.543%2024.527%2015.9%2019.318%209.44%2011.396c-1.125%201.936-1.77%204.184-1.77%206.58%200%204.543%202.312%208.552%205.824%2010.9-2.146-.07-4.165-.658-5.93-1.64-.002.056-.002.11-.002.163%200%206.345%204.513%2011.638%2010.504%2012.84-1.1.298-2.256.457-3.45.457-.845%200-1.666-.078-2.464-.23%201.667%205.2%206.5%208.985%2012.23%209.09-4.482%203.51-10.13%205.605-16.26%205.605-1.055%200-2.096-.06-3.122-.184%205.794%203.717%2012.676%205.882%2020.067%205.882%2024.083%200%2037.25-19.95%2037.25-37.25%200-.565-.013-1.133-.038-1.693%202.558-1.847%204.778-4.15%206.532-6.774z%22%2F%3E%3C%2Fsvg%3E">
                                                        </a>
                                                        <a class="btn btn--group-item pi" data-social-network="Pinterest" data-social-network-link="" href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(URL::current().'?utm_source=sharepi') }}&media={{ $preview_image }}&description={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}">
                                                            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiPjwvcGF0aD48cGF0aCBkPSJNMTQuNzMzLDEuNjg2IEM3LjUxNiwxLjY4NiAxLjY2NSw3LjQ5NSAxLjY2NSwxNC42NjIgQzEuNjY1LDIwLjE1OSA1LjEwOSwyNC44NTQgOS45NywyNi43NDQgQzkuODU2LDI1LjcxOCA5Ljc1MywyNC4xNDMgMTAuMDE2LDIzLjAyMiBDMTAuMjUzLDIyLjAxIDExLjU0OCwxNi41NzIgMTEuNTQ4LDE2LjU3MiBDMTEuNTQ4LDE2LjU3MiAxMS4xNTcsMTUuNzk1IDExLjE1NywxNC42NDYgQzExLjE1NywxMi44NDIgMTIuMjExLDExLjQ5NSAxMy41MjIsMTEuNDk1IEMxNC42MzcsMTEuNDk1IDE1LjE3NSwxMi4zMjYgMTUuMTc1LDEzLjMyMyBDMTUuMTc1LDE0LjQzNiAxNC40NjIsMTYuMSAxNC4wOTMsMTcuNjQzIEMxMy43ODUsMTguOTM1IDE0Ljc0NSwxOS45ODggMTYuMDI4LDE5Ljk4OCBDMTguMzUxLDE5Ljk4OCAyMC4xMzYsMTcuNTU2IDIwLjEzNiwxNC4wNDYgQzIwLjEzNiwxMC45MzkgMTcuODg4LDguNzY3IDE0LjY3OCw4Ljc2NyBDMTAuOTU5LDguNzY3IDguNzc3LDExLjUzNiA4Ljc3NywxNC4zOTggQzguNzc3LDE1LjUxMyA5LjIxLDE2LjcwOSA5Ljc0OSwxNy4zNTkgQzkuODU2LDE3LjQ4OCA5Ljg3MiwxNy42IDkuODQsMTcuNzMxIEM5Ljc0MSwxOC4xNDEgOS41MiwxOS4wMjMgOS40NzcsMTkuMjAzIEM5LjQyLDE5LjQ0IDkuMjg4LDE5LjQ5MSA5LjA0LDE5LjM3NiBDNy40MDgsMTguNjIyIDYuMzg3LDE2LjI1MiA2LjM4NywxNC4zNDkgQzYuMzg3LDEwLjI1NiA5LjM4Myw2LjQ5NyAxNS4wMjIsNi40OTcgQzE5LjU1NSw2LjQ5NyAyMy4wNzgsOS43MDUgMjMuMDc4LDEzLjk5MSBDMjMuMDc4LDE4LjQ2MyAyMC4yMzksMjIuMDYyIDE2LjI5NywyMi4wNjIgQzE0Ljk3MywyMi4wNjIgMTMuNzI4LDIxLjM3OSAxMy4zMDIsMjAuNTcyIEMxMy4zMDIsMjAuNTcyIDEyLjY0NywyMy4wNSAxMi40ODgsMjMuNjU3IEMxMi4xOTMsMjQuNzg0IDExLjM5NiwyNi4xOTYgMTAuODYzLDI3LjA1OCBDMTIuMDg2LDI3LjQzNCAxMy4zODYsMjcuNjM3IDE0LjczMywyNy42MzcgQzIxLjk1LDI3LjYzNyAyNy44MDEsMjEuODI4IDI3LjgwMSwxNC42NjIgQzI3LjgwMSw3LjQ5NSAyMS45NSwxLjY4NiAxNC43MzMsMS42ODYiIGZpbGw9IiMxMTEiPjwvcGF0aD48L2c+PC9zdmc+">
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
                                                <form data-view="purchaseForm" data-google-analytics-page="itemPage" data-google-analytics-payload="{&quot;actionData&quot;:null,&quot;productsArray&quot;:[{&quot;id&quot;:29900946,&quot;name&quot;:&quot;Dj Flyer&quot;,&quot;brand&quot;:&quot;Hotpin&quot;,&quot;category&quot;:&quot;Wakay.net/print-templates/flyers/events&quot;,&quot;quantity&quot;:&quot;1&quot;}],&quot;timestamp&quot;:1611619309}" action="/cart/add/29900946" accept-charset="UTF-8" method="post">
                                                    <p class="t-body -size-s" itemprop="description">
                                                        {{ __('product.product_description') }}
                                                        <!-- The size of this template is {{ $template->width }}x{{ $template->height }}{{ $template->measureUnits }}. Click “Use This Template“, start your own design. Then you can change the text and images as you wish. After that, preview and save your work, your design will be ready to print, share or download. -->
                                                    </p>
                                                    <div class="purchase-form__button">
                                                        <a class="js-purchase__add-to-cart e-btn--3d -color-primary -size-m -width-full"
                                                            href="{{ 
                                                            route('editor.openTemplate',[
                                                                'country' => $country,
                                                                'template_key' => $template->_id
                                                            ] )
                                                        }}" target="_blank">
                                                            <strong>{{ __('product.use_this_template') }}</strong>
                                                        </a>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="item-preview__preview-buttons--social" data-view="socialButtons">
                                                <div class="btn-group">
                                                    <!-- <div class="btn btn--label btn--group-item">Share</div> -->
                                                    <a class="btn btn--group-item fb" data-social-network="Facebook" data-social-network-link="" href="https://www.facebook.com/sharer/sharer.php?display=popup&u={{ urlencode(URL::current().'?utm_source=sharepi') }}">
                                                        <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yr/r/zSKZHMh8mXU.png">
                                                    </a>
                                                    <a class="btn btn--group-item tw" data-social-network="Twitter" data-social-network-link="" href="https://twitter.com/intent/tweet?text={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}&url={{ urlencode(URL::current().'?utm_source=sharetw') }}">
                                                        <img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2072%2072%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h72v72H0z%22%2F%3E%3Cpath%20class%3D%22icon%22%20fill%3D%22%23fff%22%20d%3D%22M68.812%2015.14c-2.348%201.04-4.87%201.744-7.52%202.06%202.704-1.62%204.78-4.186%205.757-7.243-2.53%201.5-5.33%202.592-8.314%203.176C56.35%2010.59%2052.948%209%2049.182%209c-7.23%200-13.092%205.86-13.092%2013.093%200%201.026.118%202.02.338%202.98C25.543%2024.527%2015.9%2019.318%209.44%2011.396c-1.125%201.936-1.77%204.184-1.77%206.58%200%204.543%202.312%208.552%205.824%2010.9-2.146-.07-4.165-.658-5.93-1.64-.002.056-.002.11-.002.163%200%206.345%204.513%2011.638%2010.504%2012.84-1.1.298-2.256.457-3.45.457-.845%200-1.666-.078-2.464-.23%201.667%205.2%206.5%208.985%2012.23%209.09-4.482%203.51-10.13%205.605-16.26%205.605-1.055%200-2.096-.06-3.122-.184%205.794%203.717%2012.676%205.882%2020.067%205.882%2024.083%200%2037.25-19.95%2037.25-37.25%200-.565-.013-1.133-.038-1.693%202.558-1.847%204.778-4.15%206.532-6.774z%22%2F%3E%3C%2Fsvg%3E">
                                                    </a>
                                                    <a class="btn btn--group-item pi" data-social-network="Pinterest" data-social-network-link="" href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(URL::current().'?utm_source=sharepi') }}&media={{ $preview_image }}&description={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}">
                                                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiPjwvcGF0aD48cGF0aCBkPSJNMTQuNzMzLDEuNjg2IEM3LjUxNiwxLjY4NiAxLjY2NSw3LjQ5NSAxLjY2NSwxNC42NjIgQzEuNjY1LDIwLjE1OSA1LjEwOSwyNC44NTQgOS45NywyNi43NDQgQzkuODU2LDI1LjcxOCA5Ljc1MywyNC4xNDMgMTAuMDE2LDIzLjAyMiBDMTAuMjUzLDIyLjAxIDExLjU0OCwxNi41NzIgMTEuNTQ4LDE2LjU3MiBDMTEuNTQ4LDE2LjU3MiAxMS4xNTcsMTUuNzk1IDExLjE1NywxNC42NDYgQzExLjE1NywxMi44NDIgMTIuMjExLDExLjQ5NSAxMy41MjIsMTEuNDk1IEMxNC42MzcsMTEuNDk1IDE1LjE3NSwxMi4zMjYgMTUuMTc1LDEzLjMyMyBDMTUuMTc1LDE0LjQzNiAxNC40NjIsMTYuMSAxNC4wOTMsMTcuNjQzIEMxMy43ODUsMTguOTM1IDE0Ljc0NSwxOS45ODggMTYuMDI4LDE5Ljk4OCBDMTguMzUxLDE5Ljk4OCAyMC4xMzYsMTcuNTU2IDIwLjEzNiwxNC4wNDYgQzIwLjEzNiwxMC45MzkgMTcuODg4LDguNzY3IDE0LjY3OCw4Ljc2NyBDMTAuOTU5LDguNzY3IDguNzc3LDExLjUzNiA4Ljc3NywxNC4zOTggQzguNzc3LDE1LjUxMyA5LjIxLDE2LjcwOSA5Ljc0OSwxNy4zNTkgQzkuODU2LDE3LjQ4OCA5Ljg3MiwxNy42IDkuODQsMTcuNzMxIEM5Ljc0MSwxOC4xNDEgOS41MiwxOS4wMjMgOS40NzcsMTkuMjAzIEM5LjQyLDE5LjQ0IDkuMjg4LDE5LjQ5MSA5LjA0LDE5LjM3NiBDNy40MDgsMTguNjIyIDYuMzg3LDE2LjI1MiA2LjM4NywxNC4zNDkgQzYuMzg3LDEwLjI1NiA5LjM4Myw2LjQ5NyAxNS4wMjIsNi40OTcgQzE5LjU1NSw2LjQ5NyAyMy4wNzgsOS43MDUgMjMuMDc4LDEzLjk5MSBDMjMuMDc4LDE4LjQ2MyAyMC4yMzksMjIuMDYyIDE2LjI5NywyMi4wNjIgQzE0Ljk3MywyMi4wNjIgMTMuNzI4LDIxLjM3OSAxMy4zMDIsMjAuNTcyIEMxMy4zMDIsMjAuNTcyIDEyLjY0NywyMy4wNSAxMi40ODgsMjMuNjU3IEMxMi4xOTMsMjQuNzg0IDExLjM5NiwyNi4xOTYgMTAuODYzLDI3LjA1OCBDMTIuMDg2LDI3LjQzNCAxMy4zODYsMjcuNjM3IDE0LjczMywyNy42MzcgQzIxLjk1LDI3LjYzNyAyNy44MDEsMjEuODI4IDI3LjgwMSwxNC42NjIgQzI3LjgwMSw3LjQ5NSAyMS45NSwxLjY4NiAxNC43MzMsMS42ODYiIGZpbGw9IiMxMTEiPjwvcGF0aD48L2c+PC9zdmc+">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box -radius-all">
                                        <div class="rating-detailed--has-no-ratings">
                                            <strong>{{ __('product.item_rating') }}</strong> &nbsp;&nbsp;<span>{{ __('product.minimum_votes') }}</span>
                                            <div itemprop="aggregateRating"
                                                itemscope itemtype="https://schema.org/AggregateRating"
                                                style="display:none">
                                                Rated <span itemprop="ratingValue">5</span>/5
                                                based on <span itemprop="reviewCount">1</span> customer reviews
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
                                                                {{ $breadcrumb->name }}
                                                            <!-- </a> -->
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
                                                    <li class="Gu5L1Q" style="background-color: {{ $hex_color }};"><div class="_-pFsfA">{{ $hex_color }}</div></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="is-hidden-phone">
                        <div id="tooltip-magnifier" class="magnifier">
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="landscape-image-magnifier" class="magnifier">
                            <div class="size-limiter">
                            </div>
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="portrait-image-magnifier" class="magnifier">
                            <div class="size-limiter">
                            </div>
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="square-image-magnifier" class="magnifier" style="top: 2376px; left: 619.5px; display: none;">
                            <div class="size-limiter"><img src="{{ asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] ) }}"></div>
                            <strong>{{ $template->title }}</strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author">Hotpin</span>
                                </div>
                                <div class="price">
                                    <span class="cost"><sup>$</sup>7</span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category">Print Templates / Flyers / Church</span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="smart-image-magnifier" class="magnifier">
                            <div class="size-limiter">
                            </div>
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="video-magnifier" class="magnifier">
                            <div class="size-limiter">
                                <div class="faux-player is-hidden"><img></div>
                                <div>
                                    <div id="hover-video-preview"></div>
                                </div>
                            </div>
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
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
        <div id="js-customer-satisfaction-popup" class="survey-popup is-visually-hidden">
            <div class="h-text-align-right"><a href="#" id="js-popup-close-button" class="e-alert-box__dismiss-icon"><i class="e-icon -icon-cancel"></i></a></div>
            <div class="survey-popup--section">
                <h2 class="t-heading h-text-align-center -size-m">Tell us what you think!</h2>
                <p>We'd like to ask you a few questions to help improve Wakay.</p>
            </div>
            <div class="survey-popup--section">
                <a href="#" id="js-show-survey-button" class="e-btn -color-primary -size-m -width-full js-survey-popup--show-survey-button">Sure, take me to the survey</a>
            </div>
        </div>
        <div id="affiliate-tracker" class="is-hidden" data-view="affiliatesTracker" data-cookiebot-enabled="true"></div>
@endsection