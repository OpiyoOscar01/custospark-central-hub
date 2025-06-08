<!-- Location Section -->
<div data-aos="fade-up" class="section py-16 bg-gradient-to-bl from-blue-500 via-black to-blue-500 text-white relative overflow-hidden" id="location">
  <div class="absolute inset-0 bg-white/10 backdrop-blur-md rounded-xl shadow-lg"></div>
  
  <div class="container mx-auto px-6 relative z-10">
    <!-- Title Section -->
    <h2 class="text-4xl font-extrabold text-white mb-6 flex justify-center items-center gap-3 hover:scale-105 transition-transform duration-300">
      <i class="fas fa-map-marker-alt text-yellow-400"></i> Our Location
    </h2>
  
    <!-- Content Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
      <!-- Description Section -->
      <div>
        <p class="text-lg text-gray-200 leading-relaxed bg-white/5 backdrop-blur-md p-4 rounded-lg shadow-xl hover:shadow-2xl transition duration-300">
          <i class="fas fa-map-signs text-white mr-2"></i>
          We're headquartered in <strong>Kampala, Uganda</strong>, at the heart of Africa’s burgeoning tech scene. As a strategic hub, we’re positioned to tap into the immense growth potential of the African market—one of the most dynamic and untapped regions globally.
        </p>
  
        <p class="text-lg text-gray-200 leading-relaxed mt-6 bg-white/5 backdrop-blur-md p-4 rounded-lg shadow-xl hover:shadow-2xl transition duration-300">
          <i class="fas fa-users text-white mr-2"></i>
          Custospark operates as a **remote-first** company with a global, diverse team. We are leveraging cutting-edge technology and global collaboration to scale rapidly and meet our clients' needs worldwide.
        </p>
  
        <p class="text-lg text-gray-200 leading-relaxed mt-6 font-semibold bg-white/5 backdrop-blur-md p-4 rounded-lg shadow-xl hover:shadow-2xl transition duration-300">
          <i class="fas fa-globe-americas text-white mr-2"></i>
          Whether you’re an investor looking to partner with a fast-growing company or a collaborator seeking innovative tech solutions, **Custospark is here for you**. Let’s join forces to make a global impact.
        </p>
      </div>
  
      <!-- Map Section -->
      <div class="relative">
        <div id="map" style="height: 450px; border-radius: 12px; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);"></div>
      </div>
    </div>
  </div>
  
</div>

<!-- Include Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
  // Initialize the map
  var map = L.map('map').setView([0.3136, 32.5811], 13); // Coordinates for Kampala, Uganda

  // Set up the OpenStreetMap tile layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 19,
  }).addTo(map);

  // Add a marker for the location
  var marker = L.marker([0.3136, 32.5811]).addTo(map);
  marker.bindPopup("<b>Custospark Headquarters</b><br>Kampala, Uganda").openPopup();
</script>
