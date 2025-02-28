document.addEventListener('DOMContentLoaded', function() {
    var splide = new Splide('.splide', {
        // type: 'loop',
        perPage: 3,
        perMove: 1,
        focus: 'center',
        breakpoints: {
            768: {
                perPage:1,
            },
            900:{
                perPage:2,
            }
        },
    });

    splide.mount();
});
