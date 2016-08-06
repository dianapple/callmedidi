<?php

function px_add_image_size_retina($name, $width = 0, $height = 0, $crop = false)
{
    add_image_size($name, $width, $height, $crop);
    add_image_size("$name@2x", $width*2, $height*2, $crop);
}

/*-----------------------------------------------------------------------------------*/
/*	Configure WP2.9+ Thumbnails
/*-----------------------------------------------------------------------------------*/

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );

	//set_post_thumbnail_size
    px_add_image_size_retina( 'post-thumbnail', 760,323,true);//fixed view

    //Post Detail Image size
    px_add_image_size_retina( 'post-single', 875,455 );

    //Post slider thumbnail
    px_add_image_size_retina( 'post-slider-thumb', 760, 323, true);

    //Portfolio thumbnails
    px_add_image_size_retina('portfolio-thumb', 388, 231,true);

    //Portfolio single
    px_add_image_size_retina('portfolio-single', 990,450);

    /* Blog Widget */
    px_add_image_size_retina('recent-widget', 75, 63, true);
}

/*-----------------------------------------------------------------------------------*/
/*	Customize Excerpt
/*-----------------------------------------------------------------------------------*/

function excerpt_read_more_link($output) {
    global $post;
    return $output . '<a class="more-link" href="'. get_permalink($post->ID) . '">'.__("Keep Reading",TEXTDOMAIN ).'<span class="icon-arrow-right5"></span></a>';
}
add_filter('the_excerpt', 'excerpt_read_more_link');


/*-----------------------------------------------------------------------------------*/
/*	RSS Feeds
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'automatic-feed-links' );

/*-----------------------------------------------------------------------------------*/
/*	Post Formats
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'post-formats', array( 'quote', 'video', 'audio', 'gallery' ) );