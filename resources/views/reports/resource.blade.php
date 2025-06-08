<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Resource Utilization Report
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
                  <!-- Date Range Filter -->
                  <div class="mb-8">
                      <form action="{{ route('reports.resource-utilization') }}" method="GET" class="flex space-x-4">
                          <div>
                              <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                              <input type="date" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                          </div>
                          <div>
                              <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                              <input type="date" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                          </div>
                          <div class="flex items-end">
                              <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                  Update Report
                              </button>
                          </div>
                      </form>
                  </div>

                  <!-- Resource Utilization Chart -->
                  <div class="bg-white p-6 rounded-lg shadow mb-8">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Resource Utilization Chart</h3>
                      <div class="h-96" id="utilizationChart"></div>
                  </div>

                  <!-- Detailed Breakdown -->
                  <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team Member</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expected Hours</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actual Hours</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilization Rate</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @foreach($utilization as $data)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                          {{ $data['user'] }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ number_format($data['expected_hours'], 1) }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ number_format($data['actual_hours'], 1) }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          <div class="flex items-center">
                                              <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                  <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min($data['utilization_rate'], 100) }}%"></div>
                                              </div>
                                              <span>{{ number_format($data['utilization_rate'], 1) }}%</span>
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm">
                                          @php
                                              $status = $data['utilization_rate'] > 90 ? 'Overutilized' : ($data['utilization_rate'] < 70 ? 'Underutilized' : 'Optimal');
                                              $statusColor = $status === 'Overutilized' ? 'red' : ($status === 'Underutilized' ? 'yellow' : 'green');
                                          @endphp
                                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                              {{ $status }}
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
      const ctx = document.getElementById('utilizationChart').getContext('2d');
      new Chart(ctx, {
          type: 'bar',
          data: {
              labels: @json(array_column($utilization, 'user')),
              datasets: [
                  {
                      label: 'Expected Hours',
                      data: @json(array_column($utilization, 'expected_hours')),
                      backgroundColor: 'rgb(209, 213, 219)',
                  },
                  {
                      label: 'Actual Hours',
                      data: @json(array_column($utilization, 'actual_hours')),
                      backgroundColor: 'rgb(59, 130, 246)',
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
                          text: 'Hours'
                      }
                  }
              }
          }
      });
  </script>
  @endpush
</x-app-layout>