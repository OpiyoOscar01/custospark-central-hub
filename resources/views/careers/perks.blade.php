@php
$perks = [
  ['icon' => 'bi-house-door', 'title' => 'Remote Work', 'desc' => 'Work from wherever you’re most productive — home, café, or beach.'],
  ['icon' => 'bi-clock-history', 'title' => 'Flexible Hours', 'desc' => 'We focus on outcomes, not hours. Design your own schedule.'],
  ['icon' => 'bi-journal-code', 'title' => 'Learning Budget', 'desc' => 'We support growth with a dedicated budget for courses, books & tools.'],
  ['icon' => 'bi-calendar-heart', 'title' => 'Paid Time Off', 'desc' => 'Rest matters. Enjoy generous vacation and personal time off.'],
  ['icon' => 'bi-airplane', 'title' => 'Team Retreats', 'desc' => 'Join us in beautiful destinations to connect, recharge, and plan.'],
  ['icon' => 'bi-lightning-charge', 'title' => 'Mentorship & Growth', 'desc' => 'Work closely with industry pros and grow faster than ever.'],
  ['icon' => 'bi-gem', 'title' => 'Equity Opportunities', 'desc' => 'Be a part-owner of what you help build — we grow together.'],
  ['icon' => 'bi-wallet2', 'title' => 'Competitive Pay', 'desc' => 'We offer industry-leading compensation and regular performance reviews.'],
  ['icon' => 'bi-heart', 'title' => 'Health & Wellness', 'desc' => 'Enjoy access to health insurance, fitness stipends, and wellness programs.'],
  ['icon' => 'bi-globe', 'title' => 'Diversity & Inclusion', 'desc' => 'Be part of a diverse team that celebrates individuality and collaboration.'],
];
@endphp

<!-- Particles.js Background -->
<div id="particles-js" class="absolute inset-0 z-0"></div>

<section id="perks-benefits" class="relative py-28 bg-gradient-to-bl from-blue-500 via-black to-blue-500 text-white overflow-hidden">
  <!-- Background Glow -->
  <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(circle_at_10%_10%,_rgba(255,255,255,0.2),_transparent_40%),_radial-gradient(circle_at_90%_90%,_rgba(255,255,255,0.15),_transparent_40%)] blur-3xl z-0"></div>

  <div class="relative z-20 max-w-6xl mx-auto px-6">
    <!-- Header -->
    <div class="text-center mb-20">
      <h2 class="text-5xl font-extrabold drop-shadow-2xl">Why You'll Love Working Here</h2>
      <p class="text-xl mt-6 max-w-3xl mx-auto text-white/80 leading-relaxed">
        At <span class="text-yellow-300 font-semibold">Custospark</span>, we’re dedicated to supporting our people both professionally and personally. Explore benefits that help you thrive at every stage of life.
      </p>
    </div>

    <!-- Timeline Line -->
    <div class="relative">
      <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-yellow-400 via-pink-500 to-blue-600 rounded-full shadow-lg z-0"></div>

      <div class="space-y-24">
        @foreach ($perks as $index => $perk)
          @php $isLeft = $index % 2 === 0; @endphp
          <div class="flex flex-col md:flex-row items-center md:items-start relative group">
            <!-- Spacer for Left or Right Positioning -->
            <div class="w-full md:w-1/2 {{ $isLeft ? 'order-2 md:pl-12' : 'md:pr-12' }}">
              <!-- Card -->
              <div class="bg-white/10 border border-white/20 backdrop-blur-md rounded-2xl p-6 shadow-2xl transform transition-all duration-500 hover:scale-[1.02] hover:translate-y-1 hover:rotate-3d hover:shadow-2xl perspective-1000">
                <div class="flex items-center space-x-6">
                  <!-- Circular Icon -->
                  <div class="w-20 h-20 bg-gradient-to-b from-yellow-300 to-pink-600 text-white rounded-full flex items-center justify-center text-4xl shadow-xl">
                    <i class="bi {{ $perk['icon'] }}"></i>
                  </div>
                  <div>
                    <h3 class="text-2xl font-bold text-white">{{ $perk['title'] }}</h3>
                    <p class="text-white/80 mt-2 text-base leading-relaxed">{{ $perk['desc'] }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Connector Dot -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-8 h-8 bg-white/30 backdrop-blur-xl border border-white/20 rounded-full z-10 shadow-lg"></div>

            <!-- Filler for spacing -->
            <div class="hidden md:block w-1/2 {{ $isLeft ? 'order-1' : 'order-3' }}"></div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- CTA -->
    <div class="mt-24 text-center">
      <a href="#faqs"
         class="inline-block bg-white text-blue-500 px-8 py-4 rounded-xl text-lg font-semibold hover:bg-black hover:text-blue-500 transition-transform transform hover:scale-105 shadow-lg">
        Explore commonly asked questions →
      </a>
    </div>
  </div>
</section>

<!-- Particle.js Script -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
  particlesJS("particles-js", {
    particles: {
      number: {
        value: 80,
        density: { enable: true, value_area: 800 }
      },
      color: { value: "#ffffff" },
      shape: {
        type: "circle",
        stroke: { width: 0, color: "#000000" },
        polygon: { nb_sides: 5 }
      },
      opacity: {
        value: 0.3,
        random: true,
        anim: { enable: false }
      },
      size: {
        value: 8,
        random: true,
        anim: { enable: false }
      },
      line_linked: {
        enable: true,
        distance: 150,
        color: "#ffffff",
        opacity: 0.2,
        width: 1
      },
      move: {
        enable: true,
        speed: 1,
        direction: "none",
        random: false,
        straight: false,
        out_mode: "out",
        bounce: false
      }
    },
    interactivity: {
      detect_on: "canvas",
      events: {
        onhover: { enable: true, mode: "repulse" },
        onclick: { enable: true, mode: "push" },
        resize: true
      },
      modes: {
        repulse: { distance: 100, duration: 0.4 },
        push: { particles_nb: 4 }
      }
    },
    retina_detect: true
  });
</script>

<style>
  #particles-js {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 1;
  }

  .hover\:scale-105:hover {
    transform: scale(1.05);
  }

  .hover\:translate-y-1:hover {
    transform: translateY(1rem);
  }

  .hover\:rotate-3d:hover {
    transform: rotate3d(1, 1, 0, 15deg);
  }

  .perspective-1000 {
    perspective: 1000px;
  }

  @keyframes horizontal-scroll {
    0% {
      transform: translateX(0%);
    }
    100% {
      transform: translateX(-50%);
    }
  }

  .animate-horizontal-scroll {
    animation: horizontal-scroll 30s linear infinite;
  }

  .animate-horizontal-scroll:hover {
    animation-play-state: paused;
  }
</style>
