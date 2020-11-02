<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    
    <link rel="stylesheet" href="{{ asset('assets/admin/tags/bootstrap-tagsinput.css') }}">
    
    <title>Create Product</title>
  </head>
  <body>
    
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">CREAR PRODUCTO</h1>
            </div>
            <div class="col-12">
                <form method="POST" action="/admin/etsy/templates/description">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <ul>
                            <li>
                                Template
                                <ul>
                                    <li>templateDemoUrl</li>
                                    <li>template_id</li>
                                </ul>
                            </li>
                            <li>wayakCatalogUrl</li>
                            <li>
                                Etsy
                                <ul>
                                    <li>etsyLinkStore</li>
                                    <li>etsyStoreCode</li>
                                    <li>estyStoreName</li>
                                </ul>
                            </li>
                        </ul>
                        <!-- <div id="descHelp" class="form-text">
                            Start with a brief overview that describes your item’s finest features. Shoppers will only see the first few lines of your description at first, so make it count!
                            
                            Not sure what else to say? Shoppers also like hearing about your process, and the story behind this item.
                        </div> -->

                        <textarea aria-describedby="descHelp" class="form-control" name="description" rows="25" required>{{ isset($description) ? $description : null }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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
        @if( isset($metadata->primaryColor) )
            $('select[name="primaryColor"] option:eq({{ $metadata->primaryColor }})').attr('selected', 'selected');
        @endif
        @if( isset($metadata->secondaryColor) )
            $('select[name="secondaryColor"] option:eq({{ $metadata->secondaryColor }})').attr('selected', 'selected');
        @endif
        @if( isset($metadata->occasion) )
            $('select[name="occasion"] option:eq({{ $metadata->occasion }})').attr('selected', 'selected');
        @endif
        @if( isset($metadata->holiday) )
            $('select[name="holiday"] option:eq({{ $metadata->holiday }})').attr('selected', 'selected');
        @endif

        // $(document).on("keydown", "form>input", function(event) { 
        //     return event.key != "Enter";
        // });
        $('input.tags').tagsinput({
            maxTags: 13,
            trimValue: true,
            allowDuplicates: false,
            confirmKeys: [44]
        });
        $('input.tags').on('itemAdded', function(event) {
            console.log( $("input.tags").val() );
        });
    </script>
  </body>
</html>