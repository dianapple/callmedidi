<?php

require_once(THEME_LIB . '/forms/fieldtemplate.php');
require_once(THEME_LIB . '/forms/post-options-provider.php');

abstract class PxPostType
{
    protected $postType;

    function __construct($postType)
    {
        $this->postType = $postType;

        add_action( 'init', array(&$this, 'Px_CreatePostType') );

        add_action('add_meta_boxes', array(&$this, 'Px_AddMetaBoxes'));
        add_action('admin_print_scripts-post-new.php', array( &$this, 'Px_InitScripts' ));
        add_action('admin_print_scripts-post.php', array( &$this, 'Px_InitScripts' ));

        /* Save post meta on the 'save_post' hook. */
        add_action( 'save_post', array( &$this, 'Px_SaveData' ), 10, 2 );
    }

    function Px_SaveData($post_id = false, $post = false)
    {
        /* Verify the nonce before proceeding. */
        $nonce = THEME_NAME_SEO . '_post_nonce';

        if ( !isset( $_POST[$nonce] ) || !wp_verify_nonce( $_POST[$nonce], 'theme-post-meta-form' ) )
            return $post_id;

        // check autosave
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return $post_id;


        if( $post->post_type != $this->postType || !current_user_can('edit_post', $post_id))
            return $post_id;

        //CRUD Operation
        foreach( $this->Px_GetOptionsForStore() as $key => $settings )
        {
            //Let the derived class intercept the process
            if($this->Px_OnProcessFieldForStore($post_id, $key, $settings))
                continue;

            $postedVal = isset( $_POST[$key] ) ? $_POST[$key] : '';
            $val       = get_post_meta( $post_id, $key, true );

            //Insert
            if ( $postedVal != '' && $val == '' )
            {
                add_post_meta( $post_id, $key, $postedVal, true );
            }
            //Delete
            elseif ( $val != '' && $postedVal == '' )
            {
                delete_post_meta( $post_id, $key );

                //Delete the attachment as well
                if($settings['type'] == 'upload')
                {
                    px_delete_attachment($val);
                }
            }
            //Update
            elseif ( $postedVal != $val )
            {
                update_post_meta( $post_id, $key, $postedVal );
            }


        }

        return $post_id;
    }

    function Px_OnProcessFieldForStore($post_id, $key, $settings)
    {
        return false;
    }

    function Px_CreatePostType()
    {

    }

    protected function Px_GetOptionsForStore()
    {
        $options = $this->Px_GetOptions();
        $values  = array();

        foreach($options as $box)
        {
            foreach($box['options'] as $section)
            {
                foreach($section['fields'] as $key => $field)
                {
                    $ignore = px_array_value('dontsave', px_array_value('meta', $field, array()), false);

                    if($ignore)
                        continue;

                    $values[$key] = $field;
                }
            }
        }

        return $values;
    }

    protected function Px_GetOptions()
    {
        return array();
    }

    function Px_AddMetaBoxes()
    {
        $options = $this->Px_GetOptions();

        foreach($options as $box)
        {

            add_meta_box(
                $box['id'], // $id
                $box['title'], // $title
                array(&$this, 'Px_ShowMetaBox'), // $callback
                $this->postType, // $page
                $box['context'], // $context
                $box['priority'],// $priority
                $box['options']
            );

        }

    }

    function Px_ShowMetaBox($post, $metabox)
    {
        $args = $metabox['args'];

        $form = new PxFieldTemplate(new PxPostOptionsProvider(), dirname(__FILE__));

        echo $form->Px_GetTemplate('meta-form', $args);
    }


    function Px_InitScripts()
    {
        global $post_type;

        if( $post_type != $this->postType )
            return;

        $this->Px_RegisterScripts();
        $this->Px_EnqueueScripts();
    }

    protected function Px_RegisterScripts()
    {
        wp_register_script('jquery-easing', THEME_ADMIN_URI  .'/scripts/jquery.easing.1.3.js', array('jquery'), '1.3.0');

        wp_register_style( 'nouislider', THEME_ADMIN_URI . '/css/nouislider.css', false, '2.1.4', 'screen' );
        wp_register_script('nouislider', THEME_ADMIN_URI  .'/scripts/jquery.nouislider.min.js', array('jquery'), '2.1.4');

        wp_register_style( 'colorpicker0', THEME_ADMIN_URI . '/css/colorpicker.css', false, '1.0.0', 'screen' );
        wp_register_script('colorpicker0', THEME_ADMIN_URI  .'/scripts/colorpicker.js', array('jquery'), '1.0.0');

        wp_register_style( 'chosen', THEME_ADMIN_URI . '/css/chosen.css', false, '1.0.0', 'screen' );
        wp_register_script('chosen', THEME_ADMIN_URI  .'/scripts/chosen.jquery.min.js', array('jquery'), '1.0.0');

        wp_register_style( 'theme-admin', THEME_ADMIN_URI . '/css/style.css', false, '1.0.0', 'screen' );
        wp_register_script('theme-admin', THEME_ADMIN_URI  .'/scripts/admin.js', array('jquery'), '1.0.0');
    }

    protected function Px_EnqueueScripts()
    {
        wp_enqueue_script('hoverIntent');
        wp_enqueue_script('jquery-easing');

        wp_enqueue_style('nouislider');
        wp_enqueue_script('nouislider');

        wp_enqueue_style('colorpicker0');
        wp_enqueue_script('colorpicker0');

        wp_enqueue_style('chosen');
        wp_enqueue_script('chosen');

        wp_enqueue_style('theme-admin');
        wp_enqueue_script('theme-admin');
    }
}