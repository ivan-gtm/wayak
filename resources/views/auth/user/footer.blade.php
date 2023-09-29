<!-- https://wp.alithemes.com/html/nest/demo/page-contact.html -->
<html>

<head>
    <style>
        body {
            font-size: 100%;
        }
    </style>
    <style>
        /*! CSS Used from: https://wp.alithemes.com/html/nest/demo/assets/css/main.css?v=5.6 */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/vendors/normalize.css */
        a {
            background-color: transparent;
        }

        strong {
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

        /*! end @import */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/vendors/bootstrap.min.css */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        h2,
        h3,
        h4,
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

        h3 {
            font-size: calc(1.3rem + .6vw);
        }

        @media (min-width:1200px) {
            h3 {
                font-size: 1.75rem;
            }
        }

        h4 {
            font-size: calc(1.275rem + .3vw);
        }

        @media (min-width:1200px) {
            h4 {
                font-size: 1.5rem;
            }
        }

        h6 {
            font-size: 1rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        ul {
            padding-left: 2rem;
        }

        ul {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
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

        .col {
            flex: 1 0 0%;
        }

        .col-12 {
            flex: 0 0 auto;
            width: 100%;
        }

        @media (min-width:576px) {
            .col-sm-6 {
                flex: 0 0 auto;
                width: 50%;
            }
        }

        @media (min-width:768px) {
            .col-md-4 {
                flex: 0 0 auto;
                width: 33.3333333333%;
            }

            .col-md-6 {
                flex: 0 0 auto;
                width: 50%;
            }
        }

        @media (min-width:992px) {
            .col-lg-6 {
                flex: 0 0 auto;
                width: 50%;
            }

            .col-lg-12 {
                flex: 0 0 auto;
                width: 100%;
            }
        }

        @media (min-width:1200px) {
            .col-xl-4 {
                flex: 0 0 auto;
                width: 33.3333333333%;
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

        .d-flex {
            display: flex !important;
        }

        .d-none {
            display: none !important;
        }

        .position-relative {
            position: relative !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        @media (min-width:576px) {
            .mb-sm-2 {
                margin-bottom: .5rem !important;
            }

            .mb-sm-5 {
                margin-bottom: 3rem !important;
            }
        }

        @media (min-width:768px) {
            .d-md-block {
                display: block !important;
            }

            .mb-md-0 {
                margin-bottom: 0 !important;
            }

            .mb-md-3 {
                margin-bottom: 1rem !important;
            }

            .mb-md-4 {
                margin-bottom: 1.5rem !important;
            }
        }

        @media (min-width:992px) {
            .d-lg-inline-flex {
                display: inline-flex !important;
            }

            .mb-lg-0 {
                margin-bottom: 0 !important;
            }

            .mb-lg-3 {
                margin-bottom: 1rem !important;
            }
        }

        @media (min-width:1200px) {
            .d-xl-block {
                display: block !important;
            }

            .d-xl-none {
                display: none !important;
            }

            .mb-xl-0 {
                margin-bottom: 0 !important;
            }
        }

        /*! end @import */
        div,
        span,
        h2,
        h3,
        h4,
        h6,
        p,
        a,
        img,
        strong,
        ul,
        li,
        form,
        footer,
        section {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        footer,
        section {
            display: block;
        }

        ul {
            list-style: none;
        }

        img {
            max-width: 100%;
        }

        *:focus,
        button:focus,
        input[type=email]:focus {
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

        .position-relative {
            position: relative;
        }

        *:focus,
        button:focus,
        input[type=email]:focus {
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

        .text-brand {
            color: #3BB77E !important;
        }

        a,
        button,
        img,
        input,
        span,
        h4 {
            -webkit-transition: all .3s ease 0s;
            transition: all .3s ease 0s;
        }

        h2,
        h3,
        h4,
        h6 {
            font-family: "Quicksand", sans-serif;
            color: #253D4E;
            font-weight: 700;
            line-height: 1.2;
        }

        h2 {
            font-size: 40px;
        }

        h3 {
            font-size: 32px;
        }

        h4 {
            font-size: 24px;
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

        .text-heading {
            color: #253D4E;
        }

        p:last-child {
            margin-bottom: 0;
        }

        a,
        button {
            text-decoration: none;
            cursor: pointer;
        }

        strong {
            font-weight: 600;
        }

        .font-sm {
            font-size: 14px;
        }

        .font-md {
            font-size: 16px;
        }

        .font-lg {
            font-size: 17px;
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

        .banner-left-icon {
            position: relative;
            background: #F4F6FA;
            padding: 20px;
            border-radius: 10px;
        }

        .banner-left-icon:hover .banner-icon {
            -webkit-transform: translateY(-5px);
            transform: translateY(-5px);
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
        }

        .banner-left-icon .banner-icon {
            max-width: 60px;
            margin-right: 20px;
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
        }

        .banner-left-icon .banner-text h3 {
            color: #242424;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .banner-left-icon .banner-text p {
            margin-bottom: 0;
            color: #adadad;
        }

        @media print {
            .col-sm-6 {
                width: 50%;
            }

            .text-end {
                text-align: right !important;
            }
        }

        .logo a {
            display: block;
        }

        .mobile-social-icon a {
            text-align: center;
            font-size: 14px;
            margin-right: 5px;
            -webkit-transition-duration: 0.5s;
            transition-duration: 0.5s;
            height: 30px;
            width: 30px;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            background: #3BB77E;
            border-radius: 30px;
            line-height: 1;
            -ms-flex-line-pack: center;
            align-content: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .mobile-social-icon a img {
            max-width: 16px;
        }

        .mobile-social-icon a img:hover {
            opacity: 0.8;
        }

        .mobile-social-icon a:hover {
            -webkit-transform: translateY(-2px);
            transform: translateY(-2px);
            -webkit-transition-duration: 0.5s;
            transition-duration: 0.5s;
            margin-top: -2px;
        }

        .mobile-social-icon a:last-child {
            margin-right: 0;
        }

        .hotline img {
            min-width: 35px;
            margin-right: 12px;
        }

        .hotline p {
            color: #3BB77E;
            font-size: 26px;
            font-weight: 700;
            font-family: "Quicksand", sans-serif;
            display: block;
            line-height: 1;
        }

        .hotline p span {
            font-weight: 500;
            font-size: 12px;
            font-family: "Lato", sans-serif;
            color: #7E7E7E;
            display: block;
            letter-spacing: 0.9px;
        }

        footer .mobile-social-icon {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-item-align: center;
            align-self: center;
        }

        footer .mobile-social-icon h6 {
            display: inline-block;
            margin-right: 15px;
        }

        footer .hotline {
            min-width: 200px;
        }

        footer .hotline img {
            min-width: 10px;
            margin-right: 12px;
            max-width: 30px;
            opacity: 0.5;
        }

        .newsletter {
            position: relative;
        }

        .newsletter .newsletter-inner {
            background: url(https://wp.alithemes.com/html/nest/demo/assets/imgs/banner/banner-10.png) no-repeat center;
            background-size: cover;
            padding: 84px 78px;
            clear: both;
            display: table;
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            min-height: 230px;
        }

        .newsletter .newsletter-inner img {
            position: absolute;
            right: 50px;
            bottom: 0;
            max-width: 40%;
        }

        .newsletter .newsletter-inner .newsletter-content p {
            font-size: 18px;
        }

        .newsletter .newsletter-inner .newsletter-content form {
            background-color: #fff;
            max-width: 450px;
            border-radius: 50px;
            position: relative;
            z-index: 4;
        }

        .newsletter .newsletter-inner .newsletter-content form input {
            border: 0;
            border-radius: 50px 0 0 50px;
            padding-left: 58px;
            background: url(https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-plane.png) no-repeat 25px center;
        }

        .newsletter .newsletter-inner .newsletter-content form button {
            border: 0;
            border-radius: 50px;
            font-weight: 700;
        }

        .widget-about {
            min-width: 300px;
            font-size: 15px;
        }

        .widget-install-app {
            min-width: 310px;
        }

        .contact-infor {
            font-size: 15px;
            color: #253D4E;
        }

        .contact-infor li:not(:last-child) {
            margin-bottom: 10px;
        }

        .contact-infor li img {
            margin-right: 8px;
            max-width: 16px;
        }

        .footer-link-widget:not(:last-child) {
            margin-right: 50px;
        }

        .footer-link-widget p {
            font-size: 15px;
            color: #253D4E;
        }

        .download-app {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin: 25px 0 33px;
        }

        .download-app a {
            display: block;
            margin-right: 12px;
        }

        .download-app a img {
            max-width: 128px;
        }

        .footer-list {
            list-style: outside none none;
            margin: 0;
            padding: 0;
            min-width: 170px;
        }

        .footer-list li {
            display: block;
            margin: 0 0 13px;
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
        }

        .footer-list li:last-child {
            margin: 0;
        }

        .footer-list li:hover {
            padding-left: 5px;
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
        }

        .footer-list li a {
            font-size: 15px;
            color: #253D4E;
            display: block;
        }

        .footer-list li a:hover {
            color: #3BB77E;
        }

        .footer-bottom {
            border-top: 1px solid #BCE3C9;
        }

        .footer-mid .widget-title {
            margin: 15px 0 20px 0;
        }

        .section-padding {
            padding: 25px 0;
        }

        .pt-15 {
            padding-top: 15px !important;
        }

        .pb-20 {
            padding-bottom: 20px !important;
        }

        .pb-30 {
            padding-bottom: 30px !important;
        }

        .mb-15 {
            margin-bottom: 15px !important;
        }

        .mb-20 {
            margin-bottom: 20px !important;
        }

        .mb-30 {
            margin-bottom: 30px !important;
        }

        .mb-45 {
            margin-bottom: 45px !important;
        }

        .mr-30 {
            margin-right: 30px !important;
        }

        @media only screen and (max-width: 768px) {
            .download-app {
                margin-bottom: 0 !important;
            }

            .footer-mid .logo img {
                max-width: 150px;
            }

            .footer-mid .widget-install-app,
            .footer-mid .widget-about {
                min-width: 205px;
            }

            .footer-mid .widget-about strong {
                display: none;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            .hotline p {
                font-size: 15px;
            }
        }

        @media only screen and (min-width: 1200px) {
            .container {
                max-width: 1610px;
            }

            .col-lg-1-5 {
                width: 20%;
            }
        }

        @media only screen and (max-width: 1024px) {
            .hotline {
                display: none !important;
            }
        }

        @media only screen and (max-width: 480px) {
            .banner-left-icon {
                margin-bottom: 15px;
            }

            .mb-sm-5 {
                margin-bottom: 2rem;
            }

            ul.footer-list {
                margin-bottom: 30px;
            }

            .newsletter form {
                margin: 15px 0;
            }

            footer .download-app a img {
                width: 150px;
            }

            .newsletter .newsletter-inner {
                padding: 20px;
            }

            .newsletter .newsletter-inner h2 {
                font-size: 22px;
            }

            .newsletter .newsletter-inner .newsletter-content p {
                font-size: 14px;
                margin-bottom: 25px !important;
            }

            .newsletter .newsletter-inner button[type="submit"] {
                padding: 12px 20px;
            }

            .footer-link-widget:not(:last-child) {
                margin-right: 0;
            }

            .widget-about {
                margin-bottom: 30px;
            }
        }

        /*! CSS Used fontfaces */
        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 400;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-latin-400-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-latin-400-normal.woff) format('woff');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 400;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-latin-ext-400-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-latin-ext-400-normal.woff) format('woff');
            unicode-range: U+0100-02AF, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 400;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-vietnamese-400-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-vietnamese-400-normal.woff) format('woff');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 500;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-latin-500-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-latin-500-normal.woff) format('woff');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 500;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-latin-ext-500-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-latin-ext-500-normal.woff) format('woff');
            unicode-range: U+0100-02AF, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 500;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-vietnamese-500-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-vietnamese-500-normal.woff) format('woff');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 600;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-latin-600-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-latin-600-normal.woff) format('woff');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 600;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-latin-ext-600-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-latin-ext-600-normal.woff) format('woff');
            unicode-range: U+0100-02AF, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 600;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-vietnamese-600-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-vietnamese-600-normal.woff) format('woff');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 700;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-latin-700-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-latin-700-normal.woff) format('woff');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 700;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-latin-ext-700-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-latin-ext-700-normal.woff) format('woff');
            unicode-range: U+0100-02AF, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Quicksand';
            font-style: normal;
            font-weight: 700;
            font-stretch: 100%;
            src: url(https://fonts.bunny.net/quicksand/files/quicksand-vietnamese-700-normal.woff2) format('woff2'), url(https://fonts.bunny.net/quicksand/files/quicksand-vietnamese-700-normal.woff) format('woff');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.bunny.net/lato/files/lato-latin-400-normal.woff2) format('woff2'), url(https://fonts.bunny.net/lato/files/lato-latin-400-normal.woff) format('woff');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.bunny.net/lato/files/lato-latin-ext-400-normal.woff2) format('woff2'), url(https://fonts.bunny.net/lato/files/lato-latin-ext-400-normal.woff) format('woff');
            unicode-range: U+0100-02AF, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            src: url(https://fonts.bunny.net/lato/files/lato-latin-700-normal.woff2) format('woff2'), url(https://fonts.bunny.net/lato/files/lato-latin-700-normal.woff) format('woff');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            src: url(https://fonts.bunny.net/lato/files/lato-latin-ext-700-normal.woff2) format('woff2'), url(https://fonts.bunny.net/lato/files/lato-latin-ext-700-normal.woff) format('woff');
            unicode-range: U+0100-02AF, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 900;
            src: url(https://fonts.bunny.net/lato/files/lato-latin-900-normal.woff2) format('woff2'), url(https://fonts.bunny.net/lato/files/lato-latin-900-normal.woff) format('woff');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 900;
            src: url(https://fonts.bunny.net/lato/files/lato-latin-ext-900-normal.woff2) format('woff2'), url(https://fonts.bunny.net/lato/files/lato-latin-ext-900-normal.woff) format('woff');
            unicode-range: U+0100-02AF, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
    </style>
</head>

<body>
    <footer class="main">
        <section class="newsletter mb-15">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="position-relative newsletter-inner">
                            <div class="newsletter-content">
                                <h2 class="mb-20">
                                    Stay home &amp; get your daily <br>
                                    needs from our shop
                                </h2>
                                <p class="mb-45">Start You'r Daily Shopping with <span class="text-brand">Nest Mart</span></p>
                                <form class="form-subcriber d-flex">
                                    <input type="email" placeholder="Your emaill address">
                                    <button class="btn" type="submit">Subscribe</button>
                                </form>
                            </div>
                            <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/banner/banner-13.png" alt="newsletter">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="featured section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-md-4 mb-xl-0">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated animated" style="visibility: visible;">
                            <div class="banner-icon">
                                <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-1.svg" alt="">
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Best prices &amp; offers</h3>
                                <p>Orders $50 or more</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated animated" style="visibility: visible;">
                            <div class="banner-icon">
                                <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-2.svg" alt="">
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Free delivery</h3>
                                <p>24/7 amazing services</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated animated" style="visibility: visible;">
                            <div class="banner-icon">
                                <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-3.svg" alt="">
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Great daily deal</h3>
                                <p>When you sign up</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated animated" style="visibility: visible;">
                            <div class="banner-icon">
                                <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-4.svg" alt="">
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Wide assortment</h3>
                                <p>Mega Discounts</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated animated" style="visibility: visible;">
                            <div class="banner-icon">
                                <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-5.svg" alt="">
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Easy returns</h3>
                                <p>Within 30 days</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-xl-none">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated" style="visibility: hidden; animation-name: none;">
                            <div class="banner-icon">
                                <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-6.svg" alt="">
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Safe delivery</h3>
                                <p>Within 30 days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding footer-mid">
            <div class="container pt-15 pb-20">
                <div class="row">
                    <div class="col">
                        <div class="widget-about font-md mb-md-3 mb-lg-3 mb-xl-0">
                            <div class="logo mb-30">
                                <a href="index.html" class="mb-15"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/logo.svg" alt="logo"></a>
                                <p class="font-lg text-heading">Awesome grocery store website template</p>
                            </div>
                            <ul class="contact-infor">
                                <li><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-location.svg" alt=""><strong>Address: </strong> <span>5171 W Campbell Ave undefined Kent, Utah 53127 United States</span></li>
                                <li><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-contact.svg" alt=""><strong>Call Us:</strong><span>(+91) - 540-025-124553</span></li>
                                <li><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-email-2.svg" alt=""><strong>Email:</strong><span>sale@Nest.com</span></li>
                                <li><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-clock.svg" alt=""><strong>Hours:</strong><span>10:00 - 18:00, Mon - Sat</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Company</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Delivery Information</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Support Center</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Account</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">Sign In</a></li>
                            <li><a href="#">View Cart</a></li>
                            <li><a href="#">My Wishlist</a></li>
                            <li><a href="#">Track My Order</a></li>
                            <li><a href="#">Help Ticket</a></li>
                            <li><a href="#">Shipping Details</a></li>
                            <li><a href="#">Compare products</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Corporate</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">Become a Vendor</a></li>
                            <li><a href="#">Affiliate Program</a></li>
                            <li><a href="#">Farm Business</a></li>
                            <li><a href="#">Farm Careers</a></li>
                            <li><a href="#">Our Suppliers</a></li>
                            <li><a href="#">Accessibility</a></li>
                            <li><a href="#">Promotions</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Popular</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">Milk &amp; Flavoured Milk</a></li>
                            <li><a href="#">Butter and Margarine</a></li>
                            <li><a href="#">Eggs Substitutes</a></li>
                            <li><a href="#">Marmalades</a></li>
                            <li><a href="#">Sour Cream and Dips</a></li>
                            <li><a href="#">Tea &amp; Kombucha</a></li>
                            <li><a href="#">Cheese</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget widget-install-app col">
                        <h4 class="widget-title">Install App</h4>
                        <p class="wow fadeIn animated animated" style="visibility: visible;">From App Store or Google Play</p>
                        <div class="download-app">
                            <a href="#" class="hover-up mb-sm-2 mb-lg-0"><img class="active" src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/app-store.jpg" alt=""></a>
                            <a href="#" class="hover-up mb-sm-2"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/google-play.jpg" alt=""></a>
                        </div>
                        <p class="mb-20">Secured Payment Gateways</p>
                        <img class="wow fadeIn animated animated" src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/payment-method.png" alt="" style="visibility: visible;">
                    </div>
                </div>
            </div>
        </section>
        <div class="container pb-30">
            <div class="row align-items-center">
                <div class="col-12 mb-30">
                    <div class="footer-bottom"></div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <p class="font-sm mb-0">© 2022, <strong class="text-brand">Nest</strong> - HTML Ecommerce Template <br>All rights reserved</p>
                </div>
                <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                    <div class="hotline d-lg-inline-flex mr-30">
                        <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/phone-call.svg" alt="hotline">
                        <p>1900 - 6666<span>Working 8:00 - 22:00</span></p>
                    </div>
                    <div class="hotline d-lg-inline-flex">
                        <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/phone-call.svg" alt="hotline">
                        <p>1900 - 8888<span>24/7 Support Center</span></p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 text-end d-none d-md-block">
                    <div class="mobile-social-icon">
                        <h6>Follow Us</h6>
                        <a href="#"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-facebook-white.svg" alt=""></a>
                        <a href="#"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-twitter-white.svg" alt=""></a>
                        <a href="#"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-instagram-white.svg" alt=""></a>
                        <a href="#"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-pinterest-white.svg" alt=""></a>
                        <a href="#"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/icon-youtube-white.svg" alt=""></a>
                    </div>
                    <p class="font-sm">Up to 15% discount on your first subscribe</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>