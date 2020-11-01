<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">

    <title>Verificación de Codigo</title>
  </head>
  <body>
    
    <style>
        #wrapper {
            font-size: 1.5rem;
            text-align: center;
            box-sizing: border-box;
            color: #333;
        }
        #wrapper #dialog {
            /* border: solid 1px #ccc; */
            margin: 10px auto;
            padding: 20px 30px;
            display: inline-block;
            /* box-shadow: 0 0 4px #ccc; */
            /* background-color: #FAF8F8; */
            overflow: hidden;
            position: relative;
            max-width: 600px;
        }
        #wrapper #dialog h3 {
            margin: 0 0 10px;
            padding: 0;
            line-height: 1.25;
            font-size: 19px;
            line-height: 1.47059;
            font-weight: 400;
            letter-spacing: -.022em;
            font-family: SF Pro Text,SF Pro Icons,Helvetica Neue,Helvetica,Arial,sans-serif;
        }
        #wrapper #dialog span {
        font-size: 90%;
        }
        #wrapper #dialog #form {
        max-width: 300px;
        margin: 25px auto 0;
        }
        #wrapper #dialog #form input {
            margin: 0 5px;
            text-align: center;
            line-height: 80px;
            font-size: 50px;
            border: solid 1px #a7a7a7;
            box-shadow: 0 0 5px #d6d6d6 inset;
            outline: none;
            width: 20%;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            border-radius: 3px;
        }
        #wrapper #dialog #form input:focus {
            border-color: #d8d8d8;
            box-shadow: 0 0 5px #969696 inset;
        }
        #wrapper #dialog #form input::-moz-selection {
        background: transparent;
        }
        #wrapper #dialog #form input::selection {
        background: transparent;
        }
        #wrapper #dialog #form button {
        margin: 30px 0 50px;
        width: 100%;
        padding: 6px;
        background-color: #000;
        border: none;
        text-transform: uppercase;
        }
        #wrapper #dialog button.close {
        border: solid 2px;
        border-radius: 30px;
        line-height: 19px;
        font-size: 120%;
        width: 22px;
        position: absolute;
        right: 5px;
        top: 5px;
        }
        #wrapper #dialog div {
        position: relative;
        z-index: 1;
        }
        #wrapper #dialog img {
        position: absolute;
        bottom: -70px;
        right: -63px;
        }

    </style>
    
    <div id="wrapper">
        <div id="dialog">
            <!-- <button class="close">×</button> -->
            <h1>WAYAK</h1>
            <h3>Se ha enviado un mensaje con un código de verificación de 4 dígitos a tu cuenta. Introduce el código para continuar.</h3>
            <!-- <h3>Ingrese el código de verificación de 4 dígitos que recibio:</h3> -->
            <!-- <span>(queremos asegurarnos de que sea usted antes de contactar a nuestros transportistas)</span> -->

            <div id="form">
                <form method="post" action="{{ route('code.validate') }}">
                    <!-- CROSS Site Request Forgery Protection -->
                    @csrf    
                    <input name="templates" type="hidden" value="{{ $templates }}" />
                    <input name="digit1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" autofocus />
                    <input name="digit2" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                    <input name="digit3" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                    <input name="digit4" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                    
                    <button type="submit" class="btn btn-primary btn-embossed">VERIFICAR CODIGO</button>
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