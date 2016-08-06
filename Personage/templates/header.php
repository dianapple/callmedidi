<header id="page-top-menu">
    <div class="mobile-menu-bottons">
        <a href="#" class="navigation-button">
            <span class="icon-paragraph-justify"></span>
        </a>
        <a href="#" class="navigation-button">
<!--            <span class="contact icon-mail5"></span>-->
        </a>
    </div>
    <nav class="top-menu">
        <?php
        wp_nav_menu(array(
            'container' =>'',
            'menu_class' => 'desktop-menu center-block sf-menu',
            'before'     => '',
            'theme_location' => 'primary-nav',
            'walker'     => new PxCustomNavWalker(),
            'fallback_cb' => false
        ));
        
        
        $mapdata = array(
            'type' =>   'contact',
            'contactMedia' => px_opt('contact-media-type'),
            'contactMediaImage' => px_opt('contact-image'),
            'contactMediaMap' => array(
                'style' => px_opt('map-style'),
                'zoom' => px_opt('map-zoom'),
                'address' => px_opt('map-address'),
                'latitude' => px_opt('map-latitude'),
                'longitude' => px_opt('map-longitude'),
                'marker' => px_opt('map-marker'),
            ),

        );
        wp_enqueue_script('contact-js',px_path_combine(THEME_JS_URI,'contact.js'),array(),THEME_VERSION,true);
        wp_localize_script( 'contact-js', 'contactParam', $mapdata );
        get_template_part('templates/section','contact');
        
        ?>
    </nav>
</header>