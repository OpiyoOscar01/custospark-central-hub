<!-- Footer Section -->
<footer class="bg-gradient-to-b from-blue-500 via-black to-blue-500 text-white py-16">
  <div class="container mx-auto px-6">
    
    
    <!-- Logo and Links Section -->
    <div class="flex flex-wrap justify-between items-start mb-12">
      
      <!-- Logo and Company Summary -->
      <div class="mb-8 md:mb-0">
        <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="w-40 h-40 md:w-48 md:h-48 rounded-full object-cover mb-4">
        <h2 class="text-xl font-semibold">Custospark Company Ltd</h2>
        <p class="text-sm italic">PowerHouse of Innovations.</p>
      </div>

      <!-- Quick Links -->
      <div class="mb-8 md:mb-0">
        <h4 class="text-lg font-bold mb-4">Quick Links</h4>
        <ul class="space-y-2">
          <li><a href="{{ route('about-us') }}" class="hover:text-blue-200 no-underline flex items-center"><i class="bi bi-info-circle mr-2"></i>About Us</a></li>

          <li><a href="{{ route('services') }}" class="hover:text-blue-200 no-underline flex items-center"><i class="bi bi-gear mr-2"></i>Services</a></li>
          <li><a href="{{ route('contact-us') }}" class="hover:text-blue-200 no-underline flex items-center"><i class="bi bi-envelope mr-2"></i>Contact Us</a></li>
        </ul>
      </div>

      <!-- Resources -->
      <div>
        <h4 class="text-lg font-bold mb-4">Resources</h4>
        <ul class="space-y-2">
          <li><a href="{{ route('help.terms') }}" class="hover:text-blue-200 no-underline flex items-center"><i class="bi bi-file-earmark-text mr-2"></i>Terms of Service</a></li>
          <li><a href="{{ route('privacy.policies') }}" class="hover:text-blue-200 no-underline flex items-center"><i class="bi bi-shield-lock mr-2"></i>Privacy Policy</a></li>
          <li><a href="{{ route('home.careers') }}" class="hover:text-blue-200 no-underline flex items-center"><i class="bi bi-briefcase mr-2"></i>Careers</a></li>
          <li><a href="{{ route('investor_relations') }}" class="hover:text-blue-200 no-underline flex items-center"><i class="bi bi-people mr-2"></i>Partners</a></li>
          <li><a href="{{ route('help.contacts') }}" class="hover:text-blue-200 no-underline flex items-center"><i class="bi bi-question-circle mr-2"></i>Help Center</a></li>
        </ul>
      </div>
    </div>

    <!-- Bottom Contact and Social Media -->
    <div class="flex flex-col md:flex-row justify-between items-center border-t border-blue-400 pt-6">
      
      <!-- Contact Info -->
      <div class="text-center md:text-left mb-4 md:mb-0">
        <p class="text-sm"><i class="bi bi-building mr-2"></i>Company Registration No: {{ env('COMPANY_REGISTRATION_NUMBER') }}</p>
        <p class="text-sm"><i class="bi bi-geo-alt mr-2"></i>{{ env('COMPANY_POSTAL_ADDRESS') }}</p>
        <p class="text-sm"><i class="bi bi-envelope-at mr-2"></i><a href="mailto:support@custospark.com" class="hover:text-blue-200 no-underline">support@custospark.com</a></p>
      </div>

      <!-- Social Media Icons -->
      <div class="flex space-x-5">
        <a href="mailto:support@custospark.com" class="hover:text-blue-200 text-xl"><i class="bi bi-envelope"></i></a>
        <a href="#" class="hover:text-blue-200 text-xl"><i class="bi bi-facebook"></i></a>
        <a href="#" class="hover:text-blue-200 text-xl"><i class="bi bi-twitter-x"></i></a>
        <a href="#" class="hover:text-blue-200 text-xl"><i class="bi bi-linkedin"></i></a>
        <a href="#" class="hover:text-blue-200 text-xl"><i class="bi bi-instagram"></i></a>
      </div>

    </div>
  </div>
</footer>
