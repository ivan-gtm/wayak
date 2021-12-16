@extends('layouts.frontend')
    
    @section(' KLARNA DANIEL Gutierrez')

    @section('meta')
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    @endsection
    
    @section('css')
        <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    @endsection

@section('content')
<style>
    body {
        background-color: #F7F7F8;
        color:black;
    }

    .card {
        border: none
    }

    .logo {
        background-color: #eeeeeea8;
        padding-left: 39px;
    }

    .totals tr td {
        font-size: 13px
    }

    .footer {
        background-color: #eeeeeea8;
        padding: 17px 40px;
    }

    .footer span {
        font-size: 12px
    }

    .product-qty span {
        font-size: 12px;
        color: #dedbdb
    }
    .card{
        background-color: white;
        /* margin: 30px 0px; */
        box-shadow: 1px 5px 10px #dbdbdb;
    }
    .card > .invoice{
        padding: 10px 40px;
    }
    .card h5{
        font-size: 22px;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="invoice p-5">
                    <span class="font-weight-bold d-block mt-4">
                        Hello, Daniel Gutierrez
                    </span> 
                    <br>
                    <span>You order has been confirmed, below order details</span>
                    <br><br>

                    <a class="js-purchase__add-to-cart e-btn--3d -color-primary -size-m -width-full"
                        target="_blank">
                        <strong>Track Order</strong>
                    </a>
                    <br><br><br>
                    <h5 class="text-center">Order Details</h5>
                    <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="py-2"> 
                                            <span class="d-block text-muted">Order Date</span> 
                                            <span>{{ $klarnaOrder->created_at }}</span> 
                                        </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> 
                                            <span class="d-block text-muted">Klarna Order Id</span> 
                                            <span>
                                                {{ $klarnaOrder->order_id }}<br>
                                            </span> 
                                            <br>
                                            <span class="d-block text-muted">Klarna Reference</span> 
                                            <span>
                                                {{ $klarnaOrder->klarna_reference }}<br>
                                            </span> 
                                        </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> 
                                            <span class="d-block text-muted">Status</span> 
                                            <span>
                                                {{ $klarnaOrder->status }}
                                            </span> 
                                        </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> 
                                            <span class="d-block text-muted">Billing Address</span> 
                                            <span>
                                                {{ $klarnaOrder->billing_address->street_address }}<br>
                                                {{ $klarnaOrder->billing_address->street_address2 }}
                                                {{ $klarnaOrder->billing_address->postal_code }}
                                                {{ $klarnaOrder->billing_address->city }}
                                                {{ $klarnaOrder->billing_address->region }}
                                            </span> 
                                            <span class="d-block text-muted">e-mail</span> 
                                            <span>
                                                {{ $klarnaOrder->billing_address->email }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="product border-bottom table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                @foreach($klarnaOrder->order_lines as $product)
                                    <tr>
                                        <td width="20%"> <img src="https://www.klarna.com/demo/static/images/products/t-shirt.jpg" width="90"> </td>
                                        <td width="60%"> 
                                            <span class="font-weight-bold">
                                                {{ $product->name }}
                                            </span>
                                            <div class="product-qty"> 
                                                <span class="d-block">
                                                    Quantity: {{ $product->quantity }}
                                                </span>
                                            </div>
                                        </td>
                                        <td width="20%">
                                            <div class="text-right"> 
                                                <span class="font-weight-bold">$ {{ round( $product->total_amount / 100, 3 ) }}</span> 
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-5">
                            <br><br>
                            <table class="table table-borderless">
                                <tbody class="totals">
                                    <tr class="border-top border-bottom">
                                        <td>
                                            <div class="text-left"> <span class="font-weight-bold">Subtotal</span> </div>
                                        </td>
                                        <td>
                                            <div class="text-right"> 
                                                <span class="font-weight-bold">${{ round( $klarnaOrder->original_order_amount / 100 , 3 ) }}</span> 
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <p>We will be sending shipping confirmation email when the item shipped successfully!</p> -->
                    <p class="font-weight-bold mb-0">Thanks for shopping with us!</p>
                    <!-- <span>Wayak Team</span> -->
                </div>
                <div class="d-flex justify-content-between footer p-3"> <span>Need Help? visit our <a href="#"> help center</a></span> <span>12 June, 2020</span> </div>
            </div>
        </div>
    </div>
</div>

@endsection