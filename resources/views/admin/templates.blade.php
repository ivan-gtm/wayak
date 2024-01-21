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
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Templates</h1>
            </div>
            @foreach ($templates as $product_info )
                <div class="col-6 col-sm-2 box">
                    <a href="{{ route('admin.edit.template', [
                              'language_code' => $language_code,
                              'template_key' => $product_info['key']
                          ]) }}">
                        <img class="img-fluid" src="{{ $product_info['thumbnail'] }}">
                    </a>
                    <br>
                    <div class="row text-center">
                      <div class="col-12">
                        <p>
                          {{ $product_info['key'] }}<br>
                          {{ $product_info['title'] }}<br>
                          {{ $product_info['dimentions'] }}</p>
                      </div>
                      <div class="col-12">
                        <a href="{{ route('admin.edit.template', [
                            'language_code' => $language_code,
                            'template_key' => $product_info['key']
                        ]) }}">Edit Template</a>
                      </div>
                      <div class="col-12">
                        <a href="{{ 
                          route('admin.code.manage',[
                            'type' => 'product',
                            'country' => $country,
                            'product_id' => $product_info['key']
                          ])
                        }}">
                          GENERATE CODE
                        </a>
                      </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
          <!-- <div class="col-sm-12 col-md-5">
              <div class="dataTables_info" id="selection-datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
          </div> -->
          <div class="col-12 col-md-12">
              <div class="dataTables_paginate paging_simple_numbers" id="selection-datatable_paginate">
                <ul class="pagination pagination-rounded">
                    <li class="paginate_button page-item previous" id="selection-datatable_previous">
                      <a href="{{ route('admin.template.gallery',[
                        'country' => $country,
                        'page' => $current_page
                        -1]) }}" tabindex="0" class="page-link">
                          <i class="mdi mdi-chevron-left"></i>
                      </a>
                    </li>
                    @for ($page = 1; $page < $total_pages; $page++)
                      @if($current_page == $page)
                        <li class="paginate_button page-item active">
                      @else
                        <li class="paginate_button page-item ">
                      @endif
                        <a href="{{ route('admin.template.gallery',[
                          'country' => $country,
                          'page' => $page
                          ]) }}" tabindex="0" class="page-link">{{ $page }}</a>
                      </li>
                    @endfor
                    
                    <li class="paginate_button page-item next" id="selection-datatable_next">
                      <a href="{{ route('admin.template.gallery',[
                        'country' => $country,
                        'page' => $total_pages
                        ]) }}" tabindex="0" class="page-link">
                        <i class="mdi mdi-chevron-right"></i>
                      </a>
                    </li>
                </ul>
              </div>
          </div>
        </div>
    </div>
@endsection
    

