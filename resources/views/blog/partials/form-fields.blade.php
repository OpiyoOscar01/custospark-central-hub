<!-- Title -->
<div>
    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
    <input type="text" name="title" id="title" 
           class="mt-1 block w-full rounded-lg border-gray-400 p-5 shadow-sm focus:ring-blue-500 focus:border-blue-500"
           value="{{ old('title', $post->title ?? '') }}" required>
    @error('title')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Category -->
<div>
    <label for="category_id" class="block text-sm font-medium text-gray-800">Category</label>
    <select name="category_id" id="category_id" 
            class="mt-1 block w-full rounded-lg border-black-400 p-5 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">Select a category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" 
                {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Content -->
<div>
    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
    <textarea name="content" id="content" rows="10" 
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
              required>{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Featured Image -->
<div>
    <label for="featured_image" class="block text-sm font-medium text-gray-700">Featured Image</label>
    @if(isset($post) && $post->featured_image)
        <div class="mt-2 mb-4">
            <img src="{{ asset($post->featured_image) }}" alt="Current featured image" class="h-32 w-auto rounded-lg">
        </div>
    @endif
    <input type="file" name="featured_image" id="featured_image" 
           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
    @error('featured_image')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Status -->
<div>
    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
    <select name="status" id="status" 
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
    </select>
    @error('status')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Publication Date (Conditional) -->
<div id="publication_date_wrapper" class="hidden">
    <label for="publication_date" class="block text-sm font-medium text-gray-700 mt-4">Publication Date</label>
    <input type="datetime-local" name="published_at" id="publication_date" 
           value="{{ old('published_at', $post->publication_date ?? '') }}"
           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    @error('publication_date')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Script to Toggle Publication Date Field -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.getElementById('status');
        const pubDateWrapper = document.getElementById('publication_date_wrapper');
        const pubDateInput = document.getElementById('publication_date');

        function togglePublicationDate() {
            if (statusSelect.value === 'published') {
                pubDateWrapper.classList.remove('hidden');
                pubDateInput.setAttribute('required', 'required');
            } else {
                pubDateWrapper.classList.add('hidden');
                pubDateInput.removeAttribute('required');
                pubDateInput.value = '';
            }
        }

        togglePublicationDate();
        statusSelect.addEventListener('change', togglePublicationDate);
    });
</script>
