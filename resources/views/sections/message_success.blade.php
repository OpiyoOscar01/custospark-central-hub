@extends('layouts.main')
@section('title','Thank You')  
@section('description','Custospark is a leading provider of innovative solutions, specializing in technology and consulting services. Our mission is to empower businesses with cutting-edge strategies and tools to thrive in the digital age. Explore our diverse range of services and discover how we can help you achieve your goals.')
@section('keywords','Custospark, technology, solutions, innovation, success.software development, consulting, digital transformation, IT services, business solutions')
@section('author','Custospark')
@section('content')
<section id="contact-confirmation" class="bg-gradient-to-r from-blue-600 via-black to-blue-600 text-white py-20 text-center">
  <div class="max-w-7xl mx-auto px-4">
    <h1 class="text-4xl font-bold mb-6">Thank You for Reaching Out!</h1>
    <p class="text-lg mb-6">Your message has been successfully sent. We appreciate you contacting us and will get back to you as soon as possible.</p>
    
    <!-- Next Steps Section -->
    <div class="mb-8">
      <h2 class="text-2xl font-semibold mb-4">What to Expect</h2>
      <p class="text-lg">Our team has received your message and will respond via email within the next 24–48 hours. Please check your inbox (and spam folder just in case). We look forward to continuing the conversation!</p>
    </div>
    
    <!-- CTA Buttons -->
    <div class="flex justify-center gap-8 mt-6 flex-wrap">
      <a href="{{ route('contact-us') }}" class="bg-black text-white px-6 py-3 rounded-md text-lg font-bold hover:bg-blue-500 transition-all">Send Another Message</a>
      <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-3 rounded-md text-lg font-bold hover:bg-blue-700 transition-all">Return to Homepage</a>
    </div>
  </div>
</section>

<!-- Optional Success/Trust Section -->
<section id="trust-section" class="py-20 bg-gradient-to-r from-blue-600 via-black to-blue-600 text-center">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-white mb-8">You're in Good Company</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="testimonial-card p-6 bg-white text-black rounded-lg shadow-lg">
        <p class="italic text-gray-600 mb-4">"I reached out with an idea and the Custospark team got back to me fast. We’re now actively building something exciting together!"</p>
        <p class="font-semibold text-blue-900">Daniel K.</p>
        <p class="text-sm text-gray-500">Innovator & Collaborator</p>
      </div>
      <div class="testimonial-card p-6 bg-white text-black rounded-lg shadow-lg">
        <p class="italic text-gray-600 mb-4">"Their response was thoughtful and personalized. I felt truly heard and appreciated. Highly recommend reaching out!"</p>
        <p class="font-semibold text-blue-900">Grace M.</p>
        <p class="text-sm text-gray-500">Investor, GM Ventures</p>
      </div>
    </div>
  </div>
</section>

<style>
  /* Testimonial Card Styling */
  .testimonial-card {
    background-color: rgba(255, 255, 255, 0.95);
  }

  .testimonial-card p {
    font-style: italic;
    color: #616161;
  }

  /* Button Hover Effects */
  a:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  /* Mobile responsiveness */
  @media (max-width: 768px) {
    .testimonial-card {
      max-width: 90%;
    }
  }
</style>
@include('about_us.location')
@endsection