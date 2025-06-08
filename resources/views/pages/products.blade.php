@extends('layouts.main')

@section('title','Custosell - Powering Smart Businesses')  

@section('description', 'Discover Custosell by Custospark — the ultimate SaaS platform designed to help businesses manage sales, operations, and customer engagement in one place. Empower your business with intelligent, scalable tools built for growth.')

@section('keywords', 'Custosell, Custospark, business management platform, SaaS, customer engagement, inventory management, sales tools, smart businesses, all-in-one business software')

@section('author', 'Custospark')

@section('content')
  <!-- Overview: Introduce Custosell and who it's for -->
  @include('products.custosell.overview')

  <!-- Features: Showcase key features and how they solve problems -->
  @include('products.custosell.features')

  <!-- Why Choose Custosell: Reasons to choose Custosell over competitors -->
  @include('products.custosell.why_choose')

  <!-- Testimonials: Real user feedback and success stories -->
  @include('products.custosell.testimonials')

  <!-- Target Users: Who benefits most from Custosell -->
  @include('products.custosell.target_users')

  <!-- FAQs: Address common questions or concerns -->
  @include('products.custosell.faqs')

  <!-- CTA: Strong call to action, inviting users to start a free trial or sign up -->
  @include('products.custosell.cta')
@endsection

