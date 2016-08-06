<div class="post-info clearfix">
    <span class="post-author"><?php _e('Posted by ', TEXTDOMAIN); the_author_posts_link(); ?></span>
    <span class="post-info-separator">/</span>
    <span class="post-date"><?php the_time(get_option('date_format')); ?></span>
    <span class="post-info-separator">/</span>
    <span class="post-categories"><?php  the_tags('');  ?></span>
</div>