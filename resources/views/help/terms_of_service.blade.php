@php
$layout=Auth::check() ? 'layouts.employee' : 'layouts.main';
@endphp

@extends($layout)
@section('title', 'Terms of Service')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6 bg-white shadow-md rounded-lg">
  <div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-bold text-blue-500 flex items-center gap-2">
      <i class="bi bi-file-earmark-text-fill text-2xl"></i>
      Terms of Service
    </h1>
    <p class="text-sm text-gray-500 mt-1 flex items-center">
      <i class="bi bi-calendar-check-fill mr-2 text-blue-600"></i>
      Effective Date: January 1, 2025
    </p>
  </div>

  <p class="mb-5 text-gray-900 leading-relaxed">
    Welcome! These Terms of Service (“Terms”) explain your rights and responsibilities when using any service or platform provided by <strong>Custospark Company Ltd</strong> — including but not limited to <em>Custospace, Custohost, and Custosell</em>. By using any of our Services, you’re agreeing to these Terms.
  </p>

  {{-- Section 1 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-check-circle-fill text-lg text-green-600"></i>
      1. Your Agreement
    </h2>
    <p class="text-gray-900 leading-relaxed">
      When you sign up or use any of our Services, you confirm that you’re at least 18 years old (or have permission from a parent or guardian) and that you accept these Terms and our Privacy Policy.
    </p>
  </div>

  {{-- Section 2 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-globe2 text-lg text-indigo-600"></i>
      2. How You Can Use Our Services
    </h2>
    <ul class="list-none pl-6 text-gray-900 space-y-1">
      <li>(a) Please use our Services responsibly and legally.</li>
      <li>(b) Don’t copy, modify, or resell any part of our Services without written permission.</li>
      <li>(c) Keep your login information safe — you're responsible for your account.</li>
    </ul>
  </div>

  {{-- Section 3 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-credit-card-fill text-lg text-purple-600"></i>
      3. Subscriptions and Payments
    </h2>
    <ul class="list-none pl-6 text-gray-900 space-y-1">
      <li>(a) Some Services require a paid plan, sometimes with a free trial.</li>
      <li>(b) By subscribing, you allow us (or our payment partners) to charge your chosen payment method.</li>
      <li>(c) You’re free to cancel anytime. Your plan will remain active until the current billing cycle ends.</li>
    </ul>
  </div>

  {{-- Section 4 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-award-fill text-yellow-500"></i>
      4. Intellectual Property
    </h2>
    <p class="text-gray-900 leading-relaxed">
      Everything you see on our platforms — branding, code, designs — belongs to Custospark Company Ltd. Please don’t use it without permission.
    </p>
  </div>

  {{-- Section 5 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-chat-text-fill text-cyan-600"></i>
      5. What You Share
    </h2>
    <p class="text-gray-900 leading-relaxed">
      You own any content you upload or submit. But you give us permission to use, store, or display it so we can provide our Services to you.
    </p>
  </div>

  {{-- Section 6 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-door-closed-fill text-red-600"></i>
      6. Account Suspension or Termination
    </h2>
    <p class="text-gray-900 leading-relaxed">
      If you violate these Terms, we may suspend or deactivate your account without prior notice. We do this to protect the community and the integrity of our Services.
    </p>
  </div>

  {{-- Section 7 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-shield-exclamation text-orange-600"></i>
      7. No Guarantees
    </h2>
    <p class="text-gray-900 leading-relaxed">
      While we work hard to make our Services reliable, they’re offered “as is.” We can’t promise they’ll always be perfect or available.
    </p>
  </div>

  {{-- Section 8 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
      8. Limiting Our Liability
    </h2>
    <p class="text-gray-900 leading-relaxed">
      We’re not liable for indirect or unexpected damages related to your use of our Services — like data loss, downtime, or financial loss.
    </p>
  </div>

  {{-- Section 9 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-arrow-clockwise text-green-600"></i>
      9. Updates to These Terms
    </h2>
    <p class="text-gray-900 leading-relaxed">
      We might update these Terms occasionally. If we do, we’ll post the changes here with a new date. Continuing to use our Services means you accept the changes.
    </p>
  </div>

  {{-- Section 10 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-gavel-fill text-indigo-600"></i>
      10. Legal Matters
    </h2>
    <p class="text-gray-900 leading-relaxed">
      These Terms follow the laws of the Republic of Uganda. If there’s a dispute, it’ll be handled in Ugandan courts.
    </p>
  </div>

  {{-- Section 11 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-envelope-fill text-blue-600"></i>
      11. Talk to Us
    </h2>
    <ul class="mt-2 space-y-1 text-gray-900">
      <li><i class="bi bi-envelope-open mr-1 text-blue-600"></i>Email: <a href="mailto:{{env('COMPANY_SUPPORT_EMAIL')}}" class="text-blue-600 hover:underline">{{env('COMPANY_SUPPORT_EMAIL')}}</a></li>
      <li><i class="bi bi-telephone-fill mr-1 text-blue-600"></i>Phone: {{ env('COMPANY_SUPPORT_PHONE') }}</li>
      <li><i class="bi bi-geo-alt-fill mr-1 text-blue-600"></i>{{env('COMPANY_POSTAL_ADDRESS')}}</li>
    </ul>
  </div>
</div>
@endsection
