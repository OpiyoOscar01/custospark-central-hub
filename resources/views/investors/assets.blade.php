@php
  // Our perks array can be reused or replaced by investor-specific content.
  $investorSupport = [
    'title' => 'Dedicated Investor Support',
    'desc' => 'Gain direct access to our Investor Relations team for timely updates, comprehensive financial reports, and strategic insights. Our dedicated team is committed to keeping you informed and engaged with Custospark’s growth journey.',
    'email' => 'investors@custospark.com',
    'phone' => '+(256) 756-697-871',
    'address' => 'Kampala City, Uganda.',
  ];
$investorResources = [
    'title' => 'Investor Message',
    'desc' => "We’re currently bootstrapped and moving toward launch with multiple in-house apps designed to empower digital transformation across underserved markets.\n\nWe're preparing for our next chapter and open to investor conversations that align with our values and long-term impact goals.",
    'cta' => 'Contact Us',
    'ctaLink' => route('help.contacts') // or any route you want to lead investors to
];

@endphp

<!-- Desktop Version: Alternating Timeline Layout with Vertical Divider -->
<section id="contact-investor-relations-desktop" class="hidden lg:block relative py-28 bg-gradient-to-br from-black to-blue-500 text-white overflow-hidden">
  <!-- Particle.js Background Layer -->
  <div id="investor-bg-desktop" class="absolute inset-0 pointer-events-none z-0"></div>

  <div class="relative z-10 max-w-6xl mx-auto px-6">
    <!-- Section Header -->
    <div class="text-center mb-16">
      <h2 class="text-5xl sm:text-6xl font-bold">Contact & Investor Relations</h2>
      <p class="text-xl mt-6 max-w-3xl mx-auto leading-relaxed">
        Our Investor Relations team is dedicated to delivering timely updates, robust financial metrics, and strategic insights. Reach out to learn more about Custospark’s growth and investment opportunities.
      </p>
    </div>

    <!-- Timeline Container -->
    <div class="relative">
      <!-- Vertical Divider -->
      <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-blue-500 via-pink-700 to-blue-500 rounded-full shadow-lg z-0"></div>

      <div class="space-y-24">
        <!-- Timeline Item 1: Dedicated Investor Support (Left Side) -->
        <div class="flex flex-col md:flex-row items-center md:items-start relative group">
          <!-- Left Column: Card -->
          <div class="w-full md:w-1/2 order-1 md:pr-12">
            <div class="bg-white/90 border border-gray-200 backdrop-blur-md rounded-2xl p-6 shadow-2xl transform transition-all duration-500 hover:scale-105 perspective-1000 animate-float">
              <h3 class="text-2xl sm:text-3xl font-bold mb-4 text-orange-700">{{ $investorSupport['title'] }}</h3>
              <p class="text-lg sm:text-xl leading-relaxed mb-6 text-gray-800">
                {{ $investorSupport['desc'] }}
              </p>
              <div class="space-y-3">
                <p class="text-lg sm:text-xl text-gray-800">
                  <strong>Email:</strong>
                  <a href="mailto:{{ $investorSupport['email'] }}" class="text-blue-600">
                    {{ $investorSupport['email'] }}
                  </a>
                </p>
                <p class="text-lg sm:text-xl text-gray-800">
                  <strong>Phone:</strong>
                  <a href="tel:+1234567890" class="text-blue-600">
                    {{ $investorSupport['phone'] }}
                  </a>
                </p>
                <p class="text-lg sm:text-xl text-gray-800">
                  <strong>Office Address:</strong> {{ $investorSupport['address'] }}
                </p>
              </div>
            </div>
          </div>

          <!-- Connector Dot -->
          <div class="absolute left-1/2 transform -translate-x-1/2 w-8 h-8 bg-white/30 backdrop-blur-xl border border-white/20 rounded-full z-10 shadow-lg"></div>
          
          <!-- Right Column: Spacer -->
          <div class="hidden md:block w-1/2 order-2"></div>
        </div>

        <!-- Timeline Item 2: Investor Resources (Right Side) -->
        <div class="flex flex-col md:flex-row items-center md:items-start relative group">
          <!-- Left Column: Spacer -->
          <div class="hidden md:block w-1/2 order-1"></div>
          <!-- Connector Dot -->
          <div class="absolute left-1/2 transform -translate-x-1/2 w-8 h-8 bg-white/30 backdrop-blur-xl border border-white/20 rounded-full z-10 shadow-lg"></div>
          <!-- Right Column: Card -->
          <div class="w-full md:w-1/2 order-2 md:pl-12">
            <div class="bg-white/90 border border-gray-200 backdrop-blur-md rounded-2xl p-6 shadow-2xl transform transition-all duration-500 hover:scale-105 perspective-1000 animate-float" style="animation-delay: 0.4s;">
              <h3 class="text-2xl sm:text-3xl font-bold mb-4 text-orange-700">{{ $investorResources['title'] }}</h3>
              <p class="text-lg sm:text-xl leading-relaxed mb-6 text-gray-800">
                {{ $investorResources['desc'] }}
              </p>
              {{-- <a href="{{ $investorResources['ctaLink'] }}" download class="inline-block bg-blue-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-blue-700 transition-transform transform hover:scale-105 shadow-lg">
                {{ $investorResources['cta'] }} --}}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mobile Version: Two-Column Grid Layout -->
<section id="contact-investor-relations-mobile" class="block lg:hidden relative py-28 bg-gradient-to-br from-blue-700 via-black to-blue-500 text-white overflow-hidden">
  <div class="relative z-10 max-w-5xl mx-auto px-4">
    <!-- Section Header -->
    <div class="text-center mb-12">
      <h2 class="text-3xl sm:text-4xl font-bold tracking-tight">Contact & Investor Relations</h2>
      <p class="text-base sm:text-lg mt-2 max-w-md mx-auto leading-relaxed">
        Our Investor Relations team is here to keep you informed with timely updates and robust financial insights.
      </p>
    </div>

    <!-- Card Layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <!-- Card 1: Dedicated Support -->
      <div class="p-6 bg-white/90 border border-white/30 backdrop-blur-md rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 animate-float">
        <h3 class="text-xl font-semibold text-black mb-2">{{ $investorSupport['title'] }}</h3>
        <p class="text-sm text-gray-800 leading-relaxed mb-3">
          {{ $investorSupport['desc'] }}
        </p>
        <p class="text-sm">
          <strong class="text-gray-900">Email:</strong> 
          <a href="mailto:{{ $investorSupport['email'] }}" class="text-blue-600 hover:underline">{{ $investorSupport['email'] }}</a>
        </p>
        <p class="text-sm mt-1">
          <strong class="text-gray-900">Phone:</strong> 
          <a href="tel:{{ $investorSupport['phone'] }}" class="text-blue-600 hover:underline">{{ $investorSupport['phone'] }}</a>
        </p>
      </div>

      <!-- Card 2: Investor Resources -->
      <div class="p-6 bg-white/90 border border-white/30 backdrop-blur-md rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 animate-float" style="animation-delay: 0.2s;">
        <h3 class="text-xl font-semibold text-orange-700 mb-2">{{ $investorResources['title'] }}</h3>
        <p class="text-sm text-gray-800 leading-relaxed mb-4">
          {{ $investorResources['desc'] }}
        </p>
        @if(isset($investorResources['cta']) && isset($investorResources['ctaLink']))
          {{-- <a href="{{ $investorResources['ctaLink'] }}" download class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-transform transform hover:scale-105 shadow-md">
            {{ $investorResources['cta'] }}
          </a> --}}
        @endif
      </div>
    </div>
  </div>
</section>


<!-- Shared Custom Animations & Responsive Styles -->
<style>
  /* 3D Floating Animation for Cards */
  @keyframes float3d {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }
  .animate-float {
    animation: float3d 3s ease-in-out infinite;
  }
</style>
