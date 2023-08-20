@extends('layouts.frontend')

@section('title', 'Redeem Template Code | WAYAK')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
<style>
    /* :root{--bs-blue:#0d6efd;--bs-indigo:#6610f2;--bs-purple:#6f42c1;--bs-pink:#d63384;--bs-red:#dc3545;--bs-orange:#fd7e14;--bs-yellow:#ffc107;--bs-green:#198754;--bs-teal:#20c997;--bs-cyan:#0dcaf0;--bs-white:#fff;--bs-gray:#6c757d;--bs-gray-dark:#343a40;--bs-primary:#0d6efd;--bs-secondary:#6c757d;--bs-success:#198754;--bs-info:#0dcaf0;--bs-warning:#ffc107;--bs-danger:#dc3545;--bs-light:#f8f9fa;--bs-dark:#343a40;--bs-font-sans-serif:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--bs-font-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--bs-gradient:linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));}
            *,::after,::before{box-sizing:border-box;} */
    body {
        margin: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;
    }

    h1,
    h3 {
        margin-top: 0;
        margin-bottom: .5rem;
        font-weight: 500;
        line-height: 1.2;
    }

    h1 {
        font-size: calc(1.375rem + 1.5vw);
    }

    @media (min-width:1200px) {
        h1 {
            font-size: 2.5rem;
        }
    }

    h3 {
        font-size: calc(1.3rem + .6vw);
    }

    @media (min-width:1200px) {
        h3 {
            font-size: 1.75rem;
        }
    }

    a {
        color: #0d6efd;
        text-decoration: underline;
    }

    a:hover {
        color: #024dbc;
    }

    button {
        border-radius: 0;
    }

    button:focus {
        outline: 1px dotted;
        outline: 5px auto -webkit-focus-ring-color;
    }

    button,
    input {
        margin: 0;
        font-size: inherit;
        line-height: inherit;
    }

    button,
    input {
        overflow: visible;
    }

    button {
        text-transform: none;
    }

    [type=submit],
    button {
        -webkit-appearance: button;
    }

    ::-moz-focus-inner {
        padding: 0;
        border-style: none;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        border-radius: .25rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    @media (prefers-reduced-motion:reduce) {
        .btn {
            transition: none;
        }
    }

    .btn:hover {
        color: #212529;
    }

    .btn:focus {
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
    }

    .btn:disabled {
        pointer-events: none;
        opacity: .65;
    }

    .btn-primary {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #025ce2;
        border-color: #0257d5;
    }

    .btn-primary:focus {
        color: #fff;
        background-color: #025ce2;
        border-color: #0257d5;
        box-shadow: 0 0 0 .25rem rgba(49, 132, 253, .5);
    }

    .btn-primary:active {
        color: #fff;
        background-color: #0257d5;
        border-color: #0252c9;
    }

    .btn-primary:active:focus {
        box-shadow: 0 0 0 .25rem rgba(49, 132, 253, .5);
    }

    .btn-primary:disabled {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    /*! CSS Used from: Embedded */
    #wrapper {
        font-size: 1.5rem;
        text-align: center;
        box-sizing: border-box;
        color: #333;
    }

    #wrapper #dialog {
        margin: 10px auto;
        padding: 20px 30px;
        display: inline-block;
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
        margin: 30px 0 3px;
        width: 100%;
        padding: 15px;
        background-color: #000;
        border: none;
        text-transform: uppercase;
    }

    #wrapper #dialog div {
        position: relative;
        z-index: 1;
    }
</style>
@endsection

@section('content')
<div id="wrapper">
    <div id="dialog">
        <h1>{{ __('code.redeem_template') }}</h1>
        <h3>{{ __('code.instructions') }}</h3>

        <div id="form">
            <form method="post" action="{{ route('code.validate', [
                        'country' => $country
                    ]) }}">
                <!-- CROSS Site Request Forgery Protection -->
                @csrf
                <input name="templates" type="hidden" value="{{ $templates }}" />
                <input name="template_key" type="hidden" value="{{ $template_key }}" />
                <input class="digit" name="digit1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" autofocus />
                <input class="digit" name="digit2" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                <input class="digit" name="digit3" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                <input class="digit" name="digit4" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />

                <button type="submit" class="btn btn-primary btn-embossed">{{ __('code.verify_btn') }}</button>
                <button type="button" class="btn btn-primary btn-embossed" onclick="resetForm()" style="margin-top: 8px;background-color: #d2d2d2;color: black;">{{ __('code.reset_btn') }}</button>
                <!-- <a href="#" style="color: #b1b1b1;text-decoration: none;font-size: 15px;">
                            Usar versión demo
                        </a> -->
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    'use strict';

    var body = document.body;

    function resetForm(){
        console.log("sdas");
        var digitInputs = document.querySelectorAll('input.digit');
        for (var i = 0; i < digitInputs.length; i++) {
            digitInputs[i].value = "";
        }
        document.querySelector('#form > form > input:nth-child(3)').focus();
    }

    function goToNextInput(e) {
        var key = e.which || e.keyCode,
            t = e.target,
            sib = t.nextElementSibling;

        if (key != 9 && (key < 48 || key > 57)) {
            e.preventDefault();
            return false;
        }

        if (key === 9) {
            return true;
        }

        if (!sib) {
            sib = document.querySelector('#form > form > button:nth-child(7)');
            console.log("hello");
            console.log(sib);
            sib.focus();
            sib.click();
        } else {
            sib.focus();
        }
    }

    function onKeyDown(e) {
        var key = e.which || e.keyCode;

        if (key === 9 || (key >= 48 && key <= 57)) {
            return true;
        }

        e.preventDefault();
        return false;
    }
    
    function onFocus(e) {
        e.target.select();
    }

    function checkAndSubmit() {
        var digitInputs = document.querySelectorAll('input.digit');
        var allNumeric = Array.from(digitInputs).every(function(input) {
            return !isNaN(input.value) && input.value !== '';
        });

        if (allNumeric) {
            document.querySelector('#form > form').submit();
        }
    }

    body.addEventListener('keyup', function(e) {
        if (e.target.tagName === 'INPUT') {
            goToNextInput(e);
            checkAndSubmit();
        }
    });
    
    body.addEventListener('keydown', function(e) {
        if (e.target.tagName === 'INPUT') {
            onKeyDown(e);
        }
    });
    
    body.addEventListener('click', function(e) {
        if (e.target.tagName === 'INPUT') {
            onFocus(e);
        }
    });
});

</script>
@endsection



</body>

</html>