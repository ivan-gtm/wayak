<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    
    <link rel="stylesheet" href="{{ asset('assets/admin/tags/bootstrap-tagsinput.css') }}">
    
    <title>Create Product</title>
  </head>
  <body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center" lang="en">TRANSLATE PRODUCT METADATA</h1>
            </div>
            <div class="col-12">
                <input type="hidden" id="template_key" name="template_key" value="{{ $template_key }}">
                <input type="hidden" id="language_from" name="language_from" value="{{ $from }}">
                <input type="hidden" id="language_to" name="language_to" value="{{ $to }}">
                {!! $template_text !!}
                <p id="bulk-translate-status" lang="en">TEMPLATE READY</p>
                <button id="bulk-translate" type="button" class="btn btn-primary" lang="en" onclick="translateTemplate()">TEMPLATE READY</button>
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
        var template_data = {};

        $( document ).ready(function() {
            $("html, body").animate({ scrollTop: 0 }, "slow");

            setTimeout( function(){ 
                // alert("Hello"); 
                $("html, body").animate({ scrollTop: $(document).height() }, 1000);
            }, 1000);
        });

        function getTranslationText(){
            var template = [];
            
            $( "ul.template-content" ).each(function( parent_index ) {
                var $this = $(this);
                var template_text = [];
                $this.children("li").each(function( child_index ){
                        template_text[child_index] = $(this).text();
                        // $this; // parent ul
                        // $(this).; // child li
                        // console.log( child_index + ": " + $(this).text() );
                });

                template[parent_index] = {
                    key: $(this).attr('data-template-id'),
                    template_text: template_text
                };
            });

            console.log( template );
            return template;
        }

        // function sendAJAX(templates_text){
        // }

        function translateTemplate(){
            // var template_data = {};
            
            templates_text = getTranslationText();
            // console.log(templates_text);
            // sendAJAX(templates_text);

            $.ajax({
                type:'POST',
                url:'{{ route('admin.bulkTranslate', [
                    'from' => $from,
                    'to' => $to
                ]) }}',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'templates_text': templates_text,
                    'language_from': $('#language_from').val(),
                    'language_to': $('#language_to').val()
                },
                success:function(data) {
                    console.log("RECARGA AHORA");
                    // location.reload();
                }
            });
            
            // $( "ul#template-content>li" ).each(function( index ) {
            //     // console.log( index + ": " + $( this ).text() );
            //     template_data[index] = $( this ).text();
            // });
            return 1;

        }
    </script>
  </body>
</html>