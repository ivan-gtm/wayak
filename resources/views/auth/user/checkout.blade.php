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

        h1 {
            font-size: 2em;
            margin: 0.67em 0;
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
        input,
        select,
        textarea {
            font-family: inherit;
            font-size: 100%;
            line-height: 1.15;
            margin: 0;
        }

        button,
        input {
            overflow: visible;
        }

        button,
        select {
            text-transform: none;
        }

        button {
            -webkit-appearance: button;
        }

        textarea {
            overflow: auto;
        }

        [type="checkbox"],
        [type="radio"] {
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

        [tabindex="-1"]:focus:not(:focus-visible) {
            outline: 0 !important;
        }

        h1,
        h4,
        h6 {
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

        table {
            caption-side: bottom;
            border-collapse: collapse;
        }

        tbody,
        td,
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
        input,
        select,
        textarea {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        button,
        select {
            text-transform: none;
        }

        select {
            word-wrap: normal;
        }

        button {
            -webkit-appearance: button;
        }

        button:not(:disabled) {
            cursor: pointer;
        }

        textarea {
            resize: vertical;
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

        @media (min-width:992px) {
            .col-lg-5 {
                flex: 0 0 auto;
                width: 41.6666666667%;
            }

            .col-lg-6 {
                flex: 0 0 auto;
                width: 50%;
            }

            .col-lg-7 {
                flex: 0 0 auto;
                width: 58.3333333333%;
            }

            .col-lg-8 {
                flex: 0 0 auto;
                width: 66.6666666667%;
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

        .form-check-input[type=radio] {
            border-radius: 50%;
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

        .form-check-input:checked[type=radio] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='2' fill='%23fff'/%3e%3c/svg%3e");
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

        .collapse:not(.show) {
            display: none;
        }

        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            padding: 0 0;
            margin-bottom: 1rem;
            list-style: none;
        }

        .d-inline-block {
            display: inline-block !important;
        }

        .d-flex {
            display: flex !important;
        }

        .border {
            border: 1px solid #dee2e6 !important;
        }

        .w-100 {
            width: 100% !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .align-items-end {
            align-items: flex-end !important;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .text-body {
            color: #212529 !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        @media (min-width:768px) {
            .mb-md-3 {
                margin-bottom: 1rem !important;
            }
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

        .fi-rs-sign-out:before {
            content: "\f218";
        }

        .fi-rs-user:before {
            content: "\f257";
        }

        /*! end @import */
        /*! @import https://wp.alithemes.com/html/nest/demo/assets/css/plugins/select2.min.css */
        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 28px;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            display: block;
            padding-left: 8px;
            padding-right: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .select2-hidden-accessible {
            border: 0 !important;
            clip: rect(0 0 0 0) !important;
            -webkit-clip-path: inset(50%) !important;
            clip-path: inset(50%) !important;
            height: 1px !important;
            overflow: hidden !important;
            padding: 0 !important;
            position: absolute !important;
            width: 1px !important;
            white-space: nowrap !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: $color-heading;
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #bbb transparent transparent transparent;
            border-style: solid;
            border-width: 6px 5px 0 5px;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: -2px;
            position: absolute;
            top: 50%;
            width: 0;
        }

        .select2-container {
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -ms-transition: none !important;
            -o-transition: none !important;
            transition: none !important;
        }

        /*! end @import */
        div,
        span,
        h1,
        h4,
        h6,
        p,
        a,
        img,
        b,
        i,
        form,
        label,
        table,
        tbody,
        tr,
        td {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        img {
            max-width: 100%;
        }

        *:focus,
        select:focus,
        button:focus,
        textarea:focus,
        input[type=text]:focus,
        input[type=password]:focus {
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
        select:focus,
        button:focus,
        textarea:focus,
        input[type=text]:focus,
        input[type=password]:focus {
            outline: none !important;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .text-brand {
            color: #3BB77E !important;
        }

        .text-muted {
            color: #B6B6B6 !important;
        }

        .border {
            border: 1px solid #ececec !important;
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

        h1,
        h4,
        h6 {
            font-family: "Quicksand", sans-serif;
            color: #253D4E;
            font-weight: 700;
            line-height: 1.2;
        }

        h1 {
            font-size: 48px;
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

        a,
        button {
            text-decoration: none;
            cursor: pointer;
        }

        b {
            font-weight: 500;
        }

        .text-body {
            color: #7E7E7E !important;
        }

        .font-sm {
            font-size: 14px;
        }

        .font-lg {
            font-size: 17px;
        }

        .btn-md {
            padding: 10px 24px !important;
            font-size: 12px;
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

        select {
            width: 100%;
            background: transparent;
            border: 0px solid #ececec;
            -webkit-box-shadow: none;
            box-shadow: none;
            font-size: 16px;
            color: #7E7E7E;
        }

        option {
            background: #fff;
            border: 0px solid #626262;
            padding-left: 10px;
            font-size: 16px;
        }

        textarea {
            border: 1px solid #ececec;
            border-radius: 10px;
            height: 50px;
            -webkit-box-shadow: none;
            box-shadow: none;
            padding: 10px 10px 10px 20px;
            font-size: 16px;
            width: 100%;
            min-height: 200px;
        }

        textarea:focus {
            background: transparent;
            border: 1px solid #BCE3C9;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border-bottom: 3px solid #414648;
            border-radius: 0;
            border-right: 0;
            height: 50px;
            padding-left: 0;
            border-top: 0;
            border-left: 0;
            font-weight: bold;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 50px;
            font-size: 14px;
            padding: 0;
            font-family: "Quicksand", sans-serif;
            color: #253D4E;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 12px;
            right: 15px;
            width: 20px;
        }

        .custom_select {
            position: relative;
            width: 100%;
        }

        .custom_select .select2-container {
            max-width: 155px;
        }

        .custom_select .select2-container--default .select2-selection--single {
            border: 1px solid #ececec;
            border-radius: 4px;
            height: 50px;
            line-height: 50px;
            padding-left: 20px;
            font-size: 14px;
        }

        .custom_select .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 50px;
            font-size: 14px;
            padding-left: 0;
        }

        .custom_select .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 9px;
            right: 14px;
        }

        .select2-container {
            max-width: 135px;
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

        .custome-radio .form-check-label,
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

        .custome-radio .form-check-input,
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

        table td {
            padding: 10px 20px;
            border: 1px solid #ececec;
            vertical-align: middle;
        }

        table .product-thumbnail img {
            max-width: 80px;
        }

        .divider-2 {
            width: 100%;
            height: 1px;
            background-color: #ececec;
        }

        .product-rate {
            background-image: url("https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/rating-stars.png");
            background-position: 0 -12px;
            background-repeat: repeat-x;
            height: 12px;
            width: 60px;
            transition: all 0.5s ease-out 0s;
            -webkit-transition: all 0.5s ease-out 0s;
        }

        .product-rating {
            height: 12px;
            background-repeat: repeat-x;
            background-image: url("https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/rating-stars.png");
            background-position: 0 0;
        }

        table.no-border td {
            border: 0;
        }

        .shipping_calculator .custom_select .select2-container {
            max-width: unset;
        }

        .shipping_calculator .custom_select .select2-container--default .select2-selection--single {
            border-radius: 10px;
            height: 64px;
            line-height: 64px;
        }

        .shipping_calculator .custom_select .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 64px;
        }

        .shipping_calculator .custom_select .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50%;
            right: 14px;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .shipping_calculator .w-100 .select2-container {
            max-width: unset;
            min-width: 445.5px;
        }

        .cart-totals {
            border-radius: 15px;
            -webkit-box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.05);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px 40px;
        }

        .toggle_info {
            padding: 12px 20px;
            background-color: #fff;
            border-radius: 10px;
            border: 1px solid #ececec;
            -webkit-box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.05);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.05);
        }

        .login_form .panel-body {
            border: 1px solid #ececec;
            padding: 30px;
            margin-top: 30px;
            border-radius: 10px;
        }

        .payment_option .custome-radio {
            margin-bottom: 10px;
        }

        .payment_option .custome-radio .form-check-label {
            color: #292b2c;
            font-weight: 600;
        }

        .custome-radio .form-check-label::before {
            content: "";
            border: 1px solid #908f8f;
            height: 16px;
            width: 16px;
            display: inline-block;
            border-radius: 100%;
            vertical-align: middle;
            margin-right: 8px;
        }

        .custome-radio input[type="radio"]+.form-check-label::after {
            content: "";
            height: 10px;
            width: 10px;
            border-radius: 100%;
            position: absolute;
            top: 9px;
            left: 3px;
            opacity: 0;
        }

        .custome-radio input[type="radio"]:checked+.form-check-label::after {
            opacity: 1;
            background-color: #3BB77E;
        }

        .apply-coupon {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .apply-coupon input {
            height: 51px;
            border-radius: 10px 0 0 10px;
            background-image: url("https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/coupon.png");
            background-position: 20px center;
            background-repeat: no-repeat;
            padding-left: 50px;
        }

        .apply-coupon button {
            min-width: 150px;
            height: 51px;
            border-radius: 0 10px 10px 0;
            background-color: #253D4E;
        }

        .apply-coupon button:hover {
            background-color: #3BB77E;
        }

        .order_table table .product-thumbnail img {
            max-width: 120px;
            border-radius: 15px;
            border: 1px solid #ececec;
            padding: 5px;
        }

        .order_table table .w-160 {
            max-width: 160px;
        }

        .table tr {
            border: 1px solid #e9ecef;
        }

        .table> :not(caption)>*>* {
            background-color: var(--bs-table-bg);
            border-bottom-width: 0;
        }

        .p-40 {
            padding: 40px !important;
        }

        .pl-20 {
            padding-left: 20px !important;
        }

        .pr-20 {
            padding-right: 20px !important;
        }

        .mt-30 {
            margin-top: 30px !important;
        }

        .mt-50 {
            margin-top: 50px !important;
        }

        .mb-5 {
            margin-bottom: 5px !important;
        }

        .mb-10 {
            margin-bottom: 10px !important;
        }

        .mb-30 {
            margin-bottom: 30px !important;
        }

        .mb-40 {
            margin-bottom: 40px !important;
        }

        .mb-50 {
            margin-bottom: 50px !important;
        }

        .mb-80 {
            margin-bottom: 80px !important;
        }

        .ml-5 {
            margin-left: 5px !important;
        }

        .ml-15 {
            margin-left: 15px !important;
        }

        .ml-30 {
            margin-left: 30px !important;
        }

        .mr-5 {
            margin-right: 5px !important;
        }

        .mr-10 {
            margin-right: 10px !important;
        }

        .mr-15 {
            margin-right: 15px !important;
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

            .mb-sm-15 {
                margin-bottom: 15px;
            }

            .toggle_info .font-lg,
            .apply-coupon input {
                font-size: 14px !important;
            }

            .cart-totals.ml-30 {
                margin-left: 0 !important;
                text-align: center;
            }

            .order_table table .w-160 {
                margin: 0 auto;
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
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shop
                    <span></span> Checkout
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">Checkout</h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are <span class="text-brand">3</span> products in your cart</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row mb-50">
                        <div class="col-lg-6 mb-sm-15 mb-lg-0 mb-md-3">
                            <div class="toggle_info">
                                <span><i class="fi-rs-user mr-10"></i><span class="text-muted font-lg">Already have an account?</span> <a href="#loginform" data-bs-toggle="collapse" class="collapsed font-lg" aria-expanded="false">Click here to login</a></span>
                            </div>
                            <div class="panel-collapse collapse login_form" id="loginform">
                                <div class="panel-body">
                                    <p class="mb-30 font-sm">If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" name="email" placeholder="Username Or Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="login_footer form-group">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="remember" value="">
                                                    <label class="form-check-label" for="remember"><span>Remember me</span></label>
                                                </div>
                                            </div>
                                            <a href="#">Forgot password?</a>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-md" name="login">Log in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form method="post" class="apply-coupon">
                                <input type="text" placeholder="Enter Coupon Code...">
                                <button class="btn  btn-md" name="login">Apply Coupon</button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="mb-30">Billing Details</h4>
                        <form method="post">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" required="" name="fname" placeholder="First name *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" required="" name="lname" placeholder="Last name *">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_address" required="" placeholder="Address *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_address2" required="" placeholder="Address line2">
                                </div>
                            </div>
                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select class="form-control select-active select2-hidden-accessible" data-select2-id="7" tabindex="-1" aria-hidden="true">
                                            <option value="" data-select2-id="9">Select an option...</option>
                                            <option value="AX">Aland Islands</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="PW">Belau</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia</option>
                                            <option value="BQ">Bonaire, Saint Eustatius and Saba</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BV">Bouvet Island</option>
                                            <option value="BR">Brazil</option>
                                            <option value="IO">British Indian Ocean Territory</option>
                                            <option value="VG">British Virgin Islands</option>
                                            <option value="BN">Brunei</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="CV">Cape Verde</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CX">Christmas Island</option>
                                            <option value="CC">Cocos (Keeling) Islands</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo (Brazzaville)</option>
                                            <option value="CD">Congo (Kinshasa)</option>
                                            <option value="CK">Cook Islands</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CW">CuraÇao</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FK">Falkland Islands</option>
                                            <option value="FO">Faroe Islands</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="GF">French Guiana</option>
                                            <option value="PF">French Polynesia</option>
                                            <option value="TF">French Southern Territories</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GI">Gibraltar</option>
                                            <option value="GR">Greece</option>
                                            <option value="GL">Greenland</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GP">Guadeloupe</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GG">Guernsey</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HM">Heard Island and McDonald Islands</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HK">Hong Kong</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IM">Isle of Man</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="CI">Ivory Coast</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JE">Jersey</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Laos</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MO">Macao S.A.R., China</option>
                                            <option value="MK">Macedonia</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MQ">Martinique</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="YT">Mayotte</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia</option>
                                            <option value="MD">Moldova</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MS">Montserrat</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="AN">Netherlands Antilles</option>
                                            <option value="NC">New Caledonia</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="KP">North Korea</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PS">Palestinian Territory</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PN">Pitcairn</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="QA">Qatar</option>
                                            <option value="IE">Republic of Ireland</option>
                                            <option value="RE">Reunion</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russia</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="ST">São Tomé and Príncipe</option>
                                            <option value="BL">Saint Barthélemy</option>
                                            <option value="SH">Saint Helena</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="SX">Saint Martin (Dutch part)</option>
                                            <option value="MF">Saint Martin (French part)</option>
                                            <option value="PM">Saint Pierre and Miquelon</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="SM">San Marino</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="GS">South Georgia/Sandwich Islands</option>
                                            <option value="KR">South Korea</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                            <option value="SZ">Swaziland</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syria</option>
                                            <option value="TW">Taiwan</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TL">Timor-Leste</option>
                                            <option value="TG">Togo</option>
                                            <option value="TK">Tokelau</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TC">Turks and Caicos Islands</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom (UK)</option>
                                            <option value="US">USA (US)</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VA">Vatican</option>
                                            <option value="VE">Venezuela</option>
                                            <option value="VN">Vietnam</option>
                                            <option value="WF">Wallis and Futuna</option>
                                            <option value="EH">Western Sahara</option>
                                            <option value="WS">Western Samoa</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="8" style="width: 445.578px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-6eap-container"><span class="select2-selection__rendered" id="select2-6eap-container" role="textbox" aria-readonly="true" title="Select an option...">Select an option...</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="city" placeholder="City / Town *">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="zipcode" placeholder="Postcode / ZIP *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="phone" placeholder="Phone *">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="cname" placeholder="Company Name">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="email" placeholder="Email address *">
                                </div>
                            </div>
                            <div class="form-group mb-30">
                                <textarea rows="5" placeholder="Additional information"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="createaccount">
                                        <label class="form-check-label label_info" data-bs-toggle="collapse" href="#collapsePassword" data-target="#collapsePassword" aria-controls="collapsePassword" for="createaccount"><span>Create an account?</span></label>
                                    </div>
                                </div>
                            </div>
                            <div id="collapsePassword" class="form-group create-account collapse in">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input required="" type="password" placeholder="Password" name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="ship_detail">
                                <div class="form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="differentaddress">
                                            <label class="form-check-label label_info" data-bs-toggle="collapse" data-target="#collapseAddress" href="#collapseAddress" aria-controls="collapseAddress" for="differentaddress"><span>Ship to a different address?</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseAddress" class="different_address collapse in">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input type="text" required="" name="fname" placeholder="First name *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" required="" name="lname" placeholder="Last name *">
                                        </div>
                                    </div>
                                    <div class="row shipping_calculator">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="cname" placeholder="Company Name">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <div class="custom_select w-100">
                                                <select class="form-control select-active select2-hidden-accessible" data-select2-id="10" tabindex="-1" aria-hidden="true">
                                                    <option value="" data-select2-id="12">Select an option...</option>
                                                    <option value="AX">Aland Islands</option>
                                                    <option value="AF">Afghanistan</option>
                                                    <option value="AL">Albania</option>
                                                    <option value="DZ">Algeria</option>
                                                    <option value="AD">Andorra</option>
                                                    <option value="AO">Angola</option>
                                                    <option value="AI">Anguilla</option>
                                                    <option value="AQ">Antarctica</option>
                                                    <option value="AG">Antigua and Barbuda</option>
                                                    <option value="AR">Argentina</option>
                                                    <option value="AM">Armenia</option>
                                                    <option value="AW">Aruba</option>
                                                    <option value="AU">Australia</option>
                                                    <option value="AT">Austria</option>
                                                    <option value="AZ">Azerbaijan</option>
                                                    <option value="BS">Bahamas</option>
                                                    <option value="BH">Bahrain</option>
                                                    <option value="BD">Bangladesh</option>
                                                    <option value="BB">Barbados</option>
                                                    <option value="BY">Belarus</option>
                                                    <option value="PW">Belau</option>
                                                    <option value="BE">Belgium</option>
                                                    <option value="BZ">Belize</option>
                                                    <option value="BJ">Benin</option>
                                                    <option value="BM">Bermuda</option>
                                                    <option value="BT">Bhutan</option>
                                                    <option value="BO">Bolivia</option>
                                                    <option value="BQ">Bonaire, Saint Eustatius and Saba</option>
                                                    <option value="BA">Bosnia and Herzegovina</option>
                                                    <option value="BW">Botswana</option>
                                                    <option value="BV">Bouvet Island</option>
                                                    <option value="BR">Brazil</option>
                                                    <option value="IO">British Indian Ocean Territory</option>
                                                    <option value="VG">British Virgin Islands</option>
                                                    <option value="BN">Brunei</option>
                                                    <option value="BG">Bulgaria</option>
                                                    <option value="BF">Burkina Faso</option>
                                                    <option value="BI">Burundi</option>
                                                    <option value="KH">Cambodia</option>
                                                    <option value="CM">Cameroon</option>
                                                    <option value="CA">Canada</option>
                                                    <option value="CV">Cape Verde</option>
                                                    <option value="KY">Cayman Islands</option>
                                                    <option value="CF">Central African Republic</option>
                                                    <option value="TD">Chad</option>
                                                    <option value="CL">Chile</option>
                                                    <option value="CN">China</option>
                                                    <option value="CX">Christmas Island</option>
                                                    <option value="CC">Cocos (Keeling) Islands</option>
                                                    <option value="CO">Colombia</option>
                                                    <option value="KM">Comoros</option>
                                                    <option value="CG">Congo (Brazzaville)</option>
                                                    <option value="CD">Congo (Kinshasa)</option>
                                                    <option value="CK">Cook Islands</option>
                                                    <option value="CR">Costa Rica</option>
                                                    <option value="HR">Croatia</option>
                                                    <option value="CU">Cuba</option>
                                                    <option value="CW">CuraÇao</option>
                                                    <option value="CY">Cyprus</option>
                                                    <option value="CZ">Czech Republic</option>
                                                    <option value="DK">Denmark</option>
                                                    <option value="DJ">Djibouti</option>
                                                    <option value="DM">Dominica</option>
                                                    <option value="DO">Dominican Republic</option>
                                                    <option value="EC">Ecuador</option>
                                                    <option value="EG">Egypt</option>
                                                    <option value="SV">El Salvador</option>
                                                    <option value="GQ">Equatorial Guinea</option>
                                                    <option value="ER">Eritrea</option>
                                                    <option value="EE">Estonia</option>
                                                    <option value="ET">Ethiopia</option>
                                                    <option value="FK">Falkland Islands</option>
                                                    <option value="FO">Faroe Islands</option>
                                                    <option value="FJ">Fiji</option>
                                                    <option value="FI">Finland</option>
                                                    <option value="FR">France</option>
                                                    <option value="GF">French Guiana</option>
                                                    <option value="PF">French Polynesia</option>
                                                    <option value="TF">French Southern Territories</option>
                                                    <option value="GA">Gabon</option>
                                                    <option value="GM">Gambia</option>
                                                    <option value="GE">Georgia</option>
                                                    <option value="DE">Germany</option>
                                                    <option value="GH">Ghana</option>
                                                    <option value="GI">Gibraltar</option>
                                                    <option value="GR">Greece</option>
                                                    <option value="GL">Greenland</option>
                                                    <option value="GD">Grenada</option>
                                                    <option value="GP">Guadeloupe</option>
                                                    <option value="GT">Guatemala</option>
                                                    <option value="GG">Guernsey</option>
                                                    <option value="GN">Guinea</option>
                                                    <option value="GW">Guinea-Bissau</option>
                                                    <option value="GY">Guyana</option>
                                                    <option value="HT">Haiti</option>
                                                    <option value="HM">Heard Island and McDonald Islands</option>
                                                    <option value="HN">Honduras</option>
                                                    <option value="HK">Hong Kong</option>
                                                    <option value="HU">Hungary</option>
                                                    <option value="IS">Iceland</option>
                                                    <option value="IN">India</option>
                                                    <option value="ID">Indonesia</option>
                                                    <option value="IR">Iran</option>
                                                    <option value="IQ">Iraq</option>
                                                    <option value="IM">Isle of Man</option>
                                                    <option value="IL">Israel</option>
                                                    <option value="IT">Italy</option>
                                                    <option value="CI">Ivory Coast</option>
                                                    <option value="JM">Jamaica</option>
                                                    <option value="JP">Japan</option>
                                                    <option value="JE">Jersey</option>
                                                    <option value="JO">Jordan</option>
                                                    <option value="KZ">Kazakhstan</option>
                                                    <option value="KE">Kenya</option>
                                                    <option value="KI">Kiribati</option>
                                                    <option value="KW">Kuwait</option>
                                                    <option value="KG">Kyrgyzstan</option>
                                                    <option value="LA">Laos</option>
                                                    <option value="LV">Latvia</option>
                                                    <option value="LB">Lebanon</option>
                                                    <option value="LS">Lesotho</option>
                                                    <option value="LR">Liberia</option>
                                                    <option value="LY">Libya</option>
                                                    <option value="LI">Liechtenstein</option>
                                                    <option value="LT">Lithuania</option>
                                                    <option value="LU">Luxembourg</option>
                                                    <option value="MO">Macao S.A.R., China</option>
                                                    <option value="MK">Macedonia</option>
                                                    <option value="MG">Madagascar</option>
                                                    <option value="MW">Malawi</option>
                                                    <option value="MY">Malaysia</option>
                                                    <option value="MV">Maldives</option>
                                                    <option value="ML">Mali</option>
                                                    <option value="MT">Malta</option>
                                                    <option value="MH">Marshall Islands</option>
                                                    <option value="MQ">Martinique</option>
                                                    <option value="MR">Mauritania</option>
                                                    <option value="MU">Mauritius</option>
                                                    <option value="YT">Mayotte</option>
                                                    <option value="MX">Mexico</option>
                                                    <option value="FM">Micronesia</option>
                                                    <option value="MD">Moldova</option>
                                                    <option value="MC">Monaco</option>
                                                    <option value="MN">Mongolia</option>
                                                    <option value="ME">Montenegro</option>
                                                    <option value="MS">Montserrat</option>
                                                    <option value="MA">Morocco</option>
                                                    <option value="MZ">Mozambique</option>
                                                    <option value="MM">Myanmar</option>
                                                    <option value="NA">Namibia</option>
                                                    <option value="NR">Nauru</option>
                                                    <option value="NP">Nepal</option>
                                                    <option value="NL">Netherlands</option>
                                                    <option value="AN">Netherlands Antilles</option>
                                                    <option value="NC">New Caledonia</option>
                                                    <option value="NZ">New Zealand</option>
                                                    <option value="NI">Nicaragua</option>
                                                    <option value="NE">Niger</option>
                                                    <option value="NG">Nigeria</option>
                                                    <option value="NU">Niue</option>
                                                    <option value="NF">Norfolk Island</option>
                                                    <option value="KP">North Korea</option>
                                                    <option value="NO">Norway</option>
                                                    <option value="OM">Oman</option>
                                                    <option value="PK">Pakistan</option>
                                                    <option value="PS">Palestinian Territory</option>
                                                    <option value="PA">Panama</option>
                                                    <option value="PG">Papua New Guinea</option>
                                                    <option value="PY">Paraguay</option>
                                                    <option value="PE">Peru</option>
                                                    <option value="PH">Philippines</option>
                                                    <option value="PN">Pitcairn</option>
                                                    <option value="PL">Poland</option>
                                                    <option value="PT">Portugal</option>
                                                    <option value="QA">Qatar</option>
                                                    <option value="IE">Republic of Ireland</option>
                                                    <option value="RE">Reunion</option>
                                                    <option value="RO">Romania</option>
                                                    <option value="RU">Russia</option>
                                                    <option value="RW">Rwanda</option>
                                                    <option value="ST">São Tomé and Príncipe</option>
                                                    <option value="BL">Saint Barthélemy</option>
                                                    <option value="SH">Saint Helena</option>
                                                    <option value="KN">Saint Kitts and Nevis</option>
                                                    <option value="LC">Saint Lucia</option>
                                                    <option value="SX">Saint Martin (Dutch part)</option>
                                                    <option value="MF">Saint Martin (French part)</option>
                                                    <option value="PM">Saint Pierre and Miquelon</option>
                                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                                    <option value="SM">San Marino</option>
                                                    <option value="SA">Saudi Arabia</option>
                                                    <option value="SN">Senegal</option>
                                                    <option value="RS">Serbia</option>
                                                    <option value="SC">Seychelles</option>
                                                    <option value="SL">Sierra Leone</option>
                                                    <option value="SG">Singapore</option>
                                                    <option value="SK">Slovakia</option>
                                                    <option value="SI">Slovenia</option>
                                                    <option value="SB">Solomon Islands</option>
                                                    <option value="SO">Somalia</option>
                                                    <option value="ZA">South Africa</option>
                                                    <option value="GS">South Georgia/Sandwich Islands</option>
                                                    <option value="KR">South Korea</option>
                                                    <option value="SS">South Sudan</option>
                                                    <option value="ES">Spain</option>
                                                    <option value="LK">Sri Lanka</option>
                                                    <option value="SD">Sudan</option>
                                                    <option value="SR">Suriname</option>
                                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                                    <option value="SZ">Swaziland</option>
                                                    <option value="SE">Sweden</option>
                                                    <option value="CH">Switzerland</option>
                                                    <option value="SY">Syria</option>
                                                    <option value="TW">Taiwan</option>
                                                    <option value="TJ">Tajikistan</option>
                                                    <option value="TZ">Tanzania</option>
                                                    <option value="TH">Thailand</option>
                                                    <option value="TL">Timor-Leste</option>
                                                    <option value="TG">Togo</option>
                                                    <option value="TK">Tokelau</option>
                                                    <option value="TO">Tonga</option>
                                                    <option value="TT">Trinidad and Tobago</option>
                                                    <option value="TN">Tunisia</option>
                                                    <option value="TR">Turkey</option>
                                                    <option value="TM">Turkmenistan</option>
                                                    <option value="TC">Turks and Caicos Islands</option>
                                                    <option value="TV">Tuvalu</option>
                                                    <option value="UG">Uganda</option>
                                                    <option value="UA">Ukraine</option>
                                                    <option value="AE">United Arab Emirates</option>
                                                    <option value="GB">United Kingdom (UK)</option>
                                                    <option value="US">USA (US)</option>
                                                    <option value="UY">Uruguay</option>
                                                    <option value="UZ">Uzbekistan</option>
                                                    <option value="VU">Vanuatu</option>
                                                    <option value="VA">Vatican</option>
                                                    <option value="VE">Venezuela</option>
                                                    <option value="VN">Vietnam</option>
                                                    <option value="WF">Wallis and Futuna</option>
                                                    <option value="EH">Western Sahara</option>
                                                    <option value="WS">Western Samoa</option>
                                                    <option value="YE">Yemen</option>
                                                    <option value="ZM">Zambia</option>
                                                    <option value="ZW">Zimbabwe</option>
                                                </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="11" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-r0lw-container"><span class="select2-selection__rendered" id="select2-r0lw-container" role="textbox" aria-readonly="true" title="Select an option...">Select an option...</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="billing_address" required="" placeholder="Address *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="billing_address2" required="" placeholder="Address line2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="state" placeholder="State / County *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="city" placeholder="City / Town *">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="zipcode" placeholder="Postcode / ZIP *">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Your Order</h4>
                            <h6 class="text-muted">Subtotal</h6>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-1-1.jpg" alt="#"></td>
                                        <td>
                                            <h6 class="w-160 mb-5"><a href="shop-product-full.html" class="text-heading">Yidarton Women Summer Blue</a></h6>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width:90%">
                                                    </div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="text-muted pl-20 pr-20">x 1</h6>
                                        </td>
                                        <td>
                                            <h4 class="text-brand">$13.3</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-2-1.jpg" alt="#"></td>
                                        <td>
                                            <h6 class="w-160 mb-5"><a href="shop-product-full.html" class="text-heading">Seeds of Change Organic Quinoa</a></h6>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width:90%">
                                                    </div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="text-muted pl-20 pr-20">x 1</h6>
                                        </td>
                                        <td>
                                            <h4 class="text-brand">$15.0</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-3-1.jpg" alt="#"></td>
                                        <td>
                                            <h6 class="w-160 mb-5"><a href="shop-product-full.html" class="text-heading">Angie’s Boomchickapop Sweet </a></h6>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width:90%">
                                                    </div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="text-muted pl-20 pr-20">x 1</h6>
                                        </td>
                                        <td>
                                            <h4 class="text-brand">$17.2</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="payment ml-30">
                        <h4 class="mb-30">Payment</h4>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option" id="exampleRadios3" checked="">
                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse" data-target="#bankTranfer" aria-controls="bankTranfer">Direct Bank Transfer</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option" id="exampleRadios4" checked="">
                                <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse" data-target="#checkPayment" aria-controls="checkPayment">Cash on delivery</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option" id="exampleRadios5" checked="">
                                <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse" data-target="#paypal" aria-controls="paypal">Online Getway</label>
                            </div>
                        </div>
                        <div class="payment-logo d-flex">
                            <img class="mr-15" src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/payment-paypal.svg" alt="">
                            <img class="mr-15" src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/payment-visa.svg" alt="">
                            <img class="mr-15" src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/payment-master.svg" alt="">
                            <img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/theme/icons/payment-zapper.svg" alt="">
                        </div>
                        <a href="#" class="btn btn-fill-out btn-block mt-30">Place an Order<i class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>