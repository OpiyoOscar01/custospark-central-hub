@extends('layouts.main')

@section('title', 'Investor Relations')  
@section('description', 'Explore Custospark’s growth story and discover investment opportunities with a company that is transforming technology and business solutions across industries. Join us in shaping the future of innovation and scalability.')
@section('keywords', 'Custospark investors, investment opportunities, business growth, technology innovation, scalable solutions, startup investment, global impact, financial growth, emerging markets, Custospark growth strategy')
@section('author', 'Custospark')

@section('content')
@include('investors.overview')
 @include('about_us.mission')
 @include('about_us.vision')
 @include('investors.finance')
 @include('investors.business_strategy')
 @include('investors.market_analysis')
 {{-- @include('investors.leadership') --}}
 @include('investors.assets')
 {{-- @include('investors.cta') --}}

@endsection
