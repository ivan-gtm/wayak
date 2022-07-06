<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="light" data-layout-width="fluid" data-layout-position="fixed" data-layout-style="default">

<head>

    <meta charset="utf-8">
    <title>Recuperar Contraseña | IPDP CDMX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin &amp; Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->


    

    <style>
        body {
            font-size: 16px;
        }
    
        /*! CSS Used from: https://themesbrand.com/velzon/html/default/assets/css/bootstrap.min.css */
        
        :root {
            --vz-blue: #3577f1;
            --vz-indigo: #405189;
            --vz-purple: #6559cc;
            --vz-pink: #f672a7;
            --vz-red: #f06548;
            --vz-orange: #f1963b;
            --vz-yellow: #f7b84b;
            --vz-green: #0ab39c;
            --vz-teal: #02a8b5;
            --vz-cyan: #299cdb;
            --vz-white: #fff;
            --vz-gray: #878a99;
            --vz-gray-dark: #343a40;
            --vz-gray-100: #f3f6f9;
            --vz-gray-200: #eff2f7;
            --vz-gray-300: #e9ebec;
            --vz-gray-400: #ced4da;
            --vz-gray-500: #adb5bd;
            --vz-gray-600: #878a99;
            --vz-gray-700: #495057;
            --vz-gray-800: #343a40;
            --vz-gray-900: #212529;
            --vz-primary: #405189;
            --vz-secondary: #3577f1;
            --vz-success: #0ab39c;
            --vz-info: #299cdb;
            --vz-warning: #f7b84b;
            --vz-danger: #f06548;
            --vz-light: #f3f6f9;
            --vz-dark: #212529;
            --vz-primary-rgb: 64, 81, 137;
            --vz-secondary-rgb: 53, 119, 241;
            --vz-success-rgb: 10, 179, 156;
            --vz-info-rgb: 41, 156, 219;
            --vz-warning-rgb: 247, 184, 75;
            --vz-danger-rgb: 240, 101, 72;
            --vz-light-rgb: 243, 246, 249;
            --vz-dark-rgb: 33, 37, 41;
            --vz-white-rgb: 255, 255, 255;
            --vz-black-rgb: 0, 0, 0;
            --vz-body-color-rgb: 33, 37, 41;
            --vz-body-bg-rgb: 243, 243, 249;
            --vz-font-sans-serif: "Poppins", sans-serif;
            --vz-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            --vz-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            --vz-body-font-family: var(--vz-font-sans-serif);
            --vz-body-font-size: 0.8125rem;
            --vz-body-font-weight: 400;
            --vz-body-line-height: 1.5;
            --vz-body-color: #212529;
            --vz-body-bg: #f3f3f9;
        }
        
        *,
        ::after,
        ::before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        
        @media (prefers-reduced-motion:no-preference) {
            :root {
                scroll-behavior: smooth;
            }
        }
        
        body {
            margin: 0;
            font-family: var(--vz-body-font-family);
            font-size: var(--vz-body-font-size);
            font-weight: var(--vz-body-font-weight);
            line-height: var(--vz-body-line-height);
            color: var(--vz-body-color);
            text-align: var(--vz-body-text-align);
            background-color: var(--vz-body-bg);
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: transparent;
        }
        
        h5 {
            margin-top: 0;
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
        }
        
        h5 {
            font-size: 1.015625rem;
        }
        
        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        
        a {
            color: var(--vz-link-color);
            text-decoration: underline;
        }
        
        a:hover {
            color: var(--vz-link-hover-color);
        }
        
        img,
        svg {
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
        
        ::-moz-focus-inner {
            padding: 0;
            border-style: none;
        }
        
        .container {
            width: 100%;
            padding-right: var(--vz-gutter-x, .75rem);
            padding-left: var(--vz-gutter-x, .75rem);
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
            --vz-gutter-x: 1.5rem;
            --vz-gutter-y: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--vz-gutter-y));
            margin-right: calc(-.5 * var(--vz-gutter-x));
            margin-left: calc(-.5 * var(--vz-gutter-x));
        }
        
        .row>* {
            -ms-flex-negative: 0;
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--vz-gutter-x) * .5);
            padding-left: calc(var(--vz-gutter-x) * .5);
            margin-top: var(--vz-gutter-y);
        }
        
        @media (min-width:768px) {
            .col-md-8 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: 66.66666667%;
            }
        }
        
        @media (min-width:992px) {
            .col-lg-6 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: 50%;
            }
            .col-lg-12 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: 100%;
            }
        }
        
        @media (min-width:1200px) {
            .col-xl-5 {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: 41.66666667%;
            }
        }
        
        .form-label {
            margin-bottom: .5rem;
        }
        
        .form-control {
            display: block;
            width: 100%;
            padding: .5rem .9rem;
            font-size: .8125rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--vz-body-color);
            background-color: var(--vz-input-bg);
            background-clip: padding-box;
            border: 1px solid var(--vz-input-border);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: .25rem;
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }
        
        @media (prefers-reduced-motion:reduce) {
            .form-control {
                -webkit-transition: none;
                transition: none;
            }
        }
        
        .form-control:focus {
            color: var(--vz-body-color);
            background-color: var(--vz-input-bg);
            border-color: var(--vz-input-focus-border);
            outline: 0;
            -webkit-box-shadow: 0 0 0 0 rgba(64, 81, 137, .25);
            box-shadow: 0 0 0 0 rgba(64, 81, 137, .25);
        }
        
        .form-control::-webkit-input-placeholder {
            color: #878a99;
            opacity: 1;
        }
        
        .form-control::-moz-placeholder {
            color: #878a99;
            opacity: 1;
        }
        
        .form-control:-ms-input-placeholder {
            color: #878a99;
            opacity: 1;
        }
        
        .form-control::-ms-input-placeholder {
            color: #878a99;
            opacity: 1;
        }
        
        .form-control::placeholder {
            color: #878a99;
            opacity: 1;
        }
        
        .form-control:disabled {
            background-color: var(--vz-input-disabled-bg);
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
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: .5rem .9rem;
            font-size: .8125rem;
            border-radius: .25rem;
            -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }
        
        @media (prefers-reduced-motion:reduce) {
            .btn {
                -webkit-transition: none;
                transition: none;
            }
        }
        
        .btn:hover {
            color: #212529;
        }
        
        .btn:focus {
            outline: 0;
            -webkit-box-shadow: 0 0 0 0 rgba(64, 81, 137, .25);
            box-shadow: 0 0 0 0 rgba(64, 81, 137, .25);
        }
        
        .btn:disabled {
            pointer-events: none;
            opacity: .65;
        }
        
        .btn-success {
            color: #fff;
            background-color: #0ab39c;
            border-color: #0ab39c;
        }
        
        .btn-success:hover {
            color: #fff;
            background-color: #099885;
            border-color: #088f7d;
        }
        
        .btn-success:focus {
            color: #fff;
            background-color: #099885;
            border-color: #088f7d;
            -webkit-box-shadow: 0 0 0 0 rgba(47, 190, 171, .5);
            box-shadow: 0 0 0 0 rgba(47, 190, 171, .5);
        }
        
        .btn-success:active {
            color: #fff;
            background-color: #088f7d;
            border-color: #088675;
        }
        
        .btn-success:active:focus {
            -webkit-box-shadow: 0 0 0 0 rgba(47, 190, 171, .5);
            box-shadow: 0 0 0 0 rgba(47, 190, 171, .5);
        }
        
        .btn-success:disabled {
            color: #fff;
            background-color: #0ab39c;
            border-color: #0ab39c;
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
            background-color: var(--vz-card-bg);
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }
        
        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }
        
        .alert {
            position: relative;
            padding: .8rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
        
        .alert-warning {
            color: #b98a38;
            background-color: #fef4e4;
            border-color: #fdeac9;
        }
        
        .d-inline-block {
            display: inline-block!important;
        }
        
        .w-100 {
            width: 100%!important;
        }
        
        .justify-content-center {
            -webkit-box-pack: center!important;
            -ms-flex-pack: center!important;
            justify-content: center!important;
        }
        
        .mx-2 {
            margin-right: .5rem!important;
            margin-left: .5rem!important;
        }
        
        .mt-2 {
            margin-top: .5rem!important;
        }
        
        .mt-3 {
            margin-top: 1rem!important;
        }
        
        .mt-4 {
            margin-top: 1.5rem!important;
        }
        
        .mb-0 {
            margin-bottom: 0!important;
        }
        
        .mb-2 {
            margin-bottom: .5rem!important;
        }
        
        .mb-4 {
            margin-bottom: 1.5rem!important;
        }
        
        .p-2 {
            padding: .5rem!important;
        }
        
        .p-4 {
            padding: 1.5rem!important;
        }
        
        .pt-5 {
            padding-top: 3rem!important;
        }
        
        .text-center {
            text-align: center!important;
        }
        
        .text-decoration-underline {
            text-decoration: underline!important;
        }
        
        .text-primary {
            --vz-text-opacity: 1;
            color: rgba(var(--vz-primary-rgb), var(--vz-text-opacity))!important;
        }
        
        .text-danger {
            --vz-text-opacity: 1;
            color: rgba(var(--vz-danger-rgb), var(--vz-text-opacity))!important;
        }
        
        .text-muted {
            --vz-text-opacity: 1;
            color: #878a99!important;
        }
        
        .text-white-50 {
            --vz-text-opacity: 1;
            color: rgba(255, 255, 255, .5)!important;
        }
        
        @media (min-width:576px) {
            .mt-sm-5 {
                margin-top: 3rem!important;
            }
        }
        /*! CSS Used from: https://themesbrand.com/velzon/html/default/assets/css/icons.min.css */
        
        .mdi:before {
            display: inline-block;
            font: normal normal normal 24px/1 "Material Design Icons";
            font-size: inherit;
            text-rendering: auto;
            line-height: inherit;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .mdi-heart::before {
            content: "\f02d1";
        }
        /*! CSS Used from: https://themesbrand.com/velzon/html/default/assets/css/app.min.css */
        
        :root {
            --vz-body-bg: #f3f3f9;
            --vz-body-color: #212529;
            --vz-body-color-rgb: 33, 37, 41;
            --vz-vertical-menu-bg: #fff;
            --vz-vertical-menu-item-color: #6d7080;
            --vz-vertical-menu-item-hover-color: #405189;
            --vz-vertical-menu-item-active-color: #405189;
            --vz-vertical-menu-sub-item-color: #7c7f90;
            --vz-vertical-menu-sub-item-hover-color: #405189;
            --vz-vertical-menu-sub-item-active-color: #405189;
            --vz-vertical-menu-title-color: #919da9;
            --vz-vertical-menu-bg-dark: #405189;
            --vz-vertical-menu-item-color-dark: #abb9e8;
            --vz-vertical-menu-item-hover-color-dark: #fff;
            --vz-vertical-menu-item-active-color-dark: #fff;
            --vz-vertical-menu-sub-item-color-dark: #abb9e8;
            --vz-vertical-menu-sub-item-hover-color-dark: #fff;
            --vz-vertical-menu-sub-item-active-color-dark: #fff;
            --vz-vertical-menu-title-color-dark: #838fb9;
            --vz-header-bg: #fff;
            --vz-header-item-color: #e9ecef;
            --vz-header-bg-dark: #405189;
            --vz-header-item-color-dark: #b0c4d9;
            --vz-topbar-search-bg: #f3f3f9;
            --vz-topbar-user-bg: #f3f3f9;
            --vz-topbar-user-bg-dark: #52639c;
            --vz-footer-bg: #fff;
            --vz-footer-color: #98a6ad;
            --vz-topnav-bg: #fff;
            --vz-topnav-item-color: #6d7080;
            --vz-topnav-item-color-active: #405189;
            --vz-twocolumn-menu-iconview-bg: #fff;
            --vz-twocolumn-menu-bg: #fff;
            --vz-twocolumn-menu-iconview-bg-dark: var(--vz-vertical-menu-bg-dark);
            --vz-twocolumn-menu-bg-dark: #435590;
            --vz-twocolumn-menu-item-color-dark: var(--vz-vertical-menu-item-color-dark);
            --vz-twocolumn-menu-item-active-color-dark: #fff;
            --vz-twocolumn-menu-item-active-bg-dark: rgba(255, 255, 255, 0.15);
            --vz-boxed-body-bg: #e5e5f2;
            --vz-heading-color: #495057;
            --vz-light: #f3f6f9;
            --vz-light-rgb: 243, 246, 249;
            --vz-dark: #212529;
            --vz-dark-rgb: 33, 37, 41;
            --vz-link-color: #405189;
            --vz-link-hover-color: #405189;
            --vz-border-color: #e9ebec;
            --vz-dropdown-bg: #fff;
            --vz-dropdown-link-color: #212529;
            --vz-dropdown-link-hover-color: #1e2125;
            --vz-dropdown-link-hover-bg: #f3f6f9;
            --vz-dropdown-border-width: 0px;
            --vz-card-bg: #fff;
            --vz-card-cap-bg: #fff;
            --vz-card-logo-dark: block;
            --vz-card-logo-light: none;
            --vz-modal-bg: #fff;
            --vz-nav-tabs-link-active-color: #495057;
            --vz-nav-tabs-link-active-bg: #f3f3f9;
            --vz-accordion-button-active-color: #3a497b;
            --vz-progress-bg: #eff2f7;
            --vz-toast-background-color: rgba(255, 255, 255, 0.85);
            --vz-toast-border-color: rgba(0, 0, 0, 0.1);
            --vz-toast-header-border-color: rgba(0, 0, 0, 0.05);
            --vz-list-group-hover-bg: #f3f6f9;
            --vz-popover-bg: #fff;
            --vz-pagination-hover-bg: #eff2f7;
            --vz-input-bg: #fff;
            --vz-input-border: #ced4da;
            --vz-input-focus-border: #a0a8c4;
            --vz-input-disabled-bg: #eff2f7;
            --vz-input-group-addon-bg: #eff2f7;
            --vz-input-check-border: var(--vz-input-border);
        }
        
        .footer {
            bottom: 0;
            padding: 20px calc(1.5rem / 2);
            position: absolute;
            right: 0;
            color: var(--vz-footer-color);
            left: 250px;
            height: 60px;
            background-color: var(--vz-footer-bg);
        }
        
        @media (max-width:991.98px) {
            .footer {
                left: 0;
            }
        }
        
        .avatar-xl {
            height: 7.5rem;
            width: 7.5rem;
        }
        
        .fs-15 {
            font-size: 15px!important;
        }
        
        .fw-medium {
            font-weight: 500;
        }
        
        .fw-semibold {
            font-weight: 600!important;
        }
        
        .bg-overlay {
            position: absolute;
            height: 100%;
            width: 100%;
            right: 0;
            bottom: 0;
            left: 0;
            top: 0;
            opacity: .7;
            background-color: #000;
        }
        
        [type=email]::-webkit-input-placeholder {
            text-align: left;
        }
        
        [type=email]::-moz-placeholder {
            text-align: left;
        }
        
        [type=email]:-ms-input-placeholder {
            text-align: left;
        }
        
        [type=email]::-ms-input-placeholder {
            text-align: left;
        }
        
        [type=email]::placeholder {
            text-align: left;
        }
        
        @media print {
            .footer {
                display: none!important;
            }
            .card-body,
            body {
                padding: 0;
                margin: 0;
            }
            .card {
                border: 0;
                -webkit-box-shadow: none!important;
                box-shadow: none!important;
            }
        }
        
        html {
            position: relative;
            min-height: 100%;
        }
        
        h5 {
            color: var(--vz-heading-color);
            font-family: Poppins, sans-serif;
        }
        
        a {
            text-decoration: none!important;
        }
        
        label {
            font-weight: 500;
            margin-bottom: .5rem;
        }
        
        @media (min-width:1200px) {
            .container {
                max-width: 1140px;
            }
        }
        
        .row>* {
            position: relative;
        }
        
        .alert-borderless {
            border-width: 0;
        }
        
        a,
        button {
            outline: 0!important;
            position: relative;
        }
        
        .btn {
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        
        .card {
            margin-bottom: 1.5rem;
            -webkit-box-shadow: 0 1px 2px rgba(56, 65, 74, .15);
            box-shadow: 0 1px 2px rgba(56, 65, 74, .15);
        }
        
        .auth-page-wrapper .auth-page-content {
            padding-bottom: 60px;
            position: relative;
            z-index: 2;
            width: 100%;
        }
        
        .auth-page-wrapper .footer {
            left: 0;
            background-color: transparent;
            color: #212529;
        }
        
        .auth-one-bg-position {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 380px;
        }
        
        @media (max-width:575.98px) {
            .auth-one-bg-position {
                height: 280px;
            }
        }
        
        .auth-one-bg {
            background-image: url(https://themesbrand.com/velzon/html/default/assets/images/auth-one-bg.jpg);
            background-position: center;
            background-size: cover;
        }
        
        .auth-one-bg .bg-overlay {
            background: -webkit-gradient(linear, left top, right top, from(#00312d), to(#00312d));
            background: linear-gradient(to right, #00312d, #00312d);
            color: white;
            opacity: .98;
        }
        
        .auth-one-bg .shape {
            position: absolute;
            bottom: 0;
            right: 0;
            left: 0;
            z-index: 1;
            pointer-events: none;
        }
        
        .auth-one-bg .shape>svg {
            width: 100%;
            height: auto;
            fill: var(--vz-body-bg);
        }
        
        .particles-js-canvas-el {
            position: relative;
        }
        /*! CSS Used fontfaces */
        
        @font-face {
            font-family: "Material Design Icons";
            src: url(https://themesbrand.com/velzon/html/default/assets/fonts/materialdesignicons-webfont.eot?v=6.5.95);
            src: url(https://themesbrand.com/velzon/html/default/assets/fonts/materialdesignicons-webfont.eot#iefix&v=6.5.95) format("embedded-opentype"), url(https://themesbrand.com/velzon/html/default/assets/fonts/materialdesignicons-webfont.woff2?v=6.5.95) format("woff2"), url(https://themesbrand.com/velzon/html/default/assets/fonts/materialdesignicons-webfont.woff?v=6.5.95) format("woff"), url(https://themesbrand.com/velzon/html/default/assets/fonts/materialdesignicons-webfont.ttf?v=6.5.95) format("truetype");
            font-weight: 400;
            font-style: normal;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLDz8Z11lFd2JQEl8qw.woff2) format('woff2');
            unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLDz8Z1JlFd2JQEl8qw.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLDz8Z1xlFd2JQEk.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiEyp8kv8JHgFVrJJbecnFHGPezSQ.woff2) format('woff2');
            unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiEyp8kv8JHgFVrJJnecnFHGPezSQ.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiEyp8kv8JHgFVrJJfecnFHGPc.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLGT9Z11lFd2JQEl8qw.woff2) format('woff2');
            unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLGT9Z1JlFd2JQEl8qw.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLGT9Z1xlFd2JQEk.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLEj6Z11lFd2JQEl8qw.woff2) format('woff2');
            unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLEj6Z1JlFd2JQEl8qw.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLEj6Z1xlFd2JQEk.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLCz7Z11lFd2JQEl8qw.woff2) format('woff2');
            unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLCz7Z1JlFd2JQEl8qw.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLCz7Z1xlFd2JQEk.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
            <canvas class="particles-js-canvas-el" width="1905" height="380" style="width: 100%; height: 100%;"></canvas></div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="{{ route('ipdp.home') }}" class="d-inline-block auth-logo">
                                    <img src="https://cdmx.gob.mx/resources/img/adip-header2.svg"
                                        alt="" height="80">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">
                                INSTITUTO DE PLANEACIÓN DEMOCRÁTICA Y PROSPECTIVA DE LA CIUDAD DE MÉXICO 
                            </p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">RECUPERAR CUENTA</h5>
                                    <p class="text-muted">Indique el correo electrónico registrado</p>

                                    <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon>

                                </div>

                                <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                                    ¡Ingrese su correo electrónico y se enviarán las instrucciones para recuperar su cuenta!
                                </div>
                                <div class="p-2">
                                    <form>
                                        <div class="mb-4">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" placeholder="Ingrese e-mail">
                                        </div>

                                        <div class="text-center mt-4">
                                            <button class="btn btn-success w-100" type="submit">Recuperar Contraseña</button>
                                        </div>
                                    </form>
                                    <!-- end form -->
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Si conoces tu contraseña.... <a href="{{ route('ipdp.login') }}" class="fw-semibold text-primary text-decoration-underline"> Click aqui para ingresar</a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                Instituto de Planeación Democrática y Prospectiva | CDMX
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->










    <!-- particles js -->


    <!-- particles app js -->



</body>

</html>