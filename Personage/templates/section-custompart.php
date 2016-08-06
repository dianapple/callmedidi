<?php
$display_title=get_post_meta($my_postid,'custompart-item-title',true)?"block":"none";
$style_title=get_post_meta($my_postid,'custompart-item-style',true)?"have-background":"have-underline";
$section_width=get_post_meta($my_postid,'custompart-width',true)?"full-width":"container";
?>

<section id="<?php echo $my_postid ?>" class="<?php echo $section_width ?> custom-part custom-part-<?php echo $my_postid ?>">

    <?php if($style_title=="have-background"){
    ?>
        <div class="clearfix" style="display:<?php echo $display_title; ?>" >
            <div class="custom-part-header-container col-md-3 col-sm-6 col-xs-6 ">
                <h2 class="custom-part-title <?php echo $style_title ?>"><?php echo(esc_attr(get_the_title($my_postid))); ?></h2>
            </div>
        </div>
    <?php }
    else{
    ?>
        <div class="col-md-3 col-xs-12">
            <div class="custom-part-text"><?php echo(esc_attr(get_the_title($my_postid))); ?></div>
            <div class="underline-box"></div>
        </div>
    <?php
    }
    ?>



    <div class="custom-part-content col-md-12">

    <?php
    $content_post = get_post($my_postid);
    if(!is_null($content_post)){
        $content = $content_post->post_content;
        $content = apply_filters('the_content', $content);
        echo $content;
    }
    else{
        echo("No Custom Part Found With This ID");
    }
    ?>
    </div>
</section>