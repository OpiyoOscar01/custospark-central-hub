<!-- Contact Us Section -->
<section id="contact" class="py-24 bg-gradient-to-br from-blue-500 via-black to-blue-500 text-white relative overflow-hidden">
  <div class="container mx-auto px-6 max-w-7xl">
    
    <!-- Header -->
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-4xl sm:text-5xl font-bold flex items-center justify-center gap-4 animate__animated animate__fadeInDown">
        <i class="fas fa-envelope text-white/80"></i>
        Contact Us
      </h2>
      <p class="mt-4 text-lg text-gray-200 max-w-2xl mx-auto animate__animated animate__fadeIn">
        <i class="fas fa-paper-plane text-white mr-2"></i>
        Whether you're an investor, collaborator, or someone with a bold new idea, we're excited to connect. Reach out and let's create something extraordinary together.
      </p>
    </div>
      @if(session('success'))
    <div class="text-green-500 text-sm">{{ session('success') }}</div>
  @endif

    <!-- Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
      
      <!-- Contact Form Placeholder -->
      <div class="animate__animated animate__fadeInLeft animate__delay-1s">
        <div class="bg-white/90 backdrop-blur-lg p-8 rounded-2xl shadow-xl">
          <h3 class="text-xl font-semibold text-blue-800 mb-4">Send Us a Message</h3>
          <!-- You can replace this with your actual form -->
       <form id="contactForm" action="{{ route('contact.submit') }}" method="POST" class="space-y-4" onsubmit="return validateForm(event)">
    @csrf

    <!-- Name Field -->
    <div class="relative">
        <i class="bi bi-person absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        <input type="text" name="name" id="name" placeholder="Your Name"
               class="w-full pl-10 pr-4 py-3 rounded-lg bg-white text-black border border-gray-300 focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Email Field -->
    <div class="relative">
        <i class="bi bi-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        <input type="email" name="email" id="email" placeholder="Your Email"
               class="w-full pl-10 pr-4 py-3 rounded-lg bg-white text-black border border-gray-300 focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Message Field -->
    <div class="relative">
        <i class="bi bi-chat-dots absolute left-3 top-4 text-gray-500"></i>
        <textarea name="message" id="message" rows="4" placeholder="Your Message"
                  class="w-full pl-10 pr-4 py-3 rounded-lg bg-white text-black border border-gray-300 focus:ring-2 focus:ring-blue-500"></textarea>
    </div>

    <!-- Submit Button -->
    <button type="submit"
            class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 rounded-lg transition duration-300 shadow-md">
                <i class="fas fa-paper-plane text-white mr-2"></i>
                  Send Message
    </button>
</form>

        </div>
      </div>

      <!-- Contact Info -->
      <div class="animate__animated animate__fadeInRight animate__delay-1s">
        <div class="bg-white/10 backdrop-blur-md p-8 rounded-2xl shadow-xl text-white space-y-4">
          <div class="text-center">
            <p class="text-2xl font-semibold mb-2">
              <i class="fas fa-phone-alt mr-3"></i>+256 756 697 871
            </p>
            <div class="space-y-1 text-sm">
              <p><i class="fas fa-envelope mr-2 text-blue-300"></i>info@custospark.com</p>
              <p><i class="fas fa-envelope mr-2 text-blue-300"></i>inquiries@custospark.com</p>
              <p><i class="fas fa-envelope mr-2 text-blue-300"></i>investors@custospark.com</p>
              <p><i class="fas fa-envelope mr-2 text-blue-300"></i>partners@custospark.com</p>
              <p><i class="fas fa-envelope mr-2 text-blue-300"></i>teams@custospark.com</p>
            </div>
            <p class="mt-3 text-sm">
              <i class="fas fa-map-marker-alt mr-2 text-red-400"></i>Kampala, Uganda
            </p>
            <p class="mt-6 text-xs italic text-gray-300">
              We're always available to chat about innovative ideas and partnership opportunities. Your next big breakthrough starts with a conversation.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
  <script>
function validateForm(event) {
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const message = document.getElementById("message");

    if (!name.value.trim()) {
        alert("Please enter your name.");
        name.focus();
        event.preventDefault();
        return false;
    }

    if (!email.value.trim()) {
        alert("Please enter your email.");
        email.focus();
        event.preventDefault();
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value.trim())) {
        alert("Please enter a valid email address.");
        email.focus();
        event.preventDefault();
        return false;
    }

    if (!message.value.trim()) {
        alert("Please enter your message.");
        message.focus();
        event.preventDefault();
        return false;
    }

    return true;
}
</script>

</section>

<!-- Animate.css CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
