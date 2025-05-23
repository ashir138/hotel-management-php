// script.js

const pageBtns = document.querySelectorAll(".pagebtn");
const frames = document.querySelectorAll(".frames");

// Navigation Tab Switching
pageBtns.forEach((btn, index) => {
  btn.addEventListener("click", () => {
    // Remove active class from all
    pageBtns.forEach(b => b.classList.remove("active"));
    frames.forEach(f => f.classList.remove("active"));

    // Add active class to selected
    btn.classList.add("active");
    frames[index].classList.add("active");
  });
});

// Optional: Load Dashboard tab by default
window.onload = () => {
  pageBtns[0].classList.add("active");
  frames[0].classList.add("active");
};
