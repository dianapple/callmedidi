<?php

include_once THEME_LIB . '/google-fonts.php';

function px_admin_get_defaults()
{
    static $values = array();

    if(count($values))
        return $values;

    //Extract key-value pairs from settings
    $settings = px_admin_get_form_settings();
    $panels   = $settings['panels'];

    foreach($panels as $panel)
    {
        foreach($panel['sections'] as $section)
        {
            foreach($section['fields'] as $fieldKey => $field)
            {
                $values[$fieldKey] = px_array_value('value', $field);
            }
        }
    }

    return $values;
}

function createMapZoomLevelOptions($lenght=19){
    for($i=1; $i<=$lenght; $i++){
        $zoomArr[$i] = 'Zoom ' . $i;
    }
    return $zoomArr;
}

function Px_GetSidebars()
{
    $sidebars = array('no-sidebar' => '' , 'Main Sidebar' => __('Main Sidebar', TEXTDOMAIN), 'Page Sidebar' => __('Default Page Sidebar', TEXTDOMAIN));
    $sidebars = array_merge($sidebars, px_get_custom_sidebars());

    return $sidebars;
}

function px_admin_get_appearance_value($name){

    $savedThemeOption =get_option('theme_personage_options');
    return $savedThemeOption[$name];
}

function px_admin_get_color_option_attr($colors)
{
    $tmp = json_encode($colors);
    $tmp = esc_attr($tmp);
    $x="data-colors=\"$tmp\"";
    return "data-colors=\"$tmp\"";
}

function px_admin_get_form_settings()
{
    static $settings = array();//Cache the settings
    $gf = new PxGoogleFonts(px_path_combine(THEME_LIB, 'googlefonts.json'));

    if(count($settings))
        return $settings;

    $biographySetting = array(
        'title' => __('Biography Section', TEXTDOMAIN),
        'sections' => array(
            'intro' => array(
                'title'   => __('Biography Information', TEXTDOMAIN),
                'tooltip' => __('Enter your biography entries here', TEXTDOMAIN),
                'fields'  => array(
                    'intro-height'=> array(
                        'type' => 'text',
                        'placeholder' => __('Intro Section Height:(Ex: 650px)', TEXTDOMAIN),
                        'class'   => 'intro-view',
                        'label' => __('Intro Section. Height',TEXTDOMAIN),
                    ),
                    'bio-title'=> array(
                        'type' => 'text',
                        'placeholder' => __('Bio title', TEXTDOMAIN),
                        'class'   => 'intro-view',
                        'label' => __('Bio title',TEXTDOMAIN),
                    ),'bio-text' => array(
                        'type'  => 'textarea',
                        'title' => __('Text' , TEXTDOMAIN),
                        'label' => __('Bio Text',TEXTDOMAIN)
                    ),
                    'bio-image' => array(
                        'type'  => 'upload',
                        'title' => __('Image', TEXTDOMAIN),
                        'label'=> __('Bio Image:', TEXTDOMAIN),
                        'referer' => 'px-bio-image',
                    ),
                    'signature-image'  =>  array(
                        'type'  => 'upload',
                        'title' => __('Signature', TEXTDOMAIN),
                        'label'=> __('Signature Image:', TEXTDOMAIN),
                        'referer' => 'px-signature-image',
                    )
                )
            ),//Bio Intro sec
            'background' => array(
                'title'   => __('Background setting', TEXTDOMAIN),
                'tooltip' => __('Choose background type and set its settings here. Alternative image (video background) is the image that is shown instead of video in tablet and mobile devices. If you choose Image, the first image will be shown as the background in mobile and tablets.', TEXTDOMAIN),
                'fields'  => array(
                    'background-type'   => array(
                        'type'    => 'select',
                        'label'   => __('Background type', TEXTDOMAIN),
                        'attributes' => 'data-fields=".background-image,.background-video"',
                        'options' => array('no'=>'None','image'=>'Slider','video'=>'Video'),
                        'option-attributes' =>array('no'=>'','image'=>'data-show=".background-image"','video'=>'data-show=".background-video"'),
                        'default' =>'no',
                        'class'   =>'show-select child-select field-selector background-view'
                    ),
                    'color-detector' => array(
                        'type' => 'checkbox',
                        'checked' => true,
                        'label' => __('Menu Color Detector',TEXTDOMAIN),
                        'class' => 'background-image-type'
                    ),
                    'bg-images'   => array(
                        'type'  => 'upload',
                        'class'   => 'background-image background-image-type',
                        'title' => __('Background Images', TEXTDOMAIN),
                        'label'=> __('Slide:', TEXTDOMAIN),
                        'referer' => 'px-background-image',
                        'meta'  => array('array'=>true),
                    ),
                    'bg-video-mp4'   =>  array(
                        'type'  => 'upload',
                        'class'   => 'background-video',
                        'title' => __('Mp4 type', TEXTDOMAIN),
                        'label'=> __('mp4 video file:', TEXTDOMAIN),
                        'referer' => 'px-background-video-mp4',
                    ),
                    'bg-video-webm'   => array(
                        'type'  => 'upload',
                        'class'   => 'background-video',
                        'title' => __('Webm type', TEXTDOMAIN),
                        'label'=> __('webm video file:', TEXTDOMAIN),
                        'referer' => 'px-background-video-webm',
                    ),
                    'bg-video-ogg'   => array(
                        'type'  => 'upload',
                        'class'   => 'background-video',
                        'title' => __('Ogg type', TEXTDOMAIN),
                        'label'=> __('ogg video file:', TEXTDOMAIN),
                        'referer' => 'px-background-video-off',
                    ),
                    'bg-video-poster'   => array(
                        'type'  => 'upload',
                        'class'   => 'background-video',
                        'title' => __('Alternative Image', TEXTDOMAIN),
                        'label'=> __('Alternative Image:', TEXTDOMAIN),
                        'referer' => 'px-background-video-poster',
                    ),
                )
            ),//Background Sec
            'overlay' => array(
                'title'   => __('Overlay setting ', TEXTDOMAIN),
                'tooltip' => __('Select the overlay type for intro section and set its settings here', TEXTDOMAIN),
                'fields'  => array(
                    'overlay-type'   => array(
                        'type'      => 'select',
                        'label'     => __('Overlay type', TEXTDOMAIN),
                        'attributes'=> 'data-fields=".overlay-opacity,.overlay-texture,.overlay-texture-opacity,.overlay-gradient"',
                        'options'   => array('no'=>'None','opacity'=>'Opacity','texture'=>'Texture','opacity-texture'=>'Opacity & Texture','gradient'=>'Gradient'),
                        'option-attributes' =>array('no'=>'','opacity'=>'data-show=".overlay-opacity"','texture'=>'data-show=".overlay-texture"','opacity-texture'=>'data-show=".overlay-texture-opacity"','gradient'=>'data-show=".overlay-gradient"'),
                        'default' =>'no',
                        'class'   =>'show-select child-select field-selector overlay-view'
                    ),
                    'overlay-opacity'   => array(
                        'type'        => 'text',
                        'placeholder' => __('Example: 95', TEXTDOMAIN),
                        'class'       => 'overlay-opacity overlay-texture-opacity overlay-gradient',
                        'label'       => __('Opacity value( 0-100 )',TEXTDOMAIN),
                    ),
                    'overlay-texture'   => array(
                        'type'    => 'visual-select',
                        'class'   => 'show-select overlay-texture overlay-texture-opacity',
                        'label'   => __('Texture image', TEXTDOMAIN),
                        'options' => array('first'=>1,'second'=>2,'third'=>3,'fourth'=>4,'fifth'=>5,'sixth'=>6),
                    ),
                    'overlay-color'   => array(
                        'type'    => 'color',
                        'class'   => 'show-select overlay-opacity overlay-texture-opacity',
                        'label'   => __('Overlay Color', TEXTDOMAIN),
                        'value'   => "#000000"
                    ),
                    'overlay-gradient1' => array(
                        'type' => 'color',
                        'class' => 'show-select overlay-gradient',
                        'label' => __('Start Color',TEXTDOMAIN),
                        'value'   => "#000000"
                    ),
                    'overlay-gradient2' => array(
                        'type' => 'color',
                        'class' => 'show-select overlay-gradient',
                        'label' => __('End Color',TEXTDOMAIN),
                        'value'   => "#000000"

                    )
                )
            ),//Overlay Sec


        )
    );

    $sectionsTitle = array(
        'title' => __('Sections Display & Title',TEXTDOMAIN),
        'sections'  => array(
            'intro' => array(
                'title'     => __('Intro Section', TEXTDOMAIN),
                'tooltip'   => __('Select intro section display in menu or not', TEXTDOMAIN),
                'fields'    => array(
                    'intro-display' => array(
                        'type'  => 'switch',
                        'label' => __('Display in menu',TEXTDOMAIN),
                        'state0' => __('Don\'t show in Menu ', TEXTDOMAIN),
                        'state1' => __('Show in Menu', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    )
                )
            ),
            'skills' => array(
                'title'     => __('Skill Section', TEXTDOMAIN),
                'tooltip'   => __('Enter a title for skills Section and choose to show or not to show this section name in menu', TEXTDOMAIN),
                'fields'    => array(
                    'skills' => array(
                        'type'  => 'text',
                        'label' => __('Skills Title',TEXTDOMAIN),
                        'placeholder' => __('MY SKILLS',TEXTDOMAIN),
                    ),
                    'skill-display' => array(
                        'type'  => 'switch',
                        'label' => __('Display in menu',TEXTDOMAIN),
                        'state0' => __('Don\'t show in Menu ', TEXTDOMAIN),
                        'state1' => __('Show in Menu', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    )
                )
            ),
            'experience' => array(
                'title'     => __('Experience Section', TEXTDOMAIN),
                'tooltip'   => __('Enter a title for Experience Section and choose to show or not to show this section name in menu', TEXTDOMAIN),
                'fields'    => array(
                    'experience' => array(
                        'type'  => 'text',
                        'label' => __('Experience Title',TEXTDOMAIN),
                        'placeholder' => __('MY Experience',TEXTDOMAIN),
                    ),
                    'experience-display' => array(
                        'type'  => 'switch',
                        'label' => __('Display in menu',TEXTDOMAIN),
                        'state0' => __('Don\'t show in Menu ', TEXTDOMAIN),
                        'state1' => __('Show in Menu', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    )
                )
            ),
            'education' => array(
                'title'     => __('Education Section', TEXTDOMAIN),
                'tooltip'   => __('Enter a title for Education Section and choose to show or not to show this section name in menu', TEXTDOMAIN),
                'fields'    => array(
                    'education' => array(
                        'type'  => 'text',
                        'label' => __('Education Title',TEXTDOMAIN),
                        'placeholder' => __('MY Education',TEXTDOMAIN),
                    ),
                    'education-display' => array(
                        'type'  => 'switch',
                        'label' => __('Display in menu',TEXTDOMAIN),
                        'state0' => __('Don\'t show in Menu ', TEXTDOMAIN),
                        'state1' => __('Show in Menu', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    )
                )
            ),
            'portfolio' => array(
                'title'     => __('Portfolio Section', TEXTDOMAIN),
                'tooltip'   => __('Enter a title for Portfolio Section and choose to show or not to show this section name in menu', TEXTDOMAIN),
                'fields'    => array(
                    'portfolio' => array(
                        'type'  => 'text',
                        'label' => __('Portfolio Title',TEXTDOMAIN),
                        'placeholder' => __('MY Works',TEXTDOMAIN),
                    ),
                    'portfolio-display' => array(
                        'type'  => 'switch',
                        'label' => __('Display in menu',TEXTDOMAIN),
                        'state0' => __('Don\'t show in Menu ', TEXTDOMAIN),
                        'state1' => __('Show in Menu', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    )
                )
            ),
            'testimonial' => array(
                'title'     => __('Testimonial Section ', TEXTDOMAIN),
                'tooltip'   => __('Enter a title for Testimonial Section and choose to show or not to show this section name in menu', TEXTDOMAIN),
                'fields'    => array(
                    'testimonial' => array(
                        'type'  => 'text',
                        'label' => __('Testimonial Title',TEXTDOMAIN),
                        'placeholder' => __('MY Testimonial',TEXTDOMAIN),
                    ),
                    'testimonial-display' => array(
                        'type'  => 'switch',
                        'label' => __('Display in menu',TEXTDOMAIN),
                        'state0' => __('Don\'t show in Menu ', TEXTDOMAIN),
                        'state1' => __('Show in Menu', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    )

                )
            )
        )
    );

    $generalSettingsPanel = array(
        'title' => __('Appearance', TEXTDOMAIN),
        'sections' => array(
            'background' => array(
                'title'     => __('Site Background', TEXTDOMAIN),
                'tooltip'   => __('Choose your desired background type for your website.', TEXTDOMAIN),
                'fields'    => array(
                    'bg-type' =>array(
                        'type'       => 'select',
                        'label'      => __('My Background Is',TEXTDOMAIN),
                        'attributes' => 'data-fields=".solid,.bg-texture"',
                        'options'    => array( 1 => __('Color',TEXTDOMAIN), 2 => __('Texture',TEXTDOMAIN)),
                        'option-attributes' => array(1 =>"data-show=.solid", 2 => "data-show=.bg-texture" ),
                        'default'   =>2,
                        'class'   =>'show-select  field-selector'
                    ),
                    'body-solid' => array(
                        'type'    => 'color',
                        'class'   => 'show-select solid',
                        'label'   => __('Background Color', TEXTDOMAIN),
                        'value'   => "#ffffff"
                    ),
                    'body-texture' => array(
                        'type'    => 'visual-select',
                        'class'   => 'show-select bg-texture',
                        'label' => __('Background Texture', TEXTDOMAIN),
                        'options' => array('first'=>1,'second'=>2,'third'=>3,'fourth'=>4,'fifth'=>5,'sixth'=>6,'seventh'=>7,'eighth'=>8)
                    )
                )
            ),
            'logo' => array(
                'title'     => __('Custom Logo', TEXTDOMAIN),
                'tooltip'   => __('Choose text to use your name as logo or upload a .png image to be shown as website logo', TEXTDOMAIN),
                'fields'    => array(
                    'logo-type' => array(
                        'type'       => 'select',
                        'label'      => __('My Logo Is',TEXTDOMAIN),
                        'attributes' => 'data-fields=".image,.text"',
                        'options'    => array( 1 => __('Text',TEXTDOMAIN), 2 => __('PNG Image',TEXTDOMAIN)),
                        'option-attributes' => array(1 =>"data-show=.text", 2 => "data-show=.image" ),
                        'default'   => 1,
                        'class'   =>'show-select  field-selector'
                    ),
                    'logo' => array(
                        'type' => 'upload',
                        'title' => __('Upload Logo', TEXTDOMAIN),
                        'label' => __('Upload Logo', TEXTDOMAIN),
                        'referer' => 'px-settings-logo',
                        'class'   => 'image'
                    ),
                    'title-name' => array(
                        'type'  => 'text',
                        'label' => __('Your Name',TEXTDOMAIN),
                        'class' => 'text'
                    ),
                    'logo-transform' => array(
                        'type' => 'checkbox',
                        'checked' => true,
                        'label' => __('Uppercase',TEXTDOMAIN),
                        'class' => 'text admin'
                    ),
                    'font-logo' => array(
                        'type'   => 'select',
                        'label' => __('Font Name',TEXTDOMAIN),
                        'options'=> $gf->Px_GetFontNames(),
                        'value'  => 'Patua One',
                        'class' => 'text show-select'
                    ),
                    'fontsize-logo' => array(
                        'type'  => 'text',
                        'label' => __('Font Size',TEXTDOMAIN),
                        'placeholder' => __('example: 23',TEXTDOMAIN),
                        'class' => 'text',
                        'value' => '23'
                    )
                )
            ),//Logo sec
            'favicon' => array(
                'title'   => __('Custom Favicon', TEXTDOMAIN),
                'tooltip' => __('Specify custom favicon url or upload new icon here', TEXTDOMAIN),
                'fields'  => array(
                    'favicon' => array(
                        'type'    => 'upload',
                        'title'   =>  __('Upload Favicon', TEXTDOMAIN),
                        'label'   =>  __('Upload Favicon', TEXTDOMAIN),
                        'referer' => 'px-settings-favicon'
                    ),
                )
            ),//Favicon sec
            'print' => array(
                'title'   => __('Print Setting', TEXTDOMAIN),
               'tooltip' => __('Choose the print button functionality, you can set it to print your website in a beautiful style or upload a file to be downloaded as your resume.', TEXTDOMAIN),
                'fields'  => array(
                    'print-state' => array(
                        'type'    => 'select',
                        'label'   => __('Print Button Action:', TEXTDOMAIN),
                        'default' =>'page',
                        'class'   =>'show-select field-selector',
                        'options' => array('page'=>'print page','link'=>'download external resume file'),
                        'option-attributes' => array('page'=>'','link'=>'data-show=".print-link"'),
                        'attributes' => 'data-fields=".print-link"',
                    ),//Print Sec
                    'print-link'=>array(
                        'type'    => 'upload',
                        'label'   => __('Select Resume File:', TEXTDOMAIN),
                        'class'   =>'print-link'
                    ),
                ),
            ),
            'animation' => array(
                'title'   => __('Animation Setting', TEXTDOMAIN),
                'tooltip' => __('Disable or Enable animation for website', TEXTDOMAIN),
                'fields'  => array(
                    'animation' => array(
                        'type'   => 'switch',
                        'state0' => __('Disable', TEXTDOMAIN),
                        'state1' => __('Enable', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    ),
                )
            ),//Animation sec
            'small-nav' => array(
                'title'   => __('Oval Sticky Navigation Visibility', TEXTDOMAIN),
                'tooltip' => __('Sticky Navigation is the small oval navigation on right side of screen which comes with you when you scroll between the sections of website. You can choose to show or not to show the Sticky Navigation.', TEXTDOMAIN),
                'fields'  => array(
                    'small-nav' => array(
                        'type'   => 'switch',
                        'state0' => __('Don\'t Show', TEXTDOMAIN),
                        'state1' => __('Show', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    ),
                )
            ),//Animation sec


        )
    );//$generalSettingsPanel

    $portfolioSetting=array(
        'title' => __('Portfolio Section Setting',TEXTDOMAIN),
        'sections' => array(
            'portfolio-num' =>array(
                'title'   => __('Number of Portfolio Posts ', TEXTDOMAIN),
                'tooltip' => __('Enter the number of portfolio posts you want to display in your website before you click load more button. Enter -1 to display all posts.', TEXTDOMAIN),
                'fields'  => array(
                    'portfolio-num'  => array(
                        'type'  => 'text',
                        'label' => __('Post Number', TEXTDOMAIN),
                        'value' => 10
                    ),
                    'portfolio-header' => array(
                        'type' => 'checkbox',
                        'checked' => true,
                        'label' => __('Title & Filter Display',TEXTDOMAIN),
                        'class' => 'text admin'
                    ),
                )
            )
        )
    );

    $contactPanel =  array(
        'title' => __('Contact Section',TEXTDOMAIN),
        'sections' => array(
            'Intro' => array(
                'title'   => __('Contact Information', TEXTDOMAIN),
                'tooltip' => __('Add a heading, plus your contact information here. You can also choose your contact form which is creating in Contact panel here.', TEXTDOMAIN),
                'fields'  => array(
                    'contact-title'    => array(
                        'type' => 'text',
                        'label'=> __('Title',TEXTDOMAIN),
                        'placeholder' => __('For ex: CONTACT ME', TEXTDOMAIN),
                    ),
                    'contact-address'  => array(
                        'type'  => 'text',
                        'label' => __('Address',TEXTDOMAIN),
                        'placeholder' => __('Your Address', TEXTDOMAIN),
                    ),
                    'contact-email'    =>  array(
                        'type'  => 'text',
                        'label' => __('Email',TEXTDOMAIN),
                        'placeholder' => __('Your Email', TEXTDOMAIN),
                    ),
                    'contact-phone'    => array(
                        'type'  => 'text',
                        'label' => __('Phone',TEXTDOMAIN),
                        'placeholder' => __('Your Phone', TEXTDOMAIN),
                    ),
                    'contact-form'     =>  array(
                        'type'    => 'select',
                        'label'   => __('Select a form that is created in "Contact" panel', TEXTDOMAIN),
                        'options' => px_get_contact_form7_forms(),
                        'class'   =>'show-select field-selector'
                    ),
                )
            ),//Contact Intro Sec
            'map' => array(
                'title'   => __('Media setting ', TEXTDOMAIN),
                'tooltip' => __('Choose the contact Section media type(Image or Map) and set its settings', TEXTDOMAIN),
                'fields'  => array(
                    'contact-media-type'=> array(
                        'type'    => 'select',
                        'label'   => 'Media type',
                        'attributes' => 'data-fields=".contact-media-image,.contact-media-map"',
                        'options' => array('no'=>'None','image'=>'Image','map'=>'Map'),
                        'option-attributes' =>array('no'=>'','image'=>'data-show=".contact-media-image"','map'=>'data-show=".contact-media-map"'),
                        'default' =>'no',
                        'class'   =>'show-select child-select field-selector background-view'
                    ),
                    'contact-image'       => array(
                        'type'    => 'upload',
                        'class'   => 'contact-media-image',
                        'title'   => __('Image', TEXTDOMAIN),
                        'label'   => __('Image:', TEXTDOMAIN),
                        'referer' => 'px-contact-background-image',
                    ),
                    'map-style'      => array(
                        'type' => 'select',
                        'label'=> __('Choose Map style:', TEXTDOMAIN),
                        'options' => array('dark'=>'Custom PixFlow Map','normal'=>'Standard Google Map'),
                        'default' =>'dark',
                        'class'   =>'show-select field-selector contact-media-map'
                    ),
                    'map-zoom'       => array(
                        'type'    => 'select',
                        'label'   => __('Select Map Zoom Level:', TEXTDOMAIN),
                        'options' => createMapZoomLevelOptions(),
                        'default' =>'dark',
                        'class'   =>'show-select field-selector contact-media-map'
                    ),
                    'map-address'    => array(
                        'type' => 'text',
                        'class' => 'contact-media-map',
                        'label' => __('Map Address',TEXTDOMAIN),
                        'placeholder' => __('Google Map Address', TEXTDOMAIN),
                    ),
                    'map-latitude'   => array(
                        'type'  => 'text',
                        'class' => 'contact-media-map',
                        'label' => __('Map latitude value',TEXTDOMAIN),
                        'placeholder' => __('Google Maps latitude', TEXTDOMAIN),
                    ),
                    'map-longitude'  => array(
                        'type'  => 'text',
                        'class' => 'contact-media-map',
                        'label' => __('Map longitude value',TEXTDOMAIN),
                        'placeholder' => __('Google Maps longitude', TEXTDOMAIN),
                    ),
                    'map-marker'     => array(
                        'type'  => 'upload',
                        'class' => 'contact-media-map',
                        'title' => __('Map Marker Image', TEXTDOMAIN),
                        'label' => __('Map Marker Image(PNG)', TEXTDOMAIN),
                        'referer' => 'px-contact-map-marker',
                    ),
                )
            ),//Map Intro sec
        )

    );

    $presetColors = array();

    $presetColors['default'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#62D703',
              'style-menu-color'=>'#303030',
              'style-font-color'=>'#666666',
              'style-highlight-color'=>'#62D703',
              'style-link-color'=>'#62D703',
              'style-link-hover-color'=>'#333333'));

    $presetColors['red'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#eb2130',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#eb2130',
            'style-link-color'=>'#eb2130',
            'style-link-hover-color'=>'#333333'));

    $presetColors['orange'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#fe4d2c',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#fe4d2c',
            'style-link-color'=>'#fe4d2c',
            'style-link-hover-color'=>'#333333'));

    $presetColors['pink'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#eb2071',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#eb2071',
            'style-link-color'=>'#eb2071',
            'style-link-hover-color'=>'#333333'));

    $presetColors['yellow'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#ffdb0d',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#ffdb0d',
            'style-link-color'=>'#ffdb0d',
            'style-link-hover-color'=>'#333333'));

    $presetColors['green'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#96d639',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#96d639',
            'style-link-color'=>'#96d639',
            'style-link-hover-color'=>'#333333'));

    $presetColors['emerald'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#4dac46',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#4dac46',
            'style-link-color'=>'#4dac46',
            'style-link-hover-color'=>'#333333'));

    $presetColors['teal'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#23d692',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#23d692',
            'style-link-color'=>'#23d692',
            'style-link-hover-color'=>'#333333'));

    $presetColors['skyBlue'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#45c1e5',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#45c1e5',
            'style-link-color'=>'#45c1e5',
            'style-link-hover-color'=>'#333333'));

    $presetColors['blue'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#073b87',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#073b87',
            'style-link-color'=>'#073b87',
            'style-link-hover-color'=>'#333333'));

    $presetColors['purple'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#423c6c',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#423c6c',
            'style-link-color'=>'#423c6c',
            'style-link-hover-color'=>'#333333'));

    $presetColors['golden'] = px_admin_get_color_option_attr(
        array('style-accent-color'=>'#dbbe7c',
            'style-menu-color'=>'#303030',
            'style-font-color'=>'#666666',
            'style-highlight-color'=>'#dbbe7c',
            'style-link-color'=>'#dbbe7c',
            'style-link-hover-color'=>'#333333'));

    $customColor = array('style-accent-color'=>px_admin_get_appearance_value('style-accent-color'),
        'style-menu-color'=>px_admin_get_appearance_value('style-menu-color'),
        'style-font-color'=>px_admin_get_appearance_value('style-font-color'),
        'style-highlight-color'=>px_admin_get_appearance_value('style-highlight-color'),
        'style-link-color'=>px_admin_get_appearance_value('style-link-color'),
        'style-link-hover-color'=>px_admin_get_appearance_value('style-link-hover-color'));

    $presetColors['custom'] = px_admin_get_color_option_attr( $customColor);

    $appearancePanel = array(
        'title' => __('Colors', TEXTDOMAIN),
        'sections' => array(

            'dark-style' => array(
                'title'     => __('Skin Style', TEXTDOMAIN),
                'tooltip'   => __('Here you can choose your website skin style, it can be dark or light', TEXTDOMAIN),
                'fields'    => array(
                    'dark-style-status' => array(
                        'type'  => 'switch',
                        'label' => __('Skin Style',TEXTDOMAIN),
                        'state0' => __('Light', TEXTDOMAIN),
                        'state1' => __('Dark', TEXTDOMAIN),
                        'value'  => 0,
                        'default'=> 0
                    )
                )
            ),

            'theme-style' => array(
                'title'   => __('Preset Color', TEXTDOMAIN),
                'tooltip' => __('Choose a preset theme color or choose custom to set your own color for theme', TEXTDOMAIN),
                'fields'  => array(
                    'style-preset-color' => array(
                        'type'   => 'select',
                        'options'=> array('default' => 'Default Theme Colors', 'red' => 'Red', 'orange' => 'Orange', 'pink' => 'Pink', 'yellow' => 'Yellow', 'green' => 'Green', 'emerald' => 'Emerald', 'teal' => 'Teal', 'skyBlue' => 'Sky Blue', 'blue' => 'Blue', 'golden' => 'Golden','custom'=>'Custom'),
                        'option-attributes' => $presetColors
                    ),
                )
            ),//theme-style sec
            'accent-color' => array(
                'title'   => __('General color', TEXTDOMAIN),
                'tooltip' => __('General color for page elements', TEXTDOMAIN),
                'fields'  => array(
                    'style-accent-color' => array(
                        'type'   => 'color',
                        'label'  => __('Choose', TEXTDOMAIN),
                        'value'  => '#62D703'
                    ),
                )
            ),//accent-color sec
            'menu-color' => array(
                'title'   => __('Menu color', TEXTDOMAIN),
                'tooltip' => __('Menu color for Top menu items', TEXTDOMAIN),
                'fields'  => array(
                    'style-menu-color' => array(
                        'type'   => 'color',
                        'label'  => __('Choose', TEXTDOMAIN),
                        'value'  => '#303030'
                    ),
                )
            ),//menu-color sec
            'primary-color' => array(
                'title'   => __('Content color', TEXTDOMAIN),
                'tooltip' => __('Primary font and content elements color', TEXTDOMAIN),
                'fields'  => array(
                    'style-font-color' => array(
                        'type'   => 'color',
                        'label'  => __('Choose', TEXTDOMAIN),
                        'value'  => '#666666'
                    ),
                )
            ),//primary-color sec
            'highlight-color' => array(
                'title'   => __('Highlight color', TEXTDOMAIN),
                'tooltip' => __('Color for highlighted elements', TEXTDOMAIN),
                'fields'  => array(
                    'style-highlight-color' => array(
                        'type'   => 'color',
                        'label'  => __('Choose', TEXTDOMAIN),
                        'value'  => '#62D703'
                    ),
                )
            ),//highlight-color sec
            'link-color' => array(
                'title'   => __('Link Color', TEXTDOMAIN),
                'tooltip' => __('Choose link color and hover color', TEXTDOMAIN),
                'fields'  => array(
                    'style-link-color' => array(
                        'type'   => 'color',
                        'label'  => __('Normal Color', TEXTDOMAIN),
                        'value'  => '#262626'
                    ),
                    'style-link-hover-color' => array(
                        'type'   => 'color',
                        'label'  => __('Hover Color', TEXTDOMAIN),
                        'value'  => '#000000'
                    ),
                )
            ),//link-color sec

        )
    );//$themeStylePanel

    $gf = new PxGoogleFonts(px_path_combine(THEME_LIB, 'googlefonts.json'));
    $fontNames = $gf->Px_GetFontNames();

    $fontsPanel = array(
        'title' => __('Fonts', TEXTDOMAIN),
        'sections' => array(

            'font-body' => array(
                'title'   => __('Body Font', TEXTDOMAIN),
                'tooltip' => __('Select your desired font for contents', TEXTDOMAIN),
                'fields'  => array(
                    'font-body' => array(
                        'type'   => 'select',
                        'options'=> $fontNames,
                        'value'  => 'Open Sans'
                    ),
                )
            ),
            'font-navigation' => array(
                'title'   => __('Navigation Font', TEXTDOMAIN),
                'tooltip' => __('Select your desired font for navigation menu', TEXTDOMAIN),
                'fields'  => array(
                    'font-navigation' => array(
                        'type'   => 'select',
                        'options'=> $fontNames,
                        'value'  => 'Oswald'
                    ),
                )
            ),
            'font-headings' => array(
                'title'   => __('Headings Font', TEXTDOMAIN),
                'tooltip' => __('Select your desired font for headings and titles', TEXTDOMAIN),
                'fields'  => array(
                    'font-headings' => array(
                        'type'   => 'select',
                        'options'=> $fontNames,
                        'value'  => 'Oswald'
                    ),
                )
            )
        )

    );//$fontsPanel

    $sidebarPanel = array(
        'title' => __('Sidebars', TEXTDOMAIN),
        'sections' => array(
            'single-sidebar' =>array(
                'title'     => __('Single Blog Post Sidebar',TEXTDOMAIN),
                'tooltip'   => __('Select a sidebar for your single blog post',TEXTDOMAIN),
                'fields'    => array(
                    'single-sidebar'  => array(
                        'type' => 'select',
                        'label'   => 'Sidebar',
                        'options' => Px_GetSidebars(),
                        'default' => '0',
                        'class'   =>'show-select'
                    )
                )
            ),
            'custom-sidebar' => array(
                'title'   => __('Custom Sidebar', TEXTDOMAIN),
                'tooltip' => __('Create custom sidebars that can be used in pages. You can customize those widgets in appearance > widgets', TEXTDOMAIN),
                'fields'  => array(
                    'custom_sidebars' => array(
                        'type' => 'csv',
                        'placeholder' => __('Enter a sidebar name', TEXTDOMAIN),
                    ),
                )
            ),//custom-sidebar sec
            'sidebar-position' => array(
                'title'   => __('Page Sidebar Position', TEXTDOMAIN),
                'tooltip' => __('Choose default sidebar position for pages that has sidebar', TEXTDOMAIN),
                'fields'  => array(
                    'sidebar-position' => array(
                        'type' => 'visual-select',
                        'options' => array(/*'none'=>0,*/ 'left-side'=>1, 'right-side'=>2),
                        'class' => 'page-sidebar',
                        'value' => 2,
                    ),
                )
            ),//sidebar-position sec
        )
    );//$sidebarPanel

    $socialSettingsPanel = array(
        'title' => __('Social', TEXTDOMAIN),
        'sections' => array(
            'socials' => array(
                'title'   => __('Social Network URLs', TEXTDOMAIN),
                'tooltip' => __('Enter your social network addresses in respective fields. You can clear fields to hide icons from the website user interface', TEXTDOMAIN),
                'fields'  => array(
                    'social_icon_target' => array(
                        'type'  => 'switch',
                        'label' => __('Choose Where To Open Social Icons',TEXTDOMAIN),
                        'state0' => __('Same Window ', TEXTDOMAIN),
                        'state1' => __('New Window', TEXTDOMAIN),
                        'value'  => 1,
                        'default'=> 1
                    ),
                    'social_facebook_url' => array(
                        'type' => 'text',
                        'label' => __('Facebook', TEXTDOMAIN),
                    ),//Facebook
                    'social_twitter_url' => array(
                        'type' => 'text',
                        'label' => __('Twitter', TEXTDOMAIN),
                    ),//twitter
                    'social_vimeo_url' => array(
                        'type' => 'text',
                        'label' => __('Vimeo', TEXTDOMAIN),
                    ),//vimeo
                    'social_youtube_url' => array(
                        'type' => 'text',
                        'label' => __('YouTube', TEXTDOMAIN),
                    ),//youtube
                    'social_googleplus_url' => array(
                        'type' => 'text',
                        'label' => __('Google+', TEXTDOMAIN),
                    ),//Google+
                    'social_dribbble_url' => array(
                        'type' => 'text',
                        'label' => __('Dribbble', TEXTDOMAIN),
                    ),//dribbble
                    'social_tumblr_url' => array(
                        'type' => 'text',
                        'label' => __('Tumblr', TEXTDOMAIN),
                    ),//Tumblr
                    'social_linkedin_url' => array(
                        'type' => 'text',
                        'label' => __('LinkedIn', TEXTDOMAIN),
                    ),//LinkedIn
                    'social_flickr_url' => array(
                        'type' => 'text',
                        'label' => __('Flickr', TEXTDOMAIN),
                    ),//flickr
                    'social_forrst_url' => array(
                        'type' => 'text',
                        'label' => __('Forrst', TEXTDOMAIN),
                    ),//forrst
                    'social_github_url' => array(
                        'type' => 'text',
                        'label' => __('GitHub', TEXTDOMAIN),
                    ),//GitHub
                    'social_lastfm_url' => array(
                        'type' => 'text',
                        'label' => __('Last.fm', TEXTDOMAIN),
                    ),//Last.fm
                    'social_paypal_url' => array(
                        'type' => 'text',
                        'label' => __('PayPal', TEXTDOMAIN),
                    ),//Paypal
                    'social_rss_url' => array(
                        'type' => 'text',
                        'label' => __('RSS Feed', TEXTDOMAIN),
                        'value' => get_bloginfo('rss2_url'),
                    ),//rss
                    'social_skype_url' => array(
                        'type' => 'text',
                        'label' => __('Skype', TEXTDOMAIN),
                    ),//skype
                    'social_wordpress_url' => array(
                        'type' => 'text',
                        'label' => __('WordPress', TEXTDOMAIN),
                    ),//wordpress
                    'social_yahoo_url' => array(
                        'type' => 'text',
                        'label' => __('Yahoo', TEXTDOMAIN),
                    ),//yahoo
                    'social_deviantart_url' => array(
                        'type' => 'text',
                        'label' => __('deviantART', TEXTDOMAIN),
                    ),//DeviantArt
                    'social_steam_url' => array(
                        'type' => 'text',
                        'label' => __('Steam', TEXTDOMAIN),
                    ),//Steam
                    'social_reddit_url' => array(
                        'type' => 'text',
                        'label' => __('reddit', TEXTDOMAIN),
                    ),//reddit
                    'social_stumbleupon_url' => array(
                        'type' => 'text',
                        'label' => __('StumbleUpon', TEXTDOMAIN),
                    ),//StumbleUpon
                    'social_pinterest_url' => array(
                        'type' => 'text',
                        'label' => __('Pinterest', TEXTDOMAIN),
                    ),//Pinterest
                    'social_xing_url' => array(
                        'type' => 'text',
                        'label' => __('XING', TEXTDOMAIN),
                    ),//XING
                    'social_blogger_url' => array(
                        'type' => 'text',
                        'label' => __('Blogger', TEXTDOMAIN),
                    ),//Blogger
                    'social_soundcloud_url' => array(
                        'type' => 'text',
                        'label' => __('SoundCloud', TEXTDOMAIN),
                    ),//SoundCloud
                    'social_delicious_url' => array(
                        'type' => 'text',
                        'label' => __('Delicious', TEXTDOMAIN),
                    ),//delicious
                    'social_foursquare_url' => array(
                        'type' => 'text',
                        'label' => __('Foursquare', TEXTDOMAIN),
                    ),//Foursquare
                    'social_instagram_url'  => array(
                        'type' => 'text',
                        'label'=>__('Instagram',TEXTDOMAIN)
                    ),//instagram
                )
            ),//Favicon sec
        ),
    );

    $footerSettingsPanel = array(

        'title' => __('Footer Settings', TEXTDOMAIN),
        'sections' => array(
            'widget-areas' => array(
                'title'   => __('Widget Areas', TEXTDOMAIN),
                'tooltip' => __('How many widget areas you like to have in the footer', TEXTDOMAIN),
                'fields'  => array(
                    'footer_widgets' => array(
                        'type' => 'visual-select',
                        'options' => array('zero' => 0, 'one'=>1, 'two'=>2, 'three'=>3, 'four'=>4),
                        'class' => 'footer-widgets',
                        'value' => 4,
                    ),
                )
            ),//widget-areas sec
            'copyright-message' => array(
                'title'   => __('Copyright Text', TEXTDOMAIN),
                'tooltip' => __('Enter footer copyright text. ', TEXTDOMAIN),
                'fields'  => array(
                    'footer-copyright' => array(
                        'type' => 'text',
                        'label' => __('Copyright Text', TEXTDOMAIN),
                        'value' => '&copy; 2014 PixFlow is proudly powered by <a href="http://wordpress.org">WordPress</a> | Built With Personage Theme'
                    ),
                )
            ),//footer_copyright sec
        ),
    );

    $extraSettingsPanel = array(
        'title' => __('Additional Scripts', TEXTDOMAIN),
        'sections' => array(

            'additional-js' => array(
                'title'   => __('Additional JavaScript', TEXTDOMAIN),
                'tooltip' => __('Enter custom JavaScript code such as Google Analytics code here. Please note that you should not include &lt;script&gt; tags in your scripts.', TEXTDOMAIN),
                'fields'  => array(
                    'additional-js' => array(
                        'type' => 'textarea'
                    ),
                )
            ),//additional-js sec
            'additional-css' => array(
                'title'   => __('Additional CSS', TEXTDOMAIN),
                'tooltip' => __('Enter custom CSS code such as style overrides here. Please note that you should not include &lt;style&gt; tags in your css code.', TEXTDOMAIN),
                'fields'  => array(
                    'additional-css' => array(
                        'type' => 'textarea'
                    ),
                )
            ),//additional-js sec

        ),
    );

    $apiSettingsPanel = array(
        'title' => __('API Keys', TEXTDOMAIN),
        'sections' => array(

            'google-api' => array(
                'title'   => __('Google API Key', TEXTDOMAIN),
                'tooltip' => __('Google API key for services such as Google Maps. Click <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" target="_blank">here</a> for more information on how to obtain Google API key.', TEXTDOMAIN),
                'fields'  => array(
                    'google-api-key' => array(
                        'type' => 'text'
                    ),
                )
            ),//additional-js sec


        ),
    );

    $importExportSettingsPanel = array(
        'title' => __('Import Dummy Data', TEXTDOMAIN),
        'sections' => array(
            'import-dummy-data' => array(
                'title'   => __('after successful import please go to setting >> reading <br />then set the main and blog page<br />importing media will take few minutes to finish', TEXTDOMAIN),
                'tooltip' => __('If you are new to WordPress or have problems creating posts or pages that look like the theme preview you can import dummy posts and pages here that will definitely help to understand how those tasks are done.', TEXTDOMAIN),
                'fields'  => array(
                    'demo-dummy-data' => array(
                        'label'   => __('Select demo', TEXTDOMAIN),
                        'type'   => 'select',
                        'options'=> array(
                            'standard' => 'Standard',
                            'team'=> 'Team',
                            'photogallery'=> 'Photo Gallery',
                            'rtl'=> 'Right to Left'
                        ),
                    ),
                    'import-dummy-data' => array(
                        'type'   => 'switch',
                        'state0' => __('Don\'t Import', TEXTDOMAIN),
                        'state1' => __('Import', TEXTDOMAIN),
                        'value'  => 0
                    ),
					'import-media' => array(
                        'type'   => 'switch',
                        'state0' => __('Don\'t Import Media', TEXTDOMAIN),
                        'state1' => __('Import Media', TEXTDOMAIN),
                        'value'  => 0
                    ),
                    'import-theme-setting' => array(
                        'type'   => 'switch',
                        'state0' => __('Don\'t Import Theme Setting', TEXTDOMAIN),
                        'state1' => __('Import Theme Setting', TEXTDOMAIN),
                        'value'  => 0
                    )
                )
            ),//import-dummy-data sec

        ),
    );

    $panels = array(
        'general'    => $generalSettingsPanel,
        'biography'  => $biographySetting ,
        'portfolio'  => $portfolioSetting,
        'contact'    => $contactPanel,
        'secLabel'   => $sectionsTitle,
        'appearance' => $appearancePanel,
        'fonts'      => $fontsPanel,
        'social'     => $socialSettingsPanel,
        'footer'     => $footerSettingsPanel,
        'sidebar'    => $sidebarPanel,
        'extra'      => $extraSettingsPanel,
        'api'        => $apiSettingsPanel,
        'data'      => $importExportSettingsPanel,
    );

    $tabs = array(
        'general'    => array( 'text' => __('- General Settings', TEXTDOMAIN ), 'panel' => 'general'),
        'biography'  => array( 'text' => __('- Intro Section' , TEXTDOMAIN ), 'panel'=>'biography'),
        'portfolio'  => array( 'text' => __('- Portfolio Section', TEXTDOMAIN),  'panel' => 'portfolio'),
        'contact'    => array( 'text' => __('- Contact Section' , TEXTDOMAIN ), 'panel'=>'contact'),
        'secLabel'   => array('text' =>  __('- Sections Display & Title' , TEXTDOMAIN ), 'panel'=>'secLabel'),
        'appearance' => array( 'text' => __('- Appearance', TEXTDOMAIN), 'panel' => 'appearance'),
        'fonts'      => array( 'text' => __('- Fonts', TEXTDOMAIN), 'panel'  => 'fonts'),
        'footer'     => array( 'text' => __('- Footer Area', TEXTDOMAIN), 'panel'  => 'footer'),
        'sidebar'    => array( 'text' => __('- Sidebar', TEXTDOMAIN), 'panel' => 'sidebar'),
        'social'     => array( 'text' => __('- Social', TEXTDOMAIN),  'panel' => 'social'),
        'extra'      => array( 'text' => __('- Additional Scripts', TEXTDOMAIN),  'panel' => 'extra'),
        'api'        => array( 'text' => __('- API Keys', TEXTDOMAIN),  'panel' => 'api'),
        'data'       => array( 'text' => __('- Dummy Data', TEXTDOMAIN),  'panel' => 'data')
    );

    $tabGroups = array(
        'theme-settings' => array( 'text' => __('Theme Settings', TEXTDOMAIN), 'tabs' => array('general','secLabel', 'portfolio','biography','contact', 'appearance', 'fonts', 'sidebar', 'footer', 'social') ),
        'other-settings' => array( 'text' => __('Other Settings', TEXTDOMAIN), 'tabs' => array('extra', 'api', 'data') )
    );

    $settings = array(
        'document-url' => 'http://demo3.pixflow.net/promo/personage/documentation/',
        'support-url'  => 'http://support.pixflow.net/',
        'tabs-title'   => __('Theme Options', TEXTDOMAIN),
        'tab-groups'   => $tabGroups,
        'tabs'         => $tabs,
        'panels'       => $panels,
    );

    return $settings;
}