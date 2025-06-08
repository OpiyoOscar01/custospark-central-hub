<header class="bg-gradient-to-b from-blue-500 to-blue-500 text-white py-3 px-2 sm:py-4 sm:px-4 flex flex-wrap items-center sticky top-0 z-50 shadow-md border-b-2">
  <!-- Left: Brand -->
  <div class="flex items-center space-x-2 sm:space-x-3 mr-auto">
    <img src="{{ asset('images/v8.png') }}" alt="Brand Logo" class="w-8 h-8 sm:w-10 sm:h-10 object-contain rounded-full" />
    <h1 class="text-lg sm:text-xl font-semibold">Custospark</h1>
  </div>

  <!-- Center: Mobile Menu Button (Only visible on small screens) -->
  <button 
    id="menu-btn" 
    class="lg:hidden mx-2 text-white hover:text-blue-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 rounded-md"
    aria-label="Open navigation menu"
  >
    <i class="bi bi-list text-2xl"></i>
  </button>

  <!-- Subscription Cards - Hidden on mobile, visible on large screens -->
  <div class="hidden lg:flex items-center space-x-4 mx-auto">
    <!-- Subscription Card -->
    <div class="bg-white text-blue-500 rounded-md p-2 shadow-lg flex items-center justify-between hover:shadow-xl transition ease-in-out duration-300 text-xs space-x-2">
      <div class="flex items-center space-x-2">
        <i class="bi bi-card-checklist text-lg"></i>
        <div>
          <h2 class="font-semibold">Total Subscriptions</h2>
          <p class="text-gray-900">{{ $subscriptionCount }} {{ Str::plural('Subscription', $subscriptionCount) }}</p>
        </div>
      </div>
      <a href="{{route('user.subscriptions',$user)}}" class="bg-blue-500 text-white px-2 py-1 rounded-full hover:bg-blue-600 transition duration-300 whitespace-nowrap">
        View
      </a>
    </div>
    
    <!-- Invite Friends Card -->
    <div class="bg-white text-blue-500 rounded-md p-2 shadow-lg flex items-center justify-between hover:shadow-xl transition ease-in-out duration-300 text-xs space-x-2">
      <div class="flex items-center space-x-2">
        <i class="bi bi-person-plus text-lg"></i>
        <div>
          <h2 class="font-semibold">Invite Friends</h2>
          <p class="text-gray-900">and Earn Rewards</p>
        </div>
      </div>
      <a href="{{ route('user.referrals.invite') }}" class="bg-green-500 text-white px-2 py-1 rounded-full hover:bg-green-600 transition duration-300 whitespace-nowrap">
        Invite
      </a>
    </div>
  </div>

  <!-- Right: Action Items -->
  <div class="flex items-center space-x-1 sm:space-x-2 ml-auto lg:ml-0">
    <!-- Notifications -->
    <div class="relative">
      <button 
        id="notifications-btn"
        aria-label="Notifications"
        class="relative p-1 sm:p-2 flex items-center justify-center hover:bg-blue-600 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50"
      >
        <i class="bi bi-bell-fill text-white text-lg sm:text-xl"></i>
        @if ($unreadCount > 0)
          <span
            class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center"
          >
            {{ $unreadCount }}
          </span>
        @endif
      </button>

      <!-- Notifications Dropdown - Centered for all screen sizes -->
      <div 
        id="notifications-dropdown"
        class="fixed left-1/2 transform -translate-x-1/2 mt-2 w-[90vw] max-w-sm sm:max-w-md bg-white border border-gray-200 rounded-lg shadow-xl hidden z-50 overflow-hidden"
        style="top: 4rem;"
        aria-hidden="true"
      >
        <!-- Header -->
        <div class="px-4 py-3 bg-gray-100 border-b text-sm text-blue-600 font-semibold flex justify-between items-center">
          <span>My Notifications</span>
          @if ($notifications && $notifications->count())
            <form method="POST" action="{{ route('notifications.read_all') }}" class="inline">
              @csrf
              <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 hover:underline focus:outline-none">
                Mark all as read
              </button>
            </form>
          @endif
        </div>

        <!-- List -->
        <ul class="p-3 text-sm max-h-[60vh] overflow-y-auto space-y-2">
          @forelse ($notifications as $notif)
            <li 
              x-data="{ open: false }" 
              class="bg-gray-50 rounded-md border border-gray-200 px-3 py-2 shadow-sm hover:shadow-md transition-shadow duration-200"
            >
              <!-- Title -->
              <div class="text-center font-medium text-gray-800 text-base leading-tight break-words">
                {{ $notif->title }}
              </div>

              <!-- Timestamp -->
              <div class="text-center text-xs text-gray-400 my-1">
                {{ $notif->created_at->diffForHumans() }}
              </div>

              <!-- Toggle -->
              <div class="flex justify-center mb-1">
                <button 
                  @click="open = !open"
                  class="text-xs text-blue-500 hover:text-blue-700 hover:underline focus:outline-none"
                >
                  <span x-text="open ? 'Hide details' : 'Show details'"></span>
                </button>
              </div>

              <!-- Details -->
              <div 
                x-show="open" 
                x-cloak 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="text-gray-700 text-sm border-t border-gray-100 pt-2 break-words"
              >
                {{ $notif->message }}
              </div>

              <!-- Actions -->
              <div class="mt-2 flex justify-between items-center text-xs text-gray-600">
                @unless($notif->isReadBy(auth()->user()))
                  <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="inline">
                    @csrf
                    <input type="hidden" name="notification_id" value="{{ $notif->id }}">
                    <button type="submit" class="text-blue-600 hover:text-blue-800 hover:underline focus:outline-none">
                      Mark as read
                    </button>
                  </form>
                @else
                  <span class="text-green-600 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Read
                  </span>
                @endunless
              </div>
            </li>
          @empty
            <li class="text-gray-500 text-center py-8">
              <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
              </svg>
              <p>No notifications yet</p>
            </li>
          @endforelse
        </ul>
      </div>
    </div>

    <!-- App Launcher -->
    <div class="relative">
      <button 
        id="app-launcher-btn" 
        title="Custospark Apps"
        aria-label="Open apps menu"
        class="flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 bg-white border border-gray-200 hover:bg-gray-100 hover:shadow-md transition-all duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
        aria-haspopup="true" 
        aria-expanded="false"
      >
        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M2 2h4v4H2V2zm6 0h4v4H8V2zm6 0h4v4h-4V2zM2 8h4v4H2V8zm6 0h4v4H8V8zm6 0h4v4h-4V8zM2 14h4v4H2v-4zm6 0h4v4H8v-4zm6 0h4v4h-4v-4z" />
        </svg>
      </button>
    
      <!-- App Launcher Dropdown - Centered for all screen sizes -->
      <div 
        id="app-launcher-dropdown"
        class="fixed left-1/2 transform -translate-x-1/2 mt-3 w-[90vw] sm:w-[420px] max-w-lg rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 hidden z-50"
        style="top: 4rem;"
        aria-hidden="true"
      >
        <!-- App Search -->
        <div class="p-3 sm:p-4 border-b border-gray-200">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
            <input 
              type="text" 
              id="app-search"
              class="w-full pl-10 pr-4 py-2 rounded-lg text-gray-700 bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Search apps..." 
            />
          </div>
        </div>
    
        <!-- Header Text -->
        <div class="p-3 sm:p-4 text-center">
          <p class="text-blue-600 font-semibold">All your apps in one place</p>
          <p class="text-gray-500 text-xs mt-1">Click on an app to start using it.</p>
        </div>
    
        <!-- App Grid -->
        <div class="max-h-[50vh] overflow-y-auto">
          @include('custospark::appluncher')
        </div>
    
        <!-- Help Section -->
        <div class="p-3 sm:p-4 border-t border-gray-200 bg-gray-50 rounded-b-xl">
          <button 
            id="help-btn"
            class="w-full text-left text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center"
          >
            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Need help? <span class="font-semibold ml-1">Contact support</span>
          </button>
        </div>
      </div>
    </div>
   
    <!-- User Profile -->
    <div class="relative">
      <button 
        id="profile-btn" 
        aria-label="User profile menu"
        class="flex items-center space-x-1 text-white hover:text-blue-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 rounded-full"
      >
        <img 
          src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) }}" 
          alt="Profile Photo" 
          class="w-8 h-8 sm:w-9 sm:h-9 rounded-full border-2 border-white object-cover" 
        />
        <i class="bi bi-chevron-down"></i>
      </button>      
    
      <!-- Profile Dropdown - Centered for mobile -->
      <div 
        id="profile-dropdown"
        class="fixed sm:absolute sm:right-0 left-1/2 sm:left-auto transform -translate-x-1/2 sm:translate-x-0 mt-2 sm:mt-2 hidden bg-white shadow-lg rounded-lg w-[90vw] sm:w-64 max-w-md border border-gray-200 z-50 overflow-hidden"
        style="top: 4rem;"
        aria-hidden="true"
      >
        <!-- User Info Header -->
        <div class="px-4 py-3 bg-blue-500">
          <div class="font-semibold text-base text-center text-white">{{ $user->first_name }} {{ $user->last_name }}</div>
          <div class="text-xs text-white truncate text-center">{{ $user->email }}</div>
        </div>

        <!-- Menu Items -->
        <ul class="text-gray-700 text-sm py-2 max-h-[60vh] overflow-y-auto">
          <!-- Personal Section -->
          <li class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
            Personal
          </li>
          <li>
            <a href="{{ route('user.profile.show') }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-person-circle text-indigo-500 mr-2"></i> My Profile
            </a>
          </li>
          <li>
            <a href="{{ route('user.security.edit') }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-shield-lock text-indigo-500 mr-2"></i> Password & 2FA
            </a>
          </li>

          <!-- Usage & Subscriptions Section -->
          <li class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-2">
            Subscriptions
          </li>
          <li>
            <a href="{{ route('user.subscriptions', $user) }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-card-list text-indigo-500 mr-2"></i> My Subscriptions
            </a>
          </li>
          <li>
            <a href="{{ route('user.billing-history', $user) }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-wallet2 text-indigo-500 mr-2"></i> My Payments
            </a>
          </li>

          <!-- Growth & Rewards Section -->
          <li class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-2">
            Rewards
          </li>
          <li>
            <a href="{{ route('user.referrals.invite') }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-megaphone text-indigo-500 mr-2"></i> Invite & Refer Friends
            </a>
          </li>
          <li>
            <a href="{{ route('user.referrals.earnings') }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-cash-coin text-indigo-500 mr-2"></i> Referral Earnings
            </a>
          </li>
          <li>
            <a href="{{ route('user.coupons.my') }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-ticket-detailed text-indigo-500 mr-2"></i> My Coupon Codes
            </a>
          </li>

          <!-- Additional Options -->
          <li class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-2">
            Options
          </li>
          <li>
            <a href="{{ route('general.pricing') }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-bar-chart-line text-indigo-500 mr-2"></i> Plans & offers
            </a>
          </li>
          <li>
            <a href="{{ route('help.contacts') }}" class="block px-4 py-2 hover:bg-indigo-50 flex items-center rounded-md transition-colors duration-150">
              <i class="bi bi-life-preserver text-indigo-500 mr-2"></i> Help & Support
            </a>
          </li>

          <!-- Logout -->
          <li class="border-t border-gray-100 mt-2">
            <form action="{{ route('sso.logout') }}" method="GET" class="w-full inline-block">
              <input type="hidden" name="app" value="{{ request()->query('app', 'custospark') }}">
              <button type="submit" class="block w-full px-4 py-3 hover:bg-red-50 flex items-center text-red-600 bg-transparent border-0 transition-colors duration-150">
                <i class="bi bi-box-arrow-right mr-2"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<!-- Backdrop for Mobile Dropdowns -->
<div id="mobile-dropdown-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<!-- JavaScript for Dropdown Interactions -->
<script>
/**
 * Custospark Header Controller
 * Handles dropdown menus and responsive behavior for the application header
 * @author Custospark Development Team
 * @version 2.0.0
 */
(function() {
  'use strict';
  
  // DOM Elements
  const dropdowns = [
    { btnId: 'notifications-btn', dropdownId: 'notifications-dropdown' },
    { btnId: 'app-launcher-btn', dropdownId: 'app-launcher-dropdown' },
    { btnId: 'profile-btn', dropdownId: 'profile-dropdown' }
  ];
  
  // State variables
  let activeDropdown = null;
  const backdrop = document.getElementById('mobile-dropdown-backdrop');
  
  /**
   * Initialize dropdown toggle functionality with safety checks
   * @param {string} btnId - Button ID
   * @param {string} dropdownId - Dropdown container ID
   */
  function initializeDropdown(btnId, dropdownId) {
    const button = document.getElementById(btnId);
    const dropdown = document.getElementById(dropdownId);
    
    if (!button || !dropdown) {
      console.warn(`Dropdown initialization failed: Elements not found for ${btnId} or ${dropdownId}`);
      return;
    }
    
    button.addEventListener('click', (event) => {
      event.stopPropagation();
      
      // Close any open dropdown that's not the current one
      if (activeDropdown && activeDropdown !== dropdown) {
        activeDropdown.classList.add('hidden');
        activeDropdown.setAttribute('aria-hidden', 'true');
      }
      
      // Toggle current dropdown
      const isHidden = dropdown.classList.contains('hidden');
      dropdown.classList.toggle('hidden');
      dropdown.setAttribute('aria-hidden', !isHidden);
      button.setAttribute('aria-expanded', isHidden);

      // Toggle backdrop for mobile view
      if (isHidden && window.innerWidth < 640) {
        backdrop.classList.remove('hidden');
      } else {
        backdrop.classList.add('hidden');
      }
      
      // Update active dropdown reference
      activeDropdown = isHidden ? dropdown : null;
    });
  }
  
  /**
   * Setup app search functionality
   */
  function setupAppSearch() {
    const searchInput = document.getElementById('app-search');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', () => {
      const query = searchInput.value.toLowerCase().trim();
      const appCards = document.querySelectorAll('#app-launcher-dropdown .app-card');
      
      appCards.forEach(card => {
        const title = card.querySelector('h2')?.innerText.toLowerCase() || '';
        const isMatch = title.includes(query);
        card.style.display = isMatch ? 'flex' : 'none';
      });
    });
    
    // Prevent search input from closing dropdown when clicked
    searchInput.addEventListener('click', (event) => {
      event.stopPropagation();
    });
  }
  
  /**
   * Register event listeners for app cards
   */
  function setupAppCardListeners() {
    const appCards = document.querySelectorAll('#app-launcher-dropdown .app-card');
    const appLauncherDropdown = document.getElementById('app-launcher-dropdown');
    
    appCards.forEach(card => {
      card.addEventListener('click', () => {
        if (appLauncherDropdown) {
          appLauncherDropdown.classList.add('hidden');
          appLauncherDropdown.setAttribute('aria-hidden', 'true');
          backdrop.classList.add('hidden');
          activeDropdown = null;
        }
      });
    });
  }
  
  /**
   * Setup help button functionality
   */
  function setupHelpButton() {
    const helpButton = document.getElementById('help-btn');
    if (!helpButton) return;
    
    helpButton.addEventListener('click', () => {
      // Configure the destination URL as needed
      window.location.href = '{{ route("help.contacts") }}';
    });
  }
  
  /**
   * Close all dropdowns when clicking outside
   */
  function setupOutsideClickListener() {
    document.addEventListener('click', (event) => {
      if (!activeDropdown) return;
      
      // Check if click is outside of active dropdown and its toggle button
      const clickedInsideDropdown = activeDropdown.contains(event.target);
      const dropdownBtnId = dropdowns.find(d => d.dropdownId === activeDropdown.id)?.btnId;
      const toggleButton = dropdownBtnId ? document.getElementById(dropdownBtnId) : null;
      const clickedToggleButton = toggleButton && toggleButton.contains(event.target);
      
      if (!clickedInsideDropdown && !clickedToggleButton) {
        activeDropdown.classList.add('hidden');
        activeDropdown.setAttribute('aria-hidden', 'true');
        if (toggleButton) toggleButton.setAttribute('aria-expanded', 'false');
        backdrop.classList.add('hidden');
        activeDropdown = null;
      }
    });

    // Close dropdowns when backdrop is clicked
    if (backdrop) {
      backdrop.addEventListener('click', () => {
        if (activeDropdown) {
          activeDropdown.classList.add('hidden');
          activeDropdown.setAttribute('aria-hidden', 'true');
          
          const dropdownBtnId = dropdowns.find(d => d.dropdownId === activeDropdown.id)?.btnId;
          const toggleButton = dropdownBtnId ? document.getElementById(dropdownBtnId) : null;
          if (toggleButton) toggleButton.setAttribute('aria-expanded', 'false');
          
          backdrop.classList.add('hidden');
          activeDropdown = null;
        }
      });
    }
  }
  
  /**
   * Add keyboard navigation for accessibility
   */
  function setupKeyboardNavigation() {
    document.addEventListener('keydown', (event) => {
      // Close dropdowns on Escape
      if (event.key === 'Escape' && activeDropdown) {
        activeDropdown.classList.add('hidden');
        activeDropdown.setAttribute('aria-hidden', 'true');
        
        const dropdownBtnId = dropdowns.find(d => d.dropdownId === activeDropdown.id)?.btnId;
        const toggleButton = dropdownBtnId ? document.getElementById(dropdownBtnId) : null;
        if (toggleButton) toggleButton.setAttribute('aria-expanded', 'false');
        
        backdrop.classList.add('hidden');
        activeDropdown = null;
      }
    });
  }

  /**
   * Handle window resize events for responsive adjustments
   */
  function setupResizeHandler() {
    window.addEventListener('resize', () => {
      // On large screens, ensure dropdowns appear in correct position
      if (window.innerWidth >= 640 && activeDropdown) {
        // Remove any fixed positioning styles for desktop
        if (activeDropdown.style.top) {
          activeDropdown.style.top = '';
        }
        
        // Hide the backdrop on larger screens
        backdrop.classList.add('hidden');
      }
    });
  }
  
  /**
   * Initialize all header functionality
   */
  function init() {
    // Initialize dropdowns
    dropdowns.forEach(({ btnId, dropdownId }) => {
      initializeDropdown(btnId, dropdownId);
    });
    
    // Setup other functionality
    setupAppSearch();
    setupAppCardListeners();
    setupHelpButton();
    setupOutsideClickListener();
    setupKeyboardNavigation();
    setupResizeHandler();
  }
  
  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>
