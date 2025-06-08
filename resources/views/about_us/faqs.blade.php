<!-- FAQ Section -->
<div data-aos="fade-up" class="section py-16 bg-gradient-to-bl from-blue-500 via-gray-900 to-blue-500 text-white" id="faq">
  <div class="container mx-auto px-6">
    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 flex justify-center items-center gap-3">
      <i class="bi bi-question-circle"></i>
      <span>Frequently Asked Questions</span>
    </h2>
    <p class="text-lg text-gray-200 leading-relaxed mx-auto max-w-2xl mb-10 flex justify-center items-center gap-2">
      <i class="bi bi-info-circle text-white"></i>
      <span>
        We've compiled the most common questions about Custospark, our cutting-edge solutions, and our dynamic partnership model.
        If you need further information, our team is always here to help!
      </span>
    </p>

    <!-- FAQ Accordion Container -->
    <div id="faq-container" class="max-w-3xl mx-auto space-y-4"></div>
  </div>
</div>

<!-- Add Bootstrap Icons and Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const faqs = [
      {
        question: "What is Custospark?",
        answer: "Custospark is a technology-driven company empowering entrepreneurs with innovative software solutions across industries like education, healthcare, logistics, and finance."
      },
      {
        question: "What is Custosell?",
        answer: "Custosell is our flagship product—a comprehensive eCommerce platform that enables businesses to manage online stores, sell products, and scale with ease."
      },
      {
        question: "Who can use Custosell?",
        answer: "Designed for entrepreneurs and business owners in any industry, Custosell is versatile enough for restaurants, retail, healthcare, education, and more."
      },
      {
        question: "How can I get started with Custosell?",
        answer: "Signing up is simple! Register, create your business profile, add products or services, and start selling. We also offer easy-to-follow tutorials to guide you."
      },
      {
        question: "Do I need technical skills to use Custosell?",
        answer: "Not at all. Our platform is crafted for simplicity, so even non-technical users can navigate and maximize its features. Plus, our support team is always available."
      },
      {
        question: "Can I manage multiple businesses on Custosell?",
        answer: "Yes. Custosell lets you seamlessly switch between different business profiles all from one account."
      },
      {
        question: "Is Custosell mobile-friendly?",
        answer: "Absolutely—our fully responsive design ensures access and functionality on desktops, tablets, or smartphones."
      },
      {
        question: "How secure is my data on Custosell?",
        answer: "We take your data security seriously, using industry-standard encryption and robust protocols to protect your information every step of the way."
      },
      {
        question: "Can I integrate third-party tools with Custosell?",
        answer: "Yes, we offer flexible integrations for payments, marketing, analytics, and more, so you can tailor Custosell perfectly to your business."
      },
      {
        question: "Does Custospark provide support?",
        answer: "Our dedicated support team is committed to your success; we're here to help if you encounter any issues or have questions along the way."
      },
      {
        question: "What is the cost of using Custosell?",
        answer: "Custosell offers various pricing plans to suit businesses of all sizes. Check out our pricing page for comprehensive information on our basic and premium packages."
      },
      {
        question: "How can I become a partner with Custospark?",
        answer: "We're excited to collaborate with like-minded innovators and investors. Contact us directly if you're interested in forging a partnership."
      },
      {
        question: "Does Custospark have a mobile app?",
        answer: "Currently, we are a web-based platform, but we’re actively developing mobile app solutions to enhance your experience even further."
      },
      {
        question: "How can I invest in Custospark?",
        answer: "If investing in Custospark interests you, please reach out to us via our contact page. We’re always open to discussing future growth and collaboration."
      },
      {
        question: "Where is Custospark located?",
        answer: "Headquartered in Kampala, Uganda, Custospark sits at the heart of Africa's burgeoning tech scene. We’re proud to operate as a remote-first, global company."
      },
      {
        question: "How do I contact Custospark's support team?",
        answer: "You can contact our support team via our contact page or directly through the help section on the platform. We're here to assist you!"
      },
      {
        question: "Can I try Custosell before purchasing?",
        answer: "Yes, we offer a free trial for Custosell so you can explore the features and see how it works for your business before committing to a plan."
      }
    ];

    const container = document.getElementById('faq-container');

    faqs.forEach((faq, index) => {
      const faqItem = document.createElement('div');
      faqItem.className = "faq-item bg-white rounded-lg shadow-md overflow-hidden";

      // FAQ Header
      const header = document.createElement('button');
      header.className = "faq-header w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none focus:ring focus:ring-blue-300 transition duration-300 ease-in-out transform hover:bg-blue-100";
      header.innerHTML = `
        <h3 class="text-2xl font-semibold text-gray-800">${faq.question}</h3>
        <i class="bi bi-chevron-down text-gray-600"></i>
      `;
      faqItem.appendChild(header);

      // FAQ Answer
      const answerContainer = document.createElement('div');
      answerContainer.className = "faq-answer px-6 py-4 border-t border-gray-200 hidden transition-all duration-300 ease-in-out opacity-0 max-h-0";
      answerContainer.innerHTML = `<p class="text-lg text-gray-700">${faq.answer}</p>`;
      faqItem.appendChild(answerContainer);

      // Toggle FAQ Item
      header.addEventListener('click', () => {
        const isExpanded = !answerContainer.classList.contains('hidden');

        // Close all open answers
        document.querySelectorAll('#faq-container .faq-answer').forEach(el => {
          el.classList.add('hidden');
          el.style.maxHeight = '0';
          el.style.opacity = '0';
          const icon = el.parentElement.querySelector('.bi-chevron-down');
          if (icon) icon.classList.remove('rotate-180');
        });

        // Open current answer
        if (!isExpanded) {
          answerContainer.classList.remove('hidden');
          answerContainer.style.maxHeight = '500px'; // adjust based on content
          answerContainer.style.opacity = '1';
          header.querySelector('.bi-chevron-down').classList.add('rotate-180');
        }
      });

      container.appendChild(faqItem);
    });
  });
</script>

