<?php
/**
 * Biography Section
 */

if (px_opt('color-detector') && px_opt('background-type') == 'image'){
    wp_enqueue_script('bg-check',px_path_combine(THEME_JS_URI,'background-check.js'),array('jquery'),'',true);
    $arr = array(
        "detector" => 1
    );
    wp_localize_script('mainjs','state',$arr);
}else{
    $arr = array(
        "detector" => 0
    );
    wp_localize_script('mainjs','state',$arr);
}
if(px_opt('background-type') == 'video')
{
    wp_enqueue_script('bg-video',px_path_combine(THEME_JS_URI,'jquery.videoBG.js'),array('jquery'),THEME_VERSION,true);
    $video_options = array(
        'type'      => 'video',
        'altImg'    => px_opt('bg-video-poster'),
        'videoFile'    => array(
            'mp4' => px_opt('bg-video-mp4'),
            'ogg' => px_opt('bg-video-ogg'),
            'webm' => px_opt('bg-video-webm'),
        )
    );
    wp_localize_script( 'mainjs', 'param', $video_options );


}
// Generating inline style for overlay setting (Read from page template setting)
$overlay_type = px_opt('overlay-type');
$texture = $opacity = $gradient = false;
if($overlay_type == 'opacity' || $overlay_type == 'opacity-texture' || $overlay_type == 'gradient')
{
    $opacity = true;
    $overlay_opacity = px_opt('overlay-opacity');
    $overlay_color   = px_opt('overlay-color');
    $overlay_opacity = ($overlay_opacity > 100)?100:$overlay_opacity;
    $overlay_opacity = ($overlay_opacity < 1)?1:$overlay_opacity;
    $overlay_opacity = $overlay_opacity / 100;
    if ($overlay_color == ''){
        $overlay_color="#000000";
    }

    $overlay_color = implode(', ', PxColor::Px_HexToRgb($overlay_color));
}
if($overlay_type == 'texture' || $overlay_type == 'opacity-texture'){
    $texture = true;
    $overlay_texture = px_opt('overlay-texture');
    $overlay_texture_path = px_path_combine(THEME_ADMIN_URI,'img/texture/'.$overlay_texture.'.png');
}

if($overlay_type == 'gradient' ){
    $gradient = true;
    $gradientFirstColor = px_opt("overlay-gradient1");
    $gradientSecondColor = px_opt("overlay-gradient2");
    $gradientFirstColor = implode(', ', PxColor::Px_HexToRgb($gradientFirstColor));
    $gradientSecondColor = implode(', ', PxColor::Px_HexToRgb($gradientSecondColor));
}

//$overlayClass = "";
$overlayClass = (px_opt('animation')== "1")?'animation' : "";

if($overlay_type != 'no'){
    $overlay="";

    if(true == $opacity && true == $texture){
        $overlay .= " background-image:url(". $overlay_texture_path .");";
        $overlay .= " background-color:rgba($overlay_color , $overlay_opacity );";
    }elseif($texture == true && $gradient == false ){
        $overlay .= " background-image:url(". $overlay_texture_path .");";
    }elseif($texture == false && $gradient== false){
        $overlay .= " background-color:rgba(".$overlay_color.",".$overlay_opacity.");";
    }elseif ($gradient == true){
        $overlay .= " background-image:linear-gradient(129deg,rgba(".$gradientFirstColor.",".$overlay_opacity."),rgba(".$gradientSecondColor.",".$overlay_opacity."))";
    }

    $overlayClass .= " header-overly";
    ?>
    <style>
        .header-overly{
        <?php
            echo $overlay;
        ?>
        }
    </style>
<?php
}
$height = px_opt("intro-height");
$height =($height=="")?"650px":px_opt("intro-height")."px";

?>
<section id="intro" class="container-fluid <?php echo $overlayClass; ?>" style="height: <?php echo $height ;?>">
    <?php
    if(px_opt('background-type') == 'image'){
        ?>
        <div class="flexslider" style="z-index:-100;overflow:hidden;height: <?php echo $height;?>">
            <ul class="slides">
                <?php
                $slides = px_opt('bg-images');
                if(is_array($slides) && count($slides)>0){
                    foreach($slides as $slide){
                        ?>
                        <li>
                            <div style='background-image:url(<?php echo $slide ?>); background-size: cover;height:<?php echo $height ;?>'></div>
                            <img class="intro-img" src="" style="visibility: hidden ">
                        </li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>
    <?php
    }
    ?>
    <div class="container">
        <?php if(px_opt("bio-image")){ ?>
            <div class="face-photo-container">
                <div class="face-photo" style="background-image: url(<?php echo px_opt("bio-image"); ?>);"></div>
                <img src="<?php echo px_opt("bio-image"); ?>" class="face-pic " >
            </div>
        <?php } ?>
        <div class="about">
            <?php if(px_opt("bio-title")){ ?>
                <h2 class="about-name"><?php echo px_opt('bio-title'); ?></h2>
            <?php } ?>
            <?php if(px_opt("bio-title") != '' && px_opt("bio-text") != ''){ ?>
                <div class="separator-container">
                    <div class="separator"></div>
                </div>
            <?php } ?>
            <?php if(px_opt("bio-text")){ ?>
                <div class="description-container">
                    <p class="description"><?php echo px_opt("bio-text"); ?></p>
                </div>
            <?php } ?>
            <?php if(px_opt("signature-image")){ ?>
                <div class="signature">
                    <img src="<?php echo px_opt('signature-image'); ?>">
                </div>
            <?php } ?>
        </div>
    </div>
</section>
