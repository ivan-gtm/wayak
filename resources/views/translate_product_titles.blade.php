<html>

<head>
    <title>
      WAYAK TRANSLATOR
    </title>
    <style>
      body{
        background-color: #fbfbfb !important;
      }
    </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="text-center title">NOMBRE ORIGINAL</h5>
            <h3 class="text-center">
              {{ $title->name }} 
            </h3>
          </div>
        </div>
        <br>
      </div>

      <div class="col-12" id="sort-title-container">
        <div class="card">
          <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-center title">ORDENAR NOMBRE</h5>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <style>
                        #sortable { list-style-type: none; margin: 0; padding: 0; }
                        #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; float: left; }
                    </style>
                    <ul id="sortable">
                      @for ($i = 0; $i < sizeof($title_words[1]); $i++)
                        @if ($title_words[1][$i] <> "")
                          <li class="ui-state-default">
                            {{ $title_words[1][$i] }}
                          </li>
                        @endif
                      @endfor
                    </ul>
                </div>
                <div class="col-12 d-none d-sm-block">
                  <h5 class="text-center title">DESCRIPCION</h5>
                  <div>
                    {!! $description !!}
                  </div>
                  <textarea class="form-control" id="description" name="description"></textarea>
                </div>
            </div>
            
            <div class="row p-2">
              <div class="col-3">
                <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="customizeTitle()">PERSONALIZAR TITULO</button>
              </div>
              <div class="col-9">
                <button type="button" onclick="saveTranslation()" class="btn btn-primary btn-lg btn-block">GUARDAR CAMBIOS</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 d-none" id="customize-title-container">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <h5 class="text-center title">PERSONALIZAR TITULO</h5>
                <!-- <label for="exampleFormControlTextarea1">TRADUCCI&Oacute;N FINAL</label> -->
                <textarea class="form-control" id="final-sentence" name="final-sentence"></textarea>
                <br>
                <button type="button" onclick="saveTranslation()" class="btn btn-primary btn-lg btn-block">GUARDAR CAMBIOS</button>
              </div>  
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/css/base/jquery.ui.all.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.2/css/lightness/jquery-ui-1.10.2.custom.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        });
        
        $('#sortable').bind("DOMSubtreeModified",function(){
          console.log( " KOKOKOKOKOKOKOKOKOKOKOKOKOKOKOKOKOKOKOKO " );

          var final_sentence = "";

          $.each( $('#sortable > li') , function( k, v ) {
            console.log( "Key: " + k );
            console.log( $(v).text().trim() );
            final_sentence += $(v).text().trim() + " ";
          });

          $('textarea#final-sentence').val(final_sentence);

        });

        function customizeTitle(){
          $('#sort-title-container').addClass('d-none');
          $('#customize-title-container').removeClass("d-none");
        }

        function saveTranslation(){
          var translation = $('#final-sentence').val();
          var description = $('#description').val();

          // alert(translation);
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $.ajax({
            method: "POST",
            url: "{{ URL::to('/translate/product-title/update') }}",
            data: { 
              product_id: {{ $title->product_id }}, 
              description: description,
              translation: translation 
            }
          })
          .done(function( msg ) {
              // alert( "Data Saved: " + msg );
              location.reload();
          });
          
        }
    </script>

</body>

</html>