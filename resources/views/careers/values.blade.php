<!-- Desktop Version: Circular Floating Layout (Visible on md and above) -->
<section
  id="values-3d-desktop"
  class="hidden lg:block relative py-20 bg-black text-white overflow-hidden"
>

  <!-- Sparkle Particle Background (Desktop) -->
  <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
    <canvas id="sparkle-bg-desktop" class="w-full h-full opacity-20"></canvas>
  </div>
  <div class="max-w-7xl mx-auto px-6 relative z-10 perspective-container">
    <div class="text-center mb-12">
      <h2 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight drop-shadow-md">
        Our Core Values at <span class="text-green-300">Custospark</span>
      </h2>
    </div>
  
    <div class="text-center">
      <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
        We’ll guide you through exciting opportunities at Custospark. Ready to begin? Let’s get started!
      </p>
{{--   
      <a href="#explore-opportunities" class="inline-block bg-gradient-to-r from-green-300 to-blue-500 text-white px-8 py-4 rounded-full text-lg font-semibold hover:from-green-400 hover:to-blue-600 transition-all transform hover:scale-105 shadow-lg">
        Explore Opportunities
      </a> --}}
    </div>
  </div>
  
  
  

    <!-- Circular Container (No overall rotation) -->
    <div class="relative h-[600px] sm:h-[500px] xs:h-[400px] w-full transform-style-3d">
      <!-- Each Node is positioned at center (50%,50%) and offset by a calculated translate -->

      <!-- Node 1: Innovation (Angle: -90°) -->
      <div class="value-node-wrapper absolute"
           style="top: 50%; left: 50%; transform: translate(-50%, -50%) translate(0px, -200px);">
        <div class="value-node animate-random hover:scale-110 transition-all duration-300" style="animation-delay: 0s;">
          <div class="value-number glow-ring mb-3" data-number="1"></div>
          <h3 class="text-xl md:text-2xl font-semibold mb-1">INNOVATION</h3>
          <p class="text-sm md:text-base text-gray-200">Empowering creativity.</p>
        </div>
      </div>

      <!-- Node 2: Integrity (Angle: -38.57°) -->
      <div class="value-node-wrapper absolute"
           style="top: 50%; left: 50%; transform: translate(-50%, -50%) translate(156px, -126px);">
        <div class="value-node animate-random hover:scale-110 transition-all duration-300" style="animation-delay: 0.2s;">
          <div class="value-number glow-ring mb-3" data-number="2"></div>
          <h3 class="text-xl md:text-2xl font-semibold mb-1">INTEGRITY</h3>
          <p class="text-sm md:text-base text-gray-200">Honesty in action.</p>
        </div>
      </div>

      <!-- Node 3: Respect (Angle: 12.86°) -->
      <div class="value-node-wrapper absolute"
           style="top: 50%; left: 50%; transform: translate(-50%, -50%) translate(195px, 45px);">
        <div class="value-node animate-random hover:scale-110 transition-all duration-300" style="animation-delay: 0.4s;">
          <div class="value-number glow-ring mb-3" data-number="3"></div>
          <h3 class="text-xl md:text-2xl font-semibold mb-1">RESPECT</h3>
          <p class="text-sm md:text-base text-gray-200">Celebrating every voice.</p>
        </div>
      </div>

      <!-- Node 4: Collaboration (Angle: 64.29°) -->
      <div class="value-node-wrapper absolute"
           style="top: 50%; left: 50%; transform: translate(-50%, -50%) translate(87px, 180px);">
        <div class="value-node animate-random hover:scale-110 transition-all duration-300" style="animation-delay: 0.6s;">
          <div class="value-number glow-ring mb-3" data-number="4"></div>
          <h3 class="text-xl md:text-2xl font-semibold mb-1">COLLABORATION</h3>
          <p class="text-sm md:text-base text-gray-200">Shared success.</p>
        </div>
      </div>

      <!-- Node 5: Excellence (Angle: 115.72°) -->
      <div class="value-node-wrapper absolute"
           style="top: 50%; left: 50%; transform: translate(-50%, -50%) translate(-86px, 180px);">
        <div class="value-node animate-random hover:scale-110 transition-all duration-300" style="animation-delay: 0.8s;">
          <div class="value-number glow-ring mb-3" data-number="5"></div>
          <h3 class="text-xl md:text-2xl font-semibold mb-1">EXCELLENCE</h3>
          <p class="text-sm md:text-base text-gray-200">Raising the bar.</p>
        </div>
      </div>

      <!-- Node 6: Resilience (Angle: 167.15°) -->
      <div class="value-node-wrapper absolute"
           style="top: 50%; left: 50%; transform: translate(-50%, -50%) translate(-195px, 45px);">
        <div class="value-node animate-random hover:scale-110 transition-all duration-300" style="animation-delay: 1s;">
          <div class="value-number glow-ring mb-3" data-number="6"></div>
          <h3 class="text-xl md:text-2xl font-semibold mb-1">RESILIENCE</h3>
          <p class="text-sm md:text-base text-gray-200">Strength in adversity.</p>
        </div>
      </div>

      <!-- Node 7: Kindness (Angle: -141.43° equivalent to 218.57°) -->
      <div class="value-node-wrapper absolute"
           style="top: 50%; left: 50%; transform: translate(-50%, -50%) translate(-156px, -126px);">
        <div class="value-node animate-random hover:scale-110 transition-all duration-300" style="animation-delay: 1.2s;">
          <div class="value-number glow-ring mb-3" data-number="7"></div>
          <h3 class="text-xl md:text-2xl font-semibold mb-1">KINDNESS</h3>
          <p class="text-sm md:text-base text-gray-200">Genuine care.</p>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Mobile Version: Grid Floating (Two Cards per Row) -->
<section
  id="values-3d-mobile"
  class="block md:hidden relative py-12 bg-gradient-to-bl from-blue-700 via-black to-blue-700 text-white overflow-hidden"
>
  <!-- Sparkle Particle Background (Mobile) -->
  <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
    <canvas id="sparkle-bg-mobile" class="w-full h-full opacity-20"></canvas>
  </div>

  <div class="max-w-5xl mx-auto px-4 relative z-10 text-center">
    <!-- Header -->
    <div class="mb-10">
      <h2 class="text-3xl font-bold tracking-tight">
        Our Core Values at <span class="text-green-300">Custospark</span>
      </h2>
   
    </div>

    <!-- Core Value Cards -->
    <div class="grid grid-cols-2 gap-6 justify-items-center">
      <!-- Innovation -->
      <div class="bg-white/10 backdrop-blur-lg p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-random text-center" style="animation-delay: 0s;">
        <div class="value-number glow-ring mb-2" data-number="1"></div>
        <h3 class="text-lg font-semibold mb-1">INNOVATION</h3>
        <p class="text-xs text-gray-200">Empowering creativity.</p>
      </div>

      <!-- Integrity -->
      <div class="bg-white/10 backdrop-blur-lg p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-random text-center" style="animation-delay: 0.2s;">
        <div class="value-number glow-ring mb-2" data-number="2"></div>
        <h3 class="text-lg font-semibold mb-1">INTEGRITY</h3>
        <p class="text-xs text-gray-200">Honesty in action.</p>
      </div>

      <!-- Respect -->
      <div class="bg-white/10 backdrop-blur-lg p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-random text-center" style="animation-delay: 0.4s;">
        <div class="value-number glow-ring mb-2" data-number="3"></div>
        <h3 class="text-lg font-semibold mb-1">RESPECT</h3>
        <p class="text-xs text-gray-200">Celebrating every voice.</p>
      </div>

      <!-- Kindness -->
      <div class="bg-white/10 backdrop-blur-lg p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-random text-center" style="animation-delay: 0.6s;">
        <div class="value-number glow-ring mb-2" data-number="4"></div>
        <h3 class="text-lg font-semibold mb-1">KINDNESS</h3>
        <p class="text-xs text-gray-200">Genuine care.</p>
      </div>

      <!-- Excellence -->
      <div class="bg-white/10 backdrop-blur-lg p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-random text-center" style="animation-delay: 0.8s;">
        <div class="value-number glow-ring mb-2" data-number="5"></div>
        <h3 class="text-lg font-semibold mb-1">EXCELLENCE</h3>
        <p class="text-xs text-gray-200">Raising the bar.</p>
      </div>

      <!-- Resilience -->
      <div class="bg-white/10 backdrop-blur-lg p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-random text-center" style="animation-delay: 1s;">
        <div class="value-number glow-ring mb-2" data-number="6"></div>
        <h3 class="text-lg font-semibold mb-1">RESILIENCE</h3>
        <p class="text-xs text-gray-200">Strength in adversity.</p>
      </div>

      <!-- Collaboration (Spanning two columns) -->
      <div class="bg-white/10 backdrop-blur-lg p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-random col-span-2 text-center" style="animation-delay: 1.2s;">
        <div class="value-number glow-ring mb-2" data-number="7"></div>
        <h3 class="text-lg font-semibold mb-1">COLLABORATION</h3>
        <p class="text-xs text-gray-200">Shared success.</p>
      </div>
    </div>
  </div>
</section>


<!-- Shared Custom Animations & Responsive Styles -->
<style>
  /* Desktop: 3D Setup and Perspective */
  .perspective-container {
    perspective: 1200px;
  }
  .transform-style-3d {
    transform-style: preserve-3d;
  }
  /* Base Value Node Styles for desktop cards */
  .value-node {
    position: relative;
    transform-style: preserve-3d;
    transition: transform 0.3s ease;
    will-change: transform;
  }
  .value-node:hover {
    transform: scale(1.05);
  }
  /* Random Floating Movement */
  @keyframes randomMove {
    0% { transform: translate(0, 0); }
    25% { transform: translate(8px, -4px); }
    50% { transform: translate(-8px, 8px); }
    75% { transform: translate(4px, -6px); }
    100% { transform: translate(0, 0); }
  }
  .animate-random {
    animation: randomMove 5s ease-in-out infinite;
  }
  /* Value Number with Glow (shared) */
  .value-number {
    width: 48px;
    height: 48px;
    margin: 0 auto;
    border-radius: 50%;
    background-color: #34d399;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    font-size: 1.2rem;
    position: relative;
    z-index: 10;
  }
  .glow-ring::before {
    content: '';
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, transparent 70%);
    filter: blur(6px);
    z-index: -1;
    animation: pulse-ring 2s infinite ease-in-out;
  }
  @keyframes pulse-ring {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.5; }
  }
  /* Ensure the sparkle background is oriented correctly */
  #sparkle-bg-desktop, #sparkle-bg-mobile {
    transform: rotate(180deg);
    transform-origin: center;
    display: block;
  }
  /* Responsive adjustments for desktop */
  @media (max-width: 640px) {
    .perspective-container {
      perspective: 800px;
    }
    .relative.h-

\[600px\]

 {
      height: 400px;
    }
  }
</style>

<!-- Include particles.js from CDN for Desktop and Mobile Sparkle Background -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
  // Desktop Sparkle Background Initialization
  particlesJS("sparkle-bg-desktop", {
    "particles": {
      "number": { "value": 120, "density": { "enable": true, "value_area": 800 } },
      "color": { "value": ["#FF5733", "#FFC300", "#28A745", "#17A2B8"] },
      "shape": { "type": "circle", "stroke": { "width": 0, "color": "#000" } },
      "opacity": { "value": 0.8, "random": true },
      "size": { "value": 1, "random": true },
      "line_linked": { "enable": false },
      "move": { "enable": true, "speed": 10, "direction": "none", "random": true, "straight": false, "out_mode": "out" }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": { "resize": true }
    },
    "retina_detect": true
  });
  
  // Mobile Sparkle Background Initialization
  particlesJS("sparkle-bg-mobile", {
    "particles": {
      "number": { "value": 80, "density": { "enable": true, "value_area": 10000 } },
      "color": { "value": ["#FF5733", "#FFC300", "#28A745", "#17A2B8"] },
      "shape": { "type": "hexagon", "stroke": { "width": 0, "color": "#000" } },
      "opacity": { "value": 0.8, "random": true },
      "size": { "value": 1, "random": true },
      "line_linked": { "enable": false },
      "move": { "enable": true, "speed": 5, "direction": "none", "random": true, "straight": false, "out_mode": "out" }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": { "resize": true }
    },
    "retina_detect": true
  });
  
  // Optional: Custom Sparkle Canvas Animation (can be omitted if using particles.js alone)
  (function() {
    const canvas = document.getElementById("sparkle-bg-desktop");
    if (canvas) {
      const ctx = canvas.getContext("2d");
      const stars = Array.from({ length: 80 }, () => ({
        x: Math.random() * window.innerWidth,
        y: Math.random() * window.innerHeight,
        radius: Math.random() * 2.5,
        alpha: Math.random(),
        delta: Math.random() * 0.02
      }));

      function animateSparkles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        stars.forEach(star => {
          ctx.beginPath();
          ctx.arc(star.x, star.y, star.radius, 0, Math.PI * 2);
          ctx.fillStyle = `rgba(255,255,255,${star.alpha})`;
          ctx.fill();
          star.alpha += star.delta;
          if (star.alpha <= 0 || star.alpha >= 1) star.delta *= -1;
        });
        requestAnimationFrame(animateSparkles);
      }

      function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
      }

      window.addEventListener("resize", resizeCanvas);
      resizeCanvas();
      animateSparkles();
    }
  })();
</script>
