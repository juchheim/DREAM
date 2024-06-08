<?php

/**
 * SpecialOccasionBanner Class
 *
 * This class is responsible for displaying a special occasion banner in the WordPress admin.
 *
 */
class WPVR_Special_Occasion_Banner {

    /**
     * The occasion identifier.
     *
     * @var string
     */
    private $occasion;

    /**
     * The start date and time for displaying the banner.
     *
     * @var int
     */
    private $start_date;

    /**
     * The end date and time for displaying the banner.
     *
     * @var int
     */
    private $end_date;

    /**
     * Constructor method for SpecialOccasionBanner class.
     *
     * @param string $occasion   The occasion identifier.
     * @param string $start_date The start date and time for displaying the banner.
     * @param string $end_date   The end date and time for displaying the banner.
     */
    public function __construct($occasion, $start_date, $end_date) {
        $this->occasion     = $occasion;
        $this->start_date   = strtotime($start_date);
        $this->end_date     = strtotime($end_date);

        if ( !defined('WPVR_PRO_VERSION') && 'no' === get_option( '_wpvr_wp_birthday_2024', 'no' )) {
//        if ( 'no' === get_option( '_wpvr_wp_birthday_2024', 'no' )) {

            // Hook into the admin_notices action to display the banner
            add_action('admin_notices', array($this, 'display_banner'));

            // Add styles
            add_action('admin_head', array($this, 'add_styles'));
        }
    }


    /**
     * Displays the special occasion banner if the current date and time are within the specified range.
     */
    public function display_banner() {

        $screen                     = get_current_screen();
        $promotional_notice_pages   = ['dashboard', 'plugins', 'edit-wpvr_item', 'toplevel_page_wpvr', 'wp-vr_page_wpvr-setup-wizard','wpvr_item', 'wp-vr_page_wpvr-addons'];
        $current_date_time          = current_time('timestamp');

        if (!in_array($screen->id, $promotional_notice_pages)) {
            return;
        }

         if ( $current_date_time < $this->start_date || $current_date_time > $this->end_date ) {
             return;
         }
        // Calculate the time remaining in seconds
        $time_remaining = $this->end_date - $current_date_time;
        $btn_link = 'https://rextheme.com/wpvr/?utm_source=Plugin-CTA&utm_medium=VR-Plugin&utm_campaign=WP-anniversary-sale24#pricing';
        ?>
        <div class="wpvr-<?php echo esc_attr($this->occasion); ?>-banner notice">
            <div class="wpvr-promotional-banner">
                <div class="banner-overflow">
                    
                    <div class="rextheme-wp-anniv__container-area">

                        <div class="rextheme-wp-anniv__image rextheme-wp-anniv__image--left">
                            <figure>
                                <img src="<?php echo esc_url( WPVR_PLUGIN_DIR_URL.'admin/icon/wp-anniversary/wp-anniversary-left.webp' ); ?>" alt="WordPress's 21st Anniversary" />
                            </figure>
                        </div>

                        <div class="rextheme-wp-anniv__content-area">

                            <div class="rextheme-wp-anniv__image--group">


                                <div class="rextheme-wp-anniv__text-divider">
                                    <div class="rextheme-wp-anniv__text-flex">
                                    <svg width="176" height="48" viewBox="0 0 176 48" fill="none"       xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.05392 12.846C3.42992 16.974 2.91392 16.63 5.49392 19.382C6.86992 14.652 12.8899 3.128 20.1139 3.816C23.0379 4.16 26.2199 5.966 26.8219 9.062C28.4559 17.232 17.4479 25.402 9.79392 24.112C7.72992 32.196 8.93392 40.624 16.2439 39.248C21.6619 38.216 24.9299 32.282 26.7359 27.724C26.9079 27.294 27.3379 27.036 27.7679 27.208C28.1979 27.38 28.4559 27.81 28.2839 28.24C26.0479 33.83 21.5759 40.452 14.9539 41.742C3.17192 43.204 2.74192 29.53 4.97792 20.93C1.53792 17.92 1.96792 17.92 0.505922 13.276C0.419922 12.846 1.96792 12.33 2.05392 12.846ZM10.3099 22.478C16.7599 23.596 26.7359 17.146 25.2739 9.578C24.9299 7.858 22.8659 6.74 20.8879 6.998C16.0719 7.514 11.5139 18.522 10.3099 22.478ZM33.2833 34.346C33.1113 35.722 33.7993 38.044 35.7773 37.442C36.6373 37.184 38.0133 35.98 40.2493 32.454L41.2813 30.734C41.7973 29.874 43.5173 30.476 43.0013 31.422L41.8833 33.4C39.4753 37.7 36.4653 42.774 31.3053 41.914C21.2433 40.538 24.1673 21.274 32.7673 17.404C44.4633 12.33 40.9373 30.906 33.2833 34.346ZM33.1113 32.712C37.4113 31.852 39.9053 21.36 37.4113 20.672C33.5413 19.554 32.9393 30.562 33.1113 32.712ZM55.9504 5.106C56.1224 4.762 43.8244 36.582 49.0704 37.614C50.8764 37.872 53.4564 34.088 54.1444 33.056L55.6064 30.734C56.1224 29.874 57.8424 30.476 57.3264 31.422L55.9504 33.916C53.7144 37.872 50.8764 42.086 45.7164 42C37.5464 40.366 41.9324 26.176 43.3944 20.844C45.3724 13.448 47.8664 6.396 48.2104 3.988C48.8124 0.289999 57.1544 2.44 55.9504 5.106ZM63.5177 34.346C63.3457 35.722 64.0337 38.044 66.0117 37.442C66.8717 37.184 68.2477 35.98 70.4837 32.454L71.5157 30.734C72.0317 29.874 73.7517 30.476 73.2357 31.422L72.1177 33.4C69.7097 37.7 66.6997 42.774 61.5397 41.914C51.4777 40.538 54.4017 21.274 63.0017 17.404C74.6977 12.33 71.1717 30.906 63.5177 34.346ZM63.3457 32.712C67.6457 31.852 70.1397 21.36 67.6457 20.672C63.7757 19.554 63.1737 30.562 63.3457 32.712ZM85.5828 5.364C84.2928 9.492 83.0028 13.878 81.7128 18.264L81.8848 18.092C89.6248 12.244 92.7208 20.844 90.7428 29.272C89.9688 32.712 85.4968 47.332 77.7568 39.85C77.0688 39.162 76.6388 38.13 76.3808 36.754C75.8648 38.388 75.4348 40.022 75.0048 41.57C75.1768 42.602 69.3288 41.226 69.1568 40.022C72.5968 28.326 74.6608 14.996 78.2728 3.386C79.6488 0.117998 86.8728 2.354 85.5828 5.364ZM80.4228 22.564C79.3908 26.176 78.3588 29.702 77.4128 33.228C77.2408 34.948 77.4128 36.41 77.8428 37.442C82.3148 43.032 86.4428 23.252 83.8628 20.758C82.8308 19.726 81.5408 20.672 80.4228 22.564ZM92.7866 32.454C93.2166 31.852 97.0866 25.488 98.6346 20.93C95.1086 18.264 95.4526 7.858 99.1506 8.374C103.279 9.062 102.591 13.534 100.785 19.468C102.935 20.156 103.709 19.468 104.741 17.92C106.031 14.48 113.513 16.716 112.395 19.21C109.987 24.542 105.687 35.894 109.041 37.27C110.073 37.7 111.277 38.474 115.835 30.734C116.351 29.874 118.071 30.476 117.555 31.422C114.975 35.98 111.793 42.86 105.859 41.914C98.7206 40.71 102.419 28.412 104.139 21.016C102.935 21.79 101.989 22.134 100.011 21.446C98.1186 27.294 94.6786 32.884 94.3346 33.572C93.4746 34.948 92.6146 33.4 92.7866 32.454ZM99.5806 18.78C100.871 14.566 101.473 10.954 100.355 10.18C98.9786 9.062 97.4306 16.2 99.5806 18.78ZM131.045 17.92C132.335 14.48 139.817 16.716 138.699 19.21C136.291 24.542 131.991 35.894 135.345 37.27C136.377 37.7 137.581 38.474 142.139 30.734C142.655 29.874 144.375 30.476 143.859 31.422C141.279 35.98 138.097 42.86 132.163 41.914C129.239 41.484 128.121 39.076 128.035 35.808L127.949 36.066C127.089 37.872 126.057 39.334 124.853 40.194C117.199 45.956 114.103 37.442 116.081 29.014C116.855 25.574 121.327 10.954 129.067 18.35C129.669 18.952 130.099 19.898 130.357 20.93C130.529 19.898 130.787 18.952 131.045 17.92ZM122.961 37.442C125.885 40.366 131.819 23.338 128.895 20.758C124.509 15.168 120.381 34.948 122.961 37.442ZM144.432 20.156C143.658 20.156 142.798 20.07 142.024 20.07C140.906 19.984 141.422 17.06 142.54 17.146C143.4 17.146 144.26 17.232 145.12 17.404C146.066 13.964 146.84 11.126 147.098 9.492C147.528 5.794 155.956 7.944 154.752 10.61C154.064 12.158 152.946 15.082 151.828 18.264L153.978 18.522C154.494 18.522 154.838 18.866 154.838 19.296C154.752 19.812 154.408 20.156 153.978 20.156C153.032 20.07 152.086 20.07 151.226 20.07C150.022 24.198 145.464 36.066 149.85 37.528C150.796 37.7 152.344 37.012 156.042 30.734C156.558 29.874 158.278 30.476 157.762 31.422C155.182 35.98 152 42.86 146.066 41.914C137.724 40.882 144.002 23.94 144.432 20.156ZM163.963 34.346C163.791 35.722 164.479 38.044 166.457 37.442C167.317 37.184 168.693 35.98 170.929 32.454L171.961 30.734C172.477 29.874 174.197 30.476 173.681 31.422L172.563 33.4C170.155 37.7 167.145 42.774 161.985 41.914C151.923 40.538 154.847 21.274 163.447 17.404C175.143 12.33 171.617 30.906 163.963 34.346ZM163.791 32.712C168.091 31.852 170.585 21.36 168.091 20.672C164.221 19.554 163.619 30.562 163.791 32.712Z" fill="#00B4FF"/>
                                            </svg>
                                        <span class="rextheme-wp-anniv__subtitle-anniversary">
                                        <?php echo __("21st Anniversary", 'rextheme')?>
                                    </span>
                                    </div>

                                    <h2 class="rextheme-wp-anniv__title-wp">
                                        <?php echo __("of WordPress! ", 'rextheme')?>
                                    </h2>
                        
                                </div>


                                <div class="rextheme-wp-anniv__image rextheme-wp-anniv__image--four">
                                    <figure>
                                        <img src="<?php echo esc_url(WPVR_PLUGIN_DIR_URL.'admin/icon/wp-anniversary/wpvr.webp' ); ?>" alt="25% discount WPVR"  />
                                    </figure>
                                </div>

                            </div>

                            <!-- .rextheme-wp-anniv__image end -->
                            <div class="rextheme-wp-anniv__btn-area">

                                <a href="<?php echo esc_url($btn_link); ?>" role="button" class="rextheme-wp-anniv__btn" target="_blank">

                                    <?php echo __('Claim Offer Now', 'rextheme')?>
                                </a>

                            </div>

                        </div>

                        <div class="rextheme-wp-anniv__image rextheme-wp-anniv__image--right">
                            <figure>
                                <img src="<?php echo esc_url( WPVR_PLUGIN_DIR_URL.'admin/icon/wp-anniversary/wp-anniversary-right.webp' ); ?>" alt="WordPress's 21st Anniversary"  />
                            </figure>
                        </div>

                    </div>

                </div>

                <a class="close-promotional-banner wpvr-black-friday-close-promotional-banner" type="button" aria-label="close banner" id="wpvr-black-friday-close-button">
                    <svg width="12" height="13" fill="none" viewBox="0 0 12 13" xmlns="http://www.w3.org/2000/svg"><path stroke="#7A8B9A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 1.97L1 11.96m0-9.99l10 9.99"/></svg>
                </a>

            </div>
        </div>

        <script>
            var timeRemaining = <?php echo esc_js($time_remaining); ?>;

            // Update the countdown every second
            setInterval(function() {
                // var countdownElement    = document.getElementById('wpvr_countdown');
                // var daysElement         = document.getElementById('wpvr_days');
                // var hoursElement        = document.getElementById('wpvr_hours');
                // var minutesElement      = document.getElementById('wpvr_minutes');

                // Decrease the remaining time
                timeRemaining--;

                // Calculate new days, hours, and minutes
                var days = Math.floor(timeRemaining / (60 * 60 * 24));
                var hours = Math.floor((timeRemaining % (60 * 60 * 24)) / (60 * 60));
                var minutes = Math.floor((timeRemaining % (60 * 60)) / 60);


                // Format values with leading zeros
                days = (days < 10) ? '0' + days : days;
                hours = (hours < 10) ? '0' + hours : hours;
                minutes = (minutes < 10) ? '0' + minutes : minutes;

                // Update the HTML
                // daysElement.textContent = days;
                // hoursElement.textContent = hours;
                // minutesElement.textContent = minutes;

                // Check if the countdown has ended
                // if (timeRemaining <= 0) {
                //     countdownElement.innerHTML = 'Campaign Ended';
                // }
            }, 1000); // Update every second
        </script>
        <?php
    }


    /**
     * Adds internal CSS styles for the special occasion banners.
     */
    public function add_styles() {

        ?>
        <style id="wpvr-promotional-banner-style" type="text/css">


            @font-face {
                font-family: 'Lexend Deca';
                src: url(<?php echo WPVR_PLUGIN_DIR_URL.'admin/fonts/campaign-font/LexendDeca-SemiBold.woff2';?>) format('woff2'),
                    url(<?php echo WPVR_PLUGIN_DIR_URL.'admin/fonts/campaign-font/LexendDeca-SemiBold.woff';?>) format('woff');
                font-weight: 600;
                font-style: normal;
                font-display: swap;
            }

            @font-face {
                font-family: 'Lexend Deca';
                src: url(<?php echo WPVR_PLUGIN_DIR_URL.'admin/fonts/campaign-font/LexendDeca-Bold.woff2';?>) format('woff2'),
                    url(<?php echo WPVR_PLUGIN_DIR_URL.'admin/fonts/campaign-font/LexendDeca-Bold.woff';?>) format('woff');
                font-weight: bold;
                font-style: normal;
                font-display: swap;
            }
        

            .wpvr-promotional-banner, 
            .wpvr-promotional-banner * {
                box-sizing: border-box;
            }
                    
            .wpvr-christmas-banner.notice {
                border: none;
                padding: 0;
                display: block;
                background: transparent;
                box-shadow: none;
            }

            .wpvr-christmas-banner h2 {
                margin: 0; 
            }

            .wp-vr_page_wpvr-setup-wizard .wpvr-promotional-banner,
            .wp-vr_page_wpvr-addons .wpvr-promotional-banner,
            .toplevel_page_wpvr .wpvr-promotional-banner {
                width: calc(100% - 20px);
                margin: 20px 0;
            }

            .wp-vr_page_wpvr-setup-wizard .wpvr-christmas-banner.notice,
            .wp-vr_page_wpvr-addons .wpvr-christmas-banner.notice,
            .toplevel_page_wpvr .wpvr-christmas-banner.notice {
                margin: 0;
            }

            .wpvr-promotional-banner {
                background-color: #d6e4ff;
                width: 100%;
                background-image: url(<?php echo esc_url( WPVR_PLUGIN_DIR_URL.'admin/icon/wp-anniversary/notification-bar-bg.webp' )?>);
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
                border: none;
                box-shadow: none;
                display: block;
                max-height: 110px;
            }

            .wpvr-promotional-banner .banner-overflow {
                overflow: hidden;
                position: relative;
                width: 100%;
            }

            .wpvr-promotional-banner .close-promotional-banner {
                position: absolute;
                top: -10px;
                right: -9px;
                background: #fff;
                border: none;
                padding: 8px 9px;
                border-radius: 50%;
                cursor: pointer;
                z-index: 9;
            }

            .wpvr-promotional-banner .close-promotional-banner svg {
                display: block;
                width: 10px;
            }

            .rextheme-wp-anniv__container {
                width: 100%;
                margin: 0 auto;
                max-width: 1640px;
                position: relative;
                padding-right: 15px;
                padding-left: 15px;
            }

            .rextheme-wp-anniv__container-area {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .rextheme-wp-anniv__content-area {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 62px;
                max-width: 1340px;
                position: relative;
                padding-right: 15px;
                padding-left: 15px;
                margin: 0 auto;
            }

            .rextheme-wp-anniv__image--group {
                display: flex;
                align-items: center;
                gap: 90px;
            }

            .rextheme-wp-anniv__text-flex {
                display: flex;
                align-items: center;
                gap:5px;
            }

            .rextheme-wp-anniv__text-flex svg {
                width: 108px;
                height: 27px
            }

            .rextheme-wp-anniv__title-wp {
                position: relative;
                font-family: 'Lexend Deca';
                font-size: 42px;
                font-style: normal;
                font-weight: 800;
                line-height: 1.4;
            }

            .rextheme-wp-anniv__title-wp::before {
                content: "of WordPress!";
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: -moz-linear-gradient(359deg, #fff 33.26%, #fff 78.5%);
                background: -o-linear-gradient(359deg, #fff 33.26%, #fff 78.5%);
                background: linear-gradient(91deg, #fff 33.26%, #fff 78.5%);
                -webkit-background-clip: text !important;
                background-clip: text !important;
                -webkit-text-fill-color: transparent;
                z-index: 1;
            }

            .rextheme-wp-anniv__title-wp::after {
                content: "of WordPress!";
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                -webkit-text-stroke: 8px #0106c6;
            }

            .rextheme-wp-anniv__subtitle-anniversary {
                position: relative;
                font-family: 'Lexend Deca';
                font-size: 33px;
                font-style: normal;
                font-weight: 800;
                line-height: 1.1;
                letter-spacing: -.36px;
            }

            .rextheme-wp-anniv__subtitle-anniversary::before {
                content: "21st Anniversary";
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: -moz-linear-gradient(181deg, #faff00 15.6%, #4fff33 96.87%);
                background: -o-linear-gradient(181deg, #faff00 15.6%, #4fff33 96.87%);
                background: linear-gradient(269deg, #faff00 15.6%, #4fff33 96.87%);
                -webkit-background-clip: text !important;
                background-clip: text !important;
                -webkit-text-fill-color: transparent;
                z-index: 1;
            }

            .rextheme-wp-anniv__subtitle-anniversary::after {
                content: "21st Anniversary";
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                -webkit-text-stroke: 8px #0106c6;
            }
      
            .rextheme-wp-anniv__image--left img {
                width: 100%;
                max-width: 223px;
            }
        
            .rextheme-wp-anniv__image--four img {
                width: 100%;
                max-width: 436px;
            }

            .rextheme-wp-anniv__image--right img {
                width: 100%;
                max-width: 178px;
            }

            .rextheme-wp-anniv__image figure {
                margin: 0;
            }

            .rextheme-wp-anniv__text-container {
                position: relative;
                max-width: 330px;
            }

            .rextheme-wp-anniv__campaign-text-icon {
                position: absolute;
                top: -10px;
                right: -15px;
                max-width: 100%;
                max-height: 24px;
            }

            .rextheme-wp-anniv__btn-area {
                display: flex;
                align-items: flex-end;
                justify-content: flex-end;
                position: relative;
            }

            .rextheme-wp-anniv__btn {
                font-family: 'Lexend Deca';
                font-size: 20px;
                font-style: normal;
                font-weight: 600;
                line-height: 1;
                text-align: center;
                border-radius: 30px;
                background: -webkit-gradient(linear, left bottom, left top, from(#ace7ff), to(#fff));
                background: -moz-linear-gradient(bottom, #ace7ff 0, #fff 100%);
                background: -o-linear-gradient(bottom, #ace7ff 0, #fff 100%);
                background: linear-gradient(0deg, #ace7ff 0, #fff 100%);
                -webkit-box-shadow: 0 11px 30px 0 rgba(19, 13, 57, .25);
                box-shadow: 0 11px 30px 0 rgba(19, 13, 57, .25);
                color: #3f04fe;
                padding: 17px 26px;
                display: inline-block;
                text-decoration: none;
                cursor: pointer;
                text-transform: capitalize;
                -webkit-transition: all .5s linear;
                -o-transition: all .5s linear;
                -moz-transition: all .5s linear;
                transition: all .5s linear;
            }

            a.rextheme-wp-anniv__btn:hover {
                color: #3f04fe;
                background: linear-gradient(0deg, #ace7ff 100%, #fff 0);
            }

            .rextheme-wp-anniv__btn-area a:focus {
                color: #fff;
                box-shadow: none;
                outline: 0px solid transparent;
            }

            .rextheme-wp-anniv__btn:hover {
                background-color: #201cfe;
                color: #fff;
            }


            @media only screen and (max-width: 1710px) {

                .rextheme-wp-anniv__title {
                    font-size: 30px;
                    text-align: left;
                }

                .rextheme-wp-anniv__image--group {
                    gap: 60px;
                }

                .rextheme-wp-anniv__image--four img {
                    max-width: 320px;
                }

                .rextheme-wp-anniv__content-area {
                    gap: 50px;
                    position: relative;
                    z-index: 1;
                    max-width: 992px;
                }

                .rextheme-wp-anniv__title-wp {
                    font-size: 32px;
                }

                .rextheme-wp-anniv__subtitle-anniversary {
                    font-size: 26px;
                }

                .rextheme-wp-anniv__image.rextheme-wp-anniv__image--left {
                    position: absolute;
                    left: -30px;
                    top: 50%;
                    transform: translateY(-50%);
                }

                .rextheme-wp-anniv__image.rextheme-wp-anniv__image--right {
                    position: absolute;
                    right: -30px;
                    top: 50%;
                    transform: translateY(-50%);
                }

                .rextheme-wp-anniv__title-end {
                    font-size: 26px;
                }

                .rextheme-wp-anniv__btn {
                    font-size: 18px;
                }

                .rextheme-wp-anniv__text-inner svg {
                    width: 120px;
                }

                .rextheme-wp-anniv__text {
                    gap: 78px;
                }

                .rextheme-wp-anniv__content-inner {
                    gap: 78px;
                }

                .rextheme-wp-anniv__img-area {
                    gap: 78px;
                }

                .rextheme-wp-anniv__img img {
                    max-width: 20px;
                }

            }


            @media only screen and (max-width: 1440px) {
                .rextheme-wp-anniv__image--group {
                    gap: 30px;
                }

                .wpvr-promotional-banner {
                    max-height: 90px;
                }

                .rextheme-wp-anniv__title-wp {
                    font-size: 25px;
                }

                .rextheme-wp-anniv__subtitle-anniversary {
                    font-size: 25px;
                }

                .rextheme-wp-anniv__image--left img {
                    max-width: 170px;
                }

                .rextheme-wp-anniv__image--right img {
                    max-width: 150px;
                }
              
                .rextheme-wp-anniv__content-area {
                    max-width: 926px;
                    gap: 40px;
                }

                .rextheme-wp-anniv__image--four img {
                    max-width: 310px;
                }

                .rextheme-wp-anniv__btn {
                    font-size: 16px;
                    font-weight: 600;
                    line-height: 34px;
                    border-radius: 30px;
                    padding: 8px 27px;
                }
            
            }


            @media only screen and (max-width: 1399px) {

                .rextheme-wp-anniv__title-wp {
                    font-size: 20px;
                }

                .rextheme-wp-anniv__image--four img {
                    max-width: 275px;
                }

                .rextheme-wp-anniv__subtitle-anniversary {
                    font-size: 20px;
                }


                .rextheme-wp-anniv__text-flex svg {
                    width: 90px;
                    height: 23px;
                }
                
            }

            @media only screen and (max-width: 1024px) {

                .wpvr-promotional-banner {
                    max-height: 63px;
                }

                .rextheme-wp-anniv__content-area {
                    max-width: 653px;
                }

                .rextheme-wp-anniv__content-area {
                    gap: 40px;
                }

                .rextheme-wp-anniv__image--right img {
                    max-width: 126px;
                }

                .rextheme-wp-anniv__image--group {
                    gap: 40px;
                }

                .rextheme-wp-anniv__image--left img {
                    max-width: 170px;
                    margin-left: -30px;
                }

                .rextheme-wp-anniv__image--right img {
                    max-width: 126px;
                    margin-right: -30px;
                }

                .rextheme-wp-anniv__text-flex svg {
                    width: 50px;
                    height: 20px;
                }

                .rextheme-wp-anniv__title-wp {
                    font-size: 16px;
                }

                .rextheme-wp-anniv__subtitle-anniversary {
                    font-size: 15px;
                }

                .rextheme-wp-anniv__image--four img {
                    max-width: 250px;
                }

                .rextheme-wp-anniv__image--four img {
                    max-width: 200px;
                }

                .rextheme-wp-anniv__btn {
                    font-size: 12px;
                    line-height: 1.2;
                    padding: 12px 21px;
                    font-weight: 400;
                }

                .rextheme-wp-anniv__btn {
                    box-shadow: none;
                }
            
            }


            @media only screen and (max-width: 991px) {
                .rextheme-wp-anniv__image--group {
                    gap: 40px;
                }
            }

            @media only screen and (max-width: 768px) {

    
                .wpvr-promotional-banner {
                    max-height: 62px;
                }
             
                .rextheme-wp-anniv__image--four img {
                    max-width: 200px;
                }

                .rextheme-wp-anniv__image--left,
                .rextheme-wp-anniv__image--right {
                    display: none;
                }

                .rextheme-wp-anniv__btn {
                    font-size: 12px;
                    line-height: 1;
                    font-weight: 400;
                    padding: 13px 20px;
                    margin-left: 0;
                    box-shadow: none;
                }

            }
            
            @media only screen and (max-width: 767px) {
                .wpvr-promotional-banner {
                    padding-top: 20px;
                    padding-bottom: 30px;
                    max-height: none;
                }

                .wpvr-promotional-banner {
                    max-height: none;
                }
            
                .rextheme-wp-anniv__image--right,
                .rextheme-wp-anniv__image--left {
                    display: none;
                }

                .rextheme-wp-anniv__stroke-font {
                    font-size: 16px;
                }

                .rextheme-wp-anniv__content-area {
                    flex-direction: column;
                    gap: 25px;
                    text-align: center;
                    align-items: center;
                }
                .rextheme-wp-anniv__btn-area {
                    justify-content: center;
                    padding-top: 5px;
                }
                .rextheme-wp-anniv__btn {
                    font-size: 12px;
                    padding: 15px 24px;
                }
                .rextheme-wp-anniv__image--group {
                    gap: 10px;
                    padding: 0;
                }
            }

            
        </style>
        <?php

    }

}