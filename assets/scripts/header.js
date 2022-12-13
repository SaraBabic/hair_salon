let scrollpos = window.scrollY;

const header = document.querySelector(".header");
const scrollChange = 50;

const add_class_on_scroll = () => {
    header.classList.add("colored-header");
    header.classList.remove("transparent-header");
}
const remove_class_on_scroll = () => {
    header.classList.add("transparent-header");
    header.classList.remove("colored-header");
}

window.addEventListener('scroll', function() {
    scrollpos = window.scrollY;

    if (scrollpos >= scrollChange) {
        add_class_on_scroll();
    }
    else {
        remove_class_on_scroll();
    }
})