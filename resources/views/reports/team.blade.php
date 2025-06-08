<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Team Performance Report
          </h2>
          <div class="flex space-x-4">
              <a href="{{ route('reports.export-time-logs', ['format' => 'excel']) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                  Export Excel
              </a>
              <a href="{{ route('reports.export-time-logs', ['format' => 'pdf']) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                  Export PDF
              </a>
          </div>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6">
                  <!-- Performance Overview -->
                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                      @foreach($users as $user)
                          <div class="bg-white p-6 rounded-lg shadow">
                              <div class="flex items-center">
                                  <div class="flex-shrink-0 h-10 w-10">
                                      <span class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700">
                                          {{ strtoupper(substr($user['name'], 0, 2)) }}
                                      </span>
                                  </div>
                                  <div class="ml-4">
                                      <h3 class="text-lg font-medium text-gray-900">{{ $user['name'] }}</h3>
                                      <p class="text-sm text-gray-500">Team Member</p>
                                  </div>
                              </div>
                              <div class="mt-4">
                                  <dl class="grid grid-cols-1 gap-4">
                                      <div>
                                          <dt class="text-sm font-medium text-gray-500">Tasks Completed</dt>
                                          <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $user['completed_tasks'] }}/{{ $user['total_tasks'] }}</dd>
                                      </div>
                                      <div>
                                          <dt class="text-sm font-medium text-gray-500">On-Time Completion Rate</dt>
                                          <dd class="mt-1">
                                              <div class="flex items-center">
                                                  <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                      <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $user['on_time_completion_rate'] }}%"></div>
                                                  </div>
                                                  <span class="text-sm text-gray-700">{{ number_format($user['on_time_completion_rate'], 1) }}%</span>
                                              </div>
                                          </dd>
                                      </div>
                                      <div>
                                          <dt class="text-sm font-medium text-gray-500">Billable Hours</dt>
                                          <dd class="mt-1 text-lg font-semibold text-gray-900">{{ number_format($user['billable_hours'], 1) }} hrs</dd>
                                      </div>
                                  </dl>
                              </div>
                          </div>
                      @endforeach
                  </div>

                  <!-- Performance Metrics Chart -->
                  <div class="bg-white p-6 rounded-lg shadow mb-8">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Performance Metrics</h3>
                      <div class="h-96" id="performanceChart"></div>
                  </div>

                  <!-- Detailed Performance Table -->
                  <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team Member</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tasks Completed</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">On-Time Completion</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Task Duration</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Billable Hours</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance Rating</th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @foreach($users as $user)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="flex items-center">
                                              <div class="flex-shrink-0 h-8 w-8">
                                                  <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-sm">
                                                      {{ strtoupper(substr($user['name'], 0, 2)) }}
                                                  </span>
                                              </div>
                                              <div class="ml-4">
                                                  <div class="text-sm font-medium text-gray-900">{{ $user['name'] }}</div>
                                              </div>
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ $user['completed_tasks'] }}/{{ $user['total_tasks'] }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ number_format($user['on_time_completion_rate'], 1) }}%
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ number_format($user['average_task_duration'], 1) }} days
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ number_format($user['billable_hours'], 1) }} hrs
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          @php
                                              $rating = $user['on_time_completion_rate'] >= 90 ? 'Excellent' : ($user['on_time_completion_rate'] >= 75 ? 'Good' : 'Needs Improvement');
                                              $ratingColor = $rating === 'Excellent' ? 'green' : ($rating === 'Good' ? 'blue' : 'yellow');
                                          @endphp
                                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $ratingColor }}-100 text-{{ $ratingColor }}-800">
                                              {{ $rating }}
                                          </span>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
      const ctx = document.getElementById('performanceChart').getContext('2d');
      new Chart(ctx, {
          type: 'bar',
          data: {
              labels: @json(array_column($users, 'name')),
              datasets: [
                  {
                      label: 'Tasks Completed',
                      data: @json(array_column($users, 'completed_tasks')),
                      backgroundColor: 'rgb(59, 130, 246)',
                  },
                  {
                      label: 'On-Time Completion Rate (%)',
                      data: @json(array_column($users, 'on_time_completion_rate')),
                      backgroundColor: 'rgb(34, 197, 94)',
                  },
                  {
                      label: 'Billable Hours',
                      data: @json(array_column($users, 'billable_hours')),
                      backgroundColor: 'rgb(168, 85, 247)',
                  }
              ]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
  </script>
  @endpush
</x-app-layout>