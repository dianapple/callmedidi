<?php
/**
 * Archive template
 */

$sidebarPos   = px_opt('sidebar-position');
$sidebar = "Main Sidebar";
$class = "border-left";

get_header();
$title = __('My Blog Posts', TEXTDOMAIN);
?>
    <!--Content-->
    <div id="archive" class="container">
        <div class="clearfix" page-type="archive">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="page-title"><?php echo $title ; ?></h1>
                    <div class="archive">
                        <?php get_template_part( 'templates/loop', 'blog' );
                        if(USE_CUSTOM_PAGINATION)
							px_get_pagination();
						else
							paginate_links();
						?>
                    </div>
                </div>
                <div class="col-md-3"><?php px_get_sidebar($sidebar,$class); ?></div>
            </div>
		</div>
        <?php
        if(px_contactInMenu()){
            get_template_part('templates/section','contact');
        }
        ?>
    </div>
<?php get_footer(); ?>