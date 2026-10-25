(function () {
    "use strict";

    function initializeImageCarousels() {
        if (typeof window.Splide !== "function") {
            console.error(
                "Carrusel: no se ha cargado splide.min.js."
            );
            return;
        }

        document
            .querySelectorAll("[data-image-carousel]")
            .forEach(function (element) {
                if (element.classList.contains("is-initialized")) {
                    return;
                }

                var carousel = new window.Splide(element, {
                    type: "loop",
                    perPage: 5,
                    perMove: 1,
                    gap: 0,
                    padding: 0,

                    arrows: true,
                    pagination: false,

                    autoplay: true,
                    interval: 3000,
                    pauseOnHover: true,
                    pauseOnFocus: true,
                    resetProgress: true,

                    drag: true,
                    speed: 600,
                    mediaQuery: "max",

                    breakpoints: {
                        1199: {
                            perPage: 3
                        },
                        767: {
                            perPage: 2
                        },
                        575: {
                            perPage: 1,
                            padding: {
                                left: 0,
                                right: "15%"
                            }
                        }
                    },

                    reducedMotion: {
                        speed: 0,
                        rewindSpeed: 0,
                        autoplay: "pause"
                    },

                    i18n: {
                        prev: "Imagen anterior",
                        next: "Imagen siguiente",
                        first: "Ir a la primera imagen",
                        last: "Ir a la última imagen",
                        slideX: "Ir a la imagen %s",
                        pageX: "Ir a la página %s",
                        carousel: "Galería de imágenes",
                        slide: "Imagen",
                        select: "Selecciona una imagen",
                        slideLabel: "%s de %s"
                    }
                });

                function stopAutoplay() {
                    carousel.Components.Autoplay.pause();
                }

                // Detener la reproducción cuando se arrastran las fotos.
                carousel.on("drag", stopAutoplay);

                carousel.mount();

                // Detenerla también al pulsar cualquiera de las flechas.
                element
                    .querySelectorAll(".splide__arrow")
                    .forEach(function (button) {
                        button.addEventListener("click", stopAutoplay);
                    });
            });
    }

    if (document.readyState === "loading") {
        document.addEventListener(
            "DOMContentLoaded",
            initializeImageCarousels
        );
    } else {
        initializeImageCarousels();
    }
})();