<section id="application-confirmation" class="py-16 lg:py-20 bg-gradient-to-r from-blue-500 to-black text-white">
  <div class="container-fluid mx-auto px-4 sm:px-6 lg:px-8 text-center">

    <!-- Confirmation Icon & Header -->
    <div class="mb-10">
      <i class="bi bi-lock-fill text-yellow-400 text-6xl sm:text-7xl lg:text-8xl mb-4 animate__animated animate__fadeIn"></i>
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold animate__animated animate__fadeIn animate__delay-1s">
        To Apply for This Role
      </h2>
      <p class="text-base sm:text-lg lg:text-xl mt-4 max-w-2xl mx-auto leading-relaxed animate__animated animate__fadeIn animate__delay-2s">
        Please <strong>sign up</strong> or <strong>log in</strong> to Custospark to proceed with your application.
      </p>
    </div>

    <!-- CTA Card -->
    <div class="bg-white text-gray-900 p-6 sm:p-8 lg:p-10 rounded-2xl shadow-xl mx-auto max-w-lg animate__animated animate__fadeIn animate__delay-3s">
      <h3 class="text-2xl sm:text-3xl font-semibold mb-4">Why Sign In?</h3>
      <ul class="text-left space-y-3 text-base sm:text-lg">
        <li class="flex items-start">
          <i class="bi bi-person-check-fill text-blue-600 text-xl mr-3"></i>
          Track your application status and receive timely updates.
        </li>
        <li class="flex items-start">
          <i class="bi bi-envelope-open-fill text-orange-500 text-xl mr-3"></i>
          Get notified about interviews and feedback.
        </li>
        <li class="flex items-start">
          <i class="bi bi-briefcase-fill text-green-500 text-xl mr-3"></i>
          Explore more opportunities tailored for you.
        </li>
      </ul>

      <!-- Action Button -->
      <div class="mt-6">
        <a href="{{ route('login') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out text-lg">
          Continue to Apply
        </a>
      </div>
    </div>

    <!-- Footer Note -->
    <div class="mt-10 text-sm sm:text-base text-white animate__animated animate__fadeIn animate__delay-4s">
      Don’t have an account? <a href="{{ route('register') }}" class="underline font-semibold text-yellow-300 hover:text-yellow-400">Sign up here</a>.
    </div>

  </div>
</section>
