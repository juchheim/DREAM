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
                <svg height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 330 330" xml:space="preserve">
                    <path d="M165,0C74.019,0,0,74.02,0,165.001C0,255.982,74.019,330,165,330s165-74.018,165-164.999C330,74.02,255.981,0,165,0z
                        M165,300c-74.44,0-135-60.56-135-134.999C30,90.562,90.56,30,165,30s135,60.562,135,135.001C300,239.44,239.439,300,165,300z" />
                    <path d="M164.998,70c-11.026,0-19.996,8.976-19.996,20.009c0,11.023,8.97,19.991,19.996,19.991
                        c11.026,0,19.996-8.968,19.996-19.991C184.994,78.976,176.024,70,164.998,70z" />
                    <path d="M165,140c-8.284,0-15,6.716-15,15v90c0,8.284,6.716,15,15,15c8.284,0,15-6.716,15-15v-90C180,146.716,173.284,140,165,140z
                        " />
                </svg>

                <?php _e('Info', 'wpvr'); ?>
            </a>
        </li>

        <li class="tab col s3 wpvr_tabs_row">
            <a href="#tab2">
                <svg id="Capa_1" enable-background="new 0 0 512 512" height="14" width="18" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path d="m338.95 243.28-120-75c-4.625-2.89-10.453-3.043-15.222-.4-4.77 2.643-7.729 7.667-7.729 13.12v150c0 5.453 2.959 10.476 7.729 13.12 2.266 1.256 4.77 1.88 7.271 1.88 2.763 0 5.522-.763 7.95-2.28l120-75c4.386-2.741 7.05-7.548 7.05-12.72s-2.663-9.979-7.049-12.72zm-112.95 60.656v-95.873l76.698 47.937z" />
                        <path d="m437 61h-362c-41.355 0-75 33.645-75 75v240c0 41.355 33.645 75 75 75h362c41.355 0 75-33.645 75-75v-240c0-41.355-33.645-75-75-75zm45 315c0 24.813-20.187 45-45 45h-362c-24.813 0-45-20.187-45-45v-240c0-24.813 20.187-45 45-45h362c24.813 0 45 20.187 45 45z" />
                    </g>
                </svg>
                <?php _e('Video Tutorials', 'wpvr'); ?>
            </a>
        </li>

        <?php
        if (!is_plugin_active('wpvr-pro/wpvr-pro.php')) {
        ?>
            <li class="tab col s3 wpvr_tabs_row">
                <a href="#tab3">
                    <svg height="16px" viewBox="0 -10 511.98685 511" width="17px" xmlns="http://www.w3.org/2000/svg">
                        <path d="m114.59375 491.140625c-5.609375 0-11.179688-1.75-15.933594-5.1875-8.855468-6.417969-12.992187-17.449219-10.582031-28.09375l32.9375-145.089844-111.703125-97.960937c-8.210938-7.167969-11.347656-18.519532-7.976562-28.90625 3.371093-10.367188 12.542968-17.707032 23.402343-18.710938l147.796875-13.417968 58.433594-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.433594 136.769532 147.773437 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.367187.253906 21.738281-7.957032 28.90625l-111.703125 97.941406 32.9375 145.085938c2.414063 10.667968-1.726562 21.699218-10.578125 28.097656-8.832031 6.398437-20.609375 6.890625-29.910156 1.300781l-127.445312-76.160156-127.445313 76.203125c-4.308594 2.558594-9.109375 3.863281-13.953125 3.863281zm141.398438-112.875c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.746094 1.089843-19.921875 8.621093-26.515625l105.472657-92.5-139.542969-12.671875c-10.046875-.917969-18.6875-7.234375-22.613281-16.492188l-55.082031-129.046875-55.148438 129.066407c-3.882812 9.195312-12.523438 15.511718-22.546875 16.429687l-139.5625 12.671875 105.46875 92.5c7.554687 6.613281 10.859375 16.769531 8.621094 26.539062l-31.0625 136.9375 120.277343-71.914062c4.308594-2.558594 9.109376-3.859375 13.953126-3.859375zm-84.585938-221.847656s0 .023437-.023438.042969zm169.128906-.0625.023438.042969c0-.023438 0-.023438-.023438-.042969zm0 0" />
                    </svg>
                    <?php _e('Free vs Pro', 'wpvr'); ?>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>

    <div id="tab1" class="block-wrapper info-tab">
        <div class="info-wrapper">

            <div class="single-block banner">
                <a href="https://rextheme.com/wpvr/" target="_blank">
                    <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/wpvr-banner.jpg' ?>" alt="wpvr-banner">
                </a>
            </div>

            <div class="single-block share-block">
                <div class="upgrade-pro">
                    <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/wpvr-logo.png' ?>" alt="logo">
                    <?php if (!is_plugin_active('wpvr-pro/wpvr-pro.php')) { ?>
                        <a class="wpvr-btn" href="https://rextheme.com/wpvr/#pricing" target="_blank">
                            <?php _e('Upgrade to Pro ', 'wpvr'); ?>
                        </a>
                    <?php } ?>
                </div>
                <div class="social-share">
                    <h4><?php _e('Share On', 'wpvr'); ?></h4>
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//wordpress.org/plugins/wpvr/" title="Facebook" target="_blank">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/fb-regular.jpg' ?>" alt="Facebook" class="regular">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/fb-hover.jpg' ?>" alt="Facebook" class="hover">
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/home?status=https%3A//wordpress.org/plugins/wpvr/" title="Twitter" target="_blank">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/tw-regular.jpg' ?>" alt="Twitter" class="regular">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/tw-hover.jpg' ?>" alt="Twitter" class="hover">
                            </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=https%3A//wordpress.org/plugins/wpvr/&title=&summary=&source=" title="Linkedin" target="_blank">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/in-regular.jpg' ?>" alt="Linked in" class="regular">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/in-hover.jpg' ?>" alt="Linked in" class="hover">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="single-block doc">
                <div class="single-block-heading">
                    <span class="icon">
                        <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/doc-icon.png' ?>" class="doc-icon" alt="doc-icon">
                    </span>
                    <h4><?php _e('Documentation', 'wpvr'); ?></h4>
                </div>
                
                <p><?php _e('Before You start, you can check our Documentation to get familiar with WP VR - 360 Panorama and virtual tour creator for WordPress.', 'wpvr'); ?></p>
                <a class="wpvr-btn" href="https://rextheme.com/docs/wp-vr/" target="_blank"><?php _e('Documentation', 'wpvr'); ?></a>
            </div>

            <div class="single-block support">
                <div class="single-block-heading">
                    <span class="icon">
                        <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/support-icon.png' ?>" class="support-icon" alt="support-icon">
                    </span>
                    <h4><?php _e('Support', 'wpvr'); ?></h4>
                </div>

                <p><?php _e('Can\'t find solution on with our documentation? Just Post a ticket on Support forum. We are to solve your issue.', 'wpvr'); ?></p>
                <a class="wpvr-btn" href="https://wordpress.org/support/plugin/wpvr" target="_blank"><?php _e('Post a Ticket', 'wpvr'); ?></a>
            </div>

            <div class="single-block rating">
                <div class="single-block-heading">
                    <span class="icon">
                        <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/rating-icon.png' ?>" class="rating-icon" alt="rating-icon">
                    </span>
                    <h4><?php _e('Make WPVR Popular', 'wpvr'); ?></h4>
                </div>

                <p><?php _e('Your rating and feedback matters to us. If you are happy with WP VR - 360 Panorama and virtual tour creator for WordPress give us a rating.', 'wpvr'); ?> </p>
                <a class="wpvr-btn" href="https://wordpress.org/plugins/wpvr/#reviews" target="_blank"><?php _e('Rate Us ', 'wpvr'); ?></a>
            </div>

        </div>

        <div class="promotion-area">
            <section class="rex-ads-section">
                <div class="rex-ads-container">
                    <h2 class="rex-ads-heading">Boost Revenue &amp; Scale Up Your Business With WooCommerce Sell Kit!</h2>
                    <figure>
                        <img class="rex-ads-plugin-img" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/WooCommerce-sell-kit.webp' ?>" alt="WooCommerce Sell Kit" loading="lazy" decoding="async">
                    </figure>
                    <h2 class="rex-ads-offer-price">Save 40%</h2>
                    <a href="<?php echo('https://rextheme.com/woocommerce-sell-kit/?utm_source=wpvr-plugin-cta&utm_medium=wpvr-plugin&utm_campaign=wpvr-plugin-to-woo-sell-kit') ?>" role="button" target="_blank" class="get-offer-btn">Claim Your Offer Now</a>
                </div>
            </section>
        </div>
    </div>

    <div id="tab2" class="block-wrapper">
        <div class="video-wrapper">

            <div class="video-left">
                <iframe src="https://www.youtube.com/embed/videoseries?list=PLelDqLncNWcUndi1NkXJh2BH62OYmIayt" width="100%" height="100%" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

            <div class="video-right">
                <div class="single-block share-block">
                    <div class="upgrade-pro">
                        <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/wpvr-logo.png' ?>" alt="logo">
                        <?php if (!is_plugin_active('wpvr-pro/wpvr-pro.php')) { ?>
                            <a class="wpvr-btn" href="https://rextheme.com/wpvr/#pricing" target="_blank"><?php _e('Upgrade to Pro ', 'wpvr'); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
    if (!is_plugin_active('wpvr-pro/wpvr-pro.php')) {
    ?>
        <div id="tab3" class="block-wrapper">
            <div class="wpvr-compare">
                <div class="compare-header">
                    <h4><?php _e('WPVR Feature Comparison', 'wpvr'); ?></h4>
                    <?php $pro_url = add_query_arg('wpvr-dashboard', '1', 'https://rextheme.com/wpvr/#pricing'); ?>
                    <a class="wpvr-btn get-pro" href="<?php echo $pro_url; ?>" title="Upgrade to Pro" target="_blank"><?php _e('Upgrade to Pro', 'wpvr'); ?></a>
                </div>

                <div class="compare-tbl-wrapper">
                    <ul class="single-feature list-header">
                        <li class="feature"><?php _e('features', 'wpvr'); ?></li>
                        <li class="free"><?php _e('free', 'wpvr'); ?></li>
                        <li class="pro"><?php _e('pro', 'wpvr'); ?></li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Unlimited Scenes (Up to 5 in Free)', 'wpvr'); ?></li>
                        <li class="free">
        <span class="icon no">
            <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
        </span>
                        </li>
                        <li class="pro">
        <span class="icon yes">
            <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
        </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Unlimited Hotspots (Up to to 5 for a scene in free)', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Publish Tours Anywhere (Embed Add-on)', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('WooCommerce Add-on', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Gyroscope Support', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Panorama Scene Gallery', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>
                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Explainer Video', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img loading="lazy" src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Tour Background Audio', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Info-type Hotspots (Heading, Image, Text, Video, Gif, Links)', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Scene-type Hotspots (Connect Panoramas)', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Custom Icon & Color for Hotspots (Using CSS)', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('900+ Icons & RGB Color Support for Hotspots', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Partial Panorama / Mobile Panorama Support', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('360 Video Support', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Google Street View', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>
                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Cubemap Image Support', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>
                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('VR Glass Support for Video Tours', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Fluent Forms Add-on', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Autoload Tours', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>
                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Custom Rotation Settings', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>
                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Full Page Virtual Tours', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>
                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Custom Preview Image & Text', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Company Logo & Description', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Import & Export Virtual Tours', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Duplicate Tours with One Click', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Control Horizontal & Vertical View of Panorama Images', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Custom Zoom Settings', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Custom Panorama Loading Face', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                    <ul class="single-feature feature-list">
                        <li class="feature"><?php _e('Background Panoramas', 'wpvr'); ?></li>
                        <li class="free">
                            <span class="icon no">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/cross.png' ?>" alt="cross">
                            </span>
                        </li>
                        <li class="pro">
                            <span class="icon yes">
                                <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            </span>
                        </li>
                    </ul>

                </div>
                <!-- /compare-tbl-wrapper -->

                <div class="wpvr-more-feature">
                    <h5 class="heading"><?php _e('More Pro Features', 'wpvr'); ?></h5>
                    <ul>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Home Button to visit Default Scene', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Scene Title', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Scene Author with URL', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Enable or Disable Keyboard Movement Control.', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Enable or Disable Keyboard Zoom Control.', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Enable or Disable Mouse Drag Control.', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Enable or Disable Mouse Zoom control.', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Mouse Control.', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('On Screen Compass.', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Scene Titles on Gallery.', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Customize Icon & Logo of Control Buttons.', 'wpvr'); ?>
                        </li>
                        <li>
                            <img src="<?php echo WPVR_PLUGIN_DIR_URL . 'admin/icon/check.png' ?>" alt="check">
                            <?php _e('Autoload & Autoplay Video Tours.', 'wpvr'); ?>
                        </li>
                    </ul>
                </div>


                <div class="footer-btn">
                    <a class="wpvr-btn get-pro" href="<?php echo $pro_url; ?>" title="Upgrade to Pro" target="_blank"><?php _e('Upgrade to Pro', 'wpvr'); ?></a>
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