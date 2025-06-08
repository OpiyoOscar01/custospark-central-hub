<!-- Pricing Section -->
<section id="pricing" class="relative bg-gradient-to-br from-blue-500 via-black to-blue-500 bg-opacity-70 text-white py-20 px-4 md:px-8 overflow-hidden">

  <!-- Particle Background -->
  <div id="particles-js" class="absolute inset-0 z-0"></div>

  <div class="max-w-7xl mx-auto relative z-10">

    <div class="text-center mb-12">
  <h2 class="text-xl md:text-5xl font-extrabold mb-4 text-center">
  {{ $app->name }} Plans That Scale With Your Growth.
</h2>
<h2 class="text-xl md:text-2xl font-semibold italic text-white text-center mb-2">
  {{ $app->tagline }}
</h2>

<p class="text-lg md:text-xl text-white text-opacity-90 text-center mb-4">
  {{ $app->description }}
</p>

<p class="text-center text-lg md:text-xl text-white text-opacity-80 mb-6">
  Invest in the plan that matches where you are — and unlock features that help you get where you're going. 
  No contracts. No surprises. Just pure value.
</p>



    <!-- Pricing Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-16">
      @forelse ($plans as $plan)
        @php
          $isPopular = $plan->is_popular;
          $cardClasses = $isPopular 
            ? 'relative bg-gradient-to-br from-blue-500 to-black backdrop-blur-lg border-4 border-white rounded-3xl shadow-2xl p-10 flex flex-col items-center text-center transform scale-105' 
            : 'bg-gradient-to-br from-blue-500 to-black backdrop-blur-lg border border-white/10 rounded-3xl shadow-2xl p-8 flex flex-col items-center text-center';
        @endphp

        <div class="{{ $cardClasses }}">
          @if($isPopular)
            <span class="absolute top-4 right-4 bg-white text-blue-800 text-xs font-bold px-3 py-1 rounded-full">Most Popular</span>
          @endif

          <h3 class="text-2xl font-bold mb-2">{{ $plan->name }}</h3>

          @if ($plan->description ?? false)
            <p class="text-white text-opacity-80 mb-4 italic">{{ $plan->description }}</p>
          @else
            <p class="text-white text-opacity-80 mb-4 italic">Flexible features for your needs.</p>
          @endif

          @if ($plan->features->count())
            <ul class="text-white text-opacity-70 mb-6 space-y-3 text-left w-full max-w-xs mx-auto">
              @foreach ($plan->features as $feature)
                <li>✔ {{ $feature->name }}</li>
              @endforeach
            </ul>
          @else
            <p class="text-white text-opacity-70 mb-6 italic">No features listed.</p>
          @endif

          {{-- Pricing --}}
          @if($plan->price == 0)
            <h4 class="text-4xl font-bold mb-6">$0</h4>
          @else
            @if($isPopular)
              <p class="text-gray-400 line-through text-sm">${{ number_format($plan->price * 1.3, 2) }}/mo</p>
              <h4 class="text-4xl font-bold mb-6">${{ number_format($plan->price, 2) }} <span class="text-lg font-medium">/month</span></h4>
              <p class="text-sm italic mb-6 text-white text-opacity-60">Save 15% with annual billing</p>
            @else
              <h4 class="text-4xl font-bold mb-6">${{ number_format($plan->price, 2) }} <span class="text-lg font-medium">/month</span></h4>
            @endif
          @endif

          <a href="{{ route('plan.select', ['app' => $plan->app->id, 'plan' => $plan->id]) }}" 
             class="{{ $isPopular ? 'bg-white text-blue-800 font-extrabold' : 'bg-blue-300 text-blue-800 font-semibold' }} rounded-full py-3 px-8 hover:bg-blue-500 hover:text-white transition w-full max-w-xs">
            {{ $isPopular ? 'Upgrade to '.$plan->name : 'Choose '.$plan->name }}
          </a>

          @if($isPopular)
            <p class="text-xs text-white text-opacity-60 mt-4">30-Day Money-Back Guarantee.</p>
          @endif
        </div>
      @empty
        <p class="col-span-4 text-center text-white">No plans available for this app.</p>
      @endforelse
    </div>

    <!-- Optional Urgency Notice -->
    @if($plans->contains('is_popular', true))
      <div class="text-center mb-16">
        <p class="bg-blue-800 inline-block px-6 py-2 rounded-full text-white text-lg font-bold animate-pulse">
          Limited-Time Offer: Get {{ $plan->name }} today & receive your first month free!
        </p>
      </div>
    @endif

        <p class="text-center text-lg md:text-xl text-white text-opacity-80 mb-6">
      <span class="font-bold text-blue-300">Risk-free guarantee:</span> Try any plan for 30 days — love it or get your money back, no questions asked.
    </p>

    <p class="text-center text-lg md:text-xl text-white text-opacity-80 mb-8">
      <strong>Unsure where to start?</strong> 
      <a href="{{ route('help.contacts') }}" class="text-blue-300 hover:underline font-semibold">
        Talk to our experts
      </a> for a tailored recommendation.
    </p>
  </div>

  <!-- Particles Background Script -->
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
  <script>
    particlesJS("particles-js", {
      particles: {
        number: { value: 50 },
        color: { value: ["#ffffff"] },
        shape: { type: "circle" },
        opacity: { value: 0.3, random: true },
        size: { value: 4, random: true },
        move: { speed: 1, random: true, out_mode: "out" }
      },
      interactivity: {
        events: {
          onhover: { enable: true, mode: "repulse" },
          onclick: { enable: true, mode: "push" }
        },
        modes: {
          repulse: { distance: 100 },
          push: { particles_nb: 4 }
        }
      },
      retina_detect: true
    });
  </script>
</section>
