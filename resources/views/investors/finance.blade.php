<!-- Financial Information Section with 3D Floating Cards & Particle.js Background -->
{{-- <section id="financial-information" class="py-24 bg-gradient-to-br from-blue-500 via-black to-blue-500 text-white overflow-hidden">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Section Header -->
    <div class="text-center mb-16">
      <h2 class="text-4xl sm:text-5xl font-bold">Financial Information</h2>
      <p class="text-lg sm:text-xl mt-4 max-w-2xl mx-auto leading-relaxed text-white">
        Explore Custospark’s financial journey—from founder-led reinvestments to our strategic funding plans for exponential growth.
      </p>
    </div>

    <!-- Founder Reinvestment Overview Card -->
    <div class="mb-16 p-6 bg-white/90 border border-gray-200 backdrop-blur-md rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 perspective-1000 animate-float">
      <h3 class="text-3xl font-semibold mb-4 text-blue-500">Founder Reinvestment (UGX)</h3>
      <p class="text-lg sm:text-xl leading-relaxed text-gray-800">
        Since 2023, Custospark has been bootstrapped—UGX 30 million was reinvested by the founders to build our core infrastructure, platforms, and brand.
      </p>
      <div class="mt-8 bg-white rounded-xl p-6 shadow-2xl ring-2 ring-white/10">
        <canvas id="revenueGrowthChart" height="120"></canvas>
      </div>
      <p class="text-sm text-gray-800 mt-4 italic text-center">
        This reinvestment powered our MVP launch and secure early market traction.
      </p>
    </div>

    <!-- Funding History Card -->
    <div class="mb-16 p-6 bg-white/90 border border-gray-200 backdrop-blur-md rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 perspective-1000 animate-float" style="animation-delay: 0.4s;">
      <h3 class="text-3xl font-semibold mb-4 text-blue-500">Funding History (UGX)</h3>
      <p class="text-lg sm:text-xl leading-relaxed text-gray-800">
        Custospark has been 100% founder-funded. We now seek early-stage investment to scale operations, enhance talent, and expand market reach.
      </p>
      <div class="mt-8 bg-white rounded-xl p-6 shadow-2xl ring-2 ring-white/10">
        <canvas id="fundingHistoryChart" height="120"></canvas>
      </div>
      <p class="text-sm text-gray-800 mt-4 italic text-center">
        Total funding: UGX 30,000,000 — solely from the founders.
      </p>
    </div>

    <!-- Financial Projections Card -->
    <div class="mb-16 p-6 bg-white/90 border border-gray-200 backdrop-blur-md rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 perspective-1000 animate-float" style="animation-delay: 0.8s;">
      <h3 class="text-3xl font-semibold mb-4 text-blue-500">Financial Projections (UGX)</h3>
      <p class="text-lg sm:text-xl leading-relaxed text-gray-800">
        Fuelled by our growth strategy and product-market fit, we project steady revenue increases. These projections inform our funding targets.
      </p>
      <div class="mt-8 bg-white rounded-xl p-6 shadow-2xl ring-2 ring-white/10">
        <canvas id="projectionChart" height="120"></canvas>
      </div>
      <p class="text-sm text-gray-800 mt-4 italic text-center">
        Projections are based on lean execution, streamlined scaling, and recurring revenue from SaaS and enterprise contracts.
      </p>
    </div>
  </div>
</section> --}}

<!-- CTA: Let's Talk Investment -->
{{-- <section class="bg-gradient-to-l from-blue-500 via-black to-blue-500 py-16 text-white">
  <div class="max-w-3xl mx-auto text-center px-6">
    <h3 class="text-3xl sm:text-4xl font-bold mb-4">Let’s Talk Investment</h3>
    <p class="text-lg sm:text-xl text-gray-100 leading-relaxed mb-6">
      Custospark—founded by visionary university innovators—is building the future of technology. We’re now seeking strategic partners to scale our impact.
    </p>
    <p class="text-sm text-gray-200 mt-4">
      Email us at <a href="mailto:investors@custospark.com" class="underline text-white">investors@custospark.com</a>
    </p>
  </div>
</section> --}}

<!-- Shared 3D Floating Animation for Cards -->
<style>
  @keyframes float3d {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }
  .animate-float {
    animation: float3d 4s ease-in-out infinite;
  }
</style>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Reinvestment Growth Chart
  const revenueCtx = document.getElementById('revenueGrowthChart').getContext('2d');
  new Chart(revenueCtx, {
    type: 'line',
    data: {
      labels: ['2023', '2024', '2025'],
      datasets: [{
        label: 'Reinvested Capital (UGX in Millions)',
        data: [10, 8, 12],
        backgroundColor: 'rgba(255, 255, 255, 0.1)',
        borderColor: '#10b981',
        borderWidth: 3,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#10b981'
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { labels: { color: '#10b981' } } },
      scales: {
        x: { ticks: { color: '#334155' }, grid: { display: false } },
        y: { 
          ticks: { 
            color: '#334155',
            callback: function(value) { return 'UGX ' + value + 'M'; }
          },
          grid: { color: '#e2e8f0' } 
        }
      }
    }
  });

  // Funding History Chart
  const fundingCtx = document.getElementById('fundingHistoryChart').getContext('2d');
  new Chart(fundingCtx, {
    type: 'bar',
    data: {
      labels: ['2023', '2024', '2025'],
      datasets: [{
        label: 'Total Founder Funding (UGX)',
        data: [10000000, 8000000, 12000000],
        backgroundColor: '#ec4899'
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { labels: { color: '#ec4899' } } },
      scales: {
        x: { ticks: { color: '#ec4899' }, grid: { display: false } },
        y: { 
          ticks: { 
            color: '#ec4899',
            callback: function(value) { return 'UGX ' + value.toLocaleString(); }
          },
          grid: { color: '#fce7f3' } 
        }
      }
    }
  });

  // Financial Projection Chart
  const projectionCtx = document.getElementById('projectionChart').getContext('2d');
  new Chart(projectionCtx, {
    type: 'line',
    data: {
      labels: ['2025', '2026', '2027'],
      datasets: [{
        label: 'Projected Revenue (UGX in Millions)',
        data: [150, 430, 780],
        backgroundColor: 'rgba(255, 255, 255, 0.1)',
        borderColor: '#f59e0b',
        borderWidth: 3,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#f59e0b'
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { labels: { color: '#fbbf24' } } },
      scales: {
        x: { ticks: { color: '#fbbf24' }, grid: { display: false } },
        y: { 
          ticks: { 
            color: '#fbbf24',
            callback: function(value) { return 'UGX ' + value + 'M'; }
          },
          grid: { color: '#fef3c7' }
        }
      }
    }
  });
</script>

<!-- Particles.js Sparkle Background Initialization -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
  particlesJS("market-analysis-bg", {
    "particles": {
      "number": { "value": 100, "density": { "enable": true, "value_area": 800 } },
      "color": { "value": ["#FFC300", "#FF5733", "#28A745", "#17A2B8"] },
      "shape": { "type": "circle", "stroke": { "width": 0, "color": "#000" } },
      "opacity": { "value": 0.8, "random": true },
      "size": { "value": 8, "random": true },
      "line_linked": { "enable": false },
      "move": { "enable": true, "speed": 2, "direction": "none", "random": true, "straight": false, "out_mode": "out" }
    },
    "interactivity": { "detect_on": "canvas", "events": { "resize": true } },
    "retina_detect": true
  });
</script>
