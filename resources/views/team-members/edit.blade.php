<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Edit Team Member
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="p-6">
                  <form action="{{ route('team-members.update', $teamMember) }}" method="POST" class="space-y-6">
                      @csrf
                      @method('PUT')

                      <div>
                          <x-label value="Team Member" />
                          <div class="mt-1 block w-full text-gray-700">
                              {{ $teamMember->user->name }}
                          </div>
                      </div>

                      <div>
                          <x-label value="Project" />
                          <div class="mt-1 block w-full text-gray-700">
                              {{ $teamMember->project->name }}
                          </div>
                      </div>

                      <div>
                          <x-label for="role" value="Role" />
                          <x-input id="role" type="text" name="role" :value="old('role', $teamMember->role)" required class="mt-1 block w-full" />
                          <x-input-error for="role" class="mt-2" />
                      </div>

                      <div>
                          <x-label for="assigned_date" value="Assignment Date" />
                          <x-input id="assigned_date" type="date" name="assigned_date" :value="old('assigned_date', $teamMember->assigned_date->format('Y-m-d'))" required class="mt-1 block w-full" />
                          <x-input-error for="assigned_date" class="mt-2" />
                      </div>

                      <div class="flex items-center justify-end mt-4">
                          <x-button class="ml-4">
                              Update Team Member
                          </x-button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>