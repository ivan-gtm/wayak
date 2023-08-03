@extends('layouts.admin')

@section('title', ' Carousels')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">

<meta data-rh="true" charset="UTF-8">
<meta data-rh="true" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">

{{--
        <meta data-rh="true" name="google-site-verification" content="">
        <meta data-rh="true" name="apple-itunes-app" content="">
        <meta data-rh="true" name="google" content="no-translate">
--}}

@endsection

@section('content')
<div class="col-12">
    <form class="form___1I3Xs" novalidate="" method="GET" action="{{ route('admin.carousels.step2',['country' => $country]) }}">
        @csrf
        <br>
        <div class="sc-dmlrTW guKkvw">
            <input type="text" autocomplete="off" name="carouselTitle" id="carouselTitle" class="form-control" value="{{ $current_title }}" style="padding-left: 20px;" placeholder="title" autofocus>
        </div>
        <br>
        <div class="sc-dmlrTW guKkvw">
            <input type="text" autocomplete="off" name="searchQuery" id="searchQuery" class="form-control" value="{{ $search_query }}" style="padding-left: 20px;" placeholder="Termino de busqueda">
        </div>
        <br>
        <div class="inputControls___BVQJr right___3zI72">
            <button onclick="setCarouselTitle()" class="form-control" data-categ="homeSearchForm" data-value="submit">SET TITLE</button>
        </div>
    </form>
</div>

<script>
    function setCarouselTitle(){
        var carouselTitle = document.getElementById('carouselTitle');
        saveTemplateName(carouselTitle.value);
        window.location.href = '{{ route('admin.carousels.step2',['country' => $country]) }}';
    }

    function getTemplateName() {
        return localStorage.getItem('templateName');
    }

    function saveTemplateName(templateName) {
        localStorage.setItem('templateName', templateName);
    }

    function clearLocalStorage() {
        // Clear local storage
        localStorage.clear();
    }

    function onLoad() {
        clearLocalStorage()
    }

    // Add the onload event listener to the window object
    window.addEventListener("load", onLoad);

</script>
@endsection