<?php
$media = px_get_meta('media');
$mediaClass   = 'media-content';

?>
<!--Content Row-->
    <!-- image part -->
<div class="portfolio-container slider-popup container zoom-anim-dialog">
    <?php if($media != 'none'){ ?>
    <?php $contentClass = ''; ?>
        <div class="portfolio-media">
        <div class="<?php echo $mediaClass ?>">
            <?php
            if($media == 'video')
            {
                $vid   = px_get_meta('video-id');
                $vType = px_get_meta('video-type');
                ?>
                <div class="video-frame">
                    <?php
                    if($vType == 'youtube')
                    {?>
                        <iframe src="http://www.youtube.com/embed/<?php echo $vid; ?>" frameborder="0" allowfullscreen></iframe>
                    <?php
                    }
                    else
                    {?>
                        <iframe src="http://player.vimeo.com/video/<?php echo $vid; ?>?color=ff4c2f" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            elseif($media == 'image')//Image or slide show
            {
                $images = px_get_meta('image');
                if(count($images))
                {?>
                    <div class="flexslider clearfix">
                        <ul class="slides">
                            <?php
                            $imageSize = 'portfolio-single';
                            foreach($images as $img)
                            {
                                $imgId = px_get_image_id($img);
                                if($imgId == -1)//Fallback
                                    $imgTag = "<img src=\"$img\" />";
                                else
                                    $imgTag = wp_get_attachment_image($imgId, $imageSize);
                                ?>
                                <li><?php echo $imgTag; ?></li>
                            <?php
                            }?>
                        </ul>
                    </div>
                    <?php if(count($images) > 1){ ?>
                    <div class="slider-nav-controls-container"></div>
                    <?php } ?>
                <?php
                }
            }
            elseif($media == 'audio')//audio
            {
                $audio = px_get_meta('audio-url');
                if($audio != null)
                {
                    //Extract video ID
                    ?>
                    <div class="post-media audio-frame">
                        <?php
                        echo px_soundcloud_get_embed($audio);
                        ?>
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </div>
    <?php }else{
        $contentClass = 'porfolio-content-full';
    } ?>
    <div class="portfolio-description <?php echo $contentClass ?>">
        <?php the_content(); ?>
    </div>
</div>