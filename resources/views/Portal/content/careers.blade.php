@extends('Portal.partials.main')

@section('title', 'Jobs Management')
@section('description', 'Manage job postings and opportunities')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manage Jobs</h2>
      <p class="text-sm text-gray-500 dark:text-gray-400">Post and manage job opportunities</p>
    </div>
    
    <div id="alertContainer" class="hidden w-full text-sm rounded-lg p-4"></div>
    
    <button id="openJobForm" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow transition">
      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Post New CompanyJob
    </button>
  </div>

  <!-- CompanyJob Form Modal -->
  <div id="jobFormModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white" id="formTitle">Post New CompanyJob</h3>
        <button id="closeJobForm" class="text-gray-400 hover:text-gray-500">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <form id="jobForm" class="space-y-4">
        <input type="hidden" id="jobId" name="jobId">
        
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">CompanyJob Title</label>
          <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
          <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">CompanyJob Type</label>
            <select id="type" name="type" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="Full-Time">Full-Time</option>
              <option value="Part-Time">Part-Time</option>
              <option value="Contract">Contract</option>
              <option value="Internship">Internship</option>
              <option value="Remote">Remote</option>
              <option value="On-Site">On-Site</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Positions</label>
            <input type="number" id="positions" name="positions" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Application Deadline</label>
          <input type="date" id="deadline" name="deadline" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requirements</label>
          <div id="requirementsList" class="space-y-2">
            <div class="flex gap-2">
              <input type="text" name="requirements[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <button type="button" class="add-requirement px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">+</button>
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-2">
          <button type="button" id="cancelJobForm" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save CompanyJob</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Jobs List -->
  <div class="bg-white dark:bg-gray-900 shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Positions</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deadline</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700" id="jobsTableBody">
        @forelse($jobs as $job)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $job->title }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex flex-wrap gap-1">
              @foreach($job->type as $type)
              <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">{{ $type }}</span>
              @endforeach
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
            {{ $job->positions }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
            {{ $job->deadline }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <button class="text-indigo-600 hover:text-indigo-900 mr-3 view-job" data-id="{{ $job->id }}">View</button>
            <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-job" data-id="{{ $job->id }}">Edit</button>
            <button class="text-red-600 hover:text-red-900 delete-job" data-id="{{ $job->id }}">Delete</button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No jobs available.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const jobFormModal = document.getElementById('jobFormModal');
  const jobForm = document.getElementById('jobForm');
  const openJobFormBtn = document.getElementById('openJobForm');
  const closeJobFormBtn = document.getElementById('closeJobForm');
  const cancelJobFormBtn = document.getElementById('cancelJobForm');
  const alertContainer = document.getElementById('alertContainer');

  function showAlert(message, type = 'error') {
    alertContainer.className = `${type === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'} w-full text-sm rounded-lg p-4`;
    alertContainer.textContent = message;
    alertContainer.classList.remove('hidden');
    setTimeout(() => alertContainer.classList.add('hidden'), 50000);
  }

  function resetForm() {
    jobForm.reset();
    document.getElementById('jobId').value = '';
    document.getElementById('formTitle').textContent = 'Post New CompanyJob';
    const requirementsList = document.getElementById('requirementsList');
    requirementsList.innerHTML = `
      <div class="flex gap-2">
        <input type="text" name="requirements[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <button type="button" class="add-requirement px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">+</button>
      </div>
    `;
  }

  function closeModal() {
    jobFormModal.classList.add('hidden');
    resetForm();
  }

  openJobFormBtn.addEventListener('click', () => {
    jobFormModal.classList.remove('hidden');
    resetForm();
  });

  closeJobFormBtn.addEventListener('click', closeModal);
  cancelJobFormBtn.addEventListener('click', closeModal);

  // Handle requirements fields
  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('add-requirement')) {
      const requirementsList = document.getElementById('requirementsList');
      const newField = document.createElement('div');
      newField.className = 'flex gap-2';
      newField.innerHTML = `
        <input type="text" name="requirements[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <button type="button" class="remove-requirement px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">-</button>
      `;
      requirementsList.appendChild(newField);
    } else if (e.target.classList.contains('remove-requirement')) {
      e.target.parentElement.remove();
    }
  });

  // Form submission
  jobForm.addEventListener('submit', async (e) => {
    const formData = new FormData(jobForm);
    const jobId = formData.get('jobId');
    
    // Convert FormData to JSON
    const data = {
      title: formData.get('title'),
      description: formData.get('description'),
      type: Array.from(document.getElementById('type').selectedOptions).map(option => option.value),
      positions: parseInt(formData.get('positions')),
      deadline: formData.get('deadline'),
      requirements: Array.from(formData.getAll('requirements[]')).filter(req => req.trim() !== '')
    };

    try {
      const response = await fetch(jobId ? `/careers/${jobId}` : '/careers', {
        method: jobId ? 'PUT' : 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || 'Failed to save job');
      }

      closeModal();
      window.location.reload();
    } catch (error) {
      showAlert(error.message);
    }
  });

  // Edit job
  document.querySelectorAll('.edit-job').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      const jobId = e.target.dataset.id;
      try {
        const response = await fetch(`/careers/${jobId}`);
        if (!response.ok) throw new Error('Failed to fetch job details');
        
        const job = await response.json();
        document.getElementById('jobId').value = job.id;
        document.getElementById('title').value = job.title;
        document.getElementById('description').value = job.description;
        document.getElementById('positions').value = job.positions;
        document.getElementById('deadline').value = job.deadline;
        
        // Set job types
        const typeSelect = document.getElementById('type');
        Array.from(typeSelect.options).forEach(option => {
          option.selected = job.type.includes(option.value);
        });

        // Set requirements
        const requirementsList = document.getElementById('requirementsList');
        requirementsList.innerHTML = '';
        job.requirements.forEach((req, index) => {
          const field = document.createElement('div');
          field.className = 'flex gap-2';
          field.innerHTML = `
            <input type="text" name="requirements[]" value="${req}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            ${index === 0 ? 
              `<button type="button" class="add-requirement px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">+</button>` :
              `<button type="button" class="remove-requirement px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">-</button>`
            }
          `;
          requirementsList.appendChild(field);
        });

        document.getElementById('formTitle').textContent = 'Edit CompanyJob';
        jobFormModal.classList.remove('hidden');
      } catch (error) {
        showAlert('Failed to load job details');
      }
    });
  });

  // Delete job
  document.querySelectorAll('.delete-job').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      if (confirm('Are you sure you want to delete this job?')) {
        const jobId = e.target.dataset.id;
        try {
          const response = await fetch(`/careers/${jobId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
          });

          if (!response.ok) throw new Error('Failed to delete job');
          window.location.reload();
        } catch (error) {
          showAlert('Failed to delete job');
        }
      }
    });
  });

  // View job details
  document.querySelectorAll('.view-job').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      const jobId = e.target.dataset.id;
      try {
        const response = await fetch(`/careers/${jobId}`);
        if (!response.ok) throw new Error('Failed to fetch job details');
        
        const job = await response.json();
        const detailsHtml = `
          <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">${job.title}</h3>
                <button class="close-details text-gray-400 hover:text-gray-500">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>
              <div class="space-y-4">
                <div>
                  <h4 class="font-medium text-gray-700 dark:text-gray-300">Description</h4>
                  <p class="text-gray-600 dark:text-gray-400">${job.description}</p>
                </div>
                <div>
                  <h4 class="font-medium text-gray-700 dark:text-gray-300">CompanyJob Type</h4>
                  <div class="flex flex-wrap gap-2">
                    ${job.type.map(type => `
                      <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">${type}</span>
                    `).join('')}
                  </div>
                </div>
                <div>
                  <h4 class="font-medium text-gray-700 dark:text-gray-300">Requirements</h4>
                  <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                    ${job.requirements.map(req => `<li>${req}</li>`).join('')}
                  </ul>
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <h4 class="font-medium text-gray-700 dark:text-gray-300">Positions</h4>
                    <p class="text-gray-600 dark:text-gray-400">${job.positions}</p>
                  </div>
                  <div>
                    <h4 class="font-medium text-gray-700 dark:text-gray-300">Deadline</h4>
                    <p class="text-gray-600 dark:text-gray-400">${job.deadline}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', detailsHtml);
        
        document.querySelector('.close-details').addEventListener('click', () => {
          document.body.removeChild(document.body.lastChild);
        });
      } catch (error) {
        showAlert('Failed to load job details');
      }
    });
  });
});
</script>
@endsection