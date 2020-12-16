@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('css')

    <style>
        /*! CSS Used from: https://coderthemes.com/hyper/saas/assets/css/app.min.css */
        *,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box;}
        h4{margin-top:0;margin-bottom:1.5rem;}
        p{margin-top:0;margin-bottom:1rem;}
        ul{margin-top:0;margin-bottom:1rem;}
        a{color:#727cf5;text-decoration:none;background-color:transparent;}
        a:hover{color:#2b3af0;text-decoration:none;}
        code,pre{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em;}
        pre{margin-top:0;margin-bottom:1rem;overflow:auto;-ms-overflow-style:scrollbar;}
        table{border-collapse:collapse;}
        th{text-align:inherit;}
        label{display:inline-block;margin-bottom:.5rem;}
        input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit;}
        input{overflow:visible;}
        input[type=checkbox]{-webkit-box-sizing:border-box;box-sizing:border-box;padding:0;}
        h4{margin-bottom:1.5rem;font-weight:400;line-height:1.1;}
        h4{font-size:1.125rem;}
        code{font-size:87.5%;color:#39afd1;word-wrap:break-word;}
        pre{display:block;font-size:87.5%;color:#212529;}
        .table{width:100%;margin-bottom:1.5rem;color:#6c757d;}
        .table td,.table th{padding:.95rem;vertical-align:top;border-top:1px solid #eef2f7;}
        .table thead th{vertical-align:bottom;border-bottom:2px solid #eef2f7;}
        @media (max-width:575.98px){
        .table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;}
        }
        .nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none;}
        .nav-link{display:block;padding:.5rem 1rem;}
        .nav-link:focus,.nav-link:hover{text-decoration:none;}
        .nav-tabs{border-bottom:1px solid #dee2e6;}
        .nav-tabs .nav-item{margin-bottom:-1px;}
        .nav-tabs .nav-link{border:1px solid transparent;border-top-left-radius:.25rem;border-top-right-radius:.25rem;}
        .nav-tabs .nav-link:focus,.nav-tabs .nav-link:hover{border-color:#e9ecef #e9ecef #dee2e6;}
        .nav-tabs .nav-link.active{color:#495057;background-color:#fff;border-color:#dee2e6 #dee2e6 #fff;}
        .tab-content>.tab-pane{display:none;}
        .tab-content>.active{display:block;}
        .card-body{-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto;min-height:1px;padding:1.5rem;}
        .d-block{display:block!important;}
        .mb-0{margin-bottom:0!important;}
        .mb-3{margin-bottom:1.5rem!important;}
        .text-muted{color:#98a6ad!important;}
        @media print{
        *,::after,::before{text-shadow:none!important;-webkit-box-shadow:none!important;box-shadow:none!important;}
        a:not(.btn){text-decoration:underline;}
        pre{white-space:pre-wrap!important;}
        pre{border:1px solid #adb5bd;page-break-inside:avoid;}
        thead{display:table-header-group;}
        tr{page-break-inside:avoid;}
        p{orphans:3;widows:3;}
        .table{border-collapse:collapse!important;}
        .table td,.table th{background-color:#fff!important;}
        }
        .card .header-title{margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.02em;font-size:.9rem;margin-top:0;}
        .hljs{display:block;overflow-x:auto;padding:2em;color:#313a46;max-height:420px;margin:-10px 0 -30px;border:1px solid rgba(152,166,173,.2);}
        .hljs-tag .hljs-attr{color:#02a8b5;}
        .hljs-string{color:#fa5c7c;}
        .hljs-name,.hljs-tag{color:#0768d1;font-weight:400;}
        .hljs-comment{color:#ced4da;}
        .nav-tabs>li>a{color:#6c757d;font-weight:600;}
        .nav-tabs.nav-bordered{border-bottom:2px solid rgba(152,166,173,.2);}
        .nav-tabs.nav-bordered .nav-item{margin-bottom:-2px;}
        .nav-tabs.nav-bordered li a{border:0;padding:.625rem 1.25rem;}
        .nav-tabs.nav-bordered li a.active{border-bottom:2px solid #727cf5;}
        @media print{
        .card-body{padding:0;margin:0;}
        }
        a{outline:0!important;}
        label{font-weight:600;}
        input[data-switch]{display:none;}
        input[data-switch]+label{width:56px;height:24px;background-color:#f1f3fa;background-image:none;border-radius:2rem;cursor:pointer;display:inline-block;text-align:center;position:relative;-webkit-transition:all .1s ease-in-out;transition:all .1s ease-in-out;}
        input[data-switch]+label:before{color:#313a46;content:attr(data-off-label);display:block;font-family:inherit;font-weight:600;font-size:.75rem;line-height:24px;position:absolute;right:3px;margin:0 .21667rem;top:0;text-align:center;min-width:1.66667rem;overflow:hidden;-webkit-transition:all .1s ease-in-out;transition:all .1s ease-in-out;}
        input[data-switch]+label:after{content:'';position:absolute;left:4px;background-color:#adb5bd;-webkit-box-shadow:none;box-shadow:none;border-radius:2rem;height:18px;width:18px;top:3px;-webkit-transition:all .1s ease-in-out;transition:all .1s ease-in-out;}
        input[data-switch]:checked+label{background-color:#727cf5;}
        input[data-switch]:checked+label:before{color:#fff;content:attr(data-on-label);right:auto;left:4px;}
        input[data-switch]:checked+label:after{left:34px;background-color:#f1f3fa;}
        input:disabled+label{opacity:.5;cursor:default;}
        input[data-switch=success]:checked+label{background-color:#0acf97;}
        .table-centered td,.table-centered th{vertical-align:middle!important;}
        h4{margin:10px 0;font-weight:700;}
        .font-14{font-size:14px!important;}

        /*! CSS Used from: https://coderthemes.com/hyper/saas/assets/css/app.min.css */
    *,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box;}
    ol{margin-top:0;margin-bottom:1rem;}
    a{color:#727cf5;text-decoration:none;background-color:transparent;}
    a:hover{color:#2b3af0;text-decoration:none;}
    .breadcrumb{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding:1rem 0;margin-bottom:1rem;list-style:none;background-color:transparent;border-radius:.25rem;}
    .breadcrumb-item{display:-webkit-box;display:-ms-flexbox;display:flex;}
    .breadcrumb-item+.breadcrumb-item{padding-left:.5rem;}
    .breadcrumb-item+.breadcrumb-item::before{display:inline-block;padding-right:.5rem;color:#ced4da;content:"󰅂";}
    .breadcrumb-item+.breadcrumb-item:hover::before{text-decoration:underline;}
    .breadcrumb-item+.breadcrumb-item:hover::before{text-decoration:none;}
    .breadcrumb-item.active{color:#adb5bd;}
    .m-0{margin:0!important;}
    @media print{
    *,::after,::before{text-shadow:none!important;-webkit-box-shadow:none!important;box-shadow:none!important;}
    a:not(.btn){text-decoration:underline;}
    }
    .page-title-box .page-title-right{float:right;margin-top:20px;}
    .page-title-box .breadcrumb{padding-top:8px;}
    @media (max-width:767.98px){
    .page-title-box .breadcrumb{display:none;}
    .page-title-box .page-title-right{display:none;}
    }
    @media (max-width:419px){
    .page-title-box .breadcrumb{display:none;}
    }
    .breadcrumb-item+.breadcrumb-item::before{font-family:"Material Design Icons";font-size:16px;line-height:1.3;}
    a{outline:0!important;}
    /*! CSS Used fontfaces */
    @font-face{font-family:"Material Design Icons";src:url(https://coderthemes.com/hyper/saas/assets/fonts/materialdesignicons-webfont.eot?v=5.5.55);src:url(https://coderthemes.com/hyper/saas/assets/fonts/materialdesignicons-webfont.eot#iefix&v=5.5.55) format("embedded-opentype"),url(https://coderthemes.com/hyper/saas/assets/fonts/materialdesignicons-webfont.woff2?v=5.5.55) format("woff2"),url(https://coderthemes.com/hyper/saas/assets/fonts/materialdesignicons-webfont.woff?v=5.5.55) format("woff"),url(https://coderthemes.com/hyper/saas/assets/fonts/materialdesignicons-webfont.ttf?v=5.5.55) format("truetype");font-weight:400;font-style:normal;}
    </style>
@endsection

@section('content')
<div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                            <li class="breadcrumb-item active">Basic Tables</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Basic Tables</h4>
                                </div>
                            </div>
                        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>Creado</th>
                                    <th>Nombre del archivo</th>
                                    <th>Archivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    <tr>
                                        <td>{{ $file->created_at }}</td>
                                        <td>336-508-2157</td>
                                        <td>
                                            <a href="{{ route('admin.ml.mercadoLibreExcelProducts',[ $file->id ]) }}">VER</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection