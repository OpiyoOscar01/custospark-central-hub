@php
    use App\Helpers\SubscriptionHelper;

    $hasAccess = SubscriptionHelper::userHasFeature($app, $feature);
    $isActive = Route::is($routeName . '.*');
@endphp

<li>
    @if($hasAccess)
        <a href="{{ route($routeName . '.index') }}"
           class="flex items-center justify-between py-2 px-3 rounded hover:bg-indigo-100 {{ $isActive ? 'bg-indigo-200 font-semibold' : '' }}">
            <span>
                <i class="bi {{ $icon }} text-lg mr-2"></i> {{ $label }}
                @if(!empty($isNew))
                    <span class="ml-2 text-xs text-white bg-indigo-500 px-2 py-0.5 rounded-full">New</span>
                @endif
            </span>
        </a>
    @else
        <div class="flex items-center justify-between py-2 px-3 rounded bg-gray-50 border border-dashed border-gray-300 hover:bg-gray-100 cursor-not-allowed"
             title="Upgrade your plan to access this feature" aria-disabled="true" role="link">
            <div class="flex items-center">
                <i class="bi {{ $icon }} text-lg mr-2 text-gray-400"></i>
                <span class="text-gray-500">{{ $label }}</span>
            </div>

            <div class="flex items-center space-x-2">
                <x-upgrade-badge :app="1" />
                @if(!empty($isNew))
                    <span class="text-xs text-white bg-indigo-500 px-2 py-0.5 rounded-full">New</span>
                @endif
            </div>
        </div>
    @endif
</li>
