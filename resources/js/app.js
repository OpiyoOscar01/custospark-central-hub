// Import Bootstrap
import './bootstrap';

// Import Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Import the country dataset
import { countries } from 'world-countries';

// Event Listener for DOM Content Load
document.addEventListener('DOMContentLoaded', () => {
  const countrySelect = document.getElementById('country');

  // Verify if the <select> element exists
  if (countrySelect) {
    // Add a default placeholder option
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Select a Country';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    countrySelect.appendChild(defaultOption);

    // Populate the dropdown with country names
    countries.forEach(country => {
      const option = document.createElement('option');
      option.value = country.name;
      option.textContent = country.name;
      countrySelect.appendChild(option);
    });
  } else {
    console.error("The #country element was not found in the DOM.");
  }
});
