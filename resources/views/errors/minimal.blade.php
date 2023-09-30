<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    
    <style>
        /*! CSS Used from: https://wp.alithemes.com/html/nest/demo/assets/css/main.css?v=5.6 */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/vendors/normalize.css */
        main {
            display: block;
        }

        h1 {
            font-size: 2em;
            margin: 0.67em 0;
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

        h1 {
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

        p {
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

        .display-2 {
            font-size: calc(1.575rem + 3.9vw);
            font-weight: 300;
            line-height: 1.2;
        }

        @media (min-width:1200px) {
            .display-2 {
                font-size: 4.5rem;
            }
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
            .col-lg-10 {
                flex: 0 0 auto;
                width: 83.3333333333%;
            }
        }

        @media (min-width:1200px) {
            .col-xl-8 {
                flex: 0 0 auto;
                width: 66.6666666667%;
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

        .m-auto {
            margin: auto !important;
        }

        .text-center {
            text-align: center !important;
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

        .fi-rs-search:before {
            content: "\f207";
        }

        /*! end @import */
        div,
        span,
        h1,
        p,
        a,
        img,
        i,
        form {
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

        .font-xs {
            font-size: 13px;
        }

        a,
        button,
        img,
        input,
        span {
            -webkit-transition: all .3s ease 0s;
            transition: all .3s ease 0s;
        }

        h1,
        .display-2 {
            font-family: "Quicksand", sans-serif;
            color: #253D4E;
            font-weight: 700;
            line-height: 1.2;
        }

        h1 {
            font-size: 48px;
        }

        .display-2 {
            font-size: 72px;
            line-height: 1;
        }

        p {
            font-size: 1rem;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 5px;
            color: #7E7E7E;
        }

        a,
        button {
            text-decoration: none;
            cursor: pointer;
        }

        .font-xs {
            font-size: 13px;
        }

        .font-lg {
            font-size: 17px;
        }

        .btn-default {
            color: #fff;
            background-color: #3BB77E;
            border-radius: 50px;
            padding: 13px 28px;
            font-family: "Quicksand", sans-serif;
        }

        .btn-default i {
            font-weight: 400;
            font-size: 12px;
            margin-left: 10px;
            -webkit-transition-duration: 0.2s;
            transition-duration: 0.2s;
        }

        .btn-default:hover i {
            margin-left: 15px;
            -webkit-transition-duration: 0.2s;
            transition-duration: 0.2s;
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

        .search-form form {
            position: relative;
        }

        .search-form form input {
            -webkit-transition: all 0.25s cubic-bezier(0.645, 0.045, 0.355, 1);
            transition: all 0.25s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        .search-form form button {
            position: absolute;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            right: 0;
            border: none;
            font-size: 20px;
            height: 100%;
            padding: 0 24px;
            background-color: transparent;
            color: #242424;
        }

        .search-form form button:hover {
            color: #fff;
        }

        .page-404 {
            background-color: #fff;
        }

        .page-404 img {
            max-width: 300px;
        }

        .page-404 .search-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .pt-150 {
            padding-top: 150px !important;
        }

        .pb-150 {
            padding-bottom: 150px !important;
        }

        .mt-30 {
            margin-top: 30px !important;
        }

        .mb-20 {
            margin-bottom: 20px !important;
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

        @media only screen and (max-width: 1400px) {
            .display-2 {
                font-size: 64px;
            }
        }
    </style>
</head>

<body>
    <main class="main page-404">
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto text-center">
                        <h1 class="display-2 mb-30">@yield('code')</h1>
                        <p class="font-lg text-grey-700 mb-30">
                            @yield('message')
                        </p>
                        <div class="search-form">
                            <form action="#">
                                <input type="text" placeholder="Search…">
                                <button type="submit"><i class="fi-rs-search"></i></button>
                            </form>
                        </div>
                        <a class="btn btn-default submit-auto-width font-xs hover-up mt-30" href="index.html">
                            <i class="fi-rs-home mr-5"></i> Back To Home Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>