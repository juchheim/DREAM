<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Define the custom post type
 *
 *
 * @link       http://rextheme.com/
 * @since      8.0.0
 *
 * @package    Wpvr
 * @subpackage Wpvr/includes/classes
 */


class WPVR_Post_Type {

    /**
     * The ID of this plugin.
     *
     * @since    8.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    8.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The post type of this plugin.
     *
     * @since 8.0.0
     */
    private $post_type;

    /**
     * Initialize the class and set its properties.
     *
     * @since    8.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version, $post_type) {
 
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->post_type = $post_type;

        // Register the post type
        add_action('init', array($this, 'register'));
 
        // Admin set post columns
        add_filter('manage_edit-' . $this->post_type . '_columns', array($this, 'set_columns')) ;

        // Set messages
        add_filter('post_updated_messages', array($this, 'wpvr_post_updated_messages') );
 
        // Admin edit post columns
        add_filter('manage_' . $this->post_type . '_posts_custom_column', array($this, 'edit_columns'));
 
    }

	/**
     * Register the custom post type
     *
     * @since 8.0.0
     */
    public function register()
    {
        $labels = array(
            'name'              => __('Tours', $this->plugin_name),
            'singular_name'     => __('Tours', $this->plugin_name),
            'add_new'           => __('Add New Tour', $this->plugin_name),
            'add_new_item'      => __('Add New Tour', $this->plugin_name),
            'edit_item'         => __('Edit Tour', $this->plugin_name),
            'new_item'          => __('New Tour', $this->plugin_name),
            'view_item'         => __('View Tour', $this->plugin_name),
            'search_items'      => __('Search Wpvr Tour', $this->plugin_name),
            'not_found'         => __('No Wpvr Tour found', $this->plugin_name),
            'not_found_in_trash'=> __('No Wpvr Tour found in Trash', $this->plugin_name),
            'parent_item_colon' => '',
            'all_items'         => __('All Tours', $this->plugin_name),
            'menu_name'         => __('WP VR', $this->plugin_name),
        );

        $args = array(
            'labels'          => $labels,
            'public'          => false,
            'show_ui'         => true,
            'show_in_menu'   	=> false,
            'menu_position'   => 100,
            'supports'        => array( 'title' ),
            'menu_icon'           => plugins_url(). '/wpvr/images/icon.png',
            'capabilities' => array(
                    'edit_post' => 'edit_wpvr_tour',
                    'edit_posts' => 'edit_wpvr_tours',
                    'edit_others_posts' => 'edit_other_wpvr_tours',
                    'publish_posts' => 'publish_wpvr_tours',
                    'read_post' => 'read_wpvr_tour',
                    'read_private_posts' => 'read_private_wpvr_tours',
                    'delete_post' => 'delete_wpvr_tour'
            ),
            'map_meta_cap'    => true,
        );

        /**
         * Documentation : https://codex.wordpress.org/Function_Reference/register_post_type
         */
        register_post_type($this->post_type, $args);
    }

    public function copy_shortcode_html()
    {
        $copy = '<span id="wpvr-copy-shortcode-listing" class="wpvr-copy-shortcode-listing">
                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.4514 2.94398L10.6607 0.153279C10.5626 0.055186 10.4297 0 10.2907 0H4.7093C3.65121 0 2.7907 0.860512 2.7907 1.9186V2.7907H1.9186C0.860512 2.7907 0 3.65121 0 4.7093V13.0814C0 14.1395 0.860512 15 1.9186 15H8.89535C9.95344 15 10.814 14.1395 10.814 13.0814V12.2093H11.686C12.7441 12.2093 13.6047 11.3488 13.6047 10.2907V3.31395C13.6047 3.17533 13.5495 3.04214 13.4514 2.94398ZM10.814 1.7864L11.8183 2.7907H10.814V1.7864ZM9.76744 13.0814C9.76744 13.5624 9.3764 13.9535 8.89535 13.9535H1.9186C1.43756 13.9535 1.04651 13.5624 1.04651 13.0814V4.7093C1.04651 4.22826 1.43756 3.83721 1.9186 3.83721H2.7907V10.2907C2.7907 11.3488 3.65121 12.2093 4.7093 12.2093H9.76744V13.0814ZM11.686 11.1628H4.7093C4.22826 11.1628 3.83721 10.7717 3.83721 10.2907V1.9186C3.83721 1.43756 4.22826 1.04651 4.7093 1.04651H9.76744V3.31395C9.76744 3.60286 10.0018 3.83721 10.2907 3.83721H12.5581V10.2907C12.5581 10.7717 12.1671 11.1628 11.686 11.1628Z" fill="#2271b1"/>
                                </svg>
                                <span class="copy-shortcode-text">Copied</span>
                            </span>';

        return $copy;
    }

    /**
     * @param $columns
     * @return mixed
     *
     * Choose the columns you want in
     * the admin table for this post
     * @since 8.0.0
     */
    public function set_columns($columns) {
        // Set/unset post type table columns 
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'title'     => __('Title', $this->plugin_name),
            'shortcode' => __('Shortcodes', $this->plugin_name),
            'author'    => __('Author', $this->plugin_name),
            'date'      => __('Date', $this->plugin_name)
        );
        return $columns;
    }
 
    /**
     * @param $column
     * @param $post_id
     *
     * Edit the contents of each column in
     * the admin table for this post
     * @since 8.0.0
     */
    public function edit_columns($column) {
        // Post type table column content 
        $post = get_post();

        switch ($column) {
            case 'shortcode':
                echo '<div class="wpvr-listing-shortcode"><code>[wpvr id="' . $post->ID . '"]</code> ' . $this->copy_shortcode_html().'</div>';
                break;
            default:
                break;
        }
    }

    /**
     * Sets the messages for the custom post type
     *
     * @since 8.0.0
     */
    public function wpvr_post_updated_messages($messages)
    {
        $messages[$this->post_type][1] = __('WP VR item updated.', $this->plugin_name);
        $messages[$this->post_type][4] = __('WP VR item updated.', $this->plugin_name);

        return $messages;
    }

}
