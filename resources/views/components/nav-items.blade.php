{{-- resources/views/components/nav-items.blade.php --}}
@php
  $menuItems = [
    ['route' => route('home'), 'icon' => 'bi-house-door', 'label' => 'Home'],
    ['section' => 'services', 'icon' => 'bi-briefcase', 'label' => 'Services', 'dropdown' => [
      ['href' => '#software-dev', 'icon' => 'bi-laptop text-blue-500', 'label' => 'Software Development'],
      ['href' => '#business-solutions', 'icon' => 'bi-gear text-green-500', 'label' => 'Business Solutions & Automation'],
      ['href' => '#cloud-services', 'icon' => 'bi-cloud-fill text-indigo-500', 'label' => 'Cloud & AI Solutions'],
      ['href' => '#consulting', 'icon' => 'bi-person-gear text-yellow-500', 'label' => 'Consulting & Strategy'],
      ['href' => '#security', 'icon' => 'bi-shield-lock text-teal-500', 'label' => 'Security & Data Protection'],
      ['href' => '#design', 'icon' => 'bi-pencil-square text-pink-500', 'label' => 'Design & User Experience'],
      ['href' => '#marketing', 'icon' => 'bi-bullhorn text-red-500', 'label' => 'Marketing & AI-Driven Strategies'],
      ['href' => '#support', 'icon' => 'bi-headset text-purple-500', 'label' => 'Support & Maintenance'],
      ['href' => '#education', 'icon' => 'bi-book text-gray-500', 'label' => 'Education & Training'],
    ]],
    ['section' => 'products', 'icon' => 'bi-tools', 'label' => 'Products', 'dropdown' => [
      ['href' => '#web-dev', 'img' => asset('images/v8.png'), 'label' => 'Custosell'],
    ]],
    ['section' => 'opportunities', 'icon' => 'bi-briefcase', 'label' => 'Opportunities', 'dropdown' => [
      ['href' => '#software-dev', 'icon' => 'bi-laptop text-blue-500', 'label' => 'Careers'],
      ['href' => '#business-solutions', 'icon' => 'bi-gear text-green-500', 'label' => 'Partnerships'],
      ['href' => '#cloud-services', 'icon' => 'bi-cloud-fill text-indigo-500', 'label' => 'Investors'],
    ]],
    ['href' => '#about', 'icon' => 'bi-briefcase', 'label' => 'About Us'],
    ['href' => '#contact', 'icon' => 'bi-file-earmark-text', 'label' => 'Contact'],
    ['href' => '#blog', 'icon' => 'bi-pencil-square', 'label' => 'Blog'],
    ['href' => '#contact', 'icon' => 'bi-envelope', 'label' => 'Login'],
  ];
@endphp

@foreach ($menuItems as $item)
  @if (isset($item['dropdown']))
    <div class="relative group">
      <button class="flex items-center text-lg font-semibold text-white hover:text-orange-300 transition duration-300 p-2 focus:outline-none">
        <i class="bi {{ $item['icon'] }} mr-2"></i> {{ $item['label'] }} <i class="bi bi-caret-down-fill ml-2"></i>
      </button>
      <div class="absolute left-0 mt-2 w-80 md:w-[40vw] bg-white text-blue-900 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-300 z-50 p-4">
        <div class="grid grid-cols-2 gap-6">
          @foreach ($item['dropdown'] as $sub)
            <a href="{{ $sub['href'] }}" class="flex items-center px-4 py-2 rounded-md hover:bg-orange-100 transition">
              @if (isset($sub['img']))
                <img src="{{ $sub['img'] }}" class="w-6 h-6 mr-2 rounded-full">
              @else
                <i class="bi {{ $sub['icon'] ?? '' }} mr-2"></i>
              @endif
              {{ $sub['label'] }}
            </a>
          @endforeach
        </div>
      </div>
    </div>
  @else
    <a href="{{ $item['href'] ?? $item['route'] }}" class="hover:text-orange-300 transition duration-300">
      <i class="bi {{ $item['icon'] ?? '' }} mr-2"></i> {{ $item['label'] }}
    </a>
  @endif
@endforeach
