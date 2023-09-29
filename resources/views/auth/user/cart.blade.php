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

        b,
        strong {
            font-weight: bolder;
        }

        img {
            border-style: none;
        }

        button,
        input,
        select {
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

        [tabindex="-1"]:focus:not(:focus-visible) {
            outline: 0 !important;
        }

        h1,
        h4,
        h5,
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

        h5 {
            font-size: 1.25rem;
        }

        h6 {
            font-size: 1rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        b,
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
        input,
        select {
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
            .col-lg-4 {
                flex: 0 0 auto;
                width: 33.3333333333%;
            }

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

            .col-lg-12 {
                flex: 0 0 auto;
                width: 100%;
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

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-body {
            color: #212529 !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        @media (min-width:768px) {
            .p-md-4 {
                padding: 1.5rem !important;
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

        .fi-rs-angle-small-down:before {
            content: "\f10f";
        }

        .fi-rs-angle-small-up:before {
            content: "\f112";
        }

        .fi-rs-arrow-left:before {
            content: "\f11a";
        }

        .fi-rs-home:before {
            content: "\f1a3";
        }

        .fi-rs-label:before {
            content: "\f1b4";
        }

        .fi-rs-refresh:before {
            content: "\f1fa";
        }

        .fi-rs-sign-out:before {
            content: "\f218";
        }

        .fi-rs-trash:before {
            content: "\f24a";
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
        h5,
        h6,
        p,
        a,
        img,
        strong,
        b,
        i,
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
        select:focus,
        button:focus,
        input[type=text]:focus {
            outline: none !important;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .border-radius-15 {
            border-radius: 15px;
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
        h5,
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

        h5 {
            font-size: 20px;
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

        strong {
            font-weight: 600;
        }

        .text-body {
            color: #7E7E7E !important;
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

        input.coupon {
            height: 47px;
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

        .detail-qty {
            max-width: 80px;
            padding: 9px 20px;
            position: relative;
            width: 100%;
            border-radius: 5px;
        }

        .detail-qty>a {
            font-size: 16px;
            position: absolute;
            right: 8px;
            color: #3BB77E;
        }

        .detail-qty>a:hover {
            color: #29A56C;
        }

        .detail-qty>a.qty-up {
            top: 0;
        }

        .detail-qty>a.qty-down {
            bottom: -4px;
        }

        .detail-extralink>div {
            display: inline-block;
            vertical-align: top;
        }

        .detail-extralink .detail-qty {
            margin: 0 6px 15px 0;
            background: #fff;
            border: 2px solid #3BB77E !important;
            font-size: 16px;
            font-weight: 700;
            color: #3BB77E;
            border-radius: 5px;
            padding: 11px 20px 11px 30px;
            max-width: 90px;
        }

        .shopping-summery table> :not(caption)>*>* {
            padding: 15px 0;
        }

        .shopping-summery table td,
        .shopping-summery table th,
        .shopping-summery table thead {
            border: 0;
        }

        .shopping-summery table thead th {
            background-color: #ececec;
            padding: 18px 0;
            font-family: "Quicksand", sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: #253D4E;
        }

        .shopping-summery table thead th.start {
            border-radius: 20px 0 0 20px;
        }

        .shopping-summery table thead th.end {
            border-radius: 0 20px 20px 0;
        }

        .shopping-summery table tbody tr img {
            max-width: 120px;
            border: 1px solid #ececec;
            border-radius: 15px;
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

        .cart-totals {
            border-radius: 15px;
            -webkit-box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.05);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px 40px;
        }

        .table-wishlist {
            border: 0;
        }

        @media print {
            .text-end {
                text-align: right !important;
            }
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

        .pt-30 {
            padding-top: 30px !important;
        }

        .pt-40 {
            padding-top: 40px !important;
        }

        .pl-30 {
            padding-left: 30px !important;
        }

        .mt-10 {
            margin-top: 10px !important;
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

        .mb-20 {
            margin-bottom: 20px !important;
        }

        .mb-30 {
            margin-bottom: 30px !important;
        }

        .mb-40 {
            margin-bottom: 40px !important;
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

        @media only screen and (max-width: 768px) {
            .detail-info {
                padding: 0 !important;
            }

            .detail-info .detail-extralink .detail-qty {
                padding: 11px 20px 11px 10px;
                max-width: 60px;
            }

            .shopping-summery table tbody tr img {
                max-width: 80px;
                margin-right: 15px;
            }

            .shopping-summery .form-check-label {
                display: none;
            }

            .shopping-summery h6 {
                font-size: 14px;
            }

            .shopping-summery td.pl-30 {
                padding-left: 0 !important;
            }
        }

        @media only screen and (min-width: 1200px) {
            .container {
                max-width: 1610px;
            }
        }

        @media only screen and (max-width: 480px) {
            .pt-40 {
                padding-top: 30px !important;
            }

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

            .mb-sm-15 {
                margin-bottom: 15px;
            }

            .shopping-summery table tbody tr img {
                max-width: 180px;
                margin-right: 0;
            }

            .cart-totals.ml-30 {
                margin-left: 0 !important;
                text-align: center;
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
                    <span></span> Cart
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">Your Cart</h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are <span class="text-brand">3</span> products in your cart</h6>
                        <h6 class="text-body"><a href="#" class="text-muted"><i class="fi-rs-trash mr-5"></i>Clear Cart</a></h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th class="custome-checkbox start pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="">
                                        <label class="form-check-label" for="exampleCheckbox11"></label>
                                    </th>
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col" class="end">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="pt-30">
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                        <label class="form-check-label" for="exampleCheckbox1"></label>
                                    </td>
                                    <td class="image product-thumbnail pt-40"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-1-1.jpg" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Field Roast Chao Cheese Creamy Original</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width:90%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-body">$2.51 </h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <div class="detail-qty border radius">
                                                <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">1</span>
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-brand">$2.51 </h4>
                                    </td>
                                    <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                        <label class="form-check-label" for="exampleCheckbox2"></label>
                                    </td>
                                    <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-2-1.jpg" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Blue Diamond Almonds Lightly Salted</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width:90%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-body">$3.2 </h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <div class="detail-qty border radius">
                                                <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">1</span>
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-brand">$3.2 </h4>
                                    </td>
                                    <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                        <label class="form-check-label" for="exampleCheckbox3"></label>
                                    </td>
                                    <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-3-1.jpg" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Fresh Organic Mustard Leaves Bell Pepper</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width:90%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-body">$2.43 </h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <div class="detail-qty border radius">
                                                <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">1</span>
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-brand">$2.43 </h4>
                                    </td>
                                    <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="divider-2 mb-30"></div>
                    <div class="cart-action d-flex justify-content-between">
                        <a class="btn "><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                        <a class="btn  mr-10 mb-sm-15"><i class="fi-rs-refresh mr-10"></i>Update Cart</a>
                    </div>
                    <div class="row mt-50">
                        <div class="col-lg-7">
                            <div class="calculate-shiping p-40 border-radius-15 border">
                                <h4 class="mb-10">Calculate Shipping</h4>
                                <p class="mb-30"><span class="font-lg text-muted">Flat rate:</span><strong class="text-brand">5%</strong></p>
                                <form class="field_form shipping_calculator">
                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <div class="custom_select">
                                                <select class="form-control select-active w-100 select2-hidden-accessible" data-select2-id="7" tabindex="-1" aria-hidden="true">
                                                    <option value="" data-select2-id="9">United Kingdom</option>
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
                                                </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="8" style="width: 520.094px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-nlnf-container"><span class="select2-selection__rendered" id="select2-nlnf-container" role="textbox" aria-readonly="true" title="United Kingdom">United Kingdom</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row row">
                                        <div class="form-group col-lg-6">
                                            <input required="required" placeholder="State / Country" name="name" type="text">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="required" placeholder="PostCode / ZIP" name="name" type="text">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="p-40">
                                <h4 class="mb-10">Apply Coupon</h4>
                                <p class="mb-30"><span class="font-lg text-muted">Using A Promo Code?</span></p>
                                <form action="#">
                                    <div class="d-flex justify-content-between">
                                        <input class="font-medium mr-15 coupon" name="Coupon" placeholder="Enter Your Coupon">
                                        <button class="btn"><i class="fi-rs-label mr-10"></i>Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="border p-md-4 cart-totals ml-30">
                        <div class="table-responsive">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">$12.31</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Shipping</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end">Free </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Estimate for</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end">United Kingdom </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Total</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">$12.31</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="#" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>