@props(['app'])

<span
    class="text-xs font-medium text-green-800 bg-green-100 px-2 py-0.5 rounded-full hover:underline cursor-pointer"
    onclick="window.location.href='{{ route('dashboard.pricing.app', ['app' => 2]) }}'">
    Upgrade
</span>
