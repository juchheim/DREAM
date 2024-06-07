<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage DREAM
 * @since 1.0
 * @version 1.0
 */

?>
    </div><!-- #content -->

    <footer id="colophon" class="site-footer custom-footer">
        <div class="footer-container">
            <div class="footer-column">
                <div class="contact-info">
                    <p><strong>Contact Us</strong></p>
                    <p>Phone: 1(833) YAZOO33</p>
                    <p>Email: <a href="mailto:info@dreaminnovationsinc.org">info@dreaminnovationsinc.org</a></p>
                    <p>Address:</p>
                    <p>123 South Main Street</p>
                    <p>Yazoo City, MS 39194</p>
                </div>
                <div class="social-media-icons">
                    <a href="https://www.facebook.com/p/Dream-Innovations-Inc-100080345106697/" target="_blank">
                        <img src="/wp-content/uploads/2024/06/Facebook_Logo_Secondary.png" alt="Facebook">
                    </a>
                    <a href="https://instagram.com/dreaminnovationsinc" target="_blank">
                        <img src="/wp-content/uploads/2024/06/Instagram_Glyph_White.png" alt="Instagram">
                    </a>
                </div>
            </div>
            <div class="footer-column">
                <div class="site-info">
                    <img src="/wp-content/uploads/2024/06/footer_logo.png" alt="Dream Innovations Inc. Logo" />
                    <p>&copy; <?php echo date('Y'); ?> Dream Innovations Inc. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
