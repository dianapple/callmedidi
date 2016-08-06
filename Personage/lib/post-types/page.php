<?php

require_once('post-type.php');

class PxPage extends PxPostType
{
    function __construct()
    {
        parent::__construct('page');
    }

    function Px_RegisterScripts()
    {
        wp_register_script('page', THEME_LIB_URI . '/post-types/js/page.js', array('jquery'), THEME_VERSION);
        parent::Px_RegisterScripts();
    }

    function Px_EnqueueScripts()
    {
        wp_enqueue_script('hoverIntent');
        wp_enqueue_script('jquery-easing');

        wp_enqueue_script('nouislider');
        wp_enqueue_style('nouislider');

        wp_enqueue_style('theme-admin');
        wp_enqueue_script('theme-admin');

        wp_enqueue_script('colorpicker0');
        wp_enqueue_style('colorpicker0');

        wp_enqueue_script('page');
    }
	
	function createMapZoomLevelOptions($lenght=19){
		for($i=1; $i<=$lenght; $i++){ 
			$zoomArr[$i] = 'Zoom ' . $i;
		}
		return $zoomArr;
	}
	
	function OnProcessFieldForStore($post_id, $key, $settings)
    {
        //Process gallery field
        if($key != 'bg-images')
            return false;

        $images = $_POST["bg-images"];

        //Filter results
        $images = array_filter( array_map( 'trim', $images ), 'strlen' );
        //ReIndex
        $images = array_values($images);

        update_post_meta( $post_id, "bg-images", $images );

        return true;
    }

    private function Px_GetSidebars()
    {
        $sidebars = array('no-sidebar' => '' , 'Main Sidebar' => __('Main Sidebar', TEXTDOMAIN), 'Page Sidebar' => __('Default Page Sidebar', TEXTDOMAIN));
        $sidebars = array_merge($sidebars, px_get_custom_sidebars());

        return $sidebars;
    }


    protected function Px_GetOptions()
    {
        $fields = array(
            'contact-background-type'=>array(
                'type'    => 'select',
                'label'   => 'Background type',
                'attributes' => 'data-fields=".contact-background-image,.contact-background-map"',
                'options' => array('no'=>'None','image'=>'Image','map'=>'Map'),
                'option-attributes' =>array('no'=>'','image'=>'data-show=".contact-background-image"','map'=>'data-show=".contact-background-map"'),
                'default' =>'no',
                'class'   =>'show-select child-select field-selector background-view'
            ),
			'overlay-type'=>array(
                'type'    => 'select',
                'label'   => 'Overlay type',
                'attributes' => 'data-fields=".overlay-opacity,.overlay-texture,.overlay-texture-opacity"',
                'options' => array('no'=>'None','opacity'=>'Opacity','texture'=>'Texture','opacity-texture'=>'Opacity & Texture'),
                'option-attributes' =>array('no'=>'','opacity'=>'data-show=".overlay-opacity"','texture'=>'data-show=".overlay-texture"','opacity-texture'=>'data-show=".overlay-texture-opacity"'),
                'default' =>'no',
                'class'   =>'show-select child-select field-selector overlay-view'
            ),
            'sidebar' => array(
                'type' => 'select',
                'label'   => 'Sidebar',
                'options' => $this->Px_GetSidebars(),
                'default' => '0',
                'class'   =>'show-select'
            ),
			'contact-bg-image' => array(
                'type'  => 'upload',
				'class'   => 'contact-background-image',
                'title' => __('Background Image', TEXTDOMAIN),
                'label'=> __('Background Image:', TEXTDOMAIN),
                'referer' => 'px-contact-background-image',
            ),
			'contact-map-marker' => array(
                'type'  => 'upload',
				'class'   => 'contact-background-map',
                'title' => __('Map Marker Image', TEXTDOMAIN),
                'label'=> __('Map Marker Image(PNG)', TEXTDOMAIN),
                'referer' => 'px-contact-map-marker',
            ),
			'contact-map-style' => array(
                'type'    => 'select',
                'label'=> __('Choose Map style:', TEXTDOMAIN),
                'options' => array('dark'=>'Custom PixFlow Map','normal'=>'Standard Google Map'),
                'default' =>'dark',
                'class'   =>'show-select field-selector contact-background-map'
            ),
			'contact-map-address'=> array(
                'type' => 'text',
                'placeholder' => __('Google Map Address', TEXTDOMAIN),
                'class'   => 'contact-background-map',
                'label' => __('Map Address',TEXTDOMAIN),
            ),
			'contact-map-latitude'=> array(
                'type' => 'text',
                'placeholder' => __('Google Maps latitude', TEXTDOMAIN),
                'class'   => 'contact-background-map',
                'label' => __('Map latitude value',TEXTDOMAIN),
            ),
			'contact-map-longitude'=> array(
                'type' => 'text',
                'placeholder' => __('Google Maps longitude', TEXTDOMAIN),
                'class'   => 'contact-background-map',
                'label' => __('Map longitude value',TEXTDOMAIN),
            ),
			'contact-map-zoom' => array(
                'type'    => 'select',
                'label'=> __('Select Map Zoom Level:', TEXTDOMAIN),
                'options' => $this->createMapZoomLevelOptions(),
                'default' =>'dark',
                'class'   =>'show-select field-selector contact-background-map'
            ),
			'contact-intro-title'=> array(
                'type' => 'text',
                'placeholder' => __('For ex: Let\'s keep in touch', TEXTDOMAIN),
                'label' => __('Title',TEXTDOMAIN),
            ),
			'contact-intro-subtitle'=> array(
                'type' => 'text',
                'placeholder' => __('For ex: It\'s my office', TEXTDOMAIN),
                'label' => __('Subtitle',TEXTDOMAIN),
            ),
			'contact-intro-address'=> array(
                'type' => 'text',
                'placeholder' => __('Your Address', TEXTDOMAIN),
                'label' => __('Address',TEXTDOMAIN),
            ),
			'contact-intro-email'=> array(
                'type' => 'text',
                'placeholder' => __('Your Email', TEXTDOMAIN),
                'label' => __('Email',TEXTDOMAIN),
            ),
			'contact-intro-phone'=> array(
                'type' => 'text',
                'placeholder' => __('Your Phone', TEXTDOMAIN),
                'label' => __('Phone',TEXTDOMAIN),
            ),
			'contact-intro-website'=> array(
                'type' => 'text',
                'placeholder' => __('Your Website URL', TEXTDOMAIN),
                'label' => __('Website',TEXTDOMAIN),
            ),
            'contact-intro-moreinfo'=> array(
                'type' => 'textarea',
                'placeholder' => __('other contact info', TEXTDOMAIN),
                'label' => __('Other information',TEXTDOMAIN),
            ),
			'contact-intro-form' => array(
                'type'    => 'select',
                'label'=> __('Select a form that is created in "Contact" panel', TEXTDOMAIN),
                'options' => px_get_contact_form7_forms(),
                'class'   =>'show-select field-selector'
            ),
			'resume-exp-section'=> array(
                'type' => 'checkbox',
				'checked' => true,
				'value' => 'visible',
                'label' => __('Experience',TEXTDOMAIN),
            ),
			'resume-education-section'=> array(
                'type' => 'checkbox',
				'checked' => true,
				'value' => 'visible',
                'label' => __('Education',TEXTDOMAIN),
            ),
			'resume-skills-section'=> array(
                'type' => 'checkbox',
				'checked' => true,
				'value' => 'visible',
                'label' => __('Skills',TEXTDOMAIN),
            ),
			'resume-testimonial-section'=> array(
                'type' => 'checkbox',
				'value' => 'visible',
                'label' => __('Testimonial',TEXTDOMAIN),
            ),
			'resume-exp-section-open'=> array(
                'type' => 'checkbox',
				'value' => 'keep-open',
                'label' => __('Open',TEXTDOMAIN),
                'class' => 'related'
            ),
			'resume-education-section-open'=> array(
                'type' => 'checkbox',
				'value' => 'keep-open',
                'label' => __('Open',TEXTDOMAIN),
                'class' => 'related'
            ),
			'resume-skills-section-open'=> array(
                'type' => 'checkbox',
				'value' => 'keep-open',
                'label' => __('Open',TEXTDOMAIN),
                'class' => 'related'
            ),
			'resume-testimonial-section-open'=> array(
                'type' => 'checkbox',
				'value' => 'keep-open',
                'label' => __('Open',TEXTDOMAIN),
                'class' => 'related'
            ),
			'resume-exp-counter'=> array(
                'type' => 'text',
                'placeholder' => __('For ex: 12', TEXTDOMAIN),
                'label' => __('Experience counter',TEXTDOMAIN),
            ),
			'resume-exp-counter-title'=> array(
                'type' => 'text',
                'placeholder' => __('Enter counter title', TEXTDOMAIN),
                'label' => __('Experience counter title',TEXTDOMAIN),
            ),
        );

        //Option sections
        $options = array(
            'sidebar' => array(
                'title'   => __('Sidebar', TEXTDOMAIN),
                'tooltip' => __('Choose a sidebar for this page', TEXTDOMAIN),
                'fields'  => array(
                	'sidebar' => $fields['sidebar'],
                )
            )//Sidebar sec
        );
		//Contact page Options
		$options2 = array(
            'Intro' => array(
                'title'   => __('Contact Information', TEXTDOMAIN),
                'tooltip' => __('Add a heading and subtitle, plus your contact information here. You can also choose your contact form here.', TEXTDOMAIN),
                'fields'  => array(
                    'contact-intro-title'   => $fields['contact-intro-title'],
					'contact-intro-subtitle'   => $fields['contact-intro-subtitle'],
					'contact-intro-address'   => $fields['contact-intro-address'],
					'contact-intro-email'   => $fields['contact-intro-email'],
					'contact-intro-phone'   => $fields['contact-intro-phone'],
					'contact-intro-website'   => $fields['contact-intro-website'],
					'contact-intro-moreinfo'   => $fields['contact-intro-moreinfo'],
					'contact-intro-form'   => $fields['contact-intro-form'],
                )
            ),//Contact Intro Sec
			'map' => array(
                'title'   => __('Background setting ', TEXTDOMAIN),
                'tooltip' => __('Choose the contact page background type(Image or Map) and set its settings', TEXTDOMAIN),
                'fields'  => array(
                    'contact-background-type'   => $fields['contact-background-type'],
					'contact-bg-image'   => $fields['contact-bg-image'],
					'contact-map-style'   => $fields['contact-map-style'],
					'contact-map-zoom'   => $fields['contact-map-zoom'],
					'contact-map-address'   => $fields['contact-map-address'],
					'contact-map-latitude'   => $fields['contact-map-latitude'],
					'contact-map-longitude'   => $fields['contact-map-longitude'],
					'contact-map-marker'   => $fields['contact-map-marker'],
                )
            ),//Map Intro sec
        );
		//Resume page Options
		$options3 = array(
            'resume' => array(
                'title'   => __('Sections Visibility ', TEXTDOMAIN),
                'tooltip' => __('You can check the box in front of each section to add it to your resume page or uncheck the box to hide the section, you can also set each section to be open or close when page loads.', TEXTDOMAIN),
                'fields'  => array(
                    'resume-exp-section'   => $fields['resume-exp-section'],
					'resume-exp-section-open'   => $fields['resume-exp-section-open'],
					'resume-skills-section'   => $fields['resume-skills-section'],
					'resume-skills-section-open'   => $fields['resume-skills-section-open'],
					'resume-education-section'   => $fields['resume-education-section'],
					'resume-education-section-open'   => $fields['resume-education-section-open'],
					'resume-testimonial-section'   => $fields['resume-testimonial-section'],
					'resume-testimonial-section-open'   => $fields['resume-testimonial-section-open'],
                )
            ),//Resume Sections Visbilty
        );
		//Resume experience setting
		$options4 = array(
            'experience' => array(
                'title'   => __('Experience Setting ', TEXTDOMAIN),
                'tooltip' => __('Check-mark every section to show or uncheck to hide', TEXTDOMAIN),
                'fields'  => array(
                    'resume-exp-counter'   => $fields['resume-exp-counter'],
					'resume-exp-counter-title'   => $fields['resume-exp-counter-title'],
					
                )
            ),//Resume experience setting
        );
        return array(
			array(
                'id'    => 'contact_meta_box',
                'title' => __('ContactPage Settings', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'core',
                'options' => $options2,
            ),//Meta box 1
			array(
                'id'    => 'resume_meta_box',
                'title' => __('ResumePage Settings', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'core',
                'options' => $options3,
            ),//Meta box 2
			array(
                'id'    => 'experience_meta_box',
                'title' => __('Experience Settings', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'core',
                'options' => $options4,
            ),//Meta box 3
            array(
                'id' => 'blog_meta_box',
                'title' => __('Page Settings', TEXTDOMAIN),
                'context' => 'normal',
                'priority' => 'high',
                'options' => $options,
            ),//Meta box 4


        );
    }
}

new PxPage();