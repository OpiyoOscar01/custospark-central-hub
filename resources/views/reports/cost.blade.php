<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Cost Tracking - {{ $project->name }}
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
                  <!-- Budget Overview -->
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                      <div class="bg-gray-50 p-4 rounded-lg">
                          <h4 class="text-sm font-medium text-gray-500">Total Budget</h4>
                          <p class="mt-2 text-3xl font-semibold text-gray-900">${{ number_format($budgetData['total_budget'], 2) }}</p>
                      </div>
                      <div class="bg-gray-50 p-4 rounded-lg">
                          <h4 class="text-sm font-medium text-gray-500">Spent Amount</h4>
                          <p class="mt-2 text-3xl font-semibold text-red-600">${{ number_format($budgetData['spent_amount'], 2) }}</p>
                      </div>
                      <div class="bg-gray-50 p-4 rounded-lg">
                          <h4 class="text-sm font-medium text-gray-500">Remaining Budget</h4>
                          <p class="mt-2 text-3xl font-semibold text-green-600">${{ number_format($budgetData['remaining_budget'], 2) }}</p>
                      </div>
                  </div>

                  <!-- Budget Progress -->
                  <div class="mb-8">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Budget Utilization</h3>
                      <div class="bg-gray-200 rounded-full h-4">
                          @php
                              $utilizationPercentage = ($budgetData['spent_amount'] / $budgetData['total_budget']) * 100;
                              $barColor = $utilizationPercentage > 90 ? 'bg-red-600' : ($utilizationPercentage > 70 ? 'bg-yellow-600' : 'bg-green-600');
                          @endphp
                          <div class="{{ $barColor }} h-4 rounded-full" style="width: {{ min($utilizationPercentage, 100) }}%"></div>
                      </div>
                      <div class="mt-2 text-sm text-gray-600">
                          {{ number_format($utilizationPercentage, 1) }}% of budget utilized
                      </div>
                  </div>

                  <!-- Monthly Spending Chart -->
                  <div class="bg-white p-6 rounded-lg shadow mb-8">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Spending</h3>
                      <div class="h-96" id="monthlySpendingChart"></div>
                  </div>

                  <!-- Detailed Spending -->
                  <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Spent</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% of Total Budget</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @foreach($monthlySpending as $spending)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                          {{ \Carbon\Carbon::createFromFormat('Y-m', $spending->month)->format('F Y') }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          ${{ number_format($spending->total, 2) }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ number_format(($spending->total / $budgetData['total_budget']) * 100, 1) }}%
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm">
                                          @php
                                              $monthlyBudget = $budgetData['total_budget'] / 12;
                                              $status = $spending->total > $monthlyBudget * 1.1 ? 'Over Budget' : ($spending->total < $monthlyBudget * 0.9 ? 'Under Budget' : 'On Track');
                                              $statusColor = $status === 'Over Budget' ? 'red' : ($status === 'Under Budget' ? 'yellow' : 'green');
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
      const ctx = document.getElementById('monthlySpendingChart').getContext('2d');
      new Chart(ctx, {
          type: 'bar',
          data: {
              labels: @json($monthlySpending->pluck('month')->map(function($month) {
                  return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
              })),
              datasets: [{
                  label: 'Monthly Spending',
                  data: @json($monthlySpending->pluck('total')),
                  backgroundColor: 'rgb(59, 130, 246)',
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                  y: {
                      beginAtZero: true,
                      title: {
                          display: true,
                          text: 'Amount ($)'
                      }
                  }
              }
          }
      });
  </script>
  @endpush
</x-app-layout>