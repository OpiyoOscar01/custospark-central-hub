<section id="application-process" class="relative py-28 bg-black text-white overflow-hidden">
  <!-- Background Glow -->
  <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(circle_at_10%_10%,_rgba(255,255,255,0.2),_transparent_40%),_radial-gradient(circle_at_90%_90%,_rgba(255,255,255,0.15),_transparent_40%)] blur-3xl z-0"></div>

  <div class="relative z-10 max-w-6xl mx-auto px-6">
    <!-- Header -->
    <div class="text-center mb-20">
      <h2 class="text-5xl font-extrabold drop-shadow-2xl">Your Path to Joining Custospark</h2>
      <p class="text-xl mt-6 max-w-3xl mx-auto text-white/80 leading-relaxed">
        We’ve designed our application process to be transparent, efficient, and welcoming. Here’s how you can take the first step toward becoming part of our innovative team.
      </p>
    </div>

    <!-- Timeline Line -->
    <div class="relative">
      <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-yellow-400 via-pink-500 to-blue-600 rounded-full shadow-lg z-0"></div>

      @php
        $steps = [
      ['step' => 1, 'title' => 'Submit Your Application', 'desc' => 'Click the Apply button and follow the next steps. You’ll be required to create an account to track your application status and updates. Upload your resume or portfolio to complete the process.'],

          ['step' => 2, 'title' => 'Initial Review', 'desc' => 'Our hiring team evaluates your application to ensure it aligns with the role and company values.'],
          ['step' => 3, 'title' => 'Introductory Call', 'desc' => 'Have an informal chat with a team member to learn about each other.'],
          ['step' => 4, 'title' => 'Skill Assessment', 'desc' => 'For certain roles, you’ll complete a technical task or challenge that reflects the job requirements.'],
          ['step' => 5, 'title' => 'Final Interview', 'desc' => 'Meet the team you’ll collaborate with and dive deeper into your fit for the role.'],
          ['step' => 6, 'title' => 'Offer & Onboarding', 'desc' => 'If it’s a match, we’ll send you an offer and kickstart your journey at Custospark!'],
        ];
      @endphp

      <div class="space-y-24">
        @foreach ($steps as $index => $step)
          @php
            $isLeft = $index % 2 === 0;
          @endphp
          <div class="flex flex-col md:flex-row items-center md:items-start relative group">
            <!-- Spacer for Left or Right Positioning -->
            <div class="w-full md:w-1/2 {{ $isLeft ? 'order-2 md:pl-12' : 'md:pr-12' }}">

              <!-- Step Card -->
              <div class="bg-white/10 border border-white/20 backdrop-blur-md rounded-2xl p-6 shadow-2xl transform transition-all duration-500 hover:scale-[1.02]"
                   style="perspective: 1000px;">
                <div class="flex items-start space-x-4">
                  <div class="w-12 h-12 flex-shrink-0 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 text-white rounded-full flex items-center justify-center font-bold text-xl shadow-md">
                    {{ $step['step'] }}
                  </div>
                  <div>
                    <h3 class="text-2xl font-bold text-white">{{ $step['title'] }}</h3>
                    <p class="text-white/80 mt-2 text-base leading-relaxed">{{ $step['desc'] }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Connector Dot -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-8 h-8 bg-white/30 backdrop-blur-xl border border-white/20 rounded-full z-10 shadow-lg"></div>

            <!-- Filler for alignment -->
            <div class="hidden md:block w-1/2 {{ $isLeft ? 'order-1' : 'order-3' }}"></div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- CTA -->
    <div class="mt-24 text-center">
      <a href="#perks-benefits"
         class="inline-block bg-white text-blue-800 px-8 py-4 rounded-xl text-lg font-semibold hover:bg-white hover:text-blue-500 transition-transform transform hover:scale-105 shadow-lg">
        Explore the benefits of working with us.
      </a>
    </div>
  </div>
</section>
