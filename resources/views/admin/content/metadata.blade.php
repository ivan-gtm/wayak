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
            <h4 class="text-center">{{ $template->title }}</h4>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.edit.template',[
                    'language_code' => $language_code,
                    'template_key' => $template->template_id
                ]) }}">
                <img class="img-fluid" src="{{ $thumbnail }}">
            </a>
        </div>
        <div class="col-sm-9">
            <form method="POST" action="{{ route('admin.metadata.product') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $template->id }}">
                Template Name
                <input class="form-control" type="text" name="name" value="{{ $title }}" onkeyup="buildSlug(this);">
                Slug
                <input class="form-control" id="slug" type="text" name="slug" value="{{ $slug }}">
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        function buildSlug(element){
            var slug = "";
            var title = $(element).val();
            var words = title.match(/[a-zA-Z]+/g);
            var slug = words.join('-').toLowerCase();
            $('#slug').val(slug);
        }
    </script>
  @endsection