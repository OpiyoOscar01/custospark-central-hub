@php
use App\Models\App;

 $apps = App::select('id', 'name', 'slug', 'icon_url')->where('slug','!=','custospark')->get();
$defaultIcon = asset('images/custospark.png'); // fallback icon if app icon missing
@endphp
<header class="bg-blue-500 text-white sticky top-0 z-50 shadow-xl" role="banner">
  <div class="container mx-auto px-3 md:px-4 py-3 md:py-4">
    <div class="flex justify-between items-center">
      
      <!-- Logo & Brand - Always Visible -->
      <a href="{{route('home')}}" class="flex items-center gap-2 group transition duration-300 ease-in-out">
        <img 
          src="{{ asset('images/v8.png') }}" 
          alt="Custospark Logo" 
          class="w-8 h-8 sm:w-10 sm:h-10 object-contain rounded-full border-2 border-blue-300 shadow-md transform group-hover:scale-105 transition"
        />
        <span class="font-bold md:font-extrabold text-sm sm:text-base md:text-lg tracking-wide text-white text-transparent bg-clip-text">
          Custospark
        </span>
      </a>
      
      <!-- Desktop Navigation - Hidden on Mobile -->
      <nav class="hidden lg:flex items-center space-x-1 xl:space-x-3" role="navigation" aria-label="Main Navigation">
        <a href="{{ route('home') }}" class="px-2 py-1 {{ Route::is('home') ? 'text-yellow-200 font-semibold' : 'hover:text-pink-300 text-white' }} transition duration-300 text-sm">
          <i class="bi bi-house-door-fill mr-1"></i> Home
        </a>
        
        <!-- Services Dropdown -->
        <div class="relative group">
          <button class="flex items-center text-sm px-2 py-1 transition duration-300 focus:outline-none focus:ring-2 focus:ring-orange-300 rounded-md {{ Route::is('services') || Route::is('consultation') ? 'text-pink-300' : 'text-white hover:text-pink-300' }}" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-grid-fill mr-1"></i> Services <i class="bi bi-caret-down-fill ml-1 text-xs"></i>
          </button>
          <div class="absolute left-0 mt-1 w-64 bg-white text-blue-900 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-300 z-50 p-2">
            <div class="grid grid-cols-2 gap-2">
              <a href="{{ route('services') }}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                <i class="bi bi-laptop-fill text-blue-500 mr-1"></i> Software Dev
              </a>
              <a href="{{ route('services') }}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                <i class="bi bi-briefcase-fill text-green-500 mr-1"></i> Biz Solutions
              </a>
              <a href="{{ route('services') }}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                <i class="bi bi-cloud-arrow-up-fill text-indigo-500 mr-1"></i> Cloud & AI
              </a>
              <a href="{{ route('services') }}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                <i class="bi bi-person-workspace text-yellow-500 mr-1"></i> Consulting
              </a>
              <a href="{{ route('services') }}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                <i class="bi bi-shield-check text-teal-500 mr-1"></i> Security
              </a>
              <a href="#design" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                <i class="bi bi-palette-fill text-pink-500 mr-1"></i> UX Design
              </a>
            </div>
          </div>
        </div>
        
        <!-- Pricing Dropdown -->
        <div class="relative group">
          <button class="flex items-center text-sm px-2 py-1 transition duration-300 focus:outline-none focus:ring-2 focus:ring-orange-300 rounded-md text-white hover:text-orange-300" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-box-seam mr-1"></i> Pricing <i class="bi bi-caret-down-fill ml-1 text-xs"></i>
          </button>
          <div class="absolute left-0 mt-1 w-64 bg-white text-blue-900 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-300 z-50 p-2">
            <div class="grid grid-cols-2 gap-2">
              <a href="{{ route('pricing.custom')}}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                Custom Plans
              </a>
              @foreach ($apps as $app)
                <a href="{{ route('home.pricing.show', ['app' => $app->id]) }}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                  {{-- <img src="{{ $app->icon_url ?: $defaultIcon }}" alt="{{ $app->name }} icon" class="w-4 h-4 mr-1 object-contain" /> --}}
                  {{ $app->name }}
                </a>
              @endforeach
            </div>
          </div>
        </div>
        
        <!-- Connect Dropdown -->
        <div class="relative group">
          <button class="flex items-center text-sm px-2 py-1 transition duration-300 focus:outline-none focus:ring-2 focus:ring-orange-300 rounded-md text-white hover:text-orange-300" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-people-fill mr-1"></i> Connect <i class="bi bi-caret-down-fill ml-1 text-xs"></i>
          </button>
          <div class="absolute left-0 mt-1 w-64 bg-white text-blue-900 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-300 z-50 p-2">
            <div class="grid grid-cols-2 gap-2">
              <a href="{{ route('home.careers') }}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                <i class="bi bi-laptop-fill text-blue-500 mr-1"></i> Careers
              </a>
              <a href="{{ route('investor_relations') }}" class="flex items-center px-2 py-1 rounded-md hover:bg-orange-100 transition text-xs">
                <i class="bi bi-cloud-arrow-up-fill text-indigo-500 mr-1"></i> Investors
              </a>
            </div>
          </div>
        </div>
        
        <!-- Additional Links -->
        <a href="{{ route('about-us') }}" class="px-2 py-1 hover:text-orange-300 transition duration-300 {{ Route::is('about-us') ? 'text-pink-300 font-semibold' : 'hover:text-pink-300 text-white' }} text-sm">
          <i class="bi bi-info-circle-fill mr-1"></i> About
        </a>
        <a href="{{ route('contact-us') }}" class="px-2 py-1 hover:text-orange-300 transition duration-300 {{ Route::is('contact-us') ? 'text-pink-300 font-semibold' : 'hover:text-pink-300 text-white' }} text-sm">
          <i class="bi bi-chat-dots-fill mr-1"></i> Contact
        </a>
        <a href="{{route('blog.guest.user')}}" class="px-2 py-1 hover:text-orange-300 transition duration-300 text-white text-sm">
        <i class="bi bi-megaphone-fill mr-2"></i> 
Latest Updates
        </a>
      </nav>
      
      <!-- Account Button - Always Visible -->
      <form action="{{ route('login.redirect') }}" method="GET" class="ml-auto lg:ml-0">
        <input type="hidden" name="app" value="custospark">
        <button type="submit" class="flex items-center gap-1 sm:gap-2 bg-orange-300 text-white font-medium sm:font-semibold rounded-full px-2 sm:px-3 py-1 hover:bg-orange-400 hover:shadow-md transition duration-300 text-xs sm:text-sm">
          <i class="bi bi-key-fill"></i> <span>Account</span>
        </button>
      </form>
      
      <!-- Mobile Menu Toggle Button -->
      <button id="mobile-menu-toggle" class="ml-3 lg:hidden focus:outline-none text-white hover:text-orange-300 transition p-1" aria-label="Toggle navigation">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>
  
  <!-- Mobile Menu Overlay -->
  <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>
  
  <!-- Mobile Menu Panel -->
  <div id="mobile-menu-panel" class="fixed top-0 right-0 w-4/5 max-w-sm h-full bg-gradient-to-b from-blue-500 via-black to-blue-500 transform translate-x-full transition-transform duration-300 ease-in-out z-50 shadow-2xl overflow-auto">
    <!-- Mobile Menu Header -->
    <div class="flex justify-between items-center p-4 border-b border-blue-400">
      <div class="flex items-center gap-2">
        <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="w-8 h-8 object-contain rounded-full border-2 border-blue-300" />
        <span class="font-bold text-white"> Menu</span>
      </div>
      <button id="mobile-menu-close" class="text-white hover:text-orange-300 transition focus:outline-none" aria-label="Close menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    
    <!-- Mobile Menu Content -->
    <nav class="p-4 text-white">
      <div class="space-y-4">
        <!-- Main Navigation Links -->
        <a href="{{ route('home') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition {{ Route::is('home') ? 'bg-blue-700 font-medium' : '' }}">
          <i class="bi bi-house-door-fill mr-2"></i> Home
        </a>
        
        <!-- Services -->
        <div class="mobile-dropdown">
          <button class="flex justify-between items-center w-full py-2 px-3 hover:bg-blue-700 rounded-lg transition" onclick="toggleMobileDropdown('services-dropdown')">
            <span><i class="bi bi-grid-fill mr-2"></i> Services</span>
            <i class="bi bi-chevron-down transition-transform" id="services-dropdown-icon"></i>
          </button>
          <div id="services-dropdown" class="hidden pl-6 mt-1 space-y-2 transition-all">
            <a href="{{ route('services') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm">
              <i class="bi bi-laptop-fill mr-2 text-orange-300"></i> Software Development
            </a>
            <a href="{{ route('services') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm">
              <i class="bi bi-briefcase-fill mr-2 text-green-300"></i> Business Solutions
            </a>
            <a href="{{ route('services') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm">
              <i class="bi bi-cloud-arrow-up-fill mr-2 text-blue-300"></i> Cloud & AI
            </a>
            <a href="{{ route('services') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm">
              <i class="bi bi-shield-check mr-2 text-red-300"></i> Security Services
            </a>
          </div>
        </div>
        
        <!-- Pricing -->
        <div class="mobile-dropdown">
          <button class="flex justify-between items-center w-full py-2 px-3 hover:bg-blue-700 rounded-lg transition" onclick="toggleMobileDropdown('pricing-dropdown')">
            <span><i class="bi bi-box-seam mr-2"></i> Pricing</span>
            <i class="bi bi-chevron-down transition-transform" id="pricing-dropdown-icon"></i>
          </button>
          <div id="pricing-dropdown" class="hidden pl-6 mt-1 space-y-2 transition-all">
            <a href="{{ route('pricing.custom')}}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm">
              <i class="bi bi-sliders mr-2 text-yellow-300"></i> Custom Plans
            </a>
            @foreach ($apps->take(4) as $app)
              <a href="{{ route('home.pricing.show', ['app' => $app->id]) }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm">
                <i class="bi bi-app mr-2 text-purple-300"></i> {{ $app->name }}
              </a>
            @endforeach
            <a href="#" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm text-orange-300">
              <i class="bi bi-grid-3x3-gap mr-2"></i> View All Plans
            </a>
          </div>
        </div>
        
        <!-- Connect -->
        <div class="mobile-dropdown">
          <button class="flex justify-between items-center w-full py-2 px-3 hover:bg-blue-700 rounded-lg transition" onclick="toggleMobileDropdown('connect-dropdown')">
            <span><i class="bi bi-people-fill mr-2"></i> Connect</span>
            <i class="bi bi-chevron-down transition-transform" id="connect-dropdown-icon"></i>
          </button>
          <div id="connect-dropdown" class="hidden pl-6 mt-1 space-y-2 transition-all">
            <a href="{{ route('home.careers') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm">
              <i class="bi bi-briefcase mr-2 text-green-300"></i> Careers
            </a>
            <a href="{{ route('investor_relations') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition text-sm">
              <i class="bi bi-graph-up mr-2 text-blue-300"></i> Investors
            </a>
          </div>
        </div>
        
        <!-- About, Contact, Updates -->
        <a href="{{ route('about-us') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition {{ Route::is('about-us') ? 'bg-blue-700 font-medium' : '' }}">
          <i class="bi bi-info-circle-fill mr-2"></i> About Us
        </a>
        <a href="{{ route('contact-us') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition {{ Route::is('contact-us') ? 'bg-blue-700 font-medium' : '' }}">
          <i class="bi bi-chat-dots-fill mr-2"></i> Contact
        </a>
        <a href="{{ route('blog.guest.user') }}" class="block py-2 px-3 hover:bg-blue-700 rounded-lg transition">
        <i class="bi bi-megaphone-fill mr-2"></i> Latest Updates
        </a>
        
        <!-- Account Button in Mobile Menu -->
        <div class="mt-6">
          <form action="{{ route('login.redirect') }}" method="GET">
            <input type="hidden" name="app" value="custospark">
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-orange-500 text-white font-semibold rounded-lg px-3 py-2 hover:bg-orange-400 hover:shadow-md transition duration-300">
              <i class="bi bi-key-fill"></i> Account Access
            </button>
          </form>
        </div>
      </div>
    </nav>
  </div>
</header>

<!-- JavaScript for Mobile Menu -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuPanel = document.getElementById('mobile-menu-panel');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    
    // Open mobile menu
    mobileMenuToggle.addEventListener('click', function() {
      mobileMenuPanel.classList.remove('translate-x-full');
      mobileMenuOverlay.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    });
    
    // Close mobile menu
    function closeMenu() {
      mobileMenuPanel.classList.add('translate-x-full');
      mobileMenuOverlay.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }
    
    mobileMenuClose.addEventListener('click', closeMenu);
    mobileMenuOverlay.addEventListener('click', closeMenu);
    
    // Handle dropdowns in mobile menu
    window.toggleMobileDropdown = function(id) {
      const dropdown = document.getElementById(id);
      const icon = document.getElementById(id + '-icon');
      
      if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
        icon.classList.add('rotate-180');
      } else {
        dropdown.classList.add('hidden');
        icon.classList.remove('rotate-180');
      }
    }
    
    // Close mobile menu on window resize (if screen becomes larger)
    window.addEventListener('resize', function() {
      if (window.innerWidth >= 1024) { // lg breakpoint
        closeMenu();
      }
    });
  });
</script>
