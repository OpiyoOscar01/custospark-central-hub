<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Team Member Details
          </h2>
          <div class="flex space-x-4">
              <a href="{{ route('team-members.edit', $teamMember) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500">
                  Edit
              </a>
              <form action="{{ route('team-members.destroy', $teamMember) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Are you sure you want to remove this team member?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                      Remove
                  </button>
              </form>
          </div>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <!-- Member Information -->
                      <div>
                          <h3 class="text-lg font-medium text-gray-900 mb-4">Member Information</h3>
                          <dl class="grid grid-cols-1 gap-4">
                              <div>
                                  <dt class="text-sm font-medium text-gray-500">Name</dt>
                                  <dd class="mt-1 text-sm text-gray-900">{{ $teamMember->user->name }}</dd>
                              </div>
                              <div>
                                  <dt class="text-sm font-medium text-gray-500">Email</dt>
                                  <dd class="mt-1 text-sm text-gray-900">{{ $teamMember->user->email }}</dd>
                              </div>
                              <div>
                                  <dt class="text-sm font-medium text-gray-500">Role</dt>
                                  <dd class="mt-1 text-sm text-gray-900">{{ $teamMember->role }}</dd>
                              </div>
                              <div>
                                  <dt class="text-sm font-medium text-gray-500">Assigned Date</dt>
                                  <dd class="mt-1 text-sm text-gray-900">{{ $teamMember->assigned_date->format('M d, Y') }}</dd>
                              </div>
                          </dl>
                      </div>

                      <!-- Project Information -->
                      <div>
                          <h3 class="text-lg font-medium text-gray-900 mb-4">Project Information</h3>
                          <dl class="grid grid-cols-1 gap-4">
                              <div>
                                  <dt class="text-sm font-medium text-gray-500">Project Name</dt>
                                  <dd class="mt-1 text-sm text-gray-900">{{ $teamMember->project->name }}</dd>
                              </div>
                              <div>
                                  <dt class="text-sm font-medium text-gray-500">Project Status</dt>
                                  <dd class="mt-1">
                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                          @if($teamMember->project->status === 'completed') bg-green-100 text-green-800
                                          @elseif($teamMember->project->status === 'in_progress') bg-blue-100 text-blue-800
                                          @elseif($teamMember->project->status === 'on_hold') bg-yellow-100 text-yellow-800
                                          @else bg-gray-100 text-gray-800 @endif">
                                          {{ ucfirst(str_replace('_', ' ', $teamMember->project->status)) }}
                                      </span>
                                  </dd>
                              </div>
                              <div>
                                  <dt class="text-sm font-medium text-gray-500">Project Timeline</dt>
                                  <dd class="mt-1 text-sm text-gray-900">
                                      {{ $teamMember->project->start_date->format('M d, Y') }} - 
                                      {{ $teamMember->project->end_date->format('M d, Y') }}
                                  </dd>
                              </div>
                          </dl>
                      </div>
                  </div>

                  <!-- Assigned Tasks -->
                  <div class="mt-8">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Assigned Tasks</h3>
                      <div class="overflow-x-auto">
                          <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                  <tr>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                      <th scope="col" class="relative px-6 py-3">
                                          <span class="sr-only">Actions</span>
                                      </th>
                                  </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                  @forelse($teamMember->user->assignedTasks->where('project_id', $teamMember->project_id) as $task)
                                      <tr>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                  @if($task->status === 'completed') bg-green-100 text-green-800
                                                  @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                                  @elseif($task->status === 'on_hold') bg-yellow-100 text-yellow-800
                                                  @else bg-gray-100 text-gray-800 @endif">
                                                  {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                              </span>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                  @if($task->priority === 'urgent') bg-red-100 text-red-800
                                                  @elseif($task->priority === 'high') bg-orange-100 text-orange-800
                                                  @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                                  @else bg-green-100 text-green-800 @endif">
                                                  {{ ucfirst($task->priority) }}
                                              </span>
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                              {{ $task->due_date->format('M d, Y') }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                              <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                          </td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                              No tasks assigned yet.
                                          </td>
                                      </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>