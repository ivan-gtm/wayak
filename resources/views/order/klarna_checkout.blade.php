<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Klarna Checkout - Daniel Gutierrez</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/klarna_checkout.css') }}">

</head>

<body>
    <div id="site-container" class="">
        <div id="main-container" class=" guided-not-open">
            <div class="wrapper">
                <div class="page-container" id="currentPage">
                    <div id="klarna-toggle-container"><img id="klarna-toggle-icon" class="" src="https://www.klarna.com/demo/static/images/guided-toggle.png" alt="Guided toggle"></div>
                    <header id="header" class="">
                        <a class="shouldHide" href="/demo/us/en-US/kp/products">
                            <img id="demo-store" src="https://www.klarna.com/demo/static/images/demostore_logo.svg" alt="DemoStore logo"> by Daniel Gutierrez
                        </a>
                    </header>
                    <div id="checkout-container" class="kp">
                        <div>
                            <div class="row">
                                <div class="col-md-7 col-sm-12">
                                    <div class="person-details-title-container">
                                        <div class="page-title shouldHide">Checkout</div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <div class="section-container left">
                                        <div class="person-details-container person-details shouldHide">
                                            <div class="section-title shouldHide">Billing address</div>
                                            <div class="form-container">
                                                <form class="row g-3" id="billingAddressForm">
                                                    <div class="col-md-12">
                                                        <label for="inputEmail" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="inputEmail" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputFirstName" class="form-label">First name</label>
                                                        <input type="text" class="form-control" id="inputFirstName" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputLastName" class="form-label">Last name</label>
                                                        <input type="text" class="form-control" id="inputLastName" placeholder="1234 Main St" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="inputStreetAddress" class="form-label">Street Address</label>
                                                        <input type="text" class="form-control" id="inputStreetAddress" placeholder="Apartment, studio, or floor" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputState" class="form-label">State</label>
                                                        <input type="text" class="form-control" id="inputState" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputZip" class="form-label">ZIP</label>
                                                        <input type="number" class="form-control" id="inputZip" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputAparment" class="form-label">Apartment, suite (optional)</label>
                                                        <input type="text" class="form-control" id="inputAparment">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputCity" class="form-label">City</label>
                                                        <input type="text" class="form-control" id="inputCity">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputPhone" class="form-label">Phone</label>
                                                        <input type="text" class="form-control" id="inputPhone">
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="gridCheck">
                                                            <label class="form-check-label" for="gridCheck">
                                                            Use the same address for shipping
                                                        </label>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-2 col-6 mx-auto">
                                                        <button class="btn btn-primary" id="create_session_el" type="submit">Next</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="section-title shouldHide">Payment Options</div>
                                        <div id="delivery-options" class="section-container left shouldHide">
                                            @foreach ($klarnaSession->payment_method_categories as $payment_category)    
                                                <div>
                                                    <div class="input-container delivery-item-container delivery-option">
                                                        <div class="radio-container">
                                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="{{ $payment_category->identifier }}" onclick="selectPaymentMethod('{{ $payment_category->identifier }}')">
                                                        </div>
                                                        <div class="delivery-description">
                                                            <label class="title" for="{{ $payment_category->identifier }}">{{ $payment_category->name }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="section-title shouldHide">Payments</div>
                                        <div id="payment-options" class="section-container left">

                                            <div class="unbranded-card-option">
                                                <div class="unbranded-card-option-content">
                                                    <div class="section-title shouldHide">Debit/credit card</div>
                                                    <div>
                                                        <div id="klarna-container"></div>
                                                        <button type="button" id="place_order" onclick="authorizePayment()">PLACE ORDER</button>
                                                        <script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <div style="margin-bottom: 500px; position: sticky; top: 20px;">
                                        <div class="section-container center">
                                            <div class="shopping-cart">
                                                <div class="title-container shouldHide">
                                                    <div class="title">Shopping bag</div>
                                                </div>
                                                <hr class="shouldHide">
                                                <div>
                                                    <div class="shouldHide">
                                                        <div class="products-container">
                                                            <div class="product-container">
                                                                <div class="image-container">
                                                                    <img class="product-image" src="https://www.klarna.com/demo/static/images/products/t-shirt.jpg" alt="T-shirt">
                                                                </div>
                                                                <div class="description-container">
                                                                    <div class="product-title">
                                                                        {{ $orderLines['name'] }}
                                                                    </div>
                                                                </div>
                                                                <div class="price-container">
                                                                    <div class="product-remove"><img src="https://www.klarna.com/demo/static/images/remove.svg" alt="Remove icon"></div>
                                                                    <div class="product-price">$ {{ $orderLines['total_amount']/100 }} </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="shouldHide">
                                                    <div class="subtotal-container shouldHide">
                                                        <div class="subtotal-label">Subtotal</div>
                                                        <div class="subtotal-value">$ {{ $orderLines['total_amount']/100 }}</div>
                                                    </div>
                                                    <div class="shipping-container shouldHide">
                                                        <div class="shipping-label">Tax rate</div>
                                                        <div class="shipping-value">$0 </div>
                                                    </div>
                                                    <hr class="shouldHide">
                                                    <div class="total-container">
                                                        <div class="total-label shouldHide">Total</div>
                                                        <div class="total-value shouldHide">${{ $orderLines['total_amount']/100 }} </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-main">
        <footer id="footer-container">
            <span class="footer-devider"></span>
            <div class="logo-container shouldHide">
                <klarna-placement data-key="footer-promotion-auto-size" data-locale="en-US">
                    <div style="height: auto; width: 100%; display: block;"></div>
                </klarna-placement>
            </div>
            <div class="shouldHide" style="width:100%">
                <div class="footer-content demostore-financing-logo-container shouldHide">
                    <div class="footer-menu">
                        <div>
                            <h2>Klarna</h2>
                            <a href="https://www.klarna.com/us/business/case-studies/" target="_blank" rel="noopener noreferrer">Case studies</a><a href="https://www.klarna.com/demo/us/en-US/info" target="_blank" rel="noopener noreferrer">FAQ Page</a>
                        </div>
                        <div>
                            <h2>Shoppers</h2>
                            <a href="https://www.klarna.com/us/klarna-stores/" target="_blank" rel="noopener noreferrer">Klarna stores</a><a href="https://www.klarna.com/us/klarna-app/" target="_blank" rel="noopener noreferrer">Shopping app</a>
                        </div>
                        <div>
                            <h2>Business</h2>
                            <a href="https://www.klarna.com/us/business/partners/" target="_blank" rel="noopener noreferrer">Become a partner</a><a href="https://developers.klarna.com/" target="_blank" rel="noopener noreferrer">Developers</a>
                        </div>
                    </div>
                    <div class="demostore-financing-container">
                        <div class="klarna-demostore-container">
                            <a href="/demo/us/en-US/kp">
                                <img id="demo-storex" src="https://www.klarna.com/demo/static/images/demostore_logo_white.svg" alt="Demostore logo">
                            </a>
                        </div>
                        <div class="financing-container">
                            Daniel Gutierrez © 2021.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script>
        const billingAddressObj = new Object();
        var widgetLoaded = false;
        var authorizeApproved = false;
        var clientToken = "{{ $client_token }}";
        var orderItem = {!! $order_item !!};

        window.onload = function() {
            // billingAddressObj.given_name = "John";
            // billingAddressObj.family_name = "Doe";
            // billingAddressObj.email = "john@doe.com";
            // billingAddressObj.title = "Mr";
            // billingAddressObj.street_address = "144 2nd Ave";
            // billingAddressObj.postal_code = "10003";
            // billingAddressObj.city = "New York";
            // billingAddressObj.region = "United States";
            // billingAddressObj.phone = "+12122289682";
            // billingAddressObj.country = "US";
            
            // console.log( billingAddressObj );
            
            // var paymentType = "pay_over_time";
            
            // loadKlarnaWidget(paymentType, this.clientToken);
            
            var me = this;
            me.registerEventListeners();

        }

        function  registerEventListeners() {
            var me = this;
            var billingAddressForm = document.getElementById("billingAddressForm");
            
            billingAddressForm.addEventListener('submit', submitHandler);

            // console.warn('registerEventListeners');
            // console.log(billingAddressForm);
        }

        function submitHandler(event){
            var me = this;

            // var checkedRadioId = $('input[name=payment]:checked', '#shippingPaymentForm').attr('id');
            // var paymentid = 'payment_mean' + $('#mopt_payone_klarna_paymentid').val();
            // if (! (checkedRadioId === 'payment_meanmopt_payone_klarna' || checkedRadioId === paymentid)) {
            //     return;
            // }

            // if (me.authorizeApproved) {
            //     return;
            // }

            event.preventDefault();

            me.submitPressed = true;
            
            // disable submit buttons
            document.getElementById("create_session_el").disabled = true;
            
            var formInputElements = document.getElementsByClassName('form-control')
            Array.prototype.filter.call(formInputElements, function(testElement){
                // console.log(testElement);
                testElement.disabled = true;
            });

            if (widgetLoaded) {
                me.authorize();
            }

        }

        function selectPaymentMethod( paymentType ){
            console.log( paymentType );

            billingAddressObj.given_name = "John";
            billingAddressObj.family_name = "Doe";
            billingAddressObj.email = "john@doe.com";
            billingAddressObj.title = "Mr";
            billingAddressObj.street_address = "144 2nd Ave";
            billingAddressObj.postal_code = "10003";
            billingAddressObj.city = "New York";
            billingAddressObj.region = "United States";
            billingAddressObj.phone = "+12122289682";
            billingAddressObj.country = "US";
            
            // console.log( billingAddressObj );
            loadKlarnaWidget(paymentType, this.clientToken);
        }

        function generateBillingAddressObj(){

            var email = document.getElementById("inputEmail").value;
            var given_name = document.getElementById("inputFirstName").value;
            var family_name = document.getElementById("inputLastName").value;
            var street_address = document.getElementById("inputStreetAddress").value;
            var state = document.getElementById("inputState").value;
            var zip = document.getElementById("inputZip").value;
            var aparment = document.getElementById("inputAparment").value;
            var city = document.getElementById("inputCity").value;
            var phone = document.getElementById("inputPhone").value;

            billingAddressObj.given_name = given_name;
            billingAddressObj.family_name = family_name;
            billingAddressObj.email = email;
            billingAddressObj.title = "Mr";
            billingAddressObj.street_address = street_address;
            billingAddressObj.postal_code = zip;
            billingAddressObj.city = city;
            billingAddressObj.region = "United States";
            billingAddressObj.phone = phone;
            billingAddressObj.country = "US";
            
            console.log( billingAddressObj );
            
            var paymentType = "pay_over_time";
        
            loadKlarnaWidget(paymentType, clientToken);

        }

        // window.onload = function() {
        // function loadKlarnaWidget(paymentType, client_token) {
        function loadKlarnaWidget(paymentType, clientToken) {
            console.warn("Hello");
            // var me = this;

            if (!clientToken || clientToken.length === 0) {
                return;
            }
            
            if (!paymentType || paymentType.length === 0) {
                return;
            }

            if (!window.Klarna) {
                return;
            }

            Klarna.Payments.init({
                client_token: clientToken
            });
            
            Klarna.Payments.load({
                    container: "#klarna-container",
                    payment_method_category: paymentType
                }, {
                    //orderline updates here if needed
                },
                function(res) {
                    widgetLoaded = true;
                    console.log(res);
                }
            );
        }

        function authorizePayment(  ){
            var paymentType = "pay_over_time";
            var authorizeData = {
                    purchase_country: "US",
                    purchase_currency: "USD",
                    locale: "en-US",
                    billing_address: {
                        given_name: billingAddressObj.given_name,
                        family_name: billingAddressObj.family_name,
                        email: billingAddressObj.email,
                        title: billingAddressObj.title,
                        street_address: billingAddressObj.street_address,
                        postal_code: billingAddressObj.postal_code,
                        city: billingAddressObj.city,
                        region: billingAddressObj.region,
                        phone: billingAddressObj.phone,
                        country: billingAddressObj.country
                    },
                    order_amount: orderItem.total_amount,
                    order_tax_amount: orderItem.tax_rate,
                    order_lines: [{
                        type: "digital",
                        reference: orderItem.reference,
                        name: orderItem.name,
                        quantity: orderItem.quantity,
                        unit_price: orderItem.unit_price,
                        tax_rate: orderItem.tax_rate,
                        total_amount: orderItem.total_amount,
                        total_discount_amount: 0,
                        total_tax_amount: orderItem.tax_rate,
                        product_url: "https://www.klarna.com/demo/static/images/products/t-shirt.jpg",
                        image_url: "https://www.klarna.com/demo/static/images/products/t-shirt.jpg"
                    }],
                    customer: {
                        date_of_birth: "1970-01-01",
                    },
                };
            
            // console.log( authorizeData );

            Klarna.Payments.authorize({
                    payment_method_category: paymentType
                }, 
                authorizeData,
                function(res) {

                    console.log(res);
                    
                    if ( res.approved ) {
                        
                        // this.authorizeApproved = true;

                        if( res.authorization_token ) {
                            
                            
                            console.warn( res.authorization_token );
                            
                            var _token   = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: "/us/klarna/place-order",
                                type:"POST",
                                data:{
                                    authorizationToken: res.authorization_token,
                                    order_id: orderItem.reference,
                                    _token: _token
                                },
                                success:function(authorization_response){
                                    
                                    console.log(authorization_response);

                                    if( authorization_response.fraud_status == "ACCEPTED" ) {
                                        document.location.href = authorization_response.redirect_url;
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });

                        }

                        // me.$el.submit();

                    } else {
                        // redirect to fail page

                    }
                }
            );
        }
        
        
    </script>
</body>

</html>