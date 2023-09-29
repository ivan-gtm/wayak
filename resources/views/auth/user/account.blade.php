<!-- https://wp.alithemes.com/html/nest/demo/page-account.html -->
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
        main {
            display: block;
        }

        a {
            background-color: transparent;
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

        h3,
        h5 {
            margin-top: 0;
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h3 {
            font-size: calc(1.3rem + .6vw);
        }

        @media (min-width:1200px) {
            h3 {
                font-size: 1.75rem;
            }
        }

        h5 {
            font-size: 1.25rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        address {
            margin-bottom: 1rem;
            font-style: normal;
            line-height: inherit;
        }

        ul {
            padding-left: 2rem;
        }

        ul {
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

        table {
            caption-side: bottom;
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
            text-align: -webkit-match-parent;
        }

        tbody,
        td,
        th,
        thead,
        tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
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
            .col-md-3 {
                flex: 0 0 auto;
                width: 25%;
            }

            .col-md-6 {
                flex: 0 0 auto;
                width: 50%;
            }

            .col-md-9 {
                flex: 0 0 auto;
                width: 75%;
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

            .col-lg-10 {
                flex: 0 0 auto;
                width: 83.3333333333%;
            }
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-striped-color: #212529;
            --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
            --bs-table-active-color: #212529;
            --bs-table-active-bg: rgba(0, 0, 0, 0.1);
            --bs-table-hover-color: #212529;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: top;
            border-color: #dee2e6;
        }

        .table>:not(caption)>*>* {
            padding: .5rem .5rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }

        .table>tbody {
            vertical-align: inherit;
        }

        .table>thead {
            vertical-align: bottom;
        }

        .table>:not(:last-child)>:last-child>* {
            border-bottom-color: currentColor;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        @media (prefers-reduced-motion:reduce) {
            .form-control {
                transition: none;
            }
        }

        .form-control:focus {
            color: #212529;
            background-color: #fff;
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .form-control::placeholder {
            color: #6c757d;
            opacity: 1;
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 1;
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

        .fade {
            transition: opacity .15s linear;
        }

        @media (prefers-reduced-motion:reduce) {
            .fade {
                transition: none;
            }
        }

        .fade:not(.show) {
            opacity: 0;
        }

        .nav {
            display: flex;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        .nav-link {
            display: block;
            padding: .5rem 1rem;
            text-decoration: none;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
        }

        @media (prefers-reduced-motion:reduce) {
            .nav-link {
                transition: none;
            }
        }

        .tab-content>.tab-pane {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }

        .card-header {
            padding: .5rem 1rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .card-header:first-child {
            border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
        }

        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            padding: 0 0;
            margin-bottom: 1rem;
            list-style: none;
        }

        .d-block {
            display: block !important;
        }

        .flex-column {
            flex-direction: column !important;
        }

        .m-auto {
            margin: auto !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        @media (min-width:992px) {
            .mb-lg-0 {
                margin-bottom: 0 !important;
            }
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

        .fi-rs-marker:before {
            content: "\f1c6";
        }

        .fi-rs-settings-sliders:before {
            content: "\f208";
        }

        .fi-rs-shopping-bag:before {
            content: "\f212";
        }

        .fi-rs-shopping-cart-check:before {
            content: "\f214";
        }

        .fi-rs-sign-out:before {
            content: "\f218";
        }

        .fi-rs-user:before {
            content: "\f257";
        }

        /*! end @import */
        div,
        span,
        h3,
        h5,
        p,
        a,
        address,
        i,
        ul,
        li,
        form,
        label,
        table,
        tbody,
        thead,
        tr,
        th,
        td {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        thead {
            font-weight: 600;
        }

        ul {
            list-style: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        *:focus,
        button:focus,
        input.form-control:focus,
        input[type=text]:focus,
        input[type=password]:focus,
        input[type=email]:focus,
        [type=text].form-control:focus,
        [type=password].form-control:focus,
        [type=email].form-control:focus {
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
        input.form-control:focus,
        input[type=text]:focus,
        input[type=password]:focus,
        input[type=email]:focus,
        [type=text].form-control:focus,
        [type=password].form-control:focus,
        [type=email].form-control:focus {
            outline: none !important;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        a,
        button,
        input,
        span {
            -webkit-transition: all .3s ease 0s;
            transition: all .3s ease 0s;
        }

        h3,
        h5 {
            font-family: "Quicksand", sans-serif;
            color: #253D4E;
            font-weight: 700;
            line-height: 1.2;
        }

        h3 {
            font-size: 32px;
        }

        h5 {
            font-size: 20px;
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

        .font-weight-bold {
            font-weight: 700;
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

        button.submit,
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

        button.submit:hover,
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

        .contact-from-area .contact-form-style button {
            font-size: 17px;
            font-weight: 500;
            padding: 20px 40px;
            color: #ffffff;
            border: none;
            background-color: #253D4E;
            border-radius: 10px;
            font-family: "Quicksand", sans-serif;
        }

        .contact-from-area .contact-form-style button:hover {
            background-color: #3BB77E !important;
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

        .form-control {
            border: 1px solid #f0e9ff;
            border-radius: 10px;
            height: 48px;
            padding-left: 18px;
            font-size: 16px;
            background: transparent;
        }

        .form-control:focus {
            outline: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .form-control::placeholder {
            font-weight: 300;
            color: #999999;
            color: #777777;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #ececec;
            border-radius: .25rem;
        }

        .card .card-header {
            padding: 1rem;
            margin-bottom: 0;
            background-color: #f7f8f9;
            border-bottom: 1px solid #ececec;
        }

        .account .card {
            border: 0;
        }

        .account .card .card-header {
            border: 0;
            background: none;
        }

        .account .card table td,
        .account .card table th {
            border: 0;
        }

        .account .card .table>thead {
            font-family: "Quicksand", sans-serif;
            font-size: 17px;
        }

        .dashboard-menu ul {
            padding: 0;
            margin: 0;
        }

        .dashboard-menu ul li {
            position: relative;
            border-radius: 10px;
            border: 1px solid #ececec;
            border-radius: 10px;
        }

        .dashboard-menu ul li a {
            font-size: 16px;
            color: #7E7E7E;
            padding: 15px 30px;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
        }

        .dashboard-menu ul li a i {
            color: #7E7E7E;
            font-size: 19px;
            opacity: 0.6;
        }

        .dashboard-menu ul li a.active {
            color: #fff;
            background-color: #3BB77E;
            border-radius: 10px;
        }

        .dashboard-menu ul li a.active i {
            color: #fff;
        }

        .dashboard-menu ul li:not(:last-child) {
            margin-bottom: 10px;
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

        table {
            width: 100%;
            margin-bottom: 1.5rem;
            border-collapse: collapse;
            vertical-align: middle;
        }

        table td,
        table th {
            padding: 10px 20px;
            border: 1px solid #ececec;
            vertical-align: middle;
        }

        table thead>tr>th {
            vertical-align: middle;
            border-bottom: 0;
        }

        .table tr {
            border: 1px solid #e9ecef;
        }

        .table> :not(caption)>*>* {
            background-color: var(--bs-table-bg);
            border-bottom-width: 0;
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

        .mt-30 {
            margin-top: 30px !important;
        }

        .mb-20 {
            margin-bottom: 20px !important;
        }

        .mb-50 {
            margin-bottom: 50px !important;
        }

        .mr-5 {
            margin-right: 5px !important;
        }

        .mr-10 {
            margin-right: 10px !important;
        }

        @media only screen and (min-width: 1200px) {
            .container {
                max-width: 1610px;
            }
        }

        @media only screen and (max-width: 480px) {
            .table td {
                display: block;
                width: 100%;
                text-align: center;
            }

            .table td::before {
                content: attr(data-title) " ";
                float: left;
                text-transform: capitalize;
                margin-right: 15px;
                font-weight: bold;
            }

            .table thead {
                display: none;
            }
        }

        /*! CSS Used fontfaces */
        @font-face {
            font-family: "uicons-regular-straight";
            src: url("https://wp.alithemes.com/html/nest/demo/assets/fonts/uicons/uicons-regular-straight.eot#iefix") format("embedded-opentype"), url("https://wp.alithemes.com/html/nest/demo/assets/fonts/uicons/uicons-regular-straight.woff2") format("woff2"), url("https://wp.alithemes.com/html/nest/demo/assets/fonts/uicons/uicons-regular-straight.woff") format("woff");
        }

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
            font-family: "uicons-regular-straight";
            src: url("https://wp.alithemes.com/html/nest/demo/assets/fonts/uicons/uicons-regular-straight.eot#iefix") format("embedded-opentype"), url("https://wp.alithemes.com/html/nest/demo/assets/fonts/uicons/uicons-regular-straight.woff2") format("woff2"), url("https://wp.alithemes.com/html/nest/demo/assets/fonts/uicons/uicons-regular-straight.woff") format("woff");
        }
    </style>
</head>

<body>
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
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="page-login.html"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Hello Rosie!</h3>
                                            </div>
                                            <div class="card-body">
                                                <p>
                                                    From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>,<br>
                                                    manage your <a href="#">shipping and billing addresses</a> and <a href="#">edit your password and account details.</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Your Orders</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>#1357</td>
                                                                <td>March 45, 2020</td>
                                                                <td>Processing</td>
                                                                <td>$125.00 for 2 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2468</td>
                                                                <td>June 29, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$364.00 for 5 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2366</td>
                                                                <td>August 02, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$280.00 for 3 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Orders tracking</h3>
                                            </div>
                                            <div class="card-body contact-from-area">
                                                <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form class="contact-form-style mt-30 mb-50" action="#" method="post">
                                                            <div class="input-style mb-20">
                                                                <label>Order ID</label>
                                                                <input name="order-id" placeholder="Found in your order confirmation email" type="text">
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>Billing email</label>
                                                                <input name="billing-email" placeholder="Email you used during checkout" type="email">
                                                            </div>
                                                            <button class="submit submit-auto-width" type="submit">Track</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card mb-3 mb-lg-0">
                                                    <div class="card-header">
                                                        <h3 class="mb-0">Billing Address</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>
                                                            3522 Interstate<br>
                                                            75 Business Spur,<br>
                                                            Sault Ste. <br>Marie, MI 49783
                                                        </address>
                                                        <p>New York</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Shipping Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>
                                                            4299 Express Lane<br>
                                                            Sarasota, <br>FL 34249 USA <br>Phone: 1.941.227.4444
                                                        </address>
                                                        <p>Sarasota</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <p>Already have an account? <a href="page-login.html">Log in instead!</a></p>
                                                <form method="post" name="enq">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>First Name <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="name" type="text">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Last Name <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="phone">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Display Name <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="dname" type="text">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Email Address <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="email" type="email">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Current Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="password" type="password">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>New Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="npassword" type="password">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Confirm Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="cpassword" type="password">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>