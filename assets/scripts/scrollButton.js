const scrollBtn = document.querySelector(".scroll-btn");

window.addEventListener("scroll", () => {
    if (window.scrollY > 0) {
        scrollBtn.classList.add("show");
    } else {
        scrollBtn.classList.remove("show");
    }
});

scrollBtn.addEventListener("click", () => {
    if (window.scrollY !== 0) {
        window.scrollTo({ top: 0, behavior: "smooth" });
    } else {
        window.scrollTo({ top: document.documentElement.scrollHeight, behavior: "smooth" });
    }
});
