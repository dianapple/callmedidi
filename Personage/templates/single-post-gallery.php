<div <?php post_class(); ?>>
    <?php get_template_part( 'templates/single-post', "title" ); ?>
    <div class="post-content">
        <div class="post-media">
            <?php
            $images = px_get_meta('gallery');
            if(count($images))
            {?>
                <div class="flexslider">
                    <ul class="slides">
                        <?php
                        $imageSize = 'post-single';
                        foreach($images as $img)
                        {
                            //For getting image size use
                            //http://php.net/manual/en/function.getimagesize.php
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
            }?>
        </div>
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