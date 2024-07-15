document.addEventListener('DOMContentLoaded', function() {
    const slidesContainer = document.querySelector('.media-slider .slides');
    const slides = document.querySelectorAll('.media-slider .slide');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    
    if (!slidesContainer || slides.length === 0 || !prevButton || !nextButton) {
        // Suppress error display
        // console.error('Required slider elements are missing.');
        return;
    }

    let currentIndex = 1; // Start from the first actual slide
    const totalSlides = slides.length;
    const slideWidth = slides[0].offsetWidth;
    let slideInterval;

    slidesContainer.style.transform = 'translateX(' + (-slideWidth) + 'px)';

    function showSlide(index, transition = true) {
        if (!transition) {
            slidesContainer.style.transition = 'none';
        } else {
            slidesContainer.style.transition = 'transform 0.5s ease-in-out';
        }
        const offset = -index * slideWidth;
        slidesContainer.style.transform = 'translateX(' + offset + 'px)';

        const currentSlide = slides[index];
        const currentVideo = currentSlide.querySelector('video');

        if (currentVideo) {
            currentVideo.currentTime = 0; // Reset video to the first frame
            currentVideo.play();
            currentVideo.onended = function() {
                nextSlide(); // Transition to next slide after video ends
            };
        }
    }

    function resetTimer() {
        clearInterval(slideInterval);
        const currentSlide = slides[currentIndex];
        const currentVideo = currentSlide.querySelector('video');

        if (!currentVideo) {
            slideInterval = setTimeout(nextSlide, 8000); // Set timer for image slides only
        }
    }

    function nextSlide() {
        currentIndex++;
        showSlide(currentIndex);

        if (currentIndex === totalSlides - 1) {
            setTimeout(() => {
                slidesContainer.style.transition = 'none';
                currentIndex = 1;
                showSlide(currentIndex, false);
            }, 500);
        }
        resetTimer();
    }

    function prevSlide() {
        currentIndex--;
        showSlide(currentIndex);

        if (currentIndex === 0) {
            setTimeout(() => {
                slidesContainer.style.transition = 'none';
                currentIndex = totalSlides - 2;
                showSlide(currentIndex, false);
            }, 500);
        }
        resetTimer();
    }

    prevButton.addEventListener('click', prevSlide);
    nextButton.addEventListener('click', nextSlide);

    showSlide(currentIndex, false); // Initially show the first actual slide without transition
    resetTimer(); // Initial delay for first slide
});
