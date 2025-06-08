@php
$countries = [
    'East Africa' => [
        ['code' => '+256', 'flag' => '🇺🇬', 'name' => 'Uganda'],
        ['code' => '+254', 'flag' => '🇰🇪', 'name' => 'Kenya'],
        ['code' => '+255', 'flag' => '🇹🇿', 'name' => 'Tanzania'],
        ['code' => '+250', 'flag' => '🇷🇼', 'name' => 'Rwanda'],
        ['code' => '+261', 'flag' => '🇲🇬', 'name' => 'Madagascar'],
        ['code' => '+268', 'flag' => '🇸🇿', 'name' => 'Eswatini'],
    ],
    'Central Africa' => [
        ['code' => '+237', 'flag' => '🇨🇲', 'name' => 'Cameroon'],
        ['code' => '+236', 'flag' => '🇨🇫', 'name' => 'Central African Republic'],
        ['code' => '+243', 'flag' => '🇨🇩', 'name' => 'Democratic Republic of the Congo'],
        ['code' => '+242', 'flag' => '🇨🇬', 'name' => 'Republic of the Congo'],
        ['code' => '+235', 'flag' => '🇹🇩', 'name' => 'Chad'],
    ],
    'West Africa' => [
        ['code' => '+234', 'flag' => '🇳🇬', 'name' => 'Nigeria'],
        ['code' => '+233', 'flag' => '🇬🇭', 'name' => 'Ghana'],
        ['code' => '+225', 'flag' => '🇨🇮', 'name' => 'Ivory Coast'],
        ['code' => '+227', 'flag' => '🇳🇪', 'name' => 'Niger'],
        ['code' => '+228', 'flag' => '🇹🇬', 'name' => 'Togo'],
        ['code' => '+226', 'flag' => '🇧🇫', 'name' => 'Burkina Faso'],
        ['code' => '+229', 'flag' => '🇧🇯', 'name' => 'Benin'],
        ['code' => '+220', 'flag' => '🇬🇲', 'name' => 'Gambia'],
        ['code' => '+241', 'flag' => '🇬🇦', 'name' => 'Gabon'],
    ],
    'United States' => [
        ['code' => '+1', 'flag' => '🇺🇸', 'name' => 'United States'],
        ['code' => '+1', 'flag' => '🇨🇦', 'name' => 'Canada'],
        ['code' => '+1', 'flag' => '🇵🇷', 'name' => 'Puerto Rico'],
    ],
    'India' => [
        ['code' => '+91', 'flag' => '🇮🇳', 'name' => 'India'],
    ],
    'Europe' => [
        ['code' => '+44', 'flag' => '🇬🇧', 'name' => 'United Kingdom'],
        ['code' => '+49', 'flag' => '🇩🇪', 'name' => 'Germany'],
        ['code' => '+33', 'flag' => '🇫🇷', 'name' => 'France'],
        ['code' => '+39', 'flag' => '🇮🇹', 'name' => 'Italy'],
        ['code' => '+34', 'flag' => '🇪🇸', 'name' => 'Spain'],
        ['code' => '+31', 'flag' => '🇳🇱', 'name' => 'Netherlands'],
        ['code' => '+41', 'flag' => '🇨🇭', 'name' => 'Switzerland'],
        ['code' => '+48', 'flag' => '🇵🇱', 'name' => 'Poland'],
        ['code' => '+46', 'flag' => '🇸🇪', 'name' => 'Sweden'],
        ['code' => '+420', 'flag' => '🇨🇿', 'name' => 'Czech Republic'],
    ],
];
@endphp

<section id="consultation-form" class="py-20 bg-gradient-to-br from-blue-500 via-black to-blue-500">
  <div class="max-w-screen-lg mx-auto px-4 text-center">
  <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">
  Ready to Transform Your Vision into Reality?
</h2>
<p class="text-lg text-white mb-4">
  Share a few details with us and our expert team will reach out to guide you every step of the way.
</p>

<form action="{{ route('consultations.store') }}" method="POST"
      class="max-w-2xl mx-auto bg-white p-10 rounded-2xl shadow-2xl border border-blue-100 space-y-6 text-left">
  @csrf

  {{-- Full Name --}}
  <div>
    <label for="full_name" class="block text-sm font-semibold text-blue-900 mb-1">
      <i class="bi bi-person-fill mr-1 text-blue-600"></i> Full Name
    </label>
    <input type="text" id="full_name" name="full_name"
           value="{{ old('full_name') }}"
           class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white @error('full_name') border-red-500 @else border-gray-300 @enderror"
           required>
    @error('full_name')
      <p class="text-red-500 text-sm mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
    @enderror
  </div>

  {{-- Email --}}
  <div>
    <label for="email" class="block text-sm font-semibold text-blue-900 mb-1">
      <i class="bi bi-envelope-fill mr-1 text-blue-600"></i> Email Address
    </label>
    <input type="email" id="email" name="email"
           value="{{ old('email') }}"
           class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white @error('email') border-red-500 @else border-gray-300 @enderror"
           required>
    @error('email')
      <p class="text-red-500 text-sm mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
    @enderror
  </div>

  {{-- Phone Number and Country Code --}}
  <div>
    <label class="block text-sm font-semibold text-blue-900 mb-1">
      <i class="bi bi-telephone-fill mr-1 text-blue-600"></i> Phone Number
    </label>
    <div class="flex space-x-2">
      <select name="country_code" id="country_code"
              class="w-1/3 p-3 border rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('country_code') border-red-500 @else border-gray-300 @enderror"
              onchange="toggleCustomCodeInput()">
        @foreach ($countries as $region => $list)
          <optgroup label="{{ $region }}">
            @foreach ($list as $country)
              <option value="{{ $country['code'] }}"
                      {{ old('country_code') == $country['code'] ? 'selected' : '' }}>
                {{ $country['flag'] }} {{ $country['code'] }} {{ $country['name'] }}
              </option>
            @endforeach
          </optgroup>
        @endforeach
        <option value="custom" {{ old('country_code') == 'custom' ? 'selected' : '' }}>Code not found, enter manually</option>
      </select>

      <input type="hidden" name="country_code_hidden" id="country_code_hidden"
             value="{{ old('country_code') !== 'custom' ? old('country_code') : '' }}">

      <input type="tel" id="custom_country_code" name="custom_country_code"
             value="{{ old('custom_country_code') }}"
             class="w-1/3 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white {{ old('country_code') == 'custom' ? '' : 'hidden' }}"
             placeholder="Enter code e.g. +999">

      <input type="tel" id="phone" name="phone"
             value="{{ old('phone') }}"
             class="w-2/3 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white @error('phone') border-red-500 @else border-gray-300 @enderror"
             placeholder="e.g. 712345678" required>
    </div>
    @error('phone')
      <p class="text-red-500 text-sm mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
    @enderror
  </div>

  {{-- Timezone --}}
  <div>
    <label for="timezone" class="block text-sm font-semibold text-blue-900 mb-1">
      <i class="bi bi-globe2 mr-1 text-blue-600"></i> Time Zone
    </label>
    <select id="timezone" name="timezone"
            class="w-full p-3 border rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 @error('timezone') border-red-500 @else border-gray-300 @enderror"
            required>
      @foreach(timezone_identifiers_list() as $zone)
        <option value="{{ $zone }}" {{ old('timezone') == $zone ? 'selected' : '' }}>{{ $zone }}</option>
      @endforeach
    </select>
    @error('timezone')
      <p class="text-red-500 text-sm mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
    @enderror
  </div>

{{-- Preferred Date --}}
<div class="mt-4">
  <label for="preferred_date" class="block text-sm font-semibold text-blue-900 mb-1">
    <i class="bi bi-calendar-event-fill mr-1 text-blue-600"></i> Preferred Date for Consultation
  </label>
  <input type="date" id="preferred_date" name="preferred_date"
         value="{{ old('preferred_date') }}"
         class="w-full p-3 border rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 border-gray-300 @error('preferred_date') border-red-500 @enderror">
  @error('preferred_date')
    <p class="text-red-600 text-sm mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
  @enderror
</div>



{{-- Preferred Time Slots --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-blue-900 mb-1">
    <i class="bi bi-clock-fill mr-1 text-blue-600"></i> Preferred Time Slot
  </label>

  <div class="flex space-x-4">
    {{-- Start Time --}}
    <div class="w-1/2">
      <label for="preferred_start" class="block text-xs text-blue-700 mb-1">Start Time</label>
      <input type="time" id="preferred_start" name="preferred_start"
             value="{{ old('preferred_start') }}"
             class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white border-gray-300">
      @error('preferred_start')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- End Time --}}
    <div class="w-1/2">
      <label for="preferred_end" class="block text-xs text-blue-700 mb-1">End Time</label>
      <input type="time" id="preferred_end" name="preferred_end"
             value="{{ old('preferred_end') }}"
             class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white border-gray-300">
      @error('preferred_end')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>
  </div>
</div>


{{-- Time Validation Script --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const startInput = document.getElementById('preferred_start');
    const endInput = document.getElementById('preferred_end');

    function validateTimes() {
      if (startInput.value && endInput.value && startInput.value >= endInput.value) {
        alert('End time must be after start time.');
        endInput.value = '';
        endInput.focus();
      }
    }

    endInput.addEventListener('change', validateTimes);
    startInput.addEventListener('change', () => {
      if (endInput.value) validateTimes();
    });
  });
</script>


  {{-- Meeting Type --}}
  <div>
    <label for="meeting_type" class="block text-sm font-semibold text-blue-900 mb-1">
      <i class="bi bi-camera-video-fill mr-1 text-blue-600"></i> Preferred Meeting Format
    </label>
    <select id="meeting_type" name="meeting_type"
            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white border-gray-300"
            required>
      <option value="video" {{ old('meeting_type') == 'video' ? 'selected' : '' }}>Video Call</option>
      <option value="phone" {{ old('meeting_type') == 'phone' ? 'selected' : '' }}>Phone Call</option>
      <option value="in_person" {{ old('meeting_type') == 'in_person' ? 'selected' : '' }}>In Person (if applicable)</option>
    </select>
  </div>

  {{-- Organization --}}
  <div>
    <label for="organization" class="block text-sm font-semibold text-blue-900 mb-1">
      <i class="bi bi-building mr-1 text-blue-600"></i> Company / Organization (Optional)
    </label>
    <input type="text" id="organization" name="organization"
           value="{{ old('organization') }}"
           class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white border-gray-300"
           placeholder="Your company name (if applicable)">
  </div>

  {{-- Message --}}
  <div>
    <label for="message" class="block text-sm font-semibold text-blue-900 mb-1">
      <i class="bi bi-chat-left-dots-fill mr-1 text-blue-600"></i> Additional Notes (Optional)
    </label>
    <textarea id="message" name="message" rows="4"
              class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white @error('message') border-red-500 @else border-gray-300 @enderror"
              placeholder="Let us know anything specific you'd like us to prepare or be aware of.">{{ old('message') }}</textarea>
    @error('message')
      <p class="text-red-500 text-sm mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
    @enderror
  </div>

  {{-- Submit --}}
  <div>
    <button type="submit"
            class="w-full bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold py-3 rounded-md shadow-lg transition-all">
      <i class="bi bi-calendar-check-fill mr-2"></i> Schedule Free Consultation
    </button>
  </div>
</form>


  </div>
</section>



<section id="testimonials" class="py-20 bg-gradient-to-r from-blue-500 to-black text-white">
  <div class="max-w-screen-lg mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-8">What Our Clients Are Saying</h2>
    <div class="flex flex-wrap justify-center gap-12">
      <div class="testimonial-card p-6 bg-white text-black rounded-lg shadow-lg max-w-xs w-full">
        <p class="italic text-gray-600 mb-4">"The consultation provided us with incredible insights that took our business to new heights. Highly recommend!"</p>
        <p class="font-semibold text-gray-800">John Okello</p>
        <p class="text-sm text-gray-500">CEO, Acme Corp</p>
      </div>
      <div class="testimonial-card p-6 bg-white text-black rounded-lg shadow-lg max-w-xs w-full">
        <p class="italic text-gray-600 mb-4">"I couldn't have asked for a better experience. The team was professional, knowledgeable, and truly helpful."</p>
        <p class="font-semibold text-gray-800">Jane Nalubega</p>
        <p class="text-sm text-gray-500">Founder, Innovate Ltd.</p>
      </div>
    </div>
  </div>
</section>

<section id="faq" class="py-20 bg-gradient-to-l from-blue-500 to-black text-white">
  <div class="max-w-screen-lg mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-white-800 mb-8">Frequently Asked Questions</h2>
    <div class="flex flex-wrap justify-center gap-6">
      <div class="faq-item p-6 bg-white rounded-xl shadow-md max-w-sm w-full">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">How long is the consultation?</h3>
        <p class="text-gray-700">Our consultations typically last about 30-45 minutes, depending on your needs.</p>
      </div>
      <div class="faq-item p-6 bg-white rounded-xl shadow-md max-w-sm w-full">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Is the consultation free?</h3>
        <p class="text-gray-700">Yes! Our initial consultation is completely free of charge. We'll discuss your business needs and how we can help.</p>
      </div>
      <div class="faq-item p-6 bg-white rounded-xl shadow-md max-w-sm w-full">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Do I need to prepare anything?</h3>
        <p class="text-gray-700">You don't need to prepare anything in advance. Just bring your questions, and we'll help guide you through the process.</p>
      </div>
    </div>
  </div>
  <script>
  function toggleCustomCodeInput() {
    const select = document.getElementById('country_code');
    const customInput = document.getElementById('custom_country_code');
    const hiddenInput = document.getElementById('country_code_hidden');

    if (select.value === 'custom') {
      customInput.classList.remove('hidden');
      customInput.required = true;
      hiddenInput.value = '';
    } else {
      customInput.classList.add('hidden');
      customInput.required = false;
      hiddenInput.value = select.value;
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    toggleCustomCodeInput();
  });
</script>
</section>

<style>
  #consultation-hero {
    background: linear-gradient(to right, #2196F3, #9C27B0);
  }

  .testimonial-card {
    background-color: rgba(255, 255, 255, 0.9);
  }

  .faq-item {
    transition: transform 0.3s;
  }

  .faq-item:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  }
</style>
