<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">

                        <li class="page-item">
                            <a class="page-link" href="{{ route('crello.explore', ['page'=>1]) }}">
                                First
                            </a>
                        </li>

                        @for ($i = $page_from; $i < $page_to; $i++)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('crello.explore', ['page'=>$i]) }}">
                                    Page {{ $i }}
                                </a>
                            </li>    
                        @endfor
                        
                        <li class="page-item">
                            <a class="page-link" href="{{ route('crello.explore', ['page'=>$total_pages]) }}">
                                Last {{ $total_pages }}
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row">
            @foreach ($product_result->results as $product )
                <div class="col-3">
                    <a href="{{ route('admin.edit.template', [
                        'language_code' => 'en',
                        'template_key' => $product->id
                    ]) }}">
                        <img class="img-fluid" src="/design/template/{{ $product->id }}/thumbnails/preview.jpg">
                    </a>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">

                        <li class="page-item">
                            <a class="page-link" href="{{ route('crello.explore', ['page'=>1]) }}">
                                First
                            </a>
                        </li>

                        @for ($i = $page_from; $i < $page_to; $i++)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('crello.explore', ['page'=>$i]) }}">
                                    Page {{ $i }}
                                </a>
                            </li>    
                        @endfor
                        
                        <li class="page-item">
                            <a class="page-link" href="{{ route('crello.explore', ['page'=>$total_pages]) }}">
                                Last {{ $total_pages }}
                            </a>
                        </li>
                    </ul>
                </nav>
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
  </body>
</html>