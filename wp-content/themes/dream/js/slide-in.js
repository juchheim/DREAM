document.addEventListener('DOMContentLoaded', function() {
    const slideInElement = document.querySelector('.slide-in');

    if (!slideInElement) {
        // Suppress error display
        // console.log('No .slide-in element found on this page.');
        return; // Exit the function if the element is not found
    }

    function checkSlide() {
        const scrollPosition = window.scrollY;
        const slideInAt = window.scrollY + window.innerHeight - (slideInElement.offsetHeight / 4); // Wait until 3/4 of the element is in view
        const imageBottom = slideInElement.offsetTop + slideInElement.offsetHeight;
        const isQuarterShown = slideInAt > slideInElement.offsetTop;
        const isNotScrolledPast = window.scrollY < imageBottom;

        if (scrollPosition > 150 && isQuarterShown && isNotScrolledPast) {
            slideInElement.classList.add('slide-in-visible');
            window.removeEventListener('scroll', checkSlide);
        }
    }

    window.addEventListener('scroll', checkSlide);
    window.addEventListener('resize', checkSlide);
    checkSlide(); // Initial check in case the element is already in view
});
