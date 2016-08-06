<?php get_template_part( 'templates/loop', "blog-meta" ); ?>
<div class="post-content">
    <?php
    //Post thumbnail
    if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { ?>
        <div class="post-media">
            <a class="post-image" title="<?php echo esc_attr(get_the_title()); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
        </div>
        <hr class="media-separator">
    <?php }

    if( isset( $post->post_content ) && !is_null( $post->post_content ) && !empty($post->post_content ) ){
    ?>

        <div class="text-comment clearfix">

            <?php

            if (preg_match('/<!--more/', $post->post_content)) {
                the_content('Keep Reading <span class="icon-arrow-right5"></span>');
            } else {
                the_excerpt(__('Keep Reading <span class="icon-arrow-right5"></span>', TEXTDOMAIN));
            }
            ?>

            <div class="post-comments"><?php if(comments_open()) comments_popup_link( '0', '1', '%', 'comments-link', ''); ?></div>
        </div>
    <?php } ?>

</div>