@if(session('success') || session('error') || session('info') || session('warning'))
    @php
        $types = ['success', 'error', 'info', 'warning'];
        $type = collect($types)->first(fn($t) => session($t));
        $message = session($type);

        $styles = [
            'success' => [
                'bg' => 'bg-white',
                'text' => 'text-blue-500',
                'icon' => 'bi-check-circle-fill',
                'title' => 'Success',
            ],
            'error' => [
                'bg' => 'bg-red-500',
                'text' => 'text-white',
                'icon' => 'bi-x-circle-fill',
                'title' => 'Error',
            ],
            'info' => [
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-800',
                'icon' => 'bi-info-circle-fill',
                'title' => 'Information',
            ],
            'warning' => [
                'bg' => 'bg-yellow-100',
                'text' => 'text-yellow-800',
                'icon' => 'bi-exclamation-triangle-fill',
                'title' => 'Warning',
            ],
        ];
    @endphp

    <div 
        id="toast" 
        class="fixed top-4 inset-x-4 sm:left-1/2 sm:transform sm:-translate-x-1/2 z-[9999] flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 max-w-[80vw] sm:max-w-3xl w-auto px-3 py-2 sm:px-4 sm:py-4 rounded-xl shadow-lg {{ $styles[$type]['bg'] }} {{ $styles[$type]['text'] }} mt-10"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >
        <!-- Icon -->
        <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-white bg-opacity-20 rounded-full">
            <i class="bi {{ $styles[$type]['icon'] }} text-xl sm:text-2xl"></i>
        </div>

        <!-- Message -->
        <div class="flex-1">
            <p class="text-xs sm:text-sm font-semibold mb-0.5 sm:mb-1">{{ $styles[$type]['title'] }}</p>
            <p class="text-xs sm:text-sm leading-snug">{{ $message }}</p>
        </div>

        <!-- Dismiss -->
        <button 
            onclick="document.getElementById('toast')?.remove()" 
            class="self-start sm:self-center text-inherit hover:text-black transition text-base sm:text-lg leading-none"
            aria-label="Dismiss notification"
            type="button"
        >
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => toast.remove(), 400);
            }
        }, 5000);
    </script>
@endif
