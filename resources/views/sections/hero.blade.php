<!-- Hero Section -->
<section class="relative min-h-screen bg-gradient-to-br from-blue-500 via-black to-blue-500 bg-opacity-50 backdrop-blur-lg shadow-2xl flex flex-col items-center justify-center text-center overflow-hidden text-white px-4 md:px-8 py-20">

  <!-- Particle Background -->
  {{-- <div id="particles-js" class="absolute inset-0 z-0"></div> --}}

  <!-- Background Video -->
  <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover opacity-40 z-0">
    <source src="{{ asset('videos/hero-bg.mp4') }}" type="video/mp4">
  </video>

  <!-- Dark Overlay -->
  <div class="absolute inset-0 bg-black opacity-50 z-10"></div>

 
 <!-- Inclusivity Campaign Badge (Left) -->
<div class="absolute top-6 left-4 md:top-8 md:left-12 animate-floating text-center z-30 opacity-90 mb-10">
  <a href="{{route('contact-us')}}" class="block text-xs md:text-sm font-semibold cursor-pointer
             hover:scale-105 hover:shadow-lg transition transform duration-300 ease-in-out
             px-3 py-2 rounded-md">
    
    <i class="bi bi-people text-3xl md:text-5xl 
              bg-gradient-to-r from-blue-500 to-blue-300 bg-clip-text text-transparent"></i>
    
    <p class="mt-1 md:mt-2 text-white font-semibold">
      Digital Inclusivity? <span class="text-blue-300 underline">Contact Us</span>
    </p>

  </a>
</div>
<div class="absolute top-6 right-4 md:top-8 md:right-12 animate-floating text-center z-30 opacity-90">
  <i class="bi bi-robot text-3xl md:text-5xl bg-gradient-to-r from-blue-500 to-blue-300 bg-clip-text text-transparent"></i>
  <p class="mt-1 md:mt-2 text-xs md:text-sm text-white font-semibold">AI-Powered</p>
</div>

{{-- 
  <div class="absolute bottom-6 left-4 md:bottom-8 md:left-12 animate-floating text-center z-30 opacity-90">
    <i class="bi bi-cloud-arrow-down text-3xl md:text-5xl text-blue-300"></i>
    <p class="mt-1 md:mt-2 text-xs md:text-sm text-white font-semibold">Cloud Solutions</p>
  </div> --}}
  <div class="absolute bottom-6 left-4 md:bottom-8 md:left-12 animate-floating text-center z-30 opacity-90">
    <i class="bi bi-bar-chart-line text-3xl md:text-5xl text-blue-300"></i>
    <p class="mt-1 md:mt-2 text-xs md:text-sm text-white font-semibold">Data-Driven</p>
  </div>
  

  <div class="absolute bottom-6 right-4 md:bottom-8 md:right-12 animate-floating text-center z-30 opacity-90">
    <i class="bi bi-arrow-up-right-circle text-3xl md:text-5xl text-blue-300"></i>
    <p class="mt-1 md:mt-2 text-xs md:text-sm text-white font-semibold">Business Growth</p>
  </div>

  <!-- Main Hero Content -->
  <div class="z-20 mt-10 w-full max-w-6xl flex flex-col items-center">

    <!-- Hero Heading -->
    <div class="mb-12 lg:mt-10 sm:mt-10">
      <h4 class="text-xl md:text-5xl font-bold text-white drop-shadow-md">
        Custospark empowers <span id="dynamicText" class="text-blue-300"></span>
      </h4>
        <p class="mt-6 text-lg md:text-xl max-w-2xl mx-auto text-italic text-white font-bold">
        We listen, understand your needs, and build smart solutions that work for you — including our own powerful SaaS tools to help you grow.
      </p>


    </div>

    @php
    use App\Models\App;
    use Illuminate\Support\Facades\DB;

    // Retrieve apps with lowest plan price, plan type, and trial days for pricing logic
    $apps = App::select(
            'apps.id', 
            'apps.name', 
            'apps.slug', 
            'apps.icon_url', 
            'apps.description',
            DB::raw('(SELECT MIN(plans.price) FROM plans WHERE plans.app_id = apps.id) as starting_price'),
            DB::raw('(SELECT plans.plan_type FROM plans WHERE plans.app_id = apps.id ORDER BY plans.price ASC LIMIT 1) as plan_type'),
            DB::raw('(SELECT plans.trial_days FROM plans WHERE plans.app_id = apps.id ORDER BY plans.price ASC LIMIT 1) as trial_days')
        )->get();

    $defaultIcon = asset('images/custospark.png'); // Default icon fallback
    @endphp

    <!-- SaaS Cards -->
    <div id="apps-container" class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full px-4 md:px-0">

  <!-- Custom Solution Card -->
  <div class="app-card bg-gradient-to-br from-blue-500 via-black to-blue-500 backdrop-blur-lg border border-white/10 rounded-3xl shadow-lg p-8 flex flex-col items-center text-center transition-transform transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-400/50 duration-300">

    <div class="w-20 h-20 flex items-center justify-center mb-4 rounded-full bg-blue-600 bg-opacity-40">
      <i class="bi bi-gear-fill text-4xl text-white"></i>
    </div>

      <h3 class="text-2xl font-bold text-white mb-2">
        Looking for Custom Software for Your Business?
    </h3>

    <p class="text-white text-opacity-80 mb-4 max-w-xs">
        At Custospark, we build tailored software solutions designed specifically for your business needs. Let us help you innovate, streamline, and grow.
    </p>


    <div id="customExtraContent" class="hidden text-white text-opacity-80 text-sm space-y-2 mb-4 max-w-xs">
      <p>✓ Leverage better technology for growth and scale.</p>
      <p>✓ Sales-driven platforms to boost conversions.</p>
      <p>✓ Secure, scalable APIs and automation workflows.</p>
      <p>✓ Custom dashboards for business intelligence.</p>
    </div>

    <button id="toggleCustomContent" class="text-blue-200 text-sm hover:underline mb-4">See More</button>

    <div class="flex flex-col space-y-3 w-full">
      <a href="{{ route('pricing.custom') }}" 
         class="bg-blue-400 text-white font-bold rounded-full py-3 px-6 w-full text-center hover:bg-blue-500 hover:scale-105 transition">
         See Plans
      </a>
    </div>
  </div>

  <!-- Dynamic App Cards -->
  @foreach ($apps as $index => $app)
    @if($app->slug === 'custospark') @continue @endif

    @php
      switch ($app->plan_type) {
        case 'free':
          $btnText = 'Starting at $0';
          $btnClass = 'bg-green-500 text-white hover:brightness-110';
          break;
        case 'trial':
          $btnText = 'Start Free Trial (' . ($app->trial_days ?? 14) . ' days)';
          $btnClass = 'bg-blue-500 text-white hover:brightness-110';
          break;
        default:
          $btnText = 'Subscribe';
          $btnClass = 'bg-blue-400 text-white hover:bg-blue-500 hover:scale-105 transition';
          break;
      }
    @endphp

    <div class="app-card bg-gradient-to-br from-blue-500 via-black to-blue-500 backdrop-blur-lg border border-white/10 rounded-3xl shadow-lg p-8 flex flex-col items-center text-center transition-transform transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-400/50 duration-300
        @if($index >= 3) hidden extra-app @endif">
      {{-- <img src="{{ $app->icon_url ?: $defaultIcon }}" alt="{{ $app->name }} Logo" class="w-20 h-20 object-contain mb-4"> --}}
      
    <div class="w-20 h-20 flex items-center justify-center mb-4 rounded-full bg-blue-600 bg-opacity-40">
  <i class="bi bi-grid-1x2-fill mr-2 text-white text-3xl"></i>
</div>

      <h3 class="text-2xl font-bold text-white mb-2">{{ $app->name }}</h3>
      <p class="text-white text-opacity-80 mb-4">{{ $app->description }}</p>
      <p class="text-sm text-blue-300 mb-6">
        Starting at
        @if($app->starting_price !== null)
          ${{ number_format($app->starting_price, 2) }}
        @else
          N/A
        @endif
        /mo
      </p>
      <div class="flex flex-col space-y-3 w-full">
        <form action="{{ route('login.redirect') }}" method="GET" class="w-full">
          <input type="hidden" name="app" value="{{ $app->slug }}">
          <button type="submit" class="{{ $btnClass }} font-bold rounded-full py-3 px-6 w-full">
            {{ $btnText }}
          </button>
        </form>
        <p class="text-xs text-white/70">No credit card required</p>
        <a href="{{ route('home.pricing.show',['app'=>$app->id]) }}" class="text-blue-200 font-medium hover:underline">See Plans <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  @endforeach

</div>

<!-- View All / View Less Button -->
<div class="flex justify-center mt-8">
  <button id="toggleAppsBtn" class="bg-blue-400 text-white font-bold rounded-full py-3 px-8 hover:bg-blue-500 hover:scale-105 transition">
    View All
  </button>
</div>

<!-- JS -->
<script>
  // Toggle custom content
  document.getElementById('toggleCustomContent')?.addEventListener('click', function () {
    const content = document.getElementById('customExtraContent');
    const isHidden = content.classList.contains('hidden');
    content.classList.toggle('hidden');
    this.textContent = isHidden ? 'See Less' : 'See More';
  });

  // Toggle app cards
  document.getElementById('toggleAppsBtn')?.addEventListener('click', function () {
    const extraApps = document.querySelectorAll('.extra-app');
    const isShowing = [...extraApps].some(app => !app.classList.contains('hidden'));

    extraApps.forEach(app => app.classList.toggle('hidden'));
    this.textContent = isShowing ? 'View All' : 'View Less';
  });
</script>


  </div>
</section>


<!-- JavaScript for Dynamic Text -->
<script>
  const dynamicText = document.getElementById('dynamicText');
  const phrases = [
    "your business to grow faster.",
    "entrepreneurs to innovate boldly.",
    "teams to collaborate seamlessly.",
    "brands to reach new heights.",
    "your vision to become reality.",
    "companies to scale efficiently.",
    "startups to disrupt markets.",
    "leaders to make data-driven decisions.",
    "organizations to embrace digital transformation."
  ];
  let i = 0;

  function changeText() {
    dynamicText.textContent = phrases[i];
    i = (i + 1) % phrases.length;
  }

  setInterval(changeText, 3000);
  changeText();
</script>

<!-- JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<script>
// Initialize particles.js
particlesJS("particles-js", {
  particles: {
    number: { value: 200 },
    color: { value: ["#ffffff"] },
    shape: { type: ["circle"] },
    opacity: { value: 0.3, random: true },
    size: { value: 4, random: true },
    move: { speed: 3, random: true, out_mode: "out" }
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

// Text Animation
const textArray = [
  "Power Your Vision with Custospark  Softwares.",
  "Transform Ideas into Impact — Start Building Today.",
  "Scale Smart with Tools Designed for Modern Businesses.",
  "Join Custospark — Innovation Begins with You.",
  "We Build the Tech — You Build the Future.",
  "Your Growth is Our Mission at Custospark.",
  "From Dreamers to Doers — Let’s Create Together.",
  "Built for You. Backed by Custospark.",
  "Empowering Every Hustle, Every Day."
];


let currentIndex = 0;
function fadeText() {
  gsap.to("#typed-text", { opacity: 0, duration: 1, onComplete: () => {
    document.getElementById('typed-text').innerHTML = textArray[currentIndex];
    gsap.to("#typed-text", { opacity: 1, duration: 1 });
    currentIndex = (currentIndex + 1) % textArray.length;
    setTimeout(fadeText, 4000);
  }});
}
fadeText();
</script>
