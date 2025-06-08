<!-- Market Analysis Section with 3D Floating Cards & Particle.js Background -->
<section id="market-analysis" class="relative py-20 bg-gradient-to-r from-blue-500 via-black to-blue-500 text-white overflow-hidden">
  <!-- Particle.js Background Layer -->
  <div id="market-analysis-bg" class="absolute inset-0 pointer-events-none z-0"></div>

  <div class="relative z-10 max-w-6xl mx-auto px-6">
    <!-- Section Header -->
    <div class="text-center mb-12">
      <h2 class="text-4xl sm:text-5xl font-bold text-white">Market Analysis</h2>
      <p class="text-lg sm:text-xl mt-4 max-w-2xl mx-auto leading-relaxed text-white">
        Gain insights into industry trends, our competitive advantage, and the growth opportunities that lie ahead for Custospark.
      </p>
    </div>

    <!-- Global Trends Card -->
    <div class="mb-12 p-6 bg-white/90 border border-gray-200 backdrop-blur-md rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 perspective-1000 animate-float">
      <h3 class="text-2xl sm:text-3xl font-semibold mb-4 text-blue-700">Industry Trends</h3>
      <p class="text-lg sm:text-xl leading-relaxed text-gray-700">
        The technology industry is evolving rapidly—cloud computing, automation, and AI are reshaping how companies scale. Custospark leverages these trends with innovative software solutions that empower businesses worldwide.
      </p>
    </div>

    <!-- Competitor Analysis Card -->
   <div class="mb-12 p-6 bg-white/90 border border-gray-200 backdrop-blur-md rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 perspective-1000 animate-float" style="animation-delay: 0.4s;">
  <h3 class="text-2xl sm:text-3xl font-semibold mb-4 text-blue-700">Competitor Analysis</h3>
  <p class="text-lg sm:text-xl leading-relaxed text-gray-700">
    In a crowded SaaS landscape, Custospark differentiates itself through an agile, modular platform that empowers businesses across diverse sectors—from e-commerce and real estate to project collaboration. Unlike competitors bound by rigid structures or heavy funding cycles, our lean, self-funded model allows us to iterate rapidly, deliver deeply customized solutions, and adapt to regional market dynamics.
  </p>
  <p class="text-lg sm:text-xl leading-relaxed text-gray-700 mt-4">
    Our unified ecosystem approach also adds unmatched value—users can seamlessly access interconnected tools under one account, reducing cost and friction. By putting users at the center of product development and staying laser-focused on underserved and high-growth markets, we’re redefining what it means to build for scale and impact.
  </p>
</div>


    <!-- Market Opportunities Card -->
    <div class="mb-12 p-6 bg-white/90 border border-gray-200 backdrop-blur-md rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 perspective-1000 animate-float" style="animation-delay: 0.8s;">
      <h3 class="text-2xl sm:text-3xl font-semibold mb-4 text-blue-700">Market Opportunities</h3>
      <p class="text-lg sm:text-xl leading-relaxed text-gray-700">
        The technology landscape presents significant untapped potential. Key opportunities include:
      </p>
      <ul class="list-none space-y-4 text-lg sm:text-xl mt-6 text-gray-700">
        <li class="flex items-start">
          <i class="bi bi-lightbulb text-yellow-500 text-xl sm:text-2xl mr-3"></i>
          <span class="font-bold">Emerging Markets:</span> Expanding into regions experiencing rapid digital transformation.
        </li>
        <li class="flex items-start">
          <i class="bi bi-bar-chart-line text-green-600 text-xl sm:text-2xl mr-3"></i>
          <span class="font-bold">Industry-Specific Software:</span> Developing tailored solutions for sectors such as healthcare, education, and manufacturing.
        </li>
        <li class="flex items-start">
          <i class="bi bi-globe text-blue-600 text-xl sm:text-2xl mr-3"></i>
          <span class="font-bold">Global Partnerships:</span> Forming strategic alliances to broaden our reach and fortify market presence.
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- 3D Floating Animation for Cards -->
<style>
  @keyframes float3d {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }
  .animate-float {
    animation: float3d 4s ease-in-out infinite;
  }
</style>

<!-- Particles.js Sparkle Background Initialization -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
  particlesJS("market-analysis-bg", {
    "particles": {
      "number": { "value": 100, "density": { "enable": true, "value_area": 800 } },
      "color": { "value": ["#FFC300", "#FF5733", "#28A745", "#17A2B8"] },
      "shape": { "type": "bubble", "stroke": { "width": 0, "color": "#000" } },
      "opacity": { "value": 0.8, "random": true },
      "size": { "value": 8, "random": true },
      "line_linked": { "enable": false },
      "move": { "enable": true, "speed": 2, "direction": "none", "random": true, "straight": false, "out_mode": "out" }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": { "resize": true }
    },
    "retina_detect": true
  });
</script>
