<?php
/**
 * Skill Section
 */
?>
<section id="skill" class="container skills">
    <div class="skills">
        <?php if(px_opt('skills') != ''){ ?>
        <div class="col-md-3 col-xs-12">
            <div class="skill-text">
                <?php echo px_opt('skills'); ?>
            </div>
            <div class="underline-box"></div>
        </div>
        <?php } ?>
        <?php get_template_part('templates/loop-skill','posts') ?>
    </div>
</section>