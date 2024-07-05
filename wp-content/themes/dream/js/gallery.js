document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    const modal = document.getElementById('galleryModal');
    const modalMedia = modal.querySelector('.modal-media');
    const modalCaption = modal.querySelector('.modal-caption');
    const closeModal = modal.querySelector('.close');

    galleryItems.forEach(item => {
        item.addEventListener('click', function(event) {
            const type = item.getAttribute('data-type');
            const url = item.getAttribute('data-url');
            const caption = item.getAttribute('data-caption');

            // Prevent video from playing on click
            if (type === 'video') {
                event.preventDefault();
                const videos = item.getElementsByTagName('video');
                for (let video of videos) {
                    video.pause();
                }
            }

            modalMedia.innerHTML = ''; // Clear previous content
            if (type === 'video') {
                const video = document.createElement('video');
                video.controls = true;
                video.src = url;
                video.classList.add('modal-video'); // Add class for easier selection
                modalMedia.appendChild(video);
            } else {
                const img = document.createElement('img');
                img.src = url;
                modalMedia.appendChild(img);
            }

            modalCaption.textContent = caption;

            modal.style.display = 'block';
        });
    });

    closeModal.addEventListener('click', function() {
        const modalVideo = modal.querySelector('.modal-video');
        if (modalVideo) {
            modalVideo.pause();
        }
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            const modalVideo = modal.querySelector('.modal-video');
            if (modalVideo) {
                modalVideo.pause();
            }
            modal.style.display = 'none';
        }
    });
});
