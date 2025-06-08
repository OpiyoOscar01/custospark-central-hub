<footer class="bg-gradient-to-r from-blue-500 to-blue-500 text-white py-8 text-sm">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Company Info with Logo -->
    <div class="flex flex-col items-start">
      <img src="{{ asset('images/v8.png') }}" alt="Custospark Logo" class="w-20 h-20 rounded-full mb-4">
      <div>
        <h2 class="text-lg font-semibold mb-1">Custospark Company Ltd</h2>
        <p class="text-sm italic text-white mb-2">PowerHouse of Innovations.</p>
        <p><i class="bi bi-building text-white mr-2"></i>Company Registration Number {{ env('COMPANY_REGISTRATION_NUMBER') }}</p>
        <p><i class="bi bi-geo-alt text-white mr-2"></i>{{ env('COMPANY_POSTAL_ADDRESS') }}</p>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="md:text-center">
      <h2 class="text-lg font-semibold mb-2">Quick Links</h2>
      <ul class="space-y-1">
        <li><i class="bi bi-shield-lock mr-2"></i><a href="{{ route('privacy.policies') }}" class="hover:underline">Privacy Policy</a></li>
        <li><i class="bi bi-file-earmark-text mr-2"></i><a href="{{ route('help.terms') }}" class="hover:underline">Terms of Service</a></li>
        <li><i class="bi bi-chat-dots mr-2"></i><a href="{{ route('help.contacts') }}" class="hover:underline">Contact Us</a></li>
      </ul>
    </div>

    <!-- Contact Info -->
    <div class="md:text-right">
      <h2 class="text-lg font-semibold mb-2">Contact</h2>
      <p><i class="bi bi-envelope-open mr-2"></i>Email: 
        <a href="mailto:{{ env('COMPANY_SUPPORT_EMAIL') }}" class="hover:underline">
          {{ env('COMPANY_SUPPORT_EMAIL') }}
        </a>
      </p>
      <p><i class="bi bi-telephone mr-2"></i>Phone: 
        <a href="tel:+256756697871" class="hover:underline">
          {{ env('COMPANY_SUPPORT_PHONE') }}
        </a>
      </p>
      <p class="mt-2"><i class="bi bi-c-circle mr-2"></i>{{ date('Y') }} Custospark Company Ltd. All rights reserved.</p>
    </div>

  </div>
</footer>
