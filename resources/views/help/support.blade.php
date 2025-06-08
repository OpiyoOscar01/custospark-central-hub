@php
$layout=Auth::check() ? 'layouts.employee' : 'layouts.main';
@endphp

@extends($layout)
@section('title', 'Help & Support')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-4 flex items-center gap-2 text-indigo-600">
      <i class="bi bi-life-preserver-fill text-2xl"></i>
      Help & Support
    </h1>
    <p class="mb-6 text-gray-600">Welcome to your support hub! Find quick answers, helpful tips, and ways to contact us if you need more help.</p>

    {{-- Support Sections --}}
    <div class="space-y-10">

        {{-- Getting Started --}}
        <section>
            <h2 class="text-xl font-semibold mb-2 flex items-center gap-2 text-indigo-500">
              <i class="bi bi-rocket-takeoff"></i>
              Getting Started
            </h2>
            <p class="mb-3 text-gray-700">
              New here? Learn how to set up your account and get familiar with the Custospark apps.
            </p>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>How to register and verify your account</li>
                <li>Overview of Custospark apps: CustoSell, CustoHost, and CustoSpace</li>
                <li>Subscribing to free or paid plans</li>
            </ul>
        </section>

        {{-- Subscriptions & Billing --}}
        <section>
            <h2 class="text-xl font-semibold mb-2 flex items-center gap-2 text-indigo-500">
              <i class="bi bi-credit-card-2-back"></i>
              Subscriptions & Billing
            </h2>
            <p class="mb-3 text-gray-700">
              Understand how billing works, manage your subscriptions, and know your payment options.
            </p>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Understanding trial periods and billing cycles</li>
                <li>How to upgrade, downgrade, or cancel subscriptions</li>
                <li>Payment methods supported (Flutterwave, Mobile Money, etc.)</li>
            </ul>
        </section>

        {{-- Roles & Permissions --}}
        <section>
            <h2 class="text-xl font-semibold mb-2 flex items-center gap-2 text-indigo-500">
              <i class="bi bi-shield-lock"></i>
              Roles & Permissions
            </h2>
            <p class="mb-3 text-gray-700">
              Learn how to manage user access and permissions for your team or organization within the apps.
            </p>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Managing user roles per app</li>
                <li>Granting feature-level access</li>
                <li>How access is restricted by role and subscription level</li>
            </ul>
        </section>

        {{-- Feedback & Notifications --}}
        <section>
            <h2 class="text-xl font-semibold mb-2 flex items-center gap-2 text-indigo-500">
              <i class="bi bi-bell"></i>
              Notifications & Feedback
            </h2>
            <p class="mb-3 text-gray-700">
              Stay informed with notifications and share your experience or issues with us.
            </p>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Understanding in-app and email notifications</li>
                <li>How to submit feedback or report a bug</li>
                <li>Rating your experience with CustoApps</li>
            </ul>
        </section>

        {{-- Technical Support --}}
        <section>
            <h2 class="text-xl font-semibold mb-2 flex items-center gap-2 text-indigo-500">
              <i class="bi bi-tools"></i>
              Technical Support
            </h2>
            <p class="mb-3 text-gray-700">
              Having trouble? Here’s how to fix common issues or reach out for direct help.
            </p>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Troubleshooting login or access issues</li>
                <li>How to reset your password</li>
                <li>Contacting support via email or phone</li>
            </ul>
        </section>

        {{-- Contact --}}
        <section>
            <h2 class="text-xl font-semibold mb-2 flex items-center gap-2 text-indigo-500">
              <i class="bi bi-envelope-at"></i>
              Contact Us
            </h2>
            <p class="text-gray-700 mb-2">
                Need personalized support? Reach out to our friendly support team anytime.
            </p>
            <ul class="text-gray-700 space-y-1">
                <li>
                    <i class="bi bi-envelope-fill mr-1"></i> 
                    Email: <a href="mailto:support@custospark.com" class="text-indigo-600 hover:underline">support@custospark.com</a>
                </li>
                <li>
                    <i class="bi bi-telephone-fill mr-1"></i> 
                    Phone: <a href="tel:+256756697871" class="text-indigo-600 hover:underline">+256 756 697871</a>
                </li>
            </ul>
        </section>
    </div>
</div>
@endsection
