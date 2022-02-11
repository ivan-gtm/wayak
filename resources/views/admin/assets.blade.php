<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
      img.img-fluid {
          min-width: 150px;
      }
    </style>
  </head>
  <body>
    
    <div class="container">
      <div class="row">
        <div class="col-12 p-2">
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" href="?page={{ $current_page-1 }}" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              @foreach ($pages as $page_number)
                <li class="page-item">
                  <a class="page-link" href="?page={{ $page_number }}">{{ $page_number }}</a>
                </li>
              @endforeach
              <li class="page-item">
                <a class="page-link" href="?page={{ $last_page }}" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      @foreach ($imgs as $img)
        @if( $loop->index == 0 || ($loop->index%6) == 1 )
          <div class="row">
        @endif
        
        <div class="col-2">
          {{ ($loop->index) }} - 
          {{ ($loop->index%6) }}
          <a href="{{ route('admin.setIMGKeywords',[
              'img_id' => $img->id
            ]) }}" class="btn btn-primary" 
             
            {{ $img->status == 1 ? "style=background-color:red;" : "style=background-color:transparent;border:none"  }}>

            <img class="img-fluid" src="{{ $img->src }}">
            <a href="{{ $img->path }}" download>DOWNLOAD</a>
          </a>
        </div>

        @if( $loop->index > 0 && ($loop->index%6) == 0 )
          </div>
        @endif
      @endforeach
      <div class="row">
        <div class="col-12 p-2">
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" href="?page={{ $current_page-1 }}" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              @foreach ($pages as $page_number)
                <li class="page-item">
                  <a class="page-link" href="?page={{ $page_number }}">{{ $page_number }}</a>
                </li>
              @endforeach
              <li class="page-item">
                <a class="page-link" href="?page={{ $last_page }}" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    
    <script>

    </script>

  </body>
</html>