<!-- Mobile Sidebar Overlay -->
<div id="mobile-overlay" class="fixed inset-0 bg-black opacity-50 hidden z-40"></div>

<!-- Mobile Sidebar -->
<aside id="mobile-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
  <!-- Sidebar Header -->
  <div class="flex items-center space-x-4 p-4 bg-white hover:shadow-lg transition-shadow duration-300 rounded-md">
    <div class="relative group">
      <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) }}" alt="Profile Photo" class="w-12 h-12 rounded-full border-2 border-gray-200 group-hover:scale-105 transform transition duration-300">
      <span class="absolute bottom-0 right-0 block w-3 h-3 rounded-full bg-green-500 border-2 border-white animate-ping"></span>
      <span class="absolute bottom-0 right-0 block w-3 h-3 rounded-full bg-green-500 border-2 border-white"></span>
    </div>
    <div class="flex flex-col">
      <h2 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">{{ Auth::user()->first_name }}</h2>
      <p class="text-sm text-green-500 font-medium animate-pulse">Online</p>
      <p id="mobile-current-time" class="text-xs text-blue-700 mt-1 fw-bolder text-underline"></p>
    </div>
    <!-- Close Button -->
    <button id="close-sidebar-btn" class="ml-auto text-gray-600 focus:outline-none">
      <i class="bi bi-x-circle text-2xl"></i>
    </button>
  </div>
  
  <hr class="text-blue-500">

  <!-- Navigation Menu -->
  <ul class="py-2 space-y-1">
    <!-- My Apps -->
 
    <li>
      <a href="{{ route('dashboard') }}" class="mobile-link block py-2 px-6 hover:bg-indigo-50 flex items-center {{ Route::is('dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
        <i class="bi bi-grid text-lg mr-3"></i>
        My Apps
      </a>
    </li>
    
    <!-- Management -->
    @php
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
      <button class="mobile-dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center {{ $isManagementActive ? 'active' : '' }}" 
              data-dropdown-target="mobile-management-dropdown"
              aria-expanded="{{ $isManagementActive ? 'true' : 'false' }}">
        <i class="bi bi-tools text-lg mr-3"></i>
        Management
        <i class="bi bi-chevron-down ml-auto text-gray-600 transition-transform duration-300 {{ $isManagementActive ? 'transform rotate-180' : '' }}"></i>
      </button>
      <ul id="mobile-management-dropdown" class="mobile-dropdown pl-8 {{ $isManagementActive ? '' : 'hidden' }}">
               @hasAppRole(['super-admin'],'custospark')

        <li>
          <a href="{{ route('apps.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('apps.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-grid text-lg mr-2"></i> Apps
          </a>
        </li>
        <li>
          <a href="{{ route('users.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('users.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-people text-lg mr-2"></i> Users
          </a>
        </li>
        <li>
          <a href="{{ route('roles.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('roles.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-shield-lock text-lg mr-2"></i> Roles & Permissions
          </a>
        </li>
        <li>
          <a href="{{ route('plans.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('plans.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-tags text-lg mr-2"></i> Plans & Features
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
          <a href="{{ route('feedback.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('feedback.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
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
          <a href="{{ route('notifications.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('notifications.*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-bell text-lg mr-2"></i> Notifications
          </a>
        </li>
        @hasAppRole(['super-admin'],'custospark')

          <li>
        <a href="{{ route('applications.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('applications.*') ? 'bg-indigo-200' : '' }}">
            <i class="bi bi-envelope-paper text-lg mr-2"></i> Applications
        </a>
    </li>
        <li>
          
          <a href="{{ route('jobs.index') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('jobs.index') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-briefcase text-lg mr-2"></i> Jobs
          </a>
        </li>
        <li>
          <a href="{{ route('jobs.listings') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('jobs.listings') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-card-list text-lg mr-2"></i> Job Listings
          </a>
        </li>
        @endhasAppRole
      
      </ul>
    </li>
    @endhasAppRole

    <!-- Reports & Analytics -->
    @php
      $isAnalyticsActive = Route::is('analytics.*');
    @endphp
  @hasAppRole(['super-admin'],'custospark')
    <li>
      <button class="mobile-dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center {{ $isAnalyticsActive ? 'active' : '' }}" 
              data-dropdown-target="mobile-analytics-dropdown"
              aria-expanded="{{ $isAnalyticsActive ? 'true' : 'false' }}">
        <i class="bi bi-bar-chart text-lg mr-3"></i>
        Reports & Analytics
        <i class="bi bi-chevron-down ml-auto text-gray-600 transition-transform duration-300 {{ $isAnalyticsActive ? 'transform rotate-180' : '' }}"></i>
      </button>
      <ul id="mobile-analytics-dropdown" class="mobile-dropdown pl-8 {{ $isAnalyticsActive ? '' : 'hidden' }}">
        <li>
          <a href="#" class="block py-2 hover:bg-indigo-100">
            <i class="bi bi-graph-up text-lg mr-2"></i> App Usage Stats
          </a>
        </li>
        <li>
          <a href="#" class="block py-2 hover:bg-indigo-100">
            <i class="bi bi-file-earmark-text text-lg mr-2"></i> Financial Reports
          </a>
        </li>
        <li>
          <a href="#" class="block py-2 hover:bg-indigo-100">
            <i class="bi bi-lightbulb text-lg mr-2"></i> Custom Insights
          </a>
        </li>
      </ul>
    </li>
        @endhasAppRole

    
    <!-- Referral Rewards & Earnings -->
    @php
      $isEarningsAndReferralsActive =
          Route::is('user.coupons.*') ||
          Route::is('user.referrals.*');
    @endphp
    <li>
      <button class="mobile-dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center {{ $isEarningsAndReferralsActive ? 'active' : '' }}"
              data-dropdown-target="mobile-earnings-dropdown"
              aria-expanded="{{ $isEarningsAndReferralsActive ? 'true' : 'false' }}">
        <i class="bi bi-gift text-lg mr-3"></i>
        Referral Rewards & Earnings
        <i class="bi bi-chevron-down ml-auto text-gray-600 transition-transform duration-300 {{ $isEarningsAndReferralsActive ? 'transform rotate-180' : '' }}"></i>
      </button>
      <ul id="mobile-earnings-dropdown" class="mobile-dropdown pl-8 {{ $isEarningsAndReferralsActive ? '' : 'hidden' }}">
        <li>
          <a href="{{ route('user.coupons.my') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('user.coupons.my') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-ticket-perforated text-lg mr-2"></i> My Coupons
          </a>
        </li>
        <li>
          <a href="{{ route('user.referrals.invite') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('user.referrals.invite') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-send-plus text-lg mr-2"></i> Invite & Share
          </a>
        </li>
        <li>
          <a href="{{ route('user.referrals.earnings') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('user.referrals.earnings') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-currency-exchange text-lg mr-2"></i> Referral Earnings
          </a>
        </li>
      </ul>
    </li>
    
    <!-- Payments & Subscriptions -->
    @php
      $isBillingAndSubscriptionActive =
          Route::is('user.billing-history') ||
          Route::is('user.subscriptions');
    @endphp
    <li>
      <button class="mobile-dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center {{ $isBillingAndSubscriptionActive ? 'active' : '' }}"
              data-dropdown-target="mobile-subscriptions-dropdown"
              aria-expanded="{{ $isBillingAndSubscriptionActive ? 'true' : 'false' }}">
        <i class="bi bi-wallet2 text-lg mr-3"></i>
        Payments & Subscriptions
        <i class="bi bi-chevron-down ml-auto text-gray-600 transition-transform duration-300 {{ $isBillingAndSubscriptionActive ? 'transform rotate-180' : '' }}"></i>
      </button>
      <ul id="mobile-subscriptions-dropdown" class="mobile-dropdown pl-8 {{ $isBillingAndSubscriptionActive ? '' : 'hidden' }}">
        <li>
          <a href="{{ route('user.subscriptions', $user) }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('user.subscriptions') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-card-checklist text-lg mr-2"></i> My Subscriptions
          </a>
        </li>
        <li>
          <a href="{{ route('user.billing-history', $user) }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('user.billing-history') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-receipt text-lg mr-2"></i> Billing History
          </a>
        </li>
      </ul>
    </li>
    
    <!-- Plans & Pricing -->
    @php
      $isPricingActive = Route::is('dashboard.pricing.*');
    @endphp
    <li>
      <button class="mobile-dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center {{ $isPricingActive ? 'active' : '' }}"
              data-dropdown-target="mobile-pricing-dropdown"
              aria-expanded="{{ $isPricingActive ? 'true' : 'false' }}">
        <i class="bi bi-tags-fill text-lg mr-3"></i>
        Plans & Pricing
        <i class="bi bi-chevron-down ml-auto text-gray-600 transition-transform duration-300 {{ $isPricingActive ? 'transform rotate-180' : '' }}"></i>
      </button>
      <ul id="mobile-pricing-dropdown" class="mobile-dropdown pl-8 {{ $isPricingActive ? '' : 'hidden' }}">
        @foreach($apps as $app)
          @if($app->slug === 'custospark')
            @continue
          @endif
          <li>
            <a href="{{ route('dashboard.pricing.app', ['app' => $app->id]) }}"
               class="block py-2 hover:bg-indigo-100 {{ $currentAppId == $app->id ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
              <img src="{{ $app->icon_url ?: $defaultIcon }}"
                   alt="{{ $app->name }} logo"
                   onerror="this.onerror=null;this.src='{{ $defaultIcon }}';"
                   class="w-5 h-5 mr-2 rounded-full object-cover inline-block" />
              {{ $app->name }}
            </a>
          </li>
        @endforeach
      </ul>
    </li>
    
    <!-- Jobs -->
        @php
    $isJobsActive =
        Route::is('jobs.index') ||
        Route::is('jobs.listings') ||
        Route::is('jobs.listings') ||
        Route::is('user.applications.all') ||
        Route::is('applications.*') ||
        Route::is('user.application.specific.show');
@endphp
    <li>
      <button class="mobile-dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center {{ $isJobsActive ? 'active' : '' }}"
              data-dropdown-target="mobile-jobs-dropdown"
              aria-expanded="{{ $isJobsActive ? 'true' : 'false' }}">
        <i class="bi bi-briefcase text-lg mr-3"></i>
        Jobs & Applications
        <i class="bi bi-chevron-down ml-auto text-gray-600 transition-transform duration-300 {{ $isJobsActive ? 'transform rotate-180' : '' }}"></i>
      </button>
      <ul id="mobile-jobs-dropdown" class="mobile-dropdown pl-8 {{ $isJobsActive ? '' : 'hidden' }}">
       <li>
            <a href="{{ route('jobs.listings') }}"
               class="block py-2 hover:bg-indigo-100 rounded-lg {{ Route::is('jobs.listings') ? 'bg-indigo-200' : '' }}">
                <i class="bi bi-card-list text-lg mr-2"></i> Job Listings
            </a>
        </li>
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
    
    <!-- Settings -->
    @php
      $isSettingsActive = Route::is('user.profile.show') || 
                        Route::is('user.settings.notifications') || 
                        Route::is('user.security.edit');
    @endphp
    <li>
      <button class="mobile-dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center {{ $isSettingsActive ? 'active' : '' }}"
              data-dropdown-target="mobile-settings-dropdown"
              aria-expanded="{{ $isSettingsActive ? 'true' : 'false' }}">
        <i class="bi bi-gear text-lg mr-3"></i>
        Settings
        <i class="bi bi-chevron-down ml-auto text-gray-600 transition-transform duration-300 {{ $isSettingsActive ? 'transform rotate-180' : '' }}"></i>
      </button>
      <ul id="mobile-settings-dropdown" class="mobile-dropdown pl-8 {{ $isSettingsActive ? '' : 'hidden' }}">
        <li>
          <a href="{{ route('user.profile.show') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('user.profile.show') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-person text-lg mr-2"></i> Profile Settings
          </a>
        </li>
        <li>
          <a href="{{ route('user.security.edit') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('user.security.edit') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-shield-lock text-lg mr-2"></i> Password & 2FA
          </a>
        </li>
        <li>
          <a href="{{ route('user.settings.notifications') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('user.settings.notifications*') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-bell text-lg mr-2"></i> Notifications
          </a>
        </li>
      </ul>
    </li>
    
    <!-- Help & Support -->
    @php
      $isHelpActive = Route::is('help.support') || 
                    Route::is('privacy.policies') || 
                    Route::is('help.contacts') || 
                    Route::is('help.terms');
    @endphp
    <li>
      <button class="mobile-dropdown-toggle w-full text-left py-2 px-6 hover:bg-indigo-50 flex items-center {{ $isHelpActive ? 'active' : '' }}"
              data-dropdown-target="mobile-help-dropdown"
              aria-expanded="{{ $isHelpActive ? 'true' : 'false' }}">
        <i class="bi bi-life-preserver text-lg mr-3"></i>
        Help & Support
        <i class="bi bi-chevron-down ml-auto text-gray-600 transition-transform duration-300 {{ $isHelpActive ? 'transform rotate-180' : '' }}"></i>
      </button>
      <ul id="mobile-help-dropdown" class="mobile-dropdown pl-8 {{ $isHelpActive ? '' : 'hidden' }}">
        <li>
          <a href="{{ route('help.contacts') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('help.contacts') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-chat-dots text-lg mr-2"></i> Contact Us
          </a>
        </li>
        <li>
          <a href="{{ route('privacy.policies') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('privacy.policies') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-shield-check text-lg mr-2"></i> Privacy Policy
          </a>
        </li>
        <li>
          <a href="{{ route('help.terms') }}" class="block py-2 hover:bg-indigo-100 {{ Route::is('help.terms') ? 'bg-indigo-200 text-indigo-700 font-semibold' : '' }}">
            <i class="bi bi-file-earmark-text text-lg mr-2"></i> Terms of Service
          </a>
        </li>
      </ul>
    </li>
  </ul>
  
  <!-- Feedback Button -->
  <div class="p-4">
    <form method="GET" action="{{ route('feedback.create') }}">
      <button type="submit" class="w-full text-left block bg-white text-blue-600 rounded-xl p-3 shadow-md hover:shadow-xl transition-all duration-300 text-sm space-x-3 border border-blue-200">
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
  </div>

</aside>



<!-- JavaScript for Mobile Time Clock -->
<script>
  function updateMobileTime() {
    const timeElement = document.getElementById('mobile-current-time');
    if (!timeElement) return;
    
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
</script>

<!-- JavaScript for Mobile Sidebar Functionality -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Mobile sidebar elements
    const menuBtn = document.getElementById('menu-btn');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const closeSidebarBtn = document.getElementById('close-sidebar-btn');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const mobileLinks = document.querySelectorAll('.mobile-link');
    const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');
    let timeInterval = null;

    // Function to open the mobile sidebar
    function openMobileSidebar() {
      mobileSidebar.style.transform = 'translateX(0)';
      mobileOverlay.classList.remove('hidden');
      document.body.classList.add('overflow-hidden'); // Prevent body scroll
      
      // Start the clock update
      updateMobileTime();
      if (timeInterval) clearInterval(timeInterval);
      timeInterval = setInterval(updateMobileTime, 1000);
    }

    // Function to close the mobile sidebar
    function closeMobileSidebar() {
      mobileSidebar.style.transform = 'translateX(-100%)';
      mobileOverlay.classList.add('hidden');
      document.body.classList.remove('overflow-hidden'); // Enable body scroll again
      
      // Stop the clock update
      if (timeInterval) {
        clearInterval(timeInterval);
        timeInterval = null;
      }
    }

    // Function to close all dropdowns
    function closeAllDropdowns(exceptId = null) {
      mobileDropdownToggles.forEach(toggle => {
        const targetId = toggle.getAttribute('data-dropdown-target');
        if (targetId !== exceptId) {
          const targetDropdown = document.getElementById(targetId);
          const toggleIcon = toggle.querySelector('.bi-chevron-down');
          
          if (!targetDropdown.classList.contains('hidden')) {
            targetDropdown.classList.add('hidden');
            toggle.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
            toggleIcon.classList.remove('transform', 'rotate-180');
          }
        }
      });
    }

    // Toggle dropdown functionality with single-dropdown-at-a-time logic
    mobileDropdownToggles.forEach((toggle) => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const targetID = this.getAttribute('data-dropdown-target');
        const targetDropdown = document.getElementById(targetID);
        const chevron = this.querySelector('.bi-chevron-down');
        
        // If this dropdown is already open, just close it
        if (!targetDropdown.classList.contains('hidden')) {
          targetDropdown.classList.add('hidden');
          this.classList.remove('active');
          this.setAttribute('aria-expanded', 'false');
          chevron.classList.remove('transform', 'rotate-180');
          return;
        }
        
        // Close all other dropdowns
        closeAllDropdowns(targetID);
        
        // Open this dropdown with animation
        targetDropdown.classList.remove('hidden');
        targetDropdown.classList.add('animate-slideDown');
        this.classList.add('active');
        this.setAttribute('aria-expanded', 'true');
        chevron.classList.add('transform', 'rotate-180');
      });
    });

    // Only close sidebar when clicking direct links (not dropdown toggles)
    mobileLinks.forEach((link) => {
      link.addEventListener('click', closeMobileSidebar);
    });

    // Event listeners for mobile sidebar
    if (menuBtn) {
      menuBtn.addEventListener('click', openMobileSidebar);
    }
    
    if (closeSidebarBtn) {
      closeSidebarBtn.addEventListener('click', closeMobileSidebar);
    }
    
    if (mobileOverlay) {
      mobileOverlay.addEventListener('click', closeMobileSidebar);
    }

    // Accessibility improvement for keyboard navigation
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && !mobileSidebar.classList.contains('-translate-x-full')) {
        closeMobileSidebar();
      }
    });

    // Clean up interval when page unloads
    window.addEventListener('beforeunload', () => {
      if (timeInterval) {
        clearInterval(timeInterval);
      }
    });

    // Handle device orientation change or window resize
    window.addEventListener('resize', () => {
      // If screen becomes larger than lg breakpoint, close mobile sidebar
      if (window.innerWidth >= 1024 && !mobileSidebar.classList.contains('-translate-x-full')) {
        closeMobileSidebar();
      }
    });
  });
</script>
{{-- <style>
  /* Animation for dropdown menus */
  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
      max-height: 0;
    }
    to {
      opacity: 1;
      transform: translateY(0);
      max-height: 1000px;
    }
  }

  .animate-slideDown {
    animation: slideDown 0.3s ease-out forwards;
  }

  /* Active state styling */
  .mobile-dropdown-toggle.active {
    background-color: #dbeafe; /* Tailwind blue-100 */
    font-weight: 600;
  }

  .mobile-dropdown .bg-indigo-200 {
    font-weight: 600;
  }

  /* Improved transitions */
  .mobile-dropdown {
    transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
  }

  .mobile-dropdown-toggle .bi-chevron-down {
    transition: transform 0.3s ease;
  }

  /* Focus states for accessibility */
  .mobile-dropdown-toggle:focus,
  .mobile-link:focus,
  .mobile-dropdown a:focus {
    outline: 2px solid #bfdbfe; /* Tailwind blue-200 */
    outline-offset: 2px;
    background-color: #dbeafe; /* Tailwind blue-100 */
  }

  /* Mobile sidebar styles */
  #mobile-sidebar {
    background-color: rgba(255, 255, 255, 0.96);
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
  }

  #mobile-sidebar .mobile-link {
    color: #1e293b; /* Tailwind slate-800 */
  }

  #mobile-sidebar .mobile-link:hover {
    background-color: #dbeafe; /* Tailwind blue-100 */
    color: #1d4ed8; /* Tailwind blue-700 */
  }

  #mobile-sidebar .mobile-link.active {
    background-color: #bfdbfe; /* Tailwind blue-200 */
    color: #1d4ed8; /* Tailwind blue-700 */
    font-weight: 600;
  }

  #mobile-sidebar .mobile-dropdown-toggle {
    color: #1e293b; /* Tailwind slate-800 */
  }

  #mobile-sidebar .mobile-dropdown-toggle:hover {
    background-color: #dbeafe; /* Tailwind blue-100 */
    color: #1d4ed8; /* Tailwind blue-700 */
  }

  #mobile-sidebar .mobile-dropdown-toggle.active {
    background-color: #bfdbfe; /* Tailwind blue-200 */
    color: #1d4ed8; /* Tailwind blue-700 */
    font-weight: 600;
  }

  #mobile-sidebar .mobile-dropdown {
    background-color: rgba(255, 255, 255, 0.96);
    border-left: 2px solid #1d4ed8; /* Tailwind blue-700 */
  }

  #mobile-sidebar .mobile-dropdown a {
    color: #1e293b; /* Tailwind slate-800 */
  }

  #mobile-sidebar .mobile-dropdown a:hover {
    background-color: #dbeafe; /* Tailwind blue-100 */
    color: #1d4ed8; /* Tailwind blue-700 */
  }

  #mobile-sidebar .mobile-dropdown a.active {
    background-color: #bfdbfe; /* Tailwind blue-200 */
    color: #1d4ed8; /* Tailwind blue-700 */
    font-weight: 600;
  }
</style> --}}



