<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">

    <title>Codigos</title>
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
  </head>
  <body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">GESTIÓN DE PLANTILLAS</h1>
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
                      <div class="col-3">
                        <a href="{{ route( 'admin.translate.template', [
                          'template_key' => $product_info['key'],
                          'from' => 'en',
                          'to' => $language_code
                        ] ) }}">TRANSLATE</a>
                      </div>
                      <div class="col-3">
                        <a href="{{ route('code.create', [
                            'country' => 'mx',
                            'code' => $product_info['key']
                        ] ) }}">GENERAR CODIGO</a>
                      </div>
                      <div class="col-3">
                        @if( $product_info['translation_ready'] )
                          <a href="{{ route('admin.edit.template', [
                              'language_code' => $language_code,
                              'template_key' => $product_info['key']
                          ]) }}">EDITAR PLANTILLA</a>
                        @endif
                      </div>
                      <div class="col-3">
                        @if( $product_info['mp_modelo'] > 0 )
                          <a href="{{ route('plantilla.demo', [
                            'modelo_mercado_pago' => $product_info['mp_modelo'],
                            'country' => $country,
                          ] ) }}">DEMO MP</a>
                        @endif
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
  </body>
</html>