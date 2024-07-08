document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.tab');
    var panes = document.querySelectorAll('.tab-pane');
    var dropdown = document.querySelector('.dropdown-menu');

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

    function handleTabClick(event) {
        var targetTab = event.target;
        var targetPaneId = targetTab.getAttribute('data-tab');

        tabs.forEach(tab => tab.classList.remove('active'));
        panes.forEach(pane => pane.classList.remove('active'));

        targetTab.classList.add('active');
        document.getElementById(targetPaneId).classList.add('active');

        var activePane = document.getElementById(targetPaneId);
        var vrContainer = activePane.querySelector('.vr-container');
        var panoramaImage = vrContainer.getAttribute('data-panorama');

        if (!vrContainer.getAttribute('data-initialized')) {
            initializePanorama(vrContainer, panoramaImage);
            vrContainer.setAttribute('data-initialized', 'true');
        }
    }

    function handleDropdownChange(event) {
        var targetPaneId = event.target.value;

        tabs.forEach(tab => tab.classList.remove('active'));
        panes.forEach(pane => pane.classList.remove('active'));

        document.querySelector(`.tab[data-tab="${targetPaneId}"]`).classList.add('active');
        document.getElementById(targetPaneId).classList.add('active');

        var activePane = document.getElementById(targetPaneId);
        var vrContainer = activePane.querySelector('.vr-container');
        var panoramaImage = vrContainer.getAttribute('data-panorama');

        if (!vrContainer.getAttribute('data-initialized')) {
            initializePanorama(vrContainer, panoramaImage);
            vrContainer.setAttribute('data-initialized', 'true');
        }
    }

    tabs.forEach(tab => tab.addEventListener('click', handleTabClick));
    dropdown.addEventListener('change', handleDropdownChange);

    // Initialize the first panorama by default
    var firstPane = document.querySelector('.tab-pane.active .vr-container');
    if (firstPane) {
        var firstImage = firstPane.getAttribute('data-panorama');
        initializePanorama(firstPane, firstImage);
        firstPane.setAttribute('data-initialized', 'true');
    }
});