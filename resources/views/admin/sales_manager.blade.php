@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('css')
  <style>
        .box {
          position: relative;
          margin: 20px auto;
          /* width: 400px;
          height: 350px; */
          background: #fff;
          border-radius: 2px;
        }

        .box::before,
        .box::after {
          content: '';
          position: absolute;
          bottom: 10px;
          width: 40%;
          height: 10px;
          box-shadow: 0 5px 14px rgba(0,0,0,.7);
          z-index: -1;
          transition: all .3s ease-in-out;
        }

        .box::before {
          left: 15px;
          transform: skew(-5deg) rotate(-5deg);
        }

        .box::after {
          right: 15px;
          transform: skew(5deg) rotate(5deg);
        }

        .box:hover::before,
        .box:hover::after {
          box-shadow: 0 2px 14px rgba(0,0,0,.4);
        }

        .box:hover::before {
          left: 5px;
        }

        .box:hover::after {
          right: 5px;
        }
  </style>
@endsection

@section('content')
    <div class="container-fluid">
      @if($active_campaign == null)
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">SALES</h1>
            </div>
        </div>
        <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('admin.sales_manager') }}">
          @csrf
          <div class="row">
              "Site Banner"
              <input type="text" name="site_banner_txt" id="site_banner_txt" value="Design Deals are on! Stock up on design essentials up to 50% off.">
              "Site Banner Button"
              <input type="text" name="site_banner_btn" id="site_banner_btn" value="Shop and save now!">
              <!-- "sale_status"
                  <div class="ftorm-check">
                      <input class="form-check-input" type="radio" name="sale_status" id="sale_status1" value="active" checked>
                      <label class="form-check-label" for="sale_status1">
                          Active
                      </label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="sale_status" id="sale_status2"  value="inactive">
                      <label class="form-check-label" for="sale_status2">
                        Inactive
                      </label>
                  </div> -->
              <br>
              <br>
              <hr>
              <br>
              "discount_percentage"
                  <input type="number" name="discount_percentage" min="1" max="100" step="1" id="discount_percentage">
              "sale_end"
                  <input type="datetime-local" name="sale_ends_at" id="sale_ends_at">

                <input type="submit" value="SEND">
          </div>
        </form>
      @else
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">ACTIVE CAMPAIGN</h1>
                <h3>Sale Ends at: {{ $active_campaign['sale_ends_at'] }}</h3>
                <h3>Discount Percentage: {{ $active_campaign['discount_percentage'] }}%</h3>
                <a href="?delete_campaign=true">Delete Campaing</a>
            </div>
        </div>
        
      @endif
    </div>
@endsection
    

