<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic Meta Tags -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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
  <link rel="icon" href="{{ asset('images/v8.png') }}" type="image/x-icon" />

  <!-- Dynamic Title -->
  <title>@yield('title', 'Default')-Custospark</title>

  <!-- CSS and Fonts -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;500&family=Inter:wght@400&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Alpine.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <!-- Custom Styling -->
  <style>
    html {
      scroll-behavior: smooth;
    }
    body {
      font-family: 'Roboto', sans-serif;
    }
  </style>
</head>
<body class="antialiased bg-white">
  <!-- Header -->
  @include('sections.header')

  <!-- Main Content -->
  <main>
    @yield('content')
  </main>

  <!-- Footer -->
  @include('sections.footer')

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 800 });
    const toggleBtn = document.getElementById('mobile-menu-toggle'),
          mobileMenu = document.getElementById('mobile-menu'),
          mobileClose = document.getElementById('mobile-close'),
          mobileLinks = mobileMenu.querySelectorAll('a');
          
    toggleBtn.addEventListener('click', () => {
      const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
      toggleBtn.setAttribute('aria-expanded', !isExpanded);
      mobileMenu.classList.toggle('-translate-x-full');
    });
    
    if (mobileClose) {
      mobileClose.addEventListener('click', () => {
        mobileMenu.classList.add('-translate-x-full');
        toggleBtn.setAttribute('aria-expanded', 'false');
      });
    }
    
    mobileLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('-translate-x-full');
        toggleBtn.setAttribute('aria-expanded', 'false');
      });
    });
    if (mobileClose) {
      mobileClose.addEventListener('click', () => {
        mobileMenu.classList.add('-translate-x-full');
        toggleBtn.setAttribute('aria-expanded', 'false');
      });
    }

    <!-- Mobile Dropdown Toggle Script -->
  // Array of dropdown IDs
const dropdownIds = ['mobile-services', 'mobile-products', 'mobile-industries', 'mobile-about', 'mobile-contact'];

// Attach event listeners to the toggle buttons
dropdownIds.forEach(id => {
  const button = document.getElementById(id); 
  
  if (button) {
    button.addEventListener('click', () => {
      toggleDropdown(id);
    });
  }
});

function toggleDropdown(id) {
  // Loop through all dropdowns to hide them, except for the clicked one
  dropdownIds.forEach(dropdownId => {
    const el = document.getElementById(dropdownId);
    if (dropdownId === id) {
      el.classList.toggle('hidden');  // Toggle visibility for the clicked dropdown
    } else {
      el.classList.add('hidden');  // Hide all other dropdowns
    }
  });
}
  </script>

</body>
</html>
