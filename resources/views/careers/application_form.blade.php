@php
$jobs = [
    [
        'title' => 'Frontend Developer',
    ],
    [
        'title' => 'Backend Developer',
    ],
    [
        'title' => 'Full Stack Developer',
    ],
    [
        'title' => 'Product Manager',
    ],
    [
        'title' => 'UX/UI Designer',
    ],
    [
        'title' => 'Marketing Specialist',
    ],
    [
        'title' => 'Graphic Designer',
    ],
    [
        'title' => 'Data Scientist',
    ],
    [
        'title' => 'DevOps Engineer',
    ],
    [
        'title' => 'Quality Assurance Engineer',
    ],
    [
        'title' => 'Content Strategist',
    ],
    [
        'title' => 'Customer Support Specialist',
    ],
];
@endphp



{{-- Application Form Section --}}

<section id="apply-now" class="py-20 bg-gradient-to-br from-blue-500 via-black to-blue-500">
  <div class="max-w-4xl mx-auto px-6">
    <!-- Header -->
    <div class="text-center mb-12">
      <h5 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-white to-white">
        Join Our Team and Shape the Future!
      </h5>
      <p class="text-white mt-4 text-lg">
        We're thrilled to have you here! Your unique skills and passion could be exactly what we’re looking for. Fill out the form below, and let’s build something amazing together!
      </p>
      <p class="text-white mt-2 text-md italic">
        Your journey to making a difference starts now.
      </p>
    </div>

  <!-- Application Form -->
<form action="{{ route('application_success') }}" method="GET" enctype="multipart/form-data"
      class="bg-white shadow-2xl rounded-2xl p-8 space-y-6">
  @csrf

  <!-- Full Name -->
  <div>
    <label for="name" class="block font-medium text-gray-700">Full Name</label>
    <div class="relative mt-2">
      <i class="bi bi-person absolute left-3 top-3.5 text-gray-500"></i>
      <input type="text" name="name" id="name" required
             class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400">
    </div>
  </div>

  <!-- Email -->
  <div>
    <label for="email" class="block font-medium text-gray-700">Email Address</label>
    <div class="relative mt-2">
      <i class="bi bi-envelope absolute left-3 top-3.5 text-gray-500"></i>
      <input type="email" name="email" id="email" required
             class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-400">
    </div>
  </div>

  <!-- Position Selection -->
  <div>
    <label for="position" class="block font-medium text-gray-700">Select Position</label>
    <div class="relative mt-2">
      <i class="bi bi-briefcase absolute left-3 top-3.5 text-gray-500"></i>
      <select name="position" id="position" required onchange="toggleOtherInput(this)"
              class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-400">
        @foreach ($jobs as $job)
          <option value="{{ $job['title'] }}">{{ $job['title'] }}</option>
        @endforeach
        <option value="Other">Other</option>
      </select>
    </div>
  </div>

  <!-- Custom Title -->
  <div id="other-position-field" style="display: none;">
    <label for="custom_title" class="block font-medium text-gray-700">Enter Desired Role Title</label>
    <div class="relative mt-2">
      <i class="bi bi-pencil-square absolute left-3 top-3.5 text-gray-500"></i>
      <input type="text" name="custom_title" id="custom_title"
             class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300">
    </div>
  </div>

  <!-- Resume Upload -->
  <div>
    <label for="resume" class="block font-medium text-gray-700">Upload Resume (PDF)</label>
    <div class="relative mt-2">
      <i class="bi bi-paperclip absolute left-3 top-3.5 text-gray-500"></i>
      <input type="file" name="resume" id="resume" accept=".pdf" required
             class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
    </div>
  </div>

  <!-- Optional Message -->
  <div>
    <label for="message" class="block font-medium text-gray-700">Optional Message</label>
    <div class="relative mt-2">
      <i class="bi bi-chat-left-dots absolute left-3 top-3.5 text-gray-500"></i>
      <textarea name="message" id="message" rows="4"
                class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300"></textarea>
    </div>
  </div>

  <!-- Submit Button -->
  <div class="text-center">
    <button type="submit"
            class="bg-gradient-to-r from-blue-500 to-black text-white font-semibold px-8 py-3 rounded-full hover:from-black hover:to-blue-500 transition duration-300 shadow-lg">
      <i class="bi bi-send-fill mr-2"></i>Submit Application
    </button>
  </div>
</form>

  </div>

  <!-- Toggle Script -->

  <script>
    function toggleOtherInput(select) {
      const otherField = document.getElementById('other-position-field');
      otherField.style.display = select.value === 'Other' ? 'block' : 'none';
    }

    // Populate the country dropdown with country list
    // document.addEventListener('DOMContentLoaded', function() {
    //   const countries = [
    //     'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Australia', 'Austria', 
    //     'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 
    //     'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cabo Verde', 
    //     'Cambodia', 'Cameroon', 'Canada', 'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 
    //     'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Democratic Republic of the Congo', 'Denmark', 'Djibouti', 'Dominica', 
    //     'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia', 
    //     'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 
    //     'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 
    //     'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea, North', 
    //     'Korea, South', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 
    //     'Lithuania', 'Luxembourg', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 
    //     'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 
    //     'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 
    //     'Nigeria', 'North Macedonia', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 
    //     'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 
    //     'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 
    //     'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Sudan', 
    //     'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 
    //     'Thailand', 'Timor-Leste', 'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 
    //     'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 
    //     'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
    //   ];

      const countrySelect = document.getElementById('country');
      countries.forEach(country => {
        const option = document.createElement('option');
        option.value = country;
        option.textContent = country;
        countrySelect.appendChild(option);
      });
    });
  </script>
</section>
