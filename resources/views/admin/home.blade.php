<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    
    <link rel="stylesheet" href="{{ asset('assets/admin/tags/bootstrap-tagsinput.css') }}">

    <title>ADMIN HOME</title>

  </head>
  <body>
    
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Plantillas</h1>
            </div>
            
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('green.products', [ 'category_id' => 201 ]) }}" class="card-link">
                                        1 .- Corregir formato de plantillas ( Falta ajustar formato )
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route( 'admin.ml.getFormatReady' ) }}" class="card-link">
                                        2.- Plantillas editadas ( Formato OK )
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route( 'admin.bulkTranslateText', ['from' => 'en', 'to' => 'es'] ) }}" class="card-link">
                                        3.- Traducción masiva
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route( 'admin.ml.getMissingTranslation' ) }}" class="card-link">
                                        4.- Plantillas traducidas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route( 'admin.ml.templatesReadyForSale' ) }}" class="card-link">
                                        5.- Falta editar metadatos ( Ficha del producto )
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route( 'admin.ml.templatesReadyForSale' ) }}" class="card-link">
                                        6.- Plantillas listas para la venta ( formato, lenguage, descripción del producto ).
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route( 'admin.template.gallery', ['country' => 'mx'] ) }}" class="card-link">
                                        7.- Generar imagenes "vistas previa de producto"
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route( 'admin.template.gallery', ['country' => 'mx'] ) }}" class="card-link">
                                        8.- Plantillas en venta ( Mercado Libre )
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            
        </div>
        <div class="row">
            <div class="col-12">
                <h1>Clientes</h1>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.manageCodes', ['country' => 'mx'] ) }}" class="card-link">Administrar Codigos</a>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-12">
                <h1>Mercado Libre</h1>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <a href="route('admin.ml.editMetadata')" class="card-link">
                            Editar descripción productos
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <a href="route('admin.ml.generateExcel')" class="card-link">
                            Excel -  Subir productos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1>ETSY</h1>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="route('etsy.editMetadata')" class="card-link">
                            Editar Metadata
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
                    <div class="col-12">
                        <h1>Crello</h1>
                    </div>
        </div>
        <div class="col-12">
                    <div class="col-12">
                        <h1>Green</h1>
                    </div>
        </div>
        <div class="col-12">
                    <div class="col-12">
                        <h1>Over</h1>
                    </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper.js and Bootstrap JS
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/tags/bootstrap-tagsinput.min.js') }}"></script>
    <script>
       
    </script>
  </body>
</html>