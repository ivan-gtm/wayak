@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('The link you clicked may be broken or the page may have been removed.<br>visit the <a href="index.html"> <span> Homepage</span></a> or <a href="page-contact.html"><span>Contact us</span></a> about the problem.'))
