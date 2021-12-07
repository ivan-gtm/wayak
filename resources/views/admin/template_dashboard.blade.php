<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <img src="{{ $template_info['thumbnail'] }}" class="img-fluid" alt="...">
                
                <h1>Preview Images</h1>
            </div>
            <div class="col-6">
                <h1> {{ $title }} </h1>
                <div class="alert alert-secondary" role="alert">
                    <a href="{{ route('admin.createProduct',[
                                'template_key' => $template_id
                            ]) }}">
                        Edit Product
                    </a>
                </div>
                <div class="alert alert-secondary" role="alert">
                    @if( isset($canva_url) )
                        <a href="{{ $canva_url }}">
                            Canva Template URL
                        </a>
                    @else
                        <form action="" method="post" action="{{ route('admin.etsy.templateDashboard',[
                                'app' => $app,
                                'template_id' => $template_id
                            ]) }}">
                            @csrf
                            <div class="form-group">
                                <label for="canvaURLInput">Canva Template URL</label>
                                <input type="text" class="form-control" id="canvaURLInput" name="canvaURLInput" placeholder="Canva URL">
                            </div>
                            <button type="submit" class="btn btn-primary">SAVE URL</button>
                        </form>
                    @endif
                </div>
                <div class="alert alert-secondary" role="alert">
                    <a target="_blank" href="{{ $pdf_url }}">
                        Generate PDF / GET PDF
                    </a>
                </div>
                <div class="alert alert-secondary" role="alert">
                    <a href="{{ route('admin.etsy.templateAssets',[
                            'app' => $app,
                            'template_id' => $template_id
                        ]) }}">
                        View Assets
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    
  </body>
</html>