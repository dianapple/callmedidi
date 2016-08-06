<div <?php post_class(); ?>>
    <?php get_template_part( 'templates/single-post', "title" ); ?>
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
        <?php
        }
        ?>
        <?php get_template_part( 'templates/single-post', "meta" ); ?>
        <hr class="media-separator">
        <div class="post-content">
            <?php
            the_content();
            wp_link_pages('before=<div class="post-paginate clearfix">&after=</div>');
            ?>

        </div>
    </div>
</div>
<div class="comments">
    <div class="container container-vspace">
        <div class="row">
            <div class="col-md-8">
                <?php comments_template('', true); ?>
            </div>
        </div>
    </div>
</div>