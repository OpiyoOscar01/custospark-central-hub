@php
$layout=Auth::check() ? 'layouts.employee' : 'layouts.main';
@endphp

@extends($layout)
@section('title', 'Privacy Policy')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6 bg-white shadow-md rounded-lg">
  <div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-bold text-blue-500 flex items-center gap-2">
      <i class="bi bi-shield-lock-fill text-2xl"></i>
      Privacy Policy
    </h1>
    <p class="text-sm text-gray-500 mt-1 flex items-center">
      <i class="bi bi-calendar-check-fill mr-2 text-blue-600"></i>
      Effective Date: January 1, 2025
    </p>
  </div>

  <p class="mb-5 text-gray-900 leading-relaxed">
    At Custospark Company Ltd (“we”, “our”, “us”), your privacy isn't just a formality—it's part of the service we’re proud to offer. This policy outlines how we collect and use your information to better serve you across our platforms: <em>Custospace, Custohost, and Custosell</em>.
  </p>

  {{-- Section 1 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-person-lines-fill text-indigo-600 text-lg"></i>
      1. Information We Collect
    </h2>
    <ul class="list-alpha pl-6 text-gray-900 space-y-1">
      <li><strong>a. Personal Information:</strong> Helps us communicate and verify your identity — includes name, email, and contact details.</li>
      <li><strong>b. Account Information:</strong> Enables seamless access and billing — such as login details and subscription choices.</li>
      <li><strong>c. Usage Data:</strong> Lets us enhance your experience based on how you use the platform — like your device type, actions, and preferences.</li>
      <li><strong>d. Communication Records:</strong> Ensures we offer responsive and tailored support when you contact us.</li>
    </ul>
  </div>

  {{-- Section 2 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-gear-fill text-green-600 text-lg"></i>
      2. How We Use Your Information
    </h2>
    <ul class="list-alpha pl-6 text-gray-900 space-y-1">
      <li><strong>a.</strong> To deliver and enhance the services you rely on</li>
      <li><strong>b.</strong> To customize your experience, making it more relevant to your goals</li>
      <li><strong>c.</strong> To manage your subscription and facilitate secure payments</li>
      <li><strong>d.</strong> To keep you informed about updates or respond to your queries</li>
      <li><strong>e.</strong> To protect your account and detect any suspicious activity</li>
    </ul>
  </div>

  {{-- Section 3 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-share-fill text-purple-600 text-lg"></i>
      3. Sharing Your Information
    </h2>
    <p class="text-gray-900 leading-relaxed">
      We value your trust. That’s why we never sell your personal data. Any information we share with trusted partners is solely to help us serve you better — under strict confidentiality and only as needed to operate securely and efficiently.
    </p>
  </div>

  {{-- Section 4 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-lock-fill text-red-600 text-lg"></i>
      4. Data Security
    </h2>
    <p class="text-gray-900 leading-relaxed">
      Your peace of mind matters. We employ advanced security technologies and internal policies to protect your data from unauthorized access, breaches, and misuse.
    </p>
  </div>

  {{-- Section 5 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-person-check-fill text-cyan-600 text-lg"></i>
      5. Your Rights
    </h2>
    <ul class="list-alpha pl-6 text-gray-900 space-y-1">
      <li><strong>a.</strong> Review the personal data we have about you</li>
      <li><strong>b.</strong> Correct any information that’s outdated or inaccurate</li>
      <li><strong>c.</strong> Request the deletion of your data if no longer necessary</li>
      <li><strong>d.</strong> Control how we communicate with you — including marketing</li>
    </ul>
  </div>

  {{-- Section 6 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-hourglass-split text-yellow-500 text-lg"></i>
      6. Retention
    </h2>
    <p class="text-gray-900 leading-relaxed">
      We keep your data only for as long as needed to support your use of our Services or meet legal requirements — no longer than necessary.
    </p>
  </div>

  {{-- Section 7 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-cookie text-orange-600 text-lg"></i>
      7. Cookies
    </h2>
    <p class="text-gray-900 leading-relaxed">
      Cookies help us understand your preferences, so we can provide relevant content and improve performance. You can control or disable cookies anytime via your browser.
    </p>
  </div>

  {{-- Section 8 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-arrow-clockwise text-green-600 text-lg"></i>
      8. Updates to This Policy
    </h2>
    <p class="text-gray-900 leading-relaxed">
      We may occasionally update this policy to reflect new features or legal changes. We’ll always post the latest version here, so you’re in the loop.
    </p>
  </div>

  {{-- Section 9 --}}
  <div class="mt-8">
    <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 mb-2">
      <i class="bi bi-envelope-fill text-blue-600"></i>
      9. Contact Us
    </h2>
    <p class="text-gray-900 leading-relaxed">
      Have questions or concerns? We're here to help.
    </p>
    <ul class="mt-2 space-y-1 text-gray-900">
      <li><i class="bi bi-envelope-open mr-1 text-blue-600"></i>Email: <a href="mailto:{{env('COMPANY_SUPPORT_EMAIL')}}" class="text-blue-600 hover:underline">{{env('COMPANY_SUPPORT_EMAIL')}}</a></li>
      <li><i class="bi bi-telephone-fill mr-1 text-blue-600"></i>Phone: {{ env('COMPANY_SUPPORT_PHONE') }}</li>
      <li><i class="bi bi-geo-alt-fill mr-1 text-blue-600"></i>{{env('COMPANY_POSTAL_ADDRESS')}}</li>
    </ul>
  </div>
</div>
@endsection
