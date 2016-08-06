<?php 

require_once('admin-base.php');

//Extended admin class
class PxAdmin extends PxThemeAdmin
{
	function Px_Save_Options()
	{
		//Check for import dummy data option
		if( array_key_exists('import-dummy-data', $_POST) && $_POST['import-dummy-data'] == '1')
		{
			//Don't save anything just Import data
            $this->Px_ImportDummyData($_POST['demo-dummy-data']);
			
			echo 'imported';
			die();
		}
		
		parent::Px_Save_Options();
	}

    function Px_ImportDummyData($demo = 'standard')
    {
        if(!class_exists( 'WP_Import' ))
        {
            //Try to use custom version of the plugin
            require_once THEME_INCLUDES . '/wordpress-importer/wordpress-importer.php';
        }

        $wp_import = new WP_Import();
		
		if( array_key_exists('import-media', $_POST) && $_POST['import-media'] == '1'){
            $wp_import->fetch_attachments = true;
        }
		
        ob_start();
        $wp_import->import(THEME_ADMIN.'/DummyData/'.$demo.'.xml');
        if( array_key_exists('import-theme-setting', $_POST) && $_POST['import-theme-setting'] == '1'){
            $options = unserialize(file_get_contents(THEME_ADMIN.'/DummyData/'.$demo.'.dat'));
            if ($options) {
                foreach ($options as $option) {
                    update_option($option->option_name, unserialize($option->option_value));
                }
            }
            update_option( 'show_on_front', px_opt('front_page_type') );
            update_option( 'page_on_front', px_opt('front_page_static_page') );
            update_option( 'page_for_posts', px_opt('front_page_posts_page') );
            //set navigation to theme locations
            $menus = array();
            $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
            if(count($menus)>0){
                $menu = $menus[0];
                $locations['primary-nav'] = $menu->term_id;
                $locations['mobile-nav'] = $menu->term_id;
                set_theme_mod('nav_menu_locations', $locations);
            }
        }
		
        ob_end_clean();//Prevents sending output to client
    }

	function Px_Enqueue_Scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('hoverIntent');
		wp_enqueue_script('jquery-easing');
		wp_enqueue_style('nouislider');
		wp_enqueue_script('nouislider');
		wp_enqueue_style('colorpicker0');
		wp_enqueue_script('colorpicker0');
		wp_enqueue_style('chosen');
		wp_enqueue_script('chosen');
		wp_enqueue_style('theme-admin-css');
		wp_enqueue_script('theme-admin-script');
        wp_enqueue_script('theme-admin-options', THEME_ADMIN_URI . '/scripts/options-panel.js');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_media();
	}
}

new PxAdmin();

require_once('sections.php');