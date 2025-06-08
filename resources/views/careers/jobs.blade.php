@php
  use App\Models\CompanyJob;
  $jobs = CompanyJob::where('status', 'published')->latest()->get();
@endphp

<section id="open-roles" class="relative py-28 bg-gradient-to-bl from-blue-500 via-black to-blue-500 text-white overflow-hidden">
  <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(circle_at_20%_20%,_rgba(255,255,255,0.2),_transparent_40%),_radial-gradient(circle_at_80%_80%,_rgba(255,255,255,0.15),_transparent_40%)] blur-3xl"></div>

  <div class="relative z-10 max-w-7xl mx-auto px-6">
    <!-- Header -->
    <div class="text-center mb-20">
      <h2 class="text-5xl font-extrabold tracking-tight text-white drop-shadow-xl">Join Our Team</h2>
      <p class="text-lg mt-5 max-w-2xl mx-auto text-white/80 leading-relaxed">
        Explore current roles and take the next step in your journey. Become part of <span class="text-yellow-300 font-semibold">Custospark</span>'s innovation wave.
      </p>
      <!-- See How to Apply Button -->
      <div class="mt-6">
        <a href="#application-process" 
           class="inline-block bg-white text-black font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-blue-200 transition duration-300">
          <i class="bi bi-info-circle-fill mr-2"></i>See How to Apply
        </a>
      </div>
    </div>

    @if ($jobs->count())
      <!-- Job Listings Grid -->
      <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($jobs as $job)
          @php
            $tags = explode(',', $job->type);
            $colors = [
              'Remote' => 'green',
              'Full-Time' => 'blue',
              'Internship' => 'pink',
              'On-Site' => 'purple',
            ];
            $requirements = preg_split('/\r\n|\r|\n/', $job->requirements);
          @endphp

          <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:scale-[1.015] transition-transform duration-300 flex flex-col justify-between">
            
            <!-- Job Title -->
            <div>
              <h3 class="text-2xl font-bold text-white mb-1">
                <i class="bi bi-briefcase-fill mr-1 text-white/80"></i>{{ $job->title }}
              </h3>
              <p class="text-sm text-white/80">{{ $job->description }}</p>
            </div>

            <!-- Tags -->
            <div class="mt-4 flex flex-wrap gap-2">
              @foreach ($tags as $tag)
                @php $tag = trim($tag); @endphp
                <span class="bg-{{ $colors[$tag] ?? 'gray' }}-100/90 text-{{ $colors[$tag] ?? 'gray' }}-800 text-xs font-medium px-3 py-1 rounded-full">
                  <i class="bi bi-tag-fill mr-1"></i>{{ $tag }}
                </span>
              @endforeach
              <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">
                <i class="bi bi-calendar-event mr-1"></i>Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
              </span>
              <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-3 py-1 rounded-full">
                <i class="bi bi-people-fill mr-1"></i>{{ $job->positions_available }} Position{{ $job->positions_available > 1 ? 's' : '' }}
              </span>
            </div>

            <!-- Requirements -->
            <ul class="mt-4 list-disc list-inside text-sm text-white/90 space-y-1">
              @foreach ($requirements as $requirement)
                <li><i class="bi bi-check-circle-fill text-green-400 mr-1"></i>{{ $requirement }}</li>
              @endforeach
            </ul>

            <!-- CTA Button -->
            <div class="mt-6 text-center">
              {{-- <a href="{{ route('application_form') }}" --}}
             <a href="{{ route('application.proceed', ['job_id' => $job->id]) }}"
              class="inline-block bg-white text-blue-500 font-bold text-sm px-6 py-2.5 rounded-lg shadow-md hover:bg-blue-500 hover:text-white transition duration-300">
              <i class="bi bi-send-fill mr-1"></i>Apply Now
            </a>

            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center text-white/80 text-lg font-medium">
        <i class="bi bi-info-circle-fill text-white mr-2"></i>No open roles available at the moment. Please check back later.
      </div>
    @endif
  </div>
</section>



