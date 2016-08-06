<?php
$acc    = px_opt('style-accent-color');//Accent color
$accRgb = implode(', ', PxColor::Px_HexToRgb($acc));
$pc     = px_opt('style-font-color');//Primary color
$hc     = px_opt('style-highlight-color');//Highlight color
$lc     = px_opt('style-link-color');//Link color
$lhc    = px_opt('style-link-hover-color');//Link hover color
$logoFontSize    = px_opt('fontsize-logo');//Logo font size
$pgScColor = px_accent2_color($acc);
$logoFontTransform    = px_opt('logo-transform');//Logo font transform

//Fonts
$bodyFont = px_opt('font-body');
$navFont  = px_opt('font-navigation');
$headFont = px_opt('font-headings');
$logoFont = px_opt('font-logo');
?>
body{ color:<?php echo $pc; ?>; font-family:'<?php echo $bodyFont; ?>', sans-serif; }

<?php
$x = px_opt('color-detector');
$y = px_opt('background-type');
if (basename( get_page_template(),".php") != 'home-page'){
    if (px_opt('color-detector') != 1 || px_opt('background-type') != 'image' || px_firstMenuItem() != "intro"){ ?>
        .logo .name{color: <?php echo px_opt('style-menu-color');?> !important;}
    <?php }
}else{ ?>
    .logo .name{color: <?php echo px_opt('style-menu-color');?> !important;}
<?php } ?>

    #page-top-menu nav ul li.menu-item span,
    #page-top-menu nav ul li.menu-item div.icon,
    .single #page-top-menu nav ul li.menu-item span,
    .blog #page-top-menu nav ul li.menu-item span,
    .single #page-top-menu nav ul li.menu-item div.icon,
    .blog #page-top-menu nav ul li.menu-item div.icon{
    color : <?php echo px_opt('style-menu-color');?>;
    }

    #page-top-menu nav ul li.menu-item{
    border-left: 1px solid <?php echo px_opt('style-menu-color');?>;
    border-right:none;
    }
    body.rtl #page-top-menu nav ul li.menu-item{
    border-right: 1px solid <?php echo px_opt('style-menu-color');?>;
    border-left:none;
}

/*----- Start of Fonts ------*/
body,
.post-info span,
.experience,
.progressbar .title,
#intro .about .description,
.contact-page .info .address,
.contact-page .info .email,
.contact-page .info .phone,
.contact-page .info .website,
.contact-page .info .other-info,
.contact-page .px-form-name input[type="text"],
.contact-page .px-form-email input[type="email"],
.contact-page .px-form-message textarea,
#testimonial .special-intro .descriptions .description,
.mfp-wrap .mfp-container .mfp-content .slider-popup .portfolio-description,
#portfolio article.portfolio-item .portfolio-image-link .description .category
{font-family:'<?php echo $bodyFont; ?>', sans-serif; }

/* Headings */

h1, h2, h3, h4, h5, h6,
blockquote,
.percent,
.page-title,
.post .title a,
.progressbar .title,
.single-post .head .date,
.single-post .head .title,
#experience a.print-box,
#intro .about .about-name,
#portfolio .portfolio-header,
#testimonial .testimonial-header,
#skill .skills .skill-text,
#experience .experience-header,
#education .education-header,
#experience .experience-parts .experience-part h3,
#education .education-parts .education-part .title h3,
#portfolio ul.portfolio-filter li,
#portfolio ul.portfolio-filter li ul li a,
#contact-topbar div.contact-form .contact-text,
#contact-topbar div.contact-form .contact-header,
footer .widget-area .widget-title,
#page-footer .widget_px_twitter li span,
.post .timeline-container .date span,
#respond .comment-reply-title,
#education .education-parts .education-part .title .years,
#experience .experience-parts .experience-part .years,
#portfolio article.portfolio-item .portfolio-image-link .description .title,
.custom-part .custom-part-title,
.custom-part-text
{ font-family:'<?php echo $headFont; ?>', sans-serif; }

/*----- Fonts Ends -----*/

/* Logo Name */
.logo a { color: inherit; }
.logo .name{ <?php if($logoFontSize != ''){ ?>
    font-size:<?php echo $logoFontSize; ?>px;
    line-height:<?php echo $logoFontSize; ?>px;<?php } ?>
    font-family:'<?php echo $logoFont; ?>', sans-serif;<?php if($logoFontTransform == 1){ ?>text-transform:uppercase;<?php } ?>
}

/* Text Selection */

::-moz-selection { background: <?php echo $hc; ?>; /* Firefox */ }
::selection { background: <?php echo $hc; ?>; /* Safari */ }


/* Anchor */

a{ color:<?php echo $lc; ?>; }
a:hover{ color:<?php echo $lhc; ?>; }


/* Separator */
.separator{ background-color:<?php echo $acc; ?>; }
.media-separator{ background-color:<?php echo $acc; ?>; }




/* Navigation */

#page-top-menu nav ul li.menu-item span { font-family:'<?php echo $navFont; ?>', sans-serif; }

.archive .text-comment .more-link:hover,
.blog .text-comment .more-link:hover,
.archive .text-comment .more-link span:hover ,
.blog .text-comment  .more-link span:hover,
.widget_px_testimonials .name{
    color:<?php echo $acc; ?>;
}



.archive .comments-link,
.blog .comments-link,
.comments-list .comment-reply-link:hover
{
	background-color:<?php echo $acc; ?>
}

#commentform input[type="submit"]{
	background-color:<?php echo $acc; ?>;
    border:1px solid <?php echo $acc; ?>;

}

.single-post .head .date{
	color:<?php echo $acc; ?>;
}


.button1{
    background-color:<?php echo $acc; ?>;
}

.color-accent-background
{
    background-color:<?php echo $acc; ?>;
}

.color-accent-foreground
{
    color:<?php echo $acc; ?>;
}


#page-title{
    background-color:<?php echo $acc; ?>;
}


.widget-area a:hover{
    color:<?php echo $acc; ?>;
}

.tagcloud a:hover{
    color:<?php echo $acc; ?>;

    border: 1px solid <?php echo $acc; ?>;
    -moz-border: 1px solid <?php echo $acc; ?>;
    -webkit-border: 1px solid <?php echo $acc; ?>;
}

.widget_bj_testimonials .name{
    color: <?php echo $acc; ?>;
}

.widget_px_testimonials .name
    color: <?php echo $acc; ?>;
}
#footer-bottom a:hover
{
    color:<?php echo $acc; ?>;
}

footer .social-icons span:hover
{
    color: <?php echo $acc; ?>;
}

footer .copyright-text a:hover{color: <?php echo $acc; ?>;}

footer .widget-area hr{
    background-color: <?php echo $acc; ?>;
}

footer .widget_tag_cloud a:hover{
    background-color: <?php echo $acc; ?>;
    border:1px solid <?php echo $acc; ?>;
}

.footer-widgets .wpcf7 input[type="submit"]:hover{
    background-color: <?php echo $acc; ?>;
}

.iconbox.iconbox-hex:hover .icon{
    background-color: <?php echo $acc; ?>;
}

.iconbox.iconbox-circle:hover .icon{
    border:1px solid <?php echo $acc; ?>;
}

.iconbox .glyph{
    color: <?php echo $acc; ?>;
}

.iconbox.iconbox-circle:hover .glyph,
.iconbox.iconbox-hex:hover .glyph{
    color:<?php echo $acc; ?>;
}

.iconbox:hover .title{
    color:<?php echo $acc; ?>;
}

.iconbox .more-link a:hover{
    color: <?php echo $acc; ?>;
}


#portfolio article.portfolio-item:hover .portfolio-image-link .description{
    background-color: <?php echo $acc; ?>;
}

#page-top-menu nav ul li.menu-item:hover span.menu-item-description {
    color: <?php echo $acc; ?> !important;
}

#skill .skills div.underline-box,
.custom-part div.underline-box{
    background-color: <?php echo $acc; ?>;
}

#experience .experience-header,
#education .education-header,
#experience .experience-parts .experience-part .underline-box,
#education .education-parts .education-part .underline-box,
#portfolio div.underline-box,
#testimonial div.underline-box,
#experience a.print-box:hover,
.custom-part  .custom-part-title.have-background{
    background-color: <?php echo $acc; ?>;
}

#experience .experience-parts .experience-part:hover .description .icon,
#education .education-parts .education-part:hover .description .icon,
#page-footer ul li.social-icon a:hover,
.post-content .quote-symbol,
.post-pagination a:hover,
.post-pagination .this-page,
.post .title a:hover{
    color : <?php echo $acc; ?>;
}

#experience a.print-box:hover{
    border-color : <?php echo $acc; ?>;
}

.progressbar .progress{
	background-color:<?php echo $pgScColor; ?>; 
}

.widget_px_progress .progress{
    background:rgba(<?php echo $accRgb; ?> , 0.3 );
}

.progressbar .progress-inner{
    background:rgba(<?php echo $accRgb; ?> , 0.8 );
}



/*==== Style Overrides ====*/

<?php
if(px_opt("dark-style-status")==1){?>
#experience .experience-parts .experience-part{
    border-bottom: 1px solid #ffffff;
}
body,
#skill .skills *,#skill .skills .skill-text,
#experience .experience-parts .experience-part .title h3,
#experience .experience-parts .experience-part .years,
#education .education-parts .education-part .title h3,
#experience .experience-parts *,
#education .education-parts *,
#portfolio .portfolio-header,
#portfolio ul.portfolio-filter,
#portfolio ul.portfolio-filter li ul li a,
#portfolio article.portfolio-item .portfolio-image-link .description .title,
#portfolio article.portfolio-item:hover .portfolio-image-link .description .title,
#testimonial .testimonial-header,
#testimonial .special-intro .descriptions .description,
#page-footer .widget-area,
#page-footer .widget-area a,
#page-footer .widget-area .widget-title,
#page-footer .copyright-text,
#page-footer .copyright-text a,
.post .title a,
.page-title,
blockquote,
blockquote *,
.post-info span,
.post-info span a,
.widget-area .widget-title,
.single-post .head .title,
.comments-list *,
.comments-list cite a,
.widget_px_recent_posts .item-date,
.widget_px_recent_portfolio .item-date,
#page-footer .widget_px_twitter li span,
#page-footer .widget_px_twitter .join,
#contact-topbar div.contact-form .contact-text{
    color:#ffffff !important;
}
.archive .text-comment .more-link,
.blog .text-comment .more-link,
#contact-topbar div.contact-form .contact-header{
    color:#ffffff;
}
body,
#portfolio ul.portfolio-filter,
#portfolio ul.portfolio-filter li ul,
#portfolio article.portfolio-item .portfolio-image-link div.overly,
#portfolio article.portfolio-item .portfolio-image-link .description{
    background-color:#3c3c3c;
}
#page-footer .widget-area li {
    border-bottom: 1px solid #b4b4b4;
}
#portfolio ul.portfolio-filter{
    border:1px solid #ffffff;
}
#portfolio ul.portfolio-filter li ul {
    border: 1px solid #ffffff;
    border-top:none;
}
#portfolio ul.portfolio-filter li ul li a:hover,
#contact-topbar.contact-topbar .gmap ul.social-icons li.social-icon a:hover{
    background-color: #fff;
    color: #000 !important;
}
#portfolio article.portfolio-item{
    border-color:#2b2b2b;
}
#experience a.print-box{
    border-color:#1f1f1f;
}
#one-page-nav,
#experience a.print-box,
.loadmore,
.loadmore .loadmore-text{
    background-color:#1f1f1f;
    color:#fff;
}

.loadmore-btn {
    background: url("<?php echo THEME_IMAGES_URI ?>/arrow-dark.png") no-repeat scroll center center #1f1f1f;
}


.post .title a, .page-title{
    color:#fff;
}

.archive .comments-link, .blog .comments-link{
    background: url("<?php echo THEME_IMAGES_URI ?>/comments-count-dark.png") no-repeat scroll center bottom / 34px 7px <?php echo $acc; ?>;
}

#contact-topbar{
    background-color:#1f1f1f;
}
#contact-topbar .control-bar a.close-btn{
    background-image: url("<?php echo THEME_IMAGES_URI ?>/topbar-close-dark.png");
}
#contact-topbar div.contact-form input{
    color:#000;
}
#contact-topbar div.contact-form .underline-box{
    background-color:#f1f1f1;
}

<?php }?>
<?php px_eopt('additional-css'); ?>
