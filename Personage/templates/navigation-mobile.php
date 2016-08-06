<nav class="navigation-mobile">
    <span class="icon-backspace navigation-close"></span>
    <?php
    wp_nav_menu(array(
        'container' =>'',
        'theme_location' => 'mobile-nav',
        'fallback_cb' => false,
        'walker'      => new PxMobileNavWalker('menu-item-mobile'),
    ));
    ?>
</nav>