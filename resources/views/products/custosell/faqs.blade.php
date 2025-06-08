<section id="faqs" class="py-20 bg-gradient-to-bl from-blue-500 via-pink-800 to-blue-500 text-white">
  <div class="max-w-5xl mx-auto px-6">
    <!-- Section Header -->
    <div class="text-center mb-12">
      <h2 class="text-4xl sm:text-5xl font-bold">Frequently Asked Questions</h2>
      <p class="text-lg sm:text-xl mt-4 text-gray-200 max-w-2xl mx-auto">
        Get quick answers to common questions about Custosell’s features, accounts, and business tools.
      </p>
    </div>

    <!-- FAQ List -->
    <div class="space-y-6">
      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Can I use one account for multiple businesses?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes! With Custosell, you can register and manage multiple businesses under one account. You can easily switch between them without logging out.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Can I act as both a buyer and seller on the platform?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Absolutely. Your account supports both roles, allowing you to shop from other businesses and sell your own products or services simultaneously.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Is Custosell suitable for restaurants, schools, and travel agencies?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes. Custosell supports a wide range of business types. Restaurants can manage menus, travel agencies can manage routes, and schools can handle enrollments and more.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Do I need technical skills to use Custosell?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Not at all. Custosell is designed to be user-friendly and intuitive. If you can use a smartphone or web browser, you can manage your business on Custosell.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          What types of businesses can use Custosell?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Custosell is perfect for businesses of all sizes, from solo entrepreneurs to large enterprises, across various industries like retail, food, education, travel, and more.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Can I integrate Custosell with third-party apps?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes, Custosell allows integration with third-party apps and APIs, making it customizable for your business needs.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Is there any limit to the number of products I can list on Custosell?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          No, there are no product limits. You can list as many products or services as your business requires.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Can I track sales and analytics on Custosell?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes! Custosell provides built-in analytics to track sales, customer data, and business performance, helping you make informed decisions.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Does Custosell support inventory management?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes, Custosell has a built-in inventory management system for businesses like restaurants, retail, and others to track stock levels and manage supplies.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Can I accept payments online with Custosell?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes, Custosell supports secure online payments, enabling your customers to make purchases seamlessly through various payment gateways.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          How secure is my business data on Custosell?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          We prioritize security with advanced encryption and strict data protection protocols to ensure your business and customer information is safe.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Is there customer support available for Custosell?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes, Custosell offers dedicated customer support to help you with any issues, from technical assistance to account inquiries.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Can I customize the design of my business page?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes, Custosell allows you to customize your business page to match your branding, including logos, colors, and product displays.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Does Custosell offer mobile access?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Yes, Custosell is fully optimized for mobile use, allowing you to manage your business on the go.
        </div>
      </div>

      <!-- FAQ Item -->
      <div x-data="{ open: false }" class="border-b pb-4">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left text-lg font-medium text-white hover:text-gray-200 transition-all duration-300">
          Is Custosell free to use?
          <span x-show="!open">+</span>
          <span x-show="open">−</span>
        </button>
        <div x-show="open" x-collapse class="mt-2 text-gray-300">
          Custosell offers a range of pricing plans to cater to businesses of all sizes. While there is a free tier, advanced features may require a subscription.
        </div>
      </div>
    </div>
  </div>
</section>
