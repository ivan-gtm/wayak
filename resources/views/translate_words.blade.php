<html>

<head>
    <title>
      WAYAK TRANSLATOR
    </title>
    <style>
      body{
        background-color: #fbfbfb !important;
      }
        
      #elements-container {
          text-align: center;
          -webkit-user-select: none;  /* Chrome all / Safari all */
          -moz-user-select: none;     /* Firefox all */
          -ms-user-select: none;      /* IE 10+ */
          user-select: none;  
      }
      
      .draggable-element {
          display: inline-block;
          width: auto;
          /* height: 200px; */
          background: white;
          border: 1px solid rgb(196, 196, 196);
          line-height: 50px;
          text-align: center;
          margin: 10px;
          color: rgb(51, 51, 51);
          font-size: 25px;
          cursor: move;
          padding: 0 10px;
      }
      
      .drag-list {
          width: 400px;
          margin: 0 auto;
      }
      
      .drag-list > li {
          list-style: none;
          background: rgb(255, 255, 255);
          border: 1px solid rgb(196, 196, 196);
          margin: 5px 0;
          font-size: 24px;
      }
      
      .drag-list .title {
          display: inline-block;
          width: 130px;
          padding: 6px 6px 6px 12px;
          vertical-align: top;
      }
      
      .drag-list .drag-area {
          display: inline-block;
          background: rgb(158, 211, 179);
          width: 60px;
          height: 40px;
          vertical-align: top;
          float: right;
          cursor: move;
      }
      
      .title{
        color: lightgray;
      }
    </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="text-center title">PALABRA EN INGLES</h5>
            <h1 class="text-center">
              {{ $word->keyword }}
            </h1>
            <div class="row">
                <div class="col-12 text-center">¿ Tiene traducción ?</div>
                <div class="col-6">
                    <button class="btn btn-outline-success btn-lg btn-block" onclick="hasTranslation(1)">SI</button>
                </div>
                <div class="col-6">
                    <button class="btn btn-outline-danger btn-lg btn-block" onclick="hasTranslation(0)">NO</button>
                </div>
            </div>
          </div>
        </div>
        <br>
      </div>

      <div class="col-12" id="customize-title-container">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <h5 class="text-center title">TRADUCCI&Oacute;N</h5>
                <!-- <label for="exampleFormControlTe""xtarea1">TRADUCCI&Oacute;N FINAL</label> -->
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" id="word_id" name="word_id" value="{{ $word->id }}">
                <input type="text" class="form-control" id="final-sentence" name="final-sentence" autofocus>
                <br>
                <button type="button" onclick="saveTranslation()" class="btn btn-primary btn-lg btn-block">GUARDAR TRADUCCI&Oacute;N</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  

    <!-- <section class="showcase showcase-2">
        <h3>Example 2</h3>
        <ul class="drag-list">
            <li><span class="title">list 1</span><span class="drag-area"></span></li>
            <li><span class="title">list 2</span><span class="drag-area"></span></li>
            <li><span class="title">list 3</span><span class="drag-area"></span></li>
            <li><span class="title">list 4</span><span class="drag-area"></span></li>
            <li><span class="title">list 5</span><span class="drag-area"></span></li>
            <li><span class="title">list 6</span><span class="drag-area"></span></li>
            <li><span class="title">list 7</span><span class="drag-area"></span></li>
        </ul>
    </section>

    <section class="code">
        <pre>$('li').arrangeable({dragSelector: '.drag-area'});
      </pre>
    </section> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/drag-arrange.js"></script>

    <script type="text/javascript">
      function saveTranslation(){
        var translation = $('#final-sentence').val();
        var word_id = $('#word_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          method: "POST",
          url: "{{ URL::to('/translate/words/save-translation') }}",
          data: { word_id: word_id, translation: translation }
        })
        .done(function( msg ) {
            // alert( "Data Saved: " + msg );
            location.reload();
        });

      }

      function hasTranslation(has_translation_value){
        
        // alert(translation);
        var word_id = $('#word_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          method: "POST",
          url: "{{ URL::to('/translate/words/update') }}",
          data: { word_id: word_id, has_translation: has_translation_value }
        })
        .done(function( msg ) {
            // alert( "Data Saved: " + msg );
            location.reload();
        });

      }
      
      $('#final-sentence').keypress(function(event) { 
            if (event.keyCode === 13) { 
                saveTranslation();
            } 
      }); 

    </script>

</body>

</html>