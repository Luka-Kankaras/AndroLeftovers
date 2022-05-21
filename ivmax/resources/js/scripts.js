$("button.navbar-toggler-btn").click(function(e) {
    e.preventDefault();
    if (!$("#navbarNav").hasClass("active")) {
        $("#navbarNav").addClass("active");
        $("#navbarNav").show("slow");
        $("button.navbar-toggler-btn").addClass("active");
    } else {
        $("#navbarNav").removeClass("active");
        $("#navbarNav").hide("slow");
        $("button.navbar-toggler-btn").removeClass("active");
    }
});

window.toggleToothbrushDescription = function toggleToothbrushDescription(
    button,
    part
) {
    const buttons = document.getElementsByClassName("tootbrush__button");

    for (let i = 0; i < buttons.length; i++) {
        if (buttons[i].classList.contains("active")) {
            buttons[i].classList.remove("active");
        }
    }

    button.classList.add("active");

    const elements = document.getElementsByClassName("tootbrush__text");

    for (let i = 0; i < elements.length; i++) {
        if (!elements[i].classList.contains("d-none")) {
            elements[i].classList.add("d-none");
        }
    }

    const element = document.getElementById(`text${part}`);
    if (element.classList.contains("d-none")) {
        element.classList.remove("d-none");
    }
};

window.selectColor = function selectColor(colorButton, color) {
    const elements = document.getElementsByClassName("color");

    for (let i = 0; i < elements.length; i++) {
        if (elements[i].classList.contains("active")) {
            elements[i].classList.remove("active");
        }
    }

    colorButton.classList.add("active");

    const backgrounds = document.getElementsByClassName("tootbrush__img");
    for (let i = 0; i < backgrounds.length; i++) {
        if (backgrounds[i].classList.contains("active")) {
            backgrounds[i].classList.remove("active");
        }
    }

    const section = document.getElementById(`active${color}`);
    if (!section.classList.contains("active")) {
        section.classList.add("active");
    }
};

window.initSlider = function initSlider() {
    initSlider = $("#cardsSlider").owlCarousel({
        loop: true,
        lazyLoad: true,
        center: false,
        items: 1,
        margin: 0,
        autoplay: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        nav: true,
        navText: [
            "<img src='assets/images/home/testimonials/left.svg' alt='Slide prev'>",
            "<img src='assets/images/home/testimonials/right.svg' alt='Slide next'>"
        ],
        dots: false,
        responsiveClass: true,
        responsiveBaseElement: "#cardsSlider",
        responsive: {
            768: {
                items: 2
            }
        }
    });
};
