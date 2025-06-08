<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Reports
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Project Burndown -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-900">Project Burndown</h3>
                          <a href="{{ route('reports.project-burndown', ['project' => 1]) }}" class="text-sm text-indigo-600 hover:text-indigo-900">View Report</a>
                      </div>
                      <p class="text-sm text-gray-500">Track project progress against ideal burndown rate and identify potential delays or bottlenecks.</p>
                      <div class="mt-4">
                          <form action="{{ route('reports.project-burndown', ['project' => 1]) }}" method="GET" class="space-y-4">
                              <div>
                                  <label for="project" class="block text-sm font-medium text-gray-700">Select Project</label>
                                  <select id="project" name="project" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                      @foreach($projects as $project)
                                          <option value="{{ $project->id }}">{{ $project->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="flex justify-end">
                                  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                      Generate Report
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>

              <!-- Resource Utilization -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-900">Resource Utilization</h3>
                          <a href="{{ route('reports.resource-utilization') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View Report</a>
                      </div>
                      <p class="text-sm text-gray-500">Analyze team member workload and resource allocation across projects.</p>
                      <div class="mt-4">
                          <form action="{{ route('reports.resource-utilization') }}" method="GET" class="space-y-4">
                              <div class="grid grid-cols-2 gap-4">
                                  <div>
                                      <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                      <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                  </div>
                                  <div>
                                      <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                      <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                  </div>
                              </div>
                              <div class="flex justify-end">
                                  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                      Generate Report
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>

              <!-- Cost Tracking -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-900">Cost Tracking</h3>
                          <a href="{{ route('reports.cost-tracking', ['project' => 1]) }}" class="text-sm text-indigo-600 hover:text-indigo-900">View Report</a>
                      </div>
                      <p class="text-sm text-gray-500">Monitor project costs, budget utilization, and financial performance.</p>
                      <div class="mt-4">
                          <form action="{{ route('reports.cost-tracking', ['project' => 1]) }}" method="GET" class="space-y-4">
                              <div>
                                  <label for="project_cost" class="block text-sm font-medium text-gray-700">Select Project</label>
                                  <select id="project_cost" name="project" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                      @foreach($projects as $project)
                                          <option value="{{ $project->id }}">{{ $project->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="flex justify-end">
                                  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                      Generate Report
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>

              <!-- Team Performance -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <div class="p-6">
                      <div class="flex items-center justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-900">Team Performance</h3>
                          <a href="{{ route('reports.team-performance') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View Report</a>
                      </div>
                      <p class="text-sm text-gray-500">Evaluate team productivity, task completion rates, and individual performance metrics.</p>
                      <div class="mt-4">
                          <form action="{{ route('reports.team-performance') }}" method="GET" class="space-y-4">
                              <div class="grid grid-cols-2 gap-4">
                                  <div>
                                      <label for="start_date_team" class="block text-sm font-medium text-gray-700">Start Date</label>
                                      <input type="date" name="start_date" id="start_date_team" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                  </div>
                                  <div>
                                      <label for="end_date_team" class="block text-sm font-medium text-gray-700">End Date</label>
                                      <input type="date" name="end_date" id="end_date_team" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                  </div>
                              </div>
                              <div class="flex justify-end">
                                  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                      Generate Report
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>