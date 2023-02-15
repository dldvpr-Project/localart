const scrollBtn = document.querySelector(".scroll-btn");
const arrowUp = "fa-arrow-up";
const arrowDown = "fa-arrow-down";

window.addEventListener("scroll", () => {
    if (window.scrollY > 0) {
        scrollBtn.classList.add("show");
    } else {
        scrollBtn.classList.remove("show");
    }

    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        scrollBtn.querySelector(".scroll-btn-home").classList.remove(arrowDown);
        scrollBtn.querySelector(".scroll-btn-home").classList.add(arrowUp);
    } else {
        scrollBtn.querySelector(".scroll-btn-home").classList.remove(arrowUp);
        scrollBtn.querySelector(".scroll-btn-home").classList.add(arrowDown);
    }
});

scrollBtn.addEventListener("click", () => {
    if (window.scrollY !== 0) {
        window.scrollTo({ top: 0, behavior: "smooth" });
    } else {
        window.scrollTo({ top: document.documentElement.scrollHeight, behavior: "smooth" });
    }
});
