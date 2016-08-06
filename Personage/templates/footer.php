<?php
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

$footerWidgets = px_opt('footer_widgets');
if($footerWidgets=='') $footerWidgets = DEFAULT_FOOTER_WIDGETS;

//Check if there is a global override
if(2 == px_get_meta('footer-widget-area'))
    $footerWidgets = false;

?>
<footer id="page-footer">
    <?php if($footerWidgets){ ?>
        <div class="footer-widgets">
            <div class="container">
                <div class="row widget-area">
                    <?php
                    $widgetSize = 12 / $footerWidgets;

                    for($i = 1; $i <= $footerWidgets; $i++)
                    {
                        ?>
                        <div class="col-md-<?php echo $widgetSize ?> col-sm-<?php echo $widgetSize+1 ?>"><?php
                            /* Widgetised Area */
                            if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'footer-widget-' . $i ) ){}	?>
                            &nbsp;
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <!-- Footer Content -->
    <div class="content container">
        <div class="top-border"></div>
        <div class="clearfix copyright-text">
            <?php px_eopt('footer-copyright'); ?>
        </div>
        <!-- Social Icons -->
        <ul class="clearfix social-icons">
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
            foreach($icons as $key => $icon)
            {
                if(px_opt($key) != '')
                {
            ?>
            <li class="social-icon" ><a href="<?php echo esc_attr(px_opt($key)); ?>"><span class="<?php echo $icon; ?>"></span></a></li>
            <?php
                }//endif
            }
            ?>

        </ul>
    </div>

</footer>