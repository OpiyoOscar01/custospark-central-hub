<!-- Pricing Section -->
<section id="pricing" class="relative bg-gradient-to-br from-blue-500 via-black to-blue-500 bg-opacity-70 text-white py-20 px-4 md:px-8 overflow-hidden">

  <!-- Particle Background -->
  <div id="particles-js" class="absolute inset-0 z-0"></div>

  <div class="max-w-7xl mx-auto relative z-10">

    <!-- Section Heading -->
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-5xl font-extrabold mb-4">Custosell Plans That Grow With You.</h2>
      <p class="text-lg md:text-xl text-white text-opacity-80">
        Join hundreds of thriving businesses on Custosell. Start today — risk-free.
      </p>
    </div>

  <!-- Pricing Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-16">

  @forelse ($plans as $plan)
    @php
      // Determine styles based on whether it's popular
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
            <li>✔ {{ $feature->name }}{{ $feature->pivot->value ? ': '.$feature->pivot->value : '' }}</li>
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
          <p class="text-gray-400 line-through text-sm">${{ number_format($plan->price * 1.3, 2) }}/mo</p> {{-- Example original price, 30% higher --}}
          <h4 class="text-4xl font-bold mb-6">${{ number_format($plan->price, 2) }} <span class="text-lg font-medium">/month</span></h4>
          <p class="text-sm italic mb-6 text-white text-opacity-60">Save 15% with annual billing</p>
        @else
          <h4 class="text-4xl font-bold mb-6">${{ number_format($plan->price, 2) }} <span class="text-lg font-medium">/month</span></h4>
        @endif
      @endif

      <a href="#" 
         class="{{ $isPopular ? 'bg-white text-blue-800 font-extrabold' : 'bg-blue-300 text-blue-800 font-semibold' }} rounded-full py-3 px-8 hover:bg-blue-500 hover:text-white transition w-full max-w-xs">
        {{ $isPopular ? 'Upgrade to '.$plan->name : 'Choose '.$plan->name }}
      </a>

      @if($isPopular)
        <p class="text-xs text-white text-opacity-60 mt-4">30-Day Money-Back Guarantee.</p>
      @endif
    </div>
  @empty
    <p class="col-span-4 text-center text-gray-600">No plans available for this app.</p>
  @endforelse

</div>

<!-- Optional Urgency Notice -->
@if($plans->contains('is_popular', true))
  <div class="text-center mb-16">
    <p class="bg-blue-800 inline-block px-6 py-2 rounded-full text-white text-lg font-bold animate-pulse">
      Limited-Time Offer: Get Pro today & receive your first month free!
    </p>
  </div>
@endif


    <!-- Feature Comparison Table -->
    <div class="overflow-x-auto mb-16">
      <table class="w-full text-left text-white border-collapse border border-blue-500">
        <thead>
          <tr>
            <th class="p-4 border border-blue-500 bg-blue-700">Features</th>
            <th class="p-4 border border-blue-500 bg-blue-600">Free</th>
            <th class="p-4 border border-blue-500 bg-blue-600">Business Starter</th>
            <th class="p-4 border border-blue-500 bg-blue-600">Pro</th>
            <th class="p-4 border border-blue-500 bg-blue-600">Enterprise</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="p-4 border border-blue-500">Max Products</td>
            <td class="p-4 border border-blue-500">50</td>
            <td class="p-4 border border-blue-500">500</td>
            <td class="p-4 border border-blue-500">Unlimited</td>
            <td class="p-4 border border-blue-500">Custom</td>
          </tr>
          <tr>
            <td class="p-4 border border-blue-500">Support</td>
            <td class="p-4 border border-blue-500">Community</td>
            <td class="p-4 border border-blue-500">Email</td>
            <td class="p-4 border border-blue-500">Priority Email</td>
            <td class="p-4 border border-blue-500">24/7 Premium</td>
          </tr>
          <tr>
            <td class="p-4 border border-blue-500">Custom Domain</td>
            <td class="p-4 border border-blue-500">✖</td>
            <td class="p-4 border border-blue-500">✔</td>
            <td class="p-4 border border-blue-500">✔</td>
            <td class="p-4 border border-blue-500">✔</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Testimonials -->
    <div class="mb-16">
      <h3 class="text-2xl font-bold text-center mb-8">Trusted by Entrepreneurs Worldwide</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-500 rounded-2xl p-6 shadow-lg">
          <p class="text-white text-opacity-80 mb-4">"Switched to Custosell Pro and saw a 2x sales increase. Seamless setup and amazing support."</p>
          <h4 class="font-bold text-white">- Alex, BestStore</h4>
        </div>
        <div class="bg-blue-500 rounded-2xl p-6 shadow-lg">
          <p class="text-white text-opacity-80 mb-4">"I couldn't imagine scaling without Custosell. Pro features are a total game changer."</p>
          <h4 class="font-bold text-white">- Maria, Online Entrepreneur</h4>
        </div>
        <div class="bg-blue-500 rounded-2xl p-6 shadow-lg">
          <p class="text-white text-opacity-80 mb-4">"Enterprise plan gave us flexibility and speed to manage 10x more customers."</p>
          <h4 class="font-bold text-white">- John, TechSolutions</h4>
        </div>
      </div>
    </div>

    <!-- FAQ -->
    <div>
      <h3 class="text-2xl font-bold text-center mb-8">Frequently Asked Questions</h3>
      <div class="space-y-6">
        <div>
          <h4 class="font-semibold text-white mb-2">Can I switch plans later?</h4>
          <p class="text-white text-opacity-80">Absolutely! You can upgrade, downgrade, or cancel anytime — no hidden fees.</p>
        </div>
        <div>
          <h4 class="font-semibold text-white mb-2">Is there a free trial?</h4>
          <p class="text-white text-opacity-80">Yes! Try the Pro plan risk-free for 14 days. Cancel anytime.</p>
        </div>
        <div>
          <h4 class="font-semibold text-white mb-2">Do you offer discounts for annual payments?</h4>
          <p class="text-white text-opacity-80">Yes — save 15% when you choose annual billing for Pro or Enterprise plans!</p>
        </div>
      </div>
    </div>

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
