<section id="faqs" class="py-20 bg-gradient-to-bl from-blue-500 via-black to-blue-500">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Header -->
    <div class="text-center mb-12">
      <h2 class="text-5xl font-bold text-white">❓ Frequently Asked Questions</h2>
      <p class="text-xl text-gray-100 mt-6 max-w-3xl mx-auto leading-relaxed">
        Curious about life at <span class="text-yellow-300 font-semibold">Custospark</span>? We’ve gathered the answers to the most common questions right here.
      </p>
    </div>

    <!-- FAQs Accordion -->
    <div class="space-y-6">
      @php
      $faqs = [
        [
          'question' => 'Can I work remotely at Custospark?',
          'answer' => 'Absolutely. We’re a remote-first company that values trust and flexibility. Work from wherever you feel most inspired and productive.',
        ],
        [
          'question' => 'Do you offer internships or entry-level positions?',
          'answer' => 'Yes! We welcome early-career talent across engineering, design, marketing, and operations. It’s a great place to start and grow.',
        ],
        [
          'question' => 'What’s the hiring process like?',
          'answer' => 'Our process includes a quick screening, a task-based challenge, and a final interview. It’s designed to be efficient and fair, usually lasting 1–2 weeks.',
        ],
        [
          'question' => 'What kind of growth opportunities are available?',
          'answer' => 'From mentorship to project leadership, we offer clear paths for growth. We also provide learning budgets and recognize high performance with promotions.',
        ],
        [
          'question' => 'What benefits and perks do you provide?',
          'answer' => 'Flexible hours, remote work, wellness stipends, paid time off, equity options, retreats, and a whole lot of good vibes.',
        ],
        [
          'question' => 'What is Custospark’s mission and vision?',
          'answer' => 'Our mission is to transform how businesses scale using technology. Our vision is To build Africa’s most impactful tech-driven ecosystem.',
        ],
        [
          'question' => 'Do I need to be based in Uganda to apply?',
          'answer' => 'Nope. We hire globally. As long as you can collaborate remotely and align with our values, we’d love to hear from you.',
        ],
        [
          'question' => 'How often will I interact with the team?',
          'answer' => 'We connect through weekly standups, async tools like Trello and Git, and monthly all-hands. Communication is at the heart of how we work.',
        ],
        [
          'question' => 'Is there a probation period?',
          'answer' => 'Yes. We have a 3-month probation period to help both sides ensure it’s the right fit. You’ll receive regular feedback and support.',
        ],
        [
          'question' => 'What’s your approach to work-life balance?',
          'answer' => 'We believe great work comes from happy humans. Our culture promotes autonomy, wellness, and balance over burnout.',
        ],
      ];
      @endphp

      @foreach ($faqs as $index => $faq)
        <div
          x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }"
          class="rounded-2xl border border-white/20 backdrop-blur-lg bg-white/10 p-6 shadow-xl transition-all duration-300 hover:scale-[1.02] {{ $index % 2 === 0 ? 'bg-gradient-to-bl from-white/10 via-white/5 to-white/10' : 'bg-gradient-to-br from-white/10 via-white/5 to-white/10' }}"
        >
          <!-- FAQ Question -->
          <button @click="open = !open" class="flex items-center justify-between w-full text-left">
            <h3 class="text-xl font-semibold text-white">{{ $faq['question'] }}</h3>
            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-yellow-300 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- FAQ Answer -->
          <div x-show="open" x-transition class="mt-4 text-gray-100 leading-relaxed text-base">
            {{ $faq['answer'] }}
          </div>
        </div>
      @endforeach
    </div>

    <!-- CTA -->
    <div class="mt-16 text-center">
      <a href="#open-roles" class="inline-block bg-black text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-blue-500 transition-transform transform hover:scale-105 shadow-lg">
        Alright. Start your application now →
      </a>
    </div>
  </div>
</section>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
