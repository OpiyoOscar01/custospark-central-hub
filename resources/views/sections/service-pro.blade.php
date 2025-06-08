<section id="services" class="py-20 bg-gradient-to-r from-blue-500 via-black to-blue-500 h-full" data-aos="fade-up">
  <!-- Overlay -->
  <div class="absolute inset-0 bg-black opacity-50 z-0"></div>

  <!-- Gradient edges -->
  {{-- <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-black/80 to-transparent z-20 pointer-events-none"></div>
  <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-black/80 to-transparent z-20 pointer-events-none"></div> --}}

  <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-white mb-6">Our Services</h2>
    <p class="mb-12 text-gray-200">We offer a range of services to help your business excel.</p>

    <div class="overflow-hidden relative">
      <!-- Scrolling wrapper for services -->
      <div class="scrolling-wrapper flex gap-6 w-max">
        <!-- Dynamic services cards will be inserted here by JavaScript -->
      </div>
    </div>
  </div>
</section>


<script>
  const services = [
    {
      title: "Custom Software",
      description: "Bespoke solutions designed for your business needs.",
      icon: "bi-gear-fill",
      actions: ["Get in touch", "Request a consultation"]
    },
    {
      title: "Web Development",
      description: "Building responsive and scalable websites to enhance your online presence.",
      icon: "bi-laptop",
      actions: ["Talk to an expert", "Get a free quote"]
    },
    {
      title: "Mobile Development",
      description: "Creating seamless mobile experiences across iOS and Android platforms.",
      icon: "bi-phone",
      actions: ["Start a conversation", "Request a mobile demo"]
    },
    {
      title: "SaaS Solutions",
      description: "Scalable, cloud-based solutions for modern businesses.",
      icon: "bi-cloud-arrow-down",
      actions: ["Get started with a free trial", "Request a personalized demo"]
    },
    {
      title: "Consulting",
      description: "Expert advice to align technology with your strategy.",
      icon: "bi-people",
      actions: ["Book a free consultation", "Schedule a one-on-one strategy session"]
    },
    {
      title: "Cybersecurity Solutions",
      description: "Protecting your business from digital threats with cutting-edge security measures.",
      icon: "bi-shield-lock",
      actions: ["Secure your business", "Request a security audit"]
    },
    {
      title: "Blockchain Development",
      description: "Implementing decentralized, transparent, and secure blockchain solutions for businesses.",
      icon: "bi-pyramid",
      actions: ["Discover Blockchain Solutions", "Request a feasibility study"]
    },
    {
      title: "Augmented Reality (AR) & Virtual Reality (VR)",
      description: "Innovative AR/VR solutions to enhance customer experiences and improve training.",
      icon: "bi-eye",
      actions: ["Request an AR/VR demo", "Book an integration consultation"]
    },
    {
      title: "Chatbot & Virtual Assistant Development",
      description: "Creating intelligent chatbots and virtual assistants to improve customer service and support.",
      icon: "bi-chat-left",
      actions: ["Get a chatbot demo", "Start a conversation for custom solutions"]
    },
    {
      title: "Voice AI",
      description: "Leveraging voice assistants and speech recognition to enhance customer interaction.",
      icon: "bi-mic",
      actions: ["Request a Voice AI demo", "Consult with a voice AI expert"]
    },
    {
      title: "ERP Solutions",
      description: "Tailored enterprise resource planning systems to manage and automate business processes.",
      icon: "bi-grid-3x3",
      actions: ["Request an ERP system assessment", "Book a personalized demo"]
    },
    {
      title: "CRM Solutions",
      description: "Providing CRM systems to help businesses manage customer interactions and improve relationships.",
      icon: "bi-person-check",
      actions: ["Start a CRM conversation", "Book a CRM consultation"]
    },
    {
      title: "Robotic Process Automation (RPA)",
      description: "Automating repetitive tasks with intelligent bots to improve efficiency and reduce operational costs.",
      icon: "bi-robot",
      actions: ["Request an RPA assessment", "Book a consultation"]
    },
    {
      title: "3D Modeling & Product Visualization",
      description: "Creating realistic 3D models for product design, marketing, and virtual showrooms.",
      icon: "bi-cube",
      actions: ["Request a project proposal", "View our portfolio"]
    },
    {
      title: "AI-Powered Marketing Solutions",
      description: "Enhancing marketing efforts using AI-driven tools for personalized customer targeting.",
      icon: "bi-bullseye",
      actions: ["Request a marketing consultation", "Get a personalized demo"]
    }
];


  // Merge the services array to create an infinite scrolling effect
  const infiniteServices = [...services, ...services];

  // Render the services dynamically
  const servicesContainer = document.querySelector('.scrolling-wrapper');
  infiniteServices.forEach(service => {
    const serviceCard = document.createElement('div');
    serviceCard.classList.add('card', 'min-w-[260px]', 'backdrop-blur-lg', 'bg-white/10', 'p-6', 'rounded-2xl', 'shadow-xl', 'flex-shrink-0', 'transition-transform', 'duration-300', 'hover:scale-105', 'hover:shadow-blue-500/50', 'animate-float');
    
    serviceCard.innerHTML = ` 
      <div class="icon text-5xl mb-4 text-blue-400 drop-shadow-lg">
        <i class="bi ${service.icon}"></i>
      </div>
      <h3 class="text-xl font-bold text-white mb-1 transition-transform hover:text-blue-500">${service.title}</h3>
      <p class="text-sm text-gray-200 mb-1 transition-opacity hover:opacity-80">${service.description}</p>
      <div class="actions flex gap-4 mt-4">
        <a href="{{ route('consultation') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">${service.actions[0]}</a>
        <a href="{{ route('consultation') }}" class="bg-yellow-500 text-black px-4 py-2 rounded-md">${service.actions[1]}</a>
      </div>
    `;
    
    servicesContainer.appendChild(serviceCard);
  });
</script>

<style>
  /* Scrolling wrapper with improved animation */
  .scrolling-wrapper {
    animation: scroll-right 60s linear infinite;
    display: flex;
    will-change: transform;
  }

  @keyframes scroll-right {
    0% {
      transform: translateX(0%);
    }
    100% {
      transform: translateX(-50%);
    }
  }

  .scrolling-wrapper:hover {
    animation-play-state: paused;
  }

  /* Floating animation for each card */
  @keyframes float {
    0%, 100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-5px);
    }
  }

  .animate-float {
    animation: float 6s ease-in-out infinite;
  }

  /* Hover interactions */
  .card:hover {
    background-color: rgba(255, 255, 255, 0.15);
    transform: scale(1.05);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
  }

  .card h3:hover {
    color: #1E40AF; /* Blue hover for text */
  }

  .card p:hover {
    opacity: 0.8; /* Text opacity hover */
  }

  /* Call to Action Section */
  #cta {
    background: linear-gradient(to right, #9c27b0, #2196f3, #ff9800);
  }

  #cta .bg-yellow-500:hover {
    background-color: #f57c00;
  }
</style>
