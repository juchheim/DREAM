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
            <div class="child-page-right-column">
                <?php
				if ( has_post_thumbnail() ) {
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
            <div class="parallax-content">
            </div>
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
