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
    
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">CREAR PRODUCTO</h1>
            </div>
            <div class="col-6">
                <img src="{{ $thumb_img_url }}">
            </div>
            <div class="col-6">
                <form method="POST" action="/admin/create-product/YzafhmI6HRLiObn">
                    @csrf
                        <div class="mb-3">
                            <label for="titleInput" class="form-label">Title (140 chars)</label>
                            <input type="text" class="form-control" name="title" aria-describedby="titleHelp" maxlength="140" required>
                            <div id="titleHelp" class="form-text">Include keywords that buyers would use to search for your item.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tags</label>
                            <div class="form-text">Use all 13 tags to get found</div>
                            <input class="tags" name="tags" type="text" value="Amsterdam,Washington,Sydney,Beijing,Cairo" data-role="tagsinput">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Colors</label>
                            <div id="primaryColorHelp" class="form-text">
                                Primary and secondary color attributes are interchangeable so you can show shoppers that your item is multicolored. Skip secondary color if your item is only one color.
                            </div>
                            <select class="form-select" aria-describedby="primaryColorHelp" name="primaryColor">
                                <option value="">Choose primary color</option>
                                <optgroup label="Primary color options">
                                    
                                    <option value="1213">Beige</option>
                                    <option value="1">Black</option>
                                    <option value="2">Blue</option>
                                    <option value="1216">Bronze</option>
                                    <option value="3">Brown</option>
                                    <option value="1219">Clear</option>
                                    <option value="1218">Copper</option>
                                    <option value="1214">Gold</option>
                                    <option value="5">Gray</option>
                                    <option value="4">Green</option>
                                    <option value="6">Orange</option>
                                    <option value="7">Pink</option>
                                    <option value="8">Purple</option>
                                    <option value="1220">Rainbow</option>
                                    <option value="9">Red</option>
                                    <option value="1217">Rose gold</option>
                                    <option value="1215">Silver</option>
                                    <option value="10">White</option>
                                    <option value="11">Yellow</option>
                                </optgroup>
                                <optgroup label="Offer multiple options?">
                                    <option value="__variation">I offer more than one</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tags Optional</label>
                            What words might someone use to search for your listings? Use all 13 tags to get found. Get ideas for tags.

                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="secondaryColor">
                                <option value="">Choose secondary color</option><optgroup label="Secondary color options">
                                <option value="1213">Beige</option>
                                <option value="1">Black</option>
                                <option value="2">Blue</option>
                                <option value="1216">Bronze</option>
                                <option value="3">Brown</option>
                                <option value="1219">Clear</option>
                                <option value="1218">Copper</option>
                                <option value="1214">Gold</option>
                                <option value="5">Gray</option>
                                <option value="4">Green</option>
                                <option value="6">Orange</option>
                                <option value="7">Pink</option>
                                <option value="8">Purple</option>
                                <option value="1220">Rainbow</option>
                                <option value="9">Red</option>
                                <option value="1217">Rose gold</option>
                                <option value="1215">Silver</option>
                                <option value="10">White</option>
                                <option value="11">Yellow</option></optgroup><optgroup label="Offer multiple options?">
                                <option value="__variation">I offer more than one</option></optgroup>
                            </select>
                        </div>

                        <div class="mb-3">
                            <div id="occasionHelp" class="form-text">
                                Occasion
                                Add to items designed for the occasion, for example graduation party decor, not for items that could be gifted for an occasion. You can skip this attribute if it isn’t relevant.
                            </div>
                            
                            <select aria-describedby="occasionHelp" class="form-select" name="occasion">
                                <option value="">Choose occasion</option>
                                <optgroup label="Occasion options">
                                    <option value="2773">1st birthday</option>
                                    <option value="12">Anniversary</option>
                                    <option value="13">Baby shower</option>
                                    <option value="14">Bachelor party</option>
                                    <option value="15">Bachelorette party</option>
                                    <option value="16">Back to school</option>
                                    <option value="17">Baptism</option>
                                    <option value="18">Bar &amp; Bat Mitzvah</option>
                                    <option value="19">Birthday</option>
                                    <option value="20">Bridal shower</option>
                                    <option value="21">Confirmation</option>
                                    <option value="26">Divorce &amp; breakup</option>
                                    <option value="22">Engagement</option>
                                    <option value="23">First Communion</option>
                                    <option value="24">Graduation</option>
                                    <option value="25">Grief &amp; mourning</option>
                                    <option value="27">Housewarming</option>
                                    <option value="2774">LGBTQ pride</option>
                                    <option value="50">Moving</option>
                                    <option value="28">Pet loss</option>
                                    <option value="29">Prom</option>
                                    <option value="30">Quinceañera &amp; Sweet 16</option>
                                    <option value="31">Retirement</option>
                                    <option value="32">Wedding</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mb-3">
                            <div id="holidayHelp" class="form-text">
                                Holiday
                                Add to items meant specifically for a holiday, for example a Mother’s Day card, not for items that could be gifted for a holiday. You can skip this attribute if it isn’t relevant.
                            </div>
                            <select aria-describedby="holidayHelp" class="form-select" name="holiday">
                                <option value="">Choose holiday</option>
                                <optgroup label="Holiday options">
                                    <option value="35">Christmas</option>
                                    <option value="36">Cinco de Mayo</option>
                                    <option value="37">Easter</option>
                                    <option value="38">Father's Day</option>
                                    <option value="39">Halloween</option>
                                    <option value="40">Hanukkah</option>
                                    <option value="41">Independence Day</option>
                                    <option value="42">Kwanzaa</option>
                                    <option value="34">Lunar New Year</option>
                                    <option value="43">Mother's Day</option>
                                    <option value="44">New Year's</option>
                                    <option value="47">Passover</option>
                                    <option value="45">St Patrick's Day</option>
                                    <option value="46">Thanksgiving</option>
                                    <option value="48">Valentine's Day</option>
                                    <option value="49">Veterans Day</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mb-3">
                            <div id="descHelp" class="form-text">
                                Description *
                                Start with a brief overview that describes your item’s finest features. Shoppers will only see the first few lines of your description at first, so make it count!
                                
                                Not sure what else to say? Shoppers also like hearing about your process, and the story behind this item.
                            </div>

                            <textarea aria-describedby="descHelp" class="form-control" name="description" required></textarea>
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