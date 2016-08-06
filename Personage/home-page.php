<?php
/*
Template Name: Main Page
*/

get_header();

function introSection(){
    get_template_part('templates/section','intro');
}

function skillSection(){
    get_template_part('templates/section','skill');
}

function experienceSection(){
    get_template_part('templates/section','experience');
}

function educationSection(){
    get_template_part('templates/section','education');
}

function portfolioSection(){
    get_template_part('templates/section','portfolio');
}

function testimonialSection(){
    get_template_part('templates/section','testimonial');
}

function custompartSection($my_postid){
    include(locate_template('templates/section-custompart.php'));
}




function onePageNavigation($used_sections){
    $i=1;
    ?>
    <div id="one-page-nav" style="margin-bottom: -73px; right: 40px; opacity: 0.6;">
        <ul id="fixed-nav">
<?php
    foreach($used_sections as $section){
        if ($section=="intro"||$section=="skill"||$section=="experience"
            ||$section == "education" || $section == "portfolio"||$section=="testimonial" || is_numeric($section) ) {
            $class = ($i===1)? 'class="current"' : "";


            if(is_numeric($section)){
                $title=get_the_title($section);
            }
            else{
                switch($section)
                {
                    case "intro":
                        $title=px_opt("bio-title");
                        break;
                    case "skill":
                        $title=px_opt("skills");
                        break;
                    case "portfolio":
                        $title =px_opt("portfolio");
                        break;
                    case "testimonial":
                        $title =px_opt("testimonial");
                        break;
                    case "education":
                        $title =px_opt("education");
                        break;
                    case "experience":
                        $title =px_opt('experience');
                        break;
                }
            }



            ?>
            <li <?php echo $class ?>>
                <a href="#<?php echo $section ?>" rel="tooltip" class="NavTooltip" data-original-title="<?php echo $title ?>" data-placement="left" title="<?php echo $title ?>">
                    <i></i>
                </a>
            </li>

        <?php
        } // end switch
        $i++;
    } // end foreach of used sections
    ?>
        </ul>
    </div>
<?php
}




function contactSection(){
    get_template_part('templates/section','contact');
}





function contactForPrintStyle(){
?>
<div class="contact-info">
    <h2 class="contact-header"><?php echo (px_opt('contact-title')=="")?__('CONTACT ME',TEXTDOMAIN):px_opt('contact-title')?></h2>
    <div class="underline-box"></div>
    <?php if(px_opt('contact-address')!= ""){ ?>
        <p class="address"><?php echo __('Address: ',TEXTDOMAIN) . px_opt('contact-address'); ?></p>
    <?php }if(px_opt('contact-phone')!= ""){ ?>
        <p class="phone"><?php echo __('Phone: ',TEXTDOMAIN). px_opt('contact-phone'); ?></p>
    <?php } if(px_opt('contact-email')!= ""){ ?>
        <p class="email"><?php echo  __('Email: ',TEXTDOMAIN). px_opt('contact-email'); ?></p>
    <?php } ?>
</div>
<?php
}




$locations = get_nav_menu_locations();
if (isset($locations['primary-nav'])) {
    $menu_id = $locations['primary-nav'];
    $menu_items = wp_get_nav_menu_items( $menu_id, array() );
    $used_sections=array();
    
    if( !empty( $menu_items ) ) {
       
        foreach( $menu_items as $menu_item ) {
            $url=$menu_item->url;
            $url=explode("#",$url);
            if(!isset($url[1])){
                continue;
            }
            if(is_numeric($url[1])){
                array_push($used_sections,$url[1]);
            }
            switch($url[1])
            {
                case "intro":
                array_push($used_sections,"intro");
                break;
                case "education":
                array_push($used_sections,"education");
                break;
                case "experience":
                array_push($used_sections,"experience");
                break; 
                case "contact":
                array_push($used_sections,"contact");
                break; 
                case "portfolio":
                array_push($used_sections,"portfolio");
                break; 
                case "skill":
                array_push($used_sections,"skill");
                break; 
                case "testimonial":
                array_push($used_sections,"testimonial");
                break; 
            }
            
        }
        
    }

    foreach($used_sections as $section){

        if(is_numeric($section)){
             custompartSection($section);
        }

        switch ($section) {
            case 'intro':
                introSection();
                break;
            case 'skill':
                skillSection();
                break;
            case 'experience':
                experienceSection();
                break;
            case 'education':
                educationSection();
                break;
            case 'portfolio':
                portfolioSection();
                break;
            case 'testimonial':
                testimonialSection();
                break;
            case 'contact':
                contactSection();
                break;
        } // end switch
    } // end foreach of used sections

if (px_opt("small-nav")){
    onePageNavigation($used_sections);
}
    contactForPrintStyle();

} // end if primary nav is exist

get_footer();