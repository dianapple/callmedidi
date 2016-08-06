<div class="post-meta">
    <h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
    <div class="post-info clearfix">
        <span class="post-author"><?php _e('Posted by ', TEXTDOMAIN); the_author_posts_link(); ?></span>
        <span class="post-info-separator">/</span>
        <span class="post-date"><?php the_time(get_option('date_format')); ?></span>
    </div>
</div>