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
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">GESTIÓN DE CODIGOS</h1>
            </div>
            <div class="col-12">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif

                <form method="post" action="">
                    <!-- CROSS Site Request Forgery Protection -->
                    @csrf
                </form>
                <a class="btn btn-primary btn-lg btn-block" href="{{ route('admin.template.gallery', ['country' => $country]) }}">
                    Generar Codigo
                </a>
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
                                @if( $item['code'] )
                                    Codigo Usado
                                @else
                                    Codigo sin usar
                                @endif
                            </h5>
                            <!-- <p class="card-text">
                                Some quick example text to build on the card title and make up the bulk of the card's content.
                            </p> -->
                            <h1 class="card-text text-center">{{ $item['code'] }}</h1>
                            <h3 class="card-text text-center" style="font-size:15px">{{ $item['code'] }}</h3>
                            <h4 class="card-text text-center" style="font-size:15px">{{ $item['type'] }}</h4>
                            <img class="img-fluid" src="{{ $item['template_img'] }}">
                            <br>
                            <a href="{{ route('code.delete', [ 'country' => $country, 'code' => $item['code'] ]) }}">
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
  </body>
</html>