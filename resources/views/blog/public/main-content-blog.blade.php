<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-full bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto">
      <h1 class="text-4xl font-extrabold text-gray-900 mb-2 text-center">
          Shared Knowledge & Experiences.
      </h1>
      <p class="text-lg text-gray-600 text-center mb-10">
          Discover what’s new in the community
      </p>
      

      <!-- Blog Posts -->
      <div class="space-y-10">
          @foreach($posts as $post)
              <article class="bg-white rounded-2xl overflow-hidden shadow-md transition duration-300 hover:shadow-xl border border-gray-200">
                  @if($post->featured_image)
                      <img src="{{ asset($post->featured_image) }}" 
                           alt="{{ $post->title }}" 
                           class="w-full h-60 object-cover hover:scale-[1.02] transition-transform duration-200 ease-in-out">
                  @endif
                  <div class="p-6 space-y-4">
                      <!-- Meta Info -->
                      <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                          <span>{{ $post->published_at->format('M d, Y') }}</span>
                          <span>•</span>
                          <a href="#" 
                             class="text-blue-600 hover:underline hover:text-blue-800">
                              {{ $post->category->name }}
                          </a>
                      </div>

                      <!-- Title -->
                      <h2 class="text-2xl font-semibold text-gray-900 leading-tight">
                          <a href="{{ route('blog.show', $post) }}" class="hover:text-blue-600 transition duration-150">
                              {{ $post->title }}
                          </a>
                      </h2>


                      <!-- Excerpt -->
                      <p class="text-gray-700 text-base leading-relaxed">
                          {{ $post->excerpt }}
                      </p>               

                   <!-- Footer -->
                    <div class="flex items-center justify-between pt-4">
                        <!-- Author -->
                        {{-- <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center text-sm font-bold text-white">
                                @if(!empty($post->author->avatar_url))
                                    <img 
                                        src="{{ $post->author->avatar_url 
                                            ? asset('storage/' . $post->author->avatar_url) 
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->first_name . ' ' . $post->author->last_name) }}" 
                                        alt="Author Photo" 
                                        class="h-10 w-10 rounded-full border border-gray-300 object-cover"
        >
                                @else
                                    {{ strtoupper(substr($post->author->first_name, 0, 1) . substr($post->author->last_name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $post->author->first_name }} {{ $post->author->last_name }}
                            </div>
                        </div> --}}

                        <!-- Read More -->
                        <a href="{{ route('blog.show', $post) }}" 
                        class="text-sm text-blue-600 font-medium hover:underline hover:text-blue-800 flex items-center gap-1">
                            Read more....
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" 
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>

                  </div>
              </article>
          @endforeach
      </div>

      <!-- Pagination -->
      @if($posts->hasPages())
          <div class="mt-12 text-center">
              {{ $posts->links() }}
          </div>
      @endif
  </div>
</div>