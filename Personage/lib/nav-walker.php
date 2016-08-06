<?php

class PxCustomNavWalker extends Walker_Nav_Menu
{
    private $navIdPrefix = '';
	private $menu_pages = '';

    public function __construct($idPrefix='menu-item-')
    {
        $this->navIdPrefix = $idPrefix;
    }
	
	function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $allowedParts = array('page','contact','custom','category');
        $elemVisible = true;
        $val = $object->object;
        if (!in_array($val,$allowedParts))
            if((int)px_opt($object->object.'-display')== 0){
                return;
            }

        $url=explode("#",$object->url);
        $display=true;
        if(sizeof($url)>1)
        {
            $url=$url[1];

            if(is_numeric($url)){
                $display=get_post_meta($url,'show-in-menu',false);
                if(sizeof($display))
                {
                    $display=$display[0];
                }

            }
            else{
                switch ($url){
                    case "intro":
                        $display=px_opt('intro-display');
                        break;
                    case "skill":
                        $display=px_opt('skill-display');
                        break;
                    case "experience":
                        $display=px_opt('experience-display');
                        break;
                    case "portfolio":
                        $display=px_opt('portfolio-display');
                        break;
                    case "education":
                        $display=px_opt('education-display');
                        break;
                    case "testimonial":
                        $display=px_opt('testimonial-display');
                        break;
                }
            }
        }
        $style=$display?"":"display:none";


		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $object->classes ) ? array() : (array) $object->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
        $class_names = ' class="'. esc_attr( $class_names ) . '"';


        $output .= $indent . '<li style="'.$style.'" id="'. $this->navIdPrefix . $object->ID . '"' . $class_names .'>';

        $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
        $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
        $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
        $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';
        $description = ! empty( $object->description ) ? '<span class="menu-item-description">'.esc_attr( $object->description ).'</span>' : '';


        if($depth != 0)
        {
            $description = $prepend = '';
        }

        //If navigation location is empty $args will be an array
        if(is_array($args))
        {
            //Quick fix on getting a url for link element
            $attributes .= ! empty( $object->guid )  ? ' href="' . esc_attr( $object->guid ) .'"' : '';

            $item_output  = $args['before'];
			if(in_array($object->object_id,$this->menu_pages)){
				$attributes .= ' menu="open"';
			}
			$item_output .= '<a'. $attributes . '>';
            if($depth != 0)
			{
				$item_output .= $args['link_before'] . apply_filters( 'the_title', $object->post_title, $object->ID );
			}else{
				$item_output .= '<span class="title">'.$args['link_before'] . apply_filters( 'the_title', $object->post_title, $object->ID ).'</span>';
			}
			$item_output .= '<span class="title">'.$args['link_before'] . apply_filters( 'the_title', $object->post_title, $object->ID ).'</span>';
            $item_output .= $description . $args['link_after'];
            $item_output .= '</a>';
            $item_output .= $args['after'];
        }
        elseif (is_object($args))
        {

            $item_output  = $args->before;




            if(is_array($this->menu_pages)){
                if(in_array($object->object_id,$this->menu_pages)){
                    $attributes .= ' menu="open"';
                }
            }
			$item_output .= '<a'. $attributes .'>';
            if($depth != 0)
			{
				$item_output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID );

			}else{
                if((strpos($object->classes[0],'contactitem')>=0)&& $object->classes[0]!=''){

                    $item_output .= '<div class="icon-layers3 icon"></div><span class="menu-item-title">'.$args->link_before . apply_filters( 'the_title', $object->title, $object->ID ).'</span>';
                }else{
                    $item_output .= '<span class="menu-item-title">'.$args->link_before . apply_filters( 'the_title', $object->title, $object->ID ).'</span>';
                }
			}
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;



        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );

        }

    }
}


class PxMobileNavWalker extends Walker_Nav_Menu
{
    private $navIdPrefix = '';
    private $menu_pages = '';

    public function __construct($idPrefix='menu-item-')
    {
        $this->navIdPrefix = $idPrefix;
    }

    function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $object->classes ) ? array() : (array) $object->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
        $class_names = ' class="'. esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="'. $this->navIdPrefix . $object->ID . '"' . $class_names .'>';

        $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
        $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
        $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
        $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';
        $description = ! empty( $object->description ) ? '<span class="menu-item-description">'.esc_attr( $object->description ).'</span>' : '';


        if($depth != 0)
        {
            $description = $prepend = '';
        }

        //If navigation location is empty $args will be an array
        if(is_array($args))
        {
            //Quick fix on getting a url for link element
            $attributes .= ! empty( $object->guid )  ? ' href="' . esc_attr( $object->guid ) .'"' : '';

            $item_output  = $args['before'];
            if(in_array($object->object_id,$this->menu_pages)){
                $attributes .= ' menu="open"';
            }
            $item_output .= '<a'. $attributes . '>';
            if($depth != 0)
            {
                $item_output .= $args['link_before'] . apply_filters( 'the_title', $object->post_title, $object->ID );
            }else{
                $item_output .= '<span class="title">'.$args['link_before'] . apply_filters( 'the_title', $object->post_title, $object->ID ).'</span>';
            }
            $item_output .= '<span class="title">'.$args['link_before'] . apply_filters( 'the_title', $object->post_title, $object->ID ).'</span>';
            $item_output .= $description . $args['link_after'];
            $item_output .= '</a>';
            $item_output .= $args['after'];
        }
        elseif (is_object($args))
        {
            $item_output  = $args->before;
            if(is_array($this->menu_pages)){
                if(in_array($object->object_id,$this->menu_pages)){
                    $attributes .= ' menu="open"';
                }
            }
            $item_output .= '<a'. $attributes .'>';
            if($depth != 0)
            {
                $item_output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID );
            }else{
                if($object->object == 'contact'){
                    $item_output .= '<span class="icon-layers3 icon"></span>&nbsp;<span class="menu-item-title">'.$args->link_before . apply_filters( 'the_title', $object->title, $object->ID ).'</span>';
                }else{
                    $item_output .= '<span class="icon icon-arrow-right4"></span>';
                    $item_output .= '<span class="menu-item-title">'.$args->link_before . apply_filters( 'the_title', $object->title, $object->ID ).'</span>';
                }
            }
//            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
        }


        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );
    }
}