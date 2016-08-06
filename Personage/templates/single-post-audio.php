<div <?php post_class(); ?>>
    <?php get_template_part( 'templates/single-post', "title" ); ?>
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