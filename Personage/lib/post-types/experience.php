<?php

require_once('post-type.php');

class PxExperience extends PxPostType
{

    function __construct()
    {
        parent::__construct('experience');
    }

    function Px_CreatePostType()
    {
        $labels = array(
            'name' => __( 'Experience', TEXTDOMAIN),
            'singular_name' => __( 'Experience', TEXTDOMAIN ),
            'add_new' => __('Add New', TEXTDOMAIN),
            'add_new_item' => __('Add New Experience', TEXTDOMAIN),
            'edit_item' => __('Edit Experience', TEXTDOMAIN),
            'new_item' => __('New Experience', TEXTDOMAIN),
            'view_item' => __('View Experience', TEXTDOMAIN),
            'search_items' => __('Search Experience', TEXTDOMAIN),
            'not_found' =>  __('No experiences found', TEXTDOMAIN),
            'not_found_in_trash' => __('No experiences found in Trash', TEXTDOMAIN),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' =>  $labels,
            'public' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
			'menu_icon' => THEME_LIB_URI . '/admin/img/admin-panel-experience.png',
            'rewrite' => array('slug' => __( 'experiences', TEXTDOMAIN ), 'with_front' => true),
            'supports' => array('title')
        );

        register_post_type( $this->postType, $args );

    }

    function Px_RegisterScripts()
    {
        wp_register_script('experience', THEME_LIB_URI . '/post-types/js/experience.js', array('jquery'), THEME_VERSION);

        parent::Px_RegisterScripts();
    }

    function Px_EnqueueScripts()
    {
        wp_enqueue_script('hoverIntent');
        wp_enqueue_script('jquery-easing');

        wp_enqueue_style('theme-admin');
        wp_enqueue_script('theme-admin');

        wp_enqueue_script('experience');
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
			'exp-item-title'=> array(
                'type' => 'text',
                'label' => __('Experience Title',TEXTDOMAIN),
            ),
			'exp-item-duration'=> array(
                'type' => 'text',
                'label' => __('Experience Duration',TEXTDOMAIN),
            ),
			'exp-item-description'=> array(
                'type' => 'textarea',
                'label' => __('Experience Description',TEXTDOMAIN),
            ),
			'exp-item-icon' => array(
				'type'  => 'icon',
				'title' => __('Choose an icon', TEXTDOMAIN),
				'flags' => 'attribute',//CSV
			),
        );

        //Option sections
        $options = array(
			'Experience Sectting' => array(
                'title'   => __('Experience Setting ', TEXTDOMAIN),
                'tooltip' => __('Enter your experience section information here', TEXTDOMAIN),
                'fields'  => array(
					'exp-item-title'   => $fields['exp-item-title'],
					'exp-item-duration'   => $fields['exp-item-duration'],
					'exp-item-description'   => $fields['exp-item-description'],
					'exp-item-icon'   => $fields['exp-item-icon'],
                )
            ),//Experience Section
        );

        return array(
            array(
                'id' => 'experience_meta_box',
                'title' => __('Experience Options', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'default',
                'options' => $options,
            )//Meta box
        );
    }
}

new PxExperience();