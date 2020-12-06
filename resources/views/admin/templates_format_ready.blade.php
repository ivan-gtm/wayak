@extends('layouts.admin')

@section('title', 'Plantillas Formato Listo')

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
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Plantillas con formato listo.</h1>
            </div>
            @foreach ($templates as $product_info )
                <div class="col-3 box">
                    <a class="translate-template"  
                            href="{{ route('admin.edit.template', [
                              'language_code' => $language_code,
                              'template_key' => $product_info['key']
                        ]) }}">
                        <img class="img-fluid" src="{{ $product_info['thumbnail'] }}">
                    </a>
                    <br>
                    <div class="row text-center">
                      <div class="col-12">
                        <p>{{ $product_info['key'] }}</p>
                      </div>
                      <!-- <div class="col-6">
                        <a href="{{ route( 'admin.translate.template', [
                          'template_key' => $product_info['key'],
                          'from' => 'en',
                          'to' => $language_code
                        ] ) }}">TRADUCIR</a>
                      </div> -->
                      <div class="col-12">
                        <a class="translate-template"  
                            href="{{ route('admin.edit.template', [
                              'language_code' => $language_code,
                              'template_key' => $product_info['key']
                          ]) }}">EDITAR PLANTILLA</a>
                      </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection