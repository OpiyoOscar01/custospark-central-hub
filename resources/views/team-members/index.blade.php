<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Team Members
          </h2>
          <a href="{{ route('team-members.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
              Add Team Member
          </a>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6">
                  <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                                  <th scope="col" class="relative px-6 py-3">
                                      <span class="sr-only">Actions</span>
                                  </th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @foreach($teamMembers as $member)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="flex items-center">
                                              <div class="flex-shrink-0 h-10 w-10">
                                                  <span class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700">
                                                      {{ strtoupper(substr($member->user->name, 0, 2)) }}
                                                  </span>
                                              </div>
                                              <div class="ml-4">
                                                  <div class="text-sm font-medium text-gray-900">
                                                      {{ $member->user->name }}
                                                  </div>
                                                  <div class="text-sm text-gray-500">
                                                      {{ $member->user->email }}
                                                  </div>
                                              </div>
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{ $member->project->name }}</div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                              {{ $member->role }}
                                          </span>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          {{ $member->assigned_date->format('M d, Y') }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                          <a href="{{ route('team-members.show', $member) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                          <a href="{{ route('team-members.edit', $member) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                          <form action="{{ route('team-members.destroy', $member) }}" method="POST" class="inline">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this team member?')">
                                                  Remove
                                              </button>
                                          </form>
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
</x-app-layout>