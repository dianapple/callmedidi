<div <?php post_class(); ?>>
    <?php get_template_part( 'templates/single-post', "title" ); ?>
    <div class="post-content">
        <?php //Post thumbnail
        if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { ?>
            <div class="post-media">
                <?php the_post_thumbnail('post-single'); ?>
            </div>
        <?php
        } ?>
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