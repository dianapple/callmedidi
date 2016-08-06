<?php get_template_part( 'templates/loop', "blog-meta" ); ?>
<div class="post-content">
    <div class="post-media">
    <?php

    $images = px_get_meta('gallery');
    if(is_array($images) && count($images))
    {?>
        <div class="flexslider">
            <ul class="slides">
                <?php
                $imageSize = 'post-thumbnail';
                foreach($images as $img)
                {
                    $imgId = px_get_image_id($img);
                    if($imgId == -1)//Fallback
                        $imgTag = "<img src=\"$img\" />";
                    else
                        $imgTag = wp_get_attachment_image($imgId, $imageSize);
                    ?>
                    <li><?php echo $imgTag; ?></li>
                <?php
                }?>
            </ul>
        </div>
    <?php
    }
    ?>
    </div>
    <hr class="media-separator">
    <?php if( isset( $post->post_content ) && !is_null( $post->post_content ) && !empty($post->post_content ) ){
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