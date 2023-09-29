@extends('layouts.frontend')

@section('content')
    <style>
        body {
            font-size: 100%;
        }
    </style>
    <style>
        /*! CSS Used from: https://wp.alithemes.com/html/nest/demo/assets/css/main.css?v=5.6 */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/vendors/normalize.css */
        main {
            display: block;
        }

        a {
            background-color: transparent;
        }

        b {
            font-weight: bolder;
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

        [type="checkbox"] {
            box-sizing: border-box;
            padding: 0;
        }

        /*! end @import */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/vendors/bootstrap.min.css */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        h2 {
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

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        b {
            font-weight: bolder;
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

        label {
            display: inline-block;
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
        }

        @media (min-width:1200px) {
            .col-xl-4 {
                flex: 0 0 auto;
                width: 33.3333333333%;
            }
        }

        .form-check-input {
            width: 1em;
            height: 1em;
            margin-top: .25em;
            vertical-align: top;
            background-color: #fff;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            border: 1px solid rgba(0, 0, 0, .25);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .form-check-input[type=checkbox] {
            border-radius: .25em;
        }

        .form-check-input:active {
            filter: brightness(90%);
        }

        .form-check-input:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .form-check-input:checked[type=checkbox] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
        }

        .form-check-input:disabled {
            pointer-events: none;
            filter: none;
            opacity: .5;
        }

        .form-check-input:disabled~.form-check-label {
            opacity: .5;
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

        .text-muted {
            color: #6c757d !important;
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
        p,
        a,
        img,
        b,
        i,
        form,
        label {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
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

        .text-muted {
            color: #B6B6B6 !important;
        }

        a,
        button,
        img,
        input,
        span {
            -webkit-transition: all .3s ease 0s;
            transition: all .3s ease 0s;
        }

        h2 {
            font-family: "Quicksand", sans-serif;
            color: #253D4E;
            font-weight: 700;
            line-height: 1.2;
        }

        h2 {
            font-size: 40px;
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

        b {
            font-weight: 500;
        }

        .text-hot {
            color: #f74b81;
        }

        .text-new {
            color: #55bb90;
        }

        .text-sale {
            color: #67bcee;
        }

        .text-best {
            color: #f59758;
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

        label {
            margin-bottom: 5px;
        }

        .security-code {
            display: inline-block;
            border-radius: 10px;
            height: 64px;
            line-height: 64px;
            padding: 0 40px;
            font-size: 24px;
            font-weight: bold;
            background: #BCE3C9;
        }

        .security-code b {
            font-size: 24px;
            font-weight: bold;
        }

        .custome-checkbox .form-check-label {
            position: relative;
            cursor: pointer;
        }

        .custome-checkbox .form-check-label {
            position: relative;
            cursor: pointer;
            color: #687188;
            padding: 0;
            vertical-align: middle;
        }

        .custome-checkbox .form-check-label::before {
            content: "";
            border: 2px solid #ced4da;
            height: 17px;
            width: 17px;
            margin: 0px 8px 0 0;
            display: inline-block;
            vertical-align: middle;
            border-radius: 2px;
        }

        .custome-checkbox .form-check-label span {
            vertical-align: middle;
        }

        .custome-checkbox input[type="checkbox"]:checked+.form-check-label::after {
            opacity: 1;
        }

        .custome-checkbox input[type="checkbox"]+.form-check-label::after {
            content: "";
            width: 11px;
            position: absolute;
            top: 50%;
            left: 3px;
            opacity: 0;
            height: 6px;
            border-left: 2px solid #fff;
            border-bottom: 2px solid #fff;
            -webkit-transform: translateY(-65%) rotate(-45deg);
            transform: translateY(-65%) rotate(-45deg);
        }

        .custome-checkbox .form-check-input {
            display: none;
        }

        .login_footer {
            margin-bottom: 20px;
            margin-top: 5px;
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -webkit-box-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            -webkit-box-pack: justify;
            justify-content: space-between;
            width: 100%;
        }

        .custome-checkbox input[type="checkbox"]:checked+.form-check-label::before {
            background-color: #3BB77E;
            border-color: #3BB77E;
        }

        .custome-checkbox input[type="checkbox"]:checked+.form-check-label::after {
            opacity: 1;
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

        .mt-15 {
            margin-top: 15px !important;
        }

        .mb-15 {
            margin-bottom: 15px !important;
        }

        .mb-30 {
            margin-bottom: 30px !important;
        }

        .mb-50 {
            margin-bottom: 50px !important;
        }

        .mr-5 {
            margin-right: 5px !important;
        }

        @media only screen and (min-width: 1200px) {
            .container {
                max-width: 1610px;
            }
        }

        @media only screen and (max-width: 480px) {
            .security-code {
                padding: 0 20px;
            }
        }

    </style>

    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-12 m-auto">
                        <div class="login_wrap widget-taber-content background-white">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <img class="border-radius-15" src="https://wp.alithemes.com/html/nest/demo/assets/imgs/page/forgot_password.svg" alt="">
                                    <h2 class="mb-15 mt-15">Forgot your password?</h2>
                                    <p class="mb-30">Not to worry, we got you! Let’s get you a new password. Please enter your email address or your Username.</p>
                                </div>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" required="" name="email" placeholder="Username or Email *">
                                    </div>
                                    <div class="login_footer form-group">
                                        <div class="chek-form">
                                            <input type="text" required="" placeholder="Security code *">
                                        </div>
                                        <span class="security-code">
                                            <b class="text-new">8</b>
                                            <b class="text-hot">6</b>
                                            <b class="text-sale">7</b>
                                            <b class="text-best">5</b>
                                        </span>
                                    </div>
                                    <div class="login_footer form-group mb-50">
                                        <div class="chek-form">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                                <label class="form-check-label" for="exampleCheckbox1"><span>I agree to terms &amp; Policy.</span></label>
                                            </div>
                                        </div>
                                        <a class="text-muted" href="#">Learn more</a>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-heading btn-block hover-up">Reset password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection