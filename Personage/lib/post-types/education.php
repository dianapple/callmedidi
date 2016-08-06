<?php

require_once('post-type.php');

class PxEducation extends PxPostType
{

    function __construct()
    {
        parent::__construct('education');
    }

    function Px_CreatePostType()
    {
        $labels = array(
            'name' => __( 'Education', TEXTDOMAIN),
            'singular_name' => __( 'Education', TEXTDOMAIN ),
            'add_new' => __('Add New', TEXTDOMAIN),
            'add_new_item' => __('Add New Education', TEXTDOMAIN),
            'edit_item' => __('Edit Education', TEXTDOMAIN),
            'new_item' => __('New Education', TEXTDOMAIN),
            'view_item' => __('View Education', TEXTDOMAIN),
            'search_items' => __('Search Education', TEXTDOMAIN),
            'not_found' =>  __('No educations found', TEXTDOMAIN),
            'not_found_in_trash' => __('No educations found in Trash', TEXTDOMAIN),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' =>  $labels,
            'public' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_icon' => THEME_LIB_URI . '/admin/img/admin-panel-education.png',
            'rewrite' => array('slug' => __( 'educations', TEXTDOMAIN ), 'with_front' => true),
            'supports' => array('title')
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

        wp_enqueue_script('education');
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
			'education-item-title'=> array(
                'type' => 'text',
                'label' => __('Education Title',TEXTDOMAIN),
            ),
			'education-item-duration'=> array(
                'type' => 'text',
                'label' => __('Education Duration',TEXTDOMAIN),
            ),
			'education-item-description'=> array(
                'type' => 'textarea',
                'label' => __('Education Description',TEXTDOMAIN),
            ),
			'education-item-icon' => array(
				'type'  => 'icon',
				'title' => __('Choose an icon', TEXTDOMAIN),
				'flags' => 'attribute',//CSV
			),
        );

        //Option sections
        $options = array(
			'Education Sectting' => array(
                'title'   => __('Education Setting ', TEXTDOMAIN),
                'tooltip' => __('Enter your education section information here', TEXTDOMAIN),
                'fields'  => array(
					'education-item-title'   => $fields['education-item-title'],
					'education-item-duration'   => $fields['education-item-duration'],
					'education-item-description'   => $fields['education-item-description'],
					'education-item-icon'   => $fields['education-item-icon'],
                )
            ),//Education Section
        );

        return array(
            array(
                'id' => 'education_meta_box',
                'title' => __('Education Options', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'default',
                'options' => $options,
            )//Meta box
        );
    }
}

new PxEducation();