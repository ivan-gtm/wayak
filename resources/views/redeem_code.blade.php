@extends('layouts.frontend')

@section('title', 'Redeem Template Code | WAYAK')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
<style>
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
                        'country' => $country,
                        'ref' => request('ref')
                    ]) }}">
                <!-- CROSS Site Request Forgery Protection -->
                @csrf
                <input name="product_id" type="hidden" value="{{ $product_id }}" />
                <input class="digit" name="digit1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" autofocus />
                <input class="digit" name="digit2" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                <input class="digit" name="digit3" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                <input class="digit" name="digit4" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                @if (isset($error) && strlen($error) > 0 )
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary btn-embossed">{{ __('code.verify_btn') }}</button>
                <button id="resetButton" type="button" class="btn btn-primary btn-embossed" style="margin-top: 8px;background-color: #d2d2d2;color: black;">{{ __('code.reset_btn') }}</button>
                @if(request('ref') != '') 
                    <a class="btn btn-primary btn-embossed" style="margin-top: 8px;background-color: #d2d2d2;color: black;" href="{{ request('ref') }}">Go Back</a>
                @endif
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        'use strict';

        const digitInputs = document.querySelectorAll('input.digit');

        function resetForm() {
            digitInputs.forEach(input => input.value = "");
            document.querySelector('#form > form > input:nth-child(3)').focus();
        }

        const resetButton = document.querySelector('#resetButton');
        if (resetButton) {
            resetButton.addEventListener('click', resetForm);
        }


        function goToNextInput(e) {
            const key = e.which || e.keyCode;
            let target = e.target;
            let sib = target.nextElementSibling;

            // Handle backspace
            if (key === 8 && target.value === '') {
                let prevSib = target.previousElementSibling;
                if (prevSib) {
                    prevSib.value = '';
                    prevSib.focus();
                }
                return;
            }

            if (key != 9 && (key < 48 || key > 57)) {
                e.preventDefault();
                return;
            }

            if (!sib) {
                sib = document.querySelector('#form > form > button:nth-child(7)');
                sib.focus();
                sib.click();
            } else {
                sib.focus();
            }
        }

        function onKeyDown(e) {
            const key = e.which || e.keyCode;

            if (key === 9 || (key >= 48 && key <= 57) || key === 8) {
                return true;
            }

            e.preventDefault();
            return false;
        }

        function onFocus(e) {
            e.target.select();
        }

        function checkAndSubmit() {
            const allNumeric = Array.from(digitInputs).every(input => !isNaN(input.value) && input.value !== '');

            if (allNumeric) {
                document.querySelector('#form > form').submit();
            }
        }

        digitInputs.forEach(input => {
            input.addEventListener('keyup', goToNextInput);
            input.addEventListener('keyup', checkAndSubmit);
            input.addEventListener('keydown', onKeyDown);
            input.addEventListener('click', onFocus);
        });

    });

</script>
@endsection



</body>

</html>