@extends('layouts.frontend')
    
    @section('title', $template->title.' | Template | Designer Online | WAYAK')
    @section('meta')
        <meta property="og:url"           content="{{  URL::current() }}" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="{{ $template->title }} | Template | Design Online | WAYAK" />
        <meta property="og:description"   content="Your description" />
        <meta property="og:image"         content="{{ asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] ) }}" />
    @endsection
    
    @section('css')
        <style>body{font-size:16px;}</style>
        <style>
            /*! CSS Used from: Embedded */
            body{font-size:16px;}
            /*! CSS Used from: Embedded */
            body{font-size:16px;}
            @media all{
            body{margin:0;}
            nav{display:block;}
            a{background-color:transparent;-webkit-text-decoration-skip:objects;}
            a:active,a:hover{outline-width:0;}
            strong{font-weight:inherit;}
            strong{font-weight:bolder;}
            h1{font-size:2em;margin:0.67em 0;}
            sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline;}
            sup{top:-0.5em;}
            img{border-style:none;}
            button,input{font:inherit;margin:0;}
            button,input{overflow:visible;}
            button{text-transform:none;}
            button,[type="submit"]{-webkit-appearance:button;}
            button::-moz-focus-inner,[type="submit"]::-moz-focus-inner{border-style:none;padding:0;}
            button:-moz-focusring,[type="submit"]:-moz-focusring{outline:1px dotted ButtonText;}
            ::-webkit-input-placeholder{color:inherit;opacity:0.54;}
            *,*:before,*:after{-webkit-box-sizing:border-box;box-sizing:border-box;}
            @media (max-width: 1023px){
            body{height:100%;}
            }
            h1,h2,p{margin:0;}
            iframe{border:0;}
            [tabindex="-1"]:focus{outline:none!important;}
            .h-text-align-center{text-align:center;}
            .h-text-align-right{text-align:right;}
            .h-text-truncate{overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}
            .h-m0{margin:0px!important;}
            @media (max-width: 568px){
            .is-hidden-phone{display:none!important;}
            }
            @media (min-width: 569px){
            .is-hidden-tablet-and-above{display:none!important;}
            }
            .is-visually-hidden{border:0;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;}
            .is-hidden{display:none!important;}
            .t-body{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;font-size:16px;font-weight:400;line-height:1.5;margin-bottom:16px;padding:0;}
            .t-body.-size-s{font-size:12px;}
            .t-body{color:#666666;}
            .t-heading{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;font-weight:700;line-height:1.2;margin-bottom:16px;padding:0;}
            .t-heading.-size-l{font-size:28px;}
            .t-heading.-size-m{font-size:24px;}
            .t-heading.-size-xs{font-size:18px;}
            .t-heading{color:#454545;}
            .t-heading.-color-light{color:white;}
            .t-heading.-color-inherit{color:inherit;}
            .t-heading.-margin-none{margin:0;}
            .e-alert-box__dismiss-icon{display:block;color:#bababa;font-size:10px;line-height:20px;text-decoration:none;}
            .e-alert-box__dismiss-icon:hover{color:gray;}
            .e-btn,.e-btn--3d{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;-webkit-box-sizing:border-box;box-sizing:border-box;display:inline-block;margin:0;border:none;border-radius:4px;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;text-align:center;text-decoration:none;cursor:pointer;}
            .e-btn:hover,.e-btn--3d:hover,.e-btn:focus,.e-btn--3d:focus{text-decoration:none;outline:none;}
            .e-btn,.e-btn--3d{background-color:gray;color:white;}
            .e-btn:hover,.e-btn--3d:hover,.e-btn:focus,.e-btn--3d:focus,.e-btn:active,.e-btn--3d:active{background-color:#787878;}
            .e-btn.-color-primary,.-color-primary.e-btn--3d{background-color:#f73859;}
            .e-btn.-color-primary:hover,.-color-primary.e-btn--3d:hover,.e-btn.-color-primary:focus,.-color-primary.e-btn--3d:focus,.e-btn.-color-primary:active,.-color-primary.e-btn--3d:active{background-color:#d62040;}
            .e-btn.-width-full,.-width-full.e-btn--3d{-webkit-box-sizing:border-box;box-sizing:border-box;width:100%;}
            .e-btn,.e-btn--3d{font-size:14px;padding:5px 20px;line-height:1.5;}
            .e-btn.-size-m,.-size-m.e-btn--3d{font-size:16px;padding:10px 20px;}
            .e-btn--3d{position:relative;}
            .e-btn--3d:active{top:1px;-webkit-box-shadow:0 1px 0 #545454;box-shadow:0 1px 0 #545454;}
            .e-btn--3d.-color-primary{position:relative;}
            .e-btn--3d.-color-primary:active{top:1px;-webkit-box-shadow:0 1px 0 #6f9a37;box-shadow:0 1px 0 #6f9a37;}
            .e-modal{position:relative;margin:20px auto;}
            .e-modal{max-width:600px;}
            .e-modal__section{overflow:auto;margin-top:-1px;}
            .e-modal__section{background-color:white;border:1px solid #dedede;}
            .e-modal__section{padding:16px;}
            .box {
                background-color: #fafafa;
                color: #666666;
                margin-bottom: 20px;
                padding: 5px;
                border-radius: 4px;
                text-align: center;
            }
            .box.-radius-all{border-radius:4px;}
            .breadcrumbs{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;margin:0 0 8px 0;}
            .breadcrumbs a{position:relative;color:#666666;font-size:12px;line-height:1;text-decoration:none;}
            .breadcrumbs a:hover{text-decoration:none;color:#454545;}
            .breadcrumbs a:after{font-family:marketplace-glyphs;font-style:normal;font-weight:normal;speak:none;text-align:center;width:1em;content:">";display:inline-block;font-size:9px;color:#bababa;margin:0 4px 0 8px;cursor:default;}
            .breadcrumbs a:last-of-type:after{display:none;}
            .canvas{position:relative;}
            .canvas__header{position:relative;z-index:2;}
            .canvas__body{position:relative;z-index:1;}
            .content-main{min-height:250px;height:100%;padding:16px 0 32px;position:relative;}
            @media (min-width: 1024px){
            .content-main{min-height:540px;}
            }
            .context-header{background:#fff;padding-top:8px;color:#454545;}
            .grid-container{max-width:1004px;max-width:64rem;padding-left:10px;padding-left:0.625rem;padding-right:10px;padding-right:0.625rem;margin-left:auto;margin-right:auto;}
            .grid-container:after{content:"";display:table;clear:both;}
            @media (min-width: 1024px){
            .sidebar-l{float:left;margin-right:18px;width:350px;}
            }
            @media (min-width: 1024px){
            .sidebar-right{float:right;margin-left:18px;margin-right:0;}
            }
            @media (min-width: 1024px){
            .content-s{float:left;width:616px;}
            }
            .magnifier{display:none;}
            .media{display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-flow:row wrap;-ms-flex-flow:row wrap;flex-flow:row wrap;}
            @media (min-width: 569px){
            .media{-webkit-flex-flow:column;-ms-flex-flow:column;flex-flow:column;}
            }
            .media>div:first-child{margin-right:1em;}
            .page{height:100%;position:relative;}
            @media (min-width: 1024px){
            .page{min-width:1024px;}
            }
            .page__canvas{-webkit-box-shadow:0 0 15px -1px rgba(0,0,0,0.4);box-shadow:0 0 15px -1px rgba(0,0,0,0.4);position:relative;z-index:2;min-height:100%;}
            @media (min-width: 1024px){
            .page__canvas{-webkit-box-shadow:none;box-shadow:none;}
            }
            .e-icon:before {
                /* font-family: marketplace-glyphs; */
                font-style: normal;
                font-weight: normal;
                speak: none;
                text-align: center;
                width: 12px;
                height: 12px;
                display: inline-block;
            }
            .e-icon.-icon-cancel:before{content:"";}
            .e-icon.-icon-chevron-down:before{content:"";}
            .e-icon.-icon-facebook:before{
                content: url(https://static.xx.fbcdn.net/rsrc.php/v3/yr/r/zSKZHMh8mXU.png);
            }
            .e-icon.-icon-pinterest:before{
                content: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiPjwvcGF0aD48cGF0aCBkPSJNMTQuNzMzLDEuNjg2IEM3LjUxNiwxLjY4NiAxLjY2NSw3LjQ5NSAxLjY2NSwxNC42NjIgQzEuNjY1LDIwLjE1OSA1LjEwOSwyNC44NTQgOS45NywyNi43NDQgQzkuODU2LDI1LjcxOCA5Ljc1MywyNC4xNDMgMTAuMDE2LDIzLjAyMiBDMTAuMjUzLDIyLjAxIDExLjU0OCwxNi41NzIgMTEuNTQ4LDE2LjU3MiBDMTEuNTQ4LDE2LjU3MiAxMS4xNTcsMTUuNzk1IDExLjE1NywxNC42NDYgQzExLjE1NywxMi44NDIgMTIuMjExLDExLjQ5NSAxMy41MjIsMTEuNDk1IEMxNC42MzcsMTEuNDk1IDE1LjE3NSwxMi4zMjYgMTUuMTc1LDEzLjMyMyBDMTUuMTc1LDE0LjQzNiAxNC40NjIsMTYuMSAxNC4wOTMsMTcuNjQzIEMxMy43ODUsMTguOTM1IDE0Ljc0NSwxOS45ODggMTYuMDI4LDE5Ljk4OCBDMTguMzUxLDE5Ljk4OCAyMC4xMzYsMTcuNTU2IDIwLjEzNiwxNC4wNDYgQzIwLjEzNiwxMC45MzkgMTcuODg4LDguNzY3IDE0LjY3OCw4Ljc2NyBDMTAuOTU5LDguNzY3IDguNzc3LDExLjUzNiA4Ljc3NywxNC4zOTggQzguNzc3LDE1LjUxMyA5LjIxLDE2LjcwOSA5Ljc0OSwxNy4zNTkgQzkuODU2LDE3LjQ4OCA5Ljg3MiwxNy42IDkuODQsMTcuNzMxIEM5Ljc0MSwxOC4xNDEgOS41MiwxOS4wMjMgOS40NzcsMTkuMjAzIEM5LjQyLDE5LjQ0IDkuMjg4LDE5LjQ5MSA5LjA0LDE5LjM3NiBDNy40MDgsMTguNjIyIDYuMzg3LDE2LjI1MiA2LjM4NywxNC4zNDkgQzYuMzg3LDEwLjI1NiA5LjM4Myw2LjQ5NyAxNS4wMjIsNi40OTcgQzE5LjU1NSw2LjQ5NyAyMy4wNzgsOS43MDUgMjMuMDc4LDEzLjk5MSBDMjMuMDc4LDE4LjQ2MyAyMC4yMzksMjIuMDYyIDE2LjI5NywyMi4wNjIgQzE0Ljk3MywyMi4wNjIgMTMuNzI4LDIxLjM3OSAxMy4zMDIsMjAuNTcyIEMxMy4zMDIsMjAuNTcyIDEyLjY0NywyMy4wNSAxMi40ODgsMjMuNjU3IEMxMi4xOTMsMjQuNzg0IDExLjM5NiwyNi4xOTYgMTAuODYzLDI3LjA1OCBDMTIuMDg2LDI3LjQzNCAxMy4zODYsMjcuNjM3IDE0LjczMywyNy42MzcgQzIxLjk1LDI3LjYzNyAyNy44MDEsMjEuODI4IDI3LjgwMSwxNC42NjIgQzI3LjgwMSw3LjQ5NSAyMS45NSwxLjY4NiAxNC43MzMsMS42ODYiIGZpbGw9IiMxMTEiPjwvcGF0aD48L2c+PC9zdmc+);
            }
            .e-icon.-icon-twitter:before{ 
                content: url(data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2072%2072%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h72v72H0z%22%2F%3E%3Cpath%20class%3D%22icon%22%20fill%3D%22%23fff%22%20d%3D%22M68.812%2015.14c-2.348%201.04-4.87%201.744-7.52%202.06%202.704-1.62%204.78-4.186%205.757-7.243-2.53%201.5-5.33%202.592-8.314%203.176C56.35%2010.59%2052.948%209%2049.182%209c-7.23%200-13.092%205.86-13.092%2013.093%200%201.026.118%202.02.338%202.98C25.543%2024.527%2015.9%2019.318%209.44%2011.396c-1.125%201.936-1.77%204.184-1.77%206.58%200%204.543%202.312%208.552%205.824%2010.9-2.146-.07-4.165-.658-5.93-1.64-.002.056-.002.11-.002.163%200%206.345%204.513%2011.638%2010.504%2012.84-1.1.298-2.256.457-3.45.457-.845%200-1.666-.078-2.464-.23%201.667%205.2%206.5%208.985%2012.23%209.09-4.482%203.51-10.13%205.605-16.26%205.605-1.055%200-2.096-.06-3.122-.184%205.794%203.717%2012.676%205.882%2020.067%205.882%2024.083%200%2037.25-19.95%2037.25-37.25%200-.565-.013-1.133-.038-1.693%202.558-1.847%204.778-4.15%206.532-6.774z%22%2F%3E%3C%2Fsvg%3E) ;
            }
            .e-icon.-line-height-small{line-height:0.9;}
            .e-icon.-size-medium{font-size:20px;}
            .e-icon.-rotate-180:before{-webkit-transform:rotate(180deg);transform:rotate(180deg);}
            .e-icon__alt{border:0;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;}
            .btn, button, [type=submit] {
                            -webkit-font-smoothing: antialiased;
                            -moz-osx-font-smoothing: grayscale;
                            -webkit-box-sizing: border-box;
                            box-sizing: border-box;
                            background-color: #d8d8d8;
                            border: none;
                            border-radius: 4px;
                            color: #5a5a5a;
                            cursor: pointer;
                            display: inline-block;
                            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                            font-size: 12px;
                            margin: 0;
                            padding: 5px 20px;
                            text-align: center;
                            text-decoration: none;
                        }
            .btn:hover,button:hover,[type=submit]:hover,.btn:focus,button:focus,[type=submit]:focus{background-color:#0084B4;text-decoration:none;outline:none;}
            .btn:active,button:active,[type=submit]:active{background-color:#00719b;}
            .btn--label:hover{background:gray;cursor:default;}
            .btn-group{display:inline-block;font-size:0;}
            .btn--group-item{border-radius:0;padding:5px 10px;margin-right:1px;}
            .btn--group-item:first-child{border-radius:4px 0 0 4px;}
            .btn--group-item:last-child{border-radius:0 4px 4px 0;margin-right:0;}
            a.btn--group-item>img{
                width: 13px;
            }
            a.btn--group-item.tw{
                background-color:#1b95e0;
            }
            a.btn--group-item.pi{
                background-color:#111;
            }
            a.btn--group-item.fb{
                background-color:#1877f2;
            }
            button::-moz-focus-inner{padding:0;border:0;}
            }
            @media all{
            a{color:#0084B4;text-decoration:none;}
            a:hover,a:focus{text-decoration:underline;}
            h1,h2{padding:10px 0px 20px 0px;color:#545454;font-weight:inherit;}
            h1{font-size:37px;line-height:44px;padding:12px 0px 10px 0px;}
            h2{font-size:27px;line-height:35px;}
            .sidebar-l strong{font-weight:bold;}
            p{padding:10px 0px;}
            strong{font-weight:bold;}
            ::-webkit-input-placeholder{color:#bbb;}
            input:-moz-placeholder{color:#bbb;}
            .faux-player{cursor:pointer;height:100%;position:relative;width:100%;}
            .item-preview{min-height:245px;padding:12px;position:relative;text-align:center;}
            .item-preview img{display:block;max-width:100%;margin:0 auto;}
            @media (max-width: 1023px){
            .item-preview img{height:auto;}
            }
            .item-preview__preview-buttons--social{display:inline-block;}
            @media (min-width: 1024px){
            .item-preview__preview-buttons--social{padding-top:12px;}
            }
            /* .item-preview__preview-buttons--social .btn{line-height:1.6;} */
            .item-description{padding:15px 0px 20px 0px;}
            .js-item-togglable-content.has-toggle{max-height:440px;overflow:hidden;position:relative;}
            .js-item-togglable-content.has-toggle:before{content:"";position:absolute;width:100%;height:100%;bottom:35px;z-index:1;background:-webkit-gradient(linear, left top, left bottom, color-stop(50%, rgba(255,255,255,0)), to(#fff));background:-webkit-linear-gradient(top, rgba(255,255,255,0) 50%, #fff 100%);background:linear-gradient(to bottom, rgba(255,255,255,0) 50%, #fff 100%);}
            @media (min-width: 1024px){
            .js-item-togglable-content.has-toggle:not(.condenseItemPageDescription){max-height:none;overflow:visible;margin-bottom:20px;}
            .js-item-togglable-content.has-toggle:not(.condenseItemPageDescription):before{display:none;}
            }
            .item-description-toggle{position:absolute;bottom:0;left:0;right:0;padding-bottom:4px;z-index:1;background:white;}
            @media (min-width: 1024px){
            .item-description-toggle:not(.condenseItemPageDescription){display:none;}
            }
            .item-description-toggle__link{display:block;padding:5px;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;font-size:16px;font-weight:700;text-align:center;}
            .item-description-toggle__link:focus{text-decoration:none;}
            .item-description-toggle__link span:last-child{display:none;}
            .rating-detailed--has-no-ratings{font-size:14px;}
            .rating-detailed--has-no-ratings strong{color:#454545;}
            .rating-detailed--has-no-ratings span{color:#999999;}
            .user-html{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;line-height:1.5;overflow:auto;}
            .user-html p{margin-bottom:20px;padding:0;}
            .user-html p:last-child{margin-bottom:0;}
            .user-html.user-html__with-lazy-load{overflow:visible;}
            .meta-attributes{color:#999999;}
            .meta-attributes tr td{font-size:14px;padding-bottom:15px;vertical-align:top;}
            .meta-attributes tr:last-child td{padding-bottom:0px;}
            .meta-attributes a{color:#0084B4;}
            .meta-attributes a:hover{color:#00719b;}
            .meta-attributes__attr-name{color:#454545;font-weight:bold;padding-right:10px;width:140px;}
            .meta-attributes__attr-tags{display:table-cell;position:relative;padding-right:9px;max-width:185px;overflow:hidden;}
            .meta-attributes__attr-tags:before{content:"";position:absolute;background:-webkit-gradient(linear, left top, right top, from(rgba(250,250,250,0)), color-stop(90%, rgba(250,250,250,0.8)), to(#fafafa));background:-webkit-linear-gradient(left, rgba(250,250,250,0), rgba(250,250,250,0.8) 90%, #fafafa 100%);background:linear-gradient(to right, rgba(250,250,250,0), rgba(250,250,250,0.8) 90%, #fafafa 100%);top:1px;right:0px;width:10%;height:100%;z-index:10;}
            .purchase-form__button{margin-bottom:12px;}
            .purchase-form__button:last-of-type{margin-bottom:4px;}
            .item-header{width:100%;}
            .item-header__top {
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-align-items: flex-start;
                -ms-flex-align: start;
                align-items: flex-start;
                /* margin-bottom: 1em; */
            }
            .item-header__title{-webkit-flex:1 0;-ms-flex:1 0;flex:1 0;}
            .item-header__price{-webkit-flex-shrink:0;-ms-flex-negative:0;flex-shrink:0;margin-left:20px;text-align:right;white-space:nowrap;}
            @media (min-width: 1024px){
            .item-header__price{display:none;}
            }
            .survey-popup{position:fixed;bottom:24px;right:24px;background:white;padding:8px;border-radius:2px;-webkit-box-shadow:0 0 4px 2px whitesmoke;box-shadow:0 0 4px 2px whitesmoke;width:450px;z-index:2000;}
            @media screen and (max-width: 480px){
            .survey-popup{width:auto;bottom:8px;left:8px;right:8px;}
            }
            .survey-popup--section{margin:24px 16px;color:#333333;}
            @media screen and (max-width: 480px){
            .survey-popup--section{margin:16px 8px;}
            }
            .box{background-color:#fafafa;color:#666666;margin-bottom:20px;padding:5px;border-radius:4px;}
            .box:after{content:" ";display:block;clear:both;}
            @media (min-width: 569px){
            .box{padding:15px;}
            }
            .box--no-padding{background-color:#fafafa;color:#666666;margin-bottom:20px;border-radius:4px;}
            .box--no-padding:after{content:" ";display:block;clear:both;}
            .magnifier{color:white;background:#333333;border:1px solid black;-webkit-box-sizing:initial;box-sizing:initial;position:absolute;z-index:9100;display:none;padding:0px 10px 7px;}
            .magnifier .size-limiter{margin-top:10px;background:#565656;}
            .magnifier strong{padding-top:7px;font:16px/20px Helvetica, Arial, sans-serif;color:white;font-weight:bold;display:block;}
            .magnifier .info,.magnifier .footer{color:#686868;font-size:11px;line-height:18px;overflow:hidden;width:100%;}
            .magnifier .author-category{float:left;}
            .magnifier .price{float:right;margin-left:20px;font:40px/40px Helvetica, Arial, sans-serif;font-weight:bold;color:white;}
            .magnifier .price sup{font-size:23px;top:0;vertical-align:10px;}
            .magnifier .footer{display:-webkit-flex;display:-ms-flexbox;display:flex;color:#aeaeae;}
            .magnifier .gst-notice{text-align:right;width:50%;}
            .magnifier .category{width:50%;}
            #landscape-image-magnifier .size-limiter{width:472px;height:240px;overflow:hidden;}
            #landscape-image-magnifier strong{width:472px;}
            #landscape-image-magnifier .footer{width:472px;}
            #video-magnifier.magnifier{display:inline;left:-9999px;top:0;}
            #video-magnifier .size-limiter{width:472px;height:264px;overflow:hidden;}
            #video-magnifier .size-limiter img{width:472px;height:264px;}
            #video-magnifier strong{width:472px;}
            #video-magnifier .footer{width:472px;}
            #portrait-image-magnifier .size-limiter{width:240px;height:472px;overflow:hidden;}
            #portrait-image-magnifier strong{width:240px;}
            #portrait-image-magnifier .footer{width:240px;}
            #square-image-magnifier .size-limiter{width:300px;height:300px;overflow:hidden;margin:10px auto 0px;}
            #square-image-magnifier .size-limiter img{width:300px;height:auto;display:block;}
            #square-image-magnifier strong{width:300px;}
            #square-image-magnifier .footer{width:300px;}
            #smart-image-magnifier .size-limiter{overflow:hidden;position:relative;text-align:center;}
            }

        </style>
        <style>
            ._-pFsfA{position:absolute;clip:rect(1px,1px,1px,1px);height:1px;width:1px;overflow:hidden;white-space:nowrap;}
            [dir] ._-pFsfA{margin:-1px;border:0;padding:0;}
            .fP4ZCw{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;font-smooth:always;}
            .l864gg{word-wrap:break-word;overflow-wrap:break-word;}
            [dir] .l864gg{margin:0;}
            .fFOiLQ{font-size:1.4rem;}
            .fFOiLQ{font-family:Open Sans,-apple-system,BlinkMacSystemFont,Segoe UI,Helvetica,Arial,sans-serif;font-weight:400;line-height:1.6;}
            .YEm5MA{font-weight:600;}
            [dir=ltr] ._5Ob-nQ{text-align:left;}
            .I-IZwQ{color:#0e1318;}
            .DM08FA{height:14px;list-style:none;display:flex; padding: 0;}
            [dir] .DM08FA{padding:0;margin:0;}
            .Gu5L1Q{box-sizing:content-box;height:14px;width:100%;max-width:72px;overflow:hidden;}
            [dir] .Gu5L1Q{border-top:1px solid rgba(64,87,109,.07);border-bottom:1px solid rgba(64,87,109,.07);}
            [dir=ltr] .Gu5L1Q:first-of-type{border-left:1px solid rgba(64,87,109,.07);border-top-left-radius:14px;border-bottom-left-radius:14px;}
            [dir=ltr] .Gu5L1Q:last-of-type{border-right:1px solid rgba(64,87,109,.07);border-top-right-radius:14px;border-bottom-right-radius:14px;}
            ._2ngLMQ{width:100%;}
            [dir=ltr] ._2ngLMQ{padding-left:16px;}
        </style>
        <style>
            /*! CSS Used from: Embedded */
            *{box-sizing:border-box;}
            a{color:inherit;text-decoration:none;background-color:transparent;outline:none;cursor:pointer;-webkit-text-decoration-skip:objects;text-decoration-skip:objects;}
            a:active,a:hover{outline-width:0;}
            a{font-family:Geometria;}
            .link___3OiRu{position:relative;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;height:100%;padding:4px;color:var(--header-nav-link-color);transition:color .3s;}
            .link___3OiRu:hover .linkLabel___ot3V1{background:var(--header-nav-ling-color-hover);}
            .link___3OiRu.active___2JazE{color:var(--header-nav-link-color-active);}
            .link___3OiRu.active___2JazE:before{position:absolute;bottom:0;left:0;width:100%;height:3px;background-color:var(--header-nav-link-color-active);border-radius:3px 3px 0 0;content:"";}
            .linkLabel___ot3V1{height:100%;padding:18px 28px;border-radius:8px;transition:background .3s, border-radius .3s;}
            .headerWrapper___3eklQ{position:relative;display:-ms-flexbox;display:flex;-ms-flex-negative:0;flex-shrink:0;-ms-flex-pack:justify;justify-content:space-between;width:100%;height:64px;padding:0 24px;background-color:white;z-index:1;}
            .flex___2XWAk{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;}
            .logoWrapper___g2Okg{margin-right:8px;}
            .logoIconWrapper___2aVXl,.logoWrapper___g2Okg{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;}
            .logoIconWrapper___2aVXl{height:100%;}
            .typography-subheading-m{font-family:ProximaSemiBold;font-size:14px;line-height:20px;}
            .typography-body-m{font-family:ProximaRegular;font-size:14px;line-height:20px;}
            /*! CSS Used from: Embedded */
            *{box-sizing:border-box;}
            a{color:inherit;text-decoration:none;background-color:transparent;outline:none;cursor:pointer;-webkit-text-decoration-skip:objects;text-decoration-skip:objects;}
            a:active,a:hover{outline-width:0;}
            a{font-family:Geometria;}
            .link___3OiRu{position:relative;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;height:100%;padding:4px;color:var(--header-nav-link-color);transition:color .3s;}
            .link___3OiRu:hover .linkLabel___ot3V1{background:var(--header-nav-ling-color-hover);}
            .link___3OiRu.active___2JazE{border-bottom:4px solid;color:black;}
            .link___3OiRu.active___2JazE:before{position:absolute;bottom:0;left:0;width:100%;height:3px;background-color:var(--header-nav-link-color-active);border-radius:3px 3px 0 0;content:"";}
            .linkLabel___ot3V1{height:100%;padding:18px 28px;border-radius:8px;transition:background .3s,border-radius .3s;}
            .headerWrapper___3eklQ{position:relative;display:-ms-flexbox;display:flex;-ms-flex-negative:0;flex-shrink:0;-ms-flex-pack:justify;justify-content:space-between;width:100%;height:64px;padding:0 24px;background-color:var(--header-background-color);}
            /* .headerShadow___2L53V{position:absolute;right:0;bottom:0;left:0;z-index:3;height:6px;overflow:hidden;transform:translateY(100%);opacity:0;transition:opacity .2s ease-in-out;pointer-events:none;} */
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
            a{-webkit-text-decoration-skip:objects;background-color:transparent;color:#fff;color:inherit;cursor:pointer;cursor:pointer;outline:none;text-decoration:none;text-decoration:none;text-decoration-skip:objects;}
            a{font-family:'PT Sans Caption';}
            a:active,a:hover{outline-width:0;}
            *{box-sizing:border-box;}
            a{-webkit-text-decoration-skip:objects;background-color:transparent;color:inherit;cursor:pointer;outline:none;text-decoration:none;text-decoration-skip:objects;}
            a{font-family:'PT Sans Caption';}
            a:active,a:hover{outline-width:0;}
            a{background-color:transparent;background-color:transparent;}
            a:active,a:hover{outline:0;outline:0;}
            a{background-color:transparent;background-color:transparent;background-color:transparent;background-color:transparent;color:#fff;color:#fff;cursor:pointer;cursor:pointer;text-decoration:none;text-decoration:none;}
            a:active,a:hover{outline:0;outline:0;outline:0;outline:0;}
            a{color:#fff;cursor:pointer;text-decoration:none;}
            *{box-sizing:border-box;}
            a{color:inherit;text-decoration:none;background-color:transparent;outline:none;cursor:pointer;-webkit-text-decoration-skip:objects;text-decoration-skip:objects;}
            a:active,a:hover{outline-width:0;}
            a{font-family:Geometria;}
            .link___3OiRu{position:relative;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;height:100%;padding:4px;color:var(--header-nav-link-color);transition:color .3s;}
            .link___3OiRu:hover .linkLabel___ot3V1{background:var(--header-nav-ling-color-hover);}
            .link___3OiRu.active___2JazE{border-bottom:4px solid;color:black;}
            .link___3OiRu.active___2JazE:before{position:absolute;bottom:0;left:0;width:100%;height:3px;background-color:var(--header-nav-link-color-active);border-radius:3px 3px 0 0;content:"";}
            .linkLabel___ot3V1{height:100%;padding:18px 28px;border-radius:8px;transition:background .3s,border-radius .3s;}
            .headerWrapper___3eklQ{position:relative;display:-ms-flexbox;display:flex;-ms-flex-negative:0;flex-shrink:0;-ms-flex-pack:justify;justify-content:space-between;width:100%;height:64px;padding:0 24px;background-color:var(--header-background-color);}
            .headerShadow___2L53V {
                position: absolute;
                right: 0;
                bottom: 0;
                left: 0;
                /* z-index: 3; */
                height: 6px;
                overflow: hidden;
                transform: translateY(100%);
                /* opacity: 0; */
                transition: opacity .2s ease-in-out;
                pointer-events: none;
                box-shadow: 0 1px 8px rgb(0 0 0 / 10%);
            }
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
            a{-webkit-text-decoration-skip:objects;background-color:transparent;color:#fff;color:inherit;cursor:pointer;cursor:pointer;outline:none;text-decoration:none;text-decoration:none;text-decoration-skip:objects;}
            a{font-family:'PT Sans Caption';}
            a:active,a:hover{outline-width:0;}
            *{box-sizing:border-box;}
            a{-webkit-text-decoration-skip:objects;background-color:transparent;color:inherit;cursor:pointer;outline:none;text-decoration:none;text-decoration-skip:objects;}
            a{font-family:'PT Sans Caption';}
            a:active,a:hover{outline-width:0;}
            a{background-color:transparent;background-color:transparent;}
            a:active,a:hover{outline:0;outline:0;}
            a{background-color:transparent;background-color:transparent;background-color:transparent;background-color:transparent;color:#fff;color:#fff;cursor:pointer;cursor:pointer;text-decoration:none;text-decoration:none;}
            a:active,a:hover{outline:0;outline:0;outline:0;outline:0;}
            a{color:#fff;cursor:pointer;text-decoration:none;}
            /*! CSS Used fontfaces */
        </style>
    @endsection

@section('content')
        <div class="page" itemscope itemtype="https://schema.org/Product">
            <div class="page__canvas">
                <div class="canvas">
                    <div class="canvas__header">
                       
                    </div>
                    <div class="js-canvas__body canvas__body">
                        <div class="grid-container">
                        </div>
                        <div class="context-header ">
                            <div class="grid-container ">
                                <nav class="breadcrumbs h-text-truncate ">
                                    <a href="{{ url('') }}">Home</a>
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        <a class="js-breadcrumb-category" 
                                            href="{{ $breadcrumb->url }}">{{ $breadcrumb->name }}</a>
                                    @endforeach
                                    
                                </nav>
                                <div class="item-header" data-view="itemHeader">
                                    <div class="item-header__top">
                                        <div class="item-header__title">
                                            <h1 class="t-heading -color-inherit -size-l h-m0 is-hidden-phone"
                                                itemprop="name">
                                                {{ $template->title }}
                                            </h1>
                                            <h1 class="t-heading -color-inherit -size-xs h-m0 is-hidden-tablet-and-above">
                                                {{ $template->title }}
                                            </h1>
                                        </div>
                                        <div class="item-header__price">
                                            <a class="js-item-header__cart-button e-btn--3d -color-primary -size-m" 
                                                rel="nofollow" title="Add to Cart" 
                                                href="{{ 
                                                route( 'admin.edit.template',[
                                                'language_code' => $language_code,
                                                'template_key' => $template->_id
                                                ] )
                                            }}">
                                                <!-- <span class="item-header__cart-button-icon">
                                                    <i class="e-icon -icon-cart -margin-right"></i>
                                                </span> -->
                                                <span class="t-heading -size-m -color-light -margin-none">
                                                    Use this Template
                                                </span>
                                            </a>      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-main" id="content">
                            <div class="grid-container">
                                <div class="content-s js-adi-data-wrapper adi-variant-2">
                                    <div class="box--no-padding">
                                        <div class="item-preview ">
                                            <img alt="{{ $template->title }}"
                                            itemprop="image"
                                            src="{{ asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] ) }}">
                                            <div class="item-preview__actions">
                                                <div class="item-preview__preview-buttons--social" data-view="socialButtons">
                                                    <div class="btn-group">
                                                        <!-- <div class="btn btn--label btn--group-item">Share</div> -->
                                                        <a class="btn btn--group-item fb" data-social-network="Facebook" data-social-network-link="" href="https://www.facebook.com/sharer/sharer.php?display=popup&u={{ urlencode(URL::current().'?utm_source=sharepi') }}">
                                                            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yr/r/zSKZHMh8mXU.png">
                                                        </a>
                                                        <a class="btn btn--group-item tw" data-social-network="Twitter" data-social-network-link="" href="https://twitter.com/intent/tweet?text={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}&url={{ urlencode(URL::current().'?utm_source=sharetw') }}">
                                                            <img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2072%2072%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h72v72H0z%22%2F%3E%3Cpath%20class%3D%22icon%22%20fill%3D%22%23fff%22%20d%3D%22M68.812%2015.14c-2.348%201.04-4.87%201.744-7.52%202.06%202.704-1.62%204.78-4.186%205.757-7.243-2.53%201.5-5.33%202.592-8.314%203.176C56.35%2010.59%2052.948%209%2049.182%209c-7.23%200-13.092%205.86-13.092%2013.093%200%201.026.118%202.02.338%202.98C25.543%2024.527%2015.9%2019.318%209.44%2011.396c-1.125%201.936-1.77%204.184-1.77%206.58%200%204.543%202.312%208.552%205.824%2010.9-2.146-.07-4.165-.658-5.93-1.64-.002.056-.002.11-.002.163%200%206.345%204.513%2011.638%2010.504%2012.84-1.1.298-2.256.457-3.45.457-.845%200-1.666-.078-2.464-.23%201.667%205.2%206.5%208.985%2012.23%209.09-4.482%203.51-10.13%205.605-16.26%205.605-1.055%200-2.096-.06-3.122-.184%205.794%203.717%2012.676%205.882%2020.067%205.882%2024.083%200%2037.25-19.95%2037.25-37.25%200-.565-.013-1.133-.038-1.693%202.558-1.847%204.778-4.15%206.532-6.774z%22%2F%3E%3C%2Fsvg%3E">
                                                        </a>
                                                        <a class="btn btn--group-item pi" data-social-network="Pinterest" data-social-network-link="" href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(URL::current().'?utm_source=sharepi') }}&media={{ urlencode(asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] )) }}&description={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}">
                                                            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiPjwvcGF0aD48cGF0aCBkPSJNMTQuNzMzLDEuNjg2IEM3LjUxNiwxLjY4NiAxLjY2NSw3LjQ5NSAxLjY2NSwxNC42NjIgQzEuNjY1LDIwLjE1OSA1LjEwOSwyNC44NTQgOS45NywyNi43NDQgQzkuODU2LDI1LjcxOCA5Ljc1MywyNC4xNDMgMTAuMDE2LDIzLjAyMiBDMTAuMjUzLDIyLjAxIDExLjU0OCwxNi41NzIgMTEuNTQ4LDE2LjU3MiBDMTEuNTQ4LDE2LjU3MiAxMS4xNTcsMTUuNzk1IDExLjE1NywxNC42NDYgQzExLjE1NywxMi44NDIgMTIuMjExLDExLjQ5NSAxMy41MjIsMTEuNDk1IEMxNC42MzcsMTEuNDk1IDE1LjE3NSwxMi4zMjYgMTUuMTc1LDEzLjMyMyBDMTUuMTc1LDE0LjQzNiAxNC40NjIsMTYuMSAxNC4wOTMsMTcuNjQzIEMxMy43ODUsMTguOTM1IDE0Ljc0NSwxOS45ODggMTYuMDI4LDE5Ljk4OCBDMTguMzUxLDE5Ljk4OCAyMC4xMzYsMTcuNTU2IDIwLjEzNiwxNC4wNDYgQzIwLjEzNiwxMC45MzkgMTcuODg4LDguNzY3IDE0LjY3OCw4Ljc2NyBDMTAuOTU5LDguNzY3IDguNzc3LDExLjUzNiA4Ljc3NywxNC4zOTggQzguNzc3LDE1LjUxMyA5LjIxLDE2LjcwOSA5Ljc0OSwxNy4zNTkgQzkuODU2LDE3LjQ4OCA5Ljg3MiwxNy42IDkuODQsMTcuNzMxIEM5Ljc0MSwxOC4xNDEgOS41MiwxOS4wMjMgOS40NzcsMTkuMjAzIEM5LjQyLDE5LjQ0IDkuMjg4LDE5LjQ5MSA5LjA0LDE5LjM3NiBDNy40MDgsMTguNjIyIDYuMzg3LDE2LjI1MiA2LjM4NywxNC4zNDkgQzYuMzg3LDEwLjI1NiA5LjM4Myw2LjQ5NyAxNS4wMjIsNi40OTcgQzE5LjU1NSw2LjQ5NyAyMy4wNzgsOS43MDUgMjMuMDc4LDEzLjk5MSBDMjMuMDc4LDE4LjQ2MyAyMC4yMzksMjIuMDYyIDE2LjI5NywyMi4wNjIgQzE0Ljk3MywyMi4wNjIgMTMuNzI4LDIxLjM3OSAxMy4zMDIsMjAuNTcyIEMxMy4zMDIsMjAuNTcyIDEyLjY0NywyMy4wNSAxMi40ODgsMjMuNjU3IEMxMi4xOTMsMjQuNzg0IDExLjM5NiwyNi4xOTYgMTAuODYzLDI3LjA1OCBDMTIuMDg2LDI3LjQzNCAxMy4zODYsMjcuNjM3IDE0LjczMywyNy42MzcgQzIxLjk1LDI3LjYzNyAyNy44MDEsMjEuODI4IDI3LjgwMSwxNC42NjIgQzI3LjgwMSw3LjQ5NSAyMS45NSwxLjY4NiAxNC43MzMsMS42ODYiIGZpbGw9IiMxMTEiPjwvcGF0aD48L2c+PC9zdmc+">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sidebar-l sidebar-right js-sso-checkout-experiment">
                                    <div class="pricebox-container js-author-driven-pricing-experiment">
                                        <div class="box -radius-all">
                                            <div id="purchase-form" class="purchase-form">
                                                <form data-view="purchaseForm" data-google-analytics-page="itemPage" data-google-analytics-payload="{&quot;actionData&quot;:null,&quot;productsArray&quot;:[{&quot;id&quot;:29900946,&quot;name&quot;:&quot;Dj Flyer&quot;,&quot;brand&quot;:&quot;Hotpin&quot;,&quot;category&quot;:&quot;Wakay.net/print-templates/flyers/events&quot;,&quot;quantity&quot;:&quot;1&quot;}],&quot;timestamp&quot;:1611619309}" action="/cart/add/29900946" accept-charset="UTF-8" method="post">
                                                    <p class="t-body -size-s" itemprop="description">
                                                        <!-- Customize this template, and get ready to download in minutes. -->
                                                        <!-- Wayak provides unique "x" free design templates. This "x" template is created by the talented graphic designers at WAYAK.  -->
                                                        The size of this template is {{ $template->width }}x{{ $template->height }}{{ $template->measureUnits }}. Click “Use This Template“, start your own design. Then you can change the text and images as you wish. After that, preview and save your work, your design will be ready to print, share or download.
                                                    </p>
                                                    <div class="purchase-form__button">
                                                        <a class="js-purchase__add-to-cart e-btn--3d -color-primary -size-m -width-full"
                                                            href="{{ 
                                                            route( 'admin.edit.template',[
                                                            'language_code' => $language_code,
                                                            'template_key' => $template->_id
                                                            ] )
                                                        }}">
                                                            <strong>Use this template</strong>
                                                        </a>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="item-preview__preview-buttons--social" data-view="socialButtons">
                                                <div class="btn-group">
                                                    <!-- <div class="btn btn--label btn--group-item">Share</div> -->
                                                    <a class="btn btn--group-item fb" data-social-network="Facebook" data-social-network-link="" href="https://www.facebook.com/sharer/sharer.php?display=popup&u={{ urlencode(URL::current().'?utm_source=sharepi') }}">
                                                        <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yr/r/zSKZHMh8mXU.png">
                                                    </a>
                                                    <a class="btn btn--group-item tw" data-social-network="Twitter" data-social-network-link="" href="https://twitter.com/intent/tweet?text={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}&url={{ urlencode(URL::current().'?utm_source=sharetw') }}">
                                                        <img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2072%2072%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h72v72H0z%22%2F%3E%3Cpath%20class%3D%22icon%22%20fill%3D%22%23fff%22%20d%3D%22M68.812%2015.14c-2.348%201.04-4.87%201.744-7.52%202.06%202.704-1.62%204.78-4.186%205.757-7.243-2.53%201.5-5.33%202.592-8.314%203.176C56.35%2010.59%2052.948%209%2049.182%209c-7.23%200-13.092%205.86-13.092%2013.093%200%201.026.118%202.02.338%202.98C25.543%2024.527%2015.9%2019.318%209.44%2011.396c-1.125%201.936-1.77%204.184-1.77%206.58%200%204.543%202.312%208.552%205.824%2010.9-2.146-.07-4.165-.658-5.93-1.64-.002.056-.002.11-.002.163%200%206.345%204.513%2011.638%2010.504%2012.84-1.1.298-2.256.457-3.45.457-.845%200-1.666-.078-2.464-.23%201.667%205.2%206.5%208.985%2012.23%209.09-4.482%203.51-10.13%205.605-16.26%205.605-1.055%200-2.096-.06-3.122-.184%205.794%203.717%2012.676%205.882%2020.067%205.882%2024.083%200%2037.25-19.95%2037.25-37.25%200-.565-.013-1.133-.038-1.693%202.558-1.847%204.778-4.15%206.532-6.774z%22%2F%3E%3C%2Fsvg%3E">
                                                    </a>
                                                    <a class="btn btn--group-item pi" data-social-network="Pinterest" data-social-network-link="" href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(URL::current().'?utm_source=sharepi') }}&media={{ urlencode(asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] )) }}&description={{ urlencode('Check Out "'.$template->title.'" on #WayakApp') }}">
                                                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiPjwvcGF0aD48cGF0aCBkPSJNMTQuNzMzLDEuNjg2IEM3LjUxNiwxLjY4NiAxLjY2NSw3LjQ5NSAxLjY2NSwxNC42NjIgQzEuNjY1LDIwLjE1OSA1LjEwOSwyNC44NTQgOS45NywyNi43NDQgQzkuODU2LDI1LjcxOCA5Ljc1MywyNC4xNDMgMTAuMDE2LDIzLjAyMiBDMTAuMjUzLDIyLjAxIDExLjU0OCwxNi41NzIgMTEuNTQ4LDE2LjU3MiBDMTEuNTQ4LDE2LjU3MiAxMS4xNTcsMTUuNzk1IDExLjE1NywxNC42NDYgQzExLjE1NywxMi44NDIgMTIuMjExLDExLjQ5NSAxMy41MjIsMTEuNDk1IEMxNC42MzcsMTEuNDk1IDE1LjE3NSwxMi4zMjYgMTUuMTc1LDEzLjMyMyBDMTUuMTc1LDE0LjQzNiAxNC40NjIsMTYuMSAxNC4wOTMsMTcuNjQzIEMxMy43ODUsMTguOTM1IDE0Ljc0NSwxOS45ODggMTYuMDI4LDE5Ljk4OCBDMTguMzUxLDE5Ljk4OCAyMC4xMzYsMTcuNTU2IDIwLjEzNiwxNC4wNDYgQzIwLjEzNiwxMC45MzkgMTcuODg4LDguNzY3IDE0LjY3OCw4Ljc2NyBDMTAuOTU5LDguNzY3IDguNzc3LDExLjUzNiA4Ljc3NywxNC4zOTggQzguNzc3LDE1LjUxMyA5LjIxLDE2LjcwOSA5Ljc0OSwxNy4zNTkgQzkuODU2LDE3LjQ4OCA5Ljg3MiwxNy42IDkuODQsMTcuNzMxIEM5Ljc0MSwxOC4xNDEgOS41MiwxOS4wMjMgOS40NzcsMTkuMjAzIEM5LjQyLDE5LjQ0IDkuMjg4LDE5LjQ5MSA5LjA0LDE5LjM3NiBDNy40MDgsMTguNjIyIDYuMzg3LDE2LjI1MiA2LjM4NywxNC4zNDkgQzYuMzg3LDEwLjI1NiA5LjM4Myw2LjQ5NyAxNS4wMjIsNi40OTcgQzE5LjU1NSw2LjQ5NyAyMy4wNzgsOS43MDUgMjMuMDc4LDEzLjk5MSBDMjMuMDc4LDE4LjQ2MyAyMC4yMzksMjIuMDYyIDE2LjI5NywyMi4wNjIgQzE0Ljk3MywyMi4wNjIgMTMuNzI4LDIxLjM3OSAxMy4zMDIsMjAuNTcyIEMxMy4zMDIsMjAuNTcyIDEyLjY0NywyMy4wNSAxMi40ODgsMjMuNjU3IEMxMi4xOTMsMjQuNzg0IDExLjM5NiwyNi4xOTYgMTAuODYzLDI3LjA1OCBDMTIuMDg2LDI3LjQzNCAxMy4zODYsMjcuNjM3IDE0LjczMywyNy42MzcgQzIxLjk1LDI3LjYzNyAyNy44MDEsMjEuODI4IDI3LjgwMSwxNC42NjIgQzI3LjgwMSw3LjQ5NSAyMS45NSwxLjY4NiAxNC43MzMsMS42ODYiIGZpbGw9IiMxMTEiPjwvcGF0aD48L2c+PC9zdmc+">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box -radius-all">
                                        <div class="rating-detailed--has-no-ratings" 
                                            itemprop="aggregateRating"
                                            itemscope itemtype="https://schema.org/AggregateRating">
                                            <strong>Item Rating:</strong> &nbsp;&nbsp;<span>Minimum of 3 votes required</span>
                                            <!-- Rated <span itemprop="ratingValue">3.5</span>/5
                                            based on <span itemprop="reviewCount">11</span> customer reviews -->
                                        </div>
                                    </div>
                                    <div class="box -radius-all">
                                        <div class="meta-attributes " data-view="CondenseItemInfoPanel">
                                            <table class="meta-attributes__table" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <!-- <tr>
                                                        <td class="meta-attributes__attr-name">Last Update</td>
                                                        <td class="meta-attributes__attr-detail">
                                                            <time class="updated" datetime="2021-01-05T10:16:16+11:00">
                                                                {{ $template->updatedAt }}
                                                            </time>
                                                        </td>
                                                    </tr> -->
                                                    <!-- <tr>
                                                        <td class="meta-attributes__attr-name">Created</td>
                                                        <td class="meta-attributes__attr-detail">
                                                            <span>
                                                                {{ $template->createdAt }}
                                                            </span>
                                                        </td>
                                                    </tr> -->
                                                    <tr>
                                                        <td class="meta-attributes__attr-name">Category</td>
                                                        <td class="meta-attributes__attr-detail">
                                                            <a rel="nofollow" href="/attributes/print-dimensions/4x4">
                                                                {{ $breadcrumb->name }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="meta-attributes__attr-name">Format</td>
                                                        <td class="meta-attributes__attr-detail">
                                                            <a rel="nofollow" href="/attributes/print-dimensions/4x4">
                                                                {{ $template->format }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="meta-attributes__attr-name">Dimensions</td>
                                                        <td class="meta-attributes__attr-detail">
                                                            <a rel="nofollow" href="/attributes/print-dimensions/4x4">
                                                                {{ $template->width }}x{{ $template->height }} {{ $template->measureUnits }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @if( isset($template->tags) && sizeof($template->tags) > 0 )
                                                    <tr>
                                                        <td class="meta-attributes__attr-name">Tags</td>
                                                        <td>
                                                            <span class="meta-attributes__attr-tags">
                                                                @foreach($template->tags as $tag)
                                                                    <a title="artist flyer" rel="nofollow" href="/artist%20flyer-graphics">
                                                                        {{ $tag->name }}
                                                                    </a>,
                                                                @endforeach
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box -radius-all">
                                        <div class="rating-detailed--has-no-ratings">
                                            <strong>Colors:</strong> &nbsp;&nbsp;
                                            <ul class="DM08FA">
                                                @foreach( $colors as $hex_color )
                                                    <li class="Gu5L1Q" style="background-color: {{ $hex_color }};"><div class="_-pFsfA">{{ $hex_color }}</div></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="is-hidden-phone">
                        <div id="tooltip-magnifier" class="magnifier">
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="landscape-image-magnifier" class="magnifier">
                            <div class="size-limiter">
                            </div>
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="portrait-image-magnifier" class="magnifier">
                            <div class="size-limiter">
                            </div>
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="square-image-magnifier" class="magnifier" style="top: 2376px; left: 619.5px; display: none;">
                            <div class="size-limiter"><img src="{{ asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] ) }}"></div>
                            <strong>{{ $template->title }}</strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author">Hotpin</span>
                                </div>
                                <div class="price">
                                    <span class="cost"><sup>$</sup>7</span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category">Print Templates / Flyers / Church</span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="smart-image-magnifier" class="magnifier">
                            <div class="size-limiter">
                            </div>
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                        <div id="video-magnifier" class="magnifier">
                            <div class="size-limiter">
                                <div class="faux-player is-hidden"><img></div>
                                <div>
                                    <div id="hover-video-preview"></div>
                                </div>
                            </div>
                            <strong></strong>
                            <div class="info">
                                <div class="author-category">
                                    by <span class="author"></span>
                                </div>
                                <div class="price">
                                    <span class="cost"></span>
                                </div>
                            </div>
                            <div class="footer">
                                <span class="category"></span>
                                <span class="gst-notice">All prices are in US dollars and exclude sales tax</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page__overlay" data-view="offCanvasNavToggle" data-off-canvas="close"></div>
            </div>
        </div>
        <div data-site="Wakay" data-view="CsatSurvey" data-experiment-id="csat_survey" class="is-visually-hidden">
            <div id="js-customer-satisfaction-survey">
                <div class="e-modal">
                    <div class="e-modal__section" id="js-customer-satisfaction-survey-iframe-wrapper">
                    </div>
                </div>
            </div>
        </div>
        <div id="js-customer-satisfaction-popup" class="survey-popup is-visually-hidden">
            <div class="h-text-align-right"><a href="#" id="js-popup-close-button" class="e-alert-box__dismiss-icon"><i class="e-icon -icon-cancel"></i></a></div>
            <div class="survey-popup--section">
                <h2 class="t-heading h-text-align-center -size-m">Tell us what you think!</h2>
                <p>We'd like to ask you a few questions to help improve Wakay.</p>
            </div>
            <div class="survey-popup--section">
                <a href="#" id="js-show-survey-button" class="e-btn -color-primary -size-m -width-full js-survey-popup--show-survey-button">Sure, take me to the survey</a>
            </div>
        </div>
        <div id="affiliate-tracker" class="is-hidden" data-view="affiliatesTracker" data-cookiebot-enabled="true"></div>
        
@endsection