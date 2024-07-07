document.addEventListener('DOMContentLoaded', function () {
  var panoramas = document.querySelectorAll('[id^=panorama-]');

  function initializePanorama(container) {
      console.log('Container:', container); // Debugging step to check the container

      if (container) {
          console.log('Pannellum:', typeof pannellum !== 'undefined' ? 'Defined' : 'Not Defined'); // Debugging step to check if the library is loaded

          if (typeof pannellum !== 'undefined') {
              try {
                  console.log('Initializing viewer...');

                  // Fetch the panorama image URL from the data attribute
                  var panoramaImage = container.getAttribute('data-panorama');
                  console.log('Panorama Image:', panoramaImage); // Debugging step to check the image URL

                  if (panoramaImage) {
                      // Initialize the viewer using the correct constructor
                      var viewer = pannellum.viewer(container.id, {
                          type: 'equirectangular',
                          panorama: panoramaImage,
                          autoLoad: true,
                          autoRotate: -2,
                          pitch: 0,
                          yaw: 0,
                          hfov: 120, // Adjusting FOV
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

                      console.log('Viewer initialized:', viewer); // Debugging step to check the viewer initialization
                  } else {
                      console.error('No panorama image URL provided.');
                  }
              } catch (e) {
                  console.error('Initialization error:', e);
              }
          } else {
              console.error('Pannellum is not defined');
          }
      } else {
          console.error('VR container not found');
      }
  }

  function handleTabClick(event) {
      var tabs = document.querySelectorAll('.tab');
      var panes = document.querySelectorAll('.tab-pane');

      tabs.forEach(tab => {
          tab.classList.remove('active');
      });

      panes.forEach(pane => {
          pane.classList.remove('active');
      });

      var clickedTab = event.target;
      var targetPaneId = clickedTab.getAttribute('data-tab');
      var targetPane = document.getElementById(targetPaneId);

      clickedTab.classList.add('active');
      targetPane.classList.add('active');

      var panoramaContainer = targetPane.querySelector('.vr-container');
      if (panoramaContainer && !panoramaContainer.hasAttribute('data-initialized')) {
          initializePanorama(panoramaContainer);
          panoramaContainer.setAttribute('data-initialized', 'true');
      }
  }

  var tabs = document.querySelectorAll('.tab');
  tabs.forEach(tab => {
      tab.addEventListener('click', handleTabClick);
  });

  // Initialize the first panorama by default
  var firstPanoramaContainer = document.querySelector('.tab-pane.active .vr-container');
  if (firstPanoramaContainer) {
      initializePanorama(firstPanoramaContainer);
      firstPanoramaContainer.setAttribute('data-initialized', 'true');
  }
});
