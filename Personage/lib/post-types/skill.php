<?php

require_once('post-type.php');

class PxSkill extends PxPostType
{

    function __construct()
    {
        parent::__construct('skill');
    }

    function Px_CreatePostType()
    {
        $labels = array(
            'name' => __( 'Skills', TEXTDOMAIN),
            'singular_name' => __( 'Skill', TEXTDOMAIN ),
            'add_new' => __('Add New', TEXTDOMAIN),
            'add_new_item' => __('Add New Skill', TEXTDOMAIN),
            'edit_item' => __('Edit Skill', TEXTDOMAIN),
            'new_item' => __('New Skill', TEXTDOMAIN),
            'view_item' => __('View Skill', TEXTDOMAIN),
            'search_items' => __('Search Skill', TEXTDOMAIN),
            'not_found' =>  __('No skills found', TEXTDOMAIN),
            'not_found_in_trash' => __('No skills found in Trash', TEXTDOMAIN),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' =>  $labels,
            'public' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
			'menu_icon' => THEME_LIB_URI . '/admin/img/admin-panel-skill.png',
            'rewrite' => array('slug' => __( 'skills', TEXTDOMAIN ), 'with_front' => true),
            'supports' => array('title')
        );

        register_post_type( $this->postType, $args );

    }

    function Px_RegisterScripts()
    {
        wp_register_script('skill', THEME_LIB_URI . '/post-types/js/skill.js', array('jquery'), THEME_VERSION);

        parent::Px_RegisterScripts();
    }

    function Px_EnqueueScripts()
    {
        wp_enqueue_script('hoverIntent');
        wp_enqueue_script('jquery-easing');

        wp_enqueue_style('theme-admin');
        wp_enqueue_script('theme-admin');

        wp_enqueue_style('colorpicker0');
        wp_enqueue_script('colorpicker0');

        wp_enqueue_script('skill');
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
			'skill-item-title'=> array(
                'type'  => 'text',
                'label' => __('Skill Title',TEXTDOMAIN),
            ),
			'skill-item-percent'=> array(
                'type'  => 'text',
                'label' => __('Skill Percent',TEXTDOMAIN),
            ),
            'skill-start-color' => array(
                'type'  => 'color',
                'label' => __('Start Color',TEXTDOMAIN),
                'value' => '#66C4FF'
            ),
            'skill-end-color' => array(
                'type' => 'color' ,
                'label' => __('End Color',TEXTDOMAIN),
                'value' => '#6CE906'
            )
        );

        //Option sections
        $options = array(
			'Skill Sectting' => array(
                'title'   => __('Skill Setting ', TEXTDOMAIN),
                'tooltip' => __('Enter your skill section information here', TEXTDOMAIN),
                'fields'  => array(
					'skill-item-title'     => $fields['skill-item-title'],
					'skill-item-percent'   => $fields['skill-item-percent'],
                    'skill-start-color'    => $fields['skill-start-color'],
                    'skill-end-color'      => $fields['skill-end-color']
                )
            ),//Skill Section
        );

        return array(
            array(
                'id' => 'skill_meta_box',
                'title' => __('Skill Options', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'default',
                'options' => $options,
            )//Meta box
        );
    }
}

new PxSkill();