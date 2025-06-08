@extends('layouts.employee')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex items-center space-x-2 text-sm text-gray-500">
        <a href="#" class="hover:text-gray-700">Feedback</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Submit Feedback</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                    <i class="bi bi-chat-dots text-blue-600 text-xl"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-900">
    We genuinely value your feedback — it helps us serve you better.</h1>

            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Feedback Type -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-ui-checks text-blue-600"></i>
                        Feedback Type
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $types = [
                                'feature_request' => ['icon' => 'bi-lightbulb', 'label' => 'Feature Request'],
                                'complaint' => ['icon' => 'bi-exclamation-triangle', 'label' => 'Complaint'],
                                'bug_report' => ['icon' => 'bi-bug', 'label' => 'Bug Report'],
                                'general_comment' => ['icon' => 'bi-chat-left-dots', 'label' => 'General Comment'],
                            ];
                        @endphp

                        @foreach($types as $value => $data)
                            <label class="flex items-center gap-3 bg-white border border-gray-300 rounded-lg p-3 cursor-pointer hover:border-blue-400">
                                <input type="radio" name="type" value="{{ $value }}"
                                    class="form-radio text-blue-600 focus:ring-blue-500"
                                    {{ old('type') == $value ? 'checked' : '' }}
                                    onchange="toggleComplaintSection(this.value)">
                                <i class="bi {{ $data['icon'] }} text-blue-600 text-lg"></i>
                                <span class="text-sm font-medium text-gray-700">{{ $data['label'] }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Complaint Sub-Type -->
                <div id="complaint-section" class="bg-gray-50 rounded-xl p-6 border border-gray-200 hidden">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-exclamation-diamond text-red-600"></i>
                        Complaint Category
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php
                            $complaintCategories = [
                                'service_quality' => 'Service Quality',
                                'delayed_response' => 'Delayed Response',
                                'unprofessional_behavior' => 'Unprofessional Behavior',
                                'system_error' => 'System Error',
                            ];
                        @endphp

                        @foreach($complaintCategories as $key => $label)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="complaint_categories[]" value="{{ $key }}"
                                    class="form-checkbox text-red-500 focus:ring-red-500"
                                    {{ in_array($key, old('complaint_categories', [])) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Hidden Inputs -->
                <input type="hidden" name="source" value="{{ $source }}">
                <input type="hidden" name="user_id" value="{{ $userId }}">
                <input type="hidden" name="app_id" value="{{ $app->id}}">

                <!-- Message -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-pencil-square text-blue-600"></i>
                        Message
                    </h2>

                    <textarea name="message" id="message" rows="5"
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              placeholder="Describe your feedback here..." required>{{ old('message') }}</textarea>

                    @error('message')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-paperclip text-blue-600"></i>
                        Attachments (optional)
                    </h2>

                    <input type="file" name="attachments[]" multiple
                           class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0 file:text-sm file:font-semibold
                           file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                    @error('attachments.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ url()->previous() }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="bi bi-x-lg mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="bi bi-send-fill mr-2"></i>
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleComplaintSection(value) {
        const section = document.getElementById('complaint-section');
        if (value === 'complaint') {
            section.classList.remove('hidden');
        } else {
            section.classList.add('hidden');
        }
    }

    // Initialize on page load if old value was 'complaint'
    document.addEventListener('DOMContentLoaded', function () {
        const selectedType = document.querySelector('input[name="type"]:checked');
        if (selectedType && selectedType.value === 'complaint') {
            toggleComplaintSection('complaint');
        }
    });
</script>
@endsection
