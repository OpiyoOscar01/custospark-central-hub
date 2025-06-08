<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Project Burndown - {{ $project->name }}
          </h2>
          <div class="flex space-x-4">
              <a href="{{ route('reports.export-project', ['project' => $project->id, 'format' => 'excel']) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                  Export Excel
              </a>
              <a href="{{ route('reports.export-project', ['project' => $project->id, 'format' => 'pdf']) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                  Export PDF
              </a>
          </div>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6">
                  <!-- Project Overview -->
                  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                      <div class="bg-gray-50 p-4 rounded-lg">
                          <h4 class="text-sm font-medium text-gray-500">Total Tasks</h4>
                          <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $project->tasks()->count() }}</p>
                      </div>
                      <div class="bg-gray-50 p-4 rounded-lg">
                          <h4 class="text-sm font-medium text-gray-500">Completed Tasks</h4>
                          <p class="mt-2 text-3xl font-semibold text-green-600">{{ $project->tasks()->where('status', 'completed')->count() }}</p>
                      </div>
                      <div class="bg-gray-50 p-4 rounded-lg">
                          <h4 class="text-sm font-medium text-gray-500">Days Remaining</h4>
                          <p class="mt-2 text-3xl font-semibold text-blue-600">{{ $project->end_date->diffInDays(now()) }}</p>
                      </div>
                      <div class="bg-gray-50 p-4 rounded-lg">
                          <h4 class="text-sm font-medium text-gray-500">Progress</h4>
                          <p class="mt-2 text-3xl font-semibold text-indigo-600">{{ $project->progress }}%</p>
                      </div>
                  </div>

                  <!-- Burndown Chart -->
                  <div class="bg-white p-6 rounded-lg shadow">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Burndown Chart</h3>
                      <div class="h-96" id="burndownChart"></div>
                  </div>

                  <!-- Task Completion Table -->
                  <div class="mt-8">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Task Completion Details</h3>
                      <div class="overflow-x-auto">
                          <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                  <tr>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Tasks</th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ideal Burndown</th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variance</th>
                                  </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                  @foreach($burndownData as $index => $data)
                                      <tr>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                              {{ $data['date'] }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                              {{ $data['remaining'] }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                              {{ round($idealBurndown[$index]['remaining'], 1) }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm">
                                              @php
                                                  $variance = $data['remaining'] - $idealBurndown[$index]['remaining'];
                                              @endphp
                                              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $variance > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                  {{ $variance > 0 ? '+' : '' }}{{ round($variance, 1) }}
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
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
      const ctx = document.getElementById('burndownChart').getContext('2d');
      new Chart(ctx, {
          type: 'line',
          data: {
              labels: @json(array_column($burndownData, 'date')),
              datasets: [
                  {
                      label: 'Actual Burndown',
                      data: @json(array_column($burndownData, 'remaining')),
                      borderColor: 'rgb(59, 130, 246)',
                      tension: 0.1
                  },
                  {
                      label: 'Ideal Burndown',
                      data: @json(array_column($idealBurndown, 'remaining')),
                      borderColor: 'rgb(156, 163, 175)',
                      borderDash: [5, 5],
                      tension: 0.1
                  }
              ]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                  y: {
                      beginAtZero: true,
                      title: {
                          display: true,
                          text: 'Remaining Tasks'
                      }
                  },
                  x: {
                      title: {
                          display: true,
                          text: 'Date'
                      }
                  }
              }
          }
      });
  </script>
  @endpush
</x-app-layout>