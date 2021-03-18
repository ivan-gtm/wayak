@extends('layouts.frontend')

@section('title', 'Results for: "'.$search_query.'"| Search | Wayak')
    
    @section('meta')
        <link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
        
        <meta data-rh="true" charset="UTF-8">
        <meta data-rh="true" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <meta data-rh="true" name="google-site-verification" content="">
        <meta data-rh="true" name="apple-itunes-app" content="">
        <meta data-rh="true" name="google" content="no-translate">
    @endsection

@section('content')
    
    <div id="react-view">
        <div class="mainView notificationVisible headerVisible" id="app-view">
            <div class="scrollableView___3-vpm notificationVisible">
                <div class="routeWrapper___26Hc9">
                    <div class="routeContent___pkfmU">
                        <div class="wrapper___2hP9G hasPagination">
                            <div>
                                <div class="search-header">
                                    <div class="search-form-wrapper">
                                        <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('user.search',['country' => $country, 'page' => $page]) }}">
                                            @csrf
                                            <div class="sc-dmlrTW guKkvw">
                                                <input type="text" autocomplete="off" name="searchQuery" class="sc-kfzAmx sc-fKFyDc fTLfYv fYNCUl proxima-regular___3FDdY clearButtonVisible___qtH0n" placeholder="Busca entre miles de formatos y diseños" style="padding-left: 20px;" value="{{ $search_query }}">
                                            </div>
                                            <div class="inputControls___BVQJr left___1UDlV"></div>
                                            <div class="inputControls___BVQJr right___3zI72">
                                                <a class="sc-eCssSg sc-jSgupP cvSgtG eYItKN typography-subheading-m clearBtn___OIzx7" href="{{ route('user.search',['country' => $country]) }}">
                                                    <svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY"><path d="M18.8274 17.1818C18.9379 17.2914 19 17.4405 19 17.5961C19 17.7517 18.9379 17.9009 18.8274 18.0104L18.0104 18.8274C17.9009 18.9379 17.7517 19 17.5961 19C17.4405 19 17.2914 18.9379 17.1818 18.8274L12 13.6456L6.81819 18.8274C6.70862 18.9379 6.55947 19 6.40387 19C6.24828 19 6.09913 18.9379 5.98956 18.8274L5.17261 18.0104C5.06214 17.9009 5 17.7517 5 17.5961C5 17.4405 5.06214 17.2914 5.17261 17.1818L10.3544 12L5.17261 6.81819C5.06214 6.70862 5 6.55947 5 6.40387C5 6.24828 5.06214 6.09913 5.17261 5.98956L5.98956 5.17261C6.09913 5.06214 6.24828 5 6.40387 5C6.55947 5 6.70862 5.06214 6.81819 5.17261L12 10.3544L17.1818 5.17261C17.2914 5.06214 17.4405 5 17.5961 5C17.7517 5 17.9009 5.06214 18.0104 5.17261L18.8274 5.98956C18.9379 6.09913 19 6.24828 19 6.40387C19 6.55947 18.9379 6.70862 18.8274 6.81819L13.6456 12L18.8274 17.1818Z"></path></svg>
                                                </a>
                                                <button type="submit" class="bhdLno llxIqU searchBtn___3JEWS" data-categ="homeSearchForm" data-value="submit">
                                                    <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.4138 15.8368L21.8574 20.2857C22.0558 20.5064 22.046 20.8443 21.8352 21.0532L21.0575 21.8317C20.9532 21.937 20.8113 21.9962 20.6632 21.9962C20.5151 21.9962 20.3731 21.937 20.2688 21.8317L15.8252 17.3828C15.7023 17.2596 15.5907 17.1256 15.4919 16.9824L14.6587 15.8701C13.2802 16.9723 11.5682 17.5724 9.80409 17.5719C6.16878 17.5845 3.00983 15.0738 2.19744 11.5261C1.38504 7.97844 3.13601 4.34066 6.41372 2.76643C9.69143 1.1922 13.6211 2.10166 15.8763 4.95639C18.1314 7.81111 18.1102 11.8492 15.8252 14.68L16.9361 15.4475C17.1096 15.5586 17.2698 15.6892 17.4138 15.8368ZM4.24951 9.78627C4.24951 12.8576 6.73635 15.3475 9.80402 15.3475C11.2772 15.3475 12.69 14.7616 13.7317 13.7186C14.7733 12.6757 15.3585 11.2612 15.3585 9.78627C15.3585 6.7149 12.8717 4.22507 9.80402 4.22507C6.73635 4.22507 4.24951 6.7149 4.24951 9.78627Z"></path></svg></div>
                                                </button>
                                            </div>
                                        </form>
                                        <div></div>
                                    </div>
                                    <div class="pagination top">
                                        <div class="typography-marketing-display-s title___3sRwO">Plantillas de "{{ $search_query }}"</div>
                                        <div class="paginationWrapper"><span class="typography-body-m paginationRange">{{ $from_document }}-{{ $to_document }} de {{ $total_documents }}</span>
                                            <div class="paginationWrapper">
                                                <a class="bhdLno lhRPKu button___33J2d" href="{{ route('user.search',['page' => ($page-1), 'country' => $country, 'searchQuery' => $search_query]) }}">
                                                    <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 16 16" width="16" height="16" direction="left" class="sc-fubCfw ecgval"><path d="M14.463 4.11761C14.5381 4.04234 14.6403 4 14.747 4C14.8536 4 14.9558 4.04234 15.0309 4.11761L15.8788 4.96052C15.9561 5.03267 16 5.13341 16 5.23884C16 5.34427 15.9561 5.44501 15.8788 5.51716L8.52792 12.8251C8.41552 12.9369 8.26304 12.9999 8.10398 13H7.89602C7.73696 12.9999 7.58448 12.9369 7.47208 12.8251L0.121197 5.51716C0.0438665 5.44501 0 5.34427 0 5.23884C0 5.13341 0.0438665 5.03267 0.121197 4.96052L0.969068 4.11761C1.04416 4.04234 1.14639 4 1.25302 4C1.35966 4 1.46189 4.04234 1.53698 4.11761L8 10.5428L14.463 4.11761Z"></path></svg></div>
                                                </a>
                                                <div class="sc-dmlrTW guKkvw">
                                                    <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('user.search',['country' => $country]) }}">
                                                        @csrf
                                                        <input type="text" class="sc-kfzAmx sc-fKFyDc fTLfYv ikXwLi pageInput___1mj0B" value="{{ $page }}">
                                                    </form>
                                                </div>
                                                <a class="bhdLno lhRPKu button___33J2d" href="{{ route('user.search',['page' => ($page+1), 'country' => $country, 'searchQuery' => $search_query]) }}">
                                                    <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 16 16" width="16" height="16" direction="right" class="sc-fubCfw cnhfsE"><path d="M14.463 4.11761C14.5381 4.04234 14.6403 4 14.747 4C14.8536 4 14.9558 4.04234 15.0309 4.11761L15.8788 4.96052C15.9561 5.03267 16 5.13341 16 5.23884C16 5.34427 15.9561 5.44501 15.8788 5.51716L8.52792 12.8251C8.41552 12.9369 8.26304 12.9999 8.10398 13H7.89602C7.73696 12.9999 7.58448 12.9369 7.47208 12.8251L0.121197 5.51716C0.0438665 5.44501 0 5.34427 0 5.23884C0 5.13341 0.0438665 5.03267 0.121197 4.96052L0.969068 4.11761C1.04416 4.04234 1.14639 4 1.25302 4C1.35966 4 1.46189 4.04234 1.53698 4.11761L8 10.5428L14.463 4.11761Z"></path></svg>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="content ratioMultiFormats contentLastRowFix">
                                        @foreach ($templates as $template )
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="{{ 
                                                route( 'admin.edit.template',[
                                                'language_code' => $language_code,
                                                'template_key' => $template->_id
                                                ] )
                                            }}" style="width: calc(var(--row-height) * 0.714286); flex-grow: 7.14286;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 140%;">
                                                <img alt="{{ $template->title }}" crossorigin="anonymous" loading="lazy" data-categ="invitations" data-value="{{ $template->_id }}" 
                                                    src="{{ asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] ) }}"
                                                    class="itemImg">
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">{{ $template->title }}</div>
                                            </div>
                                        </a>
                                        @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="containerBottom">
                                <div class="pagination bottom___2OkNp">
                                    <!-- <a class="bhdLno iISRbV nextPageButton___rOiwa" href="{{ route('user.search',['page' => ($page+1), 'country' => $country, 'searchQuery' => $search_query]) }}">
                                        <div class="sc-hKgILt chrFRV">Página siguiente</div>
                                    </a> -->
                                    <div class="paginationWrapper"><span class="typography-body-m paginationRange">{{ $from_document }}-{{ $to_document }} de {{ $total_documents }}</span>
                                        <div class="paginationWrapper">
                                            <a class="bhdLno lhRPKu button___33J2d">
                                                <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 16 16" width="16" height="16" direction="left" class="sc-fubCfw ecgval"><path d="M14.463 4.11761C14.5381 4.04234 14.6403 4 14.747 4C14.8536 4 14.9558 4.04234 15.0309 4.11761L15.8788 4.96052C15.9561 5.03267 16 5.13341 16 5.23884C16 5.34427 15.9561 5.44501 15.8788 5.51716L8.52792 12.8251C8.41552 12.9369 8.26304 12.9999 8.10398 13H7.89602C7.73696 12.9999 7.58448 12.9369 7.47208 12.8251L0.121197 5.51716C0.0438665 5.44501 0 5.34427 0 5.23884C0 5.13341 0.0438665 5.03267 0.121197 4.96052L0.969068 4.11761C1.04416 4.04234 1.14639 4 1.25302 4C1.35966 4 1.46189 4.04234 1.53698 4.11761L8 10.5428L14.463 4.11761Z"></path></svg></div>
                                            </a>
                                            <div class="sc-dmlrTW guKkvw">
                                                <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('user.search',['country' => $country]) }}">
                                                    @csrf
                                                    <input type="text" class="sc-kfzAmx sc-fKFyDc fTLfYv ikXwLi pageInput___1mj0B" name="page" value="{{ $page }}">
                                                </form>
                                            </div>
                                            <a class="bhdLno lhRPKu button___33J2d" href="{{ route('user.search',['page' => ($page+1), 'country' => $country, 'searchQuery' => $search_query]) }}">
                                                <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 16 16" width="16" height="16" direction="right" class="sc-fubCfw cnhfsE"><path d="M14.463 4.11761C14.5381 4.04234 14.6403 4 14.747 4C14.8536 4 14.9558 4.04234 15.0309 4.11761L15.8788 4.96052C15.9561 5.03267 16 5.13341 16 5.23884C16 5.34427 15.9561 5.44501 15.8788 5.51716L8.52792 12.8251C8.41552 12.9369 8.26304 12.9999 8.10398 13H7.89602C7.73696 12.9999 7.58448 12.9369 7.47208 12.8251L0.121197 5.51716C0.0438665 5.44501 0 5.34427 0 5.23884C0 5.13341 0.0438665 5.03267 0.121197 4.96052L0.969068 4.11761C1.04416 4.04234 1.14639 4 1.25302 4C1.35966 4 1.46189 4.04234 1.53698 4.11761L8 10.5428L14.463 4.11761Z"></path></svg></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div></div>
        </div>
    </div>
    <!-- <meta name="google-site-verification" content=""> -->
    <!-- <div style="width:0px; height:0px; display:none; visibility:hidden;" id="batBeacon183254530036"><img style="width:0px; height:0px; display:none; visibility:hidden;" id="batBeacon966510314538" width="0" height="0" alt="" src="https://bat.bing.com/action/0?ti=56305916&amp;Ver=2&amp;mid=7e47ba01-f86d-43df-bc0c-a54ea92a35bb&amp;sid=95ffe9405a8d11eb89bc47deb50efd0b&amp;vid=f245ec70512611eb90d0a310eac65bd9&amp;vids=0&amp;pi=1200101525&amp;lg=es&amp;sw=1920&amp;sh=1080&amp;sc=24&amp;tl=Crello&amp;p=https%3A%2F%2Fcrello.com%2Fmx%2Fhome%2F&amp;r=&amp;evt=pageLoad&amp;msclkid=N&amp;sv=1&amp;rn=102539"></div> -->

@endsection