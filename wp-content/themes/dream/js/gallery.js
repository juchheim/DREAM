document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');

    // Create shadowbox elements only if they don't already exist
    let shadowbox = document.querySelector('.shadowbox');
    if (!shadowbox) {
        shadowbox = document.createElement('div');
        shadowbox.classList.add('shadowbox');
        const shadowboxContent = document.createElement('div');
        shadowboxContent.classList.add('shadowbox-content');
        const closeButton = document.createElement('button');
        closeButton.classList.add('shadowbox-close');
        closeButton.innerHTML = '&times;';

        shadowbox.appendChild(shadowboxContent);
        shadowbox.appendChild(closeButton);
        document.body.appendChild(shadowbox);

        closeButton.addEventListener('click', function() {
            shadowbox.classList.remove('active');
            shadowboxContent.innerHTML = '';
        });
    }

    const shadowboxContent = shadowbox.querySelector('.shadowbox-content');

    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            const mediaType = this.dataset.type;
            const mediaUrl = this.dataset.url;

            shadowboxContent.innerHTML = '';

            if (mediaType === 'image') {
                const img = document.createElement('img');
                img.src = mediaUrl;
                shadowboxContent.appendChild(img);
            } else if (mediaType === 'video') {
                const video = document.createElement('video');
                video.src = mediaUrl;
                video.controls = true;
                shadowboxContent.appendChild(video);
            }

            shadowbox.classList.add('active');
        });
    });
});
