<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">

    <title>Codigos</title>
</head>

<body>


    <h2 class="mb-4">Create Promotional Code</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="container">
        
        @if(request('type') == '') 
            <div class="row">
                <div class="col-sm-12">
                    <h1>Select code type:</h1>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">By Category</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="{{ route('admin.code.manage', ['type' => 'category', 'country' => $country]) }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Any Product</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="{{ route('admin.code.manage', ['type' => 'any_product', 'country' => $country]) }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">By Product</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="{{ route('admin.template.gallery', ['country' => $country]) }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">At Checkout</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div> -->
            </div>
        @elseif(request('type') == 'category' && request('category') == '')
            Select category associated with the code:
            <div class="card" style="width: 18rem;">
                <ul class="list-group list-group-flush">
                    @foreach($categories as $category)
                        <li class="list-group-item">
                            <a href="{{ route('admin.code.manage', ['type' => 'category', 'country' => $country,'category' => $category{'id'}]) }}">{{ $category{'name'} }} - {{ $category{'total'} }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @elseif( 
            (request('type') == 'category' && request('category') != '') 
            || (request('type') == 'any_product') 
            || (request('type') == 'product' && request('product_id') != '') 
            )
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin.code.create',['country' => $country]) }}" method="GET">
                        <!-- CROSS Site Request Forgery Protection -->
                        @csrf
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        <input type="hidden" name="product_id" value="{{ request('product_id') }}">
                        <input type="hidden" name="category" value="{{ request('category') }}">

                        <!-- Field to select the discount type -->
                        <div class="form-group">
                            <label for="discountType">Discount Type</label>
                            <select class="form-control" id="discountType" name="discount_type" required>
                                <option value="">Select Discount Type</option>
                                <option value="free">Make Product Free</option>
                                <option value="percentage">Percentage Discount</option>
                                <option value="fixed">Fixed Price</option>
                            </select>
                        </div>

                        <!-- Percentage Discount Field -->
                        <div class="form-group percentage-field" style="display:none;">
                            <label for="percentageDiscount">Percentage Discount (Optional)</label>
                            <input type="number" class="form-control" id="percentageDiscount" name="percentage_discount" placeholder="Enter discount percentage" min="1" max="100" step>
                            <small id="percentageDiscountHelp" class="form-text text-muted">This will apply a discount on the regular product price if specified.</small>
                        </div>

                        <!-- Fixed Price Field -->
                        <div class="form-group fixed-field" style="display:none;">
                            <label for="fixedPrice">Fixed Price (Optional)</label>
                            <input type="text" class="form-control" id="fixedPrice" name="fixed_price" placeholder="Enter fixed price for the product">
                            <small id="fixedPriceHelp" class="form-text text-muted">This will override the final product price if specified.</small>
                        </div>

                        <div class="form-group">
                            <label for="numberOfRedeemers">How many people will be able to redeem this code?</label>
                            <input type="number" class="form-control" id="numberOfRedeemers" name="numberOfRedeemers" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="userRequirement">Select if people must be users of the platform.</label>
                            <select multiple class="form-control" id="userRequirement" name="userRequirement">
                                <option value="anonymous" selected>Anonymous</option>
                                <option value="logged_in">Only Logged in users</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expires_at">Select until when the code is valid.</label>
                            <input type="datetime-local" class="form-control" id="expires_at" name="expiresAt" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        @endif

        <div class="row">
            <div class="col-12">
                <h1 class="text-center">EXISTING CODES</h1>
            </div>
        </div>

        <div class="row mt-4">

            @foreach ($codes as $item)
            <div class="col-3">
                @if($item['code'])
                <div class="card text-white bg-success mb-3">
                    @else
                    <div class="card bg-light mb-3">
                        @endif
                        <!-- <div class="card-header">Header</div> -->
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                @if( $item['number_of_redeemers'] != '' && $item['number_of_redeemers'] == 0 )
                                    Fully redeemed code
                                @elseif(
                                    $item['expires_at'] != '' && 
                                    Carbon\Carbon::now()->gt( Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $item['expires_at']) )
                                )
                                    EXPIRED
                                @elseif(
                                    $item['expires_at'] != '' && 
                                    Carbon\Carbon::now()->lt( Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $item['expires_at']) )
                                )
                                    VALID
                                @endif
                            </h5>
                            <!-- <p class="card-text">
                                Some quick example text to build on the card title and make up the bulk of the card's content.
                            </p> -->
                            <h4 class="card-text text-center" style="font-size:15px">Type: {{ $item['type'] }}</h4>
                            <h4 class="card-text text-center" style="font-size:15px">Discount Type: {{ $item['discountType'] }}</h4>
                            <h1 class="card-text text-center">{{ $item['code'] }}</h1>
                            <h3 class="card-text text-center" style="font-size:15px">Product: {{ $item['product_id'] }}</h3>
                            <h3 class="card-text text-center" style="font-size:15px">Category: {{ $item['category_id'] }}</h3>
                            <h3 class="card-text text-center" style="font-size:15px">number_of_redeemers: {{ $item['number_of_redeemers'] }}</h3>
                            <h3 class="card-text text-center" style="font-size:15px">percentage_discount: {{ $item['percentage_discount'] }}</h3>
                            <h3 class="card-text text-center" style="font-size:15px">fixed_price: {{ $item['fixed_price'] }}</h3>
                            <h3 class="card-text text-center" style="font-size:15px">user_requirement: {{ $item['user_requirement'] }}</h3>
                            <h3 class="card-text text-center" style="font-size:15px">expires_at: {{ $item['expires_at'] }}</h3>
                            @if(isset($item['template_img']))
                                <img class="img-fluid" src="{{ $item['template_img'] }}">
                            @endif
                            <br>
                            <a href="{{ route('admin.code.delete', [ 'country' => $country, 'code' => $item['code'] ]) }}">
                                Eliminar
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper.js -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper.js and Bootstrap JS
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    -->
    <script>
    document.getElementById('discountType').addEventListener('change', function() {
        var value = this.value;
        var percentageField = document.querySelector('.percentage-field');
        var fixedField = document.querySelector('.fixed-field');
        percentageField.style.display = 'none';
        fixedField.style.display = 'none';

        if (value === 'percentage') {
            percentageField.style.display = 'block';
        } else if (value === 'fixed') {
            fixedField.style.display = 'block';
        }
    });
    </script>
</body>

</html>