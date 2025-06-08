@extends('layouts.employee')

@section('content')
<div class="py-2 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('consultations.index') }}" class="hover:text-gray-700">Consultations</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-gray-900">Edit</span>
    </nav>

    <!-- Edit Form Card -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-200 mt-4">
        <div class="p-6 border-b border-gray-200 flex items-center gap-3">
            <div class="bg-blue-100 p-2 rounded-lg border border-blue-200">
                <i class="bi bi-pencil-square text-blue-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Consultation</h1>
                <p class="text-sm text-gray-500">{{ $consultation->full_name }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('consultations.update', $consultation->id) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @foreach(['pending', 'scheduled', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $consultation->status) === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

               
            </div>

            <!-- Actions -->
            <div class="flex justify-end pt-6 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                    <i class="bi bi-save mr-2"></i> Update Consultation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
