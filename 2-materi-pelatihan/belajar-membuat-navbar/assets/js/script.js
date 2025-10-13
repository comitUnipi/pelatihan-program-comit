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
