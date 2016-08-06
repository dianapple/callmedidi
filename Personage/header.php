<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php

    ?>
	<meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
	<title><?php bloginfo('name'); wp_title(' - ', true, 'left'); ?></title>
	
	<?php if(px_opt('favicon') != ""){ ?>
	<link rel="shortcut icon" href="<?php px_eopt('favicon'); ?>"  />
	<?php } ?>

    <link rel="stylesheet" href="<?php  ?>" type="text/css" media="print" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


	<!-- Theme Hook -->
    <?php
        wp_head();
    ?>

	<!-- Custom CSS -->
</head>
<?php
    $siteBg = px_opt('bg-type');
    if ( "1" == $siteBg ){
        $style =  "background:".px_opt('body-solid');
    }else {
        $style = "background:url(".px_path_combine(THEME_ADMIN_URI,'img/texture/bg'.px_opt('body-texture').'.png').") repeat;";
    }

?>


<body <?php body_class('no-js'); ?> style="<?php echo $style; ?>">
<?php
do_action('px_body_start');
//Because it pushes the entire content to a side, it should be placed outside of layout element
get_template_part( 'templates/navigation-mobile' ); ?>
<div class="main" page-template="<?php echo basename( get_page_template(),".php" ); ?>">
    <!--Header-->
    <?php
    do_action('px_before_header');
    get_template_part( 'templates/header' );
    ?>
    <!--End Header-->