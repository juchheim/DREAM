<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://rextheme.com/
 * @since      1.0.0
 *
 * @package    Wpvr
 * @subpackage Wpvr/admin/partials
 */
?>
<?php
/**
 * get rollback version of WPVR
 *
 * @return array|mixed
 *
 * @src Inspired from Elementor roll back options
 */
function rex_wpvr_get_roll_back_versions() {
    $rollback_versions = get_transient( 'rex_wpvr_rollback_versions_' . WPVR_VERSION );
    if ( false === $rollback_versions ) {
        $max_versions = 5;
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        $plugin_information = plugins_api(
            'plugin_information', [
                'slug' => 'wpvr',
            ]
        );
        if ( empty( $plugin_information->versions ) || ! is_array( $plugin_information->versions ) ) {
            return [];
        }

        krsort( $plugin_information->versions );

        $rollback_versions = [];

        $current_index = 0;
        foreach ( $plugin_information->versions as $version => $download_link ) {
            if ( $max_versions <= $current_index ) {
                break;
            }

            $lowercase_version = strtolower( $version );
            $is_valid_rollback_version = ! preg_match( '/(trunk|beta|rc|dev)/i', $lowercase_version );

            /**
             * Is rollback version is valid.
             *
             * Filters the check whether the rollback version is valid.
             *
             * @param bool $is_valid_rollback_version Whether the rollback version is valid.
             */
            $is_valid_rollback_version = apply_filters(
                'rex_wpvr_is_valid_rollback_version',
                $is_valid_rollback_version,
                $lowercase_version
            );

            if ( ! $is_valid_rollback_version ) {
                continue;
            }

            if ( version_compare( $version, WPVR_VERSION, '>=' ) ) {
                continue;
            }

            $current_index++;
            $rollback_versions[] = $version;
        }

        set_transient( 'rex_wpvr_rollback_versions_' . WPVR_VERSION, $rollback_versions, WEEK_IN_SECONDS );
    }
    return $rollback_versions;
}

$rollback_versions     = function_exists( 'rex_wpvr_get_roll_back_versions' ) ? rex_wpvr_get_roll_back_versions() : array();

?>
    <!-- This file should display the admin pages -->
    <div class="rex-onboarding">
        <ul class="tabs tabs-icon rex-tabs">
            <li class="tab col s3 wpvr_tabs_row">
                <a href="#tab1">
                    <svg id="Layer_1" enable-background="new 0 0 512 512" height="17px" viewBox="0 0 512 512" width="17px" xmlns="http://www.w3.org/2000/svg">
                        <path d="m272.066 512h-32.133c-25.989 0-47.134-21.144-47.134-47.133v-10.871c-11.049-3.53-21.784-7.986-32.097-13.323l-7.704 7.704c-18.659 18.682-48.548 18.134-66.665-.007l-22.711-22.71c-18.149-18.129-18.671-48.008.006-66.665l7.698-7.698c-5.337-10.313-9.792-21.046-13.323-32.097h-10.87c-25.988 0-47.133-21.144-47.133-47.133v-32.134c0-25.989 21.145-47.133 47.134-47.133h10.87c3.531-11.05 7.986-21.784 13.323-32.097l-7.704-7.703c-18.666-18.646-18.151-48.528.006-66.665l22.713-22.712c18.159-18.184 48.041-18.638 66.664.006l7.697 7.697c10.313-5.336 21.048-9.792 32.097-13.323v-10.87c0-25.989 21.144-47.133 47.134-47.133h32.133c25.989 0 47.133 21.144 47.133 47.133v10.871c11.049 3.53 21.784 7.986 32.097 13.323l7.704-7.704c18.659-18.682 48.548-18.134 66.665.007l22.711 22.71c18.149 18.129 18.671 48.008-.006 66.665l-7.698 7.698c5.337 10.313 9.792 21.046 13.323 32.097h10.87c25.989 0 47.134 21.144 47.134 47.133v32.134c0 25.989-21.145 47.133-47.134 47.133h-10.87c-3.531 11.05-7.986 21.784-13.323 32.097l7.704 7.704c18.666 18.646 18.151 48.528-.006 66.665l-22.713 22.712c-18.159 18.184-48.041 18.638-66.664-.006l-7.697-7.697c-10.313 5.336-21.048 9.792-32.097 13.323v10.871c0 25.987-21.144 47.131-47.134 47.131zm-106.349-102.83c14.327 8.473 29.747 14.874 45.831 19.025 6.624 1.709 11.252 7.683 11.252 14.524v22.148c0 9.447 7.687 17.133 17.134 17.133h32.133c9.447 0 17.134-7.686 17.134-17.133v-22.148c0-6.841 4.628-12.815 11.252-14.524 16.084-4.151 31.504-10.552 45.831-19.025 5.895-3.486 13.4-2.538 18.243 2.305l15.688 15.689c6.764 6.772 17.626 6.615 24.224.007l22.727-22.726c6.582-6.574 6.802-17.438.006-24.225l-15.695-15.695c-4.842-4.842-5.79-12.348-2.305-18.242 8.473-14.326 14.873-29.746 19.024-45.831 1.71-6.624 7.684-11.251 14.524-11.251h22.147c9.447 0 17.134-7.686 17.134-17.133v-32.134c0-9.447-7.687-17.133-17.134-17.133h-22.147c-6.841 0-12.814-4.628-14.524-11.251-4.151-16.085-10.552-31.505-19.024-45.831-3.485-5.894-2.537-13.4 2.305-18.242l15.689-15.689c6.782-6.774 6.605-17.634.006-24.225l-22.725-22.725c-6.587-6.596-17.451-6.789-24.225-.006l-15.694 15.695c-4.842 4.843-12.35 5.791-18.243 2.305-14.327-8.473-29.747-14.874-45.831-19.025-6.624-1.709-11.252-7.683-11.252-14.524v-22.15c0-9.447-7.687-17.133-17.134-17.133h-32.133c-9.447 0-17.134 7.686-17.134 17.133v22.148c0 6.841-4.628 12.815-11.252 14.524-16.084 4.151-31.504 10.552-45.831 19.025-5.896 3.485-13.401 2.537-18.243-2.305l-15.688-15.689c-6.764-6.772-17.627-6.615-24.224-.007l-22.727 22.726c-6.582 6.574-6.802 17.437-.006 24.225l15.695 15.695c4.842 4.842 5.79 12.348 2.305 18.242-8.473 14.326-14.873 29.746-19.024 45.831-1.71 6.624-7.684 11.251-14.524 11.251h-22.148c-9.447.001-17.134 7.687-17.134 17.134v32.134c0 9.447 7.687 17.133 17.134 17.133h22.147c6.841 0 12.814 4.628 14.524 11.251 4.151 16.085 10.552 31.505 19.024 45.831 3.485 5.894 2.537 13.4-2.305 18.242l-15.689 15.689c-6.782 6.774-6.605 17.634-.006 24.225l22.725 22.725c6.587 6.596 17.451 6.789 24.225.006l15.694-15.695c3.568-3.567 10.991-6.594 18.244-2.304z" />
                        <path d="m256 367.4c-61.427 0-111.4-49.974-111.4-111.4s49.973-111.4 111.4-111.4 111.4 49.974 111.4 111.4-49.973 111.4-111.4 111.4zm0-192.8c-44.885 0-81.4 36.516-81.4 81.4s36.516 81.4 81.4 81.4 81.4-36.516 81.4-81.4-36.515-81.4-81.4-81.4z" />
                    </svg>
                    <?php _e('General Settings', 'wpvr'); ?>
                </a>
            </li>
            <?php
            if (!is_plugin_active('wpvr-pro/wpvr-pro.php')) {
            ?>
            <li class="tab col s3 wpvr_tabs_row">
                <div class='rex-import-disable'>
                    <span class='is-pro'>Pro</span>
                    <svg id="bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg">
                            <path d="m12 6c-3.309 0-6 2.691-6 6s2.691 6 6 6 6-2.691 6-6-2.691-6-6-6zm3 7h-2v2c0 .552-.448 1-1 1s-1-.448-1-1v-2h-2c-.552 0-1-.448-1-1s.448-1 1-1h2v-2c0-.552.448-1 1-1s1 .448 1 1v2h2c.552 0 1 .448 1 1s-.448 1-1 1z"></path>
                            <path d="m1.5 12c0-5.789 4.71-10.5 10.5-10.5 2.079 0 4.055.607 5.732 1.707l-1.512 1.513c-.472.47-.139 1.28.53 1.28h4.5c.414 0 .75-.336.75-.75v-4.5c0-.665-.806-1.004-1.28-.53l-1.914 1.914c-1.971-1.369-4.322-2.134-6.806-2.134-6.617 0-12 5.383-12 12 0 1.173.173 2.339.513 3.466.119.395.534.621.935.502.396-.12.621-.538.501-.935-.298-.987-.449-2.007-.449-3.033z"></path>
                            <path d="m23.487 8.534c-.12-.397-.535-.623-.935-.502-.396.12-.621.538-.501.935.298.987.449 2.007.449 3.033 0 5.789-4.71 10.5-10.5 10.5-2.075 0-4.048-.604-5.722-1.7l1.505-1.522c.468-.474.132-1.278-.533-1.278h-4.5c-.2 0-.393.08-.533.223s-.219.335-.217.535l.05 4.5c.006.666.819.99 1.283.519l1.878-1.899c1.967 1.362 4.312 2.122 6.789 2.122 6.617 0 12-5.383 12-12 0-1.173-.173-2.339-.513-3.466z"></path>
                        </svg>
                    <?php _e('Import', 'wpvr'); ?>
                </div>
            </li>
                <?php
            }
            ?>
            <?php
            if (is_plugin_active('wpvr-pro/wpvr-pro.php')) {
                ?>
                <li class="tab col s3 wpvr_tabs_row">
                    <a href="#tab2">
                        <svg id="bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg">
                            <path d="m12 6c-3.309 0-6 2.691-6 6s2.691 6 6 6 6-2.691 6-6-2.691-6-6-6zm3 7h-2v2c0 .552-.448 1-1 1s-1-.448-1-1v-2h-2c-.552 0-1-.448-1-1s.448-1 1-1h2v-2c0-.552.448-1 1-1s1 .448 1 1v2h2c.552 0 1 .448 1 1s-.448 1-1 1z" />
                            <path d="m1.5 12c0-5.789 4.71-10.5 10.5-10.5 2.079 0 4.055.607 5.732 1.707l-1.512 1.513c-.472.47-.139 1.28.53 1.28h4.5c.414 0 .75-.336.75-.75v-4.5c0-.665-.806-1.004-1.28-.53l-1.914 1.914c-1.971-1.369-4.322-2.134-6.806-2.134-6.617 0-12 5.383-12 12 0 1.173.173 2.339.513 3.466.119.395.534.621.935.502.396-.12.621-.538.501-.935-.298-.987-.449-2.007-.449-3.033z" />
                            <path d="m23.487 8.534c-.12-.397-.535-.623-.935-.502-.396.12-.621.538-.501.935.298.987.449 2.007.449 3.033 0 5.789-4.71 10.5-10.5 10.5-2.075 0-4.048-.604-5.722-1.7l1.505-1.522c.468-.474.132-1.278-.533-1.278h-4.5c-.2 0-.393.08-.533.223s-.219.335-.217.535l.05 4.5c.006.666.819.99 1.283.519l1.878-1.899c1.967 1.362 4.312 2.122 6.789 2.122 6.617 0 12-5.383 12-12 0-1.173-.173-2.339-.513-3.466z" />
                        </svg>
                        <?php _e('Import', 'wpvr'); ?>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
        <div id="tab1" class="block-wrapper">
            <div class="rex-upgrade wpvr-settings <?php echo is_plugin_active('wpvr-pro/wpvr-pro.php') ? 'pro-active' : ''; ?>">
                <h4><?php _e('General Setup Options', 'wpvr'); ?></h4>
                <div class="parent settings-wrapper">
                    <div class="wpvr_role-container">
                        <ul>
                            <?php
                            $is_wpvr_premium = apply_filters('is_wpvr_premium', false);
                            $is_integration_module = apply_filters('is_integration_module', false);
                            $editor_active = get_option('wpvr_editor_active');
                            $author_active = get_option('wpvr_author_active');
                            $fontawesome_disable = get_option('wpvr_fontawesome_disable');
                            $cardboard_disable = get_option('wpvr_cardboard_disable');
                            $wpvr_webp_conversion = get_option('wpvr_webp_conversion');
                            $mobile_media_resize = get_option('mobile_media_resize');
                            $wpvr_script_control = get_option('wpvr_script_control');
                            $wpvr_script_list = get_option('wpvr_script_list');
                            $wpvr_video_script_control = get_option('wpvr_video_script_control');
                            $wpvr_video_script_list = get_option('wpvr_video_script_list');
                            $high_res_image = get_option('high_res_image');
                            $dis_on_hover = get_option('dis_on_hover');
                            $enable_woocommerce = get_option('wpvr_enable_woocommerce', false);
                            ?>
                            <li>
                                <h6><?php echo __("Allow the Editors of your site to Create, Edit, Update, and Delete virtual tours (They can access other users' tours):", "wpvr"); ?></h6>
                                <span class="wpvr-switcher">
                                <?php
                                if ($editor_active == "true") {
                                    ?>
                                    <input id="wpvr_editor_active" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="wpvr_editor_active" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="wpvr_editor_active"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __('Editors will be able to Create, Edit, Update, and Delete all virtual tours.', 'wpvr'); ?></p>
                            </span>
                            </li>

                            <li>
                                <h6><?php echo __("Allow the Authors of your site to Create, Edit, Update, and Delete virtual tours (They can access their own tours only):", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php
                                if ($author_active == "true") {
                                    ?>
                                    <input id="wpvr_author_active" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="wpvr_author_active" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="wpvr_author_active"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __('Authors will be able to Create, Edit, Update, and Delete their own virtual tours only.', 'wpvr'); ?></p>
                            </span>
                            </li>

                            <li>
                                <h6><?php echo __("Disable Fontawesome from WP VR:", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php
                                if ($fontawesome_disable == "true") {
                                    ?>
                                    <input id="wpvr_fontawesome_disable" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="wpvr_fontawesome_disable" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="wpvr_fontawesome_disable"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __('WP VR will not load Font Awesome library.', 'wpvr'); ?></p>
                            </span>
                            </li>

                            <li>
                                <h6><?php echo __("Enable mobile media resizer:", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php
                                if ($mobile_media_resize == "true") {
                                    ?>
                                    <input id="mobile_media_resize" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="mobile_media_resize" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="mobile_media_resize"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __('WP VR will resize each scenes for mobile devices.', 'wpvr'); ?></p>
                            </span>
                            </li>

                            <li>
                                <h6><?php echo __("Disable WordPress Large Image Handler on WP VR:", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php
                                if ($high_res_image == "true") {
                                    ?>
                                    <input id="high_res_image" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="high_res_image" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="high_res_image"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __("WordPress's default large image handler for images larger than 2560px will be disabled for WP VR. So can create virtual tours with extremely high-quality images. Enabling it will also show high res image on mobile devices. Many devices may not support that resolution.", 'wpvr'); ?></p>
                            </span>
                            </li>

                            <li>
                                <h6><?php echo __("Disable On Hover Content for Mobile:", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php
                                if ($dis_on_hover == "true") {
                                    ?>
                                    <input id="dis_on_hover" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="dis_on_hover" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="dis_on_hover"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __("You can disable on hover content for mobile devices. As most of the devices are touch based.", 'wpvr'); ?></p>
                            </span>
                            </li>

                            <li>

                                <h6><?php echo __("Enable script control (It will load the WP VR scripts on the pages with virtual tours only):", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php
                                if ($wpvr_script_control == "true") {
                                    ?>
                                    <input id="wpvr_script_control" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="wpvr_script_control" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="wpvr_script_control"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __("WP VR assets will be loaded on your allowed pages only. If you turn this on, you have to list the URL's of the pages with virtual tours on the 'List of allowed pages to load WP VR scripts' option", 'wpvr'); ?></p>
                            </span>
                            </li>

                            <li class="enqueue-script wpvr_enqueue_script_list">
                                <h6><?php echo __('List of allowed pages to load WP VR scripts (The URLs of the pages on your site with virtual tours):', 'wpvr'); ?> </h6>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __("List the pages with virtual tours like this: https://example.com/tour1/, https://example.com/tour2/", 'wpvr'); ?></p>
                            </span>

                                <textarea id="wpvr_script_list" class="materialize-textarea" placeholder="https://example.com/tour1/,https://example.com/tour2/"><?php echo $wpvr_script_list; ?></textarea>
                            </li>

                            <li>

                                <h6><?php echo __("Enable Video JS control (It will load the WP VR Video JS library in the listed pages only):", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php
                                if ($wpvr_video_script_control == "true") {
                                    ?>
                                    <input id="wpvr_video_script_control" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="wpvr_video_script_control" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="wpvr_video_script_control"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __("WP VR assets will be loaded on your allowed pages only. If you turn this on, you have to list the URL's of the pages with virtual tours on the 'List of allowed pages to load WP VR scripts' option", 'wpvr'); ?></p>
                            </span>
                            </li>

                            <li class="enqueue-video-script enqueue-script wpvr_enqueue_video_script_list">
                                <h6><?php echo __('List of allowed pages to load WP VR Video JS library (The URLs of the pages on your site, You want to load Video JS):', 'wpvr'); ?> </h6>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __("List the pages like this: https://example.com/tour1/, https://example.com/tour2/", 'wpvr'); ?></p>
                            </span>

                                <textarea id="wpvr_video_script_list" class="materialize-textarea" placeholder="https://example.com/video-tour1/,https://example.com/video-tour2/"><?php echo $wpvr_video_script_list; ?></textarea>
                            </li>

                            <!-- WPVR front-end notice -->
                            <li class="enqueue-script front-notice">
                                <?php
                                $wpvr_frontend_notice = false;
                                $wpvr_frontend_notice_area = '';
                                $wpvr_frontend_notice = get_option('wpvr_frontend_notice');
                                $wpvr_frontend_notice_area = get_option('wpvr_frontend_notice_area');
                                if (!$wpvr_frontend_notice_area) {
                                    $wpvr_frontend_notice_area = __("Flip the phone to landscape mode for a better experience of the tour.", "wpvr");
                                }
                                ?>
                                <h6><?php echo __("Front-End Notice for Mobile Visitors:", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php
                                if ($wpvr_frontend_notice == "true") {
                                    ?>
                                    <input id="wpvr_frontend_notice" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="wpvr_frontend_notice" type="checkbox">
                                    <?php
                                }
                                ?>
                                <label for="wpvr_frontend_notice"></label>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __("The notice will appear on the front end of the virtual tour if viewed from a mobile device.", 'wpvr'); ?></p>
                            </span>
                                <textarea id="wpvr_frontend_notice_area" class="materialize-textarea" placeholder="Add your notice here"><?php echo $wpvr_frontend_notice_area; ?></textarea>
                            </li>
                            <li>
                                <h6><?php echo __("VR GLass Support:", "wpvr"); ?></h6>

                                <span class="wpvr-switcher">
                                <?php

                                if(is_plugin_active('wpvr-pro/wpvr-pro.php')){
                                    if ($cardboard_disable == 'true') {
                                        ?>
                                        <input id="wpvr_cardboard_disable" type="checkbox" checked>
                                        <?php
                                    } else {
                                        ?>
                                        <input id="wpvr_cardboard_disable" type="checkbox" >
                                        <?php
                                    }
                                }
                                ?>
                                    <?php if(is_plugin_active('wpvr-pro/wpvr-pro.php')){ ?>
                                        <label for="wpvr_cardboard_disable"></label>
                                    <?php }else{ ?>

                                        <div class='wpvr_cardboard_disable_is_pro'>
                                            <span>Pro</span>
                                            <label for="wpvr_cardboard_disable" class='wpvr_cardboard_disable_label'></label>
                                        </div>
                                    <?php } ?>
                            </span>

                                <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __('Will activate the VR Glass support on mobile devices. This is the Beta release. So, if you face any issues with it, please contact us at support@rextheme.com', 'wpvr'); ?></p>
                            </span>
                            </li>
                            <!-- WPVR front-end notice -->
                            <?php if (is_plugin_active('wpvr-pro/wpvr-pro.php')) { ?>
                                <li>
                                    <h6><?php echo __("Convert any jpeg or png format image to webp on media upload:", "wpvr"); ?></h6>

                                    <span class="wpvr-switcher">
                                <?php
                                if ($wpvr_webp_conversion == 'true') {
                                    ?>
                                    <input id="wpvr_webp_conversion" type="checkbox" checked>
                                    <?php
                                } else {
                                    ?>
                                    <input id="wpvr_webp_conversion" type="checkbox" >
                                    <?php
                                }
                                ?>
                                <label for="wpvr_webp_conversion"></label>
                            </span>

                                    <span class="wpvr-tooltip">
                                <span class="icon">
                                    <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/question-icon.png' ?>" alt="check">
                                </span>
                                <p><?php echo __('Will convert any jpeg or png image to webp format during media upload. will decrease the image size with no quality compromise and help the site to load faster.', 'wpvr'); ?></p>
                            </span>
                                </li>
                            <?php } ?>

                            <li>
                                <form class="wpvr-version" id="trigger-rollback">
                                    <?php wp_nonce_field( 'wpvr_rollback','wpvr_rollback' ); ?>
                                    <h6><?php _e('Select a Version to Rollback', 'wpvr'); ?></h6>
                                    <select name="wpvr_version">
                                        <?php
                                        foreach ( $rollback_versions as $version ) {
                                            echo "<option value='".esc_attr( $version )."'>".esc_html($version)."</option>";
                                        }
                                        ?>
                                    </select>


                                    <input class="wpvr-btn" type="submit" value="Rollback">
                                </form>
                            </li>

                        </ul>

                        <div class="save-progress-bar">
                            <div id="wpvr_role_progress" class="progress" style="display:none;">
                                <div class="indeterminate"></div>
                            </div>
                        </div>

                        <button class="btn wpvr-btn" type="submit" id="wpvr_role_submit"><?php echo __('Save', 'wpvr'); ?></button>
                    </div>

                    <?php if (!is_plugin_active('wpvr-pro/wpvr-pro.php')) { ?>
                        <div class="upgrade-pro">
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/wpvr-logo.png' ?>" alt="logo">
                            <a class="wpvr-btn" href="https://rextheme.com/wpvr/#pricing" target="_blank"><?php _e('Upgrade to Pro ', 'wpvr'); ?></a>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <?php
        if (is_plugin_active('wpvr-pro/wpvr-pro.php')) {
            ?>
            <div id="tab2" class="block-wrapper import-tab">
                <div class="import-tab-wrapper">
                    <h4 class="tab-title"><?php _e('Import tour file: ', 'wpvr'); ?></h4>
                    <div class="parent" style="width:100%;">
                        <form id="wpvr_import_from">
                            <a class="wpvr-import-btn" id="wpvr_button_upload"><i class="material-icons"><?php echo __('add','wpvr')?></i></a>
                            <p class="vr-notice"><?php _e('Do not close or refresh the page during import process. It may take few minutes.', 'wpvr'); ?></p>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" id="wpvr_file_url" type="text" value="" data-value="">
                            </div>
                            <div id="wpvr_progress" class="progress" style="display:none;">
                                <div class="indeterminate"></div>
                            </div>
                            <button class="wpvr-btn" type="submit" id="wpvr_button_submit"><?php echo __('Submit','wpvr') ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

    </div>

<?php

if(is_plugin_active('divi-builder/divi-builder.php')){
    ?>
    <script>
        (function ($) {
            $(".rex-onboarding .block-wrapper:not(#tab1)").hide()
            $('.rex-onboarding li.tab a').first().addClass("active");
            $('.rex-onboarding li.tab').on('click', function(){
                var target_id = $(this).find("a").attr('href');
                $(".rex-onboarding li.tab a").removeClass('active');
                $(this).find("a").addClass('active');
                $(target_id).show();
                $(target_id).siblings('.block-wrapper').hide();
            })
        })(jQuery);
    </script>
    <?php
}

?>