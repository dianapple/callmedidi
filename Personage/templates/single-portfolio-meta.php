<?php
    $id = px_get_page_id('portfolio');
    $url = get_page_link($id);

    ?>
<div class="meta portfolio-meta clearfix">
    <div class="post-meta clearfix">
        <h1 class="post-title">
            <?php the_title(); ?>
            <hr class="title-sep"/>
        </h1>

        <span class="post-info clearfix">
            <span class="post-date"><?php the_date(); ?></span>
        </span>
    </div>
    <div class="meta-button">
        <a class="back-to-portfolio" href="<?php echo $url;?>">Back To Portfolio</a>
    </div>
</div>