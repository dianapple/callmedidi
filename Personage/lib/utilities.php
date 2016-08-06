<?php

require_once(THEME_LIB . '/includes/simple_html_dom.php');

function px_get_pagination($query = null, $range = 3) {
    global $paged, $wp_query;

    $q = $query == null ? $wp_query : $query;
    $output = '';

    // How much pages do we have?
    if ( !isset($max_page) ) {
        $max_page = $q->max_num_pages;
    }

    // We need the pagination only if there is more than 1 page
    if ( $max_page < 2 )
        return $output;

    $output .= '<div class="post-pagination">';

    if ( !$paged ) $paged = 1;

    // To the previous page
    if($paged > 1)
        $output .= '<a class="prev-page-link" href="' . get_pagenum_link($paged-1) . '"><div class="icon-arrow-left6"></div></a>';

    if ( $max_page > $range + 1 ) {
        if ( $paged >= $range )
            $output .= '<a href="' . get_pagenum_link(1) . '">1</a>';
        if ( $paged >= ($range + 1) )
            $output .= '<span class="page-numbers">&hellip;</span>';
    }

    // We need the sliding effect only if there are more pages than is the sliding range
    if ( $max_page > $range ) {
        // When closer to the beginning
        if ( $paged < $range ) {
            for ( $i = 1; $i <= ($range + 1); $i++ ) {
                $output .= ( $i != $paged ) ? '<a href="' . get_pagenum_link($i) .'">'.$i.'</a>' : '<span class="this-page">'.$i.'</span>';
            }
            // When closer to the end
        } elseif ( $paged >= ($max_page - ceil(($range/2))) ) {
            for ( $i = $max_page - $range; $i <= $max_page; $i++ ) {
                $output .= ( $i != $paged ) ? '<a href="' . get_pagenum_link($i) .'">'.$i.'</a>' : '<span class="this-page">'.$i.'</span>';
            }
            // Somewhere in the middle
        } elseif ( $paged >= $range && $paged < ($max_page - ceil(($range/2))) ) {
            for ( $i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++ ) {
                $output .= ($i != $paged) ? '<a href="' . get_pagenum_link($i) .'">'.$i.'</a>' : '<span class="this-page">'.$i.'</span>';
            }
        }
        // Less pages than the range, no sliding effect needed
    } else {
        for ( $i = 1; $i <= $max_page; $i++ ) {
            $output .= ($i != $paged) ? '<a href="' . get_pagenum_link($i) .'">'.$i.'</a>' : '<span class="this-page">'.$i.'</span>';
        }
    }

    if ( $max_page > $range + 1 ){
        // On the last page, don't put the Last page link
        if ( $paged <= $max_page - ($range - 1) )
            $output .= '<span class="page-numbers">&hellip;</span><a href="' . get_pagenum_link($max_page) . '">' . $max_page . '</a>';
    }

    // Next page
    if($paged < $max_page)
        $output .= '<a class="" href="' . get_pagenum_link($paged+1) . '"><div class="icon-uniE81F"></div></a>';

    $output .= '</div><!-- post-pagination -->';

    echo $output;
}

// retrieves the attachment ID from the file URL
function px_get_image_id($image_url) {
	global $wpdb;

	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " .$wpdb->prefix. "posts WHERE guid='%s';", $image_url));
	
	if(count($attachment))
		return $attachment[0];
	else
		return -1;
}

function px_get_related_posts_by_taxonomy($postId, $taxonomy, $maxPosts = 9)
{
	$terms   = wp_get_object_terms($postId, $taxonomy);

	if (!count($terms))
		return new WP_Query();
		
	$termsSlug = array();
	
	foreach($terms as $term)
		$termsSlug[] = $term->slug;

	$args=array(
	  'post__not_in' => array($postId),
	  'post_type' => get_post_type($postId),
	  'showposts'=>$maxPosts,
	  'tax_query' => array(
		array(
				'taxonomy' => $taxonomy,
				'field' => 'slug',
				'terms' => $termsSlug
			)
		)
	);
	
	return new WP_Query($args);
}

//Return theme option
function px_opt($option){
	$opt    = get_option(OPTIONS_KEY);
    $optVal = $opt[$option];

    // check if data save as an array in data base
    if ((is_array($optVal)) or ($optVal instanceof Traversable)){
        $optTemp = '';
        foreach($optVal as $val){
            $optTemp[] = stripslashes($val);
        }

        $optVal = $optTemp;
    } else {
        stripslashes($optVal);
    }


	return $optVal;
}

//Echo theme option
function px_eopt($option){
	echo px_opt($option);
}

function px_print_terms($terms, $separatorString)
{
	$termIndex = 1;
	if($terms) 
	foreach ($terms as $term) 
	{ 
		echo $term->name; 
		
		if(count($terms) > $termIndex) 
			echo $separatorString; 

		$termIndex++;
	}
}

/*
 * Gets array value with specified key, if the key doesn't exist
 * default value is returned
 */
function px_array_value($key, $arr, $default='')
{
    return array_key_exists($key, $arr) ? $arr[$key] : $default;
}


/*
 * Deletes attachment by given url
 */
function px_delete_attachment( $url ) {
    global $wpdb;

    // We need to get the image's meta ID.
    $query = "SELECT ID FROM wp_posts where guid = '" . esc_url($url) . "' AND post_type = 'attachment'";
    $results = $wpdb->get_results($query);

    // And delete it
    foreach ( $results as $row ) {
        wp_delete_attachment( $row->ID );
    }
}

function px_get_post_terms_names($taxonomy)
{
    $terms = get_the_terms( get_the_ID(), $taxonomy );

    if(!is_array($terms))
        return $terms;

    $termNames = array();

    foreach ($terms as $term)
        $termNames[] = $term->name;

    return $termNames;
}

/*
 * Concatenate post category names
 */
function px_implode_post_terms($taxonomy, $separator = ', ')
{
    $terms = px_get_post_terms_names($taxonomy);

    if(!is_array($terms))
        return null;

    return implode($separator, $terms);
}

/*
 * Converts array of slugs to corresponding array of IDs
 */
function px_slugs_to_ids($slugs=array(), $taxonomy)
{
    $tempArr = array();
    foreach($slugs as $slug)
    {
        if(!strlen(trim($slug))) continue;
        $term = get_term_by('slug', $slug, $taxonomy);
        if(!$term) continue;
        $tempArr[] = $term->term_id;
    }

    return $tempArr;
}

function px_get_meta($key, $single = true)
{
    $pid = null;

    if(in_the_loop() || is_single() || (is_page() && !is_home()))
    {
        $pid = get_the_ID();

        // Add bbpress Option
        $pageMeta = get_post($pid,ARRAY_A );

        if ($pageMeta['post_type']=='forum'){
            global $wpdb; // you may not need this line
            $pid = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = 'forums'");
        }
    }
    //Special case for blog page
    elseif(is_home() && !is_front_page())
    {
        $pid = get_option('page_for_posts');
    }
    if(null == $pid)
        return '';


    return get_post_meta($pid, $key, $single);
}

/* Get video url from known sources such as youtube and vimeo */

function px_extract_video_info($string)
{
    //check for youtube video url
    if(preg_match('/https?:\/\/(?:www\.)?youtube\.com\/watch\?v=[^&\n\s"<>]+/i', $string, $matches ))
    {
        $url = parse_url($matches[0]);
        parse_str($url['query'], $queryParams);

        return array('type'=>'youtube', 'url'=> $matches[0], 'id' => $queryParams['v']);
    }
    //Vimeo
    else if(preg_match('/https?:\/\/(?:www\.)?vimeo\.com\/\d+/i', $string, $matches))
    {
        $url = parse_url($matches[0]);

        return array('type'=>'vimeo', 'url'=> $matches[0], 'id' => ltrim($url['path'], '/'));
    }

    return null;
}

function px_extract_audio_info($string)
{
    //check for soundcloud url
    if(preg_match('/https?:\/\/(?:www\.)?soundcloud\.com\/[^&\n\s"<>]+\/[^&\n\s"<>]+\/?/i', $string, $matches ))
    {
        return array('type'=>'soundcloud', 'url'=> $matches[0]);
    }

    return null;
}

function px_get_video_meta(array &$video)
{
    if($video['type']  != 'youtube' && $video['type'] != 'vimeo')
        return null;

    $ret = px_get_url_content($video['url']/*, '127.0.0.1:8080'*/);

    if(is_array($ret))
        return 'Server Error: ' . $ret['error'] . " \nError No: " . $ret['errorno'];

    if(trim($ret) == '')
        return 'Error: got empty response from youtube';

    $html = str_get_html($ret);
    $vW   = $html->find('meta[property="og:video:width"]');
    $vH   = $html->find('meta[property="og:video:height"]');

    if(count($vW) && count($vH))
    {
        $video['width']  = $vW[0]->content;
        $video['height'] = $vH[0]->content;
    }

    return null;
}

function px_soundcloud_get_embed($url)
{
    $json = px_get_url_content("http://soundcloud.com/oembed?format=json&url=$url"/*, '127.0.0.1:8580'*/);

    if(is_array($json))
        return 'Server Error: ' . $json['error'] . " \nError No: " . $json['errorno'];

    if(trim($json) == '')
        return 'Error: got empty response from soundcloud';

    //Convert the response string to PHP object
    $data = json_decode($json);

    if(NULL == $data)
        return "Cant decode the soundcloud response \nData: $json" ;

    //TODO: add additional error checks

    return $data->html;
}

/* downloads data from given url */

function px_get_url_content($url, $proxy='')
{
    $ch = curl_init();

    // set URL and other appropriate options
    $options = array( CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true );

    if($proxy != '')
        $options[CURLOPT_PROXY] = $proxy;

    // set URL and other appropriate options
    curl_setopt_array($ch, $options);

    $ret = curl_exec($ch);

    if(curl_errno($ch))
        $ret = array('error' => curl_error($ch), 'errorno' => curl_errno($ch));

    curl_close($ch);
    return $ret;
}


//Thanks to:
//http://bavotasan.com/tutorials/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
function px_excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

/* CF7 */

function px_get_contact_form7_forms()
{
    // Get WPDB Object
    global $wpdb;

    // Table name
    $table_name = $wpdb->prefix . "posts";

    // Get forms
    $forms = $wpdb->get_results( "SELECT * FROM $table_name
                                  WHERE post_type='wpcf7_contact_form'
                                  LIMIT 100" );

    $items = array('no-form'=>'');

    // Iterate over the sliders
    foreach($forms as $key => $item) {
        $shortcode = '[contact-form-7 id="'.$item->ID.'" title="'.$item->post_title.'"]';
        $items[$shortcode] = $item->post_title;
    }


    return $items;
}

/* Search Pages by content */

function px_search_pages_by_content($cnt)
{
    // Get WPDB Object
    global $wpdb;

    $sql = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type='page' AND post_status='publish' AND post_content LIKE %s",
        '%' . like_escape($cnt) . '%' );

    // Get forms
    $pages = $wpdb->get_results( $sql );

    return $pages;
}

/* Get the id of a page by its name */

function px_get_page_id($page_name){
    global $wpdb;
    $page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
    return $page_name;
}

/* Sidebar widget count */

function px_count_sidebar_widgets( $sidebar_id, $echo = false ) {
    $sidebars = wp_get_sidebars_widgets();

    if( !isset( $sidebars[$sidebar_id] ) )
        return -1;

    $cnt = count( $sidebars[$sidebar_id] );

    if( $echo )
        echo $cnt;
    else
        return $cnt;
}

function px_get_custom_sidebars()
{
    $sidebarStr = px_opt('custom_sidebars');

    if(strlen($sidebarStr) < 1)
        return array();

    $arr      = explode(',', $sidebarStr);
    $sidebars = array();

    foreach($arr as $item)
    {
        $sidebars["custom-" . hash("crc32b", $item)] = str_replace('%666', ',', $item);
    }

    return $sidebars;
}

/* Get Sidebar */

function px_get_sidebar($id=1, $class='')
{
    $sidebarClass = "sidebar widget-area";

    if('' != $class)
        $sidebarClass .= " $class";

    if(px_count_sidebar_widgets($id) < 1)
        $sidebarClass .= ' no-widgets';
    ?>
    <div class="<?php echo $sidebarClass; ?>"><?php dynamic_sidebar($id); ?></div>
<?php
}

function px_accent2_color($color)
{
    //Only support hex for now
    if(!PxColor::Px_IsHex($color))
        return '';

    $tempColor = PxColor::Px_HexToHsv($color);

    if($tempColor[1] >= 50)
    {
        $val = round($tempColor[1] * .2);
    }
    elseif($tempColor[1] >= 30 && $tempColor[1] < 50)
    {
        $val = round($tempColor[1] * .4);
    }
    else
    {
        $val = max($tempColor[1]-10, 5);
    }

    $tempColor = PxColor::Px_HsvToHex($tempColor[0], $val, $tempColor[2]);
    return $tempColor;
}

// Active Portfolio
function px_active_portfolio_terms()
{
    //get all terms of skill
    $portfolioTerms = get_terms('skills');
    $portfolioSlugs = array();

    //get active skill terms
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $portfolioPosts = ( px_get_meta('portfolio-posts')=="")?5 :px_get_meta('portfolio-posts');

    $queryArgs = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => $portfolioPosts,
        'paged'          => $paged
    );

    $activeTerms = array();

    $query = new WP_Query($queryArgs);
    while ($query->have_posts()) { $query->the_post();
        $activeTerms = px_get_post_terms_names('skills');

        if ( $activeTerms ){
            for ($i=0; $i<count($activeTerms); $i++)
            {
                foreach($portfolioTerms as $term)
                {
                    if($activeTerms[$i] == $term->name ){

                        $portfolioSlugs[$term->slug] = $term->name;
                    }
                }

            }

        }

    }
    wp_reset_query();

    $skills = $portfolioSlugs;
    $catArr  = px_slugs_to_ids($skills, 'skills');
    return $catArr;
}


//  Custom Login Logo
function px_login_logo() {

    $login_logo =  THEME_ADMIN_URI . '/img/welcome.png';
    echo '<style type="text/css"> h1 a { background: url(' . $login_logo . ') center no-repeat !important; width:302px !important; height:67px !important  } </style>';
}
add_action('login_head', 'px_login_logo');

function px_contactInMenu(){
    $locations = get_nav_menu_locations();
    if (isset($locations['primary-nav'])) {
        $menu_id = $locations['primary-nav'];
        $menu_items = wp_get_nav_menu_items( $menu_id, array() );
        if( !empty( $menu_items ) ) {
            foreach( $menu_items as $menu_item ) {
                $used_sections[] = $menu_item->object;
            }
        }
        if(in_array("contact",$used_sections)){
            return true;
        }else{
            return false;
        }
    }
}

function px_firstMenuItem(){
    $locations = get_nav_menu_locations();
    if (isset($locations['primary-nav'])) {
        $menu_id = $locations['primary-nav'];
        $menu_items = wp_get_nav_menu_items( $menu_id, array() );
        if( !empty( $menu_items ) ) {
            foreach( $menu_items as $menu_item ) {
                $used_sections[] = $menu_item->object;
            }
        }

        return $used_sections[0];
    }
}

add_filter( 'manage_posts_columns', 'px_revealid_add_id_column', 5 );
add_action( 'manage_posts_custom_column', 'px_revealid_id_column_content', 5, 2 );


function px_revealid_add_id_column( $columns ) {
    $columns['revealid_id'] = 'ID';
    return $columns;
}

function px_revealid_id_column_content( $column, $id ) {
    if( 'revealid_id' == $column ) {
        echo $id;
    }
}