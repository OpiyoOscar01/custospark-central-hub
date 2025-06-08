@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <!-- Breadcrumb for super-admin -->
    @hasAppRole(['super-admin'],'custospark')
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('jobs.index') }}" class="hover:text-gray-700">Jobs</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('jobs.show', $job) }}" class="hover:text-gray-700">{{ $job->title }}</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Apply</span>
    </nav>
    @endhasAppRole
        @hasAppRole(['admin','normal-user'],'custospark')

    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-blue-500">
        <a href="{{ route('jobs.listings') }}" class="hover:text-blue-700">Explore all Jobs</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Apply</span>
    </nav>
    @endhasAppRole


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Application Form -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-xl border border-gray-200">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                            <i class="bi bi-send text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Apply for Position <span class="text-blue-500"> {{$job->title}}.</span></h1>
                            <p class="mt-1 text-sm text-gray-500">{{ $job->department }} • {{ $job->location }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                  <form action="{{ route('applications.store', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf

    <!-- Personal Information -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-person text-blue-600"></i>
            Personal Information
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', auth()->check() ? auth()->user()->last_name . ' ' . auth()->user()->first_name : '') }}"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    readonly
                >
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    readonly
                >
            </div>

            <input name="company_job_id" value="{{ $job->id }}" type="hidden" />

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', auth()->check() ? auth()->user()->phone ?? 'Not Provided.Update this field by updating your profile under settings.' : '') }}"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    readonly
                >
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Role -->
            <div>
                <label for="current_role" class="block text-sm font-medium text-gray-700 mb-1">Current Role</label>
                <input
                    type="text"
                    id="current_role"
                    name="current_role"
                    value="{{ old('current_role') }}"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="e.g., Software Engineer"
                    required
                >
                @error('current_role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Resume Upload -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-file-earmark-text text-blue-600"></i>
            Resume
        </h2>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Resume
                </label>

                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <i class="bi bi-cloud-arrow-up text-gray-400 text-2xl"></i>

                        <div class="flex text-sm text-gray-600 justify-center">
                            <label
                                for="resume"
                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500"
                            >
                                <span>Upload a file</span>
                                <input
                                    id="resume"
                                    name="resume"
                                    type="file"
                                    class="sr-only"
                                    accept=".pdf,.doc,.docx"
                                    required
                                >
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>

                        <p id="resume-file-name" class="text-sm text-blue-700 mt-2 hidden"></p>
                        <p class="text-xs text-blue-500">PDF or Word, up to 5MB</p>
                    </div>
                </div>

                @error('resume')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <script>
            document.getElementById('resume').addEventListener('change', function (e) {
                const fileName = e.target.files[0]?.name;
                const fileNameDisplay = document.getElementById('resume-file-name');

                if (fileName) {
                    fileNameDisplay.textContent = `Selected file: ${fileName}`;
                    fileNameDisplay.classList.remove('hidden');
                } else {
                    fileNameDisplay.classList.add('hidden');
                    fileNameDisplay.textContent = '';
                }
            });
        </script>
    </div>

    <!-- Cover Letter -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-file-earmark-arrow-up text-blue-600"></i>
            Upload Cover Letter
        </h2>

        <div>
            <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">
                Upload your cover letter (PDF, DOCX)
            </label>
            <input
                type="file"
                id="cover_letter"
                name="cover_letter"
                accept=".pdf,.doc,.docx"
                class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0 file:text-sm file:font-semibold
                       file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                       border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required
            >
            @error('cover_letter')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Additional Questions -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-question-circle text-blue-600"></i>
            Additional Questions
        </h2>

        <div class="space-y-6">
            <!-- Experience -->
            <div>
                <label for="years_of_experience" class="block text-sm font-medium text-gray-700 mb-1">
                    Years of relevant experience
                </label>
                <select
                    id="years_of_experience"
                    name="years_of_experience"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
                    <option value="">Select experience</option>
                    <option value="0-1" {{ old('years_of_experience') == '0-1' ? 'selected' : '' }}>0-1 years</option>
                    <option value="1-3" {{ old('years_of_experience') == '1-3' ? 'selected' : '' }}>1-3 years</option>
                    <option value="3-5" {{ old('years_of_experience') == '3-5' ? 'selected' : '' }}>3-5 years</option>
                    <option value="5-10" {{ old('years_of_experience') == '5-10' ? 'selected' : '' }}>5-10 years</option>
                    <option value="10+" {{ old('years_of_experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                </select>
                @error('years_of_experience')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notice Period -->
            <div>
                <label for="notice_period" class="block text-sm font-medium text-gray-700 mb-1">
                    Notice period at current employer
                </label>
                <select
                    id="notice_period"
                    name="notice_period"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
                    <option value="">Select notice period</option>
                    <option value="immediate" {{ old('notice_period') == 'immediate' ? 'selected' : '' }}>Available Immediately</option>
                    <option value="1_week" {{ old('notice_period') == '1_week' ? 'selected' : '' }}>1 Week</option>
                    <option value="2_weeks" {{ old('notice_period') == '2_weeks' ? 'selected' : '' }}>2 Weeks</option>
                    <option value="1_month" {{ old('notice_period') == '1_month' ? 'selected' : '' }}>1 Month</option>
                    <option value="2_months" {{ old('notice_period') == '2_months' ? 'selected' : '' }}>2 Months</option>
                    <option value="more_than_2_months" {{ old('notice_period') == 'more_than_2_months' ? 'selected' : '' }}>More than 2 Months</option>
                </select>
                @error('notice_period')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Salary -->
            <div>
                <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Current Salary (USD)</label>
                <input
                    type="number"
                    id="salary"
                    name="salary"
                    value="{{ old('salary') }}"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Approximate gross monthly salary"
                    required
                    min="0"
                >
                @error('salary')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div>
            <button
            type="submit"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
            id="submit-button"
        >
            <i class="bi bi-send-fill mr-2"></i> Submit Application
        </button>

    </div>
</form>

<script>
    // File size limit in bytes (5MB)
    const maxFileSize = 5 * 1024 * 1024;

    // Update resume file name display
    document.getElementById('resume').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const fileNameDisplay = document.getElementById('resume-file-name');

        if (file) {
            if (file.size > maxFileSize) {
                alert("Resume file size must be less than 5MB.");
                e.target.value = ''; // Clear file input
                fileNameDisplay.classList.add('hidden');
                fileNameDisplay.textContent = '';
                return;
            }

            fileNameDisplay.textContent = `Selected file: ${file.name}`;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameDisplay.classList.add('hidden');
            fileNameDisplay.textContent = '';
        }
    });

    // Validate cover letter file size on change
    document.getElementById('cover_letter').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > maxFileSize) {
            alert("Cover letter file size must be less than 5MB.");
            e.target.value = '';
        }
    });

    // Prevent double submission and show loading spinner
    document.querySelector('form').addEventListener('submit', function (e) {
        const resume = document.getElementById('resume').files[0];
        const cover = document.getElementById('cover_letter').files[0];

        if ((resume && resume.size > maxFileSize) || (cover && cover.size > maxFileSize)) {
            e.preventDefault();
            alert("Files must be under 5MB.");
            return;
        }

        const submitBtn = document.getElementById('submit-button');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split animate-spin mr-2"></i>Submitting...';
    });
</script>

                </div>
            </div>
        </div>

        <!-- Job Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-lg rounded-xl border border-gray-200 p-6 sticky top-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Position Summary</h2>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Department</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $job->department }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Location</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $job->location }}
                            @if($job->is_remote)
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Remote
                                </span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Employment Type</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ Str::title(str_replace('_', ' ', $job->type)) }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Experience Level</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $job->experience_level }}</p>
                    </div>

                    @if($job->salary_min || $job->salary_max)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Salary Range</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ $job->salary_currency }}
                                {{ number_format($job->salary_min) }}
                                @if($job->salary_max)
                                    - {{ number_format($job->salary_max) }}
                                @endif
                                <span class="text-gray-500">/year</span>
                            </p>
                        </div>
                    @endif

                    @if($job->deadline)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Application Deadline</h3>
                            <p class="mt-1 text-sm {{ Carbon\Carbon::parse($job->deadline)->isPast() ? 'text-red-600' : 'text-gray-600' }}">
                                {{ Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
                                @if(!Carbon\Carbon::parse($job->deadline)->isPast())
                                    <span class="text-gray-500">({{ Carbon\Carbon::parse($job->deadline)->diffForHumans() }})</span>
                                @endif
                            </p>
                        </div>
                    @endif

                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Positions Available</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $job->positions_available }}</p>
                    </div>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="text-sm text-gray-500">
                    <p>Need help? Contact our recruitment team at</p>
                    <a href="mailto:support@custospark.com" class="text-blue-600 hover:text-blue-700">hr@custospark.com</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection