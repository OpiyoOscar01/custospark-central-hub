<section id="services" class="py-20 bg-gradient-to-b from-blue-500 via-black to-blue-500 h-full">
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
      actions: ["Request a consultation", "Schedule a demo"]
    },
    {
      title: "Web Development",
      description: "Building responsive and scalable websites to enhance your online presence.",
      icon: "bi-laptop",
      actions: ["View portfolio", "Request a quote"]
    },
    {
      title: "Mobile Development",
      description: "Creating seamless mobile experiences across iOS and Android platforms.",
      icon: "bi-phone",
      actions: ["Request a consultation", "Download demo app"]
    },
    {
      title: "SaaS Solutions",
      description: "Scalable, cloud-based solutions for modern businesses.",
      icon: "bi-cloud-arrow-down",
      actions: ["Sign up for a free trial", "Request a demo"]
    },
    {
      title: "Consulting",
      description: "Expert advice to align technology with your strategy.",
      icon: "bi-people",
      actions: ["Book a free consultation", "Schedule a meeting"]
    },
    {
      title: "Cybersecurity Solutions",
      description: "Protecting your business from digital threats with cutting-edge security measures.",
      icon: "bi-shield-lock",
      actions: ["Request a security audit", "Schedule a consultation"]
    },
    {
      title: "Blockchain Development",
      description: "Implementing decentralized, transparent, and secure blockchain solutions for businesses.",
      icon: "bi-pyramid",
      actions: ["Schedule a meeting", "Request a blockchain feasibility study"]
    },
    {
      title: "Augmented Reality (AR) & Virtual Reality (VR)",
      description: "Innovative AR/VR solutions to enhance customer experiences and improve training.",
      icon: "bi-eye",
      actions: ["Request a demo", "Schedule a meeting to discuss integration"]
    },
    {
      title: "Chatbot & Virtual Assistant Development",
      description: "Creating intelligent chatbots and virtual assistants to improve customer service and support.",
      icon: "bi-chat-left",
      actions: ["Request a demo", "Sign up for a free trial"]
    },
    {
      title: "Voice AI",
      description: "Leveraging voice assistants and speech recognition to enhance customer interaction.",
      icon: "bi-mic",
      actions: ["Request a demo", "Schedule a consultation for integration"]
    },
    {
      title: "ERP Solutions",
      description: "Tailored enterprise resource planning systems to manage and automate business processes.",
      icon: "bi-grid-3x3",
      actions: ["Request an ERP system assessment", "Schedule a product demo"]
    },
    {
      title: "CRM Solutions",
      description: "Providing CRM systems to help businesses manage customer interactions and improve relationships.",
      icon: "bi-person-check",
      actions: ["Request a demo", "Schedule a consultation"]
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
      actions: ["Request a project proposal", "View portfolio"]
    },
    {
      title: "AI-Powered Marketing Solutions",
      description: "Enhancing marketing efforts using AI-driven tools for personalized customer targeting.",
      icon: "bi-bullseye",
      actions: ["Sign up for a demo", "Request a free marketing assessment"]
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
        ${service.actions.map(action => `<button class="bg-blue-500 text-white px-4 py-2 rounded-md">${action}</button>`).join('')}
      </div>
    `;
    
    servicesContainer.appendChild(serviceCard);
  });
</script>

<style>
  /* Scrolling wrapper with improved animation */
  .scrolling-wrapper {
    animation: scroll-right 80s linear infinite;
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
</style>

<script>
  const servicesGrid = document.getElementById("services-grid");

  // Function to generate the service cards dynamically
  services.forEach(service => {
    const serviceCard = document.createElement("div");
    serviceCard.classList.add("service-card", "bg-white", "shadow-xl", "p-6", "rounded-lg", "text-center", "border", "hover:shadow-2xl", "transition-all");

    serviceCard.innerHTML = `
      <div class="icon text-4xl mb-4 text-blue-900">
        <i class="bi ${service.icon}"></i>
      </div>
      <h3 class="text-xl font-semibold text-blue-900 mb-3">${service.title}</h3>
      <p class="text-gray-600 mb-6">${service.description}</p>
      <div class="actions">
        ${service.actions.map(action => `
          <a href="#" class="action-link bg-blue-600 text-white px-5 py-3 rounded-lg mb-3 inline-block text-center hover:bg-blue-500 transition duration-300 ease-in-out focus:outline-none">
            ${action}
          </a>
        `).join('')}
      </div>
    `;
  
    servicesGrid.appendChild(serviceCard);
  });
</script>

<script>
  // GSAP Parallax Scroll Effect for left to right scroll
  gsap.utils.toArray('.service-card').forEach(function (el) {
    gsap.from(el, {
      scrollTrigger: {
        trigger: el,
        start: "top 80%",
        end: "bottom 20%",
        scrub: true,
      },
      opacity: 0,
      x: 100,
      duration: 1
    });
  });

  AOS.init({
    duration: 1000,  // Animation duration
    easing: 'ease-in-out',  // Easing effect
    once: true  // Only trigger animation once
  });
</script>

<style>
  /* Service card hover and scale transition */
  .service-card {
    transform: translateX(0);
    opacity: 0;
    animation: fadeInLeft 0.5s ease-out forwards;
    transition: all 0.3s ease-in-out;
  }

  /* Hover effect with shadow and scale */
  .service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.15);
    scale: 1.05;
  }

  /* Smooth fade-in effect */
  @keyframes fadeInLeft {
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  /* GSAP Parallax scroll effect */
  .service-card[data-aos='fade-up'] {
    transform: translateX(50px);
  }

  [data-aos='fade-up'] {
    opacity: 0;
  }

  [data-aos='fade-up'].aos-animate {
    opacity: 1;
    transform: translateX(0);
  }
</style>
