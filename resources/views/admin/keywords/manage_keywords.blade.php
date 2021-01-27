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
                <h1 class="text-center">Identify potential Keywords</h1>
                <h2 class="text-center">{{ $word->word }}</h2>
            </div>
            <div class="col-12">
                <form method="POST" action="{{ route('admin.keywords.manage') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $word->id }}">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_tag" name="is_tag">
                        <label class="form-check-label" for="is_tag">
                            ¿ Es valido para ser considerado un tag ?
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_valid_for_title" name="is_valid_for_title">
                        <label class="form-check-label" for="is_valid_for_title">
                            ¿Es valido para incluirse en titulo?
                        </label>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        
    </script>
  @endsection