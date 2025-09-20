document.addEventListener("DOMContentLoaded", () => {
  const mobileMenuToggle = document.querySelector(".mobile-menu-toggle");
  const mobileNav = document.querySelector(".mobile-nav");

  if (mobileMenuToggle && mobileNav) {
    mobileMenuToggle.addEventListener("click", () => {
      mobileNav.classList.toggle("is-active");
    });
  } else {
    console.error("Mobile menu toggle button or navigation not found.");
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const slidesContainer = document.querySelector(".carousel-slides");
  const slides = document.querySelectorAll(".carousel-slide");
  const nextBtn = document.getElementById("nextBtn");
  const prevBtn = document.getElementById("prevBtn");
  const dotsContainer = document.getElementById("carouselDots");

  let currentIndex = 0;
  const totalSlides = slides.length;
  let slideInterval;

  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement("span");
    dot.classList.add("dot");
    dotsContainer.appendChild(dot);
    dot.addEventListener("click", () => {
      goToSlide(i);
    });
  }

  const dots = document.querySelectorAll(".carousel-dots .dot");
  dots[0].classList.add("active");

  function goToSlide(index) {
    if (index < 0) {
      index = totalSlides - 1;
    } else if (index >= totalSlides) {
      index = 0;
    }

    slidesContainer.style.transform = `translateX(-${index * 100}%)`;
    currentIndex = index;

    updateDots();
  }

  function updateDots() {
    dots.forEach((dot, index) => {
      if (index === currentIndex) {
        dot.classList.add("active");
      } else {
        dot.classList.remove("active");
      }
    });
  }

  nextBtn.addEventListener("click", () => {
    goToSlide(currentIndex + 1);
  });

  prevBtn.addEventListener("click", () => {
    goToSlide(currentIndex - 1);
  });

  function startAutoplay() {
    slideInterval = setInterval(() => {
      goToSlide(currentIndex + 1);
    }, 3000);
  }

  function stopAutoplay() {
    clearInterval(slideInterval);
  }

  startAutoplay();

  document
    .querySelector(".carousel-container")
    .addEventListener("mouseenter", stopAutoplay);
  document
    .querySelector(".carousel-container")
    .addEventListener("mouseleave", startAutoplay);

  goToSlide(0);
});
