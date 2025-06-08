@php
$layout=Auth::check() ? 'layouts.employee' : 'layouts.main';
@endphp
@extends($layout)
@section('title','Community Updates')
@section('description','Custospark is a leading provider of innovative solutions, specializing in technology and consulting services. Our mission is to empower businesses with cutting-edge strategies and tools to thrive in the digital age. Explore our diverse range of services and discover how we can help you achieve your goals.')
@section('keywords','Custospark, technology, solutions, innovation, success.software development, consulting, digital transformation, IT services, business solutions')
@section('author','Custospark')
@section('content')
@include('blog.public.index')
@include('blog.public.main-content-blog')
@endsection










