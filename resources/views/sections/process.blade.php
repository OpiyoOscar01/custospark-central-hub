<!-- Process Section -->
<section id="process" class="py-20 bg-gradient-to-r from-blue-900 to-blue-500 text-white relative" data-aos="fade-up">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl font-extrabold text-white mb-6 process-title">Our Process</h2>
    <p class="mb-12 text-gray-300 text-lg max-w-2xl mx-auto">
      From consultation to launch, we ensure your success with a streamlined, efficient process designed for long-term results.
    </p>
    
    <!-- Dynamic Progress Bar -->
    <div class="progress-bar-container relative mb-8">
      <div class="progress-bar bg-gradient-to-r from-orange-500 to-yellow-400 h-1 rounded" style="width: 20%;"></div>
    </div>
    
    <!-- Process Steps -->
    <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
      
      <!-- Arrow Connector (one overall connector overlay) -->
      <div class="absolute arrow-connector top-0 left-1/2 transform -translate-x-1/2 mt-20">
        <svg width="30" height="60" xmlns="http://www.w3.org/2000/svg" class="connector-icon text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7l-7 7-7-7"></path>
        </svg>
      </div>
      
      <!-- Step 1: Consultation -->
      <div class="process-card step bg-gray-50 bg-opacity-80 backdrop-blur-md p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:rotate-1 hover:shadow-xl" data-step="1">
        <div class="mb-4">
          <span class="step-number inline-block bg-gradient-to-r from-orange-500 to-yellow-400 text-white px-4 py-2 rounded-full text-xl font-semibold">
            1
          </span>
        </div>
        <h5 class="font-bold text-blue-900 text-xl mb-4">Consultation</h5>
        <p class="text-gray-600">
          We start by understanding your unique needs, goals, and challenges. Our consultation ensures we align with your vision.
        </p>
      </div>
      
      <!-- Step 2: Proposal -->
      <div class="process-card step bg-gray-50 bg-opacity-80 backdrop-blur-md p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:rotate-1 hover:shadow-xl" data-step="2">
        <div class="mb-4">
          <span class="step-number inline-block bg-gradient-to-r from-orange-500 to-yellow-400 text-white px-4 py-2 rounded-full text-xl font-semibold">
            2
          </span>
        </div>
        <h5 class="font-bold text-blue-900 text-xl mb-4">Proposal</h5>
        <p class="text-gray-600">
          We craft a tailored proposal outlining the strategy, budget, and timeline for your project.
        </p>
      </div>
      
      <!-- Step 3: Design & Development -->
      <div class="process-card step bg-gray-50 bg-opacity-80 backdrop-blur-md p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:rotate-1 hover:shadow-xl" data-step="3">
        <div class="mb-4">
          <span class="step-number inline-block bg-gradient-to-r from-orange-500 to-yellow-400 text-white px-4 py-2 rounded-full text-xl font-semibold">
            3
          </span>
        </div>
        <h5 class="font-bold text-blue-900 text-xl mb-4">Design & Development</h5>
        <p class="text-gray-600">
          Our teams collaborate to create intuitive, high-quality solutions that meet your specifications.
        </p>
      </div>
      
      <!-- Step 4: Testing -->
      <div class="process-card step bg-gray-50 bg-opacity-80 backdrop-blur-md p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:rotate-1 hover:shadow-xl" data-step="4">
        <div class="mb-4">
          <span class="step-number inline-block bg-gradient-to-r from-orange-500 to-yellow-400 text-white px-4 py-2 rounded-full text-xl font-semibold">
            4
          </span>
        </div>
        <h5 class="font-bold text-blue-900 text-xl mb-4">Testing</h5>
        <p class="text-gray-600">
          We rigorously test all solutions to ensure they are robust, secure, and perform seamlessly.
        </p>
      </div>
      
      <!-- Step 5: Launch & Support -->
      <div class="process-card step bg-gray-50 bg-opacity-80 backdrop-blur-md p-6 rounded-lg shadow-lg transition-transform hover:scale-105 hover:rotate-1 hover:shadow-xl" data-step="5">
        <div class="mb-4">
          <span class="step-number inline-block bg-gradient-to-r from-orange-500 to-yellow-400 text-white px-4 py-2 rounded-full text-xl font-semibold">
            5
          </span>
        </div>
        <h5 class="font-bold text-blue-900 text-xl mb-4">Launch & Support</h5>
        <p class="text-gray-600">
          We provide ongoing support after launch to ensure your solution evolves and succeeds.
        </p>
      </div>
      
    </div>

    <!-- Call to Action -->
    <div class="mt-12">
      <a href="{{ route('consultation') }}" class="cta-button bg-gradient-to-r from-blue-500 to-black hover:bg-gradient-to-r hover:from-black hover:to-blue-500 text-white font-semibold py-4 px-8 rounded-lg transition-transform transform hover:scale-105 shadow-lg mt-8">
        Get in Touch
      </a>
    </div>
  </div>
</section>

<!-- GSAP & ScrollTrigger -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script>
  // Register GSAP ScrollTrigger
  gsap.registerPlugin(ScrollTrigger);

  // Animate process cards with stagger
  gsap.from(".process-card", {
    scrollTrigger: {
      trigger: "#process",
      start: "top 80%"
    },
    opacity: 0,
    y: 50,
    duration: 1,
    stagger: 0.3,
    ease: "power3.out"
  });

  // Animate arrow connectors with a subtle bounce (if desired)
  gsap.from(".arrow-connector", {
    scrollTrigger: {
      trigger: "#process",
      start: "top 80%"
    },
    opacity: 0,
    y: 20,
    duration: 1,
    stagger: 0.2,
    ease: "back.out(1.7)"
  });

  // Animate the progress bar (simulate process progress as you scroll)
  gsap.to(".progress-bar", {
    scrollTrigger: {
      trigger: "#process",
      start: "top top",
      end: "bottom top",
      scrub: true
    },
    width: "100%",
    ease: "none"
  });
</script>

<!-- Additional CSS -->
<style>
  /* Progress bar container (for background effect) */
  .progress-bar-container {
    position: relative;
    height: 5px;
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 5px;
    overflow: hidden;
  }
  .progress-bar {
    height: 100%;
    background-color: #ffa500; /* Orange color */
    border-radius: 5px;
  }

  /* Arrow Connector Pulse Animation */
  .arrow {
    animation: pulse 1.5s ease-in-out infinite;
  }
  @keyframes pulse {
    0% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(1); opacity: 0.6; }
  }

  /* CTA Button Hover Transition */
  .cta-button:hover {
    transform: scale(1.1);
    box-shadow: 0 0 15px rgba(255, 165, 0, 0.5);
  }

  /* Process Card Hover Effects */
  .step:hover {
    transform: scale(1.05) rotate(1deg);
  }
  
  /* Responsive adjustments */
  @media (max-width: 640px) {
    .process-card { padding: 1.5rem; }
    .progress-bar-container { margin-bottom: 1.5rem; }
  }
</style>
