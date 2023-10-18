<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charSet="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    @yield('css')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FQVV2SLQED"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-FQVV2SLQED');
    </script>
    <style>
        .autocomplete-results {
            position: absolute;
            border: 1px solid #ccc;
            color:black;
            max-height: 315px;
            overflow-y: auto;
            background-color: #fff;
            z-index: 9999;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .autocomplete-item a{
            color: black;
        }

        .autocomplete-item {
            color: black;
            cursor: pointer;
            padding: 8px 12px;
        }

        .autocomplete-item.active, 
        .autocomplete-item:hover {
            color: black;
            background-color: #f7f7f7;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* semi-transparent black */
            z-index: 100; /* adjust this value if needed to ensure it's behind the header and results but above everything else */
            display: none; /* hidden by default */
        }

        #nav {
            z-index: 101;
        }

        /* ensure header and autocomplete results are above the overlay */
        header, .autocomplete-results {
            z-index: 102; /* adjust this value if needed */
        }


    </style>
</head>

<body>
    <header>
        @if( \Route::currentRouteName() != "user.search" && $sale != null)
        <div class="site-banner" data-v-f3f1b72a="" data-v-9440fe54="">
            <p class="site-banner__content" data-v-f3f1b72a="">
                <span class="site-banner__text" data-v-f3f1b72a="">
                    {{ $sale['site_banner_txt'] }}
                </span>
                <a href="{{ route('user.search',['country'=>$country,'sale'=> 1, 'sort'=>'popular','utm_source'=>'banner']) }}" class="site-banner__link large-screen-hidden u-type-label-small" data-v-f3f1b72a="">
                    {{ $sale['site_banner_btn'] }}
                </a>
                <a href="{{ route('user.search',['country'=>$country,'sale'=> 1, 'sort'=>'popular','utm_source'=>'banner']) }}" class="mobile-hidden btn btn--secondary btn--small btn--animated" data-v-5e31f9cb="" data-v-f3f1b72a="">
                    <span class="btn__inner" data-v-5e31f9cb="">
                        {{ $sale['site_banner_btn'] }}
                    </span>
                </a>
            </p>
            <a data-test-close="" class="site-banner__close-button" data-v-f3f1b72a="">
                <span data-v-f3f1b72a="">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg" svg-inline="" role="presentation" focusable="false" tabindex="-1">
                        <path d="M1.563 10.688l9.374-9.376M10.938 10.688L1.562 1.312" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
            </a>
        </div>
        @endif
        <nav class="navbar -nomargin" id="nav">
            <div class="logo-container">
                <a id="logo" href="{{ url('/'.$country.'?source=logo') }}" title="{{ __('home.logo_alt_title') }}" class="embedded-remove-url">
                    <div class="logo-wrapper">
                        <img class="logo-img" src="{{ url('assets/img/logo.svg') }}" alt="Wayak Logo" />
                    </div>
                </a>
            </div>
            <div class="primary-nav visible-small-laptop visible-desktop" id="nav-primary-items">
                <div class="nav-item-container hide-for-student">
                    <a class="nav-item {{ (\Route::current()->getName() == 'showHome' || \Route::current()->getName() == 'user.homepage') ? 'active' : null }}" href="{{ url('/'.$country).'?source=menu'  }}">
                        {{ __('menu.home') }}
                    </a>
                </div>
                <div class="nav-item-container hide-for-student">
                    <a class="nav-item {{ (request()->is($country.'/templates/*')) ? 'active' : null }}" href="javascript:void(0);">
                        {{ __('menu.templates') }}
                    </a>
                    <div class="dropdown-list">
                        <div class="list-container">
                            <ul class="list" id="nav-sizes-list">
                                @for($i = 0; $i < sizeof($menu->templates) / 3; $i++)
                                    <li class="list-item ">
                                        <a class="item" href="{{ $menu->templates[$i]->url.'?source=menu' }}">
                                            {{ $menu->templates[$i]->name }}
                                        </a>
                                    </li>
                                    @endfor
                                    {{-- <li class="list-item">
                                        <a class="item cta animate-icon" href="https://wayak.app/index.php/posters/sizes?utm_source=nav&utm_content=viewallsizes&utm_medium=link&utm_campaign=templategallerynav">
                                            View All <i class="icon-to-animate icon-caret-right"></i>
                                        </a>
                                    </li> --}}
                            </ul>
                            <ul class="list">
                                @for($i = (sizeof($menu->templates) / 3)+1; $i < ((sizeof($menu->templates) / 3) * 2)+1; $i++)
                                    <li class="list-item ">
                                        <a class="item" href="{{ $menu->templates[$i]->url.'?source=menu' }}">
                                            {{ $menu->templates[$i]->name }}
                                        </a>
                                    </li>
                                    @endfor
                                    {{-- <li class="list-item"><a class="item cta animate-icon" href="https://wayak.app/index.php/posters/gallery?utm_source=nav&utm_content=viewalltheme&utm_medium=link&utm_campaign=templategallerynav">View All <i class="icon-caret-right icon-to-animate"></i></a></li> --}}
                            </ul>
                            <ul class="list">
                                @for($i = ((sizeof($menu->templates) / 3)*2)+1; $i < sizeof($menu->templates); $i++)
                                    <li class="list-item ">
                                        <a class="item" href="{{ $menu->templates[$i]->url.'?source=menu' }}">
                                            {{ $menu->templates[$i]->name }}
                                        </a>
                                    </li>
                                    @endfor
                                    {{-- <li class="list-item"><a class="item cta animate-icon" href="https://wayak.app/index.php/posters/gallery?utm_source=nav&utm_content=viewalltheme&utm_medium=link&utm_campaign=templategallerynav">View All <i class="icon-caret-right icon-to-animate"></i></a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                @if($sale != null)
                <div class="nav-item-container" id="marketing-nav-item">
                    <a class="nav-item sale" href="{{ route('user.search',['country'=>$country,'sale'=> 1, 'sort'=>'popular','utm_source'=>'banner']) }}" title="Sales">
                        <svg width="17" height="17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 7" svg-inline="" role="presentation" focusable="false" tabindex="-1">
                            <path fill="currentColor" fill-rule="evenodd" d="M6.814 3.673l-1.741.822c-.15.048-.299.193-.448.435L3.78 6.62c-.15.194-.497.194-.597 0L2.338 4.93c-.05-.145-.2-.29-.448-.435L.15 3.673c-.2-.145-.2-.483 0-.58l1.74-.821c.15-.049.299-.194.448-.436l.845-1.69c.15-.194.498-.194.597 0l.845 1.69c.05.146.2.29.448.436l1.74.821c.25.145.25.484 0 .58"></path>
                        </svg>
                        Sale
                    </a>
                </div>
                @endif
                <a class="action-btn-container side-btn for-anon" id="nav-login-signup-cta" href="{{ route('code.validate.form', [
                            'country' => $country
                        ]) }}" title="Claim Code">
                    <span class="action-btn-text login-btn-text">
                        {{ __('menu.claim_code') }}
                    </span>
                </a>
            </div>
            <div class="user-options">
                <form action="{{ route('user.search',['country' => $country]) }}" class="inline-search-form" name="nav-search-form" id="nav-search-form" method="GET" onclick="document.getElementById('nav-search-input').focus();" accept-charset="utf-8" autocomplete="off">
                    @csrf
                    <input type="hidden" id="search-customer-id" name="customerId">
                    <label for="nav-search-input" class="_hidden">{{ __('menu.search_btn_label') }}</label>
                    <input class="search-input" name="searchQuery" type="text" id="nav-search-input" aria-label="{{ __('menu.search_btn_label') }}" placeholder="{{ __('menu.mobile_search_placeholder') }}" value="{{ $search_query }}" />
                    <i class="search-submit icon-search" onclick="document.forms['nav-search-form'].submit();">
                        <svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4138 15.8368L21.8574 20.2857C22.0558 20.5064 22.046 20.8443 21.8352 21.0532L21.0575 21.8317C20.9532 21.937 20.8113 21.9962 20.6632 21.9962C20.5151 21.9962 20.3731 21.937 20.2688 21.8317L15.8252 17.3828C15.7023 17.2596 15.5907 17.1256 15.4919 16.9824L14.6587 15.8701C13.2802 16.9723 11.5682 17.5724 9.80409 17.5719C6.16878 17.5845 3.00983 15.0738 2.19744 11.5261C1.38504 7.97844 3.13601 4.34066 6.41372 2.76643C9.69143 1.1922 13.6211 2.10166 15.8763 4.95639C18.1314 7.81111 18.1102 11.8492 15.8252 14.68L16.9361 15.4475C17.1096 15.5586 17.2698 15.6892 17.4138 15.8368ZM4.24951 9.78627C4.24951 12.8576 6.73635 15.3475 9.80402 15.3475C11.2772 15.3475 12.69 14.7616 13.7317 13.7186C14.7733 12.6757 15.3585 11.2612 15.3585 9.78627C15.3585 6.7149 12.8717 4.22507 9.80402 4.22507C6.73635 4.22507 4.24951 6.7149 4.24951 9.78627Z"></path>
                        </svg>
                    </i>
                </form>
                <div id="mobile-search-options">
                    <input type="checkbox" class="mobile-search-checkbox" value="1" id="mobile-search-bar" />
                    <label class="mobile-search-container action-btn-container -white -passive side-btn" for="mobile-search-bar" id="mobile-search-bar-label" onclick="document.getElementById('nav-mobile-search-input').focus();" aria-label="{{ __('menu.search_btn_label') }}"> <span class="_hidden">{{ __('menu.search_btn_label') }}</span> <i class="icon-search action-btn-icon"></i> </label>
                    <div id="mobile-search" class="inline-search-form -mobile">
                        <form action="{{ route('user.search',['country' => $country]) }}" class="mobile-search-form" name="mobile-search-form" id="mobile-search-form" method="GET" onclick="document.getElementById('nav-mobile-search-input').focus();" accept-charset="utf-8">
                            <label for="nav-mobile-search-input" class="_hidden">{{ __('menu.search_btn_label') }}</label>
                            <input class="mobile-search-input search-input" name="s" type="text" aria-label="{{ __('menu.search_btn_label') }}" id="nav-mobile-search-input" placeholder="{{ __('menu.mobile_search_placeholder') }}" maxlength="50" />
                            <i class="icon-search search-submit mobile-search-submit" onclick="document.forms['mobile-search-form'].submit();"></i>
                        </form>
                    </div>
                </div>

                @auth
                    {{auth()->user()->name}}
                    <div class="text-end">
                        <a style="color: black;" href="{{ route('logout.perform',['country' => $country]) }}" class="btn btn-outline-light me-2">Logout</a>
                    </div>
                @endauth

                @guest
                    <div class="text-end">
                        <a style="color: black;" href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
                        <a style="color: black;" href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
                    </div>
                @endguest

            </div>
        </nav>
        <div class="nav-spacer"></div>
    </header>

    @yield('content')

    <script>
        // Debounce function: Ensures that the given function is not called until after the specified time has elapsed since the last time it was called
        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        // Function to fetch results from the server using AJAX
        function fetchData(query, callback) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `http://localhost:8001/search?prefix=${query}`, true);
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    const results = JSON.parse(this.responseText);
                    callback(results);
                }
            };
            xhr.send();
        }

        // Function to display the results
        function displayResults(results, container) {
            // Clear previous results
            container.innerHTML = '';
            
            results.forEach(item => {
                const div = document.createElement('div');
                const anchor = document.createElement('a');
                const searchInput = document.getElementById('nav-search-input');
                const resultsContainer = document.querySelector('.autocomplete-results');

                div.classList.add('autocomplete-item');
                
                anchor.innerText = item;

                // anchor.href = item;

                // Assigning an onclick handler directly to the anchor element
                anchor.onclick = function() {
                    // alert('Button was clicked!');
                    searchInput.value = item;
                    searchInput.form.submit(); // assuming the input is within a form, this will submit it
                        
                    resultsContainer.innerHTML = ''; // Clear the results to hide them
                };
                
                div.appendChild(anchor);
                container.appendChild(div);
            });
        }

        function displayPopularSearches(resultsContainer) {
            // Get the parsed data from localStorage
            const popularSearchesData = JSON.parse(localStorage.getItem('popularSearches'));

            // Extract terms from the data
            const terms = popularSearchesData.map(item => item.term);

            // Use the displayResults function to display the terms
            displayResults(terms, resultsContainer);
        }

        function positionResultsContainer(input, container) {
            const rect = input.getBoundingClientRect();
            container.style.top = (rect.bottom + window.scrollY) + 'px';
            container.style.left = (rect.left + window.scrollX) + 'px';
            container.style.width = rect.width + 'px';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const searchInput = document.getElementById('nav-search-input');
            // const mobileSearchInput = document.getElementById('nav-mobile-search-input');
            const resultsContainer = document.createElement('div');
            resultsContainer.classList.add('autocomplete-results');
            var currentHighlightIndex = -1; // to keep track of currently highlighted item

            // Append results container to the body (can be adjusted based on design requirements)
            document.body.appendChild(resultsContainer);

            // Event listener for search input using debouncing
            searchInput.addEventListener('keyup', debounce(function(e) {
                const query = e.target.value;

                if (searchInput.value === "") {
                    console.log(searchInput.value);
                    displayPopularSearches(resultsContainer);
                    positionResultsContainer(searchInput, resultsContainer);
                } else if (query.length > 2) { // Only fetch data if query length is greater than 3
                    fetchData(query, function(results) {
                        displayResults(results, resultsContainer);
                        positionResultsContainer(searchInput, resultsContainer);
                    });
                }
            }, 300)); // 300ms debounce time

            // New focus event listener for searchInput
            searchInput.addEventListener('focus', function() {
                if (searchInput.value === "") {
                    console.log(searchInput.value);
                    displayPopularSearches(resultsContainer);
                    positionResultsContainer(searchInput, resultsContainer);
                } else if (searchInput.value.length > 2) { // Only fetch data if query length is greater than 3
                    fetchData(searchInput.value, function(results) {
                        displayResults(results, resultsContainer);
                        positionResultsContainer(searchInput, resultsContainer);
                    });
                }
            });

            const autocompleteResults = document.querySelector('body > div.autocomplete-results');
            let inputBlurred = false;
            let autocompleteBlurred = false;
            var overlay = document.querySelector("#overlay");

            // function checkBothBlurred() {
            //     if (inputBlurred && autocompleteBlurred) {
            //         console.log('Both elements are blurred!');
            //         autocompleteResults.innerHTML = ''; // Clear the results to hide them
            //     }
            // }

            searchInput.addEventListener("focus", function() {
                overlay.style.display = "block";
                // inputBlurred = false;
                // autocompleteBlurred = false;
                // checkBothBlurred();
            });

            searchInput.addEventListener("blur", function() {
                overlay.style.display = "none";
                // inputBlurred = true;
                // // autocompleteBlurred = true;
                // // console.log('inputBlurred' + inputBlurred);
                // checkBothBlurred();
            });

            // autocompleteResults.addEventListener('blur', function() {
            //     overlay.style.display = "none";
            //     autocompleteBlurred = true;
            //     checkBothBlurred();
            // });

            // document.addEventListener("mouseover", function(event) {
            //     if (!event.target.classList.contains("autocomplete-item")) {
            //         // document.querySelector("#nav-search-input").value = event.target.innerText;
            //         // event.target.classList.add('active');
            //         autocompleteBlurred = true;
            //     } else {
            //         autocompleteBlurred = false;
            //     }
            //     // if (event.target === event) {
            //     //     document.querySelector("#nav-search-form").submit();
            //     //     console.log("hello");
            //     // }
            // });

            // Event listener for arrow key navigation
            // searchInput.addEventListener('keydown', function(e) {
            //     const items = resultsContainer.querySelectorAll(".autocomplete-item");

            //     // Remove existing active states
            //     items.forEach(item => {
            //         item.classList.remove('active');
            //     });

            //     // Down arrow key
            //     if (e.keyCode === 40) {
            //         currentHighlightIndex = (currentHighlightIndex + 1) % items.length;
            //         items[currentHighlightIndex].classList.add('active');
            //         resultsContainer.scrollTop = items[currentHighlightIndex].offsetTop;
            //         items[currentHighlightIndex].focus(); // Focus on the active item
            //     }
                
            //     // Up arrow key
            //     else if (e.keyCode === 38) {
            //         currentHighlightIndex = (currentHighlightIndex - 1 + items.length) % items.length;
            //         items[currentHighlightIndex].classList.add('active');
            //         resultsContainer.scrollTop = items[currentHighlightIndex].offsetTop;
            //         items[currentHighlightIndex].focus(); // Focus on the active item
            //     }

            //     // Any other key
            //     else {
            //         searchInput.focus();
            //     }
            // });

            
            // Function to fetch and store data in local storage
            const fetchDataAndStorePopularSearches = () => {
                const currentTime = Date.now();

                const lastUpdated = localStorage.getItem('lastUpdatedSearchTerms');
                if (lastUpdated && (currentTime - lastUpdated < 2 * 60 * 60 * 1000)) {
                    // Data is less than 2 hours old, so no need to refetch
                    return;
                }

                fetch('http://localhost:8001/us/search/popular-searches')
                    .then(response => response.json())
                    .then(data => {
                        localStorage.setItem('popularSearches', JSON.stringify(data));
                        localStorage.setItem('lastUpdatedSearchTerms', currentTime.toString());
                    })
                    .catch(error => {
                        console.error('Error fetching popular searches:', error);
                    });
            };

            // Fetch data once page is loaded
            fetchDataAndStorePopularSearches();

            // displayPopularSearches(resultsContainer);

            // Set an interval to fetch data every 2 hours
            setInterval(fetchDataAndStorePopularSearches, 2 * 60 * 60 * 1000); // 2 hours in milliseconds
        });

    </script>

    <script>
        // Assign customer ID
        document.addEventListener("DOMContentLoaded", function() {
            const customerId = getCustomerId();

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

                // Update any input elements with name="customer-id" to have the value of customerId
                const customerInputs = document.querySelectorAll('input[name="customerId"]');
                customerInputs.forEach(input => {
                    input.value = customerId;
                });

                return customerId;
            }
        });
    </script>

    <div id="footer" class="site-footer js-site-footer" role="contentinfo">
        <div class="container-large">
            <div class="footer-lower-content">
                <div>{{ __('footer.copyright') }}</div>
                <div class="remote-locations-container">
                    {{ __('footer.made_with') }}
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')

    <div id="overlay"></div>

</body>

</html>