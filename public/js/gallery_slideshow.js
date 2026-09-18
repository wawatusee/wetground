document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.gallery-slideshow').forEach(slideshow => {

        const images = slideshow.querySelectorAll('.gallery-slideshow-image');

        if (images.length < 2) {
            return;
        }

        let current = 0;
        const interval = parseInt(slideshow.dataset.interval, 10) || 3000;

        setInterval(() => {
            images[current].classList.remove('active');

            current = (current + 1) % images.length;

            images[current].classList.add('active');
        }, interval);

    });

});