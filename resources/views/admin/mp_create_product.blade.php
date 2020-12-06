@extends('layouts.admin')

@section('title', 'Plantillas Formato Listo')

@section('css')
<style>
      .box {
        position: relative;
        margin: 20px auto;
        /* width: 400px;
        height: 350px; */
        background: #fff;
        border-radius: 2px;
      }

      .box::before,
      .box::after {
        content: '';
        position: absolute;
        bottom: 10px;
        width: 40%;
        height: 10px;
        box-shadow: 0 5px 14px rgba(0,0,0,.7);
        z-index: -1;
        transition: all .3s ease-in-out;
      }

      .box::before {
        left: 15px;
        transform: skew(-5deg) rotate(-5deg);
      }

      .box::after {
        right: 15px;
        transform: skew(5deg) rotate(5deg);
      }

      .box:hover::before,
      .box:hover::after {
        box-shadow: 0 2px 14px rgba(0,0,0,.4);
      }

      .box:hover::before {
        left: 5px;
      }

      .box:hover::after {
        right: 5px;
      }
</style>
@endsection

@section('content')
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Editar Metadatos del producto</h1>
            </div>
            <div class="col-3">
                <img class="img-fluid" src="{{ $thumb_img_url }}">
            </div>
            <div class="col-9">
                <form method="POST" action="{{ route('admin.createTemplate',[$template_key]) }}">
                    @csrf
                    <input name="codigo_universal" type="hidden" value="No aplica">
                    <input name="sku" type="hidden" value="{{ $template_key }}">
                    <input name="cantidad" type="hidden" value="99999">
                    <input name="precio" type="hidden" value="50">
                    <input name="moneda" type="hidden" value="$">
                    <input name="condicion" type="hidden" value="Nuevo">
                    <input name="tipo_publicacion" type="hidden" value="Premium">
                    <input name="forma_envio" type="hidden" value="Mercado Envíos">
                    <input name="costo_envio" type="hidden" value="Ofreces envío gratis">
                    <input name="retiro_persona" type="hidden" value="No acepto">
                    <input name="tipo_garantia" type="hidden" value="Garantía del vendedor">
                    <input name="tiempo_garantia" type="hidden" value="3">
                    <input name="unidad_tiempo_garantia" type="hidden" value="días">
                    <input name="marca" type="hidden" value="Wayak">
                    <input name="formato" type="hidden" value="Digital">
                    <input name="largo" type="hidden" value="17.78">
                    <input name="unidad_largo" type="hidden" value="cm">
                    <input name="ancho" type="hidden" value="12.7">
                    <input name="unidad_ancho" type="hidden" value="cm">
                    <input name="material" type="hidden" value="JPG,PNG" >
                    <input name="modelo" type="hidden" value="{{ $modelo }}">

                    <div class="mb-3">
                        <label for="titleInput" class="form-label">Título</label>
                        <input class="form-control" name="titulo" type="text" value="{{ $titulo }}" maxlength="60" required>
                        <!-- <ul>
                            <li>Obligatorio"</li>
                            <li>ingresa solo producto, marca y modelo </li>
                            <li>Máximo 60 caracteres.</li> -->
                            <!-- <li>Una vez que vendas no podrás editarlo.</li>
                        </ul> -->
                    </div>
                    <div class="mb-3">
                        <label for="titleInput" class="form-label">Ocasiones</label>
                        <!-- <ul>
                            <li>Obligatorio"</li>
                        </ul> -->
                            <select class="form-select" name="ocasion" id="ocasion" required>
                                <option value="">Selecciona Valor</option>
                                <option value="Aniversario">Aniversario</option>
                                <option value="Baby shower">Baby shower</option>
                                <option value="Bautizo">Bautizo</option>
                                <option value="Boda">Boda</option>
                                <option value="Cumpleaños">Cumpleaños</option>
                                <option value="Despedida de soltera">Despedida de soltera</option>
                                <option value="Despedida de soltero">Despedida de soltero</option>
                                <option value="Fiesta de 15 años">Fiesta de 15 años</option>
                                <option value="Graduación">Graduación</option>
                                <option value="Halloween">Halloween</option>
                                <option value="Primera comunión">Primera comunión</option>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label for="titleInput" class="form-label">Imágenes</label>
                        <input class="form-control" name="imagenes" type="text" value="{{ $product_images }}" required>
                        <!-- <ul>
                            <li>Obligatorio</li>
                            <li>Ingresa las URLs separadas por comas.</li>
                            <li>Formatos permitidos: .jpg, .png, .bmp, .webp. </li>
                            <li>Tamaño mínimo: 500 px en alguno de sus lados.</li>
                        </ul> -->
                    </div>
                    
                    <div class="mb-3">
                        <label for="titleInput" class="form-label">Descripción	</label>
                        <!-- <ul>
                            <li>No incluyas datos de contacto como e-mails, teléfonos, direcciones, links externos y redes sociales.</li>
                        </ul> -->
                        <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="10" required>{{ $description }}</textarea>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="titleInput" class="form-label">Link de YouTube</label>
                        <input type="text" value="">
                    </div> -->
                    <!-- <div class="mb-3">
                        <label for="titleInput" class="form-label">Disponibilidad de stock [días] == XXXXX NO APLICA</label>
                        <input type="text" value="">
                        <ul>
                            <li>Entre 1 y 45 días</li>
                        </ul>
                    </div> -->
                    

                    <!-- <div class="mb-3">
                        <label for="titleInput" class="form-label">Fabricante == Jazmin</label>
                        <input type="text" value="Wayak">
                    </div> -->
                    
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/tags/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        @if( strlen($ocasion) > 0 )
            // alert("jell");
            $('select[name="ocasion"] option[value="{{ $ocasion }}"]').attr('selected', 'selected');
        @endif

        // $(document).on("keydown", "form>input", function(event) { 
        //     return event.key != "Enter";
        // });
        $('input.tags').tagsinput({
            maxTags: 13,
            trimValue: true,
            allowDuplicates: false,
            confirmKeys: [44]
        });
        $('input.tags').on('itemAdded', function(event) {
            console.log( $("input.tags").val() );
        });
    </script>
  @endsection