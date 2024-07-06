<?php
/**
 * DREAM functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DREAM
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function dream_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on DREAM, use a find and replace
	 * to change 'dream' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'dream', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'dream' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'dream_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'dream_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function dream_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dream_content_width', 640 );
}
add_action( 'after_setup_theme', 'dream_content_width', 0 );

/**
 * Register widget area.
 */
function dream_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'dream' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'dream' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'dream_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dream_scripts() {
	

	wp_enqueue_script( 'dream-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dream_scripts' );

/**
 * Enqueue custom scripts.
 */
function dream_custom_scripts() {
    // Enqueue the custom slider script
    wp_enqueue_script(
        'custom-slider',
        get_template_directory_uri() . '/js/custom-slider.js',
        array('jquery'), // Dependencies
        null, // Version
        true // Load in the footer
    );

    // Enqueue the parallax script
    wp_enqueue_script(
        'parallax-effect',
        get_template_directory_uri() . '/js/parallax.js',
        array('jquery'), // Dependencies
        null, // Version
        true // Load in the footer
    );
	wp_enqueue_script('dream-gallery', get_template_directory_uri() . '/js/gallery.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'dream_custom_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/* my code starts here */

// Set up the theme and add support for various features
function dream_theme_setup() {
    // Add support for custom logo in the theme
    add_theme_support('custom-logo');
    
    // Add support for menus in the theme
    add_theme_support('menus');
    
    // Register the main menu for the theme
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'dream') // The location and description of the menu
    ));
}
// Hook the dream_theme_setup function to the after_setup_theme action
add_action('after_setup_theme', 'dream_theme_setup');

// Enqueue scripts needed for the theme
function dream_enqueue_scripts() {
    // Enqueue the custom slider script
    wp_enqueue_script(
        'custom-slider', // Handle for the script
        get_template_directory_uri() . '/js/custom-slider.js', // Path to the script file
        array('jquery'), // Dependencies (optional)
        null, // Version (optional)
        true // Load in the footer
    );

    // Enqueue the parallax script
    wp_enqueue_script(
        'parallax-effect', // Handle for the script
        get_template_directory_uri() . '/js/parallax.js', // Path to the script file
        array('jquery'), // Dependencies
        null, // Version
        true // Load in the footer
    );

    // Enqueue the slide-in script
    wp_enqueue_script(
        'slide-in', // Handle for the script
        get_template_directory_uri() . '/js/slide-in.js', // Path to the script file
        array('jquery'), // Dependencies
        null, // Version
        true // Load in the footer
    );
	
    // Enqueue another slider script
    wp_enqueue_script(
        'slider-script', // Handle for the script
        get_template_directory_uri() . '/js/slider.js', // Path to the script file
        array(), // No dependencies
        '1.0', // Version
        true // Load in the footer
    );
}
// Hook the dream_enqueue_scripts function to the wp_enqueue_scripts action
add_action('wp_enqueue_scripts', 'dream_enqueue_scripts');

// Add page attributes support for the slider custom post type
function add_slider_support_for_page_attributes() {
    // Enable support for page attributes in the 'slider' custom post type
    add_post_type_support('slider', 'page-attributes');
}
// Hook the add_slider_support_for_page_attributes function to the init action
add_action('init', 'add_slider_support_for_page_attributes');

// Enable simple page ordering for the slider custom post type in the admin area
function enable_simple_page_ordering_for_slider() {
    // Check if we are in the admin area and the post type is 'slider'
    if (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'slider') {
        // Enqueue the simple-page-ordering script for drag-and-drop ordering
        wp_enqueue_script('simple-page-ordering');
    }
}
// Hook the enable_simple_page_ordering_for_slider function to the admin_enqueue_scripts action
add_action('admin_enqueue_scripts', 'enable_simple_page_ordering_for_slider');


// Customize the admin query to order slider items by menu order
function customize_slider_admin_order($query) {
    // Check if we are not in the admin area
    if (!is_admin()) {
        return;
    }

    // Get the current post type
    $post_type = $query->get('post_type');

    // If the post type is 'slider', set the orderby and order parameters
    if ($post_type == 'slider') {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
}

// Add a body class if there is no featured image, excluding the home page
function dream_add_body_class_for_no_feature_image($classes) {
    // Check if the current page is not the front page, is a singular page, and does not have a featured image
    if (!is_front_page() && is_singular('page') && !has_post_thumbnail()) {
        $classes[] = 'single-column-layout'; // Add the 'single-column-layout' class if conditions are met
    }
    return $classes;
}
// Hook the dream_add_body_class_for_no_feature_image function to the body_class filter
add_filter('body_class', 'dream_add_body_class_for_no_feature_image');


function enqueue_vr_scripts() {
    // Enqueue three.js library from CDN
    wp_enqueue_script('three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', array(), null, true);
    
    // Enqueue Pannellum CSS from CDN
    wp_enqueue_style('pannellum-styles', 'https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css');
    
    // Enqueue Pannellum JS from CDN
    wp_enqueue_script('pannellum-script', 'https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js', array('three-js'), null, true);
    
    // Enqueue custom VR script
    wp_enqueue_script('vr-script', get_template_directory_uri() . '/js/360.js', array('pannellum-script'), null, true);
    
    // Enqueue custom styles
    wp_enqueue_style('custom-styles', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_vr_scripts');

// Enable auto-updates for plugins
add_filter('auto_update_plugin', '__return_true');

// Enable auto-updates for themes
add_filter('auto_update_theme', '__return_true');




// Add a custom column to the Gallery post type
function add_gallery_thumbnail_column($columns) {
    // Create an array to store the new columns
    $new_columns = array();
    
    // Loop through existing columns and insert the thumbnail column before the title column
    foreach ($columns as $key => $value) {
        if ($key == 'title') {
            $new_columns['gallery_thumbnail'] = __('Thumbnail');
        }
        $new_columns[$key] = $value;
    }

    return $new_columns;
}
add_filter('manage_gallery_posts_columns', 'add_gallery_thumbnail_column');

// Populate the custom column with thumbnails
function display_gallery_thumbnail_column($column, $post_id) {
    if ($column === 'gallery_thumbnail') {
        // The first image is stored in a custom field called 'image'
        $images = get_post_meta($post_id, 'image', true);
        
        if (!empty($images)) {
            // If the field contains multiple image IDs, extract the first one
            $first_image_id = is_array($images) ? $images[0] : $images;
            $thumbnail = wp_get_attachment_image_src($first_image_id, 'thumbnail');
            
            if ($thumbnail) {
                echo '<img src="' . esc_url($thumbnail[0]) . '" alt="" style="max-width: 100px; height: auto;">';
            } else {
                echo 'No thumbnail found';
            }
        } else {
            
        }
    }
}
add_action('manage_gallery_posts_custom_column', 'display_gallery_thumbnail_column', 10, 2);

// adjust the admin spacing, hiding unneeded elements
function custom_gallery_admin_css() {
    $screen = get_current_screen();
    if ($screen->post_type === 'gallery' && $screen->base === 'edit') {
        echo '<style>
            .column-gallery_thumbnail {
                width: 100px; /* Adjust width as needed */
            }
            .column-title {
                padding-left: 10px; /* Adjust padding as needed */
                display: flex;
                align-items: center;
            }
            .column-title a.row-title {
                flex-grow: 1;
            }
            .column-title .row-actions {
                display: inline-flex;
                margin-left: 30px;
            }
            .column-title .row-actions span {
                display: inline-block;
                margin-left: 5px; /* Adjust spacing between actions */
            }
            .spo-move-under-sibling {
                display:none !important;
            }
            .view {
                display:none !important;
            }
        </style>';
    }
}
add_action('admin_head', 'custom_gallery_admin_css');

