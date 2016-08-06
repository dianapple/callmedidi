<?php
/**
 * Search template
 */

get_header();

$pageHeading = have_posts() ? sprintf(__("RESULT <br/> FOR '%s'", TEXTDOMAIN), strtoupper($s)) : __('No Results Found', TEXTDOMAIN);
$sidebar = "Main Sidebar";
$class = "border-left";
$title = __("Search", TEXTDOMAIN);
global $wp_query;
if(!empty($wp_query->found_posts) && $wp_query->found_posts > 0)
{
	$title = $wp_query->found_posts . __(" Results found for", TEXTDOMAIN) . " '". get_search_query() . "'";
}
?>
    <div id="search" class="container">
        <div class="row">
            <div class="col-md-9">
                <h2 class="search-title"><?php echo $pageHeading; ?></h2>
                <hr class="search-separator" />
                <div class="search-box">
                    <div class="search-form">
                        <form action="#">
                            <fieldset>
                                <input type="text" name="s" placeholder="" data-defaultValue="<?php _e('Search something ...', TEXTDOMAIN);?>" value="">
                                <input type="submit" value="">
                            </fieldset>
                        </form>
                        <div class="cursor" onselectstart="return false;"></div>
                    </div>
                    <div class="search-result"><?php echo $title ?></div>
                </div>
                <?php get_template_part( 'templates/loop', 'search' );
                px_get_pagination();
                ?>
            </div>
            <div class="col-md-3"><?php px_get_sidebar($sidebar,$class); ?></div>
        </div>
        <?php
        if(px_contactInMenu()){
            get_template_part('templates/section','contact');
        }
        ?>
    </div>

<?php get_footer(); ?>