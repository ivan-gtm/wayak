@extends('layouts.frontend')

@section('content')
<html>

<head>
    <style>
        body {
            font-size: 100%;
        }
    
        /*! CSS Used from: https://wp.alithemes.com/html/nest/demo/assets/css/main.css?v=5.6 */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/vendors/normalize.css */
        main {
            display: block;
        }

        a {
            background-color: transparent;
        }

        img {
            border-style: none;
        }

        button,
        input {
            font-family: inherit;
            font-size: 100%;
            line-height: 1.15;
            margin: 0;
        }

        button,
        input {
            overflow: visible;
        }

        button {
            text-transform: none;
        }

        button,
        [type="submit"] {
            -webkit-appearance: button;
        }

        /*! end @import */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/vendors/bootstrap.min.css */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        h2,
        h6 {
            margin-top: 0;
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h2 {
            font-size: calc(1.325rem + .9vw);
        }

        @media (min-width:1200px) {
            h2 {
                font-size: 2rem;
            }
        }

        h6 {
            font-size: 1rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        ol {
            padding-left: 2rem;
        }

        ol {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        a {
            color: #0d6efd;
            text-decoration: underline;
        }

        a:hover {
            color: #0a58ca;
        }

        img {
            vertical-align: middle;
        }

        button {
            border-radius: 0;
        }

        button:focus:not(:focus-visible) {
            outline: 0;
        }

        button,
        input {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        button {
            text-transform: none;
        }

        [type=submit],
        button {
            -webkit-appearance: button;
        }

        [type=submit]:not(:disabled),
        button:not(:disabled) {
            cursor: pointer;
        }

        .container {
            width: 100%;
            padding-right: var(--bs-gutter-x, .75rem);
            padding-left: var(--bs-gutter-x, .75rem);
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width:576px) {
            .container {
                max-width: 540px;
            }
        }

        @media (min-width:768px) {
            .container {
                max-width: 720px;
            }
        }

        @media (min-width:992px) {
            .container {
                max-width: 960px;
            }
        }

        @media (min-width:1200px) {
            .container {
                max-width: 1140px;
            }
        }

        @media (min-width:1400px) {
            .container {
                max-width: 1320px;
            }
        }

        .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(var(--bs-gutter-y) * -1);
            margin-right: calc(var(--bs-gutter-x)/ -2);
            margin-left: calc(var(--bs-gutter-x)/ -2);
        }

        .row>* {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x)/ 2);
            padding-left: calc(var(--bs-gutter-x)/ 2);
            margin-top: var(--bs-gutter-y);
        }

        @media (min-width:768px) {
            .col-md-8 {
                flex: 0 0 auto;
                width: 66.6666666667%;
            }

            .col-md-12 {
                flex: 0 0 auto;
                width: 100%;
            }
        }

        @media (min-width:992px) {
            .col-lg-6 {
                flex: 0 0 auto;
                width: 50%;
            }

            .col-lg-8 {
                flex: 0 0 auto;
                width: 66.6666666667%;
            }
        }

        @media (min-width:1200px) {
            .col-xl-6 {
                flex: 0 0 auto;
                width: 50%;
            }
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

        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            padding: 0 0;
            margin-bottom: 1rem;
            list-style: none;
        }

        .m-auto {
            margin: auto !important;
        }

        .bg-white {
            background-color: #fff !important;
        }

        /*! end @import */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/vendors/uicons-regular-straight.css */
        i[class^="fi-rs-"] {
            line-height: 0 !important;
        }

        i[class^="fi-rs-"]:before {
            font-family: uicons-regular-straight !important;
            font-style: normal;
            font-weight: normal !important;
            font-variant: normal;
            text-transform: none;
            line-height: 1 !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .fi-rs-home:before {
            content: "\f1a3";
        }

        /*! end @import */
        div,
        span,
        h2,
        h6,
        p,
        a,
        img,
        i,
        ol,
        li,
        form {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        ol {
            list-style: none;
        }

        img {
            max-width: 100%;
        }

        *:focus,
        button:focus,
        input[type=text]:focus {
            outline: none !important;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        a {
            color: #3BB77E;
        }

        a:hover {
            color: #FDC040;
        }

        ::selection {
            background: #3BB77E;
            color: #fff;
        }

        ::placeholder {
            color: #838383;
        }

        *:focus,
        button:focus,
        input[type=text]:focus {
            outline: none !important;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .border-radius-15 {
            border-radius: 15px;
        }

        .hover-up {
            -webkit-transition: all 0.25s cubic-bezier(0.02, 0.01, 0.47, 1);
            transition: all 0.25s cubic-bezier(0.02, 0.01, 0.47, 1);
        }

        .hover-up:hover {
            -webkit-transform: translateY(-5px);
            transform: translateY(-5px);
            -webkit-transition: all 0.25s cubic-bezier(0.02, 0.01, 0.47, 1);
            transition: all 0.25s cubic-bezier(0.02, 0.01, 0.47, 1);
        }

        .list-insider li {
            list-style: inside;
        }

        a,
        button,
        img,
        input,
        span {
            -webkit-transition: all .3s ease 0s;
            transition: all .3s ease 0s;
        }

        h2,
        h6 {
            font-family: "Quicksand", sans-serif;
            color: #253D4E;
            font-weight: 700;
            line-height: 1.2;
        }

        h2 {
            font-size: 40px;
        }

        h6 {
            font-size: 16px;
        }

        p {
            font-size: 1rem;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 5px;
            color: #7E7E7E;
        }

        p:last-child {
            margin-bottom: 0;
        }

        a,
        button {
            text-decoration: none;
            cursor: pointer;
        }

        .btn:focus {
            outline: 0;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }

        .btn {
            font-family: "Quicksand", sans-serif;
        }

        .btn:hover {
            color: #fff;
        }

        .btn-heading,
        button.btn-heading[type="submit"] {
            background-color: #253D4E;
            border-color: #253D4E;
            font-weight: 700;
            border: 0;
        }

        button[type='submit'] {
            font-size: 16px;
            font-weight: 500;
            padding: 15px 40px;
            color: #ffffff;
            border: none;
            background-color: #3BB77E;
            border: 1px solid #29A56C;
            border-radius: 10px;
        }

        button[type='submit']:hover {
            background-color: #29A56C !important;
        }

        .btn {
            display: inline-block;
            border: 1px solid transparent;
            font-size: 14px;
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 4px;
            color: #fff;
            border: 1px solid transparent;
            background-color: #3BB77E;
            cursor: pointer;
            -webkit-transition: all 300ms linear 0s;
            transition: all 300ms linear 0s;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            background-color: #FDC040;
        }

        input {
            border: 1px solid #ececec;
            border-radius: 10px;
            height: 64px;
            -webkit-box-shadow: none;
            box-shadow: none;
            padding-left: 20px;
            font-size: 16px;
            width: 100%;
        }

        input:focus {
            background: transparent;
            border: 1px solid #BCE3C9;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group input {
            background: #fff;
            border: 1px solid #ececec;
            height: 64px;
            -webkit-box-shadow: none;
            box-shadow: none;
            padding-left: 20px;
            font-size: 16px;
            width: 100%;
        }

        .form-group input:focus {
            background: transparent;
            border-color: #BCE3C9;
        }

        .page-header.breadcrumb-wrap {
            padding: 20px;
            background-color: #fff;
            border-bottom: 1px solid #ececec;
            font-family: "Quicksand", sans-serif;
        }

        .breadcrumb {
            display: inline-block;
            padding: 0;
            text-transform: capitalize;
            color: #7E7E7E;
            font-size: 14px;
            font-weight: 600;
            background: none;
            margin: 0;
            border-radius: 0;
        }

        .breadcrumb span {
            position: relative;
            text-align: center;
            padding: 0 10px;
        }

        .breadcrumb span::before {
            content: "\f111";
            font-family: "uicons-regular-straight" !important;
            display: inline-block;
            font-size: 9px;
        }

        .pt-150 {
            padding-top: 150px !important;
        }

        .pb-150 {
            padding-bottom: 150px !important;
        }

        .pl-50 {
            padding-left: 50px !important;
        }

        .mt-15 {
            margin-top: 15px !important;
        }

        .mb-15 {
            margin-bottom: 15px !important;
        }

        .mb-30 {
            margin-bottom: 30px !important;
        }

        .mr-5 {
            margin-right: 5px !important;
        }

        @media only screen and (min-width: 1200px) {
            .container {
                max-width: 1610px;
            }
        }
    </style>
    <style>
        /* Base styles for the rules */
        .list-insider li {
            color: red;
            /* Set the default color to red for unsatisfied rules */
            transition: color 0.3s, transform 0.3s;
            /* Smooth transitions for color and icons */
            display: flex;
            align-items: center;
        }

        .list-insider li::before {
            content: '\274C';
            /* Cross mark */
            margin-right: 8px;
            display: inline-block;
            transition: transform 0.3s;
        }

        .list-insider li.valid {
            color: green;
            /* Satisfied rules turn green */
        }

        .list-insider li.valid::before {
            content: '\2713';
            /* Check mark */
        }
    </style>
</head>

<body>
    <main class="main pages">
        <!-- <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div> -->
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-8 col-md-12 m-auto">
                        <div class="row">
                            <div class="heading_s1">
                                <img class="border-radius-15" src="https://wp.alithemes.com/html/nest/demo/assets/imgs/page/reset_password.svg" alt="">
                                <h2 class="mb-15 mt-15">Set new password</h2>
                                <p class="mb-30">Please create a new password that you don’t use on any other site.</p>
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf

                                            <input type="hidden" name="reset_token" value="{{ $token }}">

                                            <div class="form-group">
                                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="password*" required>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Confirm you password *" required>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up">Reset password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pl-50">
                                <h6 class="mb-15">Password must:</h6>
                                <p>Be between 9 and 64 characters</p>
                                <p>Include at least two of the following:</p>
                                <ol class="list-insider">
                                    <li>An uppercase character</li>
                                    <li>A lowercase character</li>
                                    <li>A number</li>
                                    <li>A special character</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // document.addEventListener("DOMContentLoaded", function() {
        //     const passwordInput = document.getElementById('password');
        //     const rules = {
        //         length: document.querySelector('.list-insider li:nth-child(1)'),
        //         uppercase: document.querySelector('.list-insider li:nth-child(2)'),
        //         lowercase: document.querySelector('.list-insider li:nth-child(3)'),
        //         number: document.querySelector('.list-insider li:nth-child(4)'),
        //         specialChar: document.querySelector('.list-insider li:nth-child(5)')
        //     };

        //     passwordInput.addEventListener('keyup', function() {
        //         let password = passwordInput.value;

        //         // Check for length
        //         if (password.length >= 9 && password.length <= 64) {
        //             rules.length.classList.add('valid');
        //         } else {
        //             rules.length.classList.remove('valid');
        //         }

        //         // Check for uppercase
        //         if (/[A-Z]/.test(password)) {
        //             rules.uppercase.classList.add('valid');
        //         } else {
        //             rules.uppercase.classList.remove('valid');
        //         }

        //         // Check for lowercase
        //         if (/[a-z]/.test(password)) {
        //             rules.lowercase.classList.add('valid');
        //         } else {
        //             rules.lowercase.classList.remove('valid');
        //         }

        //         // Check for numbers
        //         if (/\d/.test(password)) {
        //             rules.number.classList.add('valid');
        //         } else {
        //             rules.number.classList.remove('valid');
        //         }

        //         // Check for special characters
        //         if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password)) {
        //             rules.specialChar.classList.add('valid');
        //         } else {
        //             rules.specialChar.classList.remove('valid');
        //         }
        //     });
        // });

        // document.querySelector('form').addEventListener('submit', function(event) {
        //     const allRules = document.querySelectorAll('.list-insider li');
        //     for (let rule of allRules) {
        //         if (!rule.classList.contains('valid')) {
        //             event.preventDefault();
        //             alert('Please ensure your password meets all the requirements.');
        //             return;
        //         }
        //     }
        // });
    </script>
</body>

</html>
@endsection