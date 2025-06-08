<section id="blog" class="py-20 bg-gradient-to-l from-blue-900 to-blue-500" data-aos="fade-up">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-white mb-4">Blog & Content Hub</h2>
    <p class="mb-12 text-gray-200">Insights, trends, and expert advice to drive your business forward.</p>
    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3" id="blogPostsContainer">
      <!-- Blog posts will be injected here dynamically -->
    </div>
    <!-- Pagination or Infinite Scroll -->
    <div class="mt-10 text-center">
      <button id="loadMore" class="bg-blue-900 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition duration-300">Load More</button>
    </div>
  </div>
</section>

<script>
  // Wait until the DOM content is fully loaded
  document.addEventListener('DOMContentLoaded', function() {
    // Example Blog Post Data (Using remote images from Unsplash)
    const blogPosts = [
      {
        title: "How AI is Transforming SaaS for Entrepreneurs",
        description: "Explore how AI-powered tools are revolutionizing the SaaS industry and empowering entrepreneurs to scale their businesses faster.",
        image: "https://images.pexels.com/photos/8728223/pexels-photo-8728223.jpeg?auto=compress&cs=tinysrgb&w=600", 
        link: "#",
        date: "March 29, 2025"
      },
      {
        title: "5 Trends Shaping the Future of Software Development",
        description: "Stay ahead of the curve with the top software development trends that are driving the future of technology and innovation.",
        image: "https://images.pexels.com/photos/10508800/pexels-photo-10508800.jpeg?auto=compress&cs=tinysrgb&w=600",  
        link: "#",
        date: "March 15, 2025"
      },
      {
        title: "Building a Scalable SaaS Business: Lessons from Custosell",
        description: "Learn the key lessons and strategies we used to build Custosell into a scalable SaaS platform for businesses of all sizes.",
        image: "https://images.pexels.com/photos/7947968/pexels-photo-7947968.jpeg?auto=compress&cs=tinysrgb&w=600", 
        link: "#",
        date: "February 25, 2025"
      },
      // 
    ];

    const container = document.getElementById('blogPostsContainer');

    // Function to render blog posts
    function renderBlogPosts() {
      container.innerHTML = '';  // Clear the container before adding new posts
      blogPosts.forEach(post => {
        const postHTML = `
          <div class="bg-white p-6 rounded shadow-md transition hover:shadow-xl">
            <img src="${post.image}?w=500&h=300&fit=crop" alt="${post.title}" class="mb-4 rounded-lg w-full h-48 object-cover">
            <h3 class="font-bold text-blue-900">${post.title}</h3>
            <p class="mt-2 text-gray-600">${post.description}</p>
            <a href="${post.link}" class="mt-2 inline-block text-orange-500 hover:underline font-semibold">Read More</a>
          </div>
        `;
        container.insertAdjacentHTML('beforeend', postHTML);
      });
    }

    // Initial rendering of blog posts
    renderBlogPosts();
    
    // Event listener for "Load More" button
    document.getElementById('loadMore').addEventListener('click', () => {
      // Example logic to add more posts (could be replaced with an API call or pagination)
      const additionalPosts = [
        {
          title: "New Strategies for Scaling SaaS Businesses",
          description: "Explore the latest strategies to scale your SaaS business effectively.",
          image: "https://images.unsplash.com/photo-1502020076495-2c67b859eb5b",  // Example image from Unsplash
          link: "/blog/scaling-saas-strategies",
          date: "April 1, 2025"
        },
        // Add more blog posts to load here...
      ];
      
      blogPosts.push(...additionalPosts);  // Add new posts to the blog posts array
      renderBlogPosts();  // Re-render the blog posts with the new posts
    });
  });
</script>

<style>
  #blog {
    background: linear-gradient(to right, #1e3a8a, #4338ca, #7e22ce);
  }

  .bg-white {
    background-color: #ffffff;
  }

  .text-blue-900 {
    color: #1e3a8a;
  }

  .text-orange-500 {
    color: #fb923c;
  }

  .transition {
    transition: all 0.3s ease;
  }

  .hover\:shadow-xl:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  }
</style>
