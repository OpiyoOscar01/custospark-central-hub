<div class="overflow-x-auto">
  <div class="min-w-[1000px] grid grid-cols-8 border border-gray-200 rounded-lg">
      <!-- Time Column -->
      <div class="bg-gray-100 border-r border-gray-200">
          @for ($hour = 0; $hour < 24; $hour++)
              <div class="h-16 flex items-start justify-end pr-2 pt-1 text-xs text-gray-500 border-b border-gray-200">
                  {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
              </div>
          @endfor
      </div>

      <!-- Days of the Week -->
      @foreach($weekDays as $day)
          <div class="flex flex-col border-r border-gray-200">
              <!-- Header -->
              <div class="h-10 flex items-center justify-center bg-gray-50 font-medium text-gray-800 border-b border-gray-200">
                  {{ \Carbon\Carbon::parse($day)->format('D, M j') }}
              </div>
              <!-- Time Blocks -->
              @for ($hour = 0; $hour < 24; $hour++)
                  <div class="h-16 border-b border-gray-100 relative">
                      @foreach($calendar[$day][$hour] ?? [] as $item)
                          <div class="absolute left-2 right-2 top-1 text-xs p-1 rounded 
                              {{ $item['type'] === 'task' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }} 
                              shadow hover:bg-opacity-80 cursor-pointer">
                              <i class="bi {{ $item['type'] === 'task' ? 'bi-check-circle' : 'bi-flag' }} mr-1"></i>
                              {{ $item['title'] }}
                          </div>
                      @endforeach
                  </div>
              @endfor
          </div>
      @endforeach
  </div>
</div>
