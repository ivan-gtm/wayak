<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/assets/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <title>Hello, world!</title>
  </head>
  <body style="
    background-color: #8b8b8b;
    color: white;
    padding-top:40px
">
    <div class="container">
      <div class="row">
        <div class="col-6">
          <img class="img-fluid" src="{{ $img_src }}">
          <a href="{{ $img_path }}">OPEN</a>
        </div>
          <div class="col-6">
            <label class="btn btn-outline-primary">{{ $file_type }}</label>
            <label class="btn btn btn-outline-warning">{{ $source }}</label>
            <br>

            <label for="basic-url" class="form-label">Product Title</label>
            <div class="input-group mb-3">
              <input name="title" type="text" class="form-control" id="title" value="{{ $title }}">
            </div>
            
            <label for="basic-url" class="form-label">Keywords</label>
            <div class="input-group mb-3">
              <!-- <input name="keywords"  type="text" class="keywords form-control"> -->
              <select class="keywords" name="keywords" multiple data-role="tagsinput">
                @foreach ($image_keywords as $keyword)
                  <option value="{{ $keyword->word }}">{{ $keyword->word }}</option>
                @endforeach
              </select>
            </div>

            <button type="button" onclick="insertKeyWords()" class="d-grid gap-2 col-6 mx-auto">SAVE CHANGES</button>

            <label for="basic-url" class="form-label">Recomendations</label>
            <div class="input-group mb-3">
              @foreach ($unique_keywords as $keyword)
                <button class="tag label label-info" onclick="addTag('{{$keyword}}')">{{ $keyword }}</button>
              @endforeach
            </div>
            
            <label for="basic-url" class="form-label">Recomendations</label>
            <div class="input-group mb-3">
              @foreach ($autocomplete as $keyword)
                <button class="tag label label-info" onclick="addTag('{{$keyword}}')">{{ $keyword }}</button>
              @endforeach
            </div>
            
            <label for="basic-url" class="form-label">Recomendations</label>
            <div class="input-group mb-3">
              @foreach ($tmp_similar_titles as $title)
                {{ $title }}<br>
              @endforeach
            </div>
            
            <label for="basic-url" class="form-label">Recomendations</label>
            <div class="input-group mb-3">
              @foreach ($tmp_similar_thumbs as $title)
                {{ $title }}<br>
              @endforeach
            </div>

          </div>
        <!-- </form> -->
      </div>
    </div>
     
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <script>
      // var cities = new Bloodhound({
      //   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
      //   queryTokenizer: Bloodhound.tokenizers.whitespace,
      //   prefetch: 'https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/assets/cities.json'
      // });

      // cities.initialize();

      var elt = $('select.keywords');
      elt.tagsinput();
      // elt.tagsinput('add', { "value": 1 , "text": "Amsterdam"   , "continent": "Europe"    });
      
      function insertKeyWords(){
        // console.log( $("select").val() );
        var jqxhr = $.post( "{{ route('admin.setIMGKeywords', $img_id) }}", { 
          _token: "{{ csrf_token() }}",
          img_id: "{{ $img_id }}",
          title: $("#title").val(), 
          keywords: $("select").val()
        }).done(function() {
          // alert( "second success" );
          window.location.href = "{{ route('admin.staticGallery') }}";
        }).fail(function() {
          alert( "error" );
        }).always(function() {
          // alert( "finished" );
          // window.location.href = "";
          // window.location.replace("{{ route('admin.staticGallery') }}");
        });
      
      }

      function addTag(tagValue){
        // elt.tagsinput('add', { "value": tagValue, "text": tagValue });
        elt.tagsinput('add', tagValue);

      }

    </script>
  </body>
</html>