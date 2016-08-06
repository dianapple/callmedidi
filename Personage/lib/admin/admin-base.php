<?php

require_once('mediabox-strings.php');
include_once('form-settings.php');
include_once('backup-options.php');

class PxThemeAdmin
{
	function __construct() {
		$this->Px_Activation();
		
		add_action("admin_menu", array( &$this, "Px_Setup_Menus"));
        add_action( 'admin_bar_menu', array(&$this,'Px_toolbar_link_theme_setting'), 999 );
		add_action('admin_enqueue_scripts', array(&$this, 'Px_Admin_Scripts'));
		add_action('admin_init', array(&$this, 'Px_Admin_Init') );
		add_action('after_setup_theme', array(&$this, 'Px_After_Setup') );
		add_action('wp_ajax_theme_save_options', array(&$this, 'Px_Save_Options'));
	}

    function Px_toolbar_link_theme_setting( $wp_admin_bar ) {
        $args = array(
            'id'    => 'theme_setting',
            'title' => __('Pixflow Theme Setting',TEXTDOMAIN),
            'parent'=> 'site-name',
            'href'  => admin_url("admin.php?page=theme_settings"),
            'meta'  => array( 'class' => 'my-toolbar-page' ),
        );
        $wp_admin_bar->add_node( $args );
    }


	
	function Px_Save_Options()
	{
		$options = get_option( OPTIONS_KEY );
		
		foreach($options as $key => $value)
		{
			$newVal = isset($_POST[$key]) ? $_POST[$key] : '';
			$options[$key] = stripslashes_deep($newVal);
		}
		
		update_option(OPTIONS_KEY, $options);
		
		echo 'OK';
		die(); // this is required to return a proper result
	}

	function Px_After_Setup()
	{
		//Initialize default options
		//delete_option(OPTIONS_KEY);
		$options  = get_option( OPTIONS_KEY );
		$defaults = px_admin_get_defaults();
		
		// Are our options saved in the DB?  
		if ( false !== $options ) 
		{
			$changed = false;
			//Add new keys if any
			foreach($defaults as $key => $value)
			{
				if(!array_key_exists($key, $options))
				{
					//Add default value
					$options[$key] = $value;
					$changed = true;
				}
			}
			
			//Check if any key removed from defaults
			foreach($options as $key => $value)
			{
				if(!array_key_exists($key, $defaults))
				{
					//Remove the option
					unset($options[$key]);
					$changed = true;
				}
			}
			
			if($changed)
				update_option(OPTIONS_KEY, $options);
			
			return;
		}
			
		// If not, we'll save our default options  
		add_option( OPTIONS_KEY, $defaults );
	}
	
	function Px_Activation()
	{
	    // Redirect To Theme Options Page on Activation
		if (isset($_GET['activated'])){
			wp_redirect(admin_url("admin.php?page=theme_settings"));
		}
	}
	
	function Px_Setup_Menus() {
		add_theme_page(THEME_NAME, 'Theme Settings', 'manage_options',  
		'theme_settings', array(&$this, 'Px_Admin_Page'));
	}
	
	function Px_Admin_Init()
	{
		if(in_array($GLOBALS['pagenow'], array('media-upload.php', 'async-upload.php'))) {  
			// Now we'll replace the 'Insert into Post Button' inside Thickbox  
			add_filter( 'gettext', array(&$this, 'Px_Replace_Thickbox_Text')  , 1, 3 );
		}

        wp_enqueue_style( 'px-popup-font', 'http://fonts.googleapis.com/css?family=Ubuntu|Muli', false, '1.0', 'all' );
        wp_enqueue_style( 'chosen', THEME_ADMIN_URI . '/css/chosen.css' );
        wp_enqueue_style( 'icomoon', THEME_CSS_URI . '/icomoon.css' );
        wp_enqueue_style( 'elegant', THEME_CSS_URI . '/elegant.css' );
	}
	
	function Px_Replace_Thickbox_Text($translated_text, $text, $domain)
	{
		if ('Insert into Post' == $text) { 
		
			$texts = px_get_mediaBox_strings();
			
			foreach($texts as $key => $value)
			{
				$referer = strpos( wp_get_referer(), $key ); 
			
				if ( $referer !== false ) { 
					return $value;  
				}
	
			}
			
		}
		
		return $translated_text; 
	}
	
	function Px_Admin_Page()
	{
		$page = include(THEME_ADMIN . '/forms.php');
	}
	
	function Px_Admin_Scripts()
	{
		if (!isset($_GET['page']) || $_GET['page'] != 'theme_settings' ) 
			return;
		
		$this->Px_Register_Scripts();
		$this->Px_Enqueue_Scripts();
	}
	
	function Px_Register_Scripts()
	{
		wp_register_script('jquery-easing', THEME_ADMIN_URI  .'/scripts/jquery.easing.1.3.js', array('jquery'), '1.3.0');
		
		wp_register_style( 'nouislider', THEME_ADMIN_URI . '/css/nouislider.css', false, '2.1.4', 'screen' );
		wp_register_script('nouislider', THEME_ADMIN_URI  .'/scripts/jquery.nouislider.min.js', array('jquery'), '2.1.4');
		//wp_enqueue_script('nouislider', THEME_ADMIN_URI  .'/scripts/jquery.nouislider.js', array('jquery'), '2.1.4');
		
		wp_register_style( 'colorpicker0', THEME_ADMIN_URI . '/css/colorpicker.css', false, '1.0.0', 'screen' );
		wp_register_script('colorpicker0', THEME_ADMIN_URI  .'/scripts/colorpicker.js', array('jquery'), '1.0.0');
		
		wp_register_style( 'chosen', THEME_ADMIN_URI . '/css/chosen.css', false, '1.0.0', 'screen' );
		wp_register_script('chosen', THEME_ADMIN_URI  .'/scripts/chosen.jquery.min.js', array('jquery'), '1.0.0');
		
		wp_register_style( 'theme-admin-css', THEME_ADMIN_URI . '/css/style.css', false, '1.0.0', 'screen' );
		wp_register_script('theme-admin-script', THEME_ADMIN_URI  .'/scripts/admin.js', array('jquery'), '1.0.0');
	}
	
	function Px_Enqueue_Scripts()
	{

	}
	
}