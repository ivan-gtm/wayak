@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')

               <!-- start page title -->
               <div class="row">
                  <div class="col-12">
                     <div class="page-title-box">
                        
                        <h4 class="page-title">Tablero Edición de plantillas</h4>
                     </div>
                  </div>
               </div>
               <!-- end page title -->
               <div class="row">
                  <div class="col-12">
                     <div class="row">
                        

                        <div class="col-6">
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route('green.products', [ 'category_id' => 201 ]) }}" class="card-link">
                                            <h4>
                                                1 .- Corregir formato de plantillas ( Falta ajustar formato )
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route( 'admin.ml.getFormatReady' ) }}" class="card-link">
                                            <h4>
                                                2.- Plantillas con Formato OK.
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route( 'admin.bulkTranslateText', ['from' => 'en', 'to' => 'es'] ) }}" class="card-link">
                                            <h4>
                                                3.- Traducción masiva
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route( 'admin.ml.getTranslationReady' ) }}" class="card-link">
                                            <h4>
                                                4.- Plantillas traducidas
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route( 'admin.ml.getThumbnailReady' ) }}" class="card-link">
                                            <h4>
                                                5.- Plantillas con vista previa
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route('admin.generateProductThumbnails') }}" class="card-link">
                                            <h4>
                                                6.- Generar imagenes "vistas previa de producto" para Mercado Libre
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route('admin.ml.getMissingMetadataTemplates') }}" class="card-link">
                                            <h4>
                                                7.- Falta editar metadatos ( Ficha del producto )
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route( 'admin.ml.templatesReadyForSale' ) }}" class="card-link">
                                            <h4>
                                                8.- Plantillas listas para la venta ( formato, lenguage, descripción del producto ).
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <!-- <a href="{{ route( 'admin.ml.templatesReadyForSale' ) }}" class="card-link"> -->
                                        <a href="{{ route( 'admin.ml.mercadoLibreCatalog' ) }}" class="card-link">
                                            <h4>
                                                9.- Generar Formato Excel
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <a href="{{ route( 'admin.template.gallery', ['country' => 'mx'] ) }}" class="card-link">
                                            <h4>
                                                10.- Plantillas en venta ( Mercado Libre )
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col-->
                        <!-- end col-->
                     </div>
                     <!-- end row -->
                     <!-- end row -->
                  </div>
                  <!-- end col -->
                  <!-- end col -->
               </div>
               <!-- end row -->
               <!-- end row -->
               <!-- end row -->
@endsection