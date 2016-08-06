<?php
/**
  * Contact Section
 */
$mapdata = array(
    'type' =>   'contact',
    'contactMedia' => px_opt('contact-media-type'),
    'contactMediaImage' => px_opt('contact-image'),
    'contactMediaMap' => array(
        'style' => px_opt('map-style'),
        'zoom' => px_opt('map-zoom'),
        'address' => px_opt('map-address'),
        'latitude' => px_opt('map-latitude'),
        'longitude' => px_opt('map-longitude'),
        'marker' => px_opt('map-marker'),
    ),

);
wp_enqueue_script('contact-js',px_path_combine(THEME_JS_URI,'contact.js'),array(),THEME_VERSION,true);
wp_localize_script( 'contact-js', 'contactParam', $mapdata );
?>
<div id="contact-topbar" class="contact-topbar container-fluid">
    <div class="control-bar container">
        <a href="#" title="Close" class="close-btn"></a>
    </div>
    <div class="wrapper container">
        <div class="gmap">
            <div id="contact-map"></div>
            <ul class="social-icons clearfix">
                <?php
                $icons = array(
                    'social_facebook_url' => 'icon-facebook5',//Facebook
                    'social_twitter_url'  => 'icon-twitter5 ',//twitter
                    'social_vimeo_url'    => 'icon-vimeo2',//vimeo
                    'social_youtube_url'  => 'icon-youtube',//youtube
                    'social_googleplus_url' => 'icon-googleplus',//Google+
                    'social_dribbble_url' => 'icon-dribbble3',//dribbble
                    'social_tumblr_url'   => 'icon-tumblr2',//Tumblr
                    'social_linkedin_url' => 'icon-linkedin',//LinkedIn
                    'social_flickr_url'   => 'icon-flickr4',//flickr
                    'social_forrst_url'   => 'icon-forrst2',//forrst
                    'social_github_url'   => 'icon-github5',//GitHub
                    'social_lastfm_url'   => 'icon-lastfm2',//Last.fm
                    'social_paypal_url'   => 'icon-paypal3',//Paypal
                    'social_rss_url'      => 'icon-feed3',//rss
                    'social_skype_url'    => 'icon-skype',//skype
                    'social_wordpress_url'=> 'icon-wordpress2',//wordpress
                    'social_yahoo_url'    => 'icon-yahoo',//yahoo
                    'social_deviantart_url' => 'icon-deviantart2',//DeviantArt
                    'social_steam_url'    => 'icon-steam2',//Steam
                    'social_reddit_url'   => 'icon-reddit',//reddit
                    'social_stumbleupon_url' => 'icon-stumbleupon2',//StumbleUpon
                    'social_pinterest_url' => 'icon-pinterest',//Pinterest
                    'social_xing_url'      => 'icon-xing2 ',//XING
                    'social_blogger_url'   => 'icon-blogger2',//Blogger
                    'social_soundcloud_url' => 'icon-soundcloud2',//SoundCloud
                    'social_delicious_url'  => 'icon-delicious',//delicious
                    'social_foursquare_url' => 'icon-foursquare',//Foursquare
                    'social_instagram_url'  => 'icon-instagram',//instagram
                );
                if(px_opt('social_icon_target')!=''){
                    $tagrget=(px_opt('social_icon_target'))?"_blank":"_same";
                }
                else{
                    $tagrget="_blank";
                }

                foreach($icons as $key => $icon)
                {
                    if(px_opt($key) != '')
                    {
                        ?>
                        <li class="social-icon">
                            <a target="<?php echo $tagrget ?>" href="<?php echo esc_attr(px_opt($key)); ?>">
                                <span class="<?php echo $icon; ?>"></span>
                            </a>
                        </li>
                    <?php
                    }//endif
                }
                ?>

            </ul>
        </div>
        <div class="contact-form">
            <div class="clearfix">
                <div class="contact-title-container">
                    <h2 class="contact-header"><?php echo (px_opt('contact-title')=="")?__("CONTACT ME",TEXTDOMAIN):px_opt('contact-title')?></h2>
                    <div class="underline-box"></div>
                </div>
                <div class="contact-text">
                    <?php if(px_opt('contact-address')!= ""){ ?>
                        <p><?php echo __('Address: ',TEXTDOMAIN) . px_opt('contact-address'); ?></p>
                    <?php }if(px_opt('contact-phone')!= ""){ ?>
                        <p><?php echo __('Phone: ',TEXTDOMAIN). px_opt('contact-phone'); ?></p>
                    <?php } if(px_opt('contact-email')!= ""){ ?>
                        <p><?php echo  __('Email: ',TEXTDOMAIN). px_opt('contact-email'); ?></p>
                    <?php } ?>
                </div>
                <div class="form">
                    <?php
                    $form_shortcode= px_opt('contact-form');
                    $form_shortcode = stripslashes($form_shortcode);
                    echo do_shortcode($form_shortcode);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>