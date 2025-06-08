
<aside id="desktop-sidebar" class="w-60 bg-white hidden lg:block sticky top-0 h-screen overflow-y-auto transition-all duration-300 ease-in-out z-40 border-r-4 border-gradient-to-b from-blue-500 to-indigo-500">
  <ul class="">
    <div class="flex items-center space-x-4 p-4 bg-white  hover:shadow-lg transition-shadow duration-300 rounded-md w-full max-w-xs mx-auto">
      <div class="relative group">
        <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) }}" alt="Profile Photo" class="w-12 h-12 rounded-full border-2 border-gray-200 group-hover:scale-105 transform transition duration-300">
        <span class="absolute bottom-0 right-0 block w-3 h-3 rounded-full bg-green-500 border-2 border-white animate-ping"></span>
        <span class="absolute bottom-0 right-0 block w-3 h-3 rounded-full bg-green-500 border-2 border-white"></span>
      </div>
      <div class="flex flex-col">
        <h2 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">{{ Auth::user()->first_name }}</h2>
        <p class="text-sm text-green-500 font-medium animate-pulse">Online</p>
        <p id="current-time" class="text-xs text-blue-700 mt-1 fw-bolder text-underline"></p>
      </div>
    </div>
    <hr class="text-blue-500">
    
    <!-- JavaScript for real-time clock -->
    <script>
  function updateTime() {
    const timeElement = document.getElementById('current-time');
    const now = new Date();

    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const months = [
      'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
      'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];

    const dayName = days[now.getDay()];
    const monthName = months[now.getMonth()];
    const dayNumber = now.getDate();
    const year = now.getFullYear();

    let hours = now.getHours();
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    
    hours = hours % 12;
    hours = hours ? hours : 12; // 0 should be 12

    const formattedTime = `${dayName}, ${monthName} ${dayNumber} ${year}- ${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${ampm}.`;

    timeElement.textContent = formattedTime;
  }

  updateTime(); // Initial
  setInterval(updateTime, 1000); // Update every second
</script>
    
<ul>
    <li>
        <a href="{{ route('dashboard') }}" class="desktop--link block py-2 px-6 hover:bg-indigo-50 flex items-center 
            {{ Route::is('dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-grid text-lg mr-3"></i>
            My Apps
        </a>
    </li>
  

      @php
        use Illuminate\Support\Str;

        $isManagementActive = Route::is('apps.*') ||
                              Route::is('users.*') ||
                              Route::is('notifications.*') ||
                              Route::is('roles.*') ||
                              Route::is('plans.*') ||
                              Route::is('jobs.*') ||
                              Route::is('blog.*') ||
                              Route::is('applications.*') ||
                              Route::is('consultations.*') ||
                              Route::is('dashboard.management.features*') ||
                              Route::is('dashboard.management.plans*') ||
                              Route::is('feedback.*');
    @endphp
    
    @hasAppRole(['super-admin','admin'],'custospark')
  
   <li>
  

    <button class="desktop--dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center rounded-lg" data-dropdown-target="desktop--management-dropdown">
        <i class="bi bi-tools text-lg mr-3"></i>
        Management
        <i class="bi bi-chevron-down ml-auto text-gray-600"></i>
    </button>

    <ul id="desktop--management-dropdown" class="desktop--dropdown pl-8 {{ $isManagementActive ? '' : 'hidden' }}">
       @hasAppRole(['super-admin'],'custospark')

        <li>
            <a href="{{ route('apps.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('apps.*') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-grid text-lg mr-2"></i> Apps
            </a>
        </li>
        <li>
            <a href="{{ route('users.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('users.*') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-people text-lg mr-2"></i> Users
            </a>
        </li>
        <li>
            <a href="{{ route('roles.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('roles.*') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-shield-lock text-lg mr-2"></i> Roles & Permissions
            </a>
        </li>

        <li>
            <a href="
            {{route('plans.index')}}" class="block py-2 hover:bg-indigo-100 {{ Route::is('plans.*') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-tags text-lg mr-2"></i> Plans & Features.
            </a>
        </li>
        <li>
        <a href="{{ route('applications.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('applications.*') ? 'bg-indigo-200' : '' }}">
            <i class="bi bi-envelope-paper text-lg mr-2"></i> Applications
        </a>
    </li>
          <li>
        <a href="{{ route('jobs.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('jobs.index') ? 'bg-indigo-200' : '' }}">
            <i class="bi bi-briefcase text-lg mr-2"></i> Jobs
        </a>
    </li>
    <li>
        <a href="{{ route('jobs.listings') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('jobs.listings') ? 'bg-indigo-200' : '' }}">
            <i class="bi bi-card-list text-lg mr-2"></i> Job Listings
        </a>
    </li>
          @endhasAppRole

        <li>
            <a href="
            {{route('blog.index')}}" class="block py-2 hover:bg-indigo-100 {{ Route::is('blog.*') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-journal-text text-lg mr-2"></i>Manage Posts
            </a>
        </li>
          <li>
          <a href="{{ route('feedback.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('feedback.*') ? 'bg-indigo-200' : '' }}">
              <i class="bi bi-chat-dots text-lg mr-2"></i> Feedback
          </a>
      </li>
      <li>
          <a href="{{ route('consultations.all') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('consultations.*') ? 'bg-indigo-200' : '' }}">
             <i class="bi bi-calendar-check text-lg mr-2"></i>
                Consultations
          </a>
      </li>
      <li>
         
      </li>
      {{-- {{-- @hasFeature('custosell','just added') --}}
      <li>
          <a href="{{route('notifications.index')}}" class="block py-2 hover:bg-indigo-100 {{ Route::is('notifications.*') ? 'bg-indigo-200' : '' }}">
              <i class="bi bi-bell text-lg mr-2"></i> Notifications
          </a>
      </li>
      {{-- @endhasFeature --}} 
        
  


    </ul>
</li>
@endhasAppRole

   <!-- Reports & Analytics -->
   @hasAppRole(['super-admin'],'custospark')
    <li>
        <button class="desktop--dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center rounded-lg" data-dropdown-target="desktop--analytics-dropdown">
            <i class="bi bi-bar-chart text-lg mr-3"></i>
            Reports & Analytics
            <i class="bi bi-chevron-down ml-auto text-gray-600"></i>
        </button>

        <ul id="desktop--analytics-dropdown" class="desktop--dropdown hidden pl-8">
            <li><a href="#" class="block py-2 hover:bg-indigo-100 rounded-lg"><i class="bi bi-graph-up text-lg mr-2"></i> App Usage Stats</a></li>
            <li><a href="#" class="block py-2 hover:bg-indigo-100 rounded-lg"><i class="bi bi-file-earmark-text text-lg mr-2"></i> Financial Reports</a></li>
            <li><a href="#" class="block py-2 hover:bg-indigo-100 rounded-lg"><i class="bi bi-lightbulb text-lg mr-2"></i> Custom Insights</a></li>
        </ul>
    </li>
    @endhasAppRole

  <li>
    @php
        $isEarningsAndReferralsActive =
            Route::is('user.coupons.*') ||
            Route::is('user.referrals.*');
          
    @endphp

    <button class="desktop--dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center rounded-lg"
            data-dropdown-target="desktop--earnings-dropdown"
            aria-expanded="{{ $isEarningsAndReferralsActive ? 'true' : 'false' }}"
            aria-controls="desktop--earnings-dropdown">
        <i class="bi bi-gift text-lg mr-3"></i>
        Referral Rewards & Earnings
        <i class="bi bi-chevron-down ml-auto text-gray-600"></i>
    </button>

    <ul id="desktop--earnings-dropdown"
        class="desktop--dropdown pl-8 {{ $isEarningsAndReferralsActive ? '' : 'hidden' }}"
        role="menu" aria-label="Earnings & Referrals submenu">

        {{-- 🧾 Coupon Code Section --}}
        <li>
            <a href="{{ route('user.coupons.my') }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg flex items-center {{ Route::is('user.coupons.my') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-ticket-perforated text-lg mr-2"></i> My Coupons
            </a>
        </li>
       

        {{-- 👥 Referral Section --}}
        <li>
            <a href="{{ route('user.referrals.invite') }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg flex items-center {{ Route::is('user.referrals.invite') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-send-plus text-lg mr-2"></i> Invite & Share
            </a>
        </li>
     
        <li>
            <a href="{{ route('user.referrals.earnings') }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg flex items-center {{ Route::is('user.referrals.earnings') ? 'bg-indigo-200' : '' }}">
                <i class="bi  bi-currency-exchange text-lg mr-2"></i> Referral Earnings
            </a>
        </li>
    </ul>
</li>

    <!-- Payments & Subscriptions -->
   <li>
    @php
        $isBillingAndSubscriptionActive =
            Route::is('user.billing-history') ||
            Route::is('user.subscriptions') ||
            Route::is('applications.*');
    @endphp

    <button class="desktop--dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center rounded-lg"
            data-dropdown-target="desktop--payments-and-subscriptions-dropdown"
            aria-expanded="{{ $isBillingAndSubscriptionActive ? 'true' : 'false' }}"
            aria-controls="desktop--subscriptions-dropdown">
        <i class="bi bi-wallet2 text-lg mr-3"></i>
        Payments & Subscriptions
        <i class="bi bi-chevron-down ml-auto text-gray-600"></i>
    </button>

    <ul id="desktop--payments-and-subscriptions-dropdown"
        class="desktop--dropdown pl-8 {{ $isBillingAndSubscriptionActive ? '' : 'hidden' }}"
        role="menu" aria-label="Payments & Subscriptions submenu">

        <li role="none">
            <a href="{{ route('user.subscriptions', $user) }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg flex items-center {{ Route::is('user.subscriptions') ? 'bg-indigo-200' : '' }}"
               role="menuitem">
                <i class="bi bi-card-checklist text-lg mr-2"></i> My Subscriptions
            </a>
        </li>

        <li role="none">
            <a href="{{ route('user.billing-history', $user) }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg flex items-center {{ Route::is('user.billing-history') ? 'bg-indigo-200' : '' }}"
               role="menuitem">
                <i class="bi bi-receipt text-lg mr-2"></i> Billing History
            </a>
        </li>

    </ul>
</li>

<li>
    <button class="desktop--dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center rounded-lg"
            data-dropdown-target="desktop--pricing-dropdown" aria-expanded="{{ $isPricingActive ? 'true' : 'false' }}" aria-controls="desktop--pricing-dropdown">
        <i class="bi bi-tags-fill text-lg mr-3"></i>
        Plans & Pricing
        <i class="bi bi-chevron-down ml-auto text-gray-600"></i>
    </button>

    <ul id="desktop--pricing-dropdown" class="desktop--dropdown pl-8 {{ $isPricingActive ? '' : 'hidden' }}" role="menu" aria-label="Plans & Pricing submenu">
        @foreach($apps as $app)
            @if($app->slug === 'custospark')
                @continue
            @endif
            <li role="none">
                <a href="{{ route('dashboard.pricing.app', ['app' => $app->id]) }}"
                   class="block py-2 hover:bg-indigo-100 {{ $currentAppId == $app->id ? 'bg-indigo-200' : '' }} flex items-center rounded-md"
                   role="menuitem">
                    <img src="{{ $app->icon_url ?: $defaultIcon }}"
                         alt="{{ $app->name }} logo"
                         onerror="this.onerror=null;this.src='{{ $defaultIcon }}';"
                         class="w-5 h-5 mr-2 rounded-full object-cover" />
                    {{ $app->name }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
    @php
    $isJobsActive =
        Route::is('jobs.index') ||
        Route::is('jobs.listings') ||
        Route::is('jobs.listings') ||
        Route::is('user.applications.all') ||
        Route::is('applications.*') ||
        Route::is('user.application.specific.show');
@endphp

<!-- Jobs -->
<li>
    <button class="desktop--dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center rounded-lg" data-dropdown-target="desktop--jobs-dropdown">
        <i class="bi bi-briefcase text-lg mr-3"></i>
        Jobs & Appications
        <i class="bi bi-chevron-down ml-auto text-gray-600"></i>
    </button>

    <ul id="desktop--jobs-dropdown" class="desktop--dropdown pl-8 {{ $isJobsActive ? '' : 'hidden' }}">
     
        <li>
            <a href="{{ route('jobs.listings') }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('jobs.listings') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-card-list text-lg mr-2"></i> Job Listings
            </a>
        </li>
        <li>
            <a href="{{route('user.applications.all')}}"
               class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('user.applications.all','user.application.specific.show','applications.*') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-envelope-paper text-lg mr-2"></i>My Applications
            </a>
        </li>
    </ul>
</li>

@hasAppRole(['normal-user'],'custospark')
  <li>
        <a href="{{ route('blog.guest.user') }}" class="desktop--link block py-2 px-6 hover:bg-indigo-50 flex items-center 
            {{ Route::is(['blog.guest.user', 'blog.show']) ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-megaphone-fill text-lg mr-3"></i>
            
Latest Updates
        </a>
    </li>
@endhasAppRole


      @php

        $isSettingsActive =   Route::is('user.profile.show') ||
                              Route::is('user.settings.notifications') ||
                              Route::is('user.security.edit');
    @endphp

    <!-- Settings -->
    <li>
        <button class="desktop--dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center rounded-lg" data-dropdown-target="desktop--settings-dropdown">
            <i class="bi bi-gear text-lg mr-3"></i>
            Settings
            <i class="bi bi-chevron-down ml-auto text-gray-600"></i>
        </button>

        <ul id="desktop--settings-dropdown" class="desktop--dropdown pl-8 {{ $isSettingsActive ? '' : 'hidden' }}">
            {{-- <li><a href="#" class="block py-2 hover:bg-indigo-100 rounded-lg"><i class="bi bi-sliders text-lg mr-2"></i> General Settings</a></li> --}}
            <li><a href="{{route('user.profile.show')}}" class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('user.profile.show') ? 'bg-indigo-200' : '' }}"><i class="bi bi-person text-lg mr-2"></i> Profile Settings</a></li>
            <li><a href="{{route('user.security.edit')}}" class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('user.security.edit') ? 'bg-indigo-200' : '' }}"><i class="bi bi-shield-lock text-lg mr-2"></i> Password & 2FA</a></li>
            <li><a href="{{route('user.settings.notifications')}}" class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('user.settings.notifications*') ? 'bg-indigo-200' : '' }}"><i class="bi bi-bell text-lg mr-2"></i> Notifications</a></li>
        </ul>
    </li>
    @php
    $isHelpActive =
        Route::is('help.support') ||
        Route::is('privacy.policies') ||
        Route::is('help.contacts') ||
        Route::is('help.terms');
@endphp

<!-- Help & Support -->
<li>
    <button class="desktop--dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center rounded-lg" data-dropdown-target="desktop--help-dropdown">
        <i class="bi bi-life-preserver text-lg mr-3"></i>
        Help & Support
        <i class="bi bi-chevron-down ml-auto text-gray-600"></i>
    </button>

    <ul id="desktop--help-dropdown" class="desktop--dropdown pl-8 {{ $isHelpActive ? '' : 'hidden' }}">
     
      <li>
        <a href="{{ route('help.contacts') }}"
          class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('help.contacts') ? 'bg-indigo-200' : '' }}">
            <i class="bi bi-chat-dots text-lg mr-2"></i> Contact Us
        </a>
    </li>

        <li>
            <a href="{{ route('privacy.policies') }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('privacy.policies') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-shield-check text-lg mr-2"></i> Privacy Policy
            </a>
        </li>
        <li>
            <a href="{{ route('help.terms') }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('help.terms') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-file-earmark-text text-lg mr-2"></i> Terms of Service
            </a>
        </li>
    </ul>
</li>

</ul>

  
  </ul>
<form method="GET" action="{{ route('feedback.create') }}">
{{-- <input type="hidden" name="source" value="{{ request()->fullUrl() }}"> --}}

    <button type="submit"
        class="w-full text-left block bg-white text-blue-600 rounded-xl p-3 shadow-md hover:shadow-2xl transition-all duration-300 text-sm space-x-3 border border-blue-200">
        <div class="flex items-center justify-between space-x-3">
            <div class="flex items-center space-x-3">
                <i class="bi bi-pencil-square text-xl"></i>
                <div class="leading-tight">
                    <h2 class="font-semibold text-base">Feedback</h2>
                    <p class="text-black text-[11px]">Help us improve</p>
                </div>
            </div>
            <span class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-xs px-3 py-1 rounded-full transition-all duration-300 whitespace-nowrap">
                Share
            </span>
        </div>
    </button>
</form>
<!-- Satisfaction Modal -->
<div id="satisfaction-modal" class="fixed inset-0 bg-transparent flex items-end justify-end hidden z-50 p-6">
  <div id="rate-satisfaction" class="relative bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition-all duration-500 transform translate-y-20 opacity-0 w-80 cursor-pointer">
      
      <!-- Close Button -->
      <button id="close-modal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>

      <!-- Title -->
      <h3 class="text-lg text-blue-600 font-semibold mb-4">How's your satisfaction today?</h3>

      <!-- Rating Buttons -->
      <div class="flex justify-center space-x-2 mb-4">
          <button data-rating="1" class="bg-red-500 text-white rounded-full px-3 py-1 text-sm hover:bg-red-600">Poor</button>
          <button data-rating="2" class="bg-yellow-500 text-white rounded-full px-3 py-1 text-sm hover:bg-yellow-600">Fair</button>
          <button data-rating="3" class="bg-green-500 text-white rounded-full px-3 py-1 text-sm hover:bg-green-600">Good</button>
          <button data-rating="4" class="bg-blue-500 text-white rounded-full px-3 py-1 text-sm hover:bg-blue-600">Excellent</button>
      </div>

      <!-- Thank You Message -->
      <p id="thank-you-message" class="text-green-600 font-semibold hidden">Thank you for your feedback!</p>

  </div>
</div>

<!-- Script to control modal -->
<script>
  const modal = document.getElementById('satisfaction-modal');
  const rateBox = document.getElementById('rate-satisfaction');
  const buttons = document.querySelectorAll('#rate-satisfaction button');
  const closeModalBtn = document.getElementById('close-modal');
  const thankYouMessage = document.getElementById('thank-you-message');

  // Wait for 10 seconds, then show the modal
  setTimeout(() => {
    modal.classList.remove('hidden');
    // Trigger slide up effect
    setTimeout(() => {
      rateBox.classList.remove('translate-y-20', 'opacity-0');
      rateBox.classList.add('translate-y-0', 'opacity-100');
    }, 50); // small delay to trigger transition properly
  }, 1000000);

  // Handle rating button click
  buttons.forEach(button => {
    button.addEventListener('click', function() {
      buttons.forEach(btn => btn.classList.add('hidden')); // Hide all rating buttons
      thankYouMessage.classList.remove('hidden'); // Show thank you
      setTimeout(() => {
        modal.classList.add('hidden'); // Close modal after 3s
        rateBox.classList.add('translate-y-20', 'opacity-0'); // Reset for next time
        rateBox.classList.remove('translate-y-0', 'opacity-100');
        buttons.forEach(btn => btn.classList.remove('hidden')); // Reset buttons
        thankYouMessage.classList.add('hidden'); // Hide thank you
      }, 3000);
    });
  });

  // Close modal when clicking the "X"
  closeModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
    rateBox.classList.add('translate-y-20', 'opacity-0');
    rateBox.classList.remove('translate-y-0', 'opacity-100');
  });

  // Close modal when clicking outside the white box
  modal.addEventListener('click', (e) => {
    if (!rateBox.contains(e.target)) {
      modal.classList.add('hidden');
      rateBox.classList.add('translate-y-20', 'opacity-0');
      rateBox.classList.remove('translate-y-0', 'opacity-100');
    }
  });
</script>




<!-- Thank You Note -->
<div id="thank-you-note" class="hidden fixed inset-x-0 bottom-4 z-50 flex items-center justify-center">
    <div class="bg-blue-500 text-white rounded-md shadow-lg p-3 w-64 text-center">
        <p class="text-sm font-bold">Thank you for your feedback!</p>
    </div>
</div>

  
</aside>
<style>
  /* Thank You Note Slide Up Animation */
  @keyframes slide-up {
      from {
          opacity: 0;
          transform: translateY(20px);
      }
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }

  #thank-you-note {
      animation: slide-up 0.5s ease-out forwards;
  }
</style>



<script>
  // Get Elements
  const feedbackToggle = document.getElementById('feedback-toggle');
  const feedbackModal = document.getElementById('feedback-modal');
  const closeFeedback = document.getElementById('close-feedback');
  const feedbackForm = document.getElementById('feedback-form');
  const thankYouNote = document.getElementById('thank-you-note');

  // Show Feedback Modal
  feedbackToggle.addEventListener('click', () => {
    feedbackModal.classList.remove('hidden');
  });

  // Close Feedback Modal
  closeFeedback.addEventListener('click', () => {
    feedbackModal.classList.add('hidden');
  });

  // Handle Feedback Form Submission
  feedbackForm.addEventListener('submit', (e) => {
    e.preventDefault(); // Prevent actual form submission for demo purposes
    feedbackModal.classList.add('hidden'); // Hide modal
    thankYouNote.classList.remove('hidden'); // Show thank-you note

    // Auto-hide Thank You Note after 3 seconds
    setTimeout(() => {
      thankYouNote.classList.add('hidden');
    }, 3000);
  });

  // Close Modal when clicking outside of it
  feedbackModal.addEventListener('click', (e) => {
    if (e.target === feedbackModal) {
      feedbackModal.classList.add('hidden');
    }
  });
</script>


<!-- Optional: Tailwind Animation (if you want smoother open) -->
<style>
  /* Slide Down Animation */
  @keyframes slide-down {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Fade In/Out */
  @keyframes fade-in {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }

  /* Modal Appearance */
  #feedback-modal {
    animation: fade-in 0.3s ease-out forwards;
  }

  #thank-you-note {
    animation: slide-down 0.5s ease-out forwards;
  }
</style>

<!-- JavaScript for Dropdown Functionality -->
<script>
  // Top-Level Dropdown Toggles
  const desktopDropdownToggles = document.querySelectorAll('.desktop--dropdown-toggle');
  desktopDropdownToggles.forEach((toggle) => {
    toggle.addEventListener('click', function () {
      const targetID = this.getAttribute('data-dropdown-target');
      const targetDropdown = document.getElementById(targetID);
      document.querySelectorAll('.desktop--dropdown').forEach((dropdown) => {
        if (dropdown.id !== targetID) {
          dropdown.classList.add('hidden');
        }
      });
      targetDropdown.classList.toggle('hidden');
    });
  });

  // Nested Dropdown Toggles (e.g., Subtasks inside Reports)
  const desktopNestedDropdownToggles = document.querySelectorAll('.desktop--nested-dropdown-toggle');
  desktopNestedDropdownToggles.forEach((toggle) => {
    toggle.addEventListener('click', function () {
      const targetID = this.getAttribute('data-dropdown-target');
      const targetDropdown = document.getElementById(targetID);
      document.querySelectorAll('.desktop--nested-dropdown').forEach((dropdown) => {
        if (dropdown.id !== targetID) {
          dropdown.classList.add('hidden');
        }
      });
      targetDropdown.classList.toggle('hidden');
    });
  });
</script>
