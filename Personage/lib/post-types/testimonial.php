<?php

require_once('post-type.php');

class PxTestimonial extends PxPostType
{

    function __construct()
    {
        parent::__construct('testimonial');
    }

    function Px_CreatePostType()
    {
        $labels = array(
            'name' => __( 'Testimonials', TEXTDOMAIN),
            'singular_name' => __( 'Testimonial', TEXTDOMAIN ),
            'add_new' => __('Add New', TEXTDOMAIN),
            'add_new_item' => __('Add New Testimonial', TEXTDOMAIN),
            'edit_item' => __('Edit Testimonial', TEXTDOMAIN),
            'new_item' => __('New Testimonial', TEXTDOMAIN),
            'view_item' => __('View Testimonial', TEXTDOMAIN),
            'search_items' => __('Search Testimonial', TEXTDOMAIN),
            'not_found' =>  __('No testimonials found', TEXTDOMAIN),
            'not_found_in_trash' => __('No testimonials found in Trash', TEXTDOMAIN),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' =>  $labels,
            'public' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
			'menu_icon' => THEME_LIB_URI . '/admin/img/admin-panel-testimonial.png',
            'rewrite' => array('slug' => __( 'testimonials', TEXTDOMAIN ), 'with_front' => true),
            'supports' => array('title',
                'editor',
                'thumbnail'
            )
        );

        register_post_type( $this->postType, $args );

    }

    function Px_RegisterScripts()
    {
        wp_register_script('testimonial', THEME_LIB_URI . '/post-types/js/testimonial.js', array('jquery'), THEME_VERSION);

        parent::Px_RegisterScripts();
    }

    function Px_EnqueueScripts()
    {
        wp_enqueue_script('hoverIntent');
        wp_enqueue_script('jquery-easing');


        wp_enqueue_style('theme-admin');
        wp_enqueue_script('theme-admin');

        wp_enqueue_script('testimonial');
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
			'testimonial-item-title'=> array(
                'type' => 'text',
                'label' => __('Testimonial Title',TEXTDOMAIN),
            ),
			'testimonial-item-subtitle'=> array(
                'type' => 'text',
                'label' => __('Testimonial Subtitle',TEXTDOMAIN),
            ),
			'testimonial-item-description'=> array(
                'type' => 'textarea',
                'label' => __('Testimonial Description',TEXTDOMAIN),
            )
        );

        //Option sections
        $options = array(
			'Testimonial Sectting' => array(
                'title'   => __('Testimonial Setting ', TEXTDOMAIN),
                'tooltip' => __('Enter your testimonial section information here', TEXTDOMAIN),
                'fields'  => array(
					'testimonial-item-title'   => $fields['testimonial-item-title'],
					'testimonial-item-subtitle'   => $fields['testimonial-item-subtitle'],
					'testimonial-item-description'   => $fields['testimonial-item-description']
                )
            ),//Testimonial Section
        );

        return array(
            array(
                'id' => 'testimonial_meta_box',
                'title' => __('Testimonial Options', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'default',
                'options' => $options,
            )//Meta box
        );
    }
}

new PxTestimonial();