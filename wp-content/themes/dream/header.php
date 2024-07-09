<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- SEO Meta Tags -->
    <meta name="description" content="Dream Innovations Inc. is transforming rural communities through innovation and technology. Learn more about our mission, vision, and programs.">
    <meta name="keywords" content="Dream Innovations Inc., rural communities, technology training, digital literacy, Yazoo City, Mississippi Delta, low-income students, education, workforce development, innovation center">
    <meta name="author" content="Dream Innovations Inc.">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- <div class="divider-upsidedown"></div> -->
<header class="site-header">
    <div class="container">
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo home_url('/'); ?>" class="custom-logo-link">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/default-logo.png" alt="<?php bloginfo('name'); ?>">
                </a>
            <?php endif; ?>
        </div>
        <nav class="site-navigation">
			<?php wp_nav_menu(array(
				'theme_location' => 'main-menu',
				'menu_class'     => 'main-menu',
				'container'      => false,
			)); ?>
		</nav>
        <div class="hamburger" onclick="toggleMobileMenu()">
            ☰
        </div>
        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <span class="close-mobile-menu" onclick="toggleMobileMenu()">×</span>
            </div>
            <ul>
                <?php wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'menu_class'     => 'mobile-menu-items',
                    'container'      => false,
                )); ?>
            </ul>
        </div>
    </div>
</header>

<div class="header-placeholder"></div> <!-- This div will compensate for the header shrink -->

<!-- <div class="divider"></div> -->

<div id="content" class="site-content">

<script>
function toggleMobileMenu() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.classList.toggle('show');
}

document.addEventListener('DOMContentLoaded', function() {
    // Function to reverse the order of sub-menu items
    const reverseSubMenu = (subMenu) => {
        for (let i = subMenu.children.length - 1; i >= 0; i--) {
            subMenu.appendChild(subMenu.children[i]);
        }
    };

    // Find all sub-menus and reverse their order
    const subMenus = document.querySelectorAll('.sub-menu');
    subMenus.forEach(subMenu => reverseSubMenu(subMenu));

    window.addEventListener('scroll', function() {
        const header = document.querySelector('.site-header');
        const placeholder = document.querySelector('.header-placeholder');

        if (window.scrollY > 0) {
            header.classList.add('shrink');
            placeholder.classList.add('show');
        } else {
            header.classList.remove('shrink');
            placeholder.classList.remove('show');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.wpcf7');
    
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    observer.observe(form);
});
</script>
