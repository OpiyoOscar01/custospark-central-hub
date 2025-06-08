@extends('layouts.main')
@section('title','Careers')  
@section('description', 'Join Custospark and be part of a dynamic, innovative team that is shaping the future of technology and business solutions. Discover exciting career opportunities and contribute to empowering businesses globally.')
@section('keywords', 'Custospark careers, job opportunities, technology roles, innovation, success, software development, consulting, digital transformation, IT careers, remote work, team collaboration')
@section('author', 'Custospark')

@section('content')
@include('careers.jobs')
{{-- @include('careers.values') --}}
{{-- @include('careers.team_testimonial') --}}
@include('careers.application_process')
@include('careers.perks')
@include('careers.faqs')
@endsection
