document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    const modal = document.getElementById('galleryModal');
    const modalMedia = modal.querySelector('.modal-media');
    const modalCaption = modal.querySelector('.modal-caption');
    const closeModal = modal.querySelector('.close');

    function initializeGalleryItems(items) {
        items.forEach(item => {
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

                if (caption) {
                    modalCaption.textContent = caption;
                    modalCaption.style.display = 'block';
                } else {
                    modalCaption.style.display = 'none';
                }

                modal.style.display = 'block';
            });
        });
    }

    initializeGalleryItems(galleryItems);

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

    // Pagination handling
    function initializePagination() {
        const paginationLinks = document.querySelectorAll('.pagination a');

        paginationLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const url = this.href;

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'text/html'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newGalleryItems = doc.querySelector('.gallery').innerHTML;
                    const newPagination = doc.querySelector('.pagination').innerHTML;

                    document.querySelector('.gallery').innerHTML = newGalleryItems;
                    document.querySelector('.pagination').innerHTML = newPagination;

                    // Re-initialize gallery items and pagination links
                    initializeGalleryItems(document.querySelectorAll('.gallery-item'));
                    initializePagination();
                })
                .catch(error => {
                    console.error('Error fetching the gallery items:', error);
                });
            });
        });
    }

    initializePagination();
});
