@props(['label', 'icon', 'value'])

<div>
    <label class="text-sm text-gray-600 flex items-center gap-1">
        <i class="bi {{ $icon }}"></i> {{ $label }}
    </label>
    <div class="mt-1 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800">
        {{ $value }}
    </div>
</div>
