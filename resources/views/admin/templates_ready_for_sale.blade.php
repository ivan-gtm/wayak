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
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Plantillas con formato listo.</h1>
            </div>
            @foreach ($templates as $product_info )
                <div class="col-3 box">
                    <a href="{{ route('admin.ml.editMLMetadata',['template_key' => $product_info['key']]) }}">
                        <img class="img-fluid" src="{{ $product_info['thumbnail'] }}">
                    </a>
                    <br>
                    <div class="row text-center">
                      <div class="col-12">
                        <p>{{ $product_info['key'] }}</p>
                      </div>
                      <div class="col-6">
                        <a href="{{ route( 'admin.translate.template', [
                          'template_key' => $product_info['key'],
                          'from' => 'en',
                          'to' => $language_code
                        ] ) }}">TRADUCIR</a>
                      </div>
                      <!-- <div class="col-3">
                        <a href="{{ route('code.create', [
                            'country' => 'mx',
                            'code' => $product_info['key']
                        ] ) }}">GENERAR CODIGO</a>
                      </div> -->
                      <div class="col-6">
                        @if( $product_info['translation_ready'] )
                          <a class="translate-template"  
                            href="{{ route('admin.edit.template', [
                              'language_code' => $language_code,
                              'template_key' => $product_info['key']
                          ]) }}">EDITAR PLANTILLA</a>
                        @endif
                      </div>
                      <!-- <div class="col-3">
                        @if( $product_info['mp_modelo'] > 0 )
                          <a href="{{ route('plantilla.demo', [
                            'modelo_mercado_pago' => $product_info['mp_modelo'],
                            'country' => $country,
                          ] ) }}">DEMO MP</a>
                        @endif
                      </div> -->
                    </div>
                </div>
            @endforeach
        </div>
@endsection