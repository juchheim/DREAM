document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('scroll', function() {
        const parallax = document.querySelector('.parallax');
        if (parallax) {
            let scrollPosition = window.scrollY;
            parallax.style.backgroundPositionY = (scrollPosition * -0.5) + 'px'; // Move in the opposite direction
        }
    });
});
