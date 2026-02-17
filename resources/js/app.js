import axios from 'axios';
import './bootstrap';
import showCookieBanner from './cookieConsent';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
  showCookieBanner();
  const initSlider = () => {
    const slides = document.querySelectorAll(".hero-slide");
    let currentIndex = 0; // Track the current slide
    const totalSlides = slides.length;

    function moveToSlide(n) {
      slides.forEach((slide, index) => {
        slide.style.transform = `translateX(${-100 * n}%)`;
        if (n === index) {
          slide.classList.add("active");
        } else {
          slide.classList.remove("active");
        }
      });
      currentIndex = n;
    }

    // Function to go to the next slide
    function nextSlide() {
      if (currentIndex === totalSlides - 1) {
        moveToSlide(0); // Go to the first slide if we're at the last
      } else {
        moveToSlide(currentIndex + 1);
      }
    }

    // Function to go to the previous slide
    function prevSlide() {
      if (currentIndex === 0) {
        moveToSlide(totalSlides - 1); // Go to the last slide if we're at the first
      } else {
        moveToSlide(currentIndex - 1);
      }
    }

    // Example usage with buttons
    // Assuming you have buttons with classes `.next` and `.prev` for navigation
    const carouselNextButton = document.querySelector(".hero-slide-next");
    if (carouselNextButton) {
      carouselNextButton.addEventListener("click", nextSlide);
    }
    const carouselPrevButton = document.querySelector(".hero-slide-prev");
    if (carouselPrevButton) {
      carouselPrevButton.addEventListener("click", prevSlide);
    }

    // Initialize the slider
    moveToSlide(0);
  };

  const initImagePicker = () => {
    const fileInput = document.querySelector("#carFormImageUpload");
    const imagePreview = document.querySelector("#imagePreviews");
    let selectedFiles = [];

    if (!fileInput) {
      return;
    }

    fileInput.onchange = (ev) => {
      const newFiles = Array.from(ev.target.files);
      selectedFiles = selectedFiles.concat(newFiles);
      updatePreview();
    };

    function updatePreview() {
      imagePreview.innerHTML = "";
      selectedFiles.forEach((file, index) => {
        readFile(file).then((url) => {
          const img = createImage(url, index);
          imagePreview.append(img);
        });
      });
    }

    function createImage(url, index) {
      const container = document.createElement("div");
      container.classList.add("car-form-image-preview", "relative", "inline-block", "mr-2", "mb-2");

      const img = document.createElement("img");
      img.src = url;
      img.classList.add("w-20", "h-20", "object-cover", "rounded-lg", "border", "border-gray-300");

      const removeBtn = document.createElement("button");
      removeBtn.type = "button";
      removeBtn.classList.add("absolute", "-top-2", "-right-2", "w-6", "h-6", "bg-red-500", "text-white", "rounded-full", "flex", "items-center", "justify-center", "text-xs", "hover:bg-red-600", "transition-colors");
      removeBtn.innerHTML = "×";
      removeBtn.onclick = () => {
        selectedFiles.splice(index, 1);
        updatePreview();
        updateFileInput();
      };

      container.appendChild(img);
      container.appendChild(removeBtn);

      return container;
    }

    function updateFileInput() {
      // Create a new DataTransfer object to update the file input
      const dt = new DataTransfer();
      selectedFiles.forEach(file => {
        dt.items.add(file);
      });
      fileInput.files = dt.files;
    }

    function readFile(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (ev) => {
          resolve(ev.target.result);
        };
        reader.onerror = (ev) => {
          reject(ev);
        };
        reader.readAsDataURL(file);
      });
    }
  };

  const imageCarousel = () => {
    const carousel = document.querySelector('.car-images-carousel');
    if (!carousel) {
      return;
    }
    const thumbnails = document.querySelectorAll('.car-image-thumbnails img');
    const activeImage = document.getElementById('activeImage');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');


    let currentIndex = 0;

    // Initialize active thumbnail class
    thumbnails.forEach((thumbnail, index) => {
      if (thumbnail.src === activeImage.src) {
        thumbnail.classList.add('active-thumbnail');
        currentIndex = index;
      }
    });

    // Function to update the active image and thumbnail
    const updateActiveImage = (index) => {
      activeImage.src = thumbnails[index].src;
      thumbnails.forEach(thumbnail => thumbnail.classList.remove('active-thumbnail'));
      thumbnails[index].classList.add('active-thumbnail');
    };

    // Add click event listeners to thumbnails
    thumbnails.forEach((thumbnail, index) => {
      thumbnail.addEventListener('click', () => {
        currentIndex = index;
        updateActiveImage(currentIndex);
      });
    });

    // Add click event listener to the previous button
    prevButton.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
      updateActiveImage(currentIndex);
    });

    // Add click event listener to the next button
    nextButton.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % thumbnails.length;
      updateActiveImage(currentIndex);
    });
  }

  const initMobileFilters = () => {
    const filterButton = document.querySelector('.show-filters-button');
    const sidebar = document.querySelector('.search-cars-sidebar');
    const closeButton = document.querySelector('.close-filters-button');

    if (!filterButton) return;

    console.log(filterButton.classList)
    filterButton.addEventListener('click', () => {
      if (sidebar.classList.contains('opened')) {
        sidebar.classList.remove('opened')
      } else {
        sidebar.classList.add('opened')
      }
    });

    if (closeButton) {
      closeButton.addEventListener('click', () => {
        sidebar.classList.remove('opened')
      })
    }
  }

  const initCascadingDropdown = (parentSelector, childSelector) => {
    const parentDropdown = document.querySelector(parentSelector);
    const childDropdown = document.querySelector(childSelector);

    if (!parentDropdown || !childDropdown) return;

    hideModelOptions(parentDropdown.value)

    parentDropdown.addEventListener('change', (ev) => {
      hideModelOptions(ev.target.value)
      childDropdown.value = ''
    });

    function hideModelOptions(parentValue) {
      const models = childDropdown.querySelectorAll('option');
      models.forEach(model => {
        if (model.dataset.parent === parentValue || model.value === '') {
          model.style.display = 'block';
        } else {
          model.style.display = 'none';
        }
      });
    }
  }

  const initSortingDropdown = () => {
    const sortingDropdown = document.querySelector('.sort-dropdown');
    if (!sortingDropdown) return;

    // Init sorting dropdown with the current value
    const url = new URL(window.location.href);
    const sortValue = url.searchParams.get('sort');
    if (sortValue) {
      sortingDropdown.value = sortValue;
    }

    sortingDropdown.addEventListener('change', (ev) => {
      const url = new URL(window.location.href);
      url.searchParams.set('sort', ev.target.value);
      window.location.href = url.toString();
    });
  }

  const initAddToWatchlist = () => {
    // Select add to watchlist buttons
    const buttons = document.querySelectorAll('.btn-heart, .watchlist-btn');

    // Iterate over these buttons and add click event listener
    buttons.forEach((button) => {
      button.addEventListener('click', ev => {
        ev.preventDefault();
        // Get the button element on which click happened
        const button = ev.currentTarget;
        // We added data-url attribute to the button in blade file
        // get the url
        const url = button.dataset.url;

        if (!url) {
          console.error('No URL found for watchlist button');
          return;
        }

        // Make request on the URL to add or remove the car from watchlist
        axios.post(url).then((response) => {
          // Select both svg tags of the button
          const toShow = button.querySelector('svg.hidden');
          const toHide = button.querySelector('svg:not(.hidden)');

          if (toShow && toHide) {
            // Which was hidden must be displayed
            toShow.classList.remove('hidden')
            // Which was displayed must be hidden
            toHide.classList.add('hidden')
          } else {
            // For new component: toggle fill and color
            const svg = button.querySelector('svg');
            if (response.data.added) {
              button.classList.remove('text-gray-400', 'hover:text-red-500');
              button.classList.add('text-red-500');
              svg.setAttribute('fill', 'currentColor');
            } else {
              button.classList.remove('text-red-500');
              button.classList.add('text-gray-400', 'hover:text-red-500');
              svg.setAttribute('fill', 'none');
            }
          }

          // Show alert to the user (optional)
          // alert(response.data.message)
        }).catch((error) => {
          if (error.response?.status === 401) {
            // Redirect to login if not authenticated
            window.location.href = '/login';
          } else {
            console.error('Watchlist error:', error);
          }
        });
      });
    });
  };

  const initShowPhoneNumber = () => {
    // Select the element we need to listen to click
    const span = document.querySelector('.car-details-phone-view');
    if (!span) return;
    span.addEventListener('click', ev => {
      ev.preventDefault();
      // Get the url on which we should make Ajax request
      const url = span.dataset.url;

      // Make the request
      axios.post(url).then(response => {
        // Get response from backend and take actual phone number
        const phone = response.data.phone;
        // Find the <a> element
        const a = span.parentElement;
        // and update its href attribute with full phone number received from backend
        a.href = 'tel:' + phone;
        // Find the element which contains obfuscated text and update it
        const phoneEl = a.querySelector('.text-phone')
        phoneEl.innerText = phone;
      })
    })
  }

  initSlider();
  initImagePicker();
  imageCarousel();
  initMobileFilters();
  initCascadingDropdown('#makerSelect', '#modelSelect');
  initCascadingDropdown('#stateSelect', '#citySelect');
  initSortingDropdown()
  initAddToWatchlist()
  initShowPhoneNumber()

  ScrollReveal().reveal(".hero-slide.active .hero-slider-title", {
    delay: 200,
    reset: true,
  });
  ScrollReveal().reveal(".hero-slide.active .hero-slider-content", {
    delay: 200,
    origin: "bottom",
    distance: "50%",
  });
});
