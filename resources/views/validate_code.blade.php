@extends('layouts.frontend')
    
    @section('title', 'Redeem Template Code | WAYAK')
    @section('meta')

    @endsection
    
    @section('css')
        <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
        <style>
            /*! CSS Used from: https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css */
            :root{--bs-blue:#0d6efd;--bs-indigo:#6610f2;--bs-purple:#6f42c1;--bs-pink:#d63384;--bs-red:#dc3545;--bs-orange:#fd7e14;--bs-yellow:#ffc107;--bs-green:#198754;--bs-teal:#20c997;--bs-cyan:#0dcaf0;--bs-white:#fff;--bs-gray:#6c757d;--bs-gray-dark:#343a40;--bs-primary:#0d6efd;--bs-secondary:#6c757d;--bs-success:#198754;--bs-info:#0dcaf0;--bs-warning:#ffc107;--bs-danger:#dc3545;--bs-light:#f8f9fa;--bs-dark:#343a40;--bs-font-sans-serif:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--bs-font-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--bs-gradient:linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));}
            *,::after,::before{box-sizing:border-box;}
            body{margin:0;font-family:var(--bs-font-sans-serif);font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent;}
            h1,h3{margin-top:0;margin-bottom:.5rem;font-weight:500;line-height:1.2;}
            h1{font-size:calc(1.375rem + 1.5vw);}
            @media (min-width:1200px){
            h1{font-size:2.5rem;}
            }
            h3{font-size:calc(1.3rem + .6vw);}
            @media (min-width:1200px){
            h3{font-size:1.75rem;}
            }
            a{color:#0d6efd;text-decoration:underline;}
            a:hover{color:#024dbc;}
            button{border-radius:0;}
            button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color;}
            button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit;}
            button,input{overflow:visible;}
            button{text-transform:none;}
            [type=submit],button{-webkit-appearance:button;}
            ::-moz-focus-inner{padding:0;border-style:none;}
            .btn{display:inline-block;font-weight:400;line-height:1.5;color:#212529;text-align:center;text-decoration:none;vertical-align:middle;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
            @media (prefers-reduced-motion:reduce){
            .btn{transition:none;}
            }
            .btn:hover{color:#212529;}
            .btn:focus{outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
            .btn:disabled{pointer-events:none;opacity:.65;}
            .btn-primary{color:#fff;background-color:#0d6efd;border-color:#0d6efd;}
            .btn-primary:hover{color:#fff;background-color:#025ce2;border-color:#0257d5;}
            .btn-primary:focus{color:#fff;background-color:#025ce2;border-color:#0257d5;box-shadow:0 0 0 .25rem rgba(49,132,253,.5);}
            .btn-primary:active{color:#fff;background-color:#0257d5;border-color:#0252c9;}
            .btn-primary:active:focus{box-shadow:0 0 0 .25rem rgba(49,132,253,.5);}
            .btn-primary:disabled{color:#fff;background-color:#0d6efd;border-color:#0d6efd;}
            /*! CSS Used from: Embedded */
            #wrapper{font-size:1.5rem;text-align:center;box-sizing:border-box;color:#333;}
            #wrapper #dialog{margin:10px auto;padding:20px 30px;display:inline-block;overflow:hidden;position:relative;max-width:600px;}
            #wrapper #dialog h3{margin:0 0 10px;padding:0;line-height:1.25;font-size:19px;line-height:1.47059;font-weight:400;letter-spacing:-.022em;font-family:SF Pro Text,SF Pro Icons,Helvetica Neue,Helvetica,Arial,sans-serif;}
            #wrapper #dialog #form{max-width:300px;margin:25px auto 0;}
            #wrapper #dialog #form input{margin:0 5px;text-align:center;line-height:80px;font-size:50px;border:solid 1px #a7a7a7;box-shadow:0 0 5px #d6d6d6 inset;outline:none;width:20%;-webkit-transition:all 0.2s ease-in-out;transition:all 0.2s ease-in-out;border-radius:3px;}
            #wrapper #dialog #form input:focus{border-color:#d8d8d8;box-shadow:0 0 5px #969696 inset;}
            #wrapper #dialog #form input::-moz-selection{background:transparent;}
            #wrapper #dialog #form input::selection{background:transparent;}
            #wrapper #dialog #form button{margin:30px 0 3px;width:100%;padding:15px;background-color:#000;border:none;text-transform:uppercase;}
            #wrapper #dialog div{position:relative;z-index:1;}

        </style>
    @endsection
    
    @section('content')
        <div id="wrapper">
            <div id="dialog">
                <!-- <button class="close">×</button> -->
                <h1>WAYAK</h1>
                <h3>Se ha enviado un mensaje con un código de verificación de 4 dígitos a tu cuenta. Introduce el código para continuar.</h3>
                <!-- <h3>Ingrese el código de verificación de 4 dígitos que recibio:</h3> -->
                <!-- <span>(queremos asegurarnos de que sea usted antes de contactar a nuestros transportistas)</span> -->

                <div id="form">
                    <form method="post" action="{{ route('code.validate', [
                        'country' => $country
                    ]) }}">
                        <!-- CROSS Site Request Forgery Protection -->
                        @csrf    
                        <input name="templates" type="hidden" value="{{ $templates }}" />
                        <input name="digit1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" autofocus />
                        <input name="digit2" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input name="digit3" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input name="digit4" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        
                        <button type="submit" class="btn btn-primary btn-embossed">VERIFICAR CODIGO</button>
                        <a href="#" style="color: #b1b1b1;text-decoration: none;font-size: 15px;">
                            Usar versión demo
                        </a>
                    </form>
                </div>
                
                <!-- <div>
                Didn't receive the code?<br />
                <a href="#">Send code again</a><br />
                <a href="#">Change phone number</a>
                </div> -->
                <!-- <img src="http://jira.moovooz.com/secure/attachment/10424/VmVyaWZpY2F0aW9uLnN2Zw==" alt="test" /> -->
            </div>
        </div>
    @endsection

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(function() {
            'use strict';

            var body = $('body');

            function goToNextInput(e) {
                var key = e.which,
                t = $(e.target),
                sib = t.next('input');

                if (key != 9 && (key < 48 || key > 57)) {
                    e.preventDefault();
                    return false;
                }

                if (key === 9) {
                return true;
                }

                if (!sib || !sib.length) {
                sib = body.find('input').eq(0);
                }
                sib.select().focus();
            }

            function onKeyDown(e) {
                var key = e.which;

                if (key === 9 || (key >= 48 && key <= 57)) {
                return true;
                }

                e.preventDefault();
                return false;
            }
            
            function onFocus(e) {
                $(e.target).select();
            }

            body.on('keyup', 'input', goToNextInput);
            body.on('keydown', 'input', onKeyDown);
            body.on('click', 'input', onFocus);

        })
    </script>

    <!-- Option 2: Separate Popper.js and Bootstrap JS
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    -->
  </body>
</html>