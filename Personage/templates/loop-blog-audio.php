<?php get_template_part( 'templates/loop', "blog-meta" ); ?>
<div class="post-content">

    <?php
    //Parse the content for the first occurrence of video url
    $audio = px_extract_audio_info(px_get_meta('audio-url'));

    if($audio != null)
    {
        //Extract video ID
        ?>
        <div class="post-media audio-frame">
        <?php
            echo px_soundcloud_get_embed($audio['url']);
        ?>
        </div>
        <hr class="media-separator">
        <?php } if( isset( $post->post_content ) && !is_null( $post->post_content ) && !empty($post->post_content ) ){
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