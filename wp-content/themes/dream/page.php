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
             $link = $pods->field('link');
             $caption = $pods->field('caption'); // Fetch the caption field
             $slide_title = $pods->field('slide_title'); // Fetch the slide title field

             // Check if there are any videos
             if (!empty($videos)) {
                 // Loop through each video
                 foreach ($videos as $video) {
                     // Add the video to the media array with type 'video', the video's URL, and the link URL
                     $media_array[] = array(
                         'type' => 'video',
                         'url' => $video['guid'],
                         'link' => $link,
                         'caption' => $caption, // Add the caption to the media array
                         'slide_title' => $slide_title // Add the slide title to the media array
                     );
                 }
             // Check if there are any images
             } elseif (!empty($images)) {
                 // Loop through each image
                 foreach ($images as $image) {
                     // Add the image to the media array with type 'image', the image's URL, and the link URL
                     $media_array[] = array(
                         'type' => 'image',
                         'url' => $image['guid'],
                         'link' => $link,
                         'caption' => $caption, // Add the caption to the media array
                         'slide_title' => $slide_title // Add the slide title to the media array
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
                 if (!empty($last_media['link'])) {
                     echo '<a href="' . $last_media['link'] . '" target="_blank"><video src="' . $last_media['url'] . '" muted></video></a>';
                 } else {
                     echo '<video src="' . $last_media['url'] . '" muted></video>';
                 }
             } else {
                 if (!empty($last_media['link'])) {
                     echo '<a href="' . $last_media['link'] . '" target="_blank"><img src="' . $last_media['url'] . '" /></a>';
                 } else {
                     echo '<img src="' . $last_media['url'] . '" />';
                 }
                 // Add the slide title and caption for the last image
                 if (!empty($last_media['slide_title']) || !empty($last_media['caption'])) {
                     echo '<div class="caption">';
                     if (!empty($last_media['slide_title'])) {
                         echo '<div class="slide-title">' . $last_media['slide_title'] . '</div>';
                     }
                     if (!empty($last_media['caption'])) {
                         echo $last_media['caption'];
                     }
                     echo '</div>';
                 }
             }
             echo '</div>';

             // Output all media slides
             foreach ($media_array as $media) {
                 echo '<div class="slide">';
                 if ($media['type'] == 'video') {
                     if (!empty($media['link'])) {
                         echo '<a href="' . $media['link'] . '" target="_blank"><video src="' . $media['url'] . '" muted></video></a>';
                     } else {
                         echo '<video src="' . $media['url'] . '" muted></video>';
                     }
                 } else {
                     if (!empty($media['link'])) {
                         echo '<a href="' . $media['link'] . '" target="_blank"><img src="' . $media['url'] . '" /></a>';
                     } else {
                         echo '<img src="' . $media['url'] . '" />';
                     }
                     // Add the slide title and caption for each image
                     if (!empty($media['slide_title']) || !empty($media['caption'])) {
                         echo '<div class="caption">';
                         if (!empty($media['slide_title'])) {
                             echo '<div class="slide-title">' . $media['slide_title'] . '</div>';
                         }
                         if (!empty($media['caption'])) {
                             echo $media['caption'];
                         }
                         echo '</div>';
                     }
                 }
                 echo '</div>';
             }

             // Clone the first slide and append it to the slider
             $first_media = $media_array[0];
             echo '<div class="slide">';
             if ($first_media['type'] == 'video') {
                 if (!empty($first_media['link'])) {
                     echo '<a href="' . $first_media['link'] . '" target="_blank"><video src="' . $first_media['url'] . '" muted></video></a>';
                 } else {
                     echo '<video src="' . $first_media['url'] . '" muted></video>';
                 }
             } else {
                 if (!empty($first_media['link'])) {
                     echo '<a href="' . $first_media['link'] . '" target="_blank"><img src="' . $first_media['url'] . '" /></a>';
                 } else {
                     echo '<img src="' . $first_media['url'] . '" />';
                 }
                 // Add the slide title and caption for the first image
                 if (!empty($first_media['slide_title']) || !empty($first_media['caption'])) {
                     echo '<div class="caption">';
                     if (!empty($first_media['slide_title'])) {
                         echo '<div class="slide-title">' . $first_media['slide_title'] . '</div>';
                     }
                     if (!empty($first_media['caption'])) {
                         echo $first_media['caption'];
                     }
                     echo '</div>';
                 }
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
                <div class="tall-box"><img src="/wp-content/uploads/2024/07/kid_with_network_cable.png" class="slide-in" alt="Kid with Network Cable" /></div>
            
                <!-- insert new images here -->
                 <!--
                <div class="flex-container">
                    <div class="stacked-image">
                        <img src="/wp-content/uploads/2024/07/four_with_artwork.jpg" alt="Artwork 1" />
                    </div>
                    <div class="stacked-image">
                        <img src="/wp-content/uploads/2024/07/four_with_artwork.jpg" alt="Artwork 2" />
                    </div>
                    <div class="stacked-image">
                        <img src="/wp-content/uploads/2024/07/four_with_artwork.jpg" alt="Artwork 3" />
                    </div>
                </div>
            -->

            
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
                <div class="tabs-container">
                    <div class="dropdown-container">
                        <select class="dropdown-menu">
                            <?php
                            // Fetch panorama images from Pods
                            $virtual_tour_pod = pods('virtual_tour');
                            $params = array(
                                'limit' => -1 // Fetch all records
                            );
                            $virtual_tour_pod->find($params);
                            $panorama_images = [];
                            $index = 0;

                            while ($virtual_tour_pod->fetch()) {
                                $title = $virtual_tour_pod->field('title');
                                $panorama_image = $virtual_tour_pod->field('panorama_image');
                                $main_paragraph_text = $virtual_tour_pod->field('post_content'); // Get the main content
                                $description = $virtual_tour_pod->field('description'); // Get the description
                                if ($panorama_image && isset($panorama_image['guid'])) {
                                    $panorama_images[] = array(
                                        'title' => $title, 
                                        'url' => $panorama_image['guid'], 
                                        'main_paragraph_text' => $main_paragraph_text, 
                                        'description' => $description
                                    );
                                    $active_class = $index === 0 ? 'active' : '';
                                    echo '<option value="tab-' . $index . '" ' . ($index === 0 ? 'selected' : '') . '>' . esc_html($title) . '</option>';
                                    $index++;
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <ul class="tab-list">
                        <?php
                        foreach ($panorama_images as $index => $image) {
                            $active_class = $index === 0 ? 'active' : '';
                            echo '<li class="tab ' . $active_class . '" data-tab="tab-' . $index . '">' . esc_html($image['title']) . '</li>';
                        }
                        ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        foreach ($panorama_images as $index => $image) {
                            $active_class = $index === 0 ? 'active' : '';
                            echo '<div id="tab-' . $index . '" class="tab-pane ' . $active_class . '">';
                            echo '<div class="panorama">';
                            echo '<div class="vr-container" data-panorama="' . esc_url($image['url']) . '"></div>';
                            if (!empty($image['main_paragraph_text']) || !empty($image['description'])) {
                                echo '<div class="panorama-content">';
                                if (!empty($image['main_paragraph_text'])) {
                                    echo '<p>' . $image['main_paragraph_text'] . '</p>';
                                }
                                if (!empty($image['description']) && is_array($image['description'])) {
                                    foreach ($image['description'] as $desc_item) {
                                        echo '<p class="description">' . $desc_item . '</p>';
                                    }
                                } elseif (!empty($image['description'])) {
                                    echo '<p class="description">' . $image['description'] . '</p>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            <!-- End of Virtual Tour section -->




<!-- Gallery section added here -->
<?php if (is_page('gallery')) : ?>
    <div class="gallery"></div> <!-- Empty gallery container for JavaScript to populate -->

    <!-- Pagination controls -->
    <div class="pagination"></div> <!-- Empty pagination container for JavaScript to populate -->

    <!-- Modal for displaying larger images and videos with caption -->
    <div id="galleryModal" class="modal">
        <span class="close">&times;</span>
        <div class="modal-content">
            <div class="modal-media"></div>
            <div class="modal-caption"></div>
        </div>
    </div>

    <script src="<?php echo get_template_directory_uri(); ?>/js/gallery.js"></script>
<?php endif; ?>
<!-- End of Gallery section -->






            <?php if (is_page('staff')) : ?>
                <?php
                // Fetch staff data from Pods
                $staff_pod = pods('staff');
                $params = array(
                    'orderby' => 'priority DESC', // Order by priority descending
                );
                $staff_pod->find($params); // Fetch all staff members with ordering
                
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
                        // Check if photo is available
                        if (!empty($photo)) {
                            echo '<div class="staff-photo"><img src="' . esc_url($photo['guid']) . '" alt="' . esc_attr($first_name . ' ' . $last_name) . '"></div>';
                        }
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
