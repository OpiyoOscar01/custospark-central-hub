<section id="about-us" class="py-20 bg-gradient-to-br from-blue-500 via-pink-800 to-blue-500 text-white">

  <!-- Who We Are Section -->
    @include('about_us.who_we_are')
  <!-- Who We Are Section -->
    @include('about_us.values')


  <!-- Vision Section -->
  <div class="section py-12 bg-blue-500" id="vision">
    <div class="container mx-auto text-center px-6">
      <h2 class="text-4xl font-bold text-white mb-4">Our Vision</h2>
      <p class="text-lg text-gray-200">Our vision is to be a global leader in technology, transforming industries and creating a positive impact on the world through innovation and excellence.</p>
    </div>
  </div>

  <!-- Goals Section -->
  <div class="section py-12 bg-gray-700" id="goals">
    <div class="container mx-auto text-center px-6">
      <h2 class="text-4xl font-bold text-white mb-4">Our Goals</h2>
      <p class="text-lg text-gray-200">Our goals are focused on creating scalable solutions, enhancing customer experience, and advancing technological innovations that change the world.</p>
    </div>
  </div>

  <!-- Location Section -->
  <div class="section py-12 bg-blue-600" id="location">
    <div class="container mx-auto text-center px-6">
      <h2 class="text-4xl font-bold text-white mb-4">Our Location</h2>
      <p class="text-lg text-gray-200">We are based in the heart of the tech hub, offering global solutions with a local touch. Our headquarters is located in the vibrant city of [City Name].</p>
    </div>
  </div>

  <!-- Team Section -->
  <div class="section py-12 bg-gray-800" id="team">
    <div class="container mx-auto text-center px-6">
      <h2 class="text-4xl font-bold text-white mb-4">Meet Our Team</h2>
      <p class="text-lg text-gray-200">Our team is a diverse group of passionate professionals committed to delivering excellence and pushing the boundaries of what's possible.</p>
    </div>
  </div>

  <!-- History Section -->
  <div class="section py-12 bg-blue-500" id="history">
    <div class="container mx-auto text-center px-6">
      <h2 class="text-4xl font-bold text-white mb-4">Our History</h2>
      <p class="text-lg text-gray-200">Founded in [Year], we have a rich history of growth and innovation. Over the years, we have helped businesses evolve and adapt to ever-changing market conditions.</p>
    </div>
  </div>

  <!-- Contact Us Section -->
  <div class="section py-12 bg-gray-700" id="contact-us">
    <div class="container mx-auto text-center px-6">
      <h2 class="text-4xl font-bold text-white mb-4">Contact Us</h2>
      <p class="text-lg text-gray-200">Get in touch with us for any inquiries or support. Our team is here to assist you and provide the information you need.</p>
    </div>
  </div>

  <!-- Social Media Section -->
  <div class="section py-12 bg-blue-600" id="socials">
    <div class="container mx-auto text-center px-6">
      <h2 class="text-4xl font-bold text-white mb-4">Follow Us</h2>
      <p class="text-lg text-gray-200">Stay connected with us on social media for updates, insights, and news about our company and the industry.</p>
      <div class="flex justify-center space-x-6 mt-6">
        <a href="#" class="text-white text-3xl hover:text-gray-300 transition duration-200 ease-in-out"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-white text-3xl hover:text-gray-300 transition duration-200 ease-in-out"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-white text-3xl hover:text-gray-300 transition duration-200 ease-in-out"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>

</section>

<style>
  /* Parallax Effect */
  .section:not(#who-we-are) {
    background-attachment: fixed;
  }

  .section.active {
    opacity: 1;
    transform: translateY(0);
    transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
  }

  .section:not(.active) {
    opacity: 0;
    transform: translateY(30px);
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll('.section');

    // Intersection Observer for smooth transition
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
        } else {
          entry.target.classList.remove('active');
        }
      });
    }, {
      threshold: 0.5  // Trigger when 50% of section is in view
    });

    sections.forEach(section => {
      observer.observe(section);
    });

    // Parallax effect for background (only for sections excluding 'who-we-are')
    window.addEventListener('scroll', () => {
      sections.forEach(section => {
        if (!section.id === 'who-we-are') {  // Exclude "Who We Are" section
          let scrollY = window.pageYOffset;
          section.style.transform = `translateY(${scrollY * 0.05}px)`;
        }
      });
    });
  });
</script>
