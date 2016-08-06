<?php

require_once('post-type.php');

class PxCustompart extends PxPostType
{

    function __construct()
    {
        parent::__construct('custompart');
    }

    function Px_CreatePostType()
    {
        $labels = array(
            'name' => __( 'Custom Part', TEXTDOMAIN),
            'singular_name' => __( 'Custom Part', TEXTDOMAIN ),
            'add_new' => __('Add New', TEXTDOMAIN),
            'add_new_item' => __('Add New Custom Part', TEXTDOMAIN),
            'edit_item' => __('Edit Custom Part', TEXTDOMAIN),
            'new_item' => __('New Custom part', TEXTDOMAIN),
            'view_item' => __('View Custom part', TEXTDOMAIN),
            'search_items' => __('Search Custom Part', TEXTDOMAIN),
            'not_found' =>  __('No Custom part Foun', TEXTDOMAIN),
            'not_found_in_trash' => __('No Custom part found in Trash', TEXTDOMAIN),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' =>  $labels,
            'public' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_icon' => 'dashicons-star-filled',
            'rewrite' => array('slug' => __( 'custompart', TEXTDOMAIN ), 'with_front' => true),
            'supports' => array('title','editor')
        );

        register_post_type( $this->postType, $args );

    }

    function Px_RegisterScripts()
    {
        wp_register_script('education', THEME_LIB_URI . '/post-types/js/education.js', array('jquery'), THEME_VERSION);

        parent::Px_RegisterScripts();
    }

    function Px_EnqueueScripts()
    {
        wp_enqueue_script('hoverIntent');
        wp_enqueue_script('jquery-easing');
        wp_enqueue_style('theme-admin');
        wp_enqueue_script('theme-admin');
        wp_enqueue_style('nouislider');
        wp_enqueue_script('nouislider');
        wp_enqueue_style('theme-admin-css');
        wp_enqueue_script('theme-admin-script');
    }


    function Px_OnProcessFieldForStore($post_id, $key, $settings)
    {
        //Process media field
        if($key != 'media')
            return false;

        $selectedOpt = $_POST[$key];


        switch($selectedOpt)
        {

            default:
            {
                //Delete all
                delete_post_meta($post_id, "video-type");
                delete_post_meta($post_id, "video-id");
                delete_post_meta($post_id, "image");

                break;
            }
        }

        return false;
    }

    protected function Px_GetOptions()
    {
        $fields = array(
            'custompart-title-display'=> array(
                'type'  => 'switch',
                'label' => __('Display in menu',TEXTDOMAIN),
                'state0' => __('Don\'t show Section Title ', TEXTDOMAIN),
                'state1' => __('Show Title', TEXTDOMAIN),
                'value'  => 1,
                'default'=> 1
            ),
            'custompart-title-style'=> array(
                'type'  => 'switch',
                'label' => __('Title Style',TEXTDOMAIN),
                'state1' => __('Have a Background ', TEXTDOMAIN),
                'state0' => __('Have a Underline', TEXTDOMAIN),
                'value'  => 1,
                'default'=> 1
            ),
            'custompart-width'=> array(
                'type'  => 'switch',
                'label' => __('Custom part Width',TEXTDOMAIN),
                'state1' => __('Full Width ', TEXTDOMAIN),
                'state0' => __('In Container', TEXTDOMAIN),
                'value'  => 1,
                'default'=> 0
            ),
            'show-in-menu'=> array(
                'type'  => 'switch',
                'label' => __('Show In Header Menu',TEXTDOMAIN),
                'state1' => __('Show ', TEXTDOMAIN),
                'state0' => __('Do Not Show', 'TEXTDOMAIN'),
                'value'  => 1,
                'default'=> 1
            )
        );

        //Option sections
        $options = array(
            'Custompart Sectting' => array(
                'title'   => __('Custom Part Setting ', TEXTDOMAIN),
                'tooltip' => __('Enter your Custom Part section information here', TEXTDOMAIN),
                'fields'  => array(
                    'custompart-item-title'   => $fields['custompart-title-display'],
                    'custompart-item-style'   => $fields['custompart-title-style'],
                    'custompart-width'   => $fields['custompart-width'],
                    'show-in-menu'   => $fields['show-in-menu'],
                )
            ),//Education Section
        );

        return array(
            array(
                'id' => 'custompart_meta_box',
                'title' => __('Custom Part Options', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'default',
                'options' => $options,
            )//Meta box
        );
    }
}

new PxCustompart();