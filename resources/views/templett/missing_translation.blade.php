@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
        <div class="row">
            <div class="col-12 text-center">
                <h1>Plantillas, falta traducir</h1>
            </div>
            @foreach ($product_result as $product )
                <div class="col-3">
                    <a href="{{ route('admin.edit.template', [
                            'language_code' => 'en',
                            'template_key' => $product->template_id
                        ]) }}">
                        <img class="img-fluid" src="{{ $product->PreviewImage }}">
                    </a>
                    <!-- $product->title -->
                </div>
            @endforeach
        </div>

@endsection