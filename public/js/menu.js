document.addEventListener("DOMContentLoaded", () => {
  const menu = document.getElementById("responsiveMenu");
  const toggle = document.getElementById("menuToggle");
  const icon = document.getElementById("menuIcon");

  if (!menu || !toggle || !icon) return;

  toggle.addEventListener("click", () => {
    const isOpen = menu.classList.toggle("responsive");
    icon.textContent = isOpen ? "✕" : "☰";
    toggle.setAttribute("aria-expanded", isOpen);
  });
});
