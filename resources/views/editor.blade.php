<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name=”robots” content=”noindex,nofollow”>
        <meta name="googlebot" content="noindex">
        <meta name="description" content="🖍️ The largest collection of templates online. Ready to print or use on social media. Create invitations, resumes, presentations, posters, flyers. Check it out!"/>

        <link href="{{ asset('apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180">
        <link href="{{ asset('favicon-32x32.png') }}" rel="icon" sizes="32x32" type="image/png">
        <link href="{{ asset('favicon-16x16.png') }}" rel="icon" sizes="16x16" type="image/png">
        <link href="{{ asset('manifest.json') }}" rel="manifest">
        <link color="#5bbad5" href="{{ asset('safari-pinned-tab.svg') }}" rel="mask-icon">
        <meta content="#ffffff" name="theme-color">
        <title>
            WAYAK - Online Editor
        </title>
        <link href="{{ asset('assets/css/spectrum.css') }}" rel="canonical"/>
        <link href="{{ asset('assets/lib/stroke-7/style.css') }}" rel="stylesheet" type="text/css"/>
        <!-- <link href="{{ asset('assets/lib/jquery.nanoscroller/css/nanoscroller.css') }}" rel="stylesheet" type="text/css"/> -->

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('assets/js/bootstrap/bootstrap.min.css') }}" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"/>

        <link href="{{ asset('assets/js/font-awesome/css/all.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/spectrum.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- <link href="{{ asset('assets/css/bootstrap-slider.css') }}" rel="stylesheet" type="text/css"/> -->
        <!-- <link href="{{ asset('assets/lib/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css"/> -->
        <link href="{{ asset('assets/css/style.css?v=0301201901') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/js/select2/select2.min.css') }}" rel="stylesheet"/>
        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.min.css" rel="stylesheet" type="text/css"/> -->
        <!-- 
        <link rel="stylesheet" href="{{ asset('assets/css/spectrum.css') }}css/style.css">
        -->

        

    </head>
    <body class="normal">
        <div id="appSpinner" style="display: none;">
            <img class="loading-spin" src="{{ asset('assets/img/loader.svg') }}">
            </img>
        </div>
        <ul class="custom-menu">
            <li data-action="selectall">
                Select All
            </li>
            <li class="cut" data-action="cut">
                Cut
            </li>
            <li class="copy" data-action="copy">
                Copy
            </li>
            <li data-action="paste">
                Paste
            </li>
            <li data-action="pasteInPlace">
                Paste in place
            </li>
        </ul>
        <div class="modal" data-backdrop="static" data-keyboard="false" id="loadingpage" style="background:#fff; opacity:1; display:block;">
            <img class="loading-spin" src="{{ asset('assets/img/loader.svg') }}"/>
        </div>
        <div class="am-wrapper am-fixed-sidebar">
            <nav class="navbar navbar-default navbar-fixed-top am-top-header">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="page-title">
                        </div>
                        <a class="am-toggle-left-sidebar navbar-toggle collapsed" href="#">
                            <span class="icon-bar">
                                <span>
                                </span>
                                <span>
                                </span>
                                <span>
                                </span>
                            </span>
                        </a>
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('assets/img/logo.svg') }}" loading="lazy"/>
                        </a>
                    </div>
                    <a class="am-toggle-top-header-menu collapsed" data-target="#am-navbar-collapse" data-toggle="collapse" href="#">
                        <span class="icon s7-angle-down">
                        </span>
                    </a>
                    <div class="collapse navbar-collapse" id="am-navbar-collapse">
                        <ul class="nav navbar-nav am-nav-right">
                            <li>
                                <a href="#" id="undo" title="Undo">
                                    Back
                                </a>
                            </li>
                            <li>
                                <a href="#" id="redo" title="Redo">
                                    Forward
                                </a>
                            </li>
                            <!-- if( $user_role  == 'administrator' OR $user_role  == 'designer' )  "administrator", "designer","customer" -->
                            @if( $demo_as_id == 0 )
                                <li>
                                    <a href="#" id="savetemplate" title="savetemplate">
                                        Save
                                    </a>
                                </li>
                                @if( $user_role == 'administrator' )
                                    <li>
                                        <a href="#" id="newtemplate" title="newtemplate">
                                            New
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" id="saveastemplate" title="saveastemplate">
                                            Save As
                                        </a>
                                    </li>
                                @endif
                            @endif
                            <li>
                                <a href="#" id="canvasSize" title="saveimage">
                                    Canvas Size
                                </a>
                            </li>
                        </ul>
                        <!-- <ul class="nav navbar-nav navbar-right am-user-nav">
                            <li class="dropdown">
                                <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                    <img id="avatar-nav" src="{{ asset('assets/img/avatar.png') }}">
                                        <span class="user-name">
                                        </span>
                                        <span class="angle-down s7-angle-down">
                                        </span>
                                    </img>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="http://localhost/auth.php?action=logout">
                                            <span class="icon s7-power">
                                            </span>
                                            Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul> -->
                        <!-- <ul class="nav navbar-nav navbar-right am-admin-nav">
                            <li>
                                <a href="https://help.localhost.com" target="_blank">
                                    Ayuda
                                </a>
                            </li>
                        </ul> -->
                        <ul class="nav navbar-nav navbar-right am-icons-nav">
                            <li class="dropdown hide">
                                <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" title="Settings">
                                    <span class="icon s7-config">
                                    </span>
                                </a>
                                <ul class="dropdown-menu am-connections">
                                    <li>
                                        <div class="title">
                                            Ajustes
                                        </div>
                                        <div class="list">
                                            <div class="content">
                                                <ul>
                                                    <li>
                                                        <div class="logo">
                                                            <span class="icon s7-stopwatch" style="font-size:24px; vertical-align:middle;">
                                                            </span>
                                                        </div>
                                                        <div class="field">
                                                            <span>
                                                                Auto guardar
                                                            </span>
                                                            <div class="pull-right">
                                                                <div class="switch-button switch-button-sm">
                                                                    <input data-saved="yes" id="autosave" onchange="autoSave(this);" type="checkbox">
                                                                        <span>
                                                                            <label for="autosave">
                                                                            </label>
                                                                        </span>
                                                                    </input>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            @if( $demo_as_id == 0 )
                                <li class="dropdown download-menu">
                                    <input type="hidden" id="template-status" value="empty">

                                    <button aria-expanded="false" class="dropdown-toggle btn btn-info" data-toggle="dropdown" href="#" role="button" style="margin:12px 0;">
                                        Download
                                    </button>
                                    <ul class="dropdown-menu am-connections">
                                        <li>
                                            <div class="title">
                                                Download Options
                                            </div>
                                            <div class="list">
                                                <div class="content">
                                                    <ul>
                                                        <li style="text-align:center;">
                                                            <a href="#" id="downloadPDF">
                                                                <span class="icon s7-print" style="font-size:24px; vertical-align:middle;">
                                                                </span>
                                                                PDF (Para imprimir)
                                                            </a>
                                                        </li>
                                                        <li class="download-jpeg-menu-item" style="text-align:center;">
                                                            <a href="#" id="downloadJPEG">
                                                                <span class="icon s7-print" style="font-size:24px; vertical-align:middle;">
                                                                </span>
                                                                JPEG ( For printing )
                                                            </a>
                                                        </li>
                                                        <li style="text-align:center;">
                                                            <a href="#" id="downloadAsPNG">
                                                                <span class="icon s7-share" style="font-size:24px; vertical-align:middle;">
                                                                </span>
                                                                PNG (Face, Whats, Web)
                                                            </a>
                                                        </li>
                                                        <li class="title" id="downloads-remaining-text" style="text-align:center;">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                        <!-- Design As User -->
                        <!-- Demo -->
                        @if( $demo_as_id > 0 )
                            <ul class="nav navbar-nav navbar-right am-icons-nav">
                                <li style="top:20px; color:#333;font-weight: bold;">
                                    You are in a demo version. You will not be able to save the changes or download the image.
                                    <button onclick="history.back()" style="
                                        align-self: center;
                                        background: #f73859;
                                        border-radius: 25px;
                                        color: #fff;
                                        cursor: pointer;
                                        font-size: 15px;
                                        border: none;
                                        margin-left: 16px;
                                        padding: 2px 10px;
                                    ">Go Back</button>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </nav>
            <div class="am-left-sidebar">
                <div class="content">
                    <div class="am-logo">
                    </div>
                    <ul class="sidebar-elements">
                        <li class="parent active">
                            <a class="templates-pane" href="#">
                                <i class="icon s7-albums">
                                </i>
                                <span>
                                    Templates
                                </span>
                            </a>
                            <ul class="sub-menu visible">
                                <li>
                                    <div class="col-lg-12">
                                        <!-- <style>
                                            .iXSRa-D {
                                                -webkit-box-align: center;
                                                align-items: center;
                                                bottom: 0px;
                                                display: flex;
                                                height: 40px;
                                                -webkit-box-pack: center;
                                                justify-content: center;
                                                margin: inherit;
                                                position: absolute;
                                                top: 0px;
                                                width: 40px;
                                            }
                                            .hgkKkK[type="templatesearch"] {
                                                background-color: rgb(243, 243, 243);
                                                border-color: rgb(220, 220, 220);
                                            }
                                            
                                            .hgkKkK {
                                                background-color: rgb(255, 255, 255);
                                                border: 1px solid rgb(220, 220, 220);
                                                border-radius: 8px;
                                                color: rgb(86, 86, 86);
                                                display: block;
                                                font-size: 14px;
                                                height: 40px;
                                                line-height: 1;
                                                padding-left: 40px;
                                                padding-right: 12px;
                                                transition: background-color 0.25s ease 0s, border-color 0.25s ease 0s, color 0.25s ease 0s;
                                                width: 100%;
                                            }
                                            
                                            [type="templatesearch"] {
                                                appearance: textfield;
                                                outline-offset: -2px;
                                            }
                                        </style> -->
                                        <!-- <div class="StyledInputContainer-sc-1icyccg XAwfH">
                                            <div class="StyledIcon-sc-r3p5g6 iXSRa-D">
                                                <svg width="24" height="24" viewBox="0 0 24 24"><path fill="none" fill-rule="evenodd" stroke="#8C8C8C" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.657 16.657L21 21l-4.343-4.343A8 8 0 1 1 5.343 5.343a8 8 0 0 1 11.314 11.314z"></path></svg>
                                            </div>
                                            <input type="templatesearch" id="templatesearch" placeholder="Buscar plantillas…" autocorrect="off" class="StyledInput-sc-1aryhc3 hgkKkK">
                                                <a class="cancel_button" href="#" id="cancel_templates_search" title="Clear search">
                                                    <i class="s7-close-circle">
                                                    </i>
                                                </a>
                                            </input>
                                        </div> -->

                                        <!-- <div class="search">
                                            <input id="templatesearch" name="templatesearch" placeholder="Buscar..." type="text">
                                                <a class="cancel_button" href="#" id="cancel_templates_search" title="Clear search">
                                                    <i class="s7-close-circle">
                                                    </i>
                                                </a>
                                            </input>
                                        </div> -->
                                    </div>
                                    <!-- /.col-lg-12 -->
                                    <div class="col-lg-12 scroll-container" id="a">
                                        <div id="template_container" style="text-align:center;">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="parent">
                            <a class="textPane invisible" href="#">
                                <span style="font-size:35px; line-height:30px; margin-top:0px; margin-bottom:0px;">
                                    T
                                </span>
                                <span>
                                    Text
                                </span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <div class="col-lg-12">
                                        <div class="input-group text-search-block">
                                            <div class="input-group-btn text-opt-menu">
                                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-alt4 dropdown-toggle btn-menu" data-toggle="dropdown" id="textMenu" type="button">
                                                    <span class="icon s7-menu">
                                                    </span>
                                                </button>
                                                <ul aria-labelledby="textMenu" class="dropdown-menu">
                                                    <li>
                                                        <a href="#" id="saveText">
                                                            Save from Selection
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="search">
                                                <input id="textsearch" name="textsearch" placeholder="Search..." type="text">
                                                    <a class="cancel_button" href="#" id="cancel_text_search" title="Clear search">
                                                        <i class="s7-close-circle">
                                                        </i>
                                                    </a>
                                                </input>
                                            </div>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-12 -->
                                    <div class="col-lg-12" id="addtextoptions" style="text-align:center; margin-top:10px;">
                                        <div id="addheading" style="font-size:36px;">
                                            <a href="#" onclick="javascript:addheadingText();">
                                                Add Heading Text
                                            </a>
                                        </div>
                                        <div id="addsometext" style="font-size:18px; margin:5px 0 10px 0;">
                                         
                                            <a href="#" onclick="javascript:addText();">
                                                Add Textbox
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 scroll-container" id="b">
                                        <div class="" id="text_container" style="text-align:center;">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="parent elementsPaneParent">
                            <a class="elementsPane invisible" href="#">
                                <i class="icon s7-keypad">
                                </i>
                                <span>
                                    Biblioteca
                                </span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-alt4 dropdown-toggle btn-menu" data-toggle="dropdown" id="elementMenu" type="button">
                                                    <span class="icon s7-menu">
                                                    </span>
                                                </button>
                                                <ul aria-labelledby="elementMenu" class="dropdown-menu">
                                                    <li>
                                                        <a href="#" id="addElement">
                                                            New Element
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" id="saveElement">
                                                            Save from Selection
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="search">
                                                <input id="elementssearch" name="elementssearch" placeholder="Search..." type="text">
                                                    <a class="cancel_button" href="#" id="cancel_elements_search" title="Clear search">
                                                        <i class="s7-close-circle">
                                                        </i>
                                                    </a>
                                                </input>
                                            </div>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-12 -->
                                    <div class="col-lg-12" style="margin-top: 5px;">
                                        <button class="btn btn-alt4 intabbtn" id="addline" onclick="javascript:addhLine();" title="Add Horizontal Line" type="button">
                                            H Line
                                        </button>
                                        <button class="btn btn-alt4 intabbtn" id="addline" onclick="javascript:addvLine();" title="Add Vertical Line" type="button">
                                            V Line
                                        </button>
                                        <button class="btn btn-alt4 intabbtn" id="addline" onclick="javascript:addBorder();" title="Add Border" type="button">
                                            Border
                                        </button>
                                    </div>
                                    <div class="col-lg-12 scroll-container" id="c">
                                        <div id="catimage_container" style="text-align:center;">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="parent">
                            <a class="bgPane invisible" href="#">
                                <i class="icon s7-photo">
                                </i>
                                <span>
                                    Background
                                </span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <div class="col-lg-12">
                                        <div class="input-group background">
                                            <div class="input-group-btn">
                                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-alt4 dropdown-toggle btn-menu" data-toggle="dropdown" id="backgroundMenu" type="button">
                                                    <span class="icon s7-menu">
                                                    </span>
                                                </button>
                                                <ul aria-labelledby="backgroundMenu" class="dropdown-menu">
                                                    <li>
                                                        <a href="#" id="addBackground">
                                                            New Background
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="search">
                                                <input id="bgsearch" name="bgsearch" placeholder="Search..." type="text">
                                                    <a class="cancel_button" href="#" id="cancel_bg_search" title="Clear search">
                                                        <i class="s7-close-circle">
                                                        </i>
                                                    </a>
                                                </input>
                                            </div>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-12 -->
                                    <div class="col-lg-12" style="margin-top:5px;">
                                        <button class="btn btn-alt4" data-target="#bgcolorcontainer" data-toggle="collapse" title="Background color" type="button">
                                            <span class="icon s7-paint-bucket">
                                            </span>
                                        </button>
                                        <button class="btn btn-alt4" data-target="#bgscalecontainer" data-toggle="collapse" title="Background scale" type="button">
                                            <span class="icon s7-expand2">
                                            </span>
                                        </button>
                                        <button class="btn btn-danger" id="bgImageRemove" title="Delete background" type="button">
                                            <span class="icon s7-trash">
                                            </span>
                                        </button>
                                    </div>
                                    <!-- /.col-lg-12 -->
                                    <div class="collapse col-lg-12" id="bgscalecontainer" style="text-align:center; margin-top:10px;">
                                        <p>
                                            <label>
                                                Background Scale
                                            </label>
                                            <input data-slider-id="bgscaleslider" data-slider-max="130" data-slider-min="10" data-slider-step="5" data-slider-value="100" id="bgscale" type="text"/>
                                        </p>
                                    </div>
                                    <div class="col-lg-12 scroll-container" id="d">
                                        <div class="collapse in" id="bgcolorcontainer" style="text-align:center; margin-top:10px; top:0px !important;">
                                            <div id="bgcolorselect">
                                            </div>
                                        </div>
                                        <div id="background_container" style="text-align:center;">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="parent" id="tab-upload">
                            <!-- <a class="invisible" href="#" id="imagesPane">
                                <i class="icon s7-cloud-upload">
                                </i>
                                <span>
                                    Imagenes
                                </span>
                            </a> -->
                <ul class="sub-menu">
                    <li>
                        <div class="col-lg-12 scroll-container" id="f">
                                                        <div id="myAwesomeDropzone" class="dropzone">
                                <div class="dz-message">
                                    <div class="icon"><span class="s7-cloud-upload"></span></div>
                                    <h4>Drag and Drop files here</h4>
                                </div>
                                <div class="uploaded_images dropzone-previews"></div>
                            </div>
                                                        <div id="uploaded_images_list" class="uploaded_images_list dropzone-previews"></div>
                        </div>
                    </li>
                    <li>
                                                <form id="upload" action="uploadimage.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="1000000" />
                            <input id="fileselect" type="file" name="fileselect[]" />
                        </form>
                                            </li>
                </ul>
                        </li>
                        <li class="parent" id="relatedProductsPane">
                            <a class="invisible" href="#">
                                <i class="icon s7-shopbag">
                                </i>
                                <span>
                                    Productos relacionados
                                </span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <li class="title" style="font-size:20px;">
                                        Tambien te puede gustar...
                                    </li>
                                    <div class="col-lg-12 scroll-container" id="e">
                                        <div id="related_products_container" style="text-align:center;">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!--Sidebar bottom content-->
                </div>
            </div>
            <div class="am-content">
                <div class="main-content">
                    <div class="tools-top centered" style="z-index:1000;">
                        <div class="toolbar-top">
                            <span class="textelebtns">
                                <div class="btn-group">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" id="font-selected" title="Select Font">
                                        <!-- <span><span style="font-family: 'Averia Sans Libre'; font-size: 14px;">Averia Sans Libre</span>&nbsp;&nbsp;<span class="caret"></span></span> -->
                                    </button>
                                    <ul class="dropdown-menu fonts-dropdown" id="fonts-dropdown">
                                        <li>
                                            <span>
                                                Alfa Slab One
                                            </span>
                                            <a data-ff="font1" href="#" title="Alfa Slab One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Alfa_Slab_One_1490473638.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Averia Sans Libre
                                            </span>
                                            <a data-ff="font2" href="#" title="Averia Sans Libre">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Averia_Sans_Libre_1490473641.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Source Sans Pro
                                            </span>
                                            <a data-ff="font3" href="#" title="Source Sans Pro">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Source_Sans_Pro_1490473644.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Lilita One
                                            </span>
                                            <a data-ff="font5" href="#" title="Lilita One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Lilita_One_1490473649.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Dosis
                                            </span>
                                            <a data-ff="font6" href="#" title="Dosis">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Dosis_1490473650.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Abel
                                            </span>
                                            <a data-ff="font7" href="#" title="Abel">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Abel_1490473651.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kristi
                                            </span>
                                            <a data-ff="font8" href="#" title="Kristi">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Kristi_1490473652.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Ubuntu Mono
                                            </span>
                                            <a data-ff="font9" href="#" title="Ubuntu Mono">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Ubuntu_Mono_1490473653.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bubblegum Sans
                                            </span>
                                            <a data-ff="font10" href="#" title="Bubblegum Sans">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Bubblegum_Sans_1490473656.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Overlock
                                            </span>
                                            <a data-ff="font11" href="#" title="Overlock">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Overlock_1490473658.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Patrick Hand
                                            </span>
                                            <a data-ff="font12" href="#" title="Patrick Hand">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Patrick_Hand_1490473660.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Crafty Girls
                                            </span>
                                            <a data-ff="font13" href="#" title="Crafty Girls">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Crafty_Girls_1490473661.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Noto Sans
                                            </span>
                                            <a data-ff="font14" href="#" title="Noto Sans">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Noto_Sans_1490473663.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Droid Sans
                                            </span>
                                            <a data-ff="font15" href="#" title="Droid Sans">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Droid_Sans_1490473665.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Yellowtail
                                            </span>
                                            <a data-ff="font16" href="#" title="Yellowtail">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Yellowtail_1490473667.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Permanent Marker
                                            </span>
                                            <a data-ff="font17" href="#" title="Permanent Marker">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Permanent_Marker_1490473669.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Just Another Hand
                                            </span>
                                            <a data-ff="font18" href="#" title="Just Another Hand">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Just_Another_Hand_1490473674.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Unkempt
                                            </span>
                                            <a data-ff="font19" href="#" title="Unkempt">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Unkempt_1490473676.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Lato
                                            </span>
                                            <a data-ff="font20" href="#" title="Lato">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Lato_1490473678.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Arvo
                                            </span>
                                            <a data-ff="font21" href="#" title="Arvo">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Arvo_1490473679.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cabin
                                            </span>
                                            <a data-ff="font22" href="#" title="Cabin">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cabin_1490473680.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Playfair Display
                                            </span>
                                            <a data-ff="font23" href="#" title="Playfair Display">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Playfair_Display_1490473681.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cutive Mono
                                            </span>
                                            <a data-ff="font24" href="#" title="Cutive Mono">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cutive_Mono_1490473684.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Crushed
                                            </span>
                                            <a data-ff="font25" href="#" title="Crushed">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Crushed_1490473686.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Parisienne
                                            </span>
                                            <a data-ff="font26" href="#" title="Parisienne">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Parisienne_1490473688.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Codystar
                                            </span>
                                            <a data-ff="font27" href="#" title="Codystar">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Codystar_1490473690.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Lora
                                            </span>
                                            <a data-ff="font28" href="#" title="Lora">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Lora_1490473692.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Niconne
                                            </span>
                                            <a data-ff="font29" href="#" title="Niconne">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Niconne_1490473693.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Fredericka the Great
                                            </span>
                                            <a data-ff="font30" href="#" title="Fredericka the Great">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Fredericka_the_Great_1490473694.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Give You Glory
                                            </span>
                                            <a data-ff="font31" href="#" title="Give You Glory">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Give_You_Glory_1490473698.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Rammetto One
                                            </span>
                                            <a data-ff="font32" href="#" title="Rammetto One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Rammetto_One_1490473700.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                PT Sans
                                            </span>
                                            <a data-ff="font34" href="#" title="PT Sans">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/PT_Sans_1490473703.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Poiret One
                                            </span>
                                            <a data-ff="font35" href="#" title="Poiret One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Poiret_One_1490473705.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cabin Sketch
                                            </span>
                                            <a data-ff="font36" href="#" title="Cabin Sketch">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cabin_Sketch_1490473706.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cherry Cream Soda
                                            </span>
                                            <a data-ff="font37" href="#" title="Cherry Cream Soda">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cherry_Cream_Soda_1490473709.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                PT Sans Narrow
                                            </span>
                                            <a data-ff="font38" href="#" title="PT Sans Narrow">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/PT_Sans_Narrow_1490473712.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Montez
                                            </span>
                                            <a data-ff="font39" href="#" title="Montez">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Montez_1490473714.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Short Stack
                                            </span>
                                            <a data-ff="font40" href="#" title="Short Stack">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Short_Stack_1490473715.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Lily Script One
                                            </span>
                                            <a data-ff="font41" href="#" title="Lily Script One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Lily_Script_One_1490473718.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Tinos
                                            </span>
                                            <a data-ff="font42" href="#" title="Tinos">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Tinos_1490473720.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Neucha
                                            </span>
                                            <a data-ff="font43" href="#" title="Neucha">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Neucha_1490473721.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bad Script
                                            </span>
                                            <a data-ff="font44" href="#" title="Bad Script">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Bad_Script_1490473722.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Corben
                                            </span>
                                            <a data-ff="font45" href="#" title="Corben">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Corben_1490473723.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Yeseva One
                                            </span>
                                            <a data-ff="font46" href="#" title="Yeseva One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Yeseva_One_1490473724.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Arimo
                                            </span>
                                            <a data-ff="font47" href="#" title="Arimo">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Arimo_1490473727.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Petit Formal Script
                                            </span>
                                            <a data-ff="font48" href="#" title="Petit Formal Script">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Petit_Formal_Script_1490473728.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kelly Slab
                                            </span>
                                            <a data-ff="font49" href="#" title="Kelly Slab">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Kelly_Slab_1490473732.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Oleo Script
                                            </span>
                                            <a data-ff="font50" href="#" title="Oleo Script">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Oleo_Script_1490473734.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Noto Serif
                                            </span>
                                            <a data-ff="font51" href="#" title="Noto Serif">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Noto_Serif_1490473735.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Ubuntu
                                            </span>
                                            <a data-ff="font52" href="#" title="Ubuntu">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Ubuntu_1490473737.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                La Belle Aurore
                                            </span>
                                            <a data-ff="font53" href="#" title="La Belle Aurore">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/La_Belle_Aurore_1490473739.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                The Girl Next Door
                                            </span>
                                            <a data-ff="font54" href="#" title="The Girl Next Door">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/The_Girl_Next_Door_1490473741.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                PT Mono
                                            </span>
                                            <a data-ff="font55" href="#" title="PT Mono">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/PT_Mono_1490473743.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Yesteryear
                                            </span>
                                            <a data-ff="font56" href="#" title="Yesteryear">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Yesteryear_1490473745.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Marck Script
                                            </span>
                                            <a data-ff="font57" href="#" title="Marck Script">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Marck_Script_1490473746.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Droid Sans Mono
                                            </span>
                                            <a data-ff="font58" href="#" title="Droid Sans Mono">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Droid_Sans_Mono_1490473748.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Contrail One
                                            </span>
                                            <a data-ff="font59" href="#" title="Contrail One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Contrail_One_1490473752.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Nova Mono
                                            </span>
                                            <a data-ff="font60" href="#" title="Nova Mono">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Nova_Mono_1490473753.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bitter
                                            </span>
                                            <a data-ff="font61" href="#" title="Bitter">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Bitter_1490473755.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Allura
                                            </span>
                                            <a data-ff="font62" href="#" title="Allura">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Allura_1490473757.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                PT Serif
                                            </span>
                                            <a data-ff="font63" href="#" title="PT Serif">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/PT_Serif_1490473758.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Limelight
                                            </span>
                                            <a data-ff="font64" href="#" title="Limelight">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Limelight_1490473759.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Lobster
                                            </span>
                                            <a data-ff="font65" href="#" title="Lobster">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Lobster_1490473761.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kreon
                                            </span>
                                            <a data-ff="font66" href="#" title="Kreon">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Kreon_1490473762.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Fugaz One
                                            </span>
                                            <a data-ff="font67" href="#" title="Fugaz One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Fugaz_One_1490473764.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Waiting for the Sunrise
                                            </span>
                                            <a data-ff="font68" href="#" title="Waiting for the Sunrise">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Waiting_for_the_Sunrise_1490473765.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Shojumaru
                                            </span>
                                            <a data-ff="font69" href="#" title="Shojumaru">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Shojumaru_1490473768.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Gochi Hand
                                            </span>
                                            <a data-ff="font70" href="#" title="Gochi Hand">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Gochi_Hand_1490473770.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Reenie Beanie
                                            </span>
                                            <a data-ff="font71" href="#" title="Reenie Beanie">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Reenie_Beanie_1490473772.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Alex Brush
                                            </span>
                                            <a data-ff="font72" href="#" title="Alex Brush">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Alex_Brush_1490473774.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Schoolbell
                                            </span>
                                            <a data-ff="font73" href="#" title="Schoolbell">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Schoolbell_1490473776.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Crete Round
                                            </span>
                                            <a data-ff="font74" href="#" title="Crete Round">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Crete_Round_1490473778.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Shadows Into Light
                                            </span>
                                            <a data-ff="font75" href="#" title="Shadows Into Light">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Shadows_Into_Light_1490473780.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Rokkitt
                                            </span>
                                            <a data-ff="font76" href="#" title="Rokkitt">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Rokkitt_1490473782.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Josefin Slab
                                            </span>
                                            <a data-ff="font77" href="#" title="Josefin Slab">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Josefin_Slab_1490473783.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Frijole
                                            </span>
                                            <a data-ff="font78" href="#" title="Frijole">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Frijole_1490473785.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Fredoka One
                                            </span>
                                            <a data-ff="font79" href="#" title="Fredoka One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Fredoka_One_1490473788.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Libre Baskerville
                                            </span>
                                            <a data-ff="font80" href="#" title="Libre Baskerville">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Libre_Baskerville_1490473790.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Racing Sans One
                                            </span>
                                            <a data-ff="font81" href="#" title="Racing Sans One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Racing_Sans_One_1490473793.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Walter Turncoat
                                            </span>
                                            <a data-ff="font82" href="#" title="Walter Turncoat">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Walter_Turncoat_1490473796.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sigmar One
                                            </span>
                                            <a data-ff="font83" href="#" title="Sigmar One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sigmar_One_1490473802.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Source Code Pro
                                            </span>
                                            <a data-ff="font84" href="#" title="Source Code Pro">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Source_Code_Pro_1490473804.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Gloria Hallelujah
                                            </span>
                                            <a data-ff="font85" href="#" title="Gloria Hallelujah">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Gloria_Hallelujah_1490473808.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Fontdiner Swanky
                                            </span>
                                            <a data-ff="font86" href="#" title="Fontdiner Swanky">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Fontdiner_Swanky_1490473810.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Calligraffitti
                                            </span>
                                            <a data-ff="font87" href="#" title="Calligraffitti">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Calligraffitti_1490473813.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Grand Hotel
                                            </span>
                                            <a data-ff="font88" href="#" title="Grand Hotel">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Grand_Hotel_1490473815.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Tangerine
                                            </span>
                                            <a data-ff="font89" href="#" title="Tangerine">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Tangerine_1490473816.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Muli
                                            </span>
                                            <a data-ff="font90" href="#" title="Muli">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Muli_1490473817.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Just Me Again Down Here
                                            </span>
                                            <a data-ff="font91" href="#" title="Just Me Again Down Here">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Just_Me_Again_Down_Here_1490473818.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Great Vibes
                                            </span>
                                            <a data-ff="font92" href="#" title="Great Vibes">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Great_Vibes_1490473821.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cousine
                                            </span>
                                            <a data-ff="font93" href="#" title="Cousine">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cousine_1490473822.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Merienda One
                                            </span>
                                            <a data-ff="font94" href="#" title="Merienda One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Merienda_One_1490473825.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Monoton
                                            </span>
                                            <a data-ff="font95" href="#" title="Monoton">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Monoton_1490473827.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Ubuntu Condensed
                                            </span>
                                            <a data-ff="font96" href="#" title="Ubuntu Condensed">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Ubuntu_Condensed_1490473829.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                EB Garamond
                                            </span>
                                            <a data-ff="font97" href="#" title="EB Garamond">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/EB_Garamond_1490473833.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Droid Serif
                                            </span>
                                            <a data-ff="font98" href="#" title="Droid Serif">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Droid_Serif_1490473835.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bangers
                                            </span>
                                            <a data-ff="font99" href="#" title="Bangers">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Bangers_1490473837.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Pacifico
                                            </span>
                                            <a data-ff="font100" href="#" title="Pacifico">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Pacifico_1490473839.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Luckiest Guy
                                            </span>
                                            <a data-ff="font101" href="#" title="Luckiest Guy">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Luckiest_Guy_1490473840.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Courgette
                                            </span>
                                            <a data-ff="font102" href="#" title="Courgette">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Courgette_1490473843.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Over the Rainbow
                                            </span>
                                            <a data-ff="font103" href="#" title="Over the Rainbow">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Over_the_Rainbow_1490473844.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Nothing You Could Do
                                            </span>
                                            <a data-ff="font104" href="#" title="Nothing You Could Do">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Nothing_You_Could_Do_1490473846.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Titillium Web
                                            </span>
                                            <a data-ff="font105" href="#" title="Titillium Web">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Titillium_Web_1490473850.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Share
                                            </span>
                                            <a data-ff="font106" href="#" title="Share">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Share_1490473852.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Crimson Text
                                            </span>
                                            <a data-ff="font107" href="#" title="Crimson Text">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Crimson_Text_1490473853.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Squada One
                                            </span>
                                            <a data-ff="font108" href="#" title="Squada One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Squada_One_1490473856.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Carter One
                                            </span>
                                            <a data-ff="font109" href="#" title="Carter One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Carter_One_1490473858.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Wallpoet
                                            </span>
                                            <a data-ff="font110" href="#" title="Wallpoet">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Wallpoet_1490473860.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Spirax
                                            </span>
                                            <a data-ff="font111" href="#" title="Spirax">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Spirax_1490473863.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kavoon
                                            </span>
                                            <a data-ff="font112" href="#" title="Kavoon">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Kavoon_1490473864.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Vollkorn
                                            </span>
                                            <a data-ff="font113" href="#" title="Vollkorn">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Vollkorn_1490473866.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sansita One
                                            </span>
                                            <a data-ff="font114" href="#" title="Sansita One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sansita_One_1490473868.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Noticia Text
                                            </span>
                                            <a data-ff="font115" href="#" title="Noticia Text">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Noticia_Text_1490473870.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Open Sans
                                            </span>
                                            <a data-ff="font117" href="#" title="Open Sans">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Open_Sans_1490473874.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Forum
                                            </span>
                                            <a data-ff="font118" href="#" title="Forum">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Forum_1490473876.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bevan
                                            </span>
                                            <a data-ff="font119" href="#" title="Bevan">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Bevan_1490473878.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Handlee
                                            </span>
                                            <a data-ff="font120" href="#" title="Handlee">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Handlee_1490473879.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Play
                                            </span>
                                            <a data-ff="font121" href="#" title="Play">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Play_1490473881.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Coming Soon
                                            </span>
                                            <a data-ff="font122" href="#" title="Coming Soon">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Coming_Soon_1490473882.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sacramento
                                            </span>
                                            <a data-ff="font123" href="#" title="Sacramento">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sacramento_1490473884.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Oxygen
                                            </span>
                                            <a data-ff="font124" href="#" title="Oxygen">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Oxygen_1490473885.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Lemon
                                            </span>
                                            <a data-ff="font125" href="#" title="Lemon">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Lemon_1490473887.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Homemade Apple
                                            </span>
                                            <a data-ff="font126" href="#" title="Homemade Apple">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Homemade_Apple_1490473888.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Annie Use Your Telescope
                                            </span>
                                            <a data-ff="font127" href="#" title="Annie Use Your Telescope">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Annie_Use_Your_Telescope_1490473890.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Love Ya Like A Sister
                                            </span>
                                            <a data-ff="font128" href="#" title="Love Ya Like A Sister">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Love_Ya_Like_A_Sister_1490473893.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Allan
                                            </span>
                                            <a data-ff="font129" href="#" title="Allan">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Allan_1490473896.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Patua One
                                            </span>
                                            <a data-ff="font130" href="#" title="Patua One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Patua_One_1490473897.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Dancing Script
                                            </span>
                                            <a data-ff="font131" href="#" title="Dancing Script">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Dancing_Script_1490473899.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Slackey
                                            </span>
                                            <a data-ff="font132" href="#" title="Slackey">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Slackey_1490473901.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Covered By Your Grace
                                            </span>
                                            <a data-ff="font133" href="#" title="Covered By Your Grace">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Covered_By_Your_Grace_1490473904.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Griffy
                                            </span>
                                            <a data-ff="font134" href="#" title="Griffy">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Griffy_1490473907.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Indie Flower
                                            </span>
                                            <a data-ff="font135" href="#" title="Indie Flower">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Indie_Flower_1490473908.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Ceviche One
                                            </span>
                                            <a data-ff="font136" href="#" title="Ceviche One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Ceviche_One_1490473909.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bree Serif
                                            </span>
                                            <a data-ff="font137" href="#" title="Bree Serif">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Bree_Serif_1490473912.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Comfortaa
                                            </span>
                                            <a data-ff="font138" href="#" title="Comfortaa">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Comfortaa_1490473913.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cuprum
                                            </span>
                                            <a data-ff="font139" href="#" title="Cuprum">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cuprum_1490473916.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Coda
                                            </span>
                                            <a data-ff="font140" href="#" title="Coda">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Coda_1490473917.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Nunito
                                            </span>
                                            <a data-ff="font141" href="#" title="Nunito">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Nunito_1490473918.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Gruppo
                                            </span>
                                            <a data-ff="font142" href="#" title="Gruppo">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Gruppo_1490473920.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Chewy
                                            </span>
                                            <a data-ff="font143" href="#" title="Chewy">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Chewy_1490473921.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Audiowide
                                            </span>
                                            <a data-ff="font144" href="#" title="Audiowide">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Audiowide_1490473923.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sanchez
                                            </span>
                                            <a data-ff="font145" href="#" title="Sanchez">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sanchez_1490473925.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kaushan Script
                                            </span>
                                            <a data-ff="font146" href="#" title="Kaushan Script">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Kaushan_Script_1490473927.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Leckerli One
                                            </span>
                                            <a data-ff="font147" href="#" title="Leckerli One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Leckerli_One_1490473929.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Merriweather
                                            </span>
                                            <a data-ff="font148" href="#" title="Merriweather">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Merriweather_1490473931.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Signika
                                            </span>
                                            <a data-ff="font149" href="#" title="Signika">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Signika_1490473934.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Damion
                                            </span>
                                            <a data-ff="font150" href="#" title="Damion">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Damion_1490473935.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Roboto Condensed
                                            </span>
                                            <a data-ff="font151" href="#" title="Roboto Condensed">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Roboto_Condensed_1490473936.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kranky
                                            </span>
                                            <a data-ff="font152" href="#" title="Kranky">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Kranky_1490473940.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Metamorphous
                                            </span>
                                            <a data-ff="font153" href="#" title="Metamorphous">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Metamorphous_1490473941.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Inconsolata
                                            </span>
                                            <a data-ff="font154" href="#" title="Inconsolata">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Inconsolata_1490473944.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Anonymous Pro
                                            </span>
                                            <a data-ff="font155" href="#" title="Anonymous Pro">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Anonymous_Pro_1490473947.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Lusitana
                                            </span>
                                            <a data-ff="font156" href="#" title="Lusitana">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Lusitana_1490473950.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Yanone Kaffeesatz
                                            </span>
                                            <a data-ff="font157" href="#" title="Yanone Kaffeesatz">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Yanone_Kaffeesatz_1490473952.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Archivo Narrow
                                            </span>
                                            <a data-ff="font158" href="#" title="Archivo Narrow">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Archivo_Narrow_1490473955.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Alegreya
                                            </span>
                                            <a data-ff="font159" href="#" title="Alegreya">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Alegreya_1490473958.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Nova Square
                                            </span>
                                            <a data-ff="font162" href="#" title="Nova Square">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Nova_Square_1490473963.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Righteous
                                            </span>
                                            <a data-ff="font163" href="#" title="Righteous">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Righteous_1490473966.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Passion One
                                            </span>
                                            <a data-ff="font165" href="#" title="Passion One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Passion_One_1490473969.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Iceland
                                            </span>
                                            <a data-ff="font166" href="#" title="Iceland">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Iceland_1490473972.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Rochester
                                            </span>
                                            <a data-ff="font167" href="#" title="Rochester">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Rochester_1490473973.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Amatic SC
                                            </span>
                                            <a data-ff="font168" href="#" title="Amatic SC">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Amatic_SC_1490473974.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Changa One
                                            </span>
                                            <a data-ff="font169" href="#" title="Changa One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Changa_One_1490473976.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Loved by the King
                                            </span>
                                            <a data-ff="font170" href="#" title="Loved by the King">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Loved_by_the_King_1490473978.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Delius
                                            </span>
                                            <a data-ff="font171" href="#" title="Delius">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Delius_1490473980.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Satisfy
                                            </span>
                                            <a data-ff="font172" href="#" title="Satisfy">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Satisfy_1490473981.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Black Ops One
                                            </span>
                                            <a data-ff="font173" href="#" title="Black Ops One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Black_Ops_One_1490473982.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Salsa
                                            </span>
                                            <a data-ff="font174" href="#" title="Salsa">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Salsa_1490473985.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Roboto Slab
                                            </span>
                                            <a data-ff="font175" href="#" title="Roboto Slab">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Roboto_Slab_1490473986.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Rancho
                                            </span>
                                            <a data-ff="font176" href="#" title="Rancho">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Rancho_1490473988.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                VT323
                                            </span>
                                            <a data-ff="font177" href="#" title="VT323">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/VT323_1490473990.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cookie
                                            </span>
                                            <a data-ff="font178" href="#" title="Cookie">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cookie_1490473991.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Shadows Into Light Two
                                            </span>
                                            <a data-ff="font179" href="#" title="Shadows Into Light Two">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Shadows_Into_Light_Two_1490473992.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Fjalla One
                                            </span>
                                            <a data-ff="font180" href="#" title="Fjalla One">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Fjalla_One_1490473995.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Rock Salt
                                            </span>
                                            <a data-ff="font181" href="#" title="Rock Salt">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Rock_Salt_1490473996.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Roboto
                                            </span>
                                            <a data-ff="font182" href="#" title="Roboto">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Roboto_1490473998.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Architects Daughter
                                            </span>
                                            <a data-ff="font184" href="#" title="Architects Daughter">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Architects_Daughter_1490474002.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Freckle Face
                                            </span>
                                            <a data-ff="font185" href="#" title="Freckle Face">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Freckle_Face_1490474004.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Oswald
                                            </span>
                                            <a data-ff="font186" href="#" title="Oswald">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Oswald_1490474007.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Playball
                                            </span>
                                            <a data-ff="font187" href="#" title="Playball">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Playball_1490474008.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Special Elite
                                            </span>
                                            <a data-ff="font188" href="#" title="Special Elite">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Special_Elite_1490474009.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Montserrat
                                            </span>
                                            <a data-ff="font189" href="#" title="Montserrat">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Montserrat_1490474012.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Raleway
                                            </span>
                                            <a data-ff="font190" href="#" title="Raleway">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Raleway_1490474014.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Abril Fatface
                                            </span>
                                            <a data-ff="font191" href="#" title="Abril Fatface">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Abril_Fatface_1490474016.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Playfair Display SC
                                            </span>
                                            <a data-ff="font192" href="#" title="Playfair Display SC">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Playfair_Display_SC_1490474018.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Berkshire Swash
                                            </span>
                                            <a data-ff="font193" href="#" title="Berkshire Swash">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Berkshire_Swash_1490474022.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Old Standard TT
                                            </span>
                                            <a data-ff="font194" href="#" title="Old Standard TT">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Old_Standard_TT_1490474025.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Pinyon Script
                                            </span>
                                            <a data-ff="font195" href="#" title="Pinyon Script">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Pinyon_Script_1490474029.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Lobster Two
                                            </span>
                                            <a data-ff="font196" href="#" title="Lobster Two">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Lobster_Two_1490474031.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Mountains of Christmas
                                            </span>
                                            <a data-ff="font197" href="#" title="Mountains of Christmas">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Mountains_of_Christmas_1490474033.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Boogaloo
                                            </span>
                                            <a data-ff="font198" href="#" title="Boogaloo">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Boogaloo_1490474036.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Monsieur La Doulaise
                                            </span>
                                            <a data-ff="font199" href="#" title="Monsieur La Doulaise">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Monsieur_La_Doulaise_1490474037.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Citadel
                                            </span>
                                            <a data-ff="font201" href="#" title="Citadel">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Citadel_1490505636.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Copperplate
                                            </span>
                                            <a data-ff="font202" href="#" title="Copperplate">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Copperplate_1490478312.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Edwardian Script ITC
                                            </span>
                                            <a data-ff="font203" href="#" title="Edwardian Script ITC">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Edwardian_Script_ITC_1490478303.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Open Sans Light
                                            </span>
                                            <a data-ff="font210" href="#" title="Open Sans Light">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Open_Sans_Light_1490536270.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cinzel
                                            </span>
                                            <a data-ff="font319" href="#" title="Cinzel">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cinzel_1493256758.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Beau
                                            </span>
                                            <a data-ff="font24172" href="#" title="Beau">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Beautiful_Friday_03_1538337382.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Adele
                                            </span>
                                            <a data-ff="font24173" href="#" title="Adele">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Adelicia_Script_1538383463.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Miracle
                                            </span>
                                            <a data-ff="font24240" href="#" title="Miracle">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Madina_Script_1538383514.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Florentina
                                            </span>
                                            <a data-ff="font24248" href="#" title="Florentina">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Fitri_1538387457.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Britney
                                            </span>
                                            <a data-ff="font24278" href="#" title="Britney">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Braveheart_1538400485.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Floristic
                                            </span>
                                            <a data-ff="font24279" href="#" title="Floristic">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Isabella_1538400518.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Chili
                                            </span>
                                            <a data-ff="font24283" href="#" title="Chili">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/BrideChalk__Sans_1538407599.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Ginger
                                            </span>
                                            <a data-ff="font24284" href="#" title="Ginger">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Husna_1538407918.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Wed
                                            </span>
                                            <a data-ff="font24424" href="#" title="Wed">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Farmhouse_1538476717.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Maldives
                                            </span>
                                            <a data-ff="font24425" href="#" title="Maldives">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Malisia_Script_1538476810.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cinzel Regular
                                            </span>
                                            <a data-ff="font24427" href="#" title="Cinzel Regular">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cinzel_1538479153.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Extras 1
                                            </span>
                                            <a data-ff="font24433" href="#" title="Extras 1">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Mellisa_Extras_1538495752.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Extras 2
                                            </span>
                                            <a data-ff="font24434" href="#" title="Extras 2">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/valent_ornament_1538495801.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sanya
                                            </span>
                                            <a data-ff="font24442" href="#" title="Sanya">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Love_Hewits_1538501349.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Barilla
                                            </span>
                                            <a data-ff="font24875" href="#" title="Barilla">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Arillyoni_1538694168.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Delta
                                            </span>
                                            <a data-ff="font24876" href="#" title="Delta">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/PerfectCharm1_1538694263.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Arita
                                            </span>
                                            <a data-ff="font24877" href="#" title="Arita">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Mustica_Script_1538694306.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Glam
                                            </span>
                                            <a data-ff="font24878" href="#" title="Glam">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Miss_Couture_1538694342.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Gigi
                                            </span>
                                            <a data-ff="font25018" href="#" title="Gigi">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Spring_Market_ALP_1538916662.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Plain
                                            </span>
                                            <a data-ff="font25035" href="#" title="Plain">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sakkal_Majalla_1538937389.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kids font
                                            </span>
                                            <a data-ff="font25102" href="#" title="Kids font">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Starlight_1539031267.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Loving
                                            </span>
                                            <a data-ff="font25103" href="#" title="Loving">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Stardust_1539031302.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Wed calligraphy
                                            </span>
                                            <a data-ff="font25104" href="#" title="Wed calligraphy">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Virmigo_script_1539031356.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Ornament1
                                            </span>
                                            <a data-ff="font25105" href="#" title="Ornament1">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Virmigo_Sans_Flourish_1539031505.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Anna
                                            </span>
                                            <a data-ff="font25188" href="#" title="Anna">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Blooming_Elegant_1539107107.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kathy
                                            </span>
                                            <a data-ff="font25189" href="#" title="Kathy">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Cathiy_Betiey_1539107171.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Dorothy
                                            </span>
                                            <a data-ff="font25190" href="#" title="Dorothy">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Daughter_Script_1539107235.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Wed 2
                                            </span>
                                            <a data-ff="font25191" href="#" title="Wed 2">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sophia_EXT_Medium_1539107417.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                martha
                                            </span>
                                            <a data-ff="font25192" href="#" title="martha">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Siediffa_Script_1539107466.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bri
                                            </span>
                                            <a data-ff="font25280" href="#" title="Bri">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Aurellia_Script_1539177026.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Classic
                                            </span>
                                            <a data-ff="font25287" href="#" title="Classic">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Mozart_Script_Black_1539181886.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Chopin Script
                                            </span>
                                            <a data-ff="font25288" href="#" title="Chopin Script">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Chopin_Script_1539181990.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Mia 1
                                            </span>
                                            <a data-ff="font25934" href="#" title="Mia 1">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Melika_Letter_1539714019.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Mia 2
                                            </span>
                                            <a data-ff="font25935" href="#" title="Mia 2">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Melika_Letter_A_1539714379.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Mia 3
                                            </span>
                                            <a data-ff="font25936" href="#" title="Mia 3">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Melika_Letter_B_1539714393.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Mia 4
                                            </span>
                                            <a data-ff="font25937" href="#" title="Mia 4">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Melika_Letter_C_1539714579.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Mia 5
                                            </span>
                                            <a data-ff="font25938" href="#" title="Mia 5">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Melika_Letter_D_1539714593.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Mia 6
                                            </span>
                                            <a data-ff="font25940" href="#" title="Mia 6">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Melika_letter_E_1539714647.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Eva 1
                                            </span>
                                            <a data-ff="font25941" href="#" title="Eva 1">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Aerials_1539714809.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Eva 2
                                            </span>
                                            <a data-ff="font25945" href="#" title="Eva 2">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Aerials_Stylistic_One_1539715774.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Eva 3
                                            </span>
                                            <a data-ff="font25946" href="#" title="Eva 3">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Aerials_Stylistic_Two_1539715970.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sarah 1
                                            </span>
                                            <a data-ff="font25947" href="#" title="Sarah 1">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sadhira_ALT_001_1539716008.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sarah 2
                                            </span>
                                            <a data-ff="font25948" href="#" title="Sarah 2">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sadhira_Script_1539716091.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sarah 3
                                            </span>
                                            <a data-ff="font25949" href="#" title="Sarah 3">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sadhira_ALT_003_1539716116.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Sarah 4
                                            </span>
                                            <a data-ff="font25950" href="#" title="Sarah 4">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sadhira_ALT_004_1539716168.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Extras
                                            </span>
                                            <a data-ff="font26287" href="#" title="Extras">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/AutumnEmbrace_Extras_1539901957.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Savanna
                                            </span>
                                            <a data-ff="font26313" href="#" title="Savanna">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Still_Shine_1539934216.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Aria
                                            </span>
                                            <a data-ff="font26394" href="#" title="Aria">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Aidan_1540045309.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Extra 3
                                            </span>
                                            <a data-ff="font26395" href="#" title="Extra 3">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Aidan_Ornaments_1540045459.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Dorothy 2
                                            </span>
                                            <a data-ff="font26419" href="#" title="Dorothy 2">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Daughter_Script_Alt_1540120188.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Extra 5
                                            </span>
                                            <a data-ff="font26430" href="#" title="Extra 5">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Ditto_Dingbats_1540140952.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Extra 4
                                            </span>
                                            <a data-ff="font26431" href="#" title="Extra 4">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Daughter_Flourish_1540141005.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Extra 6
                                            </span>
                                            <a data-ff="font26432" href="#" title="Extra 6">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/chalisto_Extras_1540141045.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Alicia
                                            </span>
                                            <a data-ff="font26748" href="#" title="Alicia">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Adora_Bouton_1540419629.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Classic 2
                                            </span>
                                            <a data-ff="font26903" href="#" title="Classic 2">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Shaqila_1540498056.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Magnolia
                                            </span>
                                            <a data-ff="font27571" href="#" title="Magnolia">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Bottomline_1540839830.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bye bye
                                            </span>
                                            <a data-ff="font28140" href="#" title="Bye bye">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Amapola_Script_1541338335.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Bye bye1
                                            </span>
                                            <a data-ff="font28142" href="#" title="Bye bye1">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Amapola_Alternates_1541338389.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Amazing
                                            </span>
                                            <a data-ff="font28143" href="#" title="Amazing">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Amberlight_1541338422.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Amazing 1
                                            </span>
                                            <a data-ff="font28144" href="#" title="Amazing 1">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Amberlight_swash_1541338479.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Cinnamon
                                            </span>
                                            <a data-ff="font28382" href="#" title="Cinnamon">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Chalisto_Script_1541571546.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Edem
                                            </span>
                                            <a data-ff="font29674" href="#" title="Edem">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Edelweis_Script_1542923281.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Alegreya Sans SC Thin
                                            </span>
                                            <a data-ff="font29693" href="#" title="Alegreya Sans SC Thin">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Alegreya_Sans_SC_Thin_1542982618.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Ava
                                            </span>
                                            <a data-ff="font29768" href="#" title="Ava">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Azalea_1543144481.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                XBC 1
                                            </span>
                                            <a data-ff="font30357" href="#" title="XBC 1">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/AngieMakes_Blacksheep_Regular_1543838904.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Xbc 2
                                            </span>
                                            <a data-ff="font30358" href="#" title="Xbc 2">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/AngieMakes_Dahlia_Darling_1543838898.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                XBC 3
                                            </span>
                                            <a data-ff="font30359" href="#" title="XBC 3">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/AngieMakes_Claphands_1543838888.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Xbc 4
                                            </span>
                                            <a data-ff="font30360" href="#" title="Xbc 4">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/AngieMakes_Helsinki_1543838969.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Xbc 5
                                            </span>
                                            <a data-ff="font30361" href="#" title="Xbc 5">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/AngieMakes_Shippey_1543839051.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                XBC 6
                                            </span>
                                            <a data-ff="font30362" href="#" title="XBC 6">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/AngieMakes_Hoodwink_1543839110.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                XBC 8
                                            </span>
                                            <a data-ff="font30363" href="#" title="XBC 8">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Strawberry_1543839304.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Jennifer
                                            </span>
                                            <a data-ff="font31359" href="#" title="Jennifer">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Crystal_Sky_1544968200.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Britney
                                            </span>
                                            <a data-ff="font37178" href="#" title="Britney">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Barracuda_Script_1549792851.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Mimosa
                                            </span>
                                            <a data-ff="font38185" href="#" title="Mimosa">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/paradise_1550317071.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Kids Caps
                                            </span>
                                            <a data-ff="font38186" href="#" title="Kids Caps">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Panda_Tired_Caps_1550317083.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Nora
                                            </span>
                                            <a data-ff="font38206" href="#" title="Nora">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Nouradilla_1550329998.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Funny kids
                                            </span>
                                            <a data-ff="font38862" href="#" title="Funny kids">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Sweet_Mia_1550844867.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Amelia
                                            </span>
                                            <a data-ff="font38952" href="#" title="Amelia">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Olive_Sky_1550918525.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                Move font
                                            </span>
                                            <a data-ff="font38953" href="#" title="Move font">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/Mountains_Brush_Script_1550921106.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                girlish
                                            </span>
                                            <a data-ff="font38954" href="#" title="girlish">
                                                <img class="font-thumb" src="{{ asset('design/font_thumbs/hey_girl_1550921159.png') }}" loading="lazy"/>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <a class="btn btn-default" href="#" id="showObSymbolsPanel" style="width: 40px; padding: 8px 0px;" title="Show Glyphs Panel">
                                    <img height="16" src="{{ asset('assets/img/glyphs.svg') }}"/>
                                </a>
                                <div class="input-group" style="display:inline-block;vertical-align: middle;">
                                    <input class="fontinput form-control" id="fontsize" max="100" min="0" name="fontsize" style="width:52px; display:inline-block; height:36px; border-color: #d1d1d1; border-width: 1px;" type="text" value="6">
                                        <div class="input-group-btn" style="display:inline;">
                                            <button class="btn btn-default fzbutton-container dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" id="fzbutton" style="padding:2px; height:36px; border-color: #d1d1d1;" title="Font Size">
                                                <i class="fa fa fa-caret-up fzbutton" id="fontsizeInc" style="display:block;">
                                                </i>
                                                <i class="fa fa-caret-down fzbutton" id="fontsizeDec" style="display:block;">
                                                </i>
                                            </button>
                                            <ul class="dropdown-menu font-size-dropdown" id="font-size-dropdown">
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        6
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        8
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        10
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        12
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        14
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        16
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        18
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        20
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        22
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        24
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        26
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        28
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        30
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        36
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        48
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        60
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        72
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        96
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        120
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        144
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </input>
                                </div>
                            </span>
                            <div class="btn-group colorSelectorBox single">
                                <div class="btn-group patternFillGroup dropdow dpattern-holder" id="patternFillGroup">
                                    <div class="wrapper">
                                        <button class="btn btn-default dropdown-toggle patternFillLabel" id="patternFillLabel" type="button">
                                            <div class="patternFillPreview">
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <a class="btn btn-default" href="javascript:void(0);" id="colorSelector" style="padding: 17px 19px;" title="Fill Color Picker">
                                </a>
                                <a class="btn btn-default" href="javascript:void(0);" id="colorSelector2" style="padding: 17px 19px;" title="Fill Color Picker">
                                </a>
                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="filltype" style="padding-right: 1px; padding-left:1px;" type="button">
                                    <span class="caret">
                                    </span>
                                    <span class="sr-only">
                                        Toggle Dropdown
                                    </span>
                                </button>
                                <ul class="dropdown-menu fill-type-dropdown">
                                    <li>
                                        <a class="color-fill fill-type tools-top active" href="#" id="color-fill" title="Color Fill">
                                            <i class="fa fa-check">
                                            </i>
                                            Color Fill
                                        </a>
                                    </li>
                                    <li>
                                        <a class="pattern-fill fill-type tools-top" href="#" id="pattern-fill" style="display:none;" title="Pattern Fill">
                                            <i class="fa fa-check">
                                            </i>
                                            Pattern Fill
                                        </a>
                                    </li>
                                    <li>
                                        <a class="linear-gradient-h-fill fill-type tools-top" href="#" id="linear-gradient-h-fill" title="Horizontal Gradient">
                                            <i class="fa fa-check">
                                            </i>
                                            Horizontal Gradient
                                        </a>
                                    </li>
                                    <li>
                                        <a class="linear-gradient-v-fill fill-type tools-top" href="#" id="linear-gradient-v-fill" title="Vertical Gradient">
                                            <i class="fa fa-check">
                                            </i>
                                            Vertical Gradient
                                        </a>
                                    </li>
                                    <li>
                                        <a class="linear-gradient-d-fill fill-type tools-top" href="#" id="linear-gradient-d-fill" title="Diagonal Gradient">
                                            <i class="fa fa-check">
                                            </i>
                                            Diagonal Gradient
                                        </a>
                                    </li>
                                    <li>
                                        <a class="radial-gradient-fill fill-type tools-top" href="#" id="radial-gradient-fill" title="Radial Gradient">
                                            <i class="fa fa-check">
                                            </i>
                                            Radial Gradient
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="btn btn-default" href="#" id="showColors" title="Show Colors">
                                <span class="color-0">
                                </span>
                                <span class="color-1">
                                </span>
                                <span class="color-2">
                                </span>
                                <span class="color-3">
                                </span>
                            </a>
                            <span id="dynamiccolorpickers">
                            </span>
                            <div class="btn-group" id="strokegroup">
                                <a class="btn btn-default" href="javascript:void(0);" id="colorStrokeSelector" style="padding: 2px 6px 2px 5px;" title="Stroke Color Picker">
                                    <i class="fa" style="font-size: 30px;color: #fff;">
                                        ▣
                                    </i>
                                </a>
                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="strokedropdown" style="padding-right: 1px; padding-left:1px;" type="button">
                                    <span class="caret">
                                    </span>
                                    <span class="sr-only">
                                        Toggle Dropdown
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="tools-top" href="javascript:void(0);" id="objectstrokewidth" title="Stroke Width">
                                            <i class="fa fa-minus">
                                            </i>
                                            Stroke Width
                                        </a>
                                    </li>
                                    <input data-slider-id="strokewidthSlider" data-slider-max="30" data-slider-min="0.5" data-slider-step="0.1" data-slider-value="1" id="changestrokewidth" type="text"/>
                                </ul>
                            </div>
                            <div aria-label="..." class="btn-group textelebtns" id="textstylebtns" role="group">
                                <a class="btn btn-default textelebtns" href="javascript:void(0);" id="fontbold" title="Faux Bold">
                                    <i class="fa fa-bold">
                                    </i>
                                </a>
                                <a class="btn btn-default textelebtns" href="javascript:void(0);" id="fontitalic" title="Faux Italic">
                                    <i class="fa fa-italic">
                                    </i>
                                </a>
                                <a class="btn btn-default textelebtns" href="javascript:void(0);" id="fontunderline" title="Underline">
                                    <i class="fa fa-underline">
                                    </i>
                                </a>
                            </div>
                            <div aria-label="..." class="btn-group" id="alignbtns" role="group">
                                <a class="btn btn-default" href="javascript:void(0);" id="objectalignleft" title="Align left">
                                    <i class="fa fa-align-left">
                                    </i>
                                </a>
                                <a class="btn btn-default" href="javascript:void(0);" id="objectaligncenter" title="Align center">
                                    <i class="fa fa-align-center">
                                    </i>
                                </a>
                                <a class="btn btn-default" href="javascript:void(0);" id="objectalignright" title="Align right">
                                    <i class="fa fa-align-right">
                                    </i>
                                </a>
                            </div>
                            <a class="btn btn-default" href="javascript:void(0);" id="clone" title="Clone Object">
                                <img height="16" src="{{ asset('assets/img/clone.svg') }}"/>
                            </a>
                            <div class="btn-group bringforward">
                                <a class="btn btn-default" href="javascript:void(0);" id="bringforward" style="width: 34px;padding: 8px 0px;" title="Bring Forward">
                                    <img height="16" src="{{ asset('assets/img/bring-forward.svg') }}"/>
                                </a>
                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="btfdropdown" style="padding-right: 1px; padding-left:1px;" type="button">
                                    <span class="caret">
                                    </span>
                                    <span class="sr-only">
                                        Toggle Dropdown
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="tools-top" href="javascript:void(0);" id="bringtofront" title="Bring To Front">
                                            Bring To Front
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group sendbackward">
                                <a class="btn btn-default" href="javascript:void(0);" id="sendbackward" style="width: 34px;padding: 8px 0px;" title="Send Backward">
                                    <img height="16" src="{{ asset('assets/img/send-backward.svg') }}"/>
                                </a>
                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="stbdropdown" style="padding-right: 1px; padding-left:1px;" type="button">
                                    <span class="caret">
                                    </span>
                                    <span class="sr-only">
                                        Toggle Dropdown
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="tools-top" href="javascript:void(0);" id="sendtoback" title="Send To Back">
                                            Send To Back
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a class="btn btn-default" href="javascript:void(0);" id="group" style="width:42px;" title="Group Objects">
                                <!-- <i class="fa fa-object-group">
                                </i> -->
                                <img height="16" src="{{ asset('assets/img/group.svg') }}"/>
                            </a>
                            <a class="btn btn-default" href="javascript:void(0);" id="ungroup" style="width:42px;" title="Ungroup Objects">
                                <i class="fa fa-object-ungroup">
                                </i>
                            </a>
                            <div class="btn-group" id="shadowGroup">
                                <a aria-expanded="false" class="btn btn-default dropdown-toggle" data-target="#" href="#" id="shadowLabel">
                                    <img height="16" src="{{ asset('assets/img/shadow.svg') }}"/>
                                </a>
                                <ul aria-labelledby="shadowLabel" class="dropdown-menu" id="shadowTabs" role="menu" style="max-height: calc(80vh); overflow-y: auto;">
                                    <div class="row" style="padding: 1px 10px; background:#ededed; margin:0px;">
                                        <div class="col-xs-6">
                                            <h4>
                                                Shadow
                                            </h4>
                                        </div>
                                        <div class="col-xs-6" style="padding: 5px 20px;">
                                            <div class="switch-button switch-button-sm pull-right">
                                                <input id="shadowSwitch" name="shadowSwitch" type="checkbox">
                                                    <span>
                                                        <label for="shadowSwitch">
                                                        </label>
                                                    </span>
                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a data-toggle="tab" href="#appearance">
                                                Appearance
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#color">
                                                Color
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content" style="margin-bottom:0px;">
                                        <div class="tab-pane active" id="appearance">
                                            <label>
                                                Blur
                                            </label>
                                            <input data-slider-id="blurSlider" data-slider-max="50" data-slider-min="0" data-slider-step="1" data-slider-value="5" id="changeBlur" type="text"/>
                                            <label>
                                                Horizontal Offset
                                            </label>
                                            <input data-slider-id="hoffsetSlider" data-slider-max="20" data-slider-min="-20" data-slider-step="1" data-slider-value="5" id="changeHOffset" type="text"/>
                                            <label>
                                                Vertical Offset
                                            </label>
                                            <input data-slider-id="voffsetSlider" data-slider-max="20" data-slider-min="-20" data-slider-step="1" data-slider-value="5" id="changeVOffset" type="text"/>
                                        </div>
                                        <div class="tab-pane" id="color">
                                            <input id="shadowColor" type="text"/>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            <a class="btn btn-danger" href="javascript:void(0);" id="deleteitem" title="Delete Selected Item">
                                <i class="fa fa-trash-o">
                                </i>
                            </a>
                            <div class="btn-group" id="showmoreoptions" style="display:inline-block;">
                                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" id="showmore" title="Show More Tools">
                                    <span class="caret">
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="more textelebtns noclose" href="javascript:void(0);" id="textcase" title="Text Case">
                                            <i class="fa fa-font">
                                            </i>
                                            Text Case
                                        </a>
                                    </li>
                                    <li>
                                        <a class="more textelebtns" href="javascript:void(0);" id="textuppercase" style="text-transform: uppercase;" title="UPPERCASE">
                                            uppercase
                                        </a>
                                    </li>
                                    <li>
                                        <a class="more textelebtns" href="javascript:void(0);" id="textlowercase" style="text-transform: lowercase;" title="lowercase">
                                            lowercase
                                        </a>
                                    </li>
                                    <li>
                                        <a class="more textelebtns" href="javascript:void(0);" id="textcapitalize" style="text-transform: capitalize;" title="Capitalize">
                                            capitalize
                                        </a>
                                    </li>
                                    <li>
                                        <a class="more textelebtns noclose" href="javascript:void(0);" id="lineheight" title="Line Height">
                                            <img src="{{ asset('assets/img/lineheight.svg') }}" width="14">
                                                Line height
                                            </img>
                                        </a>
                                    </li>
                                    <input data-slider-id="lineheightSlider" data-slider-max="5" data-slider-min="0.5" data-slider-step="0.1" data-slider-value="1" id="changelineheight" type="text"/>
                                    <li>
                                        <a class="more textelebtns noclose" href="javascript:void(0);" id="charspacing" title="Char Spacing">
                                            <i class="fa fa-text-width">
                                            </i>
                                            Char Spacing
                                        </a>
                                    </li>
                                    <input data-slider-id="charspacingSlider" data-slider-max="10" data-slider-min="-5" data-slider-step="0.1" data-slider-value="0" id="changecharspacing" type="text"/>
                                    <!--
                                        <li><a href="javascript:void(0);" id="horizcenterindent" title="Horizontal center Indent" class="more" ><span class="glyphicon glyphicon-option-horizontal"></span> Align Horizontal Center</a></li>
                                        <li><a href="javascript:void(0);" id="verticenterindent" title="Vertical center Indent" class="more" ><span class="glyphicon glyphicon-option-vertical"></span> Align Vertical Center</a></li>
                                        <li><a href="javascript:void(0);" id="leftindent" title="Left Align" class="more" ><span class="glyphicon glyphicon-arrow-left"></span> Align To Left</a></li>
                                        <li><a href="javascript:void(0);" id="rightindent" title="Right Align" class="more" ><span class="glyphicon glyphicon-arrow-right"></span> Align To Right</a></li>
                                    -->
                                    <li>
                                        <a class="more" href="javascript:void(0);" id="objectfliphorizontal" title="Flip Horizontally">
                                            <img src="{{ asset('assets/img/fliphorizontally.png') }}" width="14">
                                                Flip Horizontally
                                            </img>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="more" href="javascript:void(0);" id="objectflipvertical" title="Flip Vertically">
                                            <img src="{{ asset('assets/img/flipvertically.png') }}" width="14">
                                                Flip Vertically
                                            </img>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="more" href="javascript:void(0);" id="objectlock" title="Lock Object Position">
                                            <i class="fa fa-lock">
                                            </i>
                                            Lock Position
                                        </a>
                                    </li>
                                    <li>
                                        <a class="more noclose" href="javascript:void(0);" id="objectopacity" title="Opacity">
                                            <img src="{{ asset('assets/img/opacity.svg') }}" width="13">
                                                Opacity
                                            </img>
                                        </a>
                                    </li>
                                    <input data-slider-id="opacitySlider" data-slider-max="1" data-slider-min="0.1" data-slider-step=".1" data-slider-value="1" id="changeopacity" type="text"/>
                                    <li>
                                        <a class="more noclose" href="javascript:void(0);" id="objectborderwh" title="Border Width">
                                            <i class="fa fa-square-o">
                                            </i>
                                            Border Size
                                        </a>
                                    </li>
                                    <input data-slider-id="borderwhSlider" data-slider-max="1" data-slider-min="0.125" data-slider-step="0.125" data-slider-value="0.25" id="changeborderwh" type="text"/>
                                    <li>
                                        <a class="more" href="javascript:void(0);" id="addremovestroke" title="Stroke">
                                            <i class="fa" style="font-size: 18px;">
                                                ▣
                                            </i>
                                            Add Stroke
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end -->
                    <ul class="zoom-control">
                        <li class="parent">
                            <a href="javascript:void(0);">
                                <i class="icon s7-expand1" id="btnFitToScreen" style="margin-right:5px;" title="Fit to screen">
                                </i>
                            </a>
                        </li>
                        <li class="parent">
                            <a href="javascript:void(0);">
                                <i class="icon s7-less" id="btnZoomOut" title="Zoom Out">
                                </i>
                            </a>
                        </li>
                        <li class="parent" style="text-align:center;background:none;">
                            <span class="btn" data-scalevalue="1" id="zoomperc" style="color:#000; font-size:16px; padding:0px 5px;font-weight: 100;margin-bottom: 5px;" title="Cick to zoom to 100%">
                                100%
                            </span>
                        </li>
                        <li class="parent">
                            <a href="javascript:void(0);">
                                <i class="icon s7-plus" id="btnZoomIn" title="Zoom In">
                                </i>
                            </a>
                        </li>
                    </ul>
                    <img id="choose-img" src="{{ asset('assets/img/choose-a-template.png') }}"/>
                    <div style="display: inline-block; text-align:center; padding: 0 70px;">
                        <img id="phone" src="{{ asset('assets/img/wayak-phone-background-2.png') }}" style="display: none; left: 50%; position: absolute; transform-origin: 0 0; opacity: .5;" loading="lazy"/>
                        <div align="center" id="canvasbox-tab" style="margin-top:40px; text-align: -webkit-center; display: inline-block;">
                            <span id="infotext" style="font-size: 10px; opacity: 0.8; position: relative; left: 0px; top: 0px; z-index: 1000;">
                            </span>
                            <div id="canvaspages" style="outline:none;" tabindex="0">
                                <div class="page" id="page0">
                                </div>
                            </div>
                            <!--
                                  <div id='divcanvas0' class="divcanvas" onClick='javascript:selectCanvas(this.id);'>
                                  </div>
                              -->
                            <div style="display:none; float:right; margin-top: -240px; margin-right: 112px; color:#ffffff;">
                                <span aria-hidden="true" class="pagenumber" id="pagenumber">
                                </span>
                                <br>
                                    <br>
                                        <span aria-hidden="true" class="s7-copy-file duplicatecanvas" id="duplicatecanvas" title="Duplicar esta pagina">
                                        </span>
                                        <br>
                                            <br>
                                                <span class="s7-trash deletecanvas" id="deletecanvas" title="Borrar esta">
                                                </span>
                                                <span class="s7-angle-right-circle background-arrow background-arrow-right" onclick="nextBackground()" title="Preview backgrounds">
                                                </span>
                                                <span class="s7-angle-left-circle background-arrow background-arrow-left" onclick="prevBackground()" title="Preview backgrounds">
                                                </span>
                                            </br>
                                        </br>
                                    </br>
                                </br>
                            </div>
                            <button class="btn btn-default" id="addnewpagebutton" onclick="javascript:addNewCanvasPage();" style="width:150px; margin:20px 0;" type="button">
                                + Agregar pagina en blanco
                            </button>
                            <!--<button onClick='javascript:toSVG();' id="tosvgbtn" class="btn" type="button" style="width:150px; margin:20px 0; padding:10px; border:1px solid #555;"> + Check SVG</button>-->
                            <div style="display:none;">
                                <canvas class="canvas" height="600" id="outputcanvas" width="750">
                                </canvas>
                            </div>
                            <div style="display:none;">
                                <canvas class="canvas" height="100" id="tempcanvas" width="100">
                                </canvas>
                            </div>
                        </div>
                    </div>
                    <div id="pageLimitMessage" style="display:none; margin-top: 20px;">
                        <p>
                            You've reached the max page limit. If you need more pages,
                            <br>
                                please add another template.
                            </br>
                        </p>
                        <button class="btn btn-default" onclick="javascript:showDuplicateTemplateModal();" style="width:175px;" type="button">
                            Add Another Template
                        </button>
                    </div>
                    <div class="rotation_info_block">
                    </div>
                </div>
            </div>
            <!-- End page content -->
            <!-- Duplicate Template Modal HTML -->
            <div class="modal fade" id="duplicateTemplateModal">
                <div class="modal-dialog" style="width:500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title" id="deleteModalTitle">
                                Add Another Template
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p>
                            </p>
                        </div>
                        <div class="modal-footer proceedDuplicateTemplateFooter">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Cancel
                            </button>
                            <button class="btn btn-default" onclick="javascript:duplicateTemplate(this);" type="button">
                                Continue
                            </button>
                        </div>
                        <div class="modal-footer loadDuplicatedTemplateFooter">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                No
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" onclick="javascript:loadTemplate(duplicatedTemplateId);" type="button">
                                Yes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Canvas Size Modal HTML -->
            <div class="modal fade" id="canvasSizeModal" role="dialog" tabindex="-1">
                <div class="modal-dialog" style="width: 300px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Set Template Size
                            </h4>
                        </div>
                        <div class="modal-body">
                            <span class="metric_block">
                                <label for="metric_units">
                                    Units
                                </label>
                                <div class="pull-right">
                                    <div class="am-radio inline" style="padding: 0">
                                        <input checked="" id="metric_units_in" name="metric_units" type="radio" value="in">
                                            <label for="metric_units_in">
                                                in
                                            </label>
                                        </input>
                                    </div>
                                    <div class="am-radio inline" style="padding: 0">
                                        <input id="metric_units_mm" name="metric_units" type="radio" value="mm">
                                            <label for="metric_units_mm">
                                                mm
                                            </label>
                                        </input>
                                    </div>
                                    <div class="am-radio inline" style="padding: 0">
                                        <input id="metric_units_px" name="metric_units" type="radio" value="px">
                                            <label for="metric_units_px">
                                                px
                                            </label>
                                        </input>
                                    </div>
                                </div>
                            </span>
                            <br/>
                            <div class="canvas_size_inches active">
                                <span>
                                    <label for="new_canvas_width">
                                        Template width (in inches):
                                    </label>
                                    <input class="form-control" id="new_canvas_width" name="new_canvas_width" placeholder="Enter Width (in inches)" type="text" value="5">
                                    </input>
                                </span>
                                <br/>
                                <span>
                                    <label for="new_canvas_height">
                                        Template height (in inches):
                                    </label>
                                    <input class="form-control" id="new_canvas_height" name="new_canvas_height" placeholder="Enter Height (in inches)" type="text" value="5">
                                    </input>
                                </span>
                            </div>
                            <div class="canvas_size_pixels">
                                <span>
                                    <label for="new_canvas_width_pixels">
                                        Template width (in pixels):
                                    </label>
                                    <input class="form-control" id="new_canvas_width_pixels" name="new_canvas_width_pixels" placeholder="Enter Width (in pixels)" type="text" value="5">
                                    </input>
                                </span>
                                <br/>
                                <span>
                                    <label for="new_canvas_height_pixels">
                                        Template height (in pixels):
                                    </label>
                                    <input class="form-control" id="new_canvas_height_pixels" name="new_canvas_height_pixels" placeholder="Enter Height (in pixels)" type="text" value="5">
                                    </input>
                                </span>
                            </div>
                            <div class="canvas_size_mm">
                                <span>
                                    <label for="new_canvas_width_mm">
                                        Template width (in millimeters):
                                    </label>
                                    <input class="form-control" id="new_canvas_width_mm" name="new_canvas_width_mm" placeholder="Enter Width" type="text" value="5">
                                    </input>
                                </span>
                                <br>
                                    <span>
                                        <label for="new_canvas_height_mm">
                                            Template height (in millimeters):
                                        </label>
                                        <input class="form-control" id="new_canvas_height_mm" name="new_canvas_height_mm" placeholder="Enter Height" type="text" value="7">
                                        </input>
                                    </span>
                                </br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Cancel
                            </button>
                            <button class="btn btn-primary" data-dismiss="modal" id="changeCanvasSize" type="button">
                                Proceed
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Success Modal HTML -->
            <div class="modal fade" id="successModal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-300">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Success
                            </h4>
                        </div>
                        <div class="modal-body" style="margin-top:-30px; ">
                            <div class="body">
                                <span id="successMessage">
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Alert Modal HTML -->
            <div class="modal fade" id="alertModal" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="responceMessage" style="text-align:center;">
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Delete Modal HTML -->
            <div class="modal fade" id="deleteModal">
                <div class="modal-dialog" style="width:400px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title" id="deleteModalTitle">
                                Delete Template
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p id="deleteModalMessage">
                                Are you sure you want to delete this template?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" id="proceedDelete" type="button">
                                Delete
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Save Template Modal HTML -->
            <div class="modal fade" id="savetemplate_modal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-500">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Save Template
                            </h4>
                        </div>
                        <div class="modal-body" style="margin-top:-30px; ">
                            <div class="body">
                                <div class="form-group">
                                    <label class="control-label">
                                        Tags
                                    </label>
                                    <select class="tags" id="template_tags" multiple="">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="template">
                                        Template Name :
                                    </label>
                                    <input class="form-control" id="templatename" name="templatename" placeholder="Enter Name" type="text">
                                    </input>
                                </div>
                                <div class="form-group" hidden="">
                                    <label class="control-label">
                                        Save to:
                                    </label>
                                    <div class="am-radio">
                                        <input checked="" id="customerAccount" name="saveToAdminAccount" type="radio" value="0">
                                            <label for="customerAccount">
                                                Customer's account
                                            </label>
                                        </input>
                                    </div>
                                    <div class="am-radio">
                                        <input id="yourAccount" name="saveToAdminAccount" type="radio" value="1">
                                            <label for="yourAccount">
                                                Your account
                                            </label>
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button class="btn btn-default" data-dismiss="modal" onclick="javascript:proceed_savetemplate();" type="button">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Download Template Modal HTML -->
            <div class="modal fade" id="downloadtemplate_modal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-500">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Download Template
                            </h4>
                        </div>
                        <div class="modal-body" style="margin-top:-30px; ">
                            <div class="body">
                                <span>
                                    <label for="template">
                                        Template Name :
                                    </label>
                                    <input class="form-control" id="downtemplatename" name="downtemplatename" placeholder="Enter Name" type="text"/>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button class="btn btn-default" data-dismiss="modal" onclick="javascript:downloadTemplateFile();" type="button">
                                Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Save Text Modal HTML -->
            <div class="modal fade" id="savetext_modal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-500">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Save Text
                            </h4>
                        </div>
                        <div class="modal-body" style="margin-top:-30px; ">
                            <div class="body">
                                <div class="form-group">
                                    <label class="control-label">
                                        Tags
                                    </label>
                                    <select class="tags" id="text_tags" multiple="">
                                    </select>
                                </div>
                                <span>
                                    <label for="template">
                                        Text Name :
                                    </label>
                                    <input class="form-control" id="textname" name="textname" placeholder="Enter Name" type="text"/>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button class="btn btn-default" data-dismiss="modal" onclick="javascript:saveFromSelection(saveAsText);" type="button">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Save Element Modal HTML -->
            <div class="modal fade" id="saveelement_modal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-500">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Save Element
                            </h4>
                        </div>
                        <div class="modal-body" style="margin-top:-30px; ">
                            <div class="body">
                                <div class="form-group">
                                    <label class="control-label">
                                        Tags
                                    </label>
                                    <select class="tags" id="element_tags" multiple="">
                                    </select>
                                </div>
                                <span>
                                    <label for="template">
                                        Element Name :
                                    </label>
                                    <input class="form-control" id="elmtname" name="elmtname" placeholder="Enter Name" type="text"/>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button class="btn btn-default" data-dismiss="modal" onclick="javascript:saveFromSelection(saveAsElement);" type="button">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Canvas h/w Modal HTML -->
            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="canvaswh_modal" role="dialog" tabindex="-1">
                <div class="modal-dialog" style="width: 400px;">
                    <div class="modal-content">
                        <div class="jumbotron modal-header" style="margin-bottom:0px;">
                            <h4 class="modal-title">
                                Set Template Size
                            </h4>
                        </div>
                        <form action="#" id="canvaswhForm" method="post" name="canvaswhForm">
                            <div class="modal-body">
                                <p class="text-center" id="multiCanvText" style="padding-bottom:20px;">
                                    Choose the width and height of each canvas section
                                </p>
                                <span class="metric_block">
                                    <label for="metric_units1">
                                        Units
                                    </label>
                                    <div class="pull-right">
                                        <div class="am-radio inline" style="padding: 0">
                                            <input checked="" id="metric_units1_in" name="metric_units1" type="radio" value="in">
                                                <label for="metric_units1_in">
                                                    in
                                                </label>
                                            </input>
                                        </div>
                                        <div class="am-radio inline" style="padding: 0">
                                            <input id="metric_units1_mm" name="metric_units1" type="radio" value="mm">
                                                <label for="metric_units1_mm">
                                                    mm
                                                </label>
                                            </input>
                                        </div>
                                        <div class="am-radio inline" style="padding: 0">
                                            <input id="metric_units1_px" name="metric_units1" type="radio" value="px">
                                                <label for="metric_units1_px">
                                                    px
                                                </label>
                                            </input>
                                        </div>
                                    </div>
                                </span>
                                <br>
                                    <div class="canvas_size_inches active">
                                        <span>
                                            <label for="template">
                                                Canvas width (in inches):
                                            </label>
                                            <input class="form-control" id="loadCanvasWid" name="loadCanvasWid" placeholder="Enter Width" type="text" value="5">
                                            </input>
                                        </span>
                                        <br>
                                            <span>
                                                <label for="template">
                                                    Canvas height (in inches):
                                                </label>
                                                <input class="form-control" id="loadCanvasHei" name="loadCanvasHei" placeholder="Enter Height" type="text" value="7">
                                                </input>
                                            </span>
                                        </br>
                                    </div>
                                    <div class="canvas_size_pixels">
                                        <span>
                                            <label for="loadCanvasWidthPx">
                                                Canvas width (in pixels):
                                            </label>
                                            <input class="form-control" id="loadCanvasWidthPx" name="loadCanvasWidthPx" placeholder="Enter Width" type="text" value="5">
                                            </input>
                                        </span>
                                        <br>
                                            <span>
                                                <label for="loadCanvasHeightPx">
                                                    Canvas height (in pixels):
                                                </label>
                                                <input class="form-control" id="loadCanvasHeightPx" name="loadCanvasHeightPx" placeholder="Enter Height" type="text" value="7">
                                                </input>
                                            </span>
                                        </br>
                                    </div>
                                    <div class="canvas_size_mm">
                                        <span>
                                            <label for="loadCanvasWidthMm">
                                                Canvas width (in millimeters):
                                            </label>
                                            <input class="form-control" id="loadCanvasWidthMm" name="loadCanvasWidthMm" placeholder="Enter Width" type="text" value="5">
                                            </input>
                                        </span>
                                        <br>
                                            <span>
                                                <label for="loadCanvasHeightMm">
                                                    Canvas height (in millimeters):
                                                </label>
                                                <input class="form-control" id="loadCanvasHeightMm" name="loadCanvasHeightMm" placeholder="Enter Height" type="text" value="7">
                                                </input>
                                            </span>
                                        </br>
                                    </div>
                                    <span>
                                        <br>
                                            <label for="template">
                                                Number of canvas sections down
                                            </label>
                                            <input class="form-control" id="numOfcanvasrows" name="numOfcanvasrows" type="text" value="1">
                                            </input>
                                        </br>
                                    </span>
                                    <span>
                                        <br>
                                            <label for="template">
                                                Number of canvas sections across
                                            </label>
                                            <input class="form-control" id="numOfcanvascols" name="numOfcanvascols" type="text" value="1">
                                            </input>
                                        </br>
                                    </span>
                                </br>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal" onclick="$('#template_type_modal').modal('show');" type="button">
                                    Back
                                </button>
                                <button class="btn btn-default" data-dismiss="modal" type="button">
                                    Cancel
                                </button>
                                <button class="btn btn-primary" type="submit">
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Progress Bar Modal -->
            <div class="modal fade" data-target="#progressElementModal" id="progressElementModal">
                <div class="modal-dialog" style="width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Uploading Elements
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p class="text-center" style="padding-bottom: 5px;">
                                Uploading elements...
                            </p>
                            <div data-backdrop="static" data-keyboard="false">
                                <div class="progress progress-striped active">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Progress Bar Modal -->
            <div class="modal fade" data-target="#progressModal" id="progressModal">
                <div class="modal-dialog" style="width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Download PDF
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p class="text-center" style="padding-bottom: 5px;">
                                Preparing PDF for download...
                            </p>
                            <div data-backdrop="static" data-keyboard="false">
                                <div class="progress progress-striped active">
                                    <div class="bar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Uploading Elements Progress Bar Modal -->
            <div class="modal fade" data-target="#uploadingProgressModal" id="uploadingProgressModal">
                <div class="modal-dialog" style="width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Upload Element
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p class="text-center" style="padding-bottom: 5px;">
                                Uploading to Wayak...
                            </p>
                            <div data-backdrop="static" data-keyboard="false">
                                <div class="progress progress-striped active">
                                    <div class="bar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Image Alert Modal HTML -->
            <div class="modal fade" id="imagealertModal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-400">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                IMAGE FILE FORMAT / SIZE MISMATCH.
                            </h4>
                        </div>
                        <div class="modal-body" style="margin-top:-30px; ">
                            <div class="body">
                                <label>
                                    Please upload your image format in JPG/PNG/GIF. Each file size is limited to 1000 KB.
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Element Modal HTML -->
            <div class="modal fade" id="AddelementModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Add Elements
                            </h4>
                        </div>
                        <form id="addelementform" name="addelementform" onsubmit="event.preventDefault();" role="form">
                            <div class="modal-body" style="margin-top:-30px; ">
                                <div class="row">
                                    <div id="newElementTags">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>
                                            Element Files (10 at a time max)
                                        </label>
                                        <div class="dropzone" id="div-new-element-dropzone" style="border-style: dashed;">
                                            <div class="dz-message text-center">
                                                <div class="icon">
                                                    <span class="s7-cloud-upload" style="font-size: 36pt;">
                                                    </span>
                                                </div>
                                                <h3>
                                                    Upload element files here
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer clearfix">
                                <button class="btn btn-default btn-small" id="uploadButton">
                                    Add
                                </button>
                                <button class="btn btn-default btn-small" data-dismiss="modal" id="uploadCancelButton" type="reset">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Add Background Modal HTML -->
            <div class="modal fade" id="AddbackgroundModal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-500">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Add Background
                            </h4>
                        </div>
                <form name="add-background-form" id="add-background-form" data-parsley-validate="" novalidate="" role="form">
                            <div class="modal-body" style="margin-top:-30px; ">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            Images uploaded to the Backgrounds pane should be seamless backgrounds only. Otherwise, upload the image to the Elements pane.
                                        </p>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="control-label">
                                            Tags
                                        </label>
                                        <select class="tags" id="bg_tags" multiple="">
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="bgName">
                                            Background Name
                                        </label>
                                        <input class="form-control" id="bgName" name="bgName" placeholder="Enter Background Name" type="text">
                                        </input>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label name="background">
                                            Background Image
                                        </label>
                                    </div>
                                    <div class="form-group bg-upload col-lg-3">
                                        <label class="btn btn-default btn-block" for="bg_img">
                                            <i class="fa fa-cloud-upload">
                                            </i>
                                            Upload
                                        </label>
                                        <input id="bg_img" name="bg_img" onchange="readBGIMG(this);" type="file"/>
                                    </div>
                                    <img alt="Your image" id="previewBGImage" src="" style="display:none;"/>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer clearfix">
                                <button class="btn btn-default btn-small" data-dismiss="modal" type="reset">
                                    Cancel
                                </button>
                                <button class="btn btn-default btn-small" type="submit">
                                    Add
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Download PDF modal -->
            <div class="modal fade" data-target="#downloadpdfmodal" id="downloadpdfmodal">
                <div class="modal-dialog" style="width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                PDF Download Options
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p class="text-center" style="padding-bottom: 5px;">
                                High quality 300dpi PDF for print
                            </p>
                            <p class="text-center">
                                <a data-target="#whentousepdf" data-toggle="collapse" href="#">
                                    When to use PDF
                                </a>
                            </p>
                            <div class="col-sm-12 collapse" id="whentousepdf" style="margin-top:10px;">
                                <p class="text-center">
                                    PDF is useful when you are printing your template at home or taking to office supply chains such as Staples, FedEx Kinkos, etc. Most print shops will also accept PDF files but if they require a bleed then you will want to use JPEG instead.
                                </p>
                            </div>
                            <div class="row" style="padding-top:20px;">
                                <div class="col-sm-2">
                                    <div class="switch-button switch-button-sm">
                                        <input id="savecrop" name="cropmark" type="checkbox">
                                            <span>
                                                <label for="savecrop">
                                                </label>
                                            </span>
                                        </input>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <span class="icon s7-scissors" style="font-size:24px; vertical-align:middle;">
                                    </span>
                                    Show Trim Marks
                                    <a data-target="#moreAboutTrim" data-toggle="collapse" href="#">
                                        <span class="s7-help1" style="font-size:15px;vertical-align: middle;">
                                        </span>
                                    </a>
                                </div>
                                <div class="col-sm-12 collapse" id="moreAboutTrim" style="margin-top:10px;">
                                    <p>
                                        Use trim marks only when you are going to trim your template yourself. Print shops will not want trim marks on the PDF file.
                                    </p>
                                </div>
                            </div>
                            <div class="row savePaperRow" style="padding-top:10px;">
                                <div class="col-sm-2">
                                    <div class="switch-button switch-button-sm">
                                        <input id="savePaper" name="savepaper" type="checkbox">
                                            <span>
                                                <label aria-controls="selectSize" aria-expanded="false" data-target="#selectSize" data-toggle="collapse" for="savePaper">
                                                </label>
                                            </span>
                                        </input>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <span class="icon s7-keypad" style="font-size:24px; vertical-align:middle;">
                                    </span>
                                    Save Paper
                                    <a data-target="#moreAboutSP" data-toggle="collapse" href="#">
                                        <span class="s7-help1" style="font-size:15px;vertical-align: middle;">
                                        </span>
                                    </a>
                                </div>
                                <div class="col-sm-12 collapse" id="moreAboutSP" style="margin-top:10px;">
                                    <p>
                                        This will fit as many templates on each page as possible to save paper.
                                    </p>
                                </div>
                                <div class="col-sm-12 collapse" data-toggle="buttons" id="selectSize" style="margin-top:10px;">
                                    <p class="text-center">
                                        Select the size paper you will be printing on.
                                    </p>
                                    <div class="col-xs-5 col-xs-offset-1">
                                        <label class="paper-size bs-grid-block btn btn-default active" id="btn_type_us" style="padding:0px; margin-bottom: 30px;">
                                            <div class="content">
                                                <p>
                                                    <input checked="" class="paper-input" name="paperSize" type="radio" value="us_letter">
                                                        <img src="{{ asset('assets/img/us_letter.svg') }}" style="width:80px;"/>
                                                    </input>
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-xs-5">
                                        <label class="paper-size bs-grid-block btn btn-default" id="btn_type_a4" style="padding:0px; margin-bottom: 30px;">
                                            <div class="content">
                                                <p>
                                                    <input class="paper-input" name="paperSize" type="radio" value="a4">
                                                        <img src="{{ asset('assets/img/a4.svg') }}" style="width:80px;"/>
                                                    </input>
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default btn-small" data-dismiss="modal" type="reset">
                                Cancel
                            </button>
                            <button class="btn btn-success" data-dismiss="modal" id="downloadAsPDF" type="button">
                                Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Download JPEG modal -->
            <div class="modal fade" id="downloadjpegmodal">
                <div class="modal-dialog" style="width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                JPEG Download Options
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p class="text-center" style="padding-bottom: 5px;">
                                High quality 300dpi JPEG for print
                            </p>
                            <p class="text-center">
                                <a data-target="#whentousejpeg" data-toggle="collapse" href="#">
                                    When to use JPEG
                                </a>
                            </p>
                            <div class="col-sm-12 collapse" id="whentousejpeg" style="margin-top:10px;">
                                <p class="text-center">
                                    JPEG is useful when getting your template professionally printed by a standard print shop or online print shop or stores that print photos. Some examples include VistaPrint, Shutterfly, Walgreens, Walmart, Target, Costco, etc.
                                </p>
                            </div>
                            <div class="row" style="padding-top:20px;">
                                <div class="col-sm-2">
                                    <div class="switch-button switch-button-sm">
                                        <input id="savebleed" name="bleed" type="checkbox">
                                            <span>
                                                <label for="savebleed">
                                                </label>
                                            </span>
                                        </input>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <span class="icon s7-expand1" style="font-size:24px; vertical-align:middle;">
                                    </span>
                                    Add Bleed
                                    <a data-target="#moreAboutBleed" data-toggle="collapse" href="#">
                                        <span class="s7-help1" style="font-size:15px;vertical-align: middle;">
                                        </span>
                                    </a>
                                </div>
                                <div class="col-sm-12 collapse" id="moreAboutBleed" style="margin-top:10px;">
                                    <p>
                                        If you are getting your template professionally printed and your template has a background or images that go to the end of the template, chances are the print shop will want a full bleed. This is an extra 1/8" around the entire template so the print shop can cut the template to size to acheive the desired result.
                                    </p>
                                </div>
                            </div>
                            <div class="row" style="padding-top:20px;margin-bottom:-20px;">
                                <div class="col-sm-12">
                                    <p class="text-muted">
                                        Note: Multiple pages will be downloaded as separate JPEG's in a Zip file.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default btn-small" data-dismiss="modal" type="reset">
                                Cancel
                            </button>
                            <button class="btn btn-success" data-dismiss="modal" id="downloadAsJPEG" type="button">
                                Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- unsaved changes modal -->
            <div class="modal fade" data-newtemplate="0" id="unsavedChanges">
                <div class="modal-dialog" style="width: 400px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                You have unsaved changes!
                            </h4>
                        </div>
                        <div class="modal-body">
                            <span>
                                Are you sure you want to continue? You have unsaved changes on the current template.
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" id="unsaved_changes_commit" type="button">
                                Continue
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" id="unsaved_changes_cancel" type="button">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- unsaved changes modal -->
            <div class="modal fade" data-newtemplate="0" id="revertTemplateModal">
                <div class="modal-dialog" style="width: 400px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Revert Template
                            </h4>
                        </div>
                        <div class="modal-body">
                            <span>
                                Are you sure you want to continue with revert the template?
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" id="unsaved_changes_commit" onclick="revertTemplate()" type="button">
                                Continue
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" id="unsaved_changes_cancel" type="button">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Seller Instructions Modal HTML -->
            <div class="modal fade" id="sellerInstructions">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-500">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Instructions From The Seller
                            </h4>
                        </div>
                        <div class="modal-body" style="margin-top:-30px; ">
                            <div class="body">
                                <div id="instructions" style="overflow-y: scroll; height:400px;white-space: pre-wrap;">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <iframe id="printIframe" style="border:none; width:0px; height:0px;">
                            </iframe>
                            <button class="btn btn-default" data-dismiss="modal" id="printInstructions" type="button">
                                Print
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New New Template Modal HTML -->
            <div class="modal fade" id="template_type_modal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-500">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Create a New Template
                            </h4>
                        </div>
                        <div class="modal-body" style="margin:-30px 0;">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4">
                                    <div class="bs-grid-block btn btn-default" id="btn_type_single" style="padding:0px; margin-bottom: 30px;">
                                        <div class="content">
                                            <p>
                                                <img src="{{ asset('assets/img/template-normal.svg') }}"/>
                                            </p>
                                            <p style="font-size: 13px;">
                                                Single
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="bs-grid-block btn btn-default" id="btn_type_doublesided" style="padding:0px; margin-bottom: 30px;">
                                        <div class="content">
                                            <p>
                                                <img src="{{ asset('assets/img/template-double-sided.svg') }}"/>
                                            </p>
                                            <p style="font-size: 13px;">
                                                Double-Sided
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="bs-grid-block btn btn-default" id="btn_type_bookfold" style="padding:0px; margin-bottom: 30px;">
                                        <div class="content">
                                            <p>
                                                <img src="{{ asset('assets/img/template-book-fold.svg') }}"/>
                                            </p>
                                            <p style="font-size: 13px;">
                                                Book Fold
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="bs-grid-block btn btn-default" id="btn_type_tentfold" style="padding:0px; margin-bottom: 30px;">
                                        <div class="content">
                                            <p>
                                                <img src="{{ asset('assets/img/template-tent-fold.svg') }}"/>
                                            </p>
                                            <p style="font-size: 13px;">
                                                Tent Fold
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="bs-grid-block btn btn-default" id="btn_type_geofilter" style="padding:0px; margin-bottom: 30px;">
                                        <div class="content">
                                            <p>
                                                <img src="{{ asset('assets/img/template-geofilter.svg') }}"/>
                                            </p>
                                            <p style="font-size: 13px;">
                                                Geofilter
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="bs-grid-block btn btn-default" id="btn_type_custom" style="padding:0px; margin-bottom: 30px;">
                                        <div class="content">
                                            <p>
                                                <img src="{{ asset('assets/img/template-custom.svg') }}"/>
                                            </p>
                                            <p style="font-size: 13px;">
                                                Custom
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Login Modal HTML -->
            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="loginModal">
                <div class="modal-dialog" style="width: 350px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center">
                                Session Expired
                            </h4>
                        </div>
                        <div class="modal-body" style="padding: 10px 30px 10px 30px">
                            <div class="form-group">
                                <p class="text-center" style="font-size: 14px; color: #999999;">
                                    Your session has expired
                                    <br>
                                        Please log in again
                                    </br>
                                </p>
                            </div>
                            <form data-parsley-validate="" id="loginForm" novalidate="">
                                <div class="form-group">
                                    <input class="form-control" id="username" name="username" parsley-trigger="change" placeholder="Username" required="" type="text" value="">
                                    </input>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="password" name="password" parsley-trigger="change" placeholder="Password" required="" type="password">
                                    </input>
                                </div>
                                <button class="btn btn-primary btn-lg" id="loginButton" style="width: 100%;" type="submit">
                                    Log in
                                </button>
                                <div class="row" style="margin-top: 3px; line-height: 35px; font-size: 14px;">
                                    <div class="col-xs-6">
                                        <a href="../forgot-password.php" target="_blank">
                                            Forgot Password?
                                        </a>
                                    </div>
                                    <div class="col-xs-6 remember" style="text-align: right;">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                        <div class="am-checkbox" style="display: inline-block;">
                                            <input id="remember" name="remember" type="checkbox">
                                                <label for="remember" style="text-align: right; margin-right: -3px;">
                                                </label>
                                            </input>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Video Modal HTML -->
            <div class="modal fade" id="modal-video" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button ">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h3 class="modal-title">
                                Wayak Design Introduction
                            </h3>
                        </div>
                        <div class="modal-body">
                            <div class="embed-responsive embed-responsive-16by9">
                                <!-- <iframe allowfullscreen="" class="embed-responsive-item" mozallowfullscreen="" src="https://www.youtube.com/embed/lzWLckQN-2c?rel=0&enablejsapi=1" webkitallowfullscreen="">
                                </iframe> -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" id="hide-video" type="button">
                                Don't show again
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal with properties of object-->
            <div id="object-properties" title="Properties">
                <div class="tab-content" style="margin-bottom:0px;">
                    <div class="tab-pane active" id="appearance">
                        <div class="filter-wrapper">
                            <label>
                                Scale
                            </label>
                            <br>
                                <input data-filter-index="Scale" data-slider-id="objectScale" data-slider-max="300" data-slider-min="10" data-slider-step="1" data-slider-ticks="[10, 100, 300]" data-slider-ticks_snap_bounds="1" data-slider-value="100" id="object-scale" type="text"/>
                            </br>
                        </div>
                        <div class="may-be-disabled editor-disabled">
                            <div class="filter-wrapper">
                                <label>
                                    Hue
                                </label>
                                <br>
                                    <input data-filter-index="HueRotation" data-slider-id="objectHue" data-slider-max="100" data-slider-min="-100" data-slider-step="1" data-slider-ticks="[-100, 0, 100]" data-slider-ticks_snap_bounds="1" data-slider-value="0" id="object-hue" type="text"/>
                                </br>
                            </div>
                            <div class="filter-wrapper">
                                <label>
                                    Brightness
                                </label>
                                <br>
                                    <input data-filter-index="Brightness" data-slider-id="objectBrightness" data-slider-max="100" data-slider-min="-100" data-slider-step="1" data-slider-ticks="[-100, 0, 100]" data-slider-ticks_snap_bounds="1" data-slider-value="0" id="object-brightness" type="text"/>
                                </br>
                            </div>
                            <div class="filter-wrapper">
                                <label>
                                    Contrast
                                </label>
                                <br>
                                    <input data-filter-index="Contrast" data-slider-id="objectContrast" data-slider-max="100" data-slider-min="-100" data-slider-step="1" data-slider-ticks="[-100, 0, 100]" data-slider-ticks_snap_bounds="1" data-slider-value="0" id="object-contrast" type="text"/>
                                </br>
                            </div>
                            <div class="filter-wrapper">
                                <label>
                                    Saturation
                                </label>
                                <br>
                                    <input data-filter-index="Saturation" data-slider-id="objectSaturation" data-slider-max="100" data-slider-min="-100" data-slider-step="1" data-slider-ticks="[-100, 0, 100]" data-slider-ticks_snap_bounds="1" data-slider-value="0" id="object-saturation" type="text"/>
                                </br>
                            </div>
                            <div class="filter-wrapper">
                                <label>
                                    Blur
                                </label>
                                <br>
                                    <input data-filter-index="Blur" data-slider-id="objectBlur" data-slider-max="1" data-slider-min="0" data-slider-step="1" data-slider-ticks="[0, 100]" data-slider-ticks_snap_bounds="1" data-slider-value="0" id="object-blur" type="text"/>
                                </br>
                            </div>
                            <br>
                                <fieldset>
                                    <label for="object-grayscale">
                                        Grayscale
                                    </label>
                                    <input id="object-grayscale" name="object-grayscale" type="checkbox">
                                        <button class="filter-reset-all btn btn-default pull-right" type="reset">
                                            Reset all
                                        </button>
                                    </input>
                                </fieldset>
                            </br>
                        </div>
                        <div class="note">
                            Image size is too large
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal with utf8 symbols-->
            <div id="font-symbols" title="Glyphs">
                <div class="tab-content" style="margin-bottom:0">
                    <div class="tab-pane active utf8-symbols">
                    </div>
                </div>
            </div>
            <!-- Confirmation Modal HTML -->
            <div class="modal fade" id="fontConfirmationModal">
                <div class="modal-dialog" style="width:450px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Before you upload, please confirm the following:
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="am-checkbox">
                                <input id="fontConfirmationCheckbox" type="checkbox">
                                    <label for="fontConfirmationCheckbox">
                                        I have the right to use this font
                                    </label>
                                </input>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Cancel
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" id="proceedFontUploadBtn" onclick="javascript:uploadFont()" type="button">
                                Upload
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Font Details Modal HTML -->
            <div class="modal fade" id="fontDetailsModal">
                <div class="modal-dialog">
                    <div class="modal-content modal-content-500">
                        <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                            <button aria-hidden="true" class="close" data-dismiss="modal" style="opacity:1.0;" type="button">
                                <i class="icon s7-close">
                                </i>
                            </button>
                            <h4 class="modal-title">
                                Font Details
                            </h4>
                        </div>
                        <div class="modal-body" style="margin-top:-30px; ">
                            <div class="body">
                                <div id="">
                                    <input id="fontId" type="hidden" value="">
                                        <div class="form-group">
                                            <label>
                                                Original Name
                                            </label>
                                            <input class="form-control" id="fontOriginalName" readonly="readonly" type="text" value="Font Name">
                                            </input>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Display Name
                                                <a data-target="#whyDName" data-toggle="collapse" href="#">
                                                    <i class="icon s7-help1">
                                                    </i>
                                                </a>
                                            </label>
                                            <div class="collapse" id="whyDName">
                                                This is the font name the user will see in the design application. Sometimes it's best not to show the real font name if you want to protect the integrity of your designs and do not want them replicated elsewhere.
                                            </div>
                                            <input class="form-control" id="fontDisplayName" required="">
                                            </input>
                                        </div>
                                    </input>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Cancel
                            </button>
                            <button class="btn btn-success" onclick="javascript:saveFontDetails()" type="button">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--dynamic pattern options-->
            <div aria-labelledby="patternFillLabel" class="dropdown-menu patternFillTab noclose" style="max-height: calc(80vh); overflow-y: auto;">
                <div class="row" style="padding: 1px 10px; background:#ededed; margin:0">
                    <div class="col-xs-6">
                        <h4>
                            Patterns
                        </h4>
                    </div>
                </div>
                <div class="tab-content" style="margin-bottom:0">
                    <label>
                        Pattern Scale
                    </label>
                    <input class="patternScale" data-slider-id="paternScaleSlider" data-slider-max="300" data-slider-min="10" data-slider-step="1" data-slider-value="100" type="text"/>
                    <div class="tiles_block">
                        <label>
                            Tiles
                        </label>
                        <div class="tab-pane active" id="patternsList">
                        </div>
                    </div>
                </div>
            </div>
            <div class="loading-icon">
            </div>
            <input id="opentemplate_input" type="file"/>
        </div>
        <div class="test-symbols" id="test-symbols">
            �test□▯😘😅
        😗😎😎🌊🌊😀
        </div>
        <!-- build:vendor -->
        
    <!-- endbuild -->

    <div class="modal fade" id="myAccountModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close md-close" data-dismiss="modal" type="button">
                    <i class="icon s7-close">
                    </i>
                </button>
                <h3 class="modal-title">
                    My Profile
                </h3>
            </div>
            <form action="../admin/actions/updateMyAvatar.php" class="form-horizontal" method="post" enctype="multipart/form-data" name="my-avatar" id="my-avatar" role="form" autocomplete="off">
                <div class="col-md-4">
                    <div style="margin:30px 0; text-align:center;">
                        <img id="avatar" style="max-width: 150px;" class="img-circle" src="">
                            <label class="btn btn-primary btn-file" style="margin:10px;">
                                Upload Image <input type="file" name="pic" accept="image/*" style="display: none;" onchange="$('#my-avatar').submit();">
                            </label>
                        </img>
                    </div>
                </div>
            </form>
            <form action="../admin/actions/updateMyAccount.php" class="form-horizontal" method="POST" name="my-account" role="form" data-parsley-validate="" novalidate="" accept-charset="UTF-8" autocomplete="off">
                <div class="col-md-8">
                    <div class="modal-body form">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Username
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control" value="" readonly>
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                First name
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control" name="firstname" placeholder="" data-parsley-type="alphanum" parsley-trigger="change" required="" type="name" value="">
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Last name
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control" name="lastname" placeholder="" data-parsley-type="alphanum" parsley-trigger="change" required="" type="name" value="">
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Email address
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control" name="email" placeholder="username@example.com" parsley-trigger="change" parsley-type="email" required="" type="email" value="" autocomplete="off">
                                </input>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a data-toggle="collapse" href="#change-pass">Change Password <i class="icon s7-angle-down"></i></a>
                        </div>
                        <div id="change-pass" class="collapse">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Password
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="password" type="password" parsley-trigger="change" id="inputPassword" autocomplete="off">
                                    </input>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Confirm password
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="password" parsley-trigger="change" id="inputConfirmPassword" data-parsley-equalto="#inputPassword" autocomplete="off">
                                    </input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default md-close" data-dismiss="modal" type="button">
                        Cancel
                    </button>
                    <button class="btn btn-primary md-close" type="submit">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="{{ asset('assets/js/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/js/touchSwipe/jquery.touchSwipe.min.js') }}"></script>
        <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
        <script src="{{ asset('assets/js/imagesLoaded/imagesloaded.pkgd.min.js') }}"></script>
        <!-- <script src="{{ asset('assets/js/jquery-mobile/jquery.mobile-1.4.5.min.js?rev=ed515e27701f638073403bd54317e') }}"></script> -->
        <script src="{{ asset('assets/js/parsley/parsley.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
        <script src="{{ asset('assets/js/spectrum/spectrum.js') }}"></script>
        <script src="{{ asset('assets/js/tagsfield/tagsfield.js') }}"></script>
        <script src="{{ asset('assets/js/opentype/opentype.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-form/jquery.form.js') }}"></script>
        <script src="{{ asset('assets/js/dropzone/dropzone.js') }}"></script>
        <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-validate/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor.js?rev=ed515e27701f638073403bd54317e') }}"></script>
        <script src="{{ asset('assets/js/nanoscroller/jquery.nanoscroller.min.js?rev=ed515e27701f638073403bd54317e') }}"></script>
        <script src="{{ asset('assets/js/fastclick/fastclick.js?rev=ed515e27701f638073403bd54317e') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/5.3.0/simplebar.min.js" integrity="sha512-AS9rZZDdb+y4W2lcmkNGwf4swm6607XJYpNST1mkNBUfBBka8btA6mgRmhoFQ9Umy8Nj/fg5444+SglLHbowuA==" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/filesaver/FileSaver.min.js') }}"></script>
        <script src="{{ asset('assets/js/jszip/jszip.min.js') }}"></script>
        <!-- <script src="{{ asset('assets/js/fabricjs/2.4.6/fabric.min.js?rev=ed515e27701f638073403bd543') }}">
        </script> -->
        <script src="{{ asset('assets/js/fabricjs/fabric.js') }}"></script>
        <script src="{{ asset('assets/js/fabricjs/centering_guidelines.js') }}"></script>
        <script src="{{ asset('assets/js/fabricjs/aligning_guidelines.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/toast/jquery.toast.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/webfontloader/webfontloader.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/store/init-min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("form[name='my-account']").ajaxForm({
                    beforeSubmit: function() {
                        if($("form[name='my-account']").parsley().isValid() == false){
                            return false;
                        }
                    },
                    success: function(data) {
                        var data = JSON.parse(data);
                        var icon = (data.err === 0) ? 'success' : 'error';
                        $.toast({
                            text: data.msg,
                            icon: icon,
                            loader: false,
                            position: 'top-right',
                            hideAfter: 3000
                        });
                        if (data.err == 0){
                            $('#inputPassword').val('');
                            $('#inputConfirmPassword').val('');
                            $('#myAccountModal').modal('hide');
                        }
                    },
                });
                $("form[name='my-avatar']").ajaxForm({
                    success: function(data) {
                        var data = JSON.parse(data);
                        var icon = (data.err === 0) ? 'success' : 'error';
                        $.toast({
                            text: data.msg,
                            icon: icon,
                            loader: false,
                            position: 'top-right',
                            hideAfter: 3000
                        });
                        if (data.err == 0){
                            $('#avatar').attr('src', data.avatar);
                            $('#avatar-nav').attr('src', data.avatar);
                        }
                    },
                });
                $('#inputPassword').on('input',function(e){
                    if ($('#inputPassword').val()==''){
                        console.log('empty');
                        $('#inputConfirmPassword').removeAttr('required');
                    } else {
                        $('#inputConfirmPassword').attr('required','');
                    }
                });
            });
        </script>
        <script type="text/javascript">
            var tempcanvas = new fabric.Canvas('tempcanvas');
            var selectedFont = 'font42';
            var fillColor = 'Black';

            // PAID
            var design_as_id = {{ $purchase_code }};
            var demo_as_id = {{ $demo_as_id }};
            var currentUserRole = '{{ $user_role }}';
            var language_code = '{{ $language_code }}';
            var docUserId = 'docUserId{{ $demo_as_id }}';
            let customerId = getCustomerId();
            
            // FREE
            // var design_as_id = 0;
            // var demo_as_id = 243578;
            // currentUserRole = "administrator", "designer","customer"
            
            var demo_templates = '{{ (isset($templates)) ? $templates : '' }}';
            var geofilterBackgrounds = [{"id":0,"filename":"none"},{"id":"1","filename":"geo-wedding.jpg"},{"id":"2","filename":"geo-party.jpg"},{"id":"3","filename":"geo-cheers.jpg"},{"id":"4","filename":"geo-babygirl.jpg"}];
            var currentUserRole = '';
            var hideVideoModal = false;
        </script>
        <script type="text/javascript">
            var appUrl = '{{ url("") }}/';
            if(demo_as_id) {
                var demoJwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6InRlbXBsZXR0In0.IntcImlkXCI6XCIxNDM0N2YxODQ2MTA0ZDgzNWIwZDNkZjUxYzBiMjdmNVwiLFwidWlkXCI6XCIxNDM0N2YxODQ2MTA0ZDgzNWIwZDNkZjUxYzBiMjdmNVwiLFwiZGVtb0FzXCI6dHJ1ZSxcInRlbXBsYXRlSWRzXCI6W1wiNTM3ODI3MFwiXSxcImF2YXRhclwiOlwiaHR0cHM6XFxcL1xcXC90ZW1wbGV0dC5jb21cXFwvYWRtaW5cXFwvYXNzZXRzXFxcL2ltZ1xcXC9sb2dvLXJldGluYS5wbmdcIixcInJvbGVcIjpcImRlbW9cIixcImVtYWlsXCI6XCJkZW1vQHRlbXBsZXR0LmNvbVwiLFwidXNlcm5hbWVcIjpcImRlbW9cIixcImxhbmd1YWdlXCI6XCJlbmdsaXNoXCIsXCJ1bmlxdWVfaWRcIjpcInNpZF82MDI1ZWVjMThmNWI1XCIsXCJsb2NhdGlvblwiOntcImNvdW50cnlfY29kZVwiOlwiTVhcIixcImNvdW50cnlfbmFtZVwiOlwiTWV4aWNvXCIsXCJjaXR5X25hbWVcIjpcIkNpdWRhZCBOZXphaHVhbGNveW90bFwiLFwidGltZV96b25lXCI6XCItMDU6MDBcIn0sXCJjcmVhdGVkXCI6MTYxMzA5ODY4OSxcImV4cFwiOjE2MTMxODUwODl9Ig.FhI0bXyk_vYX9564t92umZPq7YXTGc4VO9971uFrsxvFXmdK51cYLdLC-Q61YO0-X1nHlcCAqiCGQx27W5FbvToSyOB29DJ16sCK-v0mrP3XhW0rz1MN6bATrfAMK-STiPRuR3ipQ721Zts_efM2vqtFWK-c3b6ITC4vkO01WooxgySm92vIXimD0p521cQD146_PJVdLZcKewaeLVP_sCXXe_EpugKBXePnbsnU4KdMKOfxq6T0bHYmQO5Weu4o8O8NulvoS0YDRliU12D5KOP4bQewrxSZjZbIBCIJATqVPlse6HvkJ74C19P56WpyjJx6CEYv0t7lGu_I0QrJtA";
                $.ajaxSetup({
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('x-demo-templett-jwt', demoJwt);
                    }
                });
            }
        </script>
        <!-- build:app -->
        <script src="{{ asset('assets/js/app_keyboard_events.js?rev='.time()) }}"></script>
        <script src="{{ asset('assets/js/app_refactor.js?rev='.time()) }}"></script>
        <script src="{{ asset('assets/js/app_init_refactor.js?rev='.time()) }}"></script>
        <script src="{{ asset('assets/js/app.js?rev='.time()) }}"></script>
        <!-- endbuild -->
        <script type="text/javascript">
            // Wait for window load
    
            $(window).load(function () {  
                // Animate loader off screen
                $("#loadingpage").fadeOut("slow");
                $('.deletecanvas').css('display', 'none');
            });
            
            var configSimpleScroll = function(containerId, itemsContainerId) {
                var templatesSimpleBar = new SimpleBar(document.getElementById(containerId));
                templatesSimpleBar.getScrollElement().addEventListener('scroll', function(e) {
                    // console.log(e.srcElement.scrollHeight);
                    // console.log(e.srcElement.scrollTop);
                    // console.log(e.srcElement.offsetHeight);

                    if((e.srcElement.scrollHeight - (e.srcElement.offsetHeight + e.srcElement.scrollTop)) < 30) {
                        var selector = '#' + itemsContainerId;
                        $(selector).scroll();
                    }
                });
            };
    
            configSimpleScroll('a', 'template_container');
            configSimpleScroll('b', 'text_container');
            configSimpleScroll('c', 'catimage_container');
            configSimpleScroll('d', 'bgscalecontainer');
            //configSimpleScroll('e', 'related_products_container');
            configSimpleScroll('f', 'uploaded_images_list');

    
            $(document).ready(function() {
                // Set demo cookie after 30 seconds on page
                if (0) {
                setTimeout(function(){
                    $.get('/design/actions/setDemoCookie.php', {
                            demo_as_id: demo_as_id
                        });
                }, 30000);
                }
                //initialize the javascript
                App.init();

                //only if admin logged
                setTimeout(function() {
                    loadSettings(); 
                }, 250);
                if(jQuery('body').hasClass('admin')) {
                    setTimeout(function(){ 
                        getTexts2(0,''); 
                    }, 500);
                    setTimeout(function () {
                        getCatimages2(0,''); 
                    }, 750);
                    $(".sidebar-elements li a").removeClass("invisible");
                    if(design_as_id > 0){
                        $('#relatedProductsPane a:visible').addClass('invisible');
                    }
                }
                setTimeout(function() {
                    getBgimages2(0,'');
                }, 1000);
                if(!$('body').hasClass('admin') || design_as_id) {
                    setTimeout(function(){ getRelatedProducts(0); }, 1000);
                }
                //Outdated browser notice
                var $buoop = {
                    vs: {i:10,f:25,o:12.1,s:7},  // browser versions to notify
                    reminder: 24,                   // atfer how many hours should the message reappear
                                                    // 0 = show all the time
                    reminderClosed: 150,             // if the user closes message it reappears after x hours
                    //onshow: function(infos){},      // callback function after the bar has appeared
                    //onclick: function(infos){},     // callback function if bar was clicked
                    //onclose: function(infos){},     //

                    //l: false,                       // set a language for the message, e.g. "en"
                    // overrides the default detection
                    //test: true,                    // true = always show the bar (for testing)
                    text: "Your browser is not up to date. Wayak relies on the latest web technologies. If you experience issues, please consider updating or switching to Chrome.",                       // custom notification html text
                    // Optionally include up to two placeholders "%s" which will be replaced with the browser version and contents of the link tag. Example: "Your browser (%s) is old.  Please <a%s>update</a>"
                    //text_xx: "",                    // custom notification text for language "xx"
                    // e.g. text_de for german and text_it for italian
                    newwindow: true,                 // open link in new window/tab
                    url: 'http://outdatedbrowser.com/'                       // the url to go to after clicking the notification
                };

                var $buo_f = function() {
                    var e = document.createElement("script");
                    e.src = "//browser-update.org/update.min.js";
                    document.body.appendChild(e);
                };
                try {
                    document.addEventListener("DOMContentLoaded", $buo_f,false);
                }
                catch(e) {
                    window.attachEvent("onload", $buo_f);
                }
            });
        </script>
    </body>
</html>
