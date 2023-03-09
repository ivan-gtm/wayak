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
        <div class="col-12">
          <a class="btn btn-primary" href="{{ $img_path }}">OPEN IMAGE</a>
          <a class="btn btn-primary" href="{{ $img_path }}" download>DOWNLOAD</a>
        </div>
        <div class="col-6">
          <img class="img-fluid" src="{{ $img_src }}">
        </div>
          <div class="col-6">
            <label class="badge badge-primary">{{ $file_type }}</label>
            <label class="badge badge-primary">{{ $source }}</label>
            <br>

            <label for="basic-url" class="form-label">Product Title</label>
            <div class="input-group mb-3">
              <input name="title" type="text" class="form-control" id="title" value="{{ $title }}">
              <button class="btn btn-primary" onclick="copyToClipboard('title')">COPY TITLE</button>
            </div>
            
            <label for="basic-url" class="form-label">Keywords</label>
            <div class="input-group mb-3">
              <!-- <input name="keywords"  type="text" class="keywords form-control"> -->
              <select class="keywords" name="keywords" multiple data-role="tagsinput">
                @foreach ($image_keywords as $keyword)
                  <option value="{{ $keyword->word }}">{{ $keyword->word }}</option>
                @endforeach
              </select>
              <button class="btn btn-primary" onclick="copyToClipboard('comma_keywords')">COPY KEYWORDS</button>
              <input id="comma_keywords" class="form-control d-none" value="{{ $comma_keywords }}">
            </div>
            
            <button type="button" onclick="insertKeyWords()" class="btn btn-primary d-grid gap-2 col-6 mx-auto">SAVE CHANGES</button>

            <label for="basic-url" class="form-label">Separado por comas</label>
            <input id="comma_separated_keywords" name="comma_separated_keywords"  type="text" class="form-control">
            <button type="button" onclick="insertCommaSeparatedKeywords()" class="btn btn-primary">INSERT</button>

            <hr>
            
            <input name="search_keywords" type="text" class="form-control" id="search_keywords" placeholder="Search Keywords">
            <button id="searchKeywordsBtn" class="btn btn-primary" onclick="searchTerms()">BUSCAR</button>
            
            <hr>

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

      function copyToClipboard(element_id) {
        // Get the text field
        var copyText = document.getElementById(element_id);

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Alert the copied text
        // alert("Copied the text: " + copyText.value);
      }

      function insertCommaSeparatedKeywords(){
        var keywords_element = document.getElementById("comma_separated_keywords");
        var commm = keywords_element.value.split(",");
        commm.forEach(element => {
            elt.tagsinput('add', element);
        });
        
        keywords_element.value = '';

      }

      function searchTerms(){
        var search_term = document.getElementById("search_keywords");
        
        $.ajax({
          method: "GET",
          url: "{{ URL::to('/admin/assets-gallery/keywords/') }}" +"/"+ search_term.value
        })
        .done(function( msg ) {
            console.log(msg.keywords);
            // if( msg.keywords.size > 0 ){
              msg.keywords.forEach(element => {
                  elt.tagsinput('add', element);
              });
              $("#search_keywords").val("");
            // }
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