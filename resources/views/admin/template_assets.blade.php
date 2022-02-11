<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                {{ $path }}
            </div>
            <div class="col-6">
                <img src="{{ $template_info['thumbnail'] }}" class="img-fluid" alt="...">
            </div>
            <div class="col-6">
                @foreach($template_objects['pages'] as $page)
                    @foreach($page['text'] as $text)
                        <div class="alert alert-secondary" role="alert">
                            <button style="background-color:{{ $text['color'] }}" class="templateTxt">
                                {{ $text['color'] }}
                            </button>
                            <button class="templateTxt">
                                {{ $text['text'] }}
                            </button>
                            <br>
                            <hr>
                            <button class="templateTxt">
                                {{ str_replace(' ', '', $text['text']) }}
                            </button>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
        
        <div class="row">
            @foreach($template_objects['pages'] as $page)
                <div class="col-12">
                    <hr>
                    PAGE {{ $loop->index }}
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @if( isset($page['images']) )
                        @foreach($page['images'] as $image)
                            <div class="col">
                                <div class="card">
                                    <a href="{{ $image['src'] }}" target="_blank">
                                        <img src="{{ $image['src'] }}" class="card-img-top" alt="...">
                                    </a>
                                    <div class="d-grid gap-2">
                                        <button href="{{ $image['src'] }}" class="templateIMG btn btn-primary" type="button">COPY</button>
                                        <a href="{{ $image['src'] }}" class="templateIMG btn btn-primary" download>DOWNLOAD</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                <div class="status">
                    <p>Can write ? <span id="can-write"></span></p>
                    <p id="errorMsg"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            
            const canWriteEl = document.getElementById('can-write')
            const errorEl = document.getElementById('errorMsg')

            async function askWritePermission() {
                try {
                    const { state } = await navigator.permissions.query({ name: 'clipboard-write', allowWithoutGesture: false })
                    return state === 'granted'
                } catch (error) {
                    errorEl.textContent = `Compatibility error (ONLY CHROME > V66): ${error.message}`
                    console.log(error)
                    return false
                }
            }

            const canWrite = await askWritePermission()

            canWriteEl.textContent = canWrite
            canWriteEl.style.color = canWrite ? 'green' : 'red'

            // copyImgBtn.disabled = copyTextBtn.disabled = !canWrite

            const setToClipboard = blob => {
                
                console.log(blob.type);

                const data = [new ClipboardItem({ [blob.type]: blob })]
                return navigator.clipboard.write(data)
            }

            /**
            * @param Blob - The ClipboardItem takes an object with the MIME type as key, and the actual blob as the value.
            */

            var total_text_objects_length = document.getElementsByClassName('templateTxt').length;
            var total_text_objects = document.getElementsByClassName('templateTxt');

            for (let txt_index = 0; txt_index < total_text_objects_length; txt_index++) {
                const element = total_text_objects[txt_index];
                // console.log(element.innerText);
                element.addEventListener('click', async () => {
                    try {
                        const blob = new Blob([element.innerText], { type: 'text/plain' })
                        await setToClipboard(blob)
                    } catch (error) {
                        console.error('Something wrong happened')
                    }
                })
            }
            
            var total_img_objects_length = document.getElementsByClassName('templateIMG').length;
            var total_img_objects = document.getElementsByClassName('templateIMG');

            for (let img_index = 0; img_index < total_img_objects_length; img_index++) {
                const element = total_img_objects[img_index];
                // console.log(element.innerText);
                element.addEventListener('click', async () => {
                    // try {
                        const response = await fetch( element.getAttribute('href') )
                        const blob = await response.blob()
                        await setToClipboard(blob)
                    // } catch (error) {
                    //     console.error('Something wrong happened')
                    //     console.error(error)
                    // }
                })
            }
        })
    </script>

  </body>
</html>