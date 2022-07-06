<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Expedición de actas certificadas digitales del estado civil de las personas</title>
    <meta name="description" content="Portal de la Ciudad de México donde podrás consultar el listado de trámites y servicios disponibles">
    <meta name="keywords" content="CDMX, Trámites, Servicios, Ciudad de México">




    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <meta property="og:url" content="https://www.cdmx.gob.mx">
    <meta property="og:type" content="website">
    <meta property="og:title" content="CDMX - Portal de Trámites y Servicios">
    <meta property="og:description" content="Portal de la Ciudad de México donde podrás consultar el listado de trámites y servicios disponibles">
    <meta property="og:image" content="https://cdmx.gob.mx/resources/img/img_redes.png">
    <meta property="og:image:height" content="734">
    <meta property="og:image:width" content="907">
    <meta property="og:image:type" content="image/png">

    <meta property="twitter:url" content="https://www.cdmx.gob.mx">
    <meta name="twitter:title" content="CDMX - Portal de Trámites y Servicios">
    <meta name="twitter:description" content="Portal de la Ciudad de México donde podrás consultar el listado de trámites y servicios disponibles">
    <meta name="twitter:image" content="https://cdmx.gob.mx/resources/img/img_redes.png">
    <meta name="robots" content="all">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link type="text/css" rel="stylesheet" href="{{asset('css/ipdp.css')}}" />

    <style>
        .btn-primary {
            background-color: #9f2442;
            border-color: #9f2442;
        }
        
        body {
            background-color: #f2f3f7
        }
        
        .container {
            background-color: white;
        }
        /*! CSS Used from: https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css */
        
        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }
        
        h5 {
            margin-top: 0;
            margin-bottom: .5rem;
        }
        
        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        
        ol {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        
        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }
        
        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        
        img {
            vertical-align: middle;
            border-style: none;
        }
        
        h5 {
            margin-bottom: .5rem;
            font-family: inherit;
            font-weight: 500;
            line-height: 1.2;
            color: inherit;
        }
        
        h5 {
            font-size: 1.25rem;
        }
        
        .carousel {
            position: relative;
        }
        
        .carousel-inner {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        
        .carousel-item {
            position: relative;
            display: none;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            width: 100%;
            transition: -webkit-transform .6s ease;
            transition: transform .6s ease;
            transition: transform .6s ease, -webkit-transform .6s ease;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-perspective: 1000px;
            perspective: 1000px;
        }
        
        .carousel-item.active {
            display: block;
        }
        
        .carousel-control-next,
        .carousel-control-prev {
            position: absolute;
            top: 0;
            bottom: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 15%;
            color: #fff;
            text-align: center;
            opacity: .5;
        }
        
        .carousel-control-next:focus,
        .carousel-control-next:hover,
        .carousel-control-prev:focus,
        .carousel-control-prev:hover {
            color: #fff;
            text-decoration: none;
            outline: 0;
            opacity: .9;
        }
        
        .carousel-control-prev {
            left: 0;
        }
        
        .carousel-control-next {
            right: 0;
        }
        
        .carousel-control-next-icon,
        .carousel-control-prev-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background: transparent no-repeat center center;
            background-size: 100% 100%;
        }
        
        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
        }
        
        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
        }
        
        .carousel-indicators {
            position: absolute;
            right: 0;
            bottom: 10px;
            left: 0;
            z-index: 15;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            padding-left: 0;
            margin-right: 15%;
            margin-left: 15%;
            list-style: none;
        }
        
        .carousel-indicators li {
            position: relative;
            -webkit-box-flex: 0;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            width: 30px;
            height: 3px;
            margin-right: 3px;
            margin-left: 3px;
            text-indent: -999px;
            background-color: rgba(255, 255, 255, .5);
        }
        
        .carousel-indicators li::before {
            position: absolute;
            top: -10px;
            left: 0;
            display: inline-block;
            width: 100%;
            height: 10px;
            content: "";
        }
        
        .carousel-indicators li::after {
            position: absolute;
            bottom: -10px;
            left: 0;
            display: inline-block;
            width: 100%;
            height: 10px;
            content: "";
        }
        
        .carousel-indicators .active {
            background-color: #fff;
        }
        
        .carousel-caption {
            position: absolute;
            right: 15%;
            bottom: 20px;
            left: 15%;
            z-index: 10;
            padding-top: 20px;
            padding-bottom: 20px;
            color: #fff;
            text-align: center;
        }
        
        .d-none {
            display: none!important;
        }
        
        .d-block {
            display: block!important;
        }
        
        @media (min-width:768px) {
            .d-md-block {
                display: block!important;
            }
        }
        
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            -webkit-clip-path: inset(50%);
            clip-path: inset(50%);
            border: 0;
        }
        
        .w-100 {
            width: 100%!important;
        }
        
        @media print {
            *,
            ::after,
            ::before {
                text-shadow: none!important;
                box-shadow: none!important;
            }
            a:not(.btn) {
                text-decoration: underline;
            }
            img {
                page-break-inside: avoid;
            }
            p {
                orphans: 3;
                widows: 3;
            }
        }
        /*! CSS Used from: https://getbootstrap.com/docs/4.0/assets/css/docs.min.css */
        
        .bd-example {
            position: relative;
            padding: 1rem;
            margin: 1rem -15px 0;
            border: solid #f7f7f9;
            border-width: .2rem 0 0;
        }
        
        .bd-example::after {
            display: block;
            clear: both;
            content: "";
        }
        
        @media (min-width:576px) {
            .bd-example {
                padding: 1.5rem;
                margin-right: 0;
                margin-left: 0;
                border-width: .2rem;
            }
        }
    </style>
</head>

<body>
    <!-- <div id="page-container"> -->
    <div class="row p-0" style="background-color: white;">
        <div class="col-12 p-0">
            <div id="header">
                <div class="adjustContent">
                    <div class="grid grid-nogutter ZeroPadding-Right menu-normal">
                        <div class="col-1 ZeroPadding-Bottom">&nbsp;</div>
                        <div class="col-10 ZeroPadding-Bottom ZeroPadding-Left">
                            <div class="flex-row">
                                <div class="flex-4">
                                    <a href="/index.html" class="ui-link ui-widget"><img src="https://plazapublica.cdmx.gob.mx/assets/logo-d832e68a4bf0d893f62b192a2ab8233761432beb589c74ae807353bdb515df2d.svg" style="float: left;" class="img-header pt-1"></a>
                                </div>
                                <div class="flex-8 ">
                                    <div class="flex flex-wrap card-container yellow-container " style="float:right !important;">
                                        <div class="flex align-items-center justify-content-center h-2rem font-bold border-round m-2">
                                            <a href="https://cdmx.gob.mx/" class="ui-link ui-widget menu-header-principal" target="_blank">Seguimiento a Folios</a>
                                        </div>
                                        <div class="flex align-items-center justify-content-center h-2rem font-bold border-round m-2">
                                            <a href="https://siapem.cdmx.gob.mx/" class="ui-link ui-widget menu-header" target="_blank">Preguntas Frecuentes</a>
                                        </div>
                                        <div class="flex align-items-center justify-content-center h-2rem font-bold border-round m-2">
                                            <a href="{{ route('ipdp.login') }}" class="ui-link ui-widget menu-header">Login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 ZeroPadding-Bottom">&nbsp;</div>
                    </div>

                    <div id="formHeader:idGridMenuRespon" class="ui-panelgrid ui-widget ui-grid-col-12 ZeroPadding-Right menu-responsive" style="margin: 0; width: 100%; text-align: right;">
                        <div id="formHeader:idGridMenuRespon_content" class="ui-panelgrid-content ui-widget-content ui-grid ui-grid-responsive">
                            <div class="ui-grid-row">
                                <div class="ui-panelgrid-cell ui-grid-col-4">
                                    <a href="https://www.cdmx.gob.mx" class="ui-link ui-widget" target="_blank"><img src="https://cdmx.gob.mx/resources/img/adip-header2.svg" style="float: left;" class="img-header pt-1 menu-responsive"></a>
                                </div>
                                <div class="ui-panelgrid-cell ui-grid-col-8"><button id="formHeader:j_idt38" name="formHeader:j_idt38" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only menu-responsive claseButttonHeader" onclick="PF('sidebar1').show()" style="font-size: 25px; background-image: url(/resources/img/menu-mobile.svg); height: 24px; width: 27px; border: none; border-radius: 0;"
                                        type="button" role="button" aria-disabled="false"><span
                                            class="ui-button-text ui-c"></span></button></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12 text-center" style="background-color: #00312d; color: white; padding: 15px;">
                    <div class="container" style="background-color: #00312d; color: white;">CÉDULA PARA LA PRESENTACIÓN DE RECOMENDACIONES, OPINIONES O PROPUESTAS A LOS PROYECTOS DEL PLAN GENERAL DE DE SARROLLO Y DEL PROGRAMA GENERAL DE ORDENAMIENTO TERRITORIAL. AMBOS DE LA CIUDAD DE MÉXICO</div>
                </div>
                <!-- <div class="col-12 p-3 text-center">
                    <h4>Consultar estado de solicitud</h4>

                    <input type="text" class="form-control" placeholder="Ingrese Numero de Folio"
                        aria-label="Ingrese Numero de Folio">

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button">Consultar Folio</button>
                    </div>
                </div> -->

                <div id="formHeader:sidebar1" class="ui-sidebar ui-widget ui-widget-content ui-shadow  ui-sidebar-left" style=".ui-sidebar-close: none; width: 80%; max-width: 400px;" role="dialog" aria-hidden="true">
                    <a href="#" class="ui-sidebar-close ui-corner-all" role="button"><span
                            class="ui-icon ui-icon-closethick"></span></a>
                    <div id="formHeader:idGridMenuSidebarLogo" class="ui-panelgrid ui-widget ui-panelgrid-blank " style="margin:0;width:100%;text-align:left;display: table;">
                        <div id="formHeader:idGridMenuSidebarLogo_content" class="ui-panelgrid-content ui-widget-content ui-grid ui-grid-responsive">
                            <div class="ui-grid-row">
                                <div class="ui-panelgrid-cell ui-grid-col-12 ZeroPadding">
                                    <a href="https://www.cdmx.gob.mx" class="ui-link ui-widget" target="_blank"><img src="https://cdmx.gob.mx/resources/img/adip-header2.svg" style="float: left;" class="img-header"></a>
                                </div>
                                <div class="ui-panelgrid-cell ui-grid-col-12 ZeroPadding opcionxmenuGreen">
                                    <a id="formHeader:j_idt44" href="#" class="ui-commandlink ui-widget" onclick="PF('sidebar1').hide();PrimeFaces.ab({s:&quot;formHeader:j_idt44&quot;});return false;"><img id="formHeader:j_idt45" src="https://cdmx.gob.mx/resources/img/close3.svg?pfdrid_c=true" alt="" class="imagexgreenMenu" style="width: 25px;position: relative; float: right;"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="padding-top: 27px"></div>
                    <div id="formHeader:idGridMenuSidebar" class="ui-panelgrid ui-widget ui-panelgrid-blank " style="margin:0;width:100%;text-align:left;display: table;">
                        <div id="formHeader:idGridMenuSidebar_content" class="ui-panelgrid-content ui-widget-content ui-grid ui-grid-responsive">
                            <div class="ui-grid-row">
                                <div class="ui-panelgrid-cell ui-grid-col-12 ZeroPadding">
                                    <hr style="color: #f0f1f6; border: solid;"><a href="https://cdmx.gob.mx/" class="ui-link ui-widget fontRespSidebar opcionmenuGreen">Residentes</a>
                                    <hr style="color: #f0f1f6; border: solid;"><a href="https://siapem.cdmx.gob.mx/" class="ui-link ui-widget fontRespSidebar opcionmenuGreen">Negocios</a>
                                    <hr style="color: #f0f1f6; border: solid;"><a href="https://thecity.mx/" class="ui-link ui-widget fontRespSidebar opcionmenuGreen">Visitantes</a>
                                    <hr style="color: #f0f1f6; border: solid;"><a href="https://gobierno.cdmx.gob.mx/" class="ui-link ui-widget fontRespSidebar opcionmenuGreen">Gobierno</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="color: #f0f1f6; border: solid;">
                </div>


            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bd-example">
                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="https://via.placeholder.com/900x200.png" alt="First slide" />
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>AVISOS GENERALES</h5>
                                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://via.placeholder.com/900x200.png" alt="Second slide" />
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Second slide label</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://via.placeholder.com/900x200.png" alt="Third slide" />
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Third slide label</h5>
                                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6">
                
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="text-center">REGISTRO DE CEDULA</h3>
                        Presenta tus Recomendaciones, Opiniones o Propuestas y participa en la consulta ciudadana que la CDMX te ofrece. 
                        <br>
                        Da click en "REGISTRAR CEDULA" para presentar tu propuesta.
                    </div>
                    <div class="col-8 offset-md-2">
                        <div class="d-grid col-12">
                            <a class="btn btn-primary" href="{{ route('ipdp.registra_cedula') }}">REGISTRAR CEDULA</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>SEGUIMIENTO DE FOLIOS</h3>
                        Si ya tienes un folio capturado.
                        <br>
                        Consulta en esta sección, el progreso de tu cedula.
                    </div>
                    <div class="col-8 offset-md-2">
                        <div class="d-grid col-12">
                            <input class="form-control" type="text" placeholder="Ingresa el numero de folio">
                            <button class="btn btn-primary" type="button">CONSULTAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row p-0">
            <div class="col-12 p-0">
                <div id="footer">
                    <div class="grid grid-nogutter colorgreen">
                        <div class="col-1">&nbsp;</div>
                        <div class="col-10">
                            <div class="grid pt-5">
                                <div class="lg:col-3 md:col-6"><img src="https://cdmx.gob.mx/resources/img/logo_footer.svg" style="max-width: 100%; width: 219.5px; height: 55px; padding-left: 2%; vertical-align: middle;">
                                </div>
                                <div class="lg:col-2 md:col-3 sm:col-12 xs:col-12">
                                    <div class="grid p-0">
                                        <div class="col-12"><label style="padding-bottom: 2%; font-family: Inter; font-size: 13.1px; font-weight: bold; font-stretch: normal; font-style: normal; line-height: 1.18; letter-spacing: -0.39px; text-align: left; color: #fff;" class="titulosRobo redesleft">Redes de la ciudad</label>
                                        </div>
                                        <div class="col-12">
                                            <div class="grid p-0">
                                                <div class="col-3">
                                                    <a href="https://es-la.facebook.com/GobiernoCDMX/" class="ui-link ui-widget" target="_blank"><img id="j_idt411" src="https://cdmx.gob.mx/resources/img/facebook.svg?pfdrid_c=true" alt="" style="width: 27.7px; height: 27.7px;"></a>
                                                </div>
                                                <div class="col-3">
                                                    <a href="https://twitter.com/GobCDMX" class="ui-link ui-widget" target="_blank"><img id="j_idt414" src="https://cdmx.gob.mx/resources/img/twitter.svg?pfdrid_c=true" alt="" style="width: 30.8px; height: 24.6px;"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:col-3 md:col-6 sm:col-12 xs:col-12">
                                    <div class="grid p-0">
                                        <div class="col-12"><a href="tel:911" class="ui-link ui-widget titulo-footer" target="_blank">Ir a Portal de Plaza Publica</a>
                                        </div>
                                        <div class="col-12"><label class="footerAlingleft">Emergencias</label>
                                        </div>

                                        <div class="col-12"><label style="padding-bottom: 2%;" class="titulo-footer">Transparencia</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:col-2 md:col-6 sm:col-12 xs:col-12">
                                    <div class="grid p-0">
                                        <div class="col-12"><a href="tel:5555335533" class="ui-link ui-widget titulo-footer" style="padding-bottom: 2% !important;" target="_blank">55 1111 1111</a>
                                        </div>
                                        <div class="col-12"><label style="padding-bottom: 5%;" class="footerAlingleft">Consejo
                                                Ciudadano</label>
                                        </div>

                                        <div class="col-12"><a href="tel:5556581111" class="ui-link ui-widget titulo-footer" style="color: white; padding-bottom: 2%;" target="_blank">55 1111
                                                1111</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="lg:col-2 md:col-6 sm:col-12 xs:col-12">
                                    <div class="grid p-0 grecaFooter-Datos-Abiertos">
                                        <div class="col-12" style="padding-bottom: 0!important;"><a
                                                href="http://datos.cdmx.gob.mx/" class="ui-link ui-widget"
                                                target="_blank"><img id="j_idt432"
                                                    src="https://cdmx.gob.mx/resources/img/datos.png?pfdrid_c=true" alt=""
                                                    style="width: 131px; height: 81px;"></a>
                                        </div>
                                        <div class="col-12" style="padding-top: 0!important;"><label
                                                style="padding-bottom: 5%;" class="footerAlingleft">Portal de datos
                                                abiertos</label>
                                            <br><label style="padding-bottom: 5%;" class="footerH6Alingleft">Explora,
                                                analiza,
                                                visualiza y descarga bases de datos de la CDMX</label>
                                        </div>
                                    </div>
                                </div> -->

                            </div>
                        </div>
                        <div class="col-1">&nbsp;</div>
                    </div>
                    <div class="espacio-cintillo"></div>
                    <div class="cintilloFooter colorgreen"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        const myCarouselElement = document.querySelector('#carouselExampleCaptions')
        const carousel = new bootstrap.Carousel(myCarouselElement, {
            interval: 2000
        })
    </script>
</body>

</html>