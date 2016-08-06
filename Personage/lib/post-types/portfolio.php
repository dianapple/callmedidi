<?php

require_once('post-type.php');

class PxPortfolio extends PxPostType
{

    function __construct()
    {
        parent::__construct('portfolio');
    }

    function Px_CreatePostType()
    {
        $labels = array(
            'name' => __( 'Portfolio', TEXTDOMAIN),
            'singular_name' => __( 'Portfolio', TEXTDOMAIN ),
            'add_new' => __('Add New', TEXTDOMAIN),
            'add_new_item' => __('Add New Portfolio', TEXTDOMAIN),
            'edit_item' => __('Edit Portfolio', TEXTDOMAIN),
            'new_item' => __('New Portfolio', TEXTDOMAIN),
            'view_item' => __('View Portfolio', TEXTDOMAIN),
            'search_items' => __('Search Portfolio', TEXTDOMAIN),
            'not_found' =>  __('No portfolios found', TEXTDOMAIN),
            'not_found_in_trash' => __('No portfolios found in Trash', TEXTDOMAIN),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' =>  $labels,
            'public' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_icon' => THEME_IMAGES_URI . '/gallery-icon.png',
            'rewrite' => array('slug' => __( 'portfolios', TEXTDOMAIN ), 'with_front' => true),
            'supports' => array('title',
                'editor',
                'thumbnail'
            )
        );

        register_post_type( $this->postType, $args );

        /* Register the corresponding taxonomy */

        register_taxonomy('skills', $this->postType,
            array("hierarchical" => true,
                "label" => __( "Skills", TEXTDOMAIN ),
                "singular_label" => __( "Skill",  TEXTDOMAIN ),
                "rewrite" => false//array('slug' => 'skill-type', 'hierarchical' => true)
            ));
    }

    function Px_RegisterScripts()
    {
        wp_register_script('portfolio', THEME_LIB_URI . '/post-types/js/portfolio.js', array('jquery'), THEME_VERSION);

        parent::Px_RegisterScripts();
    }

    function Px_EnqueueScripts()
    {
        wp_enqueue_script('hoverIntent');
        wp_enqueue_script('jquery-easing');

        wp_enqueue_style('theme-admin');
        wp_enqueue_script('theme-admin');

        wp_enqueue_script('portfolio');
    }


    function Px_OnProcessFieldForStore($post_id, $key, $settings)
    {
        //Process media field
        if($key != 'media')
            return false;

        $selectedOpt = $_POST[$key];
        switch($selectedOpt)
        {
            case "image":
            {

                //delete video meta
                delete_post_meta($post_id, "video-type");
                delete_post_meta($post_id, "video-id");

                $images = $_POST["image"];

                //Filter results
                $images = array_filter( array_map( 'trim', $images ), 'strlen' );
                //ReIndex
                $images = array_values($images);

                update_post_meta( $post_id, "image", $images );

                break;
            }
            case "video":
            {
                //Delete images
                delete_post_meta($post_id, "image");

                $videoType = $_POST["video-type"];
                $videoId   = $_POST["video-id"];

                update_post_meta( $post_id, "video-type", $videoType );
                update_post_meta( $post_id, "video-id", $videoId );

                break;
            }
            case "audio":
            {
                //Delete images
                delete_post_meta($post_id, "image");
                //delete video meta
                delete_post_meta($post_id, "video-type");
                delete_post_meta($post_id, "video-id");


                $audioURL = $_POST["audio-url"];

                update_post_meta( $post_id, "audio-url", $audioURL );

                break;
            }
            default:
                {
                //Delete all
                delete_post_meta($post_id, "video-type");
                delete_post_meta($post_id, "video-id");
                delete_post_meta($post_id, "image");
                delete_post_meta($post_id, "audio-url");

                break;
                }
        }

        return false;
    }

    protected function Px_GetOptions()
    {
        $fields = array(
            'media' => array(
                'type' => 'select',
                'options' => array(
                    'image' => __( "Image",  TEXTDOMAIN ),
                    'video' => __( "Video",  TEXTDOMAIN ),
                    'audio' => __( "Audio",  TEXTDOMAIN ),
                    'none'  => __( "None",   TEXTDOMAIN ),
                ),
            ),
            'image' => array(
                'type'  => 'upload',
                'title' => __('Portfolio Image', TEXTDOMAIN),
                'referer' => 'px-portfolio-image',
                'meta'  => array('array'=>true, 'dontsave'=>true),//This will indirectly get saved
            ),
            'video-type' => array(
                'type' => 'select',
                'class' => 'portfolio-video',
                'options' => array(
                    'vimeo' => __( "Vimeo",  TEXTDOMAIN ),
                    'youtube' => __( "YouTube",  TEXTDOMAIN ),
                ),
            ),
            'video-id' => array(
                'type' => 'text',
                'placeholder' => __('Video ID', TEXTDOMAIN),
            ),//video id
            'audio-url' => array(
                'type' => 'text',
                'placeholder' => __('SoundCloud URL', TEXTDOMAIN),
            ),//audio URL
        );

        //Option sections
        $options = array(
            'media' => array(
                'title'   => __('Portfolio Media Type', TEXTDOMAIN),
                'tooltip' => __('Specify what kind of media (Image(s), Video or Audio) you like to be displayed in single portfolio.', TEXTDOMAIN),
                'fields'  => array(
                    'media' => $fields['media']
                )
            ),//media sec
            'image' => array(
                'title'   => __('Portfolio Images', TEXTDOMAIN),
                'tooltip' => __('Upload your portfolio Image(s) here. If you upload more than one image it will be shown as slider', TEXTDOMAIN),
                'fields'  => array(
                    'image' => $fields['image']
                )
            ),//images sec
            'video' => array(
                'title'   => __('Portfolio Video', TEXTDOMAIN),
                'tooltip' => __('Choose the video sharing network and add the related video ID here, you can add the information about the video in WordPress text editor above this box.', TEXTDOMAIN),
                'fields'  => array(
                    'video-type' => $fields['video-type'],
                    'video-id' => $fields['video-id'],
                )
            ),//video sec
            'audio' => array(
                'title'   => __('Portfolio Audio', TEXTDOMAIN),
                'tooltip' => __('Enter the sound cloud audio URL here', TEXTDOMAIN),
                'fields'  => array(
                    'audio-url' => $fields['audio-url'],
                )
            )//audio sec
        );

        return array(
            array(
                'id' => 'portfolio_meta_box',
                'title' => __('Portfolio Options', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'default',
                'options' => $options,
            )//Meta box
        );
    }
}

new PxPortfolio();