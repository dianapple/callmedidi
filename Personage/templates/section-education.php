<?php
/**
 * Education Section
 */
$class = (px_opt('animation')== "1")?'animation' : "";
?>
<section id="education" class="container <?php echo $class ?>">
        <?php if(px_opt('education') != ''){ ?>
        <div class="clearfix">
            <div class="education-header-container col-md-3 col-sm-6 col-xs-6">
                <h2 class="education-header"><?php echo px_opt('education'); ?></h2>
            </div>
        </div>
        <?php } ?>
        <div class="education-parts clearfix">
            <?php get_template_part('templates/loop-education','posts') ?>
        </div>
</section>