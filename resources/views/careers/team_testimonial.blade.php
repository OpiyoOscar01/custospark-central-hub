@php
$testimonials = [
  ['name' => 'Joyce A.', 'role' => 'Product Designer', 'quote' => 'Working at Custospark is like being in a creativity playground. I’m always encouraged to experiment and take bold ideas forward.', 'image' => 'https://randomuser.me/api/portraits/women/68.jpg'],
  ['name' => 'Daniel O.', 'role' => 'Backend Engineer', 'quote' => 'I joined for the tech, but stayed for the team spirit. Everyone here genuinely wants to build something meaningful.', 'image' => 'https://randomuser.me/api/portraits/men/52.jpg'],
  ['name' => 'Linda M.', 'role' => 'Marketing Strategist', 'quote' => 'The flexibility, the mentorship, and the belief in growth — that’s what makes this place home for me.', 'image' => 'https://randomuser.me/api/portraits/women/43.jpg'],
  ['name' => 'Michael K.', 'role' => 'Data Scientist', 'quote' => 'The opportunity to work with cutting-edge technologies while collaborating with a supportive team is what keeps me inspired every day.', 'image' => 'https://randomuser.me/api/portraits/men/20.jpg'],
  ['name' => 'Sarah J.', 'role' => 'HR Manager', 'quote' => 'It’s fulfilling to see how much Custospark values its employees and fosters a culture of respect, growth, and collaboration.', 'image' => 'https://randomuser.me/api/portraits/women/50.jpg'],
];
@endphp

<section id="team-testimonials" class="py-24 bg-gradient-to-br from-blue-500 via-black to-blue-500 text-white">
  <div class="max-w-4xl mx-auto px-6" x-data="testimonialSlider()" x-init="start()" @keydown.window.arrow-right="next()" @keydown.window.arrow-left="prev()">
    
    <!-- Header -->
    <div class="text-center mb-16">
      <h2 class="text-5xl sm:text-6xl font-extrabold tracking-tight drop-shadow-xl">
        💬 What Our Team Says
      </h2>
      <p class="text-xl mt-6 max-w-2xl mx-auto leading-relaxed text-white/80">
        At <span class="text-orange-300 font-semibold">Custospark</span>, our team is our greatest asset. Hear from the people who make innovation happen every day.
      </p>
    </div>

    <!-- Testimonial Slider -->
    <div class="relative h-72 sm:h-80 md:h-64" @mouseenter="stop()" @mouseleave="start()">
      <template x-for="(t, index) in testimonials" :key="index">
        <div
          x-show="currentIndex === index"
          x-transition:enter="transition ease-out duration-700"
          x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-500"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="absolute inset-0 flex flex-col items-center justify-center bg-white/10 backdrop-blur-md p-8 rounded-3xl shadow-xl border border-white/20 text-center transition-all duration-500"
        >
          <img :src="t.image" :alt="t.name" class="w-20 h-20 rounded-full object-cover border-4 border-pink-500 shadow-md mb-4" />
          <h4 class="text-xl font-bold text-white" x-text="t.name"></h4>
          <p class="text-sm text-orange-200 font-medium" x-text="t.role"></p>
          <p class="text-white/90 text-base italic leading-relaxed max-w-xl mt-4" x-text="`“${t.quote}”`"></p>
        </div>
      </template>
    </div>

    <!-- Dots -->
    <div class="flex justify-center mt-8 space-x-2">
      <template x-for="(t, index) in testimonials" :key="index">
        <button
          @click="currentIndex = index"
          :class="{'bg-white': currentIndex === index, 'bg-white/30': currentIndex !== index}"
          class="w-3 h-3 rounded-full transition duration-300"
        ></button>
      </template>
    </div>

    <!-- Controls -->
    <div class="flex justify-center gap-6 mt-12">
      <button
        @click="prev"
        class="px-6 py-3 rounded-full bg-pink-600 hover:bg-pink-700 text-white font-semibold shadow-md transition"
      >
        ← Previous
      </button>
      <button
        @click="next"
        class="px-6 py-3 rounded-full bg-pink-600 hover:bg-pink-700 text-white font-semibold shadow-md transition"
      >
        Next →
      </button>
    </div>
  </div>
</section>

<!-- Alpine.js logic -->
<script>
  function testimonialSlider() {
    return {
      currentIndex: 0,
      interval: null,
      testimonials: @json($testimonials),
      start() {
        this.interval = setInterval(() => this.next(), 3000);
      },
      stop() {
        clearInterval(this.interval);
      },
      next() {
        this.currentIndex = (this.currentIndex + 1) % this.testimonials.length;
      },
      prev() {
        this.currentIndex =
          (this.currentIndex - 1 + this.testimonials.length) % this.testimonials.length;
      },
    };
  }
</script>

<!-- Alpine.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
