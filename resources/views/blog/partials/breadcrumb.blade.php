<nav class="mb-4 flex flex-col sm:flex-row sm:items-center sm:space-x-2 text-sm text-gray-500 space-y-1 sm:space-y-0">
  <div class="flex items-center space-x-2">
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    <i class="bi bi-chevron-right text-xs"></i>
  </div>
  <div class="flex items-center space-x-2">
    <a href="{{ route('blog.index') }}" class="hover:text-gray-700">Blog Management</a>
    <i class="bi bi-chevron-right text-xs"></i>
  </div>
  <div class="flex items-center">
    <span class="text-gray-900">{{ $title }}</span>
  </div>
</nav>
