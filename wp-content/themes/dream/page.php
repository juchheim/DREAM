<!-- page.php -->
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DREAM
 */

get_header(); ?>

<!-- If the current page is the front page, display the media slider. -->
<?php if ( is_front_page() ) : ?>
 <div class="media-slider">
     <div class="slides">
         <?php
         // Fetch media using Pods
         $pods = pods('slider');
         $params = array(
             'limit' => -1 // Fetch all records
         );
         $pods->find($params);
         $media_array = [];
         
         // Loop through the fetched records and prepare the media array
         while ($pods->fetch()) {
             $videos = $pods->field('video'); 
             $images = $pods->field('image'); 
             
             // Check if there are any videos
             if (!empty($videos)) {
                 // Loop through each video
                 foreach ($videos as $video) {
                     // Add the video to the media array with type 'video' and the video's URL
                     $media_array[] = array(
                         'type' => 'video',
                         'url' => $video['guid']
                     );
                 }
             // Check if there are any images
             } elseif (!empty($images)) {
                 // Loop through each image
                 foreach ($images as $image) {
                     // Add the image to the media array with type 'image' and the image's URL
                     $media_array[] = array(
                         'type' => 'image',
                         'url' => $image['guid']
                     );
                 }
             }
         }


         $media_count = count($media_array);

         if ($media_count > 0) {
             // Clone the last slide and prepend it to the slider
             $last_media = $media_array[$media_count - 1];
             echo '<div class="slide">';
             if ($last_media['type'] == 'video') {
                 echo '<video src="' . $last_media['url'] . '" muted></video>';
             } else {
                 echo '<img src="' . $last_media['url'] . '" />';
             }
             echo '</div>';

             // Output all media slides
             foreach ($media_array as $media) {
                 echo '<div class="slide">';
                 if ($media['type'] == 'video') {
                     echo '<video src="' . $media['url'] . '" muted></video>';
                 } else {
                     echo '<img src="' . $media['url'] . '" />';
                 }
                 echo '</div>';
             }

             // Clone the first slide and append it to the slider
             $first_media = $media_array[0];
             echo '<div class="slide">';
             if ($first_media['type'] == 'video') {
                 echo '<video src="' . $first_media['url'] . '" muted></video>';
             } else {
                 echo '<img src="' . $first_media['url'] . '" />';
             }
             echo '</div>';
         }
         ?>
     </div>
     <!-- Navigation controls for the slider -->
     <button class="prev" onclick="prevSlide()">&#10094;</button>
     <button class="next" onclick="nextSlide()">&#10095;</button>
 </div>
<?php endif; ?>

<!-- Main content area -->
<div id="primary" class="content-area">
    <main id="main" class="site-main">

    <div class="content-wrapper">
        <?php if ( is_front_page() ) : ?>
            <!-- Left column for the front page content -->
            <div class="left-column">
                <?php
                // Loop through the posts and display content
                while ( have_posts() ) :
                    the_post();

                    // Include the template part for displaying page content
                    get_template_part( 'template-parts/content', 'page' );

                    // Load comments template if comments are open or there's at least one comment
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
                ?>
            </div>
            <!-- Right column with an image -->
            <div class="right-column">
                <div class="tall-box"><img src="/wp-content/uploads/2024/06/vr-kid2.png" class="slide-in" /></div>
            </div>
        <?php else : ?>
            <!-- For all other pages, display content and the featured image -->
            <?php
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', 'page' );

                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>


            <!-- Virtual Tour -->
            <?php if (is_page('virtual-tour')) : ?>
                <div class="panoramas">
				<?php
				// Fetch panorama images from Pods
				$virtual_tour_pod = pods('virtual_tour');
				$params = array(
					'limit' => -1 // Fetch all records
				);
				$virtual_tour_pod->find($params);
				$panorama_images = [];

				while ($virtual_tour_pod->fetch()) {
					$title = $virtual_tour_pod->field('title');
					$panorama_image = $virtual_tour_pod->field('panorama_image');
					if ($panorama_image && isset($panorama_image['guid'])) {
						$panorama_images[] = array('title' => $title, 'url' => $panorama_image['guid']);
					}
				}

				// Log the contents of the panorama_images array to the console
				echo '<script>console.log(' . json_encode($panorama_images) . ');</script>';

				if (!empty($panorama_images)) {
					foreach ($panorama_images as $index => $image) {
						echo '<div class="panorama-section">';
						echo '<h3 class="panorama-title">' . esc_html($image['title']) . '</h3>';
						echo '<div id="panorama-' . $index . '" class="vr-container" data-panorama="' . esc_url($image['url']) . '"></div>';
						echo '<div class="panorama-content">';
						// Output the content of the custom post type
						the_content();
						echo '</div>';
						echo '</div>';
					}
				} else {
					echo '<script>console.log("No panorama images found.");</script>';
				}
				?>
            <?php endif; ?>
            
            <!-- End of Virtual Tour section -->


            <!-- Gallery section added here -->
            <?php if (is_page('gallery')) : ?>
                <div class="gallery">
                    <?php
                    $gallery_pod = pods('gallery', array('limit' => -1));
                    while ($gallery_pod->fetch()) {
                        $images = $gallery_pod->field('image');
                        $videos = $gallery_pod->field('video');
                        if (!empty($images)) {
                            foreach ($images as $image) {
                                if (isset($image['guid'])) {
                                    echo '<div class="gallery-item" data-type="image" data-url="' . esc_url($image['guid']) . '">';
                                    echo '<img src="' . esc_url($image['guid']) . '" alt="Gallery Image">';
                                    echo '</div>';
                                }
                            }
                        }
                        if (!empty($videos)) {
                            foreach ($videos as $video) {
                                if (isset($video['guid'])) {
                                    echo '<div class="gallery-item" data-type="video" data-url="' . esc_url($video['guid']) . '">';
                                    echo '<video controls>';
                                    echo '<source src="' . esc_url($video['guid']) . '" type="video/mp4">';
                                    echo 'Your browser does not support the video tag.';
                                    echo '</video>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
                <script src="<?php echo get_template_directory_uri(); ?>/js/gallery.js"></script>
            <?php endif; ?>
            <!-- End of Gallery section -->

            <?php if (is_page('staff')) : ?>
                <?php
                // Fetch staff data from Pods
                $staff_pod = pods('staff');
                $staff_pod->find(); // Fetch all staff members
                
                echo '<div class="staff-container">';
                
                // Check if any records are found
                if ($staff_pod->total_found() > 0) {
                    // Loop through each staff member
                    while ($staff_pod->fetch()) {
                        $first_name = $staff_pod->field('first_name');
                        $last_name = $staff_pod->field('last_name');
                        $photo = $staff_pod->field('photo');
                        $staff_title = $staff_pod->field('staff_title');
                        $email = $staff_pod->field('email');
                        
                        echo '<div class="staff-member">';
                        echo '<div class="staff-photo"><img src="' . esc_url($photo['guid']) . '" alt="' . esc_attr($first_name . ' ' . $last_name) . '"></div>';
                        echo '<div class="staff-info">';
                        echo '<h3 class="staff-name">' . esc_html($first_name . ' ' . $last_name) . '</h3>';
                        echo '<p class="staff-title">' . esc_html($staff_title) . '</p>';
                        echo '<p class="staff-email"><a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No staff members found.</p>';
                }
                
                echo '</div>';
                ?>
            <?php endif; ?>
            
            <div class="child-page-right-column">

			<?php

				if ( is_page('contact') ) {
					echo do_shortcode('[contact-form-7 id="3162945" title="contact"]');
				} elseif ( has_post_thumbnail() ) {
						the_post_thumbnail();
					} 
				
			?>


            </div>
        <?php endif; ?>
    </div> <!-- .content-wrapper -->

    <?php if ( is_front_page() ) : ?>
    <!-- Parallax section for the front page -->
    <div class="single-column-wrapper">
        <div class="parallax-section">
            <div class="parallax-background"></div>
            <div class="parallax-content"></div>
        </div>
    </div>
    <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
// Include the sidebar.php file, which contains the sidebar section of the site.
get_sidebar();
// Include the footer.php file, which contains the footer section of the site.
get_footer();
?>
