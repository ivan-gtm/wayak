@extends('layouts.frontend')

@section('title', 'Results for: "'.$search_query.'"| Search | Wayak')
    
    @section('meta')
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
        <meta data-rh="true" charset="UTF-8">
        <meta data-rh="true" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <meta data-rh="true" name="google-site-verification" content="">
        <meta data-rh="true" name="apple-itunes-app" content="">
        <meta data-rh="true" name="mailru-verification" content="">
        <meta data-rh="true" name="google" content="no-translate">
        <meta data-rh="true" name="theme-color" content="#51a6ea">
    @endsection

@section('css')
    <style>
        body {
            font-size: 16px;
        }
        /*! CSS Used from: https://static.crello.com/style/app-styles.css?v=1.7.208 */
        
        * {
            box-sizing: border-box;
        }
        
        html {
            width: 100%;
            overflow: hidden;
            font-family: Geometria, sans-serif;
            line-height: 1.15;
        }
        
        body,
        html {
            height: 100%;
        }
        
        body {
            margin: 0;
            overflow-x: hidden;
        }
        
        footer {
            display: block;
        }
        
        button,
        p,
        ul {
            margin: 0;
            padding: 0;
        }
        
        li {
            list-style: none;
        }
        
        a {
            color: inherit;
            text-decoration: none;
            background-color: transparent;
            outline: none;
            cursor: pointer;
            -webkit-text-decoration-skip: objects;
            text-decoration-skip: objects;
        }
        
        a:active,
        a:hover {
            outline-width: 0;
        }
        
        input {
            border: 0;
        }
        
        video {
            display: inline-block;
        }
        
        img {
            border-style: none;
        }
        
        svg {
            display: inline-block;
        }
        
        svg:not(:root) {
            overflow: hidden;
        }
        
        a,
        button,
        input,
        textarea {
            font-family: Geometria;
        }
        
        button,
        input,
        textarea {
            margin: 0;
            font-size: 100%;
            line-height: 1.15;
        }
        
        button,
        input {
            overflow: visible;
        }
        
        button {
            text-transform: none;
        }
        
        button,
        input,
        textarea {
            outline: none;
        }
        
        [type=submit],
        button,
        html [type=button] {
            outline: none;
            cursor: pointer;
            -webkit-appearance: button;
            -moz-appearance: button;
            appearance: button;
        }
        
        button {
            background: transparent;
            border: none;
        }
        
        textarea {
            overflow: auto;
            resize: none;
        }
        
        [direction] {
            background-size: cover;
            transition: background-image .2s;
        }
        
        [data-categ]>* {
            pointer-events: none!important;
        }
        /*! CSS Used from: https://crello.com/style/main.c26dc3efae2fcb1b8d08.css */
        
        .proxima-regular___3FDdY {
            font-family: ProximaRegular;
        }
        
        .proxima-semibold___1HNzk {
            font-family: ProximaSemiBold;
        }
        
        .small___1Vvfz {
            font-size: 14px;
            line-height: 21px;
        }
        
        .proxima-s___29loE {
            font-size: 12px;
            line-height: 16px;
        }
        
        html {
            --ui-btn-color-blue: #2153cc;
            --ui-btn-color-blue-hover: #133fa9;
        }
        
        html {
            --scroll-slider-background: #a9acb2;
        }
        
        html {
            --skeleton-gradient-color1: #e2e2e2;
            --skeleton-gradient-color2: #f2f2f2;
        }
        
        html {
            --my-projects-item-preloader-icon: #cacfd8;
            --my-projects-sidebar-separator: transparent;
        }
        
        .wrapper___2sLIs {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            border-radius: 4px;
            transform: translate(0);
        }
        
        .poster,
        .video___3_MUj {
            position: absolute;
            top: 50%;
            left: 50%;
            max-width: 100%;
            max-height: 100%;
            transform: translate(-50%, -50%);
        }
        
        .poster {
            transition: opacity .5s;
            pointer-events: none;
        }
        
        .poster.fullWidthPoster {
            width: 100%;
        }
        
        .hideVideo___3vTff {
            opacity: 0;
            animation: hideVideo___3vTff .7s;
        }
        
        html {
            --header-nav-link-color: #121316;
            --header-nav-link-color-active: #000;
            --header-nav-ling-color-hover: #f4f4f5;
        }
        
        .link___3OiRu {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            height: 100%;
            padding: 4px;
            color: var(--header-nav-link-color);
            transition: color .3s;
        }
        
        .link___3OiRu:hover .linkLabel___ot3V1 {
            background: var(--header-nav-ling-color-hover);
        }
        
        .link___3OiRu.active___2JazE {
            color: var(--header-nav-link-color-active);
        }
        
        .link___3OiRu.active___2JazE:before {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--header-nav-link-color-active);
            border-radius: 3px 3px 0 0;
            content: "";
        }
        
        .linkLabel___ot3V1 {
            height: 100%;
            padding: 18px 28px;
            border-radius: 8px;
            transition: background .3s, border-radius .3s;
        }
        
        html {
            --header-text-color: #263147;
            --header-text-color-hover: #6a6e76;
        }
        
        html {
            --header-background-color: #fff;
        }
        
        .headerWrapper___3eklQ {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            -ms-flex-pack: justify;
            justify-content: space-between;
            width: 100%;
            height: 64px;
            padding: 0 24px;
            background-color: white;
            z-index: 1;
        }
        
        .headerShadow {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 3;
            height: 6px;
            overflow: hidden;
            transform: translateY(100%);
            opacity: 0;
            transition: opacity .2s ease-in-out;
            pointer-events: none;
        }
        
        .headerShadow.headerShadowVisible {
            opacity: 1;
        }
        
        .headerShadow.headerShadowVisible:before {
            transform: none;
        }
        
        .headerShadow:before {
            position: absolute;
            top: -1px;
            right: 0;
            left: 0;
            height: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04), 0 0 1px rgba(0, 0, 0, .12);
            transform: translateY(-6px);
            transition: transform .2s ease-in-out;
            content: "";
        }
        
        .headerContentLeft {
            z-index: 4;
        }
        
        .flex___2XWAk {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
        }
        
        .navLinksWrapper {
            position: absolute;
            top: 0;
            left: 50%;
            height: 100%;
            transform: translateX(-50%);
        }
        
        .userAvatarWrapper___1_s-3 {
            padding-left: 8px;
        }
        
        .iconM___hNzkq {
            width: 24px;
            height: 24px;
            border-radius: 50%;
        }
        
        .iconM___hNzkq svg {
            width: 12px;
            height: 12px;
        }
        
        .nameContainer___2j7q6 {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
        }
        
        .userAvatar___1Wy79 {
            cursor: pointer;
        }
        
        html {
            --header-logo-color: #000;
        }
        
        .logoWrapper___g2Okg {
            margin-right: 8px;
        }
        
        .logoIconWrapper___2aVXl,
        .logoWrapper___g2Okg {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
        }
        
        .logoIconWrapper___2aVXl {
            height: 100%;
        }
        
        .logo_svg {
            width: 64px;
            height: 25px;
            padding-bottom: 5px;
        }
        
        .logo_svg path {
            fill: var(--header-logo-color);
        }
        
        .dd__wrapper___3GaM8 {
            position: relative;
            z-index: 1;
        }
        
        html {
            --user-menu-background: #fff;
            --user-menu-shadow: 0 0 8px rgba(38, 49, 71, .16);
        }
        
        html {
            --user-menu-color: #121316;
            --user-menu-color-hover: #121316;
            --user-menu-separator-color: rgba(202, 207, 216, .48);
            --user-menu-link-hover: rgba(214, 218, 226, .24);
            --user-menu-link-active: rgba(33, 83, 204, .16);
            --user-menu-link-disabled: #8690a3;
        }
        
        html {
            --user-menu-switcher-icon-color: #000;
        }
        
        .emailVerifiedWrapper___2sRGa,
        .information___3ZfgV {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
        }
        
        .icon___3JlF6 {
            margin-right: 10px;
            color: #f7725e;
        }
        
        .btn___2R2Fl {
            margin-left: 8px;
        }
        
        .emailVerificationContainer___3WLdt {
            position: absolute;
            top: var(--promo-banner-header-height, 0);
            right: 0;
            left: 0;
            z-index: 12;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            height: 40px;
            color: #121316;
            background-color: #fff1f0;
            transform: translateY(-40px);
            opacity: 0;
            transition: transform .3s, opacity .3s;
        }
        
        .emailVerificationContainer___3WLdt.visible___3-WK1 {
            transform: none;
            opacity: 1;
        }
        
        .emailVerificationContainer___3WLdt .close___2ytk_ {
            position: absolute;
            right: 4px;
        }
        
        .footerWrapper___3SH7S {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 4;
            -ms-flex: 0 0 40px;
            flex: 0 0 40px;
            -ms-flex-pack: justify;
            justify-content: space-between;
            min-width: 1024px;
            height: 40px;
            padding: 0 24px;
            background-color: #1d1d23;
        }
        
        .flex___2dArY,
        .footerWrapper___3SH7S {
            display: -ms-flexbox;
            display: flex;
        }
        
        .flex___2dArY {
            -ms-flex-align: center;
            align-items: center;
        }
        
        .ltd___viT5w {
            position: absolute;
            top: 50%;
            left: 50%;
            color: #94949f;
            transform: translate(-50%, -50%);
        }
        
        .item___2MiFd:not(:last-child) {
            margin-right: 8px;
        }
        
        .link___3DrjV {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            color: #fff;
            font-size: 0;
            transition: .3s;
        }
        
        .link___3DrjV:hover {
            color: #94949f;
        }
        
        .mainView {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            height: 100%;
            transition: padding-top .3s;
            --scroll-view-offset-top: calc(var(--header-height, 0px) + var(--notification-height, 0px) + var(--aurora-header-height, 0px) + var(--promo-banner-header-height, 0px));
        }
        
        .mainView.notificationVisible {
            /* --notification-height: 40px; */
            padding-top: calc(var(--notification-height, 0px) + var(--promo-banner-header-height, 0px));
        }
        
        .mainView.headerVisible {
            --header-height: 64px;
        }
        
        .scrollableView___3-vpm {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }
        
        @media (min-width:1024px) {
            .scrollableView___3-vpm {
                overflow-x: hidden;
            }
        }
        
        .routeWrapper___26Hc9 {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-height: calc(100vh - var(--scroll-view-offset-top));
        }
        /* .routeWrapper___26Hc9.hasFooter___25yVq {
            padding-bottom: 40px;
        } */
        
        .footerContent___3RBwi {
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }
        
        .routeContent___pkfmU {
            -ms-flex-positive: 1;
            flex-grow: 1;
        }
        
        html {
            --my-projects-background: #f6f6f7;
            --my-projects-item-background: #fff;
            --my-projects-item-background-hover: #fff;
            --my-projects-item-box-shadow: rgba(93, 99, 113, .35);
            --my-projects-item-edit-background-hover: rgba(38, 49, 71, .48);
            --my-projects-item-preloader-text: #263147;
            --my-projects-function-background: #f4f4f5;
            --my-projects-function-border: #ececec;
            --my-projects-format-text: #5e677a;
            --my-projects-rename-btn-background: #fff;
            --my-projects-rename-btn-svg: #000;
            --my-projects-item-check: #3cb878;
            --select-text: #fff;
            --select-text-hover: #2153cc;
            --select-svg: #fff;
            --select-svg-hover: #2153cc;
            --select-background-hover: #fff;
            --select-border: #fff;
            --select-list-background: #fff;
            --select-list-box-shadow: #cacacb;
            --select-list-text: #1c2639;
            --select-list-text-hover: #2153cc;
            --select-list-background-hover: transparent;
            --design-types-group-color: #19374f;
            --design-types-group-active-color: #2153cc;
            --design-types-group-active-border: #2153cc;
            --design-types-group-border: #2153cc;
            --template-wrapper-box-shadow: #b9bec8;
            --template-name-text: #263147;
            --format-text: #747a84;
            --format-text-hover: #19374f;
            --format-text-active: #fff;
            --format-background-active: #2153cc;
            --format-border: #cdd0d4;
            --format-border-hover: #19374f;
            --format-border-active: #2153cc;
            --project-menu-background: #fff;
            --project-menu-box-shadow: rgba(0, 0, 0, .16);
            --project-menu-text: #000;
            --project-menu-background-hover: rgba(214, 218, 226, .24);
            --project-menu-background-active: rgba(33, 83, 204, .24);
            --project-menu-delete-text: #ff3f38;
            --project-link-text: #263147;
            --project-link-background: #fff;
            --project-link-border: #fff;
            --project-link-text-hover: #fff;
            --project-link-background-hover: #2153cc;
            --project-link-border-hover: #2153cc;
            --multi-action-panel-background: #fff;
            --multi-action-panel-text: #5e677a;
            --multi-action-panel-box-shadow: rgba(83, 85, 87, .3);
            --multi-action-panel-restore-btn-text: #2153cc;
            --multi-action-panel-restore-btn-text-hover: #fff;
            --multi-action-panel-restore-btn-background: transparent;
            --multi-action-panel-restore-btn-background-hover: #2153cc;
            --multi-action-panel-restore-btn-border: #2153cc;
            --multi-action-panel-restore-btn-border-hover: #2153cc;
            --multi-action-panel-delete-btn-text: #ec4f4f;
            --multi-action-panel-delete-btn-background: transparent;
            --multi-action-panel-delete-btn-background-hover: #ec4f4f;
            --multi-action-panel-delete-btn-border: #ec4f4f;
            --multi-action-panel-delete-btn-border-hover: #ec4f4f;
            --editor-header-background: to right, #334059 0%, #334059 8%, #42a2ec 62%, #14cbf2 100%;
            --editor-header-animated-background: to right, #334059 0%, #334059 8%, #3c4f75 62%, #2d55a3 100%;
        }
        
        html {
            --sidebar-active-link: #000;
        }
        
        html {
            --empty-content-title: #263147;
        }
        
        html {
            --new-home-loading-info: #91949c;
            --new-home-loading-spinner: #a9acb2;
            --new-home-list-icon: #a9acb2;
            --new-home-select-search-item: rgba(214, 218, 226, .24);
        }
        
        .search-form-wrapper {
            position: relative;
            z-index: 3;
            margin-bottom: 12px;
            will-change: transform;
        }
        
        .form___1I3Xs {
            position: relative;
        }
        
        .clearButtonVisible___qtH0n {
            padding-right: 92px!important;
        }
        
        .inputControls___BVQJr {
            position: absolute;
            top: 50%;
            display: -ms-flexbox;
            display: flex;
            transform: translateY(-50%);
        }
        
        .inputControls___BVQJr.left___1UDlV {
            left: 8px;
        }
        
        .inputControls___BVQJr.right___3zI72 {
            right: 8px;
        }
        
        .clearBtn___OIzx7 {
            margin-right: 8px;
        }
        
        .searchBtn___3JEWS {
            width: 72px;
            padding: 0 8px!important;
        }
        
        .content {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin: 0 64px 0 80px;
            --row-height: 184px;
        }
        
        .contentLastRowFix:after {
            -ms-flex-positive: 999;
            flex-grow: 999;
            min-width: 20%;
            height: 0;
            content: " ";
        }
        
        .ratioMultiFormats {
            --row-height: 171px;
        }
        
        @media screen and (min-width:1920px) {
            .content {
                margin: 0 136px 0 160px;
            }
        }
        
        html {
            --new-home-try-this: #121316;
        }
        
        html {
            --slider-padding-top: 4px;
        }
        
        .caption {
            height: 48px;
            margin: 8px 0 0;
            color: #121316;
            font-size: 12px;
            line-height: 16px;
            text-align: center;
            will-change: transform;
        }
        
        .caption.noSubTitle {
            height: 28px;
        }
        
        .title___3aJ-x {
            pointer-events: auto;
        }
        
        .title___3aJ-x {
            max-height: 32px;
            overflow: hidden;
        }
        
        .item {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-item-align: end;
            align-self: flex-end;
            cursor: pointer;
        }
        
        .item:hover .imgWrapper {
            box-shadow: 0 8px 16px rgba(0, 0, 0, .08), 0 0 1px rgba(0, 0, 0, .16);
            transform: translateY(-2px);
        }
        
        .item {
            margin-right: 24px;
        }
        
        .bottomIndentSmall {
            margin-bottom: 16px;
        }
        
        .preview {
            position: relative;
            height: var(--row-height);
            background-color: #f4f4f5;
            border-radius: 8px;
        }
        
        .imgWrapper {
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .08), 0 0 1px rgba(0, 0, 0, .16);
            transition: .3s cubic-bezier(.645, .045, .355, 1);
        }
        
        @media screen and (min-width:1920px) {
            .bottomIndentSmall {
                margin-bottom: 24px;
            }
        }
        
        .imgWrapper_ {
            position: relative;
            width: 100%;
            will-change: transform;
        }
        
        .itemImg {
            position: absolute;
            display: -ms-flexbox;
            display: flex;
            height: 100%;
        }
        
        .itemImg,
        .itemImg video {
            width: 100%;
        }
        
        .itemImg.centered___2L2r1 {
            top: 50%;
            height: auto;
            transform: translateY(-50%);
        }
        
        .itemImg.blurredBackImage___1kk7p {
            transform: scale(1.5);
            opacity: .7;
            filter: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg"><filter id="filter"><feGaussianBlur stdDeviation="10" /></filter></svg>#filter');
            filter: blur(10px);
        }
        
        html {
            --settings-sidebar-separator: transparent;
        }
        
        .paginationWrapper {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
        }
        
        .paginationWrapper .pageInput___1mj0B {
            max-width: 56px;
            height: 40px;
            margin: 0 8px;
            text-align: center;
        }
        
        .paginationWrapper .button___33J2d {
            height: 40px;
            padding: 12px 16px;
        }
        
        .search-header,
        .containerBottom {
            margin: 0 80px;
        }
        
        @media screen and (min-width:1920px) {
            .search-header,
            .containerBottom {
                margin: 0 160px;
            }
        }
        
        .search-header {
            padding-top: 64px;
        }
        
        .containerBottom {
            padding-top: 28px;
        }
        
        .title___3sRwO {
            color: #121316;
        }
        
        .paginationWrapper {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
        }
        
        .paginationRange {
            margin-right: 16px;
        }
        
        .pagination {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }
        
        .pagination.top {
            margin: 40px 0 32px;
        }
        
        .pagination.bottom___2OkNp {
            position: relative;
            -ms-flex-pack: end;
            justify-content: flex-end;
        }
        
        .wrapper___2hP9G {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding-bottom: 104px;
        }
        
        .wrapper___2hP9G.hasPagination {
            padding-bottom: 80px;
        }
        
        .nextPageButton___rOiwa {
            position: absolute;
            left: 50%;
            min-width: 240px;
            transform: translateX(-50%);
        }
        /*! CSS Used from: Embedded */
        
        iframe#_hjRemoteVarsFrame {
            display: none!important;
            width: 1px!important;
            height: 1px!important;
            opacity: 0!important;
            pointer-events: none!important;
        }
        /*! CSS Used from: Embedded */
        
        .bhdLno {
            display: inline-flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            font-family: ProximaSemiBold;
            box-sizing: border-box;
            font-size: 14px;
            line-height: 20px;
            cursor: pointer;
            transition: color 0.3s ease 0s, background-color ease 0s, box-shadow ease 0s;
            border: none;
            outline: none;
            text-decoration: none;
        }
        
        .llxIqU {
            height: 40px;
            padding: 10px 16px;
            border-radius: 8px;
            background-color: transparent;
            color: rgb(33, 83, 204);
            pointer-events: auto;
        }
        
        .llxIqU:hover,
        .llxIqU:active {
            background-color: rgb(213, 231, 254);
        }
        
        .llxIqU:disabled {
            color: rgb(148, 188, 249);
        }
        
        .llxIqU:disabled:hover {
            background-color: transparent;
            cursor: not-allowed;
        }
        
        .lhRPKu {
            height: 48px;
            padding: 12px 24px;
            font-size: 16px;
            line-height: 24px;
            border-radius: 8px;
            background-color: transparent;
            color: rgb(18, 19, 22);
            pointer-events: auto;
        }
        
        .lhRPKu:hover,
        .lhRPKu:active {
            background-color: rgb(232, 232, 234);
        }
        
        .lhRPKu:disabled,
        .lhRPKu[disabled] {
            background-color: transparent;
            color: rgb(169, 172, 178);
        }
        
        .lhRPKu:disabled:hover,
        .lhRPKu[disabled]:hover {
            cursor: not-allowed;
        }
        
        .iISRbV {
            height: 48px;
            padding: 12px 24px;
            font-size: 16px;
            line-height: 24px;
            border-radius: 8px;
            background-color: transparent;
            color: rgb(33, 83, 204);
            box-shadow: rgb(33, 83, 204) 0px 0px 0px 2px inset;
            pointer-events: auto;
        }
        
        .iISRbV:hover,
        .iISRbV:active {
            background-color: rgb(33, 83, 204);
            color: rgb(255, 255, 255);
        }
        
        .iISRbV:disabled {
            box-shadow: rgb(148, 188, 249) 0px 0px 0px 2px inset;
            color: rgb(148, 188, 249);
        }
        
        .iISRbV:disabled:hover {
            background-color: transparent;
            cursor: not-allowed;
        }
        
        .chrFRV {
            opacity: 1;
            display: inline-flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            transition: opacity 0.1s ease 0s;
        }
        
        .cvSgtG {
            position: relative;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            transition: all 0.3s ease 0s;
            border: none;
            padding: 4px 8px;
            color: rgb(169, 172, 178);
            outline: none;
            background: transparent;
            cursor: pointer;
            pointer-events: auto;
        }
        
        .ezRehF {
            height: 32px;
            min-width: 32px;
            border-radius: 4px;
        }
        
        .ezRehF:hover,
        .ezRehF:active {
            background: transparent;
            color: rgb(70, 74, 83);
        }
        
        .eYItKN {
            height: 40px;
            min-width: 40px;
            border-radius: 8px;
        }
        
        .eYItKN:hover,
        .eYItKN:active {
            background: transparent;
            color: rgb(70, 74, 83);
        }
        
        .typography-subheading-m {
            font-family: ProximaSemiBold;
            font-size: 14px;
            line-height: 20px;
        }
        
        .typography-body-m {
            font-family: ProximaRegular;
            font-size: 14px;
            line-height: 20px;
        }
        
        .typography-marketing-display-s {
            font-family: FugueRegular;
            font-size: 24px;
            line-height: 24px;
        }
        
        @media screen and (max-width: 360px) {
            .typography-marketing-display-s {
                font-size: 20px;
                line-height: 20px;
            }
        }
        
        .jpHeDI {
            display: inline-block;
            width: 16px;
            height: 16px;
            fill: currentcolor;
            flex-shrink: 0;
            transition: fill 0.3s ease 0s;
        }
        
        .bunAU {
            display: inline-block;
            width: 14px;
            height: 14px;
            fill: currentcolor;
            flex-shrink: 0;
            transition: fill 0.3s ease 0s;
        }
        
        .hxbxfY {
            display: inline-block;
            width: 24px;
            height: 24px;
            fill: currentcolor;
            flex-shrink: 0;
            transition: fill 0.3s ease 0s;
        }
        
        .cnhfsE {
            display: inline-block;
            width: 16px;
            height: 16px;
            fill: currentcolor;
            flex-shrink: 0;
            transition: fill 0.3s ease 0s, transform 0.3s ease 0s;
            transform: rotate(-90deg);
        }
        
        .bydJWw {
            display: inline-block;
            width: 18px;
            height: 18px;
            fill: currentcolor;
            flex-shrink: 0;
            transition: fill 0.3s ease 0s;
        }
        
        .ecgval {
            display: inline-block;
            width: 16px;
            height: 16px;
            fill: currentcolor;
            flex-shrink: 0;
            transition: fill 0.3s ease 0s, transform 0.3s ease 0s;
            transform: rotate(90deg);
        }
        
        .jtoZmK {
            display: inline-flex;
            margin-left: 4px;
            font-size: 0px;
        }
        
        .kGntgQ {
            display: inline-flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            font-family: ProximaSemiBold;
            box-sizing: border-box;
            cursor: pointer;
            transition: color 0.3s ease 0s;
            outline: none;
            text-decoration: none;
            pointer-events: auto;
        }
        
        .fSMFFj {
            height: 40px;
            padding: 13px 0px;
            font-size: 14px;
            line-height: 14px;
            color: rgb(33, 83, 204);
        }
        
        .fSMFFj:hover,
        .fSMFFj:active {
            color: rgb(7, 44, 155);
        }
        
        .guKkvw {
            position: relative;
            display: flex;
            padding: 0px;
            margin: 0px;
        }
        
        .fTLfYv {
            display: flex;
            transition: background 0.3s ease 0s, box-shadow 0.3s ease 0s, color 0.3s ease 0s;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
        }
        
        .fYNCUl {
            padding-right: 16px;
            padding-left: 16px;
            height: 56px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 24px;
            background: rgb(255, 255, 255);
            color: rgb(18, 19, 22);
            box-shadow: rgb(232, 232, 234) 0px 0px 0px 2px inset;
        }
        
        .fYNCUl::-webkit-input-placeholder {
            color: rgb(169, 172, 178);
        }
        
        .fYNCUl::placeholder {
            color: rgb(169, 172, 178);
        }
        
        .fYNCUl:hover {
            background: rgb(255, 255, 255);
            box-shadow: rgb(214, 215, 217) 0px 0px 0px 2px inset;
        }
        
        .fYNCUl:focus {
            background: rgb(255, 255, 255);
            box-shadow: rgb(33, 83, 204) 0px 0px 0px 2px inset;
        }
        
        .fYNCUl:disabled {
            background: rgb(251, 252, 252);
            color: rgb(169, 172, 178);
            box-shadow: rgb(244, 244, 245) 0px 0px 0px 2px inset;
        }
        
        .fYNCUl:disabled:hover {
            cursor: not-allowed;
        }
        
        .fYNCUl:disabled::-webkit-input-placeholder {
            color: rgb(214, 215, 217);
        }
        
        .fYNCUl:disabled::placeholder {
            color: rgb(214, 215, 217);
        }
        
        .ikXwLi {
            padding-right: 16px;
            padding-left: 16px;
            height: 48px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 24px;
            background: rgb(255, 255, 255);
            color: rgb(18, 19, 22);
            box-shadow: rgb(232, 232, 234) 0px 0px 0px 2px inset;
        }
        
        .ikXwLi::-webkit-input-placeholder {
            color: rgb(169, 172, 178);
        }
        
        .ikXwLi::placeholder {
            color: rgb(169, 172, 178);
        }
        
        .ikXwLi:hover {
            background: rgb(255, 255, 255);
            box-shadow: rgb(214, 215, 217) 0px 0px 0px 2px inset;
        }
        
        .ikXwLi:focus {
            background: rgb(255, 255, 255);
            box-shadow: rgb(33, 83, 204) 0px 0px 0px 2px inset;
        }
        
        .ikXwLi:disabled {
            background: rgb(251, 252, 252);
            color: rgb(169, 172, 178);
            box-shadow: rgb(244, 244, 245) 0px 0px 0px 2px inset;
        }
        
        .ikXwLi:disabled:hover {
            cursor: not-allowed;
        }
        
        .ikXwLi:disabled::-webkit-input-placeholder {
            color: rgb(214, 215, 217);
        }
        
        .ikXwLi:disabled::placeholder {
            color: rgb(214, 215, 217);
        }
        
        .eHNofp {
            position: relative;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            justify-content: space-between;
            width: 100%;
            cursor: pointer;
            box-sizing: border-box;
            transition: all 0.2s cubic-bezier(0.645, 0.045, 0.355, 1) 0s;
            color: rgb(18, 19, 22);
            box-shadow: transparent 0px 0px 0px 2px inset;
            background-color: rgb(255, 255, 255);
        }
        
        .hHPkIi {
            position: relative;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            justify-content: space-between;
            width: 100%;
            cursor: pointer;
            box-sizing: border-box;
            transition: all 0.2s cubic-bezier(0.645, 0.045, 0.355, 1) 0s;
            color: rgb(255, 255, 255);
            box-shadow: transparent 0px 0px 0px 2px inset;
            background-color: transparent;
        }
        
        .iHaOcn {
            display: flex;
            -webkit-box-align: center;
            align-items: center;
        }
        
        .gaGeRK {
            margin-right: 8px;
            font-size: 0px;
            display: inline-flex;
        }
        
        .laquCT {
            margin-right: 4px;
        }
        
        .iHnRgU {
            fill: rgb(70, 74, 83);
        }
        
        .MZExO {
            fill: rgb(244, 244, 245);
        }
        
        .bqEzOS {
            height: 40px;
            padding: 0px 12px 0px 16px;
            border-radius: 8px;
        }
        
        .bqEzOS:hover {
            background-color: rgb(232, 232, 234);
        }
        
        .GOxAW {
            height: 32px;
            padding: 0px 8px 0px 12px;
            border-radius: 4px;
        }
        
        .GOxAW:hover {
            background-color: rgb(70, 70, 83);
        }
        /*! CSS Used from: Embedded */
        
        ._hj-f5b2a1eb-9b07_widget,
        ._hj-f5b2a1eb-9b07_widget * {
            line-height: normal;
            font-family: Arial, sans-serif, Tahoma!important;
            text-transform: initial!important;
            letter-spacing: normal!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget,
        ._hj-f5b2a1eb-9b07_widget div {
            height: auto;
        }
        
        ._hj-f5b2a1eb-9b07_widget div,
        ._hj-f5b2a1eb-9b07_widget span,
        ._hj-f5b2a1eb-9b07_widget p,
        ._hj-f5b2a1eb-9b07_widget a,
        ._hj-f5b2a1eb-9b07_widget button {
            font-weight: normal!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget div,
        ._hj-f5b2a1eb-9b07_widget span,
        ._hj-f5b2a1eb-9b07_widget p,
        ._hj-f5b2a1eb-9b07_widget a {
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
            margin: 0;
            padding: 0;
            float: none!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget span {
            color: inherit;
        }
        
        ._hj-f5b2a1eb-9b07_widget button {
            margin: 0;
            padding: 0;
            float: none!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget input {
            vertical-align: middle;
        }
        
        ._hj-f5b2a1eb-9b07_widget *:after,
        ._hj-f5b2a1eb-9b07_widget *::before {
            -webkit-box-sizing: initial;
            -moz-box-sizing: initial;
            box-sizing: initial;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon {
            speak: none!important;
            font-style: normal!important;
            font-weight: normal!important;
            font-variant: normal!important;
            text-transform: none!important;
            overflow-wrap: normal!important;
            word-break: normal!important;
            word-wrap: normal!important;
            white-space: nowrap!important;
            line-height: normal!important;
            -webkit-font-smoothing: antialiased!important;
            -moz-osx-font-smoothing: grayscale!important;
        }
        
        div._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon,
        div._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon:before,
        div._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon:after,
        div._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon *,
        div._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon *:before,
        div._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon *:after {
            font-family: "hotjar"!important;
            display: inline-block!important;
            direction: ltr!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon:before {
            color: inherit!important;
        }
        
        ._hj-f5b2a1eb-9b07_icon-x:before {
            content: "\e803";
        }
        
        ._hj-f5b2a1eb-9b07_icon-ok:before {
            content: "\e804";
        }
        
        ._hj-f5b2a1eb-9b07_icon-select-element:before {
            content: "\e91a";
        }
        
        ._hj-f5b2a1eb-9b07_widget {
            font-size: 13px!important;
            position: fixed;
            z-index: 2147483640;
            bottom: -400px;
            right: 100px;
            width: 300px;
            -webkit-border-radius: 5px 5px 0 0;
            -moz-border-radius: 5px 5px 0 0;
            border-radius: 5px 5px 0 0;
            -webkit-transform: translateZ(0)!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_rounded_corners {
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_shadow {
            -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);
            box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_transition {
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            -ms-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_pull_right {
            float: right!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_clear_both {
            display: block!important;
            clear: both!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_link_no_underline,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_link_no_underline:hover {
            text-decoration: none!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_wordwrap {
            word-break: break-word;
            word-wrap: break-word;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_title {
            font-weight: bold!important;
            text-align: center;
            padding: 12px!important;
            margin: 0;
            line-height: 17px!important;
            min-height: 17px;
            word-break: break-word;
            word-wrap: break-word;
            cursor: pointer;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary {
            cursor: pointer;
            text-decoration: none!important;
            font-size: 13px!important;
            font-weight: bold!important;
            padding: 7px 10px!important;
            border: 0!important;
            outline: 0!important;
            height: initial!important;
            min-height: initial!important;
            display: -moz-inline-stack;
            display: inline-block;
            *display: inline;
            vertical-align: top;
            width: auto!important;
            min-width: initial!important;
            zoom: 1;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear:after,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary:after {
            content: none!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary {
            background: #00C764!important;
            color: white;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary:hover,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary:focus,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary:active {
            background: #00a251!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear {
            background: transparent!important;
            font-weight: normal!important;
            text-decoration: underline!important;
            color: !important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear:hover,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear:focus,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear:active {
            background: transparent!important;
            color: !important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:hover,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:focus,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:active {
            cursor: default;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_content {
            padding: 0 12px;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_content ._hj-f5b2a1eb-9b07_input_field {
            font-family: Arial, sans-serif, Tahoma;
            font-size: 14px;
            color: #333!important;
            padding: 6px!important;
            text-indent: 0!important;
            height: 30px;
            width: 100%;
            min-width: 100%;
            margin: 0 0 12px 0;
            background: white;
            border: 1px solid!important;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            outline: none!important;
            max-width: none!important;
            float: none;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_content ._hj-f5b2a1eb-9b07_input_field:focus {
            border: 1px solid #00a251;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_content textarea._hj-f5b2a1eb-9b07_input_field {
            resize: none;
            height: 100px;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_footer {
            width: 100%;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_footer ._hj-f5b2a1eb-9b07_pull_right {
            padding: 12px 12px 12px 0;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_footer ._hj-f5b2a1eb-9b07_pull_right button {
            padding-right: 5px;
        }
        
        ._hj-f5b2a1eb-9b07_widget {
            background: !important;
            color: !important;
        }
        
        ._hj-f5b2a1eb-9b07_widget a,
        ._hj-f5b2a1eb-9b07_widget a:link,
        ._hj-f5b2a1eb-9b07_widget a:hover,
        ._hj-f5b2a1eb-9b07_widget a:active {
            color: !important;
        }
        
        ._hj-f5b2a1eb-9b07_widget p {
            color: !important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_content ._hj-f5b2a1eb-9b07_input_field {
            border: 1px solid!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_footer {
            border-top: 1px solid!important;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:hover,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:focus,
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:active {
            color: !important;
            background: !important;
        }
        /*! CSS Used from: Embedded */
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_default *:before {
            color: #3c3c3c;
            margin-left: -1.3984375em;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_default ._hj-f5b2a1eb-9b07_icon_emotion_path1:before {
            content: "\e900";
            color: #ffd902;
            margin: 0;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_default._hj-f5b2a1eb-9b07_bottom_position_launcher *:before {
            color: #ffffff;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_default._hj-f5b2a1eb-9b07_bottom_position_launcher ._hj-f5b2a1eb-9b07_icon_emotion_path1:before {
            color: #1b2935;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_default[data-emotion-score="3"] ._hj-f5b2a1eb-9b07_icon_emotion_path2:before {
            content: "\e907";
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_emoji {
            width: 34px;
            height: 34px;
            background-size: 34px;
            background-repeat: no-repeat;
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_emoji[data-emotion-score="0"] {
            /* background-image: url(https://script.hotjar.com/emoji_0.4c6dff.png); */
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_emoji[data-emotion-score="1"] {
            /* background-image: url(https://script.hotjar.com/emoji_1.384afb.png); */
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_emoji[data-emotion-score="2"] {
            /* background-image: url(https://script.hotjar.com/emoji_2.7b3140.png); */
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_emoji[data-emotion-score="3"] {
            /* background-image: url(https://script.hotjar.com/emoji_3.14e2ff.png); */
        }
        
        ._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon_emotion_emoji[data-emotion-score="4"] {
            /* background-image: url(https://script.hotjar.com/emoji_4.bcd136.png); */
        }
        
        #_hj-f5b2a1eb-9b07_feedback {
            bottom: 0;
            right: 0;
        }
        
        #_hj-f5b2a1eb-9b07_feedback #_hj-f5b2a1eb-9b07_feedback_minimized {
            display: none;
            opacity: .96;
            height: 110px;
            position: fixed;
            direction: ltr!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback #_hj-f5b2a1eb-9b07_feedback_minimized:hover {
            opacity: 1;
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_hotjar_buddy {
            position: absolute;
            right: 0;
            bottom: 0;
            height: 50px;
            width: 52px;
            font-size: 37px;
            cursor: pointer;
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_hotjar_buddy>span {
            position: relative;
            z-index: 2;
        }
        
        #_hj-f5b2a1eb-9b07_feedback #_hj-f5b2a1eb-9b07_feedback_minimized ._hj-f5b2a1eb-9b07_hotjar_buddy:after {
            content: "";
            position: absolute;
            z-index: 1;
            top: 17px;
            left: 25px;
            background: rgba(0, 0, 0, .48);
            width: 6px;
            height: 1px;
            -webkit-box-shadow: 0 2px 18px 18px rgba(0, 0, 0, .48);
            -moz-box-shadow: 0 2px 18px 18px rgba(0, 0, 0, .48);
            box-shadow: 0 2px 18px 18px rgba(0, 0, 0, .48);
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            -ms-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
        }
        
        #_hj-f5b2a1eb-9b07_feedback #_hj-f5b2a1eb-9b07_feedback_minimized:hover ._hj-f5b2a1eb-9b07_hotjar_buddy:after {
            -webkit-box-shadow: 0 2px 18px 18px rgba(0, 0, 0, .65);
            -moz-box-shadow: 0 2px 18px 18px rgba(0, 0, 0, .65);
            box-shadow: 0 2px 18px 18px rgba(0, 0, 0, .65);
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_feedback_minimized_message {
            opacity: 0;
            pointer-events: none;
            position: absolute;
            bottom: 11px;
            padding: 12px 15px;
            width: 180px;
            text-align: center;
            font-size: 12px!important;
            cursor: pointer;
            background: #ffffff;
            -webkit-box-shadow: 0 2px 18px 0 rgba(0, 0, 0, .3);
            -moz-box-shadow: 0 2px 18px 0 rgba(0, 0, 0, .3);
            box-shadow: 0 2px 18px 0 rgba(0, 0, 0, .3);
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_feedback_minimized_message:before {
            content: "";
            width: 1px;
            height: 1px;
            position: absolute;
            bottom: 13px;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_feedback_minimized_message ._hj-f5b2a1eb-9b07_feedback_minimized_message_close {
            opacity: 0;
            position: absolute;
            top: -9px;
            right: -9px;
            width: 21px;
            height: 21px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            font-size: 11px;
            line-height: 21px!important;
            text-align: center;
            cursor: pointer;
            background-color: #1b2935;
            color: #ffffff;
        }
        
        #_hj-f5b2a1eb-9b07_feedback #_hj-f5b2a1eb-9b07_feedback_minimized_message:hover ._hj-f5b2a1eb-9b07_feedback_minimized_message_close {
            opacity: 1;
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_feedback_minimized_message span {
            display: none!important;
            color: #333333!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback #_hj-f5b2a1eb-9b07_feedback_minimized:hover ._hj-f5b2a1eb-9b07_feedback_minimized_message {
            -webkit-box-shadow: 0 2px 24px 0 rgba(0, 0, 0, .33);
            -moz-box-shadow: 0 2px 24px 0 rgba(0, 0, 0, .33);
            box-shadow: 0 2px 24px 0 rgba(0, 0, 0, .33);
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_feedback_minimized_label {
            position: relative;
            width: 40px;
            padding: 12px 14px 12px 12px;
            background: #1b2935;
            cursor: pointer;
            -webkit-transition: -webkit-box-shadow 0.1s ease-in-out;
            -moz-transition: -moz-box-shadow 0.1s ease-in-out;
            -o-transition: -o-box-shadow 0.1s ease-in-out;
            -ms-transition: -ms-box-shadow 0.1s ease-in-out;
            transition: box-shadow 0.1s ease-in-out;
            -webkit-box-sizing: border-box!important;
            -moz-box-sizing: border-box!important;
            box-sizing: border-box!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_feedback_minimized_label:hover {
            -webkit-box-shadow: 0 0 35px 2px rgba(0, 0, 0, .24);
            -moz-box-shadow: 0 0 35px 2px rgba(0, 0, 0, .24);
            box-shadow: 0 0 35px 2px rgba(0, 0, 0, .24);
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] ._hj-f5b2a1eb-9b07_feedback_minimized_label {
            right: -2px;
            border-radius: 3px 0 0 3px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] ._hj-f5b2a1eb-9b07_feedback_minimized_label:hover {
            right: 0;
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_feedback_minimized_label ._hj-f5b2a1eb-9b07_feedback_minimized_label_text {
            color: #ffffff;
            display: inline-block!important;
            overflow-wrap: normal!important;
            word-break: normal!important;
            word-wrap: normal!important;
            white-space: nowrap!important;
            filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=2);
            cursor: pointer;
            -webkit-writing-mode: vertical-lr;
            -moz-writing-mode: vertical-lr;
            -ms-writing-mode: tb-rl;
            -o-writing-mode: vertical-lr;
            writing-mode: vertical-lr;
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] ._hj-f5b2a1eb-9b07_feedback_minimized_message:before {
            right: -7px;
            border-left: 7px solid white;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] #_hj-f5b2a1eb-9b07_feedback_open_close {
            display: none;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] #_hj-f5b2a1eb-9b07_feedback_open_close_phone {
            display: block;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] #_hj-f5b2a1eb-9b07_feedback_open {
            bottom: 401px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] ._hj-f5b2a1eb-9b07_hotjar_buddy {
            display: none!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] ._hj-f5b2a1eb-9b07_feedback_minimized_message {
            top: 50%;
            bottom: auto;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] #_hj-f5b2a1eb-9b07_feedback_minimized {
            bottom: 501px;
            right: 0;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-minimized-position="middle_right"] ._hj-f5b2a1eb-9b07_feedback_minimized_message {
            right: 52px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open_close {
            opacity: 0;
            pointer-events: none;
            position: fixed;
            z-index: 10;
            bottom: 33px;
            width: 44px;
            height: 37px;
            font-size: 20px;
            text-align: center!important;
            cursor: pointer;
            background-color: #1b2935!important;
            color: #ffffff!important;
            padding-left: 1px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 2px 10px 1px rgba(0, 0, 0, .18);
            -moz-box-shadow: 0 2px 10px 1px rgba(0, 0, 0, .18);
            box-shadow: 0 2px 10px 1px rgba(0, 0, 0, .18);
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open_close_phone {
            display: none;
            font-size: 18px;
            text-align: center;
            cursor: pointer;
            background-color: #1b2935;
            color: #ffffff;
            width: 36px;
            height: 36px;
            z-index: 11;
            right: 20px;
            top: -17px;
            position: absolute;
            border-radius: 50%;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open_close span,
        #_hj-f5b2a1eb-9b07_feedback_open_close_phone span {
            line-height: 36px!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback #_hj-f5b2a1eb-9b07_feedback_open {
            opacity: 0;
            pointer-events: none;
            position: absolute;
            z-index: 10;
            width: 320px;
            bottom: 84px;
            right: 30px;
            background: #ffffff;
            -webkit-box-shadow: 0 6px 100px 0 rgba(0, 0, 0, .35)!important;
            -moz-box-shadow: 0 6px 100px 0 rgba(0, 0, 0, .35)!important;
            box-shadow: 0 6px 100px 0 rgba(0, 0, 0, .35)!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback #_hj-f5b2a1eb-9b07_feedback_open [data-state] {
            display: none;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_emotion_content {
            margin-top: 30px;
            margin-bottom: 50px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_emotion_content ._hj-f5b2a1eb-9b07_emotion_option {
            position: relative;
            float: left!important;
            bottom: -50px;
            opacity: 0;
            width: 20%;
            text-align: center;
            font-size: 26px;
            cursor: pointer;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_emotion_content ._hj-f5b2a1eb-9b07_emotion_text {
            position: absolute;
            font-size: 12px;
            color: #999;
            text-align: center;
            top: 47px;
            left: 0;
            right: 0;
            opacity: 0;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open #_hj-f5b2a1eb-9b07_state-1 ._hj-f5b2a1eb-9b07_emotion_content:hover ._hj-f5b2a1eb-9b07_emotion_option {
            opacity: .5;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open #_hj-f5b2a1eb-9b07_state-1 ._hj-f5b2a1eb-9b07_emotion_content ._hj-f5b2a1eb-9b07_emotion_option:hover {
            opacity: 1;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open #_hj-f5b2a1eb-9b07_state-1 ._hj-f5b2a1eb-9b07_emotion_content ._hj-f5b2a1eb-9b07_emotion_option:hover ._hj-f5b2a1eb-9b07_emotion_text {
            opacity: 1;
            top: 42px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open #_hj-f5b2a1eb-9b07_state-1 ._hj-f5b2a1eb-9b07_emotion_comment_holder {
            position: relative;
            display: none;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open #_hj-f5b2a1eb-9b07_state-1 ._hj-f5b2a1eb-9b07_emotion_comment_footer {
            display: none;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open #_hj-f5b2a1eb-9b07_state-1 ._hj-f5b2a1eb-9b07_emotion_comment_holder:before {
            content: "";
            width: 1px;
            height: 1px;
            position: absolute;
            left: auto;
            top: -6px;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 5px solid rgba(0, 0, 0, .1);
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open #_hj-f5b2a1eb-9b07_state-1 ._hj-f5b2a1eb-9b07_emotion_comment_footer:empty {
            display: none;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_toolset_actions {
            margin: -3px -12px 12px -12px;
            background: #eaeaeb!important;
            padding: 10px 20px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_toolset_actions>div {
            font-size: 22px;
            opacity: .75;
            cursor: pointer;
            display: inline-block;
            position: relative;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_toolset_actions>div:hover {
            opacity: 1;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_toolset_actions>div>._hj-f5b2a1eb-9b07_toolset_tooltip {
            background: black;
            color: white;
            font-size: 12px;
            padding: 8px 12px;
            border-radius: 3px;
            position: absolute;
            left: 40px;
            top: -4px;
            width: 195px;
            opacity: 0;
            pointer-events: none;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_toolset_actions>div>._hj-f5b2a1eb-9b07_toolset_tooltip:before {
            content: "";
            width: 1px;
            height: 1px;
            position: absolute;
            left: -6px;
            top: 10px;
            border-top: 4px solid transparent;
            border-bottom: 4px solid transparent;
            border-right: 5px solid black;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_open ._hj-f5b2a1eb-9b07_toolset_actions>div:hover>._hj-f5b2a1eb-9b07_toolset_tooltip {
            opacity: 1;
        }
        
        #_hj-f5b2a1eb-9b07_feedback ._hj-f5b2a1eb-9b07_feedback_content_dimmer {
            opacity: 0;
            background: black;
            position: fixed;
            z-index: -1;
            -webkit-transition: opacity .2s ease-in-out;
            -moz-transition: opacity .2s ease-in-out;
            -o-transition: opacity .2s ease-in-out;
            -ms-transition: opacity .2s ease-in-out;
            transition: opacity .2s ease-in-out;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_content_highlighter {
            display: none;
            border: 4px dashed #ffd902;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            position: fixed;
            z-index: -1;
            -webkit-box-sizing: initial!important;
            -moz-box-sizing: initial!important;
            box-sizing: initial!important;
            -webkit-transition: border .2s linear;
            -moz-transition: border .2s ease-in-out;
            -o-transition: border .2s ease-in-out;
            -ms-transition: border .2s ease-in-out;
            transition: border .2s ease-in-out;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_content_highlighter #_hj-f5b2a1eb-9b07_feedback_content_highlighter_close {
            display: none;
            font-size: 12px;
            text-align: center;
            cursor: pointer;
            background-color: #1b2935;
            color: #ffffff;
            z-index: 11;
            right: -12px;
            top: -13px;
            position: absolute;
            border-radius: 50%;
            padding: 5px 7px 3px 7px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight {
            position: fixed;
            pointer-events: none;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 5;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>._hj-f5b2a1eb-9b07_feedback_page_highlight_line {
            opacity: 0;
            position: absolute;
            background: #1b2935;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_page_highlight_line_top {
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_page_highlight_line_right {
            top: 0;
            bottom: 0;
            right: 0;
            width: 4px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_page_highlight_line_bottom {
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_page_highlight_line_left {
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_top_message_select {
            opacity: 0;
            position: fixed;
            top: -4px;
            left: 50%;
            width: 260px;
            margin-left: -130px;
            padding: 23px 0 19px 0;
            text-align: center;
            font-size: 13px;
            -webkit-border-radius: 0 0 10px 10px;
            -moz-border-radius: 0 0 10px 10px;
            border-radius: 0 0 10px 10px;
            background-color: #ffd902;
            color: #3c3c3c;
            -webkit-box-shadow: 0 2px 25px 3px rgba(0, 0, 0, .3);
            -moz-box-shadow: 0 2px 25px 3px rgba(0, 0, 0, .3);
            box-shadow: 0 2px 25px 3px rgba(0, 0, 0, .3);
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_top_message_select:before,
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_top_message_select:after {
            content: "";
            display: block;
            width: 55px;
            height: 50px;
            background-color: #1b2935;
            position: absolute;
            top: 0;
            z-index: -1;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_top_message_select:before {
            left: -9px;
            -webkit-transform: skewX(20deg);
            -moz-transform: skewX(20deg);
            -ms-transform: skewX(20deg);
            transform: skewX(20deg);
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_top_message_select:after {
            right: -9px;
            -webkit-transform: skewX(-20deg);
            -moz-transform: skewX(-20deg);
            -ms-transform: skewX(-20deg);
            transform: skewX(-20deg);
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_top_message_select #_hj-f5b2a1eb-9b07_feedback_top_message_select_close {
            position: absolute;
            right: 13px;
            top: 21px;
            color: #3c3c3c;
            text-decoration: none;
            cursor: pointer;
            height: 19px;
            width: 19px;
            padding: 3px 0 0 1px;
            border-radius: 50%;
            background: transparent;
            -webkit-box-sizing: border-box!important;
            -moz-box-sizing: border-box!important;
            box-sizing: border-box!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback_page_highlight>#_hj-f5b2a1eb-9b07_feedback_top_message_select #_hj-f5b2a1eb-9b07_feedback_top_message_select_close:hover {
            background: rgba(0, 0, 0, .2);
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget * {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget p {
            color: #333333!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary:hover,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary:focus,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_primary:active {
            background: #1b2935!important;
            color: #ffffff!important;
            font-weight: normal!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear {
            color: #aaaaaa!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear:hover,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear:focus,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_clear:active {
            color: #666666!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:hover,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:focus,
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_btn_disabled:active {
            background: #cccccc!important;
            color: #333333!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_title {
            padding: 30px!important;
            cursor: default;
            font-size: 17px;
            font-weight: normal!important;
            line-height: normal!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_content ._hj-f5b2a1eb-9b07_input_field {
            border: 0!important;
            background: #eaeaeb!important;
            color: #454A55!important;
            padding: 12px 20px!important;
            margin-left: -12px;
            margin-right: -12px;
            margin-bottom: 10px;
            width: 320px;
            -webkit-box-shadow: none!important;
            -moz-box-shadow: none!important;
            box-shadow: none!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_content textarea._hj-f5b2a1eb-9b07_input_field {
            height: 105px!important;
            line-height: 18px!important;
            margin-bottom: 0;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_content input._hj-f5b2a1eb-9b07_input_field {
            height: 46px;
            !important;
            text-align: center;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_icon-select-element:before {
            color: #454A55!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_footer {
            border-top: 0!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback._hj-f5b2a1eb-9b07_widget ._hj-f5b2a1eb-9b07_widget_footer ._hj-f5b2a1eb-9b07_pull_right {
            display: none;
            padding-top: 0;
            border-top: 0!important;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-state="minimized"] {
            width: 80px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-state="minimized"] #_hj-f5b2a1eb-9b07_feedback_minimized {
            display: block;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-state="minimized"] ._hj-f5b2a1eb-9b07_feedback_content_dimmer,
        #_hj-f5b2a1eb-9b07_feedback[data-state="minimized"] #_hj-f5b2a1eb-9b07_feedback_content_highlighter {
            display: none;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-viewmode="desktop"][data-minimized-position="middle_right"] #_hj-f5b2a1eb-9b07_feedback_minimized {
            bottom: 501px;
            right: 0;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-viewmode="desktop"][data-minimized-position="middle_right"] ._hj-f5b2a1eb-9b07_feedback_minimized_message {
            right: 52px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-viewmode="desktop"][data-minimized-position="middle_right"] #_hj-f5b2a1eb-9b07_feedback_open {
            right: 15px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-viewmode="desktop"] #_hj-f5b2a1eb-9b07_feedback_open_close_phone {
            font-size: 15px;
            width: 27px;
            height: 27px;
            top: -13px;
        }
        
        #_hj-f5b2a1eb-9b07_feedback[data-viewmode="desktop"] #_hj-f5b2a1eb-9b07_feedback_open_close_phone span {
            line-height: 27px!important;
        }
        
        @media print {
            #_hj_feedback_container {
                display: none!important;
            }
        }
        /*! CSS Used keyframes */
        
        @keyframes hideVideo___3vTff {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    </style>

    <style>/*! CSS Used from: Embedded */
        *{box-sizing:border-box;}
        a{color:inherit;text-decoration:none;background-color:transparent;outline:none;cursor:pointer;-webkit-text-decoration-skip:objects;text-decoration-skip:objects;}
        a:active,a:hover{outline-width:0;}
        a{font-family:Geometria;}
        [data-categ]>*{pointer-events:none!important;}
        .link___3OiRu{position:relative;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;height:100%;padding:4px;color:var(--header-nav-link-color);transition:color .3s;}
        .link___3OiRu:hover .linkLabel___ot3V1{background:var(--header-nav-ling-color-hover);}
        .link___3OiRu.active___2JazE{border-bottom:4px solid;color:black;}
        .link___3OiRu.active___2JazE:before{position:absolute;bottom:0;left:0;width:100%;height:3px;background-color:var(--header-nav-link-color-active);border-radius:3px 3px 0 0;content:"";}
        .linkLabel___ot3V1{height:100%;padding:18px 28px;border-radius:8px;transition:background .3s,border-radius .3s;}
        .headerWrapper___3eklQ{position:relative;display:-ms-flexbox;display:flex;-ms-flex-negative:0;flex-shrink:0;-ms-flex-pack:justify;justify-content:space-between;width:100%;height:64px;padding:0 24px;background-color:var(--header-background-color);}
        .headerShadow___2L53V{position:absolute;right:0;bottom:0;left:0;z-index:3;height:6px;overflow:hidden;transform:translateY(100%);opacity:0;transition:opacity .2s ease-in-out;pointer-events:none;}
        .headerShadow___2L53V:before{position:absolute;top:-1px;right:0;left:0;height:1px;box-shadow:0 2px 4px rgba(0,0,0,.04),0 0 1px rgba(0,0,0,.12);transform:translateY(-6px);transition:transform .2s ease-in-out;content:"";}
        .headerContentLeft___tlZaq{z-index:4;}
        .flex___2XWAk{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;}
        .navLinksWrapper___1I469{position:absolute;top:0;left:50%;height:100%;transform:translateX(-50%);}
        .logoWrapper___g2Okg{margin-right:8px;}
        .logoIconWrapper___2aVXl,.logoWrapper___g2Okg{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;}
        .logoIconWrapper___2aVXl{height:100%;color:black;font-size:28px;}
        .typography-subheading-m{font-family:'PT Sans Caption';font-size:14px;line-height:20px;}
        .typography-body-m{color:black;font-family:'PT Sans Caption';font-size:14px;line-height:20px;}
        *{box-sizing:border-box;}
        [data-categ]>*{pointer-events:none!important;}
        a{-webkit-text-decoration-skip:objects;background-color:transparent;color:#fff;color:inherit;cursor:pointer;cursor:pointer;outline:none;text-decoration:none;text-decoration:none;text-decoration-skip:objects;}
        a{font-family:'PT Sans Caption';}
        a:active,a:hover{outline-width:0;}
        *{box-sizing:border-box;}
        [data-categ]>*{pointer-events:none!important;}
        a{-webkit-text-decoration-skip:objects;background-color:transparent;color:inherit;cursor:pointer;outline:none;text-decoration:none;text-decoration-skip:objects;}
        a{font-family:'PT Sans Caption';}
        a:active,a:hover{outline-width:0;}
        a{background-color:transparent;background-color:transparent;}
        a:active,a:hover{outline:0;outline:0;}
        a{background-color:transparent;background-color:transparent;background-color:transparent;background-color:transparent;color:#fff;color:#fff;cursor:pointer;cursor:pointer;text-decoration:none;text-decoration:none;}
        a:active,a:hover{outline:0;outline:0;outline:0;outline:0;}
        a{color:#fff;cursor:pointer;text-decoration:none;}
        /*! CSS Used from: Embedded */
        *{box-sizing:border-box;}
        a{color:inherit;text-decoration:none;background-color:transparent;outline:none;cursor:pointer;-webkit-text-decoration-skip:objects;text-decoration-skip:objects;}
        a:active,a:hover{outline-width:0;}
        a{font-family:Geometria;}
        [data-categ]>*{pointer-events:none!important;}
        .link___3OiRu{position:relative;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;height:100%;padding:4px;color:var(--header-nav-link-color);transition:color .3s;}
        .link___3OiRu:hover .linkLabel___ot3V1{background:var(--header-nav-ling-color-hover);}
        .link___3OiRu.active___2JazE{border-bottom:4px solid;color:black;}
        .link___3OiRu.active___2JazE:before{position:absolute;bottom:0;left:0;width:100%;height:3px;background-color:var(--header-nav-link-color-active);border-radius:3px 3px 0 0;content:"";}
        .linkLabel___ot3V1{height:100%;padding:18px 28px;border-radius:8px;transition:background .3s,border-radius .3s;}
        .headerWrapper___3eklQ{position:relative;display:-ms-flexbox;display:flex;-ms-flex-negative:0;flex-shrink:0;-ms-flex-pack:justify;justify-content:space-between;width:100%;height:64px;padding:0 24px;background-color:var(--header-background-color);}
        .headerShadow___2L53V{position:absolute;right:0;bottom:0;left:0;z-index:3;height:6px;overflow:hidden;transform:translateY(100%);opacity:0;transition:opacity .2s ease-in-out;pointer-events:none;}
        .headerShadow___2L53V:before{position:absolute;top:-1px;right:0;left:0;height:1px;box-shadow:0 2px 4px rgba(0,0,0,.04),0 0 1px rgba(0,0,0,.12);transform:translateY(-6px);transition:transform .2s ease-in-out;content:"";}
        .headerContentLeft___tlZaq{z-index:4;}
        .flex___2XWAk{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;}
        .navLinksWrapper___1I469{position:absolute;top:0;left:50%;height:100%;transform:translateX(-50%);}
        .logoWrapper___g2Okg{margin-right:8px;}
        .logoIconWrapper___2aVXl,.logoWrapper___g2Okg{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;}
        .logoIconWrapper___2aVXl{height:100%;color:black;font-size:28px;}
        .typography-subheading-m{font-family:'PT Sans Caption';font-size:14px;line-height:20px;}
        .typography-body-m{color:black;font-family:'PT Sans Caption';font-size:14px;line-height:20px;}
        *{box-sizing:border-box;}
        [data-categ]>*{pointer-events:none!important;}
        a{-webkit-text-decoration-skip:objects;background-color:transparent;color:#fff;color:inherit;cursor:pointer;cursor:pointer;outline:none;text-decoration:none;text-decoration:none;text-decoration-skip:objects;}
        a{font-family:'PT Sans Caption';}
        a:active,a:hover{outline-width:0;}
        *{box-sizing:border-box;}
        [data-categ]>*{pointer-events:none!important;}
        a{-webkit-text-decoration-skip:objects;background-color:transparent;color:inherit;cursor:pointer;outline:none;text-decoration:none;text-decoration-skip:objects;}
        a{font-family:'PT Sans Caption';}
        a:active,a:hover{outline-width:0;}
        a{background-color:transparent;background-color:transparent;}
        a:active,a:hover{outline:0;outline:0;}
        a{background-color:transparent;background-color:transparent;background-color:transparent;background-color:transparent;color:#fff;color:#fff;cursor:pointer;cursor:pointer;text-decoration:none;text-decoration:none;}
        a:active,a:hover{outline:0;outline:0;outline:0;outline:0;}
        a{color:#fff;cursor:pointer;text-decoration:none;}
        /*! CSS Used fontfaces */
        @font-face{font-family:'PT Sans Caption';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/ptsanscaption/v13/0FlMVP6Hrxmt7-fsUFhlFXNIlpcadw_xYS2ix0YK.woff2) format('woff2');unicode-range:U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;}
        @font-face{font-family:'PT Sans Caption';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/ptsanscaption/v13/0FlMVP6Hrxmt7-fsUFhlFXNIlpcafg_xYS2ix0YK.woff2) format('woff2');unicode-range:U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;}
        @font-face{font-family:'PT Sans Caption';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/ptsanscaption/v13/0FlMVP6Hrxmt7-fsUFhlFXNIlpcadA_xYS2ix0YK.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'PT Sans Caption';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/ptsanscaption/v13/0FlMVP6Hrxmt7-fsUFhlFXNIlpcaeg_xYS2ixw.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'PT Sans Caption';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/ptsanscaption/v13/0FlMVP6Hrxmt7-fsUFhlFXNIlpcadw_xYS2ix0YK.woff2) format('woff2');unicode-range:U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;}
        @font-face{font-family:'PT Sans Caption';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/ptsanscaption/v13/0FlMVP6Hrxmt7-fsUFhlFXNIlpcafg_xYS2ix0YK.woff2) format('woff2');unicode-range:U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;}
        @font-face{font-family:'PT Sans Caption';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/ptsanscaption/v13/0FlMVP6Hrxmt7-fsUFhlFXNIlpcadA_xYS2ix0YK.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'PT Sans Caption';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/ptsanscaption/v13/0FlMVP6Hrxmt7-fsUFhlFXNIlpcaeg_xYS2ixw.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
    </style>
@endsection

@section('content')
    
    <div id="react-view" style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; overflow: auto; height: 100vh;">
        <div class="mainView notificationVisible headerVisible" id="app-view">
            <div class="scrollableView___3-vpm notificationVisible">
                <div class="routeWrapper___26Hc9">
                    <div class="routeContent___pkfmU">
                        <div class="wrapper___2hP9G hasPagination">
                            <div>
                                <div class="search-header">
                                    <div class="search-form-wrapper">
                                        <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('user.search',['country' => $country, 'page' => $page]) }}">
                                            @csrf
                                            <div class="sc-dmlrTW guKkvw">
                                                <input type="text" autocomplete="off" name="searchQuery" class="sc-kfzAmx sc-fKFyDc fTLfYv fYNCUl proxima-regular___3FDdY clearButtonVisible___qtH0n" placeholder="Busca entre miles de formatos y diseños" style="padding-left: 20px;" value="{{ $search_query }}">
                                            </div>
                                            <div class="inputControls___BVQJr left___1UDlV"></div>
                                            <div class="inputControls___BVQJr right___3zI72">
                                                <a class="sc-eCssSg sc-jSgupP cvSgtG eYItKN typography-subheading-m clearBtn___OIzx7" href="{{ route('user.search',['country' => $country]) }}">
                                                    <svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY"><path d="M18.8274 17.1818C18.9379 17.2914 19 17.4405 19 17.5961C19 17.7517 18.9379 17.9009 18.8274 18.0104L18.0104 18.8274C17.9009 18.9379 17.7517 19 17.5961 19C17.4405 19 17.2914 18.9379 17.1818 18.8274L12 13.6456L6.81819 18.8274C6.70862 18.9379 6.55947 19 6.40387 19C6.24828 19 6.09913 18.9379 5.98956 18.8274L5.17261 18.0104C5.06214 17.9009 5 17.7517 5 17.5961C5 17.4405 5.06214 17.2914 5.17261 17.1818L10.3544 12L5.17261 6.81819C5.06214 6.70862 5 6.55947 5 6.40387C5 6.24828 5.06214 6.09913 5.17261 5.98956L5.98956 5.17261C6.09913 5.06214 6.24828 5 6.40387 5C6.55947 5 6.70862 5.06214 6.81819 5.17261L12 10.3544L17.1818 5.17261C17.2914 5.06214 17.4405 5 17.5961 5C17.7517 5 17.9009 5.06214 18.0104 5.17261L18.8274 5.98956C18.9379 6.09913 19 6.24828 19 6.40387C19 6.55947 18.9379 6.70862 18.8274 6.81819L13.6456 12L18.8274 17.1818Z"></path></svg>
                                                </a>
                                                <button type="submit" class="bhdLno llxIqU searchBtn___3JEWS" data-categ="homeSearchForm" data-value="submit">
                                                    <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 24 24" width="24" height="24" class="sc-fubCfw hxbxfY"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.4138 15.8368L21.8574 20.2857C22.0558 20.5064 22.046 20.8443 21.8352 21.0532L21.0575 21.8317C20.9532 21.937 20.8113 21.9962 20.6632 21.9962C20.5151 21.9962 20.3731 21.937 20.2688 21.8317L15.8252 17.3828C15.7023 17.2596 15.5907 17.1256 15.4919 16.9824L14.6587 15.8701C13.2802 16.9723 11.5682 17.5724 9.80409 17.5719C6.16878 17.5845 3.00983 15.0738 2.19744 11.5261C1.38504 7.97844 3.13601 4.34066 6.41372 2.76643C9.69143 1.1922 13.6211 2.10166 15.8763 4.95639C18.1314 7.81111 18.1102 11.8492 15.8252 14.68L16.9361 15.4475C17.1096 15.5586 17.2698 15.6892 17.4138 15.8368ZM4.24951 9.78627C4.24951 12.8576 6.73635 15.3475 9.80402 15.3475C11.2772 15.3475 12.69 14.7616 13.7317 13.7186C14.7733 12.6757 15.3585 11.2612 15.3585 9.78627C15.3585 6.7149 12.8717 4.22507 9.80402 4.22507C6.73635 4.22507 4.24951 6.7149 4.24951 9.78627Z"></path></svg></div>
                                                </button>
                                            </div>
                                        </form>
                                        <div></div>
                                    </div>
                                    <div class="pagination top">
                                        <div class="typography-marketing-display-s title___3sRwO">Plantillas de "{{ $search_query }}"</div>
                                        <div class="paginationWrapper"><span class="typography-body-m paginationRange">{{ $from_document }}-{{ $to_document }} de {{ $total_documents }}</span>
                                            <div class="paginationWrapper">
                                                <a class="bhdLno lhRPKu button___33J2d" href="{{ route('user.search',['page' => ($page-1), 'country' => $country, 'searchQuery' => $search_query]) }}">
                                                    <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 16 16" width="16" height="16" direction="left" class="sc-fubCfw ecgval"><path d="M14.463 4.11761C14.5381 4.04234 14.6403 4 14.747 4C14.8536 4 14.9558 4.04234 15.0309 4.11761L15.8788 4.96052C15.9561 5.03267 16 5.13341 16 5.23884C16 5.34427 15.9561 5.44501 15.8788 5.51716L8.52792 12.8251C8.41552 12.9369 8.26304 12.9999 8.10398 13H7.89602C7.73696 12.9999 7.58448 12.9369 7.47208 12.8251L0.121197 5.51716C0.0438665 5.44501 0 5.34427 0 5.23884C0 5.13341 0.0438665 5.03267 0.121197 4.96052L0.969068 4.11761C1.04416 4.04234 1.14639 4 1.25302 4C1.35966 4 1.46189 4.04234 1.53698 4.11761L8 10.5428L14.463 4.11761Z"></path></svg></div>
                                                </a>
                                                <div class="sc-dmlrTW guKkvw">
                                                    <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('user.search',['country' => $country]) }}">
                                                        @csrf
                                                        <input type="text" class="sc-kfzAmx sc-fKFyDc fTLfYv ikXwLi pageInput___1mj0B" value="{{ $page }}">
                                                    </form>
                                                </div>
                                                <a class="bhdLno lhRPKu button___33J2d" href="{{ route('user.search',['page' => ($page+1), 'country' => $country, 'searchQuery' => $search_query]) }}">
                                                    <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 16 16" width="16" height="16" direction="right" class="sc-fubCfw cnhfsE"><path d="M14.463 4.11761C14.5381 4.04234 14.6403 4 14.747 4C14.8536 4 14.9558 4.04234 15.0309 4.11761L15.8788 4.96052C15.9561 5.03267 16 5.13341 16 5.23884C16 5.34427 15.9561 5.44501 15.8788 5.51716L8.52792 12.8251C8.41552 12.9369 8.26304 12.9999 8.10398 13H7.89602C7.73696 12.9999 7.58448 12.9369 7.47208 12.8251L0.121197 5.51716C0.0438665 5.44501 0 5.34427 0 5.23884C0 5.13341 0.0438665 5.03267 0.121197 4.96052L0.969068 4.11761C1.04416 4.04234 1.14639 4 1.25302 4C1.35966 4 1.46189 4.04234 1.53698 4.11761L8 10.5428L14.463 4.11761Z"></path></svg>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="content ratioMultiFormats contentLastRowFix">
                                        @foreach ($templates as $template )
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="{{ 
                                                route( 'admin.edit.template',[
                                                'language_code' => $language_code,
                                                'template_key' => $template->_id
                                                ] )
                                            }}" style="width: calc(var(--row-height) * 0.714286); flex-grow: 7.14286;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 140%;">
                                                <img alt="{{ $template->title }}" crossorigin="anonymous" loading="lazy" data-categ="invitations" data-value="{{ $template->_id }}" 
                                                    src="{{ asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] ) }}"
                                                    class="itemImg">
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">{{ $template->title }}</div>
                                            </div>
                                        </a>
                                        @endforeach
                                        <!--                                         
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b23c9891eb1c99e2a1f4534&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs">
                                                        <video src="https://cdn.crello.com/video-convert/fde2e60e-44c9-43e1-97a9-e20ab98aeea5.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns" data-value="5b23c9891eb1c99e2a1f4534"></video>
                                                        <img crossorigin="anonymous" src="https://cdn.crello.com/common/b4730cd5-0336-4118-ad72-560b5abac7db_450.jpg" class="poster videoItem fullWidthPoster" loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicación Video Cuadrado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b3b66e61eb1c99e2a69ca6d&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/e4b5d27a-8b83-42ff-889a-6ca1688d892e.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b3b66e61eb1c99e2a69ca6d"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/0917b61e-ba21-4ebe-aa90-1932eec828f7_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b3340701eb1c99e2ace934e&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Portada con Video Facebook 851 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5b3340701eb1c99e2ace934e" src="https://cdn.crello.com/common/ee52c197-ac6d-47de-ac01-380b504648e5_450.jpg"
                                                    class="itemImg blurredBackImage___1kk7p">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/69679e61-cc8b-4d97-a045-56897da4df87.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b3340701eb1c99e2ace934e"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/ee52c197-ac6d-47de-ac01-380b504648e5_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada con Video Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5aa91748f07aee69773c9505&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Anuncio de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5aa91748f07aee69773c9505" src="https://cdn.crello.com/downloads/b287f8b6-f9f7-445a-a1aa-ed1bf4439394_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=58ab09f195a7a863ddcc7344&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Publicaciones de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="58ab09f195a7a863ddcc7344" src="https://cdn.crello.com/common/f3718233-b51c-47b6-9a37-3078e886352e_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5d02178e8cba87f943b8c75a&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/8a210363-5320-4e04-a097-9658b0f8bed3.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5d02178e8cba87f943b8c75a"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/fa02a7f5-4c24-449f-b8e1-218b21f567fe_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia con Video Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5a22e318d8141396fe9a773c&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Portada de Evento de Facebook 1920 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5a22e318d8141396fe9a773c" src="https://cdn.crello.com/common/692f36bf-56ba-4253-bcc3-f462baf0e3fa_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada de Evento de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5cebe5967d4459dfe11971ce&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Portada de Facebook 851 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5cebe5967d4459dfe11971ce" src="https://cdn.crello.com/common/76ae1dbd-d5ec-4a6d-a572-6b5a7c319b9f_450.jpg"
                                                    class="itemImg blurredBackImage___1kk7p"><img alt="Portada de Facebook 851 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5cebe5967d4459dfe11971ce" src="https://cdn.crello.com/common/76ae1dbd-d5ec-4a6d-a572-6b5a7c319b9f_450.jpg"
                                                    class="itemImg centered___2L2r1"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b6302671cc8aa542951f8a1&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/a73ee349-0b2a-40e4-8d9a-7bb29d12d0bb.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b6302671cc8aa542951f8a1"></video><img crossorigin="anonymous" src="https://cdn.crello.com/downloads/8c052efd-df12-450e-9a29-7c4294cc484d_450.jpeg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5954be4595a7a863ddce154c&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.40604); flex-grow: 14.0604;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 71.12%;"><img alt="Tarjeta Postal 419 × 298 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5954be4595a7a863ddce154c" src="https://cdn.crello.com/common/e908ca1e-de7c-4783-a2ce-5fffc7b9d7f4_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Tarjeta Postal</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=589d8da095a7a863ddcc5840&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Anuncio de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="589d8da095a7a863ddcc5840" src="https://cdn.crello.com/common/558dd9f7-c8b4-48f2-9b6f-82da9d48f2e2_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=590b111295a7a863ddcd748c&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.266667); flex-grow: 2.66667;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 375%;"><img alt="Skyscraper 160 × 600 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="590b111295a7a863ddcd748c" src="https://cdn.crello.com/common/28210f72-766d-44b2-b006-819a219b2ef9_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Skyscraper</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5ea9a58c499b85dcc779c4fc&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/b2e7fa5d-34bb-4249-b0e6-644e1c6cf0b6.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5ea9a58c499b85dcc779c4fc"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/74590f14-6a94-4253-b30f-6aab25fa9ab3_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Fondo de Zoom</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5e8efab44b3890eb076235f7&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;"><img alt="Historia de Instagram 1080 × 1920 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5e8efab44b3890eb076235f7" src="https://cdn.crello.com/downloads/0da7b28e-70b4-4ee3-8a80-4b00ea3f39ff_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=58aefb4295a7a863ddcc8ec6&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.707071); flex-grow: 7.07071;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 141.43%;"><img alt="Cartel 1190 × 1683 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="58aefb4295a7a863ddcc8ec6" src="https://cdn.crello.com/downloads/4b890bf2-6005-4399-9cab-f642c206b533_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Cartel</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b602c2d00f9c6103aa378d0&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/d82f72c6-833b-4cec-846f-361f781847ae.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b602c2d00f9c6103aa378d0"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/7c04d7f5-0e33-4bb2-92ca-22f06256daed_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5d4bd4bfcf657b21ef3acd9c&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Portada de Evento de Facebook 1920 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5d4bd4bfcf657b21ef3acd9c" src="https://cdn.crello.com/downloads/19372936-2ab0-45bd-865a-f0f1e537c311_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada de Evento de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5d7a5c91abc8ea6d1c996d9d&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/6c1c95ff-7de0-49c2-a933-e22e71757ee2.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5d7a5c91abc8ea6d1c996d9d"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/a37b0bef-4c0f-48a3-aaa0-b5f56b19edbd_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicación Video Cuadrado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=592d1da895a7a863ddcd9b66&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Encabezado de Blog 1200 × 600 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="592d1da895a7a863ddcd9b66" src="https://cdn.crello.com/common/2d1ff09d-f0b0-4cf5-a947-cf6ec7830516_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Encabezado de Blog</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5f4c9d1da637ee11e34a367e&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Banner de Twitch Offline 1920 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5f4c9d1da637ee11e34a367e" src="https://cdn.crello.com/common/e7436339-d355-4576-99c9-9ee45730751f_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Banner de Twitch Offline</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5ff43d56a637ee11e34124c8&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.91083); flex-grow: 19.1083;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 52.33%;"><img alt="Anuncio de Facebook 1200 × 628 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5ff43d56a637ee11e34124c8" src="https://cdn.crello.com/downloads/06ee940b-d68a-420e-87d7-1fc1efc1c773_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5952711295a7a863ddcded4e&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.40604); flex-grow: 14.0604;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 71.12%;"><img alt="Tarjeta 419 × 298 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5952711295a7a863ddcded4e" src="https://cdn.crello.com/common/da64bafd-275f-484e-aaab-aee758193f78_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Tarjeta</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b6c568b1cc8aa54292ec7dd&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/a553b4da-4fd0-46f1-bcaa-dc1698506dff.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b6c568b1cc8aa54292ec7dd"></video><img crossorigin="anonymous" src="https://cdn.crello.com/downloads/54d8dcb4-c417-40a6-bf5a-39d0473c82f5_450.jpeg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5954bdfe95a7a863ddce14fe&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.714286); flex-grow: 7.14286;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 140%;"><img alt="Volantes 360 × 504 pul" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5954bdfe95a7a863ddce14fe" src="https://cdn.crello.com/common/55d1d075-e562-4f3a-a283-02270582abee_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Volantes</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5e732fed4b3890eb07beb5e5&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/6f5d0616-0bfb-43bd-be1b-106605cb1a30.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5e732fed4b3890eb07beb5e5"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/545b0f57-e530-4578-b76c-999407729be0_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicación Video Cuadrado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5bcef32d78e1194aa6d0c5e2&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/1b333636-c778-44a2-9341-cbed3ab3fd08.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5bcef32d78e1194aa6d0c5e2"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/18a243c0-e41a-46df-bd0b-7f5cc2d0bce1_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicación Video Cuadrado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5ea9a0af499b85dcc768bdea&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Fondo de Zoom 1920 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5ea9a0af499b85dcc768bdea" src="https://cdn.crello.com/common/3d90e907-a6bc-463c-9dcf-c9d655647705_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Fondo de Zoom</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=593146ea95a7a863ddcdcf93&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.707071); flex-grow: 7.07071;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 141.43%;"><img alt="Cartel 1190 × 1683 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="593146ea95a7a863ddcdcf93" src="https://cdn.crello.com/common/fb2406ec-fec9-4a03-b6c0-f118711c7311_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Cartel</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b59b96000f9c6103addeecf&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Portada con Video Facebook 851 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5b59b96000f9c6103addeecf" src="https://cdn.crello.com/common/a0b6eb6f-0cd4-4420-b88e-ee33c60bf94c_450.jpg"
                                                    class="itemImg blurredBackImage___1kk7p">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/a52d4d56-2a88-4124-979f-20dac96de709.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b59b96000f9c6103addeecf"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/a0b6eb6f-0cd4-4420-b88e-ee33c60bf94c_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada con Video Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b7166561cc8aa54296c647a&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.714286); flex-grow: 7.14286;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 140%;"><img alt="Invitación 360 × 504 pul" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5b7166561cc8aa54296c647a" src="https://cdn.crello.com/common/471862ee-53a8-45e5-9ece-0b0968327dfa_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Invitación</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=599ecdcf1350e8329300796a&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.40604); flex-grow: 14.0604;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 71.12%;"><img alt="Tarjeta 419 × 298 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="599ecdcf1350e8329300796a" src="https://cdn.crello.com/common/92d53ff8-176b-4c6b-aebf-6085e5a9711a_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Tarjeta</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5db83852abc8ea6d1c835979&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/28058a69-abcb-40c4-9e59-53519b5b3bba.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5db83852abc8ea6d1c835979"></video><img crossorigin="anonymous" src="https://cdn.crello.com/downloads/bf6b89ad-bc71-47c9-ac50-8f98d4006704_450.jpeg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia con Video Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5928162a95a7a863ddcd94b0&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.40604); flex-grow: 14.0604;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 71.12%;"><img alt="Tarjeta 419 × 298 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5928162a95a7a863ddcd94b0" src="https://cdn.crello.com/common/156dbf28-01d7-4f11-93f1-0977eba12582_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Tarjeta</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=58a418a095a7a863ddcc70c9&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.666667); flex-grow: 6.66667;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 150%;"><img alt="Gráficos Tumblr 540 × 810 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="58a418a095a7a863ddcc70c9" src="https://cdn.crello.com/common/3f9317ee-99be-4522-a766-532792b7cd34_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Gráficos Tumblr</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5889aee395a7a863ddcc3830&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Encabezado de Blog 1200 × 600 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5889aee395a7a863ddcc3830" src="https://cdn.crello.com/common/cb7e6815-00c9-4f86-bd46-5523f47f2137_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Encabezado de Blog</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5df3acb89fea0cc3741d1e56&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Publicaciones de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5df3acb89fea0cc3741d1e56" src="https://cdn.crello.com/common/69e9e350-1a7c-470d-a7df-54961973b375_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=59524ef295a7a863ddcde24c&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.40604); flex-grow: 14.0604;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 71.12%;"><img alt="Tarjeta 419 × 298 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="59524ef295a7a863ddcde24c" src="https://cdn.crello.com/common/1294565c-7c6f-4db8-bea8-91174627e415_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Tarjeta</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5e7a32ec4b3890eb07267660&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;"><img alt="Historia de Instagram 1080 × 1920 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5e7a32ec4b3890eb07267660" src="https://cdn.crello.com/common/e587ad97-49cd-4da1-9bbf-7a497f53bbb7_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5cd9564e7d4459dfe1fe7fad&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/9a5351ea-efc4-4b6f-aef8-007b8e5df87b.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5cd9564e7d4459dfe1fe7fad"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/e81605b4-f448-40c7-8d76-97a487d52d42_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia con Video Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5d95efc2abc8ea6d1cf3946e&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Portada de comunidad Vkontakte 1590 × 400 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5d95efc2abc8ea6d1cf3946e" src="https://cdn.crello.com/common/cd097667-1cb5-43b8-bc81-d883a798c3ad_450.jpg"
                                                    class="itemImg blurredBackImage___1kk7p"><img alt="Portada de comunidad Vkontakte 1590 × 400 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5d95efc2abc8ea6d1cf3946e" src="https://cdn.crello.com/common/cd097667-1cb5-43b8-bc81-d883a798c3ad_450.jpg"
                                                    class="itemImg centered___2L2r1"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada de comunidad Vkontakte</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5d7a273babc8ea6d1c0ca76c&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/57e6dd14-072f-402e-bf98-c7fc375a5b9b.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5d7a273babc8ea6d1c0ca76c"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/2d7dcd8a-3049-42e0-a708-ac1393479333_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia con Video Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5e8473344b3890eb07ac3e7b&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Fondo de Zoom 1920 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5e8473344b3890eb07ac3e7b" src="https://cdn.crello.com/downloads/37f76a11-10d8-413d-ab51-a42a8689a820_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Fondo de Zoom</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5f97e7fea637ee11e3877c93&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Mapa mental 1280 × 720 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5f97e7fea637ee11e3877c93" src="https://cdn.crello.com/common/218f3ad8-5a62-4f0b-a0e2-4b641a328b22_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Mapa mental</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b0809fc1e2cc446e7743e20&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Anuncio de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5b0809fc1e2cc446e7743e20" src="https://cdn.crello.com/common/09b16474-cea8-49a3-8aa1-dbd8b3cfa14b_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5c99f96e85ea3c16f950b841&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;"><img alt="Historia de Instagram 1080 × 1920 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5c99f96e85ea3c16f950b841" src="https://cdn.crello.com/common/9e939b2e-17fb-4312-be54-96c97c3673f9_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5fbb8d05a637ee11e36a779c&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.91083); flex-grow: 19.1083;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 52.33%;"><img alt="Anuncio de Facebook 1200 × 628 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5fbb8d05a637ee11e36a779c" src="https://cdn.crello.com/downloads/e3f7e20e-aed4-4de3-a6dc-4eabd53448bd_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5953611895a7a863ddce13db&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Anuncio de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5953611895a7a863ddce13db" src="https://cdn.crello.com/common/9b67751e-2a5a-462b-a4ad-78796a9e0e4b_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=589df87595a7a863ddcc5de3&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.714286); flex-grow: 7.14286;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 140%;"><img alt="Volantes 360 × 504 pul" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="589df87595a7a863ddcc5de3" src="https://cdn.crello.com/common/a8f654d5-6caf-4f3d-bc3d-728226141725_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Volantes</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5df3a7259fea0cc3740d8119&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Encabezado de Blog 1200 × 600 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5df3a7259fea0cc3740d8119" src="https://cdn.crello.com/common/39675cf3-8e1f-4769-ab19-c59024364137_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Encabezado de Blog</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5aa6ad64f07aee697773f0b2&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.19289); flex-grow: 11.9289;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 83.83%;"><img alt="Publicaciones de Facebook 940 × 788 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5aa6ad64f07aee697773f0b2" src="https://cdn.crello.com/common/ab6e03f2-09ac-4801-89af-205f7eeab760_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=589b14d095a7a863ddcc48d7&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.75); flex-grow: 7.5;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 133.33%;"><img alt="Cartel US 1296 × 1728 pul" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="589b14d095a7a863ddcc48d7" src="https://cdn.crello.com/common/b28b20ff-d0d2-42c2-af89-403614f762f2_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Cartel US</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=589d8fb495a7a863ddcc5915&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Publicaciones de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="589d8fb495a7a863ddcc5915" src="https://cdn.crello.com/downloads/1ef2b9ca-66a2-4d1a-a46f-46080bc10028_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5e4a90f21cc98b350adaeff2&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Portada de comunidad Vkontakte 1590 × 400 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5e4a90f21cc98b350adaeff2" src="https://cdn.crello.com/common/a2ef5fe9-59ac-4611-9aec-983047a19767_450.jpg"
                                                    class="itemImg blurredBackImage___1kk7p"><img alt="Portada de comunidad Vkontakte 1590 × 400 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5e4a90f21cc98b350adaeff2" src="https://cdn.crello.com/common/a2ef5fe9-59ac-4611-9aec-983047a19767_450.jpg"
                                                    class="itemImg centered___2L2r1"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada de comunidad Vkontakte</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b89149a18654940f7a110d3&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/6509b3fc-8fa2-4b31-9732-4ee4bab71457.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b89149a18654940f7a110d3"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/2d6905e9-1303-4e8f-8d14-e5be4eefc789_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=595360d895a7a863ddce1398&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Leaderboard 728 × 90 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="595360d895a7a863ddce1398" src="https://cdn.crello.com/common/adadc51b-8426-4698-8dd2-9ca94d9687be_450.jpg"
                                                    class="itemImg blurredBackImage___1kk7p"><img alt="Leaderboard 728 × 90 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="595360d895a7a863ddce1398" src="https://cdn.crello.com/common/adadc51b-8426-4698-8dd2-9ca94d9687be_450.jpg"
                                                    class="itemImg centered___2L2r1"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Leaderboard</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5888bb0495a7a863ddcc1f40&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.91083); flex-grow: 19.1083;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 52.33%;"><img alt="Anuncio de Facebook 1200 × 628 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5888bb0495a7a863ddcc1f40" src="https://cdn.crello.com/common/48641bc2-bfc6-435f-8e0a-5748d9215e74_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5faab0bea637ee11e306d244&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.91083); flex-grow: 19.1083;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 52.33%;"><img alt="Anuncio de Facebook 1200 × 628 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5faab0bea637ee11e306d244" src="https://cdn.crello.com/downloads/1e2417b6-29fd-4ef1-adf9-94db07b3d4ec_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5da0651eabc8ea6d1c03718c&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Portada de Evento de Facebook 1920 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5da0651eabc8ea6d1c03718c" src="https://cdn.crello.com/common/96dfc5d3-9c78-47eb-9e9b-f1225006891b_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada de Evento de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b62e6e21cc8aa5429e89cff&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/2337c233-9b24-497a-8d5b-89b935c6c873.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b62e6e21cc8aa5429e89cff"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/03aab166-9965-42e1-a3e8-e80cdc860998_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5da0608babc8ea6d1cf93bb9&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.707071); flex-grow: 7.07071;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 141.43%;"><img alt="Cartel 1190 × 1683 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5da0608babc8ea6d1cf93bb9" src="https://cdn.crello.com/downloads/a144bb5a-23cc-4210-a830-ed8ba50636e8_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Cartel</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5e81d48e4b3890eb071f7573&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.29412); flex-grow: 12.9412;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 77.27%;"><img alt="Certificado 792 × 612 pul" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5e81d48e4b3890eb071f7573" src="https://cdn.crello.com/common/032a7b25-828a-43ff-9e9a-bcf638b8df5c_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Certificado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=59b7dba21350e8329300f7ed&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.2); flex-grow: 12;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 83.33%;"><img alt="Rectángulo Grande 336 × 280 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="59b7dba21350e8329300f7ed" src="https://cdn.crello.com/common/278d7616-8990-4997-a0f4-06c2f885c867_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Rectángulo Grande</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5d4147dbcf657b21efcb255b&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/ac1357b0-16a9-4ff9-950b-f3d58a983830.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5d4147dbcf657b21efcb255b"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/f844c58e-41f9-495a-a8f5-e9c9f0cc0120_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia con Video Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5df3aa309fea0cc3741615d4&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.714286); flex-grow: 7.14286;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 140%;"><img alt="Invitación 360 × 504 pul" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5df3aa309fea0cc3741615d4" src="https://cdn.crello.com/common/5ab66a15-59df-438a-99b5-f7144a8d884a_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Invitación</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5888d01295a7a863ddcc26a4&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Banners de Blog 560 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5888d01295a7a863ddcc26a4" src="https://cdn.crello.com/common/e1bfac29-ad81-4fa8-9878-16540e6e7a7a_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Banners de Blog</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5afd87184b568b8eecc00450&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/ed4a1c2c-5c99-4168-911d-b74f56a8b425.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5afd87184b568b8eecc00450"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/5bd11755-5ce4-456b-8426-34fa65970108_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicación Video Cuadrado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b642def1cc8aa54295666d8&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/7fb816f1-49e1-42ef-ab93-c32557dbb6b5.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b642def1cc8aa54295666d8"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/41396cd4-90b0-4243-9b33-fd7c6a5c4ffe_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5d5c00efcf657b21ef867140&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.19289); flex-grow: 11.9289;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 83.83%;"><img alt="Publicaciones de Facebook 940 × 788 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5d5c00efcf657b21ef867140" src="https://cdn.crello.com/common/e39451ea-d545-43bb-8fd5-2e45d3de8c0f_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b76b3d81cc8aa5429d2ca36&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.5); flex-grow: 15;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 66.67%;"><img alt="Certificado de Regalo 432 × 288 pul" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5b76b3d81cc8aa5429d2ca36" src="https://cdn.crello.com/common/71baf36c-6815-47d8-9573-81b2cf468931_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Certificado de Regalo</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=58b0108695a7a863ddcc918f&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Arte del Canal de YouTube 2560 × 1440 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="58b0108695a7a863ddcc918f" src="https://cdn.crello.com/downloads/a6a8c6af-6b8a-4989-bffb-d8e04157548d_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Arte del Canal de YouTube</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5adde6e64b568b8eecb65f10&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Presentación (16:9) 1920 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5adde6e64b568b8eecb65f10" src="https://cdn.crello.com/common/5a3c5b5c-6b8b-48a6-b177-2c4a1282bde8_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Presentación (16:9)</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5947e1cf95a7a863ddcddbc0&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Portada de Facebook 851 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5947e1cf95a7a863ddcddbc0" src="https://cdn.crello.com/downloads/cc32cf4f-953d-4d12-98ac-7690204ffb0e_450.jpeg"
                                                    class="itemImg blurredBackImage___1kk7p"><img alt="Portada de Facebook 851 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5947e1cf95a7a863ddcddbc0" src="https://cdn.crello.com/downloads/cc32cf4f-953d-4d12-98ac-7690204ffb0e_450.jpeg"
                                                    class="itemImg centered___2L2r1"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5d67dc90cf657b21ef666707&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.714286); flex-grow: 7.14286;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 140%;"><img alt="Volantes 360 × 504 pul" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5d67dc90cf657b21ef666707" src="https://cdn.crello.com/common/ffd25efc-6e08-4c6f-89d5-476642bb726d_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Volantes</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5a21790fd8141396fe9a2b54&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.19289); flex-grow: 11.9289;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 83.83%;"><img alt="Publicaciones de Facebook 940 × 788 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5a21790fd8141396fe9a2b54" src="https://cdn.crello.com/downloads/2121540c-e850-4c38-9e85-d8f356586aaa_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5fc4a523a637ee11e32e561c&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.91083); flex-grow: 19.1083;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 52.33%;"><img alt="Anuncio de Facebook 1200 × 628 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5fc4a523a637ee11e32e561c" src="https://cdn.crello.com/downloads/0295afcb-8275-4f24-a90b-7435d198aa56_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b7c08fe1cc8aa542961dd80&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/e7c2185b-65c5-4c10-a043-a6143ad3f4ee.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b7c08fe1cc8aa542961dd80"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/db76ccee-dc5d-40b4-a994-5bfd6ade570c_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b8e741818654940f7fcb204&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/76c24d71-824e-4e42-a6d5-cad58a178cef.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b8e741818654940f7fcb204"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/bd9cec0f-8d0e-4746-897a-24cf2d54eae6_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicación Video Cuadrado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b9a52bf18654940f74e6d3b&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.625); flex-grow: 6.25;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 160%;"><img alt="eBook 1600 × 2560 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5b9a52bf18654940f74e6d3b" src="https://cdn.crello.com/common/ce001dd4-c4b5-440f-b4ef-a1a31224fe3f_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">eBook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5bdc66949259f9ba54b88a0d&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.91083); flex-grow: 19.1083;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 52.33%;"><img alt="Anuncio de Facebook 1200 × 628 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5bdc66949259f9ba54b88a0d" src="https://cdn.crello.com/common/118a96f3-063c-4ac9-9dfd-3ec792a7cdc9_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=593011ec95a7a863ddcdbf8b&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Anuncio de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="593011ec95a7a863ddcdbf8b" src="https://cdn.crello.com/downloads/a6edad50-0173-4ac0-9d84-484583f96cc8_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5f880291a637ee11e3e118bb&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Portada de Facebook 851 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5f880291a637ee11e3e118bb" src="https://cdn.crello.com/downloads/206733fc-83ef-443e-9a4d-7ff12c353e0d_450.jpeg"
                                                    class="itemImg blurredBackImage___1kk7p"><img alt="Portada de Facebook 851 × 315 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5f880291a637ee11e3e118bb" src="https://cdn.crello.com/downloads/206733fc-83ef-443e-9a4d-7ff12c353e0d_450.jpeg"
                                                    class="itemImg centered___2L2r1"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Portada de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=59bbdd301350e83293011695&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.266667); flex-grow: 2.66667;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 375%;"><img alt="Skyscraper 160 × 600 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="59bbdd301350e83293011695" src="https://cdn.crello.com/common/42e68c3e-40c6-4711-8b0a-30fdc79ec707_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Skyscraper</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b2d07981eb1c99e2a1107bf&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/e501080e-d5e5-420e-95d4-1fc25d9f04ed.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b2d07981eb1c99e2a1107bf"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/c25b742b-e882-43f1-ad02-a452679f31a0_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicación Video Cuadrado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=58ac648695a7a863ddcc7cfb&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Publicación de Twitter 1024 × 512 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="58ac648695a7a863ddcc7cfb" src="https://cdn.crello.com/common/a3fc98b0-bc0f-4694-9414-8fb7ab3e1fff_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicación de Twitter</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=58b5673d95a7a863ddcca462&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.666667); flex-grow: 6.66667;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 150%;"><img alt="Gráficos Tumblr 540 × 810 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="58b5673d95a7a863ddcca462" src="https://cdn.crello.com/downloads/4d1aef5c-4214-4a69-8b7f-60b208e155f7_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Gráficos Tumblr</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5fb7f20aa637ee11e3de6ea6&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.91083); flex-grow: 19.1083;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 52.33%;"><img alt="Anuncio de Facebook 1200 × 628 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5fb7f20aa637ee11e3de6ea6" src="https://cdn.crello.com/downloads/95399338-ab87-4aca-b80f-8adcce9b80a6_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5da71a45abc8ea6d1c8d183a&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Logotipo 500 × 500 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5da71a45abc8ea6d1c8d183a" src="https://cdn.crello.com/common/5bebe0ca-046d-44db-83be-f075870ce8f5_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Logotipo</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=58b4325595a7a863ddcc9b57&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.19289); flex-grow: 11.9289;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 83.83%;"><img alt="Publicaciones de Facebook 940 × 788 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="58b4325595a7a863ddcc9b57" src="https://cdn.crello.com/downloads/c6e5ea87-9ee5-4603-b319-25fe79d02c68_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=589b246895a7a863ddcc49e5&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.19289); flex-grow: 11.9289;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 83.83%;"><img alt="Publicaciones de Facebook 940 × 788 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="589b246895a7a863ddcc49e5" src="https://cdn.crello.com/common/887f558f-9a45-4e7f-9725-8064e769f037_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5a217a79d8141396fe9a2cb1&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.19289); flex-grow: 11.9289;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 83.83%;"><img alt="Publicaciones de Facebook 940 × 788 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5a217a79d8141396fe9a2cb1" src="https://cdn.crello.com/downloads/0084938e-df96-4384-bd78-b1d140d57f0e_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Publicaciones de Facebook</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5ace10fd4b568b8eec53f1af&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Anuncio de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5ace10fd4b568b8eec53f1af" src="https://cdn.crello.com/common/4e981af0-bee5-48e4-81fe-107c6e02e96f_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5a7988298c32ec6f8bbbb569&amp;keyword=Blue" style="width: calc(var(--row-height) * 2); flex-grow: 20;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 50%;"><img alt="Anuncio de Twitter 1600 × 400 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5a7988298c32ec6f8bbbb569" src="https://cdn.crello.com/common/7dc8b0d0-b702-456f-9966-cad1c38e232f_450.jpg"
                                                    class="itemImg blurredBackImage___1kk7p"><img alt="Anuncio de Twitter 1600 × 400 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5a7988298c32ec6f8bbbb569" src="https://cdn.crello.com/common/7dc8b0d0-b702-456f-9966-cad1c38e232f_450.jpg"
                                                    class="itemImg centered___2L2r1"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Twitter</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5f97cda3a637ee11e32491f6&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;"><img alt="Mapa mental 1280 × 720 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5f97cda3a637ee11e32491f6" src="https://cdn.crello.com/common/09b4b582-1595-447d-9216-2c7d2e3932ca_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Mapa mental</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=589d7ba195a7a863ddcc5531&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Anuncio de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="589d7ba195a7a863ddcc5531" src="https://cdn.crello.com/common/5bf7c634-eee6-43d9-8f4d-f6856315d19c_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5e7b60434b3890eb07ced86c&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.5625); flex-grow: 5.625;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 177.78%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/4cafbb3e-e19d-4a15-a9ac-1c1175ac6eba.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5e7b60434b3890eb07ced86c"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/ab3f559c-6c3b-4b1d-9f81-5ed7f122059c_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Historia con Video Instagram</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=593112d195a7a863ddcdc592&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.2); flex-grow: 12;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 83.33%;"><img alt="Rectángulo Grande 336 × 280 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="593112d195a7a863ddcdc592" src="https://cdn.crello.com/common/181df4a0-92d8-4471-9fe0-752b0c81704c_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Rectángulo Grande</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5b7e9bb61cc8aa54296d7f0f&amp;keyword=Blue" style="width: calc(var(--row-height) * 1.77778); flex-grow: 17.7778;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 56.25%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/2e715d43-64e7-4bf8-9b10-a53bb8a2f36e.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5b7e9bb61cc8aa54296d7f0f"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/43579a2b-83f2-483d-a3bb-6fe2d478abfb_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Video Full HD</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5dfe17149fea0cc37483107f&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;">
                                                <div class="itemImg">
                                                    <div class="wrapper___2sLIs"><video src="https://cdn.crello.com/video-convert/02566543-a194-47c6-a2d6-de6e05f826d8.mp4" loop="" playsinline="" preload="none" class="video___3_MUj videoItem hideVideo___3vTff" data-categ="homeDesingns"
                                                            data-value="5dfe17149fea0cc37483107f"></video><img crossorigin="anonymous" src="https://cdn.crello.com/common/1bc67189-9187-47d9-9831-b72370cea8d0_450.jpg" class="poster videoItem fullWidthPoster"
                                                            loading="lazy"></div>
                                                </div>
                                            </div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Logotipo Animado</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5f041d7e499b85dcc7aeffa2&amp;keyword=Blue" style="width: calc(var(--row-height) * 0.707491); flex-grow: 7.07491;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 141.34%;"><img alt="Planificador de horarios 595 × 841 сm" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5f041d7e499b85dcc7aeffa2" src="https://cdn.crello.com/downloads/13da5518-daa4-4a8d-bf84-a3239b0ec6f0_450.jpeg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Planificador de horarios</div>
                                            </div>
                                        </a>
                                        <a target="_blank" class="captionWrapper item bottomIndentSmall" href="/mx/artboard/?template=5a3d1bc68c32ec6f8b3d015c&amp;keyword=Blue" style="width: calc(var(--row-height) * 1); flex-grow: 10;">
                                            <div class="preview imgWrapper imgWrapper_" style="padding-bottom: 100%;"><img alt="Anuncio de Instagram 1080 × 1080 px" crossorigin="anonymous" loading="lazy" data-categ="homeDesingns" data-value="5a3d1bc68c32ec6f8b3d015c" src="https://cdn.crello.com/common/17ddcaf2-92fb-4e9d-95c6-c3194bd98de7_450.jpg"
                                                    class="itemImg"></div>
                                            <div class="caption proxima-semibold___1HNzk proxima-s___29loE noSubTitle">
                                                <div class="title___3aJ-x">Anuncio de Instagram</div>
                                            </div>
                                        </a> -->
                                    </div>
                                </div>
                            </div>
                            <div class="containerBottom">
                                <div class="pagination bottom___2OkNp">
                                    <!-- <a class="bhdLno iISRbV nextPageButton___rOiwa" href="{{ route('user.search',['page' => ($page+1), 'country' => $country, 'searchQuery' => $search_query]) }}">
                                        <div class="sc-hKgILt chrFRV">Página siguiente</div>
                                    </a> -->
                                    <div class="paginationWrapper"><span class="typography-body-m paginationRange">{{ $from_document }}-{{ $to_document }} de {{ $total_documents }}</span>
                                        <div class="paginationWrapper">
                                            <a class="bhdLno lhRPKu button___33J2d">
                                                <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 16 16" width="16" height="16" direction="left" class="sc-fubCfw ecgval"><path d="M14.463 4.11761C14.5381 4.04234 14.6403 4 14.747 4C14.8536 4 14.9558 4.04234 15.0309 4.11761L15.8788 4.96052C15.9561 5.03267 16 5.13341 16 5.23884C16 5.34427 15.9561 5.44501 15.8788 5.51716L8.52792 12.8251C8.41552 12.9369 8.26304 12.9999 8.10398 13H7.89602C7.73696 12.9999 7.58448 12.9369 7.47208 12.8251L0.121197 5.51716C0.0438665 5.44501 0 5.34427 0 5.23884C0 5.13341 0.0438665 5.03267 0.121197 4.96052L0.969068 4.11761C1.04416 4.04234 1.14639 4 1.25302 4C1.35966 4 1.46189 4.04234 1.53698 4.11761L8 10.5428L14.463 4.11761Z"></path></svg></div>
                                            </a>
                                            <div class="sc-dmlrTW guKkvw">
                                                <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('user.search',['country' => $country]) }}">
                                                    @csrf
                                                    <input type="text" class="sc-kfzAmx sc-fKFyDc fTLfYv ikXwLi pageInput___1mj0B" name="page" value="{{ $page }}">
                                                </form>
                                            </div>
                                            <a class="bhdLno lhRPKu button___33J2d" href="{{ route('user.search',['page' => ($page+1), 'country' => $country, 'searchQuery' => $search_query]) }}">
                                                <div class="sc-hKgILt chrFRV"><svg viewBox="0 0 16 16" width="16" height="16" direction="right" class="sc-fubCfw cnhfsE"><path d="M14.463 4.11761C14.5381 4.04234 14.6403 4 14.747 4C14.8536 4 14.9558 4.04234 15.0309 4.11761L15.8788 4.96052C15.9561 5.03267 16 5.13341 16 5.23884C16 5.34427 15.9561 5.44501 15.8788 5.51716L8.52792 12.8251C8.41552 12.9369 8.26304 12.9999 8.10398 13H7.89602C7.73696 12.9999 7.58448 12.9369 7.47208 12.8251L0.121197 5.51716C0.0438665 5.44501 0 5.34427 0 5.23884C0 5.13341 0.0438665 5.03267 0.121197 4.96052L0.969068 4.11761C1.04416 4.04234 1.14639 4 1.25302 4C1.35966 4 1.46189 4.04234 1.53698 4.11761L8 10.5428L14.463 4.11761Z"></path></svg></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div></div>
        </div>
    </div>
    <!-- <meta name="google-site-verification" content=""> -->
    <!-- <div style="width:0px; height:0px; display:none; visibility:hidden;" id="batBeacon183254530036"><img style="width:0px; height:0px; display:none; visibility:hidden;" id="batBeacon966510314538" width="0" height="0" alt="" src="https://bat.bing.com/action/0?ti=56305916&amp;Ver=2&amp;mid=7e47ba01-f86d-43df-bc0c-a54ea92a35bb&amp;sid=95ffe9405a8d11eb89bc47deb50efd0b&amp;vid=f245ec70512611eb90d0a310eac65bd9&amp;vids=0&amp;pi=1200101525&amp;lg=es&amp;sw=1920&amp;sh=1080&amp;sc=24&amp;tl=Crello&amp;p=https%3A%2F%2Fcrello.com%2Fmx%2Fhome%2F&amp;r=&amp;evt=pageLoad&amp;msclkid=N&amp;sv=1&amp;rn=102539"></div> -->

@endsection