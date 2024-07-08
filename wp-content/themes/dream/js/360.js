document.addEventListener('DOMContentLoaded', function () {
    var vrContainers = document.querySelectorAll('.vr-container');

    function initializePanorama(container, panoramaImage) {
        if (container && typeof pannellum !== 'undefined') {
            pannellum.viewer(container, {
                type: 'equirectangular',
                panorama: panoramaImage,
                autoLoad: true,
                autoRotate: -2,
                pitch: 0,
                yaw: 0,
                hfov: 120,
                minHfov: 50,
                maxHfov: 120,
                minPitch: -90,
                maxPitch: 90,
                minYaw: -180,
                maxYaw: 180,
                showControls: true,
                northOffset: 0,
                backgroundColor: [0, 0, 0],
            });
        }
    }

    vrContainers.forEach(function (container) {
        var panoramaImage = container.getAttribute('data-panorama');
        initializePanorama(container, panoramaImage);
    });
});