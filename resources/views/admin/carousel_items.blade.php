@extends('layouts.admin')

@section('title', 'Results for: "'.$search_query.'" | Online Template Editor | Wayak')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">

<meta data-rh="true" charset="UTF-8">
<meta data-rh="true" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<style>
    a>figure.selected {
        background: red;
        opacity: .5;
    }
</style>

{{--
    <meta data-rh="true" name="google-site-verification" content="">
    <meta data-rh="true" name="apple-itunes-app" content="">
    <meta data-rh="true" name="google" content="no-translate">
--}}

@endsection

@section('content')
<div class="col-12">
    <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('admin.carousels.step2',['country' => $country]) }}">
        @csrf
        <h3>Title</h3>
        <input class="form-control" type="text" id="carouselTitle" name="carouselTitle" value="{{ $carousel_title }}">
        
        <h3>Search Term</h3>
        <div class="sc-dmlrTW guKkvw">
            <input type="text" autocomplete="off" id="searchQuery" name="searchQuery" class="form-control" value="{{ $search_query }}" style="padding-left: 20px;" autofocus>
        </div>
        <div class="inputControls___BVQJr left___1UDlV"></div>
        <div class="inputControls___BVQJr right___3zI72">
            <button type="submit" class="btn btn-primary" data-categ="homeSearchForm" data-value="submit">
                <svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4138 15.8368L21.8574 20.2857C22.0558 20.5064 22.046 20.8443 21.8352 21.0532L21.0575 21.8317C20.9532 21.937 20.8113 21.9962 20.6632 21.9962C20.5151 21.9962 20.3731 21.937 20.2688 21.8317L15.8252 17.3828C15.7023 17.2596 15.5907 17.1256 15.4919 16.9824L14.6587 15.8701C13.2802 16.9723 11.5682 17.5724 9.80409 17.5719C6.16878 17.5845 3.00983 15.0738 2.19744 11.5261C1.38504 7.97844 3.13601 4.34066 6.41372 2.76643C9.69143 1.1922 13.6211 2.10166 15.8763 4.95639C18.1314 7.81111 18.1102 11.8492 15.8252 14.68L16.9361 15.4475C17.1096 15.5586 17.2698 15.6892 17.4138 15.8368ZM4.24951 9.78627C4.24951 12.8576 6.73635 15.3475 9.80402 15.3475C11.2772 15.3475 12.69 14.7616 13.7317 13.7186C14.7733 12.6757 15.3585 11.2612 15.3585 9.78627C15.3585 6.7149 12.8717 4.22507 9.80402 4.22507C6.73635 4.22507 4.24951 6.7149 4.24951 9.78627Z"></path>
                </svg>
            </button>
            <button type="button" class="btn btn-primary" onclick="sendAjaxRequest()">
                SAVE
            </button>
        </div>
    </form>
    <br>
    <button class="btn btn-primary" onclick="clearLocalStorage()">
        Clear
    </button>
    
    <button type="button" id="myModal" class="btn btn-primary" onclick="launchPreview()">
        Show Carousel Elements
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="productList"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
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
                                            <img alt="{{ $template->title }}" crossorigin="anonymous" data-value="{{ $template->_id }}" src="{{ str_replace('_carousel','_product_preview',$template->preview_image) }}" class="itemImg">
                                            <figcaption>
                                                <div class="dMnq_Lr8">
                                                    <span>
                                                        {{ $template->title }}
                                                    </span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                    @endforeach
                                </div>
                                <div class="hZFJ5g_b">
                                    @if( $current_page > 1 )
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

                                    @if( ($current_page-1) > 0 )
                                    <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ route( 'user.search', [ 'country' => $country, 'page' => $current_page-1, 'sale' => 1, 'sort' => 'popular' ] ) }}">
                                        <span class="LQ9zKnGb tUz8vpIk vHgjkrLA">
                                            <svg class="f0hiXs2f" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 24" role="img" aria-label="Arrow left">
                                                <path d="M14 24c-.2 0-.5-.1-.6-.2l-13-11c-.3-.2-.4-.5-.4-.8 0-.3.1-.6.4-.8l13-11c.4-.4 1.1-.3 1.4.1.4.4.3 1.1-.1 1.4L2.5 12l12.1 10.2c.4.4.5 1 .1 1.4-.1.3-.4.4-.7.4z">
                                                </path>
                                            </svg>
                                        </span>
                                    </a>
                                    @endif

                                    @for($i = $pagination_begin; $i <= $pagination_end; $i++) <div class="cpiMRmby">
                                        <span class="SLi2_6Jp">
                                            @if( $current_page == $i )
                                            <span data-test-selector="pagination-link-page-1-disabled" class="LQ9zKnGb zWRu8yhu tUz8vpIk">{{ $i }}</span>
                                            @else
                                            <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ route( 'admin.carousels.step2', [ 'country' => $country, 'page' => $i, 'searchQuery' => $search_query, 'carouselTitle' => $carousel_title, 'searchQuery' => $search_query] ) }}">
                                                {{ $i }}
                                            </a>
                                            @endif
                                        </span>
                                        @endfor
                                </div>

                                @if( ($current_page+1) <= $last_page ) <a class="LQ9zKnGb" data-test-selector="pagination-link-page-2" rel="nofollow" href="{{ route( 'user.search', [ 'country' => $country, 'page' => $current_page+1, 'sale' => 1, 'sort' => 'popular', 'searchQuery' => $search_query ] ) }}">
                                    <svg class="f0hiXs2f" tabindex="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 24" role="img" aria-label="Arrow right">
                                        <path d="M1 24c-.3 0-.6-.1-.8-.4-.4-.4-.3-1.1.1-1.4L12.5 12 .4 1.8C0 1.4-.1.8.3.4c.4-.4 1-.5 1.4-.1l13 11c.2.2.4.5.4.8 0 .3-.1.6-.4.8l-13 11c-.2 0-.5.1-.7.1z">
                                        </path>
                                    </svg>
                                    </a>
                                    @endif
                            </div>
                        </div>
                    </div>
                </section>

            </main>
        </div>
</main>

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
<script>
    var myModal = new bootstrap.Modal(document.getElementById("exampleModalCenter"), {});

    function launchPreview(){
        getTemplates();
        myModal.show();
    }

    // document.onreadystatechange = function () {
    // };

    function addTemplate(element) {
        
        var figureElement = element.querySelector('figure');
        var hasSelectedClass = figureElement.classList.contains('selected');
        
        console.log("element");
        console.log(element);
        console.log(element.id);
        console.log(element.dataset.templateId);

        if (hasSelectedClass) {
            figureElement.classList.remove('selected');
            removeFromLocalStorageIfExists(element.dataset.templateId);
            getTemplates();
        } else {
            figureElement.classList.add('selected');
            storeTemplateIDLocally(element.dataset.templateId);
            getTemplates();
        }
    }

    function getTemplates() {
        let idQueue = JSON.parse(localStorage.getItem("idQueue")) || [];
        console.log(`Stored IDs: ${idQueue.join(", ")}`);

        // $.get("http://localhost:8001/admin/us/carousel/preview?ids="+idQueue.join(", "), function(data, status){
        //     alert("Data: " + data + "\nStatus: " + status);
        // });
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4){
                // document.getElementById('result').innerHTML = xhr.responseText;
                console.log(xhr.responseText);
                // const obj = JSON.parse(xhr.responseText);
                displayProductList(xhr.responseText);
            }
        };
        xhr.open('GET', "http://localhost:8001/admin/us/carousel/preview?ids="+idQueue.join(","));
        xhr.send()
    }

    function displayProductList(jsonData) {
        var products = JSON.parse(jsonData);
        var productList = document.getElementById("productList");
 
        // Clear the existing list
        productList.innerHTML = '';

        for (var i = 0; i < products.length; i++) {
            var product = products[i];
            var imageSrc = product.preview_image;
            var title = product.title;

            // Create a new list item element
            var listItem = document.createElement("li");

            // // Create an image element and set its source
            // var image = document.createElement("img");
            // image.src = imageSrc;

            // // Create a text node for the product title
            // var titleNode = document.createTextNode(title);

            // // Append the image and title to the list item
            // listItem.appendChild(image);
            // listItem.appendChild(titleNode);

            // Create the <a> element
            var link = document.createElement("a");
            // link.onclick = 'addTemplate(this)';
            link.addEventListener('click', function handleClick(event) {
            //   console.log('element clicked 🎉🎉🎉', event);
                addTemplate(this);
            });
            link.id = "template"+product._id;
            link.setAttribute("data-template-id", product._id);

            // Create the <figure> element
            var figure = document.createElement("figure");
            figure.className = "selected";

            // Create the <img> element
            var img = document.createElement("img");
            img.alt = title;
            img.setAttribute("crossorigin", "anonymous");
            img.setAttribute("data-value", product._id);
            img.src = imageSrc;
            img.className = "itemImg";

            // Create the <figcaption> element
            var figcaption = document.createElement("figcaption");

            // Create the <div> element
            var div = document.createElement("div");
            div.className = "dMnq_Lr8";

            // Create the <span> element
            var span = document.createElement("span");
            span.textContent = title;

            // Append the elements together
            div.appendChild(span);
            figcaption.appendChild(div);
            figure.appendChild(img);
            figure.appendChild(figcaption);
            link.appendChild(figure);

            // Append the list item to the product list
            productList.appendChild(link);
        }
        }



    function removeFromLocalStorageIfExists(id) {
        if (typeof(Storage) !== "undefined") {
            // Retrieve the existing queue from local storage
            let queue = JSON.parse(localStorage.getItem("idQueue")) || [];

            // Remove the ID from the queue if it exists
            if (queue.includes(id)) {
                queue = queue.filter(item => item !== id);
                localStorage.setItem("idQueue", JSON.stringify(queue));
                console.log(`ID ${id} removed from local storage.`);
            } else {
                console.log(`ID ${id} does not exist in local storage.`);
            }
        } else {
            console.log("Local storage is not supported by this browser.");
        }
    }

    function storeTemplateIDLocally(id) {
        if (typeof(Storage) !== "undefined") {
            // Retrieve the existing queue from local storage
            let queue = JSON.parse(localStorage.getItem("idQueue")) || [];

            // Add the new ID to the end of the queue if it doesn't already exist
            if (!queue.includes(id)) {
                queue.push(id);
            }

            // // Keep only the last 10 IDs in the queue
            // queue = queue.slice(-10);

            // Store the updated queue in local storage
            localStorage.setItem("idQueue", JSON.stringify(queue));

            console.log(`ID ${id} stored locally.`);
        } else {
            console.log("Local storage is not supported by this browser.");
        }
    }

    function clearLocalStorage() {
        // Clear local storage
        localStorage.clear();

        // Reload the current location
        window.location.reload();
    }

    function onLoad() {
        assignDefaultElements();
        var templateIds = JSON.parse(localStorage.getItem("idQueue")) || [];
        var figureElements = document.querySelectorAll("div.grid-container > a");

        for (var i = 0; i < figureElements.length; i++) {
            if (templateIds.includes(figureElements[i].dataset.templateId)) {
                // figureElements[i].classList.add("puta");
                figureElements[i].querySelector("figure").classList.add("selected");
                // console.log("dataset.templateId");
                // console.log(figureElements[i].dataset.templateId);
            }
        }

    }

    function assignDefaultElements() {
        const hasRunBefore = localStorage.getItem("hasRunBefore");
        
        if (!hasRunBefore) {
            var default_template_ids = {!! $default_template_ids !!};
            localStorage.setItem("idQueue", JSON.stringify(default_template_ids));

            // Set the flag in the local storage to mark that the function has been executed
            localStorage.setItem("hasRunBefore", "true");
        } else {
            console.log("This function has already been executed and will not run again.");
        }
    }

    function sendAjaxRequest() {
        // Step 1: Retrieve the JSON data from local storage
        const jsonData = localStorage.getItem("idQueue");

        // Check if the JSON data exists in local storage
        if (jsonData) {
            // Step 2: Convert the JSON data to a JavaScript array
            const dataArray = JSON.parse(jsonData);

            // Step 3: Get the values of "carouselTitle" and "searchQuery"
            const carouselTitle = document.getElementById("carouselTitle").value;
            const searchQuery = document.getElementById("searchQuery").value;

            // Step 4: Add the values as request attributes in the POST data
            const requestData = JSON.stringify({
            idQueue: dataArray,
            carouselTitle: carouselTitle,
            searchQuery: searchQuery,
            });

            // Step 5: Retrieve the CSRF token value from the meta element in the header
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute("content") : null;

            // Step 6: Send the AJAX POST request with the data and CSRF token as header parameter
            const url = "http://localhost:8001/admin/us/carousels/items/create";

            // Create the AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/json");

            // Set the CSRF token as the value of the "X-CSRF-TOKEN" header
            if (csrfToken) {
                xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
            }

            // Handle the response from the server
            xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                console.log("AJAX request successful!");
                console.log(xhr.responseText);

                // Step 7: Redirect upon successful AJAX request
                window.location.href = "http://localhost:8001/admin/us/carousels/name";
                } else {
                console.error("AJAX request failed with status:", xhr.status);
                }
            }
            };

            // Step 8: Send the request
            xhr.send(requestData);
        } else {
            console.error("JSON data not found in local storage.");
        }
    }

    // Add the onload event listener to the window object
    window.addEventListener("load", onLoad);
</script>
@endsection