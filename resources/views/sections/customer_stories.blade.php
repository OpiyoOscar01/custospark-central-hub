<!-- Testimonials Section -->
<section class="relative bg-gradient-to-b from-blue-600 via-black to-blue-600 py-24 text-white overflow-hidden">

  <!-- Particle Layer -->
  <div id="particles-js-testimonials" class="absolute inset-0 z-0"></div>

  <!-- Content -->
  <div class="relative z-10 container mx-auto px-6 text-center">
    <h2 class="text-5xl sm:text-6xl font-bold mb-6 text-white glow-text">What Our Clients Say</h2>
    <p class="text-lg sm:text-xl mb-16 font-light text-white/90 leading-relaxed">Trusted by local innovators and leaders across East,Central,South and West Africa.</p>

    <!-- Testimonial Display -->
    <div id="testimonialDisplay" class="max-w-3xl mx-auto opacity-0 transition-opacity duration-1000 ease-in-out">
      <!-- Testimonial inserted dynamically -->
    </div>
  </div>

  <!-- Floating Blobs -->
  <div class="absolute inset-0 overflow-hidden z-0" aria-hidden="true">
    <div class="blob bg-blue-400 top-1/4 left-1/5"></div>
    <div class="blob bg-blue-700 top-2/3 left-1/3"></div>
    <div class="blob bg-blue-500 top-1/3 left-3/4"></div>
  </div>

</section>

<!-- Testimonials Script -->
<script>
 const testimonials = [
  // East Africa
  {
    img: "https://i.pravatar.cc/100?img=5",
    text: `Thanks to Custospark's innovative tech solutions, we automated processes that once took us weeks, cutting operational costs by 30%. Their approach is outstanding.`,
    name: "Joseph K.",
    title: "CEO, Kampala Tech Hub"
  },
  {
    img: "https://i.pravatar.cc/100?img=15",
    text: `Custospark’s clear vision and fast execution helped us increase efficiency by 40%. A great partner for any growing business.`,
    name: "Grace N.",
    title: "CTO, NileSoft"
  },
  {
    img: "https://i.pravatar.cc/100?img=25",
    text: `Innovative and reliable, Custospark is key to our market growth. Their tech solutions helped us disrupt our sector.`,
    name: "Moses L.",
    title: "Founder, EduGrow Uganda"
  },
  {
    img: "https://i.pravatar.cc/100?img=35",
    text: `We increased product launch speed by 50% thanks to Custospark’s tools. They are a true partner in progress.`,
    name: "Amina S.",
    title: "Product Manager, GreenTech Uganda"
  },
  {
    img: "https://i.pravatar.cc/100?img=45",
    text: `Custospark doesn’t follow trends — they set them. Their expertise helped us scale rapidly and lead in our field.`,
    name: "David M.",
    title: "COO, FinX Uganda"
  },

  // Central Africa
  {
    img: "https://i.pravatar.cc/100?img=55",
    text: `Our agricultural yields improved by 35% after integrating Custospark’s farm management tech. The team understands local challenges deeply.`,
    name: "Jean-Pierre T.",
    title: "Farm Owner, Congo AgriTech"
  },
  {
    img: "https://i.pravatar.cc/100?img=65",
    text: `Custospark's hospital management system reduced patient wait times by 40%, improving healthcare delivery in our facility.`,
    name: "Marie L.",
    title: "Director, Kinshasa General Hospital"
  },
  {
    img: "https://i.pravatar.cc/100?img=75",
    text: `Their education platform enabled us to reach thousands of students remotely during the pandemic, keeping learning uninterrupted.`,
    name: "Paul B.",
    title: "Principal, Libreville International School"
  },
  {
    img: "https://i.pravatar.cc/100?img=85",
    text: `With Custospark’s supply chain tools, our distribution network efficiency grew by 45%, saving costs and time.`,
    name: "Celine D.",
    title: "Logistics Manager, Central Africa Traders"
  },
  {
    img: "https://i.pravatar.cc/100?img=95",
    text: `Their innovative tech helped our NGO track impact metrics accurately, resulting in a 50% increase in funding support.`,
    name: "Emmanuel K.",
    title: "Program Director, Congo Impact Foundation"
  },

  // Southern Africa
  {
    img: "https://i.pravatar.cc/100?img=105",
    text: `Custospark’s CRM system boosted our customer retention by 30%, making a real difference in our retail business.`,
    name: "Thabo M.",
    title: "CEO, CapeTown Retail Co."
  },
  {
    img: "https://i.pravatar.cc/100?img=115",
    text: `Thanks to Custospark, our hospital reduced administrative errors by 60%, improving patient safety and care quality.`,
    name: "Naledi P.",
    title: "Hospital Administrator, Johannesburg Care"
  },
  {
    img: "https://i.pravatar.cc/100?img=125",
    text: `Their precision agriculture technology helped us increase crop yields by 50%, even with unpredictable weather patterns.`,
    name: "Sipho D.",
    title: "Farm Owner, Durban Agro"
  },
  {
    img: "https://i.pravatar.cc/100?img=135",
    text: `Custospark’s innovative training platform expanded our workforce skills across multiple industries, impacting over 10,000 learners.`,
    name: "Zanele K.",
    title: "Training Director, South Africa Skills Initiative"
  },
  {
    img: "https://i.pravatar.cc/100?img=145",
    text: `Their fintech solutions helped us reduce transaction times by 70%, revolutionizing how we serve our customers.`,
    name: "Mandla N.",
    title: "COO, Soweto FinTech Solutions"
  },

  // West Africa
  {
    img: "https://i.pravatar.cc/100?img=155",
    text: `With Custospark’s logistics platform, we cut delivery times in half and expanded our market reach significantly.`,
    name: "Amara C.",
    title: "Founder, Lagos Logistics Hub"
  },
  {
    img: "https://i.pravatar.cc/100?img=165",
    text: `Their e-learning platform kept education accessible for rural communities, supporting over 20,000 students across Nigeria.`,
    name: "Chidi E.",
    title: "Education Officer, Nigerian Schools Network"
  },
  {
    img: "https://i.pravatar.cc/100?img=175",
    text: `Custospark’s healthcare solutions increased our clinic’s patient follow-up rate by 35%, improving treatment outcomes.`,
    name: "Fatima B.",
    title: "Clinic Manager, Abuja Health Services"
  },
  {
    img: "https://i.pravatar.cc/100?img=185",
    text: `Our farming cooperative increased profits by 40% using Custospark’s farm management tools tailored for local conditions.`,
    name: "Kwame A.",
    title: "Chairman, Ghana Farmers Union"
  },
  {
    img: "https://i.pravatar.cc/100?img=195",
    text: `Custospark’s digital payment platform enabled us to securely process thousands of transactions daily, transforming our business.`,
    name: "Aisha S.",
    title: "CEO, Dakar Digital Payments"
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

  .blob.bg-blue-400 {
    width: 350px;
    height: 350px;
    animation-duration: 12s;
  }

  .blob.bg-blue-700 {
    width: 300px;
    height: 300px;
    animation-duration: 15s;
  }

  .blob.bg-blue-500 {
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
