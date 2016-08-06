<?php

function px_register_menus() {
	register_nav_menu( 'primary-nav', __( 'Primary Navigation', TEXTDOMAIN ) );
    register_nav_menu( 'mobile-nav', __( 'Mobile Navigation', TEXTDOMAIN ) );
}

add_action( 'init', 'px_register_menus' );

function px_add_logo_menu_item($items, $args)
{
    if( 'primary-nav' != $args->theme_location )
        return $items;

    //user use image or text as logo
    $logo = px_opt('logo');
    $name = px_opt('title-name');
    ob_start();
    ?>
    <li class="menu-item logo">
        <div class="logo">
            <a href="<?php echo home_url(); ?>/?home">
                <?php if (px_opt('logo-type')=="2"){ ?>
                    <img src="<?php echo $logo; ?>">
                <?php } else { ?>
                    <div class="name"><?php echo $name; ?></div>
                <?php } ?>
            </a>
        </div>
    </li>
    <?php
    if ($logo != '' || $name != '' ){
        $items = ob_get_clean().$items;
    }
    return $items;
}

add_filter('wp_nav_menu_items', 'px_add_logo_menu_item', 10, 2);