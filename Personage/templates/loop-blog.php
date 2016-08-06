<div class="posts clearfix">
        <?php
        while(have_posts()){ the_post();

            global $post;
            $format = get_post_format();

            if ( false === $format )
                $format = 'standard';
            ?>
            <article <?php post_class('item clearfix small'); ?> >
                <div class="timeline-container">
                    <div class="circle">
                        <div class="date">
                            <span class="year"><?php the_time('Y'); ?></span>
                            <span class="day-month"><?php the_time('j/M'); ?></span>
                        </div>
                    </div>
                    <div class="line hidden-phone"></div>
                    <div class="hr-line hidden-tablet hidden-desktop"></div>
                </div>
                <div class="post-container">
                    <?php get_template_part( 'templates/loop', "blog-$format" ); ?>
                </div>
            </article>
        <?php
        }
        ?>
</div>