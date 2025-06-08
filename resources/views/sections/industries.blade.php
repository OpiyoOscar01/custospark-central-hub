<section id="industries" class="py-20 relative bg-gradient-to-b from-blue-500 via-black to-blue-500">
  <!-- Overlay -->
  {{-- <div class="absolute inset-0 bg-black opacity-50 z-0"></div> --}}

  <!-- Gradient edges -->
  <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-black/80 to-transparent z-20 pointer-events-none"></div>
  <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-black/80 to-transparent z-20 pointer-events-none"></div>

  <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl font-extrabold text-white mb-4">Industries We Serve</h2>
    <p class="text-xl text-gray-200 mb-12">Tailored solutions for diverse market sectors.</p>

    <div class="overflow-hidden relative">
      <div class="scrolling-wrapper flex gap-6 w-max">
        <?php
        $industries = [
          ['title' => 'E-Commerce', 'icon' => 'bi-shop-window', 'description' => 'Boost your online sales with innovative tech.', 'result' => '+30% Conversion Rate'],
          ['title' => 'Healthcare', 'icon' => 'bi-heart', 'description' => 'Driving efficiency & better patient outcomes.', 'result' => 'Reduced Wait Times'],
          ['title' => 'Fintech', 'icon' => 'bi-wallet', 'description' => 'Secure and efficient financial solutions.', 'result' => 'Faster Transactions'],
          ['title' => 'Education', 'icon' => 'bi-book', 'description' => 'Innovative solutions for modern education.', 'result' => 'Improved Learning Outcomes'],
          ['title' => 'Retail', 'icon' => 'bi-bag-check', 'description' => 'Streamlining retail operations and sales.', 'result' => 'Increased Efficiency'],
          ['title' => 'Real Estate', 'icon' => 'bi-house-door', 'description' => 'Transforming property management and sales.', 'result' => 'Faster Property Sales'],
          ['title' => 'Logistics', 'icon' => 'bi-truck', 'description' => 'Optimizing supply chain and delivery systems.', 'result' => 'Improved Delivery Times'],
          ['title' => 'Hospitality', 'icon' => 'bi-geo-alt', 'description' => 'Enhancing guest experiences through tech.', 'result' => 'Higher Guest Satisfaction'],
          ['title' => 'Manufacturing', 'icon' => 'bi-gear', 'description' => 'Modernizing manufacturing with automation.', 'result' => 'Reduced Operational Costs'],
          ['title' => 'Entertainment', 'icon' => 'bi-film', 'description' => 'Tech solutions for the entertainment industry.', 'result' => 'Increased Audience Engagement'],
          ['title' => 'Legal', 'icon' => 'bi-gavel', 'description' => 'Streamlining legal processes and case management.', 'result' => 'Faster Case Resolutions'],
          ['title' => 'Energy', 'icon' => 'bi-lightbulb', 'description' => 'Innovative energy solutions for sustainability.', 'result' => 'Lower Energy Costs']
        ];

        // Repeat for infinite scroll
        $industries = array_merge($industries, $industries);

        foreach ($industries as $industry) {
          echo '<div class="card min-w-[260px] backdrop-blur-lg bg-white/10 p-6 rounded-2xl shadow-xl flex-shrink-0 transition-transform duration-300 hover:scale-105 hover:shadow-blue-500/50 animate-float">';
          echo '<div class="icon text-5xl mb-4 text-blue-400 drop-shadow-lg"><i class="bi ' . $industry['icon'] . '"></i></div>';
          echo '<h3 class="text-xl font-bold text-white mb-1 transition-transform hover:text-blue-500">' . $industry['title'] . '</h3>';
          echo '<p class="text-sm text-gray-200 mb-1 transition-opacity hover:opacity-80">' . $industry['description'] . '</p>';
          echo '<p class="text-sm text-blue-200 font-medium transition-opacity hover:opacity-80">' . $industry['result'] . '</p>';
          echo '</div>';
        }
        ?>
      </div>
    </div>
  </div>
</section>

<style>
  /* Scrolling wrapper with improved animation */
  .scrolling-wrapper {
    animation: scroll-left 60s linear infinite;
    display: flex;
    will-change: transform;
  }

  @keyframes scroll-left {
    0% {
      transform: translateX(0%);
    }
    100% {
      transform: translateX(-50%);
    }
  }

  .scrolling-wrapper:hover {
    animation-play-state: paused;
  }

  /* Floating animation for each card */
  @keyframes float {
    0%, 100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-5px);
    }
  }

  .animate-float {
    animation: float 6s ease-in-out infinite;
  }

  /* Hover interactions */
  .card:hover {
    background-color: rgba(255, 255, 255, 0.15);
    transform: scale(1.05);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
  }

  .card h3:hover {
    color: #1E40AF; /* Blue hover for text */
  }

  .card p:hover {
    opacity: 0.8; /* Text opacity hover */
  }
</style>
