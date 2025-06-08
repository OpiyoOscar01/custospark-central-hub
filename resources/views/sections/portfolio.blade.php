<section id="portfolio" class="relative py-24 bg-gradient-to-b from-blue-500 via-black to-blue-500 overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 text-center">
 <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6">
  Discover a curated collection of software solutions designed to streamline your operations and workflows.
</h2>
<p class="mb-14 text-white text-lg md:text-xl">
  Need something custom? We develop software tailored to your unique needs—built exactly the way you envision it.
</p>


    <!-- Scroll container -->
    <div id="projectsWrapper" class="relative h-[600px] overflow-hidden transition-all duration-500 ease-in-out">
  <div id="projectScroller" class="flex flex-col gap-8 will-change-transform animate-scroll-vertical px-4">
    @php
      use App\Models\App;
      $apps = App::where('status', 'active')->latest()->take(10)->get();
    @endphp

    @foreach ($apps as $app)
    @if($app->slug==='custospark')
      @continue
    @endif
      <article class="project-card bg-white p-6 rounded-2xl shadow-xl border border-blue-200 hover:shadow-2xl transform hover:scale-[1.03] transition-all duration-300 ease-in-out max-w-md mx-auto w-full">
        {{-- <img src="{{ $app->icon_url ?? asset('images/default-app.png') }}"
             alt="{{ $app->name }}"
             class="rounded-xl h-48 w-full object-cover mb-4 transition-transform duration-300 hover:scale-105"
             loading="lazy"> --}}
        <h3 class="text-2xl font-semibold text-blue-500">{{ $app->name }}</h3>
        <p class="mt-2 text-gray-900">{{ $app->description }}</p>
        @if ($app->tagline)
          <blockquote class="mt-3 italic text-sm text-blue-500">“{{ $app->tagline }}”</blockquote>
        @endif
        <a href="{{ route('login') }}"
           class="inline-block mt-4 text-sm text-blue-700 hover:underline font-medium">
          Get Started →
        </a>
      </article>
    @endforeach

    {{-- Seamless scroll loop --}}
    @foreach ($apps as $app)
     @if($app->slug==='custospark')
      @continue
    @endif
        <article class="project-card bg-white p-6 rounded-2xl shadow-xl border border-blue-200 hover:shadow-2xl transform hover:scale-[1.03] transition-all duration-300 ease-in-out max-w-md mx-auto w-full">
        {{-- <img src="{{ $app->icon_url ?? asset('images/default-app.png') }}"
             alt="{{ $app->name }}"
             class="rounded-xl h-48 w-full object-cover mb-4 transition-transform duration-300 hover:scale-105"
             loading="lazy"> --}}
        <h3 class="text-2xl font-semibold text-blue-500">{{ $app->name }}</h3>
        <p class="mt-2 text-gray-900">{{ $app->description }}</p>
        @if ($app->tagline)
          <blockquote class="mt-3 italic text-sm text-blue-500">“{{ $app->tagline }}”</blockquote>
        @endif
        <form action="{{ route('login.redirect') }}" method="GET" class="w-full">
          <input type="hidden" name="app" value="{{ $app->slug }}">
          <button type="submit" class="inline-block mt-4 text-sm text-blue-700 hover:underline font-medium font-bold rounded-full py-3 px-6 w-full">
          Get Started →
          </button>
        </form>
      </article>
      
    @endforeach
  </div>
</div>
  </div>
</section>

<style>
  @keyframes scroll-vertical {
    0% { transform: translateY(0); }
    100% { transform: translateY(-50%); }
  }

  .animate-scroll-vertical {
    animation: scroll-vertical 20s linear infinite;
  }

  #projectScroller {
    animation: scroll-vertical 20s linear infinite;
  }

  .project-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .project-card:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
  }

  .project-card img {
    transition: transform 0.3s ease;
  }

  .project-card img:hover {
    transform: scale(1.05);
  }
</style>

<script>
  const scroller = document.getElementById('projectScroller');
  let animationPaused = false;

  scroller.addEventListener('mouseover', (e) => {
    if (e.target.closest('.project-card')) {
      scroller.style.animationPlayState = 'paused';
      animationPaused = true;
    }
  });

  scroller.addEventListener('mouseout', (e) => {
    if (e.target.closest('.project-card')) {
      scroller.style.animationPlayState = 'running';
      animationPaused = false;
    }
  });
</script>
