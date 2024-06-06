<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
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
                    'theme_location' => 'mobile-menu',
                    'menu_class'     => 'mobile-menu-items',
                    'container'      => false,
                )); ?>
            </ul>
        </div>
    </div>
</header>

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
        let primaryDiv;
        <?php if (is_front_page()) : ?>
            console.log('This is the front page.');
            primaryDiv = document.querySelector('.media-slider'); // for the front page
            console.log('Front page, selected media-slider:', primaryDiv);
        <?php else: ?>
            console.log('This is not the front page or blog home page.');
            primaryDiv = document.querySelector('.content-area'); // for other pages, to adjust for spacing re: shrinking header
            console.log('Not front page or blog home page, selected content-area:', primaryDiv);
        <?php endif; ?>

        if (primaryDiv) {
            if (window.scrollY > 0) {
                header.classList.add('shrink');
                primaryDiv.classList.add('header-fixed');
            } else {
                header.classList.remove('shrink');
                primaryDiv.classList.remove('header-fixed');
            }
        } else {
            console.log('primaryDiv is not defined.');
        }
    });
});
</script>
</body>
</html>
