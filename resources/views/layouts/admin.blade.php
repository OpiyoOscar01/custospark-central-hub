<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta Tags -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <meta name="description" content="@yield('description', 'Custospark: Cutting-edge tech solutions to innovate, accelerate, and succeed')" />
  <meta name="keywords" content="@yield('keywords', 'Custospark, technology, solutions, innovation, success')" />
  <meta name="author" content="@yield('author', 'Custospark')" />
  <meta name="robots" content="index, follow" />
  
  <!-- Mobile Web App Optimization -->
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <meta name="apple-mobile-web-app-title" content="Custospark" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-title" content="Custospark" />
  <!-- Page Title -->
  <title>@yield('title', 'Custospark')</title>
  <link rel="icon" href="{{ asset('images/v8.png') }}" type="image/x-icon" />
  
  <!-- Tailwind CSS: Utility-First CSS Framework -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Bootstrap Icons: For Hamburger, Cross, and other icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body class="bg-white">
  <!-- Header Section (Partial) -->
  @include('Portal.partials.header')
  
  <!-- Main Layout: Sidebar + Content & Footer -->
  <div class="flex h-screen overflow-hidden">
    <!-- Desktop Sidebar (Partial) -->
    @include('Portal.partials.sidenav-desktop')
    
    <!-- Content & Footer Container -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Main Content Area -->
      <main class="flex-1 overflow-y-auto p-2 bg-white">
        @yield('content')
        <!-- Footer Section (Partial) -->
        @include('Portal.partials.footer')
      </main>
      
    </div>
  </div>
  
  <!-- Mobile Sidebar (Partial: Should include the mobile sidebar HTML) -->
  
  <!-- Mobile Sidebar Overlay -->
  @include('Portal.partials.sidenav-mobile')
  
  
  <!-- Scripts: Ensure these are loaded after your HTML elements -->
  @stack('sidenav-mobile-scripts')
  
 
</body>
</html>
