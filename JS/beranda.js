window.addEventListener("scroll", () => {
    const navbar = document.getElementById("navbar");
    if (window.scrollY > 50) {
      navbar.classList.remove("transparent");
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.add("transparent");
      navbar.classList.remove("scrolled");
    }
});
  