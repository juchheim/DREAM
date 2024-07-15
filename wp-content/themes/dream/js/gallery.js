document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('galleryModal');
    const modalMedia = modal.querySelector('.modal-media');
    const modalCaption = modal.querySelector('.modal-caption');
    const closeModal = modal.querySelector('.close');
    const galleryContainer = document.querySelector('.gallery');
    const paginationContainer = document.querySelector('.pagination');
    let currentPage = 1;

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

    function fetchGalleryItems(page) {
        const apiUrl = `https://wordpress-1260594-4612369.cloudwaysapps.com/wp-json/dream/v1/gallery?page=${page}`;
        
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Use response.json() directly to parse JSON
            })
            .then(data => {

                if (!data || !Array.isArray(data.items)) {
                    throw new Error('Invalid data structure');
                }

                galleryContainer.innerHTML = ''; // Clear existing items

                data.items.forEach(item => {

                    if (Array.isArray(item.images) && item.images.length > 0) {
                        item.images.forEach(image => {
                            if (image.sizes && image.sizes.medium && image.sizes.full) {
                                const thumbnailUrl = image.sizes.medium;
                                const fullSizeUrl = image.sizes.full;
                                if (typeof thumbnailUrl === 'string' && typeof fullSizeUrl === 'string') {
                                    galleryContainer.innerHTML += `
                                        <div class="gallery-item" data-type="image" data-url="${fullSizeUrl}" data-caption="${item.caption}">
                                            <img src="${thumbnailUrl}" alt="Gallery Image">
                                        </div>`;
                                } else {
                                    console.error('Invalid URL for image:', image);
                                }
                            } else {
                                console.error('Image sizes not found:', image);
                            }
                        });
                    }
                    if (Array.isArray(item.videos) && item.videos.length > 0) {
                        item.videos.forEach(video => {
                            if (video.guid) {
                                const videoUrl = video.guid.guid;
                                if (typeof videoUrl === 'string') {
                                    galleryContainer.innerHTML += `
                                        <div class="gallery-item" data-type="video" data-url="${videoUrl}" data-caption="${item.caption}">
                                            <video controls>
                                                <source src="${videoUrl}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>`;
                                } else {
                                    console.error('Invalid URL for video:', video);
                                }
                            } else {
                                console.error('Video GUID not found:', video);
                            }
                        });
                    }
                });

                initializeGalleryItems(document.querySelectorAll('.gallery-item'));
                renderPagination(data.total_pages, page);
            })
            .catch(error => {
                console.error('Error fetching the gallery items:', error);
            });
    }

    function renderPagination(totalPages, currentPage) {
        paginationContainer.innerHTML = ''; // Clear existing pagination

        if (totalPages > 1) {
            if (currentPage > 1) {
                paginationContainer.innerHTML += `<div class="paginate"><a href="#" class="prev-page">Previous</a></div>`;
            }
            if (currentPage < totalPages) {
                paginationContainer.innerHTML += `<div class="paginate"><a href="#" class="next-page">Next</a></div>`;
            }

            document.querySelector('.prev-page')?.addEventListener('click', function(event) {
                event.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    fetchGalleryItems(currentPage);
                }
            });

            document.querySelector('.next-page')?.addEventListener('click', function(event) {
                event.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    fetchGalleryItems(currentPage);
                }
            });
        }
    }

    // Fetch the initial gallery items and pagination
    fetchGalleryItems(currentPage);

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
