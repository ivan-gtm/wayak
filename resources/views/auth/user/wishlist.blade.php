@extends('layouts.frontend')

@section('content')
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

        h1,
        h3,
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

        h3 {
            font-size: calc(1.3rem + .6vw);
        }

        @media (min-width:1200px) {
            h3 {
                font-size: 1.75rem;
            }
        }

        h6 {
            font-size: 1rem;
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
        input {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        button {
            text-transform: none;
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
            .col-lg-12 {
                flex: 0 0 auto;
                width: 100%;
            }
        }

        @media (min-width:1200px) {
            .col-xl-10 {
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

        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            color: #fff;
            background-color: #5c636a;
            border-color: #565e64;
        }

        .btn-secondary:focus {
            color: #fff;
            background-color: #5c636a;
            border-color: #565e64;
            box-shadow: 0 0 0 .25rem rgba(130, 138, 145, .5);
        }

        .btn-secondary:active {
            color: #fff;
            background-color: #565e64;
            border-color: #51585e;
        }

        .btn-secondary:active:focus {
            box-shadow: 0 0 0 .25rem rgba(130, 138, 145, .5);
        }

        .btn-secondary:disabled {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-sm {
            padding: .25rem .5rem;
            font-size: .875rem;
            border-radius: .2rem;
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

        .m-auto {
            margin: auto !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
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

        .fi-rs-trash:before {
            content: "\f24a";
        }

        /*! end @import */
        div,
        span,
        h1,
        h3,
        h6,
        a,
        img,
        i,
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
        button:focus {
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
        button:focus {
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

        a,
        button,
        img,
        input,
        span {
            -webkit-transition: all .3s ease 0s;
            transition: all .3s ease 0s;
        }

        h1,
        h3,
        h6 {
            font-family: "Quicksand", sans-serif;
            color: #253D4E;
            font-weight: 700;
            line-height: 1.2;
        }

        h1 {
            font-size: 48px;
        }

        h3 {
            font-size: 32px;
        }

        h6 {
            font-size: 16px;
        }

        a,
        button {
            text-decoration: none;
            cursor: pointer;
        }

        .text-body {
            color: #7E7E7E !important;
        }

        .btn-sm {
            padding: 8px 18px !important;
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

        .btn.btn-sm {
            padding: 8px 18px;
            font-size: 12px;
            text-transform: none;
            line-height: 1.8;
        }

        .btn.btn-secondary {
            background-color: #3e5379;
            border-color: #3e5379;
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

        .stock-status {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-family: "Quicksand", sans-serif;
            font-size: 14px;
            font-weight: 700;
            line-height: 1;
        }

        .stock-status.in-stock {
            background: #DEF9EC;
            color: #3BB77E;
        }

        .stock-status.out-stock {
            color: #f74b81;
            background: #fde0e9;
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

        .table-wishlist {
            border: 0;
        }

        .table tr {
            border: 1px solid #e9ecef;
        }

        .table> :not(caption)>*>* {
            background-color: var(--bs-table-bg);
            border-bottom-width: 0;
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

        .mt-50 {
            margin-top: 50px !important;
        }

        .mb-10 {
            margin-bottom: 10px !important;
        }

        .mb-30 {
            margin-bottom: 30px !important;
        }

        .mb-50 {
            margin-bottom: 50px !important;
        }

        .ml-5 {
            margin-left: 5px !important;
        }

        .mr-5 {
            margin-right: 5px !important;
        }

        @media only screen and (max-width: 768px) {
            .detail-info {
                padding: 0 !important;
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

            .shopping-summery button.btn {
                width: 120px;
                margin-left: 15px;
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

            .shopping-summery table tbody tr img {
                max-width: 180px;
                margin-right: 0;
            }
        }

        
    </style>

    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shop <span></span> Fillter
                </div>
            </div>
        </div>
        <div class="container mb-30 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="mb-50">
                        <h1 class="heading-2 mb-10">Your Wishlist</h1>
                        <h6 class="text-body">There are <span class="text-brand">5</span> products in this list</h6>
                    </div>
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th class="custome-checkbox start pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="">
                                        <label class="form-check-label" for="exampleCheckbox11"></label>
                                    </th>
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock Status</th>
                                    <th scope="col">Action</th>
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
                                        <h6><a class="product-name mb-10" href="shop-product-right.html">Field Roast Chao Cheese Creamy Original</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">$2.51</h3>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <span class="stock-status in-stock mb-0"> In Stock </span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        <button class="btn btn-sm">Add to cart</button>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <a href="#" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                        <label class="form-check-label" for="exampleCheckbox2"></label>
                                    </td>
                                    <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-2-1.jpg" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6><a class="product-name mb-10" href="shop-product-right.html">Blue Diamond Almonds Lightly Salted</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">$3.2</h3>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <span class="stock-status in-stock mb-0"> In Stock </span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        <button class="btn btn-sm">Add to cart</button>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <a href="#" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                        <label class="form-check-label" for="exampleCheckbox3"></label>
                                    </td>
                                    <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-3-1.jpg" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6><a class="product-name mb-10" href="shop-product-right.html">Fresh Organic Mustard Leaves Bell Pepper</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">$2.43</h3>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <span class="stock-status in-stock mb-0"> In Stock </span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        <button class="btn btn-sm">Add to cart</button>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <a href="#" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox4" value="">
                                        <label class="form-check-label" for="exampleCheckbox4"></label>
                                    </td>
                                    <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-4-1.jpg" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6><a class="product-name mb-10" href="shop-product-right.html">Angie’s Boomchickapop Sweet &amp; Salty </a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">$3.21</h3>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <span class="stock-status out-stock mb-0"> Out Stock </span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        <button class="btn btn-sm btn-secondary">Contact Us</button>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <a href="#" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox5" value="">
                                        <label class="form-check-label" for="exampleCheckbox5"></label>
                                    </td>
                                    <td class="image product-thumbnail"><img src="https://wp.alithemes.com/html/nest/demo/assets/imgs/shop/product-5-1.jpg" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6><a class="product-name mb-10" href="shop-product-right.html">Foster Farms Takeout Crispy Classic</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">$3.17</h3>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <span class="stock-status in-stock mb-0"> In Stock </span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        <button class="btn btn-sm">Add to cart</button>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <a href="#" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection