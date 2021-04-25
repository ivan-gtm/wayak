@extends('layouts.frontend')

@section('title', 'Free Templates & Online Graphic Editor | WAYAK')

@section('content')
		<div id="appMountPoint">
            <div class="netflix-sans-font-loaded">
				<div dir="ltr" class="">
					<div>
						<div class="bd dark-background" lang="en-MX" data-uia="container-adult">
							<!-- <div class="pinning-header">
								<div class="pinning-header-container" style="top: 0px; position: relative; background: transparent;">
								</div>
							</div> -->
							<div class="mainView" role="main">
                                
								<div class="lolomo is-fullbleed">
                                    
                                    <div class="lolomoRow lolomoRow_title_card ltr-0" data-list-context="categories" style="margin-top: 4vw;">
                                        <div class="heroWrapper___2WxOZ">
                                            <div class="bannerContainer___Y4ecx">
                                                <div class="banner___3K0N2"></div>
                                            </div>
                                            <p class="fugue-regular___3IC2i fugue-h3___3pmEB title___3smO3">Design whatever you want</p>
                                            <div class="searchWrapper___ktY0d">
                                                <div class="searchFormWrapper___2LC5i">
                                                    <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('user.search',['country' => $country]) }}">
														@csrf
														<div class="sc-dmlrTW guKkvw">
															<input type="text" autocomplete="off" name="searchQuery" class="sc-kfzAmx sc-fKFyDc fTLfYv zomHz proxima-regular___3FDdY" placeholder="Search from thousands of formats and designs" value="" style="padding-left: 20px;">
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
                                    
									@foreach ($carousels as $carousel)
                                        <div class="lolomoRow lolomoRow_title_card ltr-0 template-carousel" data-list-context="similars">
                                            <h2 class="rowHeader ltr-0">
                                                <a aria-label="because you watched taco chronicles" class="rowTitle ltr-0" 
                                                    href="/browse/similars/81040704">
                                                    <span class="row-header-title">
                                                        {{ $carousel->title }}
                                                    </span>
                                                    <span class="aro-row-header">
                                                        <span class="see-all-link">Explore All</span>
                                                        <span class="aro-row-chevron icon-akiraCaretRight"></span>
                                                    </span>
                                                </a>
                                            </h2>
                                            <div class="rowContainer rowContainer_title_card" id="{{ $carousel->slider_id }}">
                                                <div class="ptrack-container">
                                                    <div class="rowContent slider-hover-trigger-layer">
                                                        <div class="slider">
                                                            <span class="handle handlePrev active" tabindex="0" role="button" aria-label="See previous titles">
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
                                                                                                'slug' => $template->slug
                                                                                            ] )
                                                                                        }}">
                                                                                            <div class="boxart-size-16x9 boxart-container boxart-rounded">
                                                                                                <img class="boxart-image boxart-image-in-padded-container" 
                                                                                                    loading=lazy
                                                                                                    src="{{ $template->preview_image_url }}"
                                                                                                    alt="{{ $template->title }}">
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

                    $.each(sliders_content, function(i,slider) {
                        var id = $(slider).attr('data-slider-id');
                        
                        console.log("NEW SLIDER");
                        console.log( '#'+ id +' > div > div > div > span.handle.handlePrev' );
                        
                        $(slider).slick({
                            lazyLoad: 'ondemand',
                            // variableWidth: true,
                            slidesToShow: 6,
                            slidesToScroll: 4,
                            dots: true,
                            appendDots: $('#'+ id +' > div > div > div > div.dotClass'),
                            dotsClass: 'pagination-indicator',
                            // infinite: true,
                            prevArrow: $('#'+ id +' > div > div > div > span.handle.handlePrev'),
                            nextArrow: $('#'+ id +' > div > div > div > span.handle.handleNext'),
                            responsive: [
                                {
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
            </script>
@endsection
