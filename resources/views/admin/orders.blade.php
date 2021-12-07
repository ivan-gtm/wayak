@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
    <div class="content">
        <!-- Topbar Start -->
        
        <!-- end Topbar -->
        
        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Klarna: Integration Case Study</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Orders</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 
        
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                                    <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Payment Status</th>
                                            <th>Total</th>
                                            <th>Payment Method</th>
                                            <th>Order Status</th>
                                            <th style="width: 125px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><a href="apps-ecommerce-orders-details.html" class="text-body fw-bold">#BM9708</a> </td>
                                            <td>
                                                August 05 2018 <small class="text-muted">10:29 PM</small>
                                            </td>
                                            <td>
                                                <h5><span class="badge badge-success-lighten"><i class="mdi mdi-bitcoin"></i> Paid</span></h5>
                                            </td>
                                            <td>
                                                $176.41
                                            </td>
                                            <td>
                                                Mastercard
                                            </td>
                                            <td>
                                                <h5><span class="badge badge-info-lighten">Shipped</span></h5>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" class="action-icon"> <i class="fa-close"></i>Add Item</a>
                                                <a href="javascript:void(0);" class="action-icon"> <i class="fa-close"></i>Cancel Order</a>
                                                <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i> Refund Order</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row --> 
            
        </div> <!-- container -->

    </div>
@endsection