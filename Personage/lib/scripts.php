<?php
require_once THEME_LIB . '/google-fonts.php';

function px_theme_scripts()
{
	//Register google fonts
    px_theme_fonts();

    //Register Styles
	wp_enqueue_style('style', get_bloginfo( 'stylesheet_url' ), array(), THEME_VERSION);

    //check registered styles
    global $wp_styles;
    $style = $wp_styles -> registered ;
	if( ! array_key_exists('plugins-style',$style) ){
	    wp_enqueue_style('plugins-style',px_path_combine(THEME_CSS_URI,'pluginstyle.css'),false,THEME_VERSION);
    }

    wp_enqueue_style('responsive-style', px_path_combine(THEME_CSS_URI, 'responsive.css'), false, THEME_VERSION);
    //wp_enqueue_style('rtl-style', px_path_combine(THEME_CSS_URI, 'rtl.css'), false, THEME_VERSION);

    //Print StyleSheet
    wp_enqueue_style('print',px_path_combine(THEME_CSS_URI,'print.css'),'',THEME_VERSION,'print');

    //TF requirement (we have our own reply script for gods sake!)
    if(USE_COMMENT_REPLY_SCRIPT && is_singular())
        wp_enqueue_script( "comment-reply" );



    //Add style overrides
    ob_start();
    include(px_path_combine(THEME_CSS, 'styles-inline.php'));
    wp_add_inline_style('style', ob_get_clean());

    //register and enqueue html5shiv
    global $wp_scripts;
    wp_register_script(
        'html5shiv',
        px_path_combine(THEME_JS_URI , 'html5shiv.js'),
        array(),
        '3.6.2'
    );
    $wp_scripts->add_data( 'html5shiv', 'conditional', 'lt IE 9' );

    preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if (count($matches)>1){
        //Then we're using IE
        $version = $matches[1];

        if($version <= 9 )
        {
         wp_enqueue_script('html5shiv');
        }
    }

    //Include jQuery
    wp_enqueue_script('jquery');

    //Main JS handler
    
	wp_enqueue_script('googleMap',"http://maps.google.com/maps/api/js?sensor=false&amp;language=en",array(),THEME_VERSION,true);
    wp_enqueue_script('plugins',px_path_combine(THEME_JS_URI,'plugins.js'),array(),THEME_VERSION,true);
	wp_enqueue_script('mainjs',px_path_combine(THEME_JS_URI,'custom.js'),array(),THEME_VERSION,true);
   

    $appdata = array( 'gkey'    => px_opt('google-api-key'),
        'path'    => array( 'img' => THEME_IMAGES_URI, 'js' => THEME_JS_URI),
        'extrajs' => px_opt('additional-js'),
        'siteaddress'=>get_site_url()
    );

    wp_localize_script( 'mainjs', 'appdata', $appdata );

}
add_action('wp_enqueue_scripts', 'px_theme_scripts');


function px_add_editor_styles()
{
    add_editor_style();
}
add_action( 'init', 'px_add_editor_styles' );


function px_theme_fonts()
{
    $fontBody     = px_opt('font-body');
    $fontNav      = px_opt('font-navigation');
    $fontHeading  = px_opt('font-headings');
    $fontLogo     = px_opt('font-logo');

    //Fix for setup problem (shouldn't happen after the update, just for old setups)
    if('' == $fontBody && '' == $fontNav && '' == $fontHeading && '' == $fontLogo)
        $fontBody = $fontNav = $fontHeading = $fontLogo = '';

    $fonts        = array($fontBody, $fontNav, $fontHeading, $fontLogo);
    $fonts        = array_filter($fonts);//remove empty elements

    $fontVariants = array(array(300,400,600,700), array(400), array(400),array(400));//Suggested variants if available
    $fontList     = array();
    $fontReq      = 'http://fonts.googleapis.com/css?family=';
    $gf           = new PxGoogleFonts(px_path_combine(THEME_LIB, 'googlefonts.json'));

    //Build font list
    foreach($fonts as $key => $font)
    {
        $duplicate = false;
        //Search for duplicate
        foreach($fontList as $item)
        {
            if($font == $item['font'])
            {
                $duplicate = true;
                if(is_array($fontVariants[$key]))
                $item['variants'] = array_unique(array_merge($item['variants'], $fontVariants[$key]));
                break;
            }
        }

        //Add
        if(!$duplicate)
            $fontList[] = array('font'=>$font, 'variants'=>$fontVariants[$key]);
    }

    $temp=array();
    foreach($fontList as $item)
    {
        $font = $gf->Px_GetFontByName($item['font']);

        if(null==$font)
            continue;

        $variants = array();
        if(is_array($item['variants']))
        foreach($item['variants'] as $variant)
        {
            //Check if font object has the variant
            if(in_array($variant, $font->variants))
            {
                $variants[] = $variant;
            }
            else if(400 == $variant && in_array('regular', $font->variants))
            {
                $variants[] = $variant;
            }
        }

        $query = preg_replace('/ /', '+', $item['font']);

        if(count($variants))
            $query .= ':' . implode(',', $variants);

        $temp[] = $query;
    }

    if(count($temp))
    {
        $fontReq .= implode('|', $temp);
        wp_enqueue_style('fonts', $fontReq);
    }
}

//JS Flag Trick
function px_add_js_support_script()
{
    ?>
    <script type="text/javascript">
        document.body.className = document.body.className.replace('no-js','js-enabled');
    </script>
    <?php
}
add_Action('px_body_start', 'px_add_js_support_script');


//Making jQuery Google API
function modify_jquery() {
    if (!is_admin()) {
        // comment out the next two lines to load the local copy of jQuery
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js', false, '1.11.0');
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'modify_jquery');