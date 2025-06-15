<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title','Account') - Custospark</title>
    <link rel="icon" href="{{ asset('images/v8.png') }}" type="image/x-icon" />
  <meta name="description" content="@yield('description', 'Custospark: Cutting-edge tech solutions to innovate, accelerate, and succeed')" />
  <meta name="keywords" content="@yield('keywords', 'Custospark, technology, solutions, innovation, success')" />
  <meta name="author" content="@yield('author', 'Custospark')" />
  

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />


  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <style>
    body {
      background: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)),
      url('{{ asset('images/bg.png') }}');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
  </style>
  @yield('styles')
</head>
<body class="min-h-screen flex flex-col text-white relative overflow-x-hidden ">

  <!-- Top Navigation -->
  <nav class="w-full bg-blue-500  px-4 sm:px-8 py-4 fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
         <a href="{{route('home')}}" class="flex items-center gap-2 group transition duration-300 ease-in-out">
        <img 
          src="{{ asset('images/v8.png') }}" 
          alt="Custospark Logo" 
          class="w-8 h-8 sm:w-10 sm:h-10 object-contain rounded-full border-2 border-blue-300 shadow-md transform group-hover:scale-105 transition"
        />
        <span class="font-bold text-xl text-white transition duration-300 ease-in-out">
          Custospark
        </span>
      </a>

      <!-- Hamburger Button -->
      <button id="menuToggle" class="sm:hidden text-white text-2xl focus:outline-none">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Desktop Links -->
      <div class="hidden sm:flex space-x-6 text-sm sm:text-base">
    <a href="{{ route('home') }}"
       class="@if(request()->is('/')) text-yellow-400 underline @else hover:text-white @endif transition">
        <i class="bi bi-house-door-fill mr-1"></i> Home
    </a>
    <a href="{{ route('login') }}"
       class="@if(request()->is('login')) text-yellow-400 underline @else hover:text-blue-300 @endif transition">
        <i class="bi bi-box-arrow-in-right mr-1"></i> Login
    </a>
    <a href="{{ route('register') }}"
       class="@if(request()->is('/signup')) text-yellow-400 underline @else hover:text-white @endif transition">
        <i class="bi bi-person-plus-fill mr-1"></i> Register
    </a>
</div>

      </div>
    </div>
  </nav>

  <!-- Overlay -->
  {{-- <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div> --}}

  <!-- Mobile Slide-in Menu with Glass Effect -->
  <div id="mobileMenu" class="fixed top-0 right-0 w-64 h-full bg-gradient-to-b from-blue-500 via-black to-blue-500 text-whiteshadow-2xl transform translate-x-full transition-transform duration-300 z-50 sm:hidden flex flex-col p-6 space-y-4">

    <div class="flex justify-between items-center mb-4">
        <span class="text-lg font-semibold text-white">Menu</span>
        <button id="closeMenu" class="text-white text-xl focus:outline-none">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <hr class ="text-white">

    <a href="{{ route('home') }}"
       class="block px-2 py-2 rounded no-underline text-white @if(request()->is('/')) bg-blue-600 @else hover:bg-blue-500 @endif">
        <i class="bi bi-house-door-fill mr-2"></i> Home
    </a>

    <a href="{{ route('login') }}"
       class="block px-2 py-2 rounded no-underline text-white @if(request()->is('login')) bg-blue-600 @else hover:bg-blue-500 @endif">
        <i class="bi bi-box-arrow-in-right mr-2"></i> Login
    </a>

    <a href="{{ route('register') }}"
       class="block px-2 py-2 rounded no-underline text-white @if(request()->is('register')) bg-blue-600 @else hover:bg-blue-500 @endif">
        <i class="bi bi-person-plus-fill mr-2"></i> Register
    </a>
</div>


  <!-- Page Content -->
  <main class="flex-grow pt-20 flex items-center justify-center mb-10 mt-10">
    @include('common.toast')
    @yield('content')
  </main>
    @include('sections.footer')


  <script>
    const menuToggle = document.getElementById('menuToggle');
    const closeMenu = document.getElementById('closeMenu');
    const mobileMenu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('overlay');

    const openMenu = () => {
      mobileMenu.classList.remove('translate-x-full');
      overlay.classList.remove('hidden');
    }

    const closeSlideMenu = () => {
      mobileMenu.classList.add('translate-x-full');
      overlay.classList.add('hidden');
    }

    menuToggle.addEventListener('click', openMenu);
    closeMenu.addEventListener('click', closeSlideMenu);
    overlay.addEventListener('click', closeSlideMenu);
  </script>

  @yield('scripts')
</body>
</html>
