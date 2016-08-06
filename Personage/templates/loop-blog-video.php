<?php get_template_part( 'templates/loop', "blog-meta" ); ?>
<div class="post-content">
    <?php
    //Parse the content for the first occurrence of video url
    $video = px_extract_video_info(px_get_meta('video-url'));

    if($video != null)
    {
        $w = 500; $h = 280;
        px_get_video_meta($video);

        if(array_key_exists('width', $video))
        {
            $w = $video['width'];
            $h = $video['height'];
        }

        //Extract video ID
        ?>
        <div class="post-media video-frame">
        <?php
            if($video['type'] == 'youtube')
                $src = "http://www.youtube.com/embed/" . $video['id'];
            else
                $src = "http://player.vimeo.com/video/" . $video['id'] . "?color=ff4c2f";
        ?>
        <iframe src="<?php echo $src; ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
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