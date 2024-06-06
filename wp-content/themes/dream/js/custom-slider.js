document.addEventListener('DOMContentLoaded', function() {
    const slidesContainer = document.querySelector('.video-slider .slides');
    const slides = document.querySelectorAll('.video-slider .slide');
    const videos = document.querySelectorAll('.video-slider .slide video');

    if (videos.length > 1) {
        // Multiple videos logic
        let currentIndex = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? 'block' : 'none';
            });
            videos[index].play();
        }

        videos.forEach((video, index) => {
            video.setAttribute('autoplay', 'true');
            video.setAttribute('muted', 'true');
            video.addEventListener('ended', () => {
                currentIndex = (currentIndex + 1) % videos.length;
                showSlide(currentIndex);
            });

            video.addEventListener('click', () => {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            });
        });

        showSlide(currentIndex);
    } else if (videos.length === 1) {
        // Single video logic
        const video = videos[0];
        video.setAttribute('autoplay', 'true');
        video.setAttribute('muted', 'true');
        video.setAttribute('loop', 'true');
        slides[0].style.display = 'block';
        video.play();
    }
});
