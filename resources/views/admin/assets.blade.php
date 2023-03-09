<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/assets/app.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css"> -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Static Assets</title>
  <style>
    img.img-fluid {
      min-width: 150px;
      max-height: 800px;
    }

    .bootstrap-tagsinput .tag {
      margin-right: 2px;
      color: white;
      background: red;
      padding: 1px 6px;
      border-radius: 4px;
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
        @if( $img->status != 2 )
        <input type="checkbox" name="imageToQueue" id="img{{ ($img->id) }}" onclick="addImageToQueue({{ ($img->id) }})">
        @endif

        {{ ($loop->index) }} -
        {{ ($loop->index%6) }}
        <a href="{{ route('admin.setIMGKeywords',[
                  'img_id' => $img->id
                ]) }}" class="btn btn-primary" {{ $img->status == 2 ? "style=background-color:red;" : "style=background-color:transparent;border:none"  }}>

          <img class="img-fluid" src="{{ $img->src }}">
          <a href="{{ $img->path }}" onclick="return registerDownload( {{ $img->id }} );" download>
            DOWNLOAD
          </a>
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


  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    ASIGNAR KEYWORDS
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            <label for="basic-url" class="form-label">Product Title</label>
            <div class="input-group mb-3">
              <input name="title" type="text" class="form-control" id="title">
              <button class="btn btn-primary" onclick="copyToClipboard('title')">COPY TITLE</button>
            </div>

            <label for="basic-url" class="form-label">Keywords</label>
            <div class="input-group mb-3">
              <!-- <input name="keywords"  type="text" class="keywords form-control"> -->
              <select class="keywords" name="keywords" multiple data-role="tagsinput">

                <option value=""></option>

              </select>
              <button class="btn btn-primary" onclick="copyToClipboard('comma_keywords')">COPY KEYWORDS</button>
              <input id="comma_keywords" class="form-control d-none" value="">
            </div>

            <button type="button" onclick="saveKeyWords()" class="btn btn-primary d-grid gap-2 col-6 mx-auto">SAVE CHANGES</button>

            <label for="basic-url" class="form-label">Separado por comas</label>
            <input id="comma_separated_keywords" name="comma_separated_keywords" type="text" class="form-control">
            <button type="button" onclick="insertCommaSeparatedKeywords()" class="btn btn-primary">INSERT</button>

            <hr>

            <input name="search_keywords" type="text" class="form-control" id="search_keywords" placeholder="Search Keywords">
            <button id="searchKeywordsBtn" class="btn btn-primary" onclick="searchTerms()">BUSCAR</button>

            <hr>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
  <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script>
    var img_ids = [];
    var elt = $('select.keywords');

    elt.tagsinput();

    function addImageToQueue(img_id) {
      img_ids.push(img_id);

      console.log(img_ids);
      // console.log( img_id );

      // $.ajax({
      //         type:'POST',
      //         url:'{{ route('admin.assets.register_download') }}/',
      //         headers: {
      //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
      //         },
      //         data: {
      //           'img_id': img_id,
      //           'status': 1
      //         },
      //         success:function(data) {
      //           console.log("Imagen actualizada con exito");
      //         }
      // });
    }

    function registerDownload(img_id) {

      console.log(img_id);

      $.ajax({
        type: 'POST',
        url: '/',
        headers: {
          'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        data: {
          'img_id': img_id,
          'status': 1
        },
        success: function(data) {
          console.log("Imagen actualizada con exito");
        }
      });
    }

    function insertCommaSeparatedKeywords() {
      var keywords_element = document.getElementById("comma_separated_keywords");
      var commm = keywords_element.value.split(",");

      console.log("TAGS");

      commm.forEach(element => {
        console.log(element);
        elt.tagsinput('add', element);
      });

      keywords_element.value = '';
    }

    function searchTerms() {
      var search_term = document.getElementById("search_keywords");

      $.ajax({
          method: "GET",
          url: "{{ URL::to('/admin/assets-gallery/keywords/') }}" + "/" + search_term.value
        })
        .done(function(msg) {
          console.log(msg.keywords);
          // if( msg.keywords.size > 0 ){
          msg.keywords.forEach(element => {
            elt.tagsinput('add', element);
          });
          $("#search_keywords").val("");
          // }
        });
    }

    function saveKeyWords() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      var jqxhr = $.post("{{ route('admin.saveMultipleKeywords') }}", {
        
        img_ids: img_ids.toString(),
        keywords: $('select.keywords').val()
      }).done(function() {
        // window.location.href = "{{ route('admin.staticGallery') }}";
        window.location.reload();
      }).fail(function() {
        alert("error");
      }).always(function() {
        // alert( "finished" );
        // window.location.href = "";
        // window.location.replace("{{ route('admin.staticGallery') }}");
      });

    }

    $("#search_keywords").keyup(function(event) {
      if (event.keyCode === 13) {
        $("#searchKeywordsBtn").click();
      }
    });
  </script>

</body>


</html>