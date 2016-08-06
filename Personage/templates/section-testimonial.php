<?php
/**
  * Testimonial Section
 */
$count_testimonial = wp_count_posts( 'testimonial' )->publish;
?>
<section id = "testimonial" class="container" >
    <div class="clearfix">
        <?php if(px_opt('testimonial') != ''){ ?>
        <h2 class="testimonial-header"><?php echo px_opt('testimonial'); ?></h2>
        <div class="underline-box"></div>
        <?php } ?>
        <div class="special-intro clearfix row">
            <div class="descriptions col-md-9 col-sm-11 col-xs-12">
                <div>
                    <?php get_template_part('templates/loop-testimonial', 'posts') ?>
                </div>
            </div>
            <div class="tab-selectors col-md-3 col-sm-1 col-xs-12">

            </div>
        </div>
    </div>
</section>