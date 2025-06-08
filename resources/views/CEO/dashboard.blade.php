<!-- Stats Overview -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
  <!-- Revenue Overview -->
  <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
      <div class="p-5">
          <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                  <div class="bg-green-100 text-green-600 rounded-xl p-3 border border-green-200">
                      <i class="bi bi-graph-up-arrow text-2xl"></i>
                  </div>
              </div>
              <div class="flex-1">
                  <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Revenue (YTD)</dt>
                      <dd class="mt-1 text-2xl font-bold text-gray-900">$2.4M</dd>
                      <dd class="mt-1 text-sm text-green-600">+15% from last year</dd>
                  </dl>
              </div>
          </div>
      </div>
      <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
          <div class="text-sm">
              <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                  View financial reports
                  <i class="bi bi-arrow-right ml-2"></i>
              </a>
          </div>
      </div>
  </div>

  <!-- Project Performance -->
  <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
      <div class="p-5">
          <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                  <div class="bg-indigo-100 text-indigo-600 rounded-xl p-3 border border-indigo-200">
                      <i class="bi bi-folder-check text-2xl"></i>
                  </div>
              </div>
              <div class="flex-1">
                  <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Active Projects</dt>
                      <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $totalProjects }}</dd>
                      <dd class="mt-1 text-sm text-indigo-600">85% on track</dd>
                  </dl>
              </div>
          </div>
      </div>
      <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
          <div class="text-sm">
              <a href="{{ route('projects.index') }}" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                  View project portfolio
                  <i class="bi bi-arrow-right ml-2"></i>
              </a>
          </div>
      </div>
  </div>

  <!-- Client Satisfaction -->
  <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
      <div class="p-5">
          <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                  <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3 border border-yellow-200">
                      <i class="bi bi-star-fill text-2xl"></i>
                  </div>
              </div>
              <div class="flex-1">
                  <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Client Satisfaction</dt>
                      <dd class="mt-1 text-2xl font-bold text-gray-900">94%</dd>
                      <dd class="mt-1 text-sm text-yellow-600">+2% this quarter</dd>
                  </dl>
              </div>
          </div>
      </div>
      <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
          <div class="text-sm">
              <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                  View client feedback
                  <i class="bi bi-arrow-right ml-2"></i>
              </a>
          </div>
      </div>
  </div>

  <!-- Team Performance -->
  <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
      <div class="p-5">
          <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                  <div class="bg-blue-100 text-blue-600 rounded-xl p-3 border border-blue-200">
                      <i class="bi bi-people-fill text-2xl"></i>
                  </div>
              </div>
              <div class="flex-1">
                  <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Team Productivity</dt>
                      <dd class="mt-1 text-2xl font-bold text-gray-900">92%</dd>
                      <dd class="mt-1 text-sm text-blue-600">+5% this month</dd>
                  </dl>
              </div>
          </div>
      </div>
      <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
          <div class="text-sm">
              <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                  View team analytics
                  <i class="bi bi-arrow-right ml-2"></i>
              </a>
          </div>
      </div>
  </div>

  <!-- Market Growth -->
  <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
      <div class="p-5">
          <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                  <div class="bg-purple-100 text-purple-600 rounded-xl p-3 border border-purple-200">
                      <i class="bi bi-graph-up text-2xl"></i>
                  </div>
              </div>
              <div class="flex-1">
                  <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Market Growth</dt>
                      <dd class="mt-1 text-2xl font-bold text-gray-900">18%</dd>
                      <dd class="mt-1 text-sm text-purple-600">Above industry avg.</dd>
                  </dl>
              </div>
          </div>
      </div>
      <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
          <div class="text-sm">
              <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                  View market analysis
                  <i class="bi bi-arrow-right ml-2"></i>
              </a>
          </div>
      </div>
  </div>

  <!-- Resource Utilization -->
  <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
      <div class="p-5">
          <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                  <div class="bg-teal-100 text-teal-600 rounded-xl p-3 border border-teal-200">
                      <i class="bi bi-gear-fill text-2xl"></i>
                  </div>
              </div>
              <div class="flex-1">
                  <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Resource Utilization</dt>
                      <dd class="mt-1 text-2xl font-bold text-gray-900">87%</dd>
                      <dd class="mt-1 text-sm text-teal-600">Optimal efficiency</dd>
                  </dl>
              </div>
          </div>
      </div>
      <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
          <div class="text-sm">
              <a href="#" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                  View resource details
                  <i class="bi bi-arrow-right ml-2"></i>
              </a>
          </div>
      </div>
  </div>
</div>