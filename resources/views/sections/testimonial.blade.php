<!-- Testimonials Section -->
<section class="relative bg-gradient-to-b from-blue-500 via-black to-blue-500 py-24 text-white overflow-hidden">

  <!-- Particle Layer -->
  <div id="particles-js-testimonials" class="absolute inset-0 z-0"></div>

  <!-- Content -->
  <div class="relative z-10 container mx-auto px-6 text-center">
    <h2 class="text-5xl sm:text-6xl font-bold mb-6 text-white glow-text">What Our Clients Say</h2>
    <p class="text-lg sm:text-xl mb-16 font-light text-white/90 leading-relaxed">Trusted by innovators, leaders, and entrepreneurs across industries.</p>

    <!-- Testimonial Display -->
    <div id="testimonialDisplay" class="max-w-3xl mx-auto opacity-0 transition-opacity duration-1000 ease-in-out">
      <!-- Testimonial inserted dynamically -->
    </div>
  </div>

  <!-- Floating Blobs -->
  <div class="absolute inset-0 overflow-hidden z-0" aria-hidden="true">
    <div class="blob bg-pink-500 top-1/4 left-1/5"></div>
    <div class="blob bg-blue-600 top-2/3 left-1/3"></div>
    <div class="blob bg-purple-600 top-1/3 left-3/4"></div>
  </div>

</section>

<!-- Testimonials Script -->
<script>
 const testimonials = [
  {
    img: "https://i.pravatar.cc/100?img=12",
    text: `Thanks to Custospark's innovative tech solutions, we automated processes that once took us weeks, cutting our operational costs by 30%. Their approach is nothing short of brilliant.`,
    name: "Sarah L.",
    title: "CEO, HealthSync"
  },
  {
    img: "https://i.pravatar.cc/100?img=24",
    text: `Custospark’s ability to execute complex visions with unmatched speed and clarity has taken our business to the next level. We’ve seen a 40% increase in efficiency since partnering with them.`,
    name: "James K.",
    title: "CTO, LogiTrack"
  },
  {
    img: "https://i.pravatar.cc/100?img=36",
    text: `Reliable, innovative, and always ahead of the curve. Custospark is helping us disrupt the market. They’re not just a service provider, but a key partner in our growth.`,
    name: "Emily R.",
    title: "Founder, EduGrowth"
  },
  {
    img: "https://i.pravatar.cc/100?img=48",
    text: `With Custospark’s state-of-the-art tools, we’ve increased our product launch speed by 50%. They’re a true partner in progress, helping us stay ahead of our competitors.`,
    name: "Michael T.",
    title: "Product Manager, GreenTech Solutions"
  },
  {
    img: "https://i.pravatar.cc/100?img=52",
    text: `The Custospark team doesn't just follow trends—they set them. Their expertise in tech development allowed us to scale rapidly, making us a leader in our industry.`,
    name: "Linda W.",
    title: "COO, FinX"
  },
  {
    img: "https://i.pravatar.cc/100?img=60",
    text: `What stands out about Custospark is their customer-first approach. They didn’t just deliver a solution; they delivered exactly what we needed, and our client satisfaction has skyrocketed as a result.`,
    name: "David P.",
    title: "Head of Operations, TransportPlus"
  },
  {
    img: "https://i.pravatar.cc/100?img=72",
    text: `After partnering with Custospark, our operational efficiency increased by 60%, and we’ve expanded our market reach by 20%. I couldn’t recommend them more.`,
    name: "Sophia M.",
    title: "Founder, ShopEase"
  },
  {
    img: "https://i.pravatar.cc/100?img=84",
    text: `Custospark’s solutions didn’t just improve our workflow—they revolutionized it. We saved over 200 hours last quarter, all thanks to their innovative technology.`,
    name: "Daniel R.",
    title: "CTO, SolarFlare"
  },
  {
    img: "https://i.pravatar.cc/100?img=96",
    text: `From day one, Custospark showed a commitment to delivering results that matter. Their attention to detail and ability to solve complex problems has earned them our complete trust.`,
    name: "Olivia A.",
    title: "VP of Technology, FinSure"
  },
  {
    img: "https://i.pravatar.cc/100?img=108",
    text: `Working with Custospark has been a game-changer. Their tech is not only easy to integrate but has driven a 25% increase in our operational output. They’re the future of tech solutions.`,
    name: "Ethan J.",
    title: "CEO, MedicaCare"
  }
];



  let index = 0;
  const display = document.getElementById("testimonialDisplay");

  function showTestimonial(i) {
    const t = testimonials[i];
    display.innerHTML = `
      <div class="flex flex-col items-center animate-fade-in">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h.01M15 12h.01M7 16h10M4 6h16M4 6v10a2 2 0 002 2h12a2 2 0 002-2V6" />
        </svg>
        <img src="${t.img}" class="rounded-full mb-4 border-4 border-white/20 shadow-2xl transform transition-all hover:scale-110" alt="${t.name}" />
        <p class="text-2xl italic mb-4 max-w-xl text-center">"${t.text}"</p>
        <p class="font-semibold text-xl">${t.name} <span class="text-sm font-light text-white/80">— ${t.title}</span></p>
      </div>
    `;
  }

  async function cycleTestimonials() {
    while (true) {
      display.classList.remove("opacity-100");
      display.classList.add("opacity-0");
      await new Promise(res => setTimeout(res, 500)); // fade out
      showTestimonial(index);
      display.classList.remove("opacity-0");
      display.classList.add("opacity-100");
      index = (index + 1) % testimonials.length;
      await new Promise(res => setTimeout(res, 4500)); // visible duration
    }
  }

  // Initial load
  showTestimonial(index);
  display.classList.add("opacity-100");
  index++;

  // Start loop
  cycleTestimonials();
</script>

<!-- Particle JS -->
<script>
  particlesJS("particles-js-testimonials", {
    particles: {
      number: { value: 100 },
      shape: { type: "circle" },
      color: { value: "#ffffff" },
      size: { value: 3 },
      move: { speed: 3 },
    },
    interactivity: {
      events: {
        onhover: { enable: true, mode: "repulse" },
      },
    },
  });
</script>

<!-- Custom Styles -->
<style>
  #testimonialDisplay img {
    width: 120px;
    height: 120px;
  }

  @keyframes fade-in {
    from {
      transform: translateY(20px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .animate-fade-in {
    animation: fade-in 1s ease forwards;
  }

  /* Floating Blob Styles */
  .blob {
    position: absolute;
    border-radius: 50%;
    opacity: 0.3;
    animation: moveBlob 12s infinite linear;
  }

  .blob.bg-pink-500 {
    width: 350px;
    height: 350px;
    animation-duration: 12s;
  }

  .blob.bg-blue-600 {
    width: 300px;
    height: 300px;
    animation-duration: 15s;
  }

  .blob.bg-purple-600 {
    width: 250px;
    height: 250px;
    animation-duration: 18s;
  }

  @keyframes moveBlob {
    0% {
      transform: translateX(0) translateY(0);
    }
    50% {
      transform: translateX(200px) translateY(200px);
    }
    100% {
      transform: translateX(0) translateY(0);
    }
  }
</style>
