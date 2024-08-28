@extends('layouts.frontend')

@section('title', __('home.title'))

@section('meta')
    <meta name="description" content="{{ __('home.meta_description') }}" />
    <meta name="title" content="{{ __('home.meta_title') }}" />
    <meta name="keywords" content="{{ __('home.meta_keywords') }}" />
@endsection
@section('css')
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/home.css') }}" media="all" preload>
    <style>
        .category.slider .sliderMask .sliderContent .slider-item {
            color: #303538;
            text-align: center;
            /* max-width: none; */
            padding: 0;
            margin: 0;
            padding-top: 15px;
        }

        .category.slider .sliderMask .sliderContent .slider-item h3 {
            color: #303538;
            text-align: center;
            max-width: none;
        }

        .category.slider .sliderMask .sliderContent .slider-item img {
            /* width:120px; */
            /* display:block; */
            margin: auto;
            height: auto;
        }

        @media screen and (min-width:1000px) {
            .category.slider .sliderMask .sliderContent .slider-item img {
                width: 70%;
            }
        }
    </style>
@endsection

@section('content')
    <div id="appMountPoint">
        <div class="netflix-sans-font-loaded">
            <div dir="ltr" class="">
                <div>
                    <div class="bd dark-background" lang="en-MX" data-uia="container-adult">
                        <div class="mainView" role="main">
                            <div class="lolomo is-fullbleed">
                                <div class="lolomoRow lolomoRow_title_card ltr-0" data-list-context="categories" style="margin-top: 4vw;">
                                    <div class="heroWrapper___2WxOZ">
                                        <div class="bannerContainer___Y4ecx">
                                            <div class="banner___3K0N2"></div>
                                        </div>
                                        <p class="fugue-regular___3IC2i fugue-h3___3pmEB title___3smO3">{{ __('home.hero') }}</p>
                                        <div class="searchWrapper___ktY0d">
                                            <div class="searchFormWrapper___2LC5i">
                                                <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('user.search',['country' => $country]) }}">
                                                    @csrf
                                                    <input type="hidden" id="heroCustomerId" name="customerId">
                                                    <div class="sc-dmlrTW guKkvw">
                                                        <input type="text" autocomplete="off" name="searchQuery" class="sc-kfzAmx sc-fKFyDc fTLfYv zomHz proxima-regular___3FDdY" placeholder="{{ __('home.search_placeholder') }}" value="" style="padding-left: 20px;">
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
                                        </div>
                                    </div>
                                </div>

                                <div class="lolomoRow lolomoRow_title_card ltr-0 template-carousel" data-list-context="similars">
                                    <h2 class="rowHeader ltr-0">
                                        <a class="rowTitle ltr-0" href="http://localhost:8001/us/search?searchQuery=baby%20shower">
                                            <span class="row-header-title">
                                                Browse Trending Categories
                                            </span>
                                            <!-- <span class="aro-row-header">
                                                <span class="see-all-link">Explore All</span>
                                                <span class="aro-row-chevron icon-akiraCaretRight"></span>
                                            </span> -->
                                        </a>
                                    </h2>
                                    <div class="rowContainer rowContainer_title_card" id="k9Qvisdas">
                                        <div class="ptrack-container">
                                            <div class="rowContent slider-hover-trigger-layer">
                                                <div class="category slider">
                                                    <span class="handle handlePrev active slick-arrow" tabindex="0" role="button" aria-label="See previous titles" style="display: flex;">
                                                        <b class="indicator-icon icon-leftCaret"></b>
                                                    </span>
                                                    <div class="dotClass"></div>
                                                    <div class="sliderMask showPeek">
                                                        <div class="sliderContent row-with-x-columns" data-slider-id="k9Qvisdas">
                                                            @for($i = 0; $i < sizeof($menu->templates); $i++)
                                                                <div class="slider-item slider-item-">
                                                                    <div class="title-card-container ltr-0">
                                                                        <div class="slider-refocus title-card">
                                                                            <div class="ptrack-content">
                                                                                <a href="{{ $menu->templates[$i]->url }}" data-cta-track="Display Fonts">
                                                                                    <span class=" lazyloaded" data-responsive="true">
                                                                                        <picture>
                                                                                            <source media="(min-width: 450px)" data-srcset="{{ asset('categories/en/'.$menu->templates[$i]->img) }} 1x, {{ asset('categories/en/'.$menu->templates[$i]->img) }} 2x" type="image/webp" srcset="{{ asset('categories/en/'.$menu->templates[$i]->img) }} 1x, {{ asset('categories/en/'.$menu->templates[$i]->img) }} 2x">
                                                                                            <source data-srcset="{{ asset('categories/en/'.$menu->templates[$i]->img) }} 1x, {{ asset('categories/en/'.$menu->templates[$i]->img) }} 2x" type="image/webp" srcset="{{ asset('categories/en/'.$menu->templates[$i]->img) }} 1x, {{ asset('categories/en/'.$menu->templates[$i]->img) }} 2x">
                                                                                            <img src="{{ asset('categories/en/'.$menu->templates[$i]->img) }}" data-src="{{ asset('categories/en/'.$menu->templates[$i]->img) }}" alt="Display Fonts" class=" lazyloaded" height="128" width="139">
                                                                                        </picture>
                                                                                    </span>

                                                                                    <h3>{{ $menu->templates[$i]->name }}</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="bob-container"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <span class="handle handleNext active" tabindex="0" role="button" aria-label="See more titles">
                                                        <b class="indicator-icon icon-rightCaret"></b>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($carousels as $carousel)
                                <div class="lolomoRow lolomoRow_title_card ltr-0 template-carousel" data-list-context="similars">
                                    <h2 class="rowHeader ltr-0">
                                        <a class="rowTitle ltr-0" href="{{ route('user.search',[
                                                            'country' => $country,
                                                            'searchQuery' => $carousel->search_term
                                                        ]) }}">
                                            <span class="row-header-title">
                                                {{ $carousel->title }}
                                            </span>
                                            <span class="aro-row-header">
                                                <span class="see-all-link">{{ __('home.carousel_explore_all') }}</span>
                                                <span class="aro-row-chevron icon-akiraCaretRight"></span>
                                            </span>
                                        </a>
                                    </h2>
                                    <div class="rowContainer rowContainer_title_card" id="{{ $carousel->slider_id }}">
                                        <div class="ptrack-container">
                                            <div class="rowContent slider-hover-trigger-layer">
                                                <div class="slider">
                                                    <span class="handle handlePrev active slick-arrow" tabindex="0" role="button" aria-label="See previous titles">
                                                        <b class="indicator-icon icon-leftCaret"></b>
                                                    </span>
                                                    <div class="dotClass"></div>
                                                    <div class="sliderMask showPeek">
                                                        <div class="sliderContent row-with-x-columns" data-slider-id="{{ $carousel->slider_id }}">
                                                            @foreach ($carousel->items as $template)
                                                            <div class="slider-item slider-item-">
                                                                <div class="title-card-container ltr-0">
                                                                    <div class="slider-refocus title-card">
                                                                        <div class="ptrack-content">
                                                                            <a class="slider-refocus" href="{{ 
                                                                                                route( 'template.productDetail',[
                                                                                                    'country' => $country,
                                                                                                    'coupon' => $coupon,
                                                                                                    'slug' => $template->slug
                                                                                                ] )
                                                                                            }}">
                                                                                <div class="boxart-size-16x9 boxart-container boxart-rounded">
                                                                                    <img class="boxart-image boxart-image-in-padded-container" loading=lazy src="{{ $template->preview_image_url }}" alt="{{ $template->title }}">
                                                                                    <div class="fallback-text-container" aria-hidden="true">
                                                                                        <p class="fallback-text">{{ $template->title }}</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="click-to-change-JAW-indicator">
                                                                                    <div class="bob-jawbone-chevron">
                                                                                        <svg class="svg-icon svg-icon-chevron-down" focusable="true">
                                                                                            <use filter="" xlink:href="#chevron-down"></use>
                                                                                        </svg>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div class="bob-container"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <span class="handle handleNext active" tabindex="0" role="button" aria-label="See more titles">
                                                        <b class="indicator-icon icon-rightCaret"></b>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var sliders_content = $('.sliderContent');

        $.each(sliders_content, function(i, slider) {
            var id = $(slider).attr('data-slider-id');

            // console.log("NEW SLIDER");
            // console.log('#' + id + ' > div > div > div > span.handle.handlePrev');

            $(slider).slick({
                lazyLoad: 'ondemand',
                // variableWidth: true,
                slidesToShow: 6,
                slidesToScroll: 4,
                dots: false,
                appendDots: $('#' + id + ' > div > div > div > div.dotClass'),
                dotsClass: 'pagination-indicator',
                // infinite: true,
                prevArrow: $('#' + id + ' > div > div > div > span.handle.handlePrev'),
                nextArrow: $('#' + id + ' > div > div > div > span.handle.handleNext'),
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ]
            });

        });

    });

    // $(document).ready(function() {
    //     let customerId = getCustomerId();
        
    //     // Function to create HTML for a single slider item
    //     function createSliderItem(item) {
    //         return `
    //             <div class="slider-item">
    //                 <div class="title-card-container">
    //                     <div class="slider-refocus title-card">
    //                         <div class="ptrack-content">
    //                             <a class="slider-refocus" href="http://localhost:8001/us/template/${item.slug}?customerId=${ customerId }">
    //                                 <div class="boxart-size-16x9 boxart-container boxart-rounded">
    //                                     <img class="boxart-image boxart-image-in-padded-container" src="${item.preview_image_url}" alt="${item.title}">
    //                                     <div class="fallback-text-container" aria-hidden="true">
    //                                         <p class="fallback-text">${item.title}</p>
    //                                     </div>
    //                                 </div>
    //                             </a>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>`;
    //     }
    
    //     // Function to create a complete slider
    //     function createSlider(sliderData) {
            
    //         // console.log(sliderData);

    //         let sliderItems = sliderData.items.map(createSliderItem).join('');
    //         return `
    //             <div class="rowContainer rowContainer_title_card" id="${sliderData.slider_id}">
    //                 <div class="ptrack-container">
    //                     <div class="rowContent slider-hover-trigger-layer">
    //                         <div class="slider">
    //                             <span class="handle handlePrev active slick-arrow" tabindex="0" role="button" aria-label="See previous titles">
    //                                 <b class="indicator-icon icon-leftCaret"></b>
    //                             </span>
    //                             <div class="dotClass"></div>
    //                             <div class="sliderMask showPeek">
    //                                 <div class="sliderContent row-with-x-columns" data-slider-id="${sliderData.slider_id}">
    //                                     ${sliderItems}
    //                                 </div>
    //                             </div>
    //                             <span class="handle handleNext active" tabindex="0" role="button" aria-label="See more titles">
    //                                 <b class="indicator-icon icon-rightCaret"></b>
    //                             </span>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>`;
    //     }

    //     // Function to create HTML for a single slider item
    //     function createSliderContainer(searchURL, sliderTitle, sliderData) {
    //         let newSliderHtml = createSlider(sliderData);
    //         return `
    //         <div class="lolomoRow lolomoRow_title_card ltr-0 template-carousel" data-list-context="similars">
    //             <h2 class="rowHeader ltr-0">
    //                 <a class="rowTitle ltr-0" href="${ searchURL }?customerId=${ customerId }">
    //                     <span class="row-header-title">
    //                         ${ sliderTitle }
    //                     </span>
    //                     <span class="aro-row-header">
    //                         <span class="see-all-link">Explore All</span>
    //                         <span class="aro-row-chevron icon-akiraCaretRight"></span>
    //                     </span>
    //                 </a>
    //             </h2>
    //             ${ newSliderHtml }
    //         </div>`;
    //     }
    
    //     // AJAX request to get new sliders
    //     function loadSliders() {
    //         $.ajax({
    //             url: '/us/carousels?customerId='+customerId, // Replace with your API URL
    //             method: 'GET',
    //             dataType: 'json',
    //             success: function(response) {
    //                 // var sliders_content = $('#appMountPoint > div > div > div > div > div > div');
    //                 var sliders_content = $('#appMountPoint > div > div > div > div > div > div > div:nth-child(2)');
    //                 response.forEach(function(sliderData) {
    //                     // // console.log(sliderData);
                        
    //                     let searchURL = '/' + sliderData.search_term;
    //                     let newSliderHtml = createSliderContainer(searchURL, sliderData.title, sliderData);
    //                     // Append the new slider to the body or a specific div
    //                     // console.log("Append the new slider to the body or a specific div");
                        
    //                     // // console.log(newSliderHtml);
                        
    //                     $(sliders_content).append(newSliderHtml);
                        
    //                     // Reinitialize slick on the new slider
    //                     $(`[data-slider-id="${sliderData.slider_id}"]`).slick({
    //                         lazyLoad: 'ondemand',
    //                         // variableWidth: true,
    //                         slidesToShow: 6,
    //                         slidesToScroll: 4,
    //                         dots: false,
    //                         appendDots: $('#' + sliderData.slider_id + ' > div > div > div > div.dotClass'),
    //                         dotsClass: 'pagination-indicator',
    //                         // infinite: true,
    //                         prevArrow: $('#' + sliderData.slider_id + ' > div > div > div > span.handle.handlePrev'),
    //                         nextArrow: $('#' + sliderData.slider_id + ' > div > div > div > span.handle.handleNext'),
    //                         responsive: [{
    //                                 breakpoint: 1024,
    //                                 settings: {
    //                                     slidesToShow: 4,
    //                                     slidesToScroll: 4
    //                                 }
    //                             },
    //                             {
    //                                 breakpoint: 600,
    //                                 settings: {
    //                                     slidesToShow: 3,
    //                                     slidesToScroll: 3
    //                                 }
    //                             },
    //                             {
    //                                 breakpoint: 480,
    //                                 settings: {
    //                                     slidesToShow: 2,
    //                                     slidesToScroll: 2
    //                                 }
    //                             }
    //                         ]
    //                     });
    //                 });
    //             },
    //             error: function(error) {
    //                 // console.log('Error loading sliders:', error);
    //             }
    //         });
    //     }
    
    //     // Load sliders when document is ready
    //     loadSliders();
    // });    
</script>
@endsection