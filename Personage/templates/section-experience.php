<?php
/**
 * Experience Section
 */
$href = "#";
if(px_opt('print-state')=='link'){
    $href  = px_opt('print-link');
    $text  = __("Get resume",TEXTDOMAIN);
}else{
    $text  = __("Print it",TEXTDOMAIN);
}

$class = (px_opt('animation')== "1")?'animation' : "";
?>
<section id="experience" class="container <?php echo $class ?>">
    <div class="clearfix">
        <div class="experience-header-container col-md-3 col-sm-6 col-xs-6">
            <?php if(px_opt('experience') != ''){ ?>
            <h2 class="experience-header"><?php echo px_opt('experience'); ?></h2>
            <?php } ?>
            <!--<div class="underline-box"></div>-->
        </div>
        <div class="print-box-container col-md-9 col-sm-6 col-xs-6">
            <a href="<?php echo $href ?>" class="print-box">
                <span class="icon-printer3"></span>
                <span class="text"><?php echo $text; ?></span>
            </a>
        </div>
    </div>
    <div class="experience-parts clearfix">
        <?php get_template_part('templates/loop-experience','posts') ?>
    </div>
</section>