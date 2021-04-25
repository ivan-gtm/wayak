<!DOCTYPE html>
<html lang="en-US">
	<head>
        <title>@yield('title')</title>
        
        @yield('meta')
        
        <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
        @yield('css')

	</head>
	<body class="page-template-default page page-id-5380 lang-en page-menus webp wpb-js-composer js-comp-ver-6.1 vc_responsive loaded">
        <header>

            <nav class="navbar -nomargin" id="nav">
                <div class="logo-container">
                    <a id="logo" href="{{ url('') }}" title="Go to the home page" class="embedded-remove-url">
                        <div class="logo-wrapper">
                            <img class="logo-img" src="{{ url('assets/img/logo.png') }}" alt="Wayak Logo" /> 
                        </div>
                    </a>
                </div>
                <div class="primary-nav visible-small-laptop visible-desktop" id="nav-primary-items">
                    <div class="nav-item-container hide-for-student">
                        <a class="nav-item" href="{{ url('') }}">Home</a>
                    </div>
                    <div class="nav-item-container hide-for-student"> 
                        <a class="nav-item" href="javascript:void(0);">Templates <i class="nav-item-icon icon-caret-down"></i></a>
                        <div class="dropdown-list">
                            <div class="list-container">
                                <ul class="list" id="nav-sizes-list">
                                    @for($i = 0; $i < sizeof($menu->templates) / 3; $i++)
                                        <li class="list-item ">
                                            <a class="item" href="{{ str_replace('localhost','localhost:8001',$menu->templates[$i]->url) }}">
                                                {{ $menu->templates[$i]->name }}
                                            </a>
                                        </li>
                                    @endfor
                                    <!-- <li class="list-item">
                                        <a class="item cta animate-icon" href="https://wayak.app/index.php/posters/sizes?utm_source=nav&utm_content=viewallsizes&utm_medium=link&utm_campaign=templategallerynav">
                                            View All <i class="icon-to-animate icon-caret-right"></i>
                                        </a>
                                    </li> -->
                                </ul>
                                <ul class="list">
                                    @for($i = (sizeof($menu->templates) / 3)+1; $i < ((sizeof($menu->templates) / 3) * 2)+1; $i++)
                                        <li class="list-item ">
                                            <a class="item" href="{{ str_replace('localhost','localhost:8001',$menu->templates[$i]->url) }}">
                                                {{ $menu->templates[$i]->name }}
                                            </a>
                                        </li>
                                    @endfor
                                    <!-- <li class="list-item"><a class="item cta animate-icon" href="https://wayak.app/index.php/posters/gallery?utm_source=nav&utm_content=viewalltheme&utm_medium=link&utm_campaign=templategallerynav">View All <i class="icon-caret-right icon-to-animate"></i></a></li> -->
                                </ul>
                                <ul class="list">
                                    @for($i = ((sizeof($menu->templates) / 3)*2)+1; $i < sizeof($menu->templates); $i++)
                                        <li class="list-item ">
                                            <a class="item" href="{{ str_replace('localhost','localhost:8001',$menu->templates[$i]->url) }}">
                                                {{ $menu->templates[$i]->name }}
                                            </a>
                                        </li>
                                    @endfor
                                    <!-- <li class="list-item"><a class="item cta animate-icon" href="https://wayak.app/index.php/posters/gallery?utm_source=nav&utm_content=viewalltheme&utm_medium=link&utm_campaign=templategallerynav">View All <i class="icon-caret-right icon-to-animate"></i></a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    {{--
                    <div class="nav-item-container" id="marketing-nav-item"> <a class="nav-item" href="javascript:void(0);" title="Promote">By Industry <i class="nav-item-icon icon-caret-down"></i></a>
                        <div class="dropdown-list">
                            <div class="list-container">
                                <ul class="list">
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/events?utm_source=nav&utm_content=m/events&utm_medium=link&utm_campaign=marketingnav">Event</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/small-business?utm_source=nav&utm_content=m/small-business&utm_medium=link&utm_campaign=marketingnav">Small business</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/church?utm_source=nav&utm_content=m/church&utm_medium=link&utm_campaign=marketingnav">Church</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/restaurants?utm_source=nav&utm_content=m/restaurants&utm_medium=link&utm_campaign=marketingnav">Restaurant</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/schools?utm_source=nav&utm_content=m/schools&utm_medium=link&utm_campaign=marketingnav">School</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/bands?utm_source=nav&utm_content=m/bands&utm_medium=link&utm_campaign=marketingnav">Band</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/real-estate?utm_source=nav&utm_content=m/real-estate&utm_medium=link&utm_campaign=marketingnav">Real Estate</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    --}}
                </div>
                <div class="user-options">
                    <form action="{{ route('user.search',['country' => $country]) }}" class="inline-search-form" 
                        name="nav-search-form" id="nav-search-form" method="GET" 
                        onclick="document.getElementById('nav-search-input').focus();" accept-charset="utf-8">
                        @csrf
                        <label for="nav-search-input" class="_hidden">Search for inspiration</label>
                        <input class="search-input" name="searchQuery" type="text" id="nav-search-input" aria-label="Search for inspiration" placeholder="Try &lsquo;Wedding Invitation&rsquo;" value="{{ $search_query }}" />
                        <i class="search-submit icon-search" onclick="document.forms['nav-search-form'].submit();">
                            <svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4138 15.8368L21.8574 20.2857C22.0558 20.5064 22.046 20.8443 21.8352 21.0532L21.0575 21.8317C20.9532 21.937 20.8113 21.9962 20.6632 21.9962C20.5151 21.9962 20.3731 21.937 20.2688 21.8317L15.8252 17.3828C15.7023 17.2596 15.5907 17.1256 15.4919 16.9824L14.6587 15.8701C13.2802 16.9723 11.5682 17.5724 9.80409 17.5719C6.16878 17.5845 3.00983 15.0738 2.19744 11.5261C1.38504 7.97844 3.13601 4.34066 6.41372 2.76643C9.69143 1.1922 13.6211 2.10166 15.8763 4.95639C18.1314 7.81111 18.1102 11.8492 15.8252 14.68L16.9361 15.4475C17.1096 15.5586 17.2698 15.6892 17.4138 15.8368ZM4.24951 9.78627C4.24951 12.8576 6.73635 15.3475 9.80402 15.3475C11.2772 15.3475 12.69 14.7616 13.7317 13.7186C14.7733 12.6757 15.3585 11.2612 15.3585 9.78627C15.3585 6.7149 12.8717 4.22507 9.80402 4.22507C6.73635 4.22507 4.24951 6.7149 4.24951 9.78627Z"></path>
                            </svg>
                        </i>
                    </form>
                    <div id="mobile-search-options"> <input type="checkbox" class="mobile-search-checkbox" value="1" id="mobile-search-bar" /> <label class="mobile-search-container action-btn-container -white -passive side-btn" for="mobile-search-bar" id="mobile-search-bar-label" onclick="document.getElementById('nav-mobile-search-input').focus();"
                            aria-label="Search for inspiration"> <span class="_hidden">Search for inspiration</span> <i class="icon-search action-btn-icon"></i> </label>
                        <div id="mobile-search" class="inline-search-form -mobile">
                            <form action="https://wayak.app/index.php/posters/search" class="mobile-search-form" name="mobile-search-form" id="mobile-search-form" method="GET" onclick="document.getElementById('nav-mobile-search-input').focus();" accept-charset="utf-8">
                                <label for="nav-mobile-search-input" class="_hidden">Search for inspiration</label> <input class="mobile-search-input search-input" name="s" type="text" aria-label="Search for inspiration" id="nav-mobile-search-input" placeholder="Try &lsquo;sale flyer&rsquo;"
                                    maxlength="50" /> <i class="icon-search search-submit mobile-search-submit" onclick="document.forms['mobile-search-form'].submit();"></i> </form>
                        </div>
                    </div>
                    
                    <a class="action-btn-container side-btn for-anon" 
                        id="nav-login-signup-cta" 
                        href="{{ route('code.validate.form', [
                        'country' => $country
                        ]) }}" title="Claim Code">
                        <span class="action-btn-text login-btn-text">
                            Claim Code
                        </span>
                    </a>
                    
                    <div class="nav-item-container -to-right for-mobile" id="nav-hamburger-container"> 
                        <input type="checkbox" class="nav-dropdown-btn" value="1" id="nav-hamburger-menu" /> 
                        <label class="action-btn-container -passive side-btn" id="label-hamburger-menu" for="nav-hamburger-menu" aria-label="Menu"> <span class="_hidden">Menu</span> <i class="icon-bars action-btn-icon"></i></label>
                        <div class="dropdown-list">
                            <div class="list-container" id="nav-hamburger-list-container">
                                <a id="nav-scroll-to-top" class="nav-scroll-to-top nav-scroller">
                                    <p class="scroll-icon-container"><i class="icon-caret-down scroller-icon"></i></p>
                                </a>
                                <ul class="list has-user-input" id="nav-hamburger-list">
                                    <li class="list-item for-user">
                                        <!-- Placeholder text will be replaced as soon as the JS runs--><a class="item header" id="ulname-toggled" href="https://wayak.app/index.php/posters/mine">My Stuff</a> </li>
                                    <li class="list-item for-user"> <a class="item" href="https://wayak.app/index.php/posters/mine">My Stuff</a> </li>
                                    <li class="list-item"> <a class="item" href="https://wayak.app/index.php/posterbuilder?utm_source=nav&utm_content=createadesign&utm_medium=mobilelink&utm_campaign=templategallerynav">Create a Design</a> </li>
                                    <li class="list-item js-nav-with-list -with-list hide-for-student" id="nav-promote"> <a class="item" href="javascript:void(0);">Promote<i class="icon icon-caret-up"></i></a> </li>
                                    <li class="list-item js-nav-with-list -with-list hide-for-student" id="nav-features"> <a class="item" href="javascript:void(0);">Features<i class="icon icon-caret-up"></i></a> </li>
                                    <li class="list-item js-nav-with-list -with-list hide-for-student" id="nav-tutorials"> <a class="item" href="javascript:void(0);">Learn<i class="icon icon-caret-up"></i></a> </li>
                                    <li class="list-item for-anon"> <a class="item" href="https://wayak.app/index.php/premium?utm_source=mainnav&utm_medium=link&utm_campaign=premiumui">Subscriptions</a> </li>
                                    <li class="list-item for-premium"> <a class="item" href="https://wayak.app/index.php/premium/subscriptions">Premium Billing</a> </li>
                                    <li class="list-item"> <a class="item" href="https://wayak.app/index.php/cart/orderhistory">Order History</a> </li>
                                    <li class="list-item for-user"> <a class="item" href="https://wayak.app/index.php/user/editprofile">Edit Profile</a> </li>
                                    <li class="list-item"> <a class="item" href="https://support.postermywall.com/hc/en-us">Help Center</a> </li>
                                    <li class="list-item for-payg">
                                        <a class="item -premium-color -premium-color-hover" href="https://wayak.app/index.php/premium?utm_source=profilenavdropdown&utm_medium=link&utm_campaign=premiumui" title="Search for answers, read FAQ or contact Customer Support"><i class="icon-crown premium-icon"></i>Unlimited Downloads </a>
                                    </li>
                                    <li class="list-item for-anon"> <a class="item" href="https://wayak.app/index.php/authenticate/showlogin/?redirect=https%3A%2F%2Fwww.postermywall.com%2Findex.php">Log In</a> </li>
                                    <li class="list-item for-user"> <a class="item js-mobile-app-reset" href="https://wayak.app/index.php/authenticate/logout">Log out</a> </li>
                                </ul>
                                <a id="nav-scroll-to-bottom" class="nav-scroll-to-bottom nav-scroller">
                                    <p class="scroll-icon-container"><i class="icon-caret-down scroller-icon"></i></p>
                                </a>
                            </div>
                            <div class="list-container -mobile-list js-nav-mobile-list" data-for="nav-promote">
                                <ul class="list">
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/events?utm_source=nav&utm_content=m/events&utm_medium=link&utm_campaign=marketingnav">Event</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/small-business?utm_source=nav&utm_content=m/small-business&utm_medium=link&utm_campaign=marketingnav">Small business</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/church?utm_source=nav&utm_content=m/church&utm_medium=link&utm_campaign=marketingnav">Church</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/restaurants?utm_source=nav&utm_content=m/restaurants&utm_medium=link&utm_campaign=marketingnav">Restaurant</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/schools?utm_source=nav&utm_content=m/schools&utm_medium=link&utm_campaign=marketingnav">School</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/bands?utm_source=nav&utm_content=m/bands&utm_medium=link&utm_campaign=marketingnav">Band</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/real-estate?utm_source=nav&utm_content=m/real-estate&utm_medium=link&utm_campaign=marketingnav">Real Estate</a> </li>
                                </ul>
                            </div>
                            <div class="list-container -mobile-list js-nav-mobile-list" data-for="nav-features">
                                <ul class="list">
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/sizes/social-media-templates?utm_source=nav&utm_medium=link&utm_campaign=marketingnav">Social Media Posts</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/video?utm_source=nav&utm_medium=link&utm_campaign=marketingnav">4K and HD Videos</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/digital-signage?utm_source=nav&utm_medium=link&utm_campaign=marketingnav">Digital Signage</a> </li>
                                    <li class="list-item"><a class="item" href="https://wayak.app/index.php/m/restaurants?utm_source=nav&utm_medium=link&utm_campaign=marketingnav">Menu Maker</a> </li>
                                </ul>
                            </div>
                            <div class="list-container -mobile-list js-nav-mobile-list" data-for="nav-tutorials">
                                <ul class="list">
                                    <li class="list-item"><a class="item" href="https://gradient.postermywall.com/category-tutorials/">Video Tutorials</a> </li>
                                    <li class="list-item"><a class="item" href="https://support.postermywall.com/">Help Center</a> </li>
                                    <li class="list-item"><a class="item" href="https://gradient.postermywall.com/learn-with-postermywall/">Live Classes</a> </li>
                                    <li class="list-item"><a class="item" href="https://www.facebook.com/groups/pmwcreativecorner">Creative Corner</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="nav-spacer"></div>
        </header>

        @yield('content')

        <div id="footer" class="site-footer js-site-footer" role="contentinfo">
            <div class="container-large">
                <div class="footer-lower-content">
                    <div>© 2021 wayak.app All rights reserved.</div>
                    <div class="remote-locations-container">
                        Made with ♥ from MX
                    </div>
                </div>
            </div>
        </div>

        @yield('scripts')

	</body>
</html>