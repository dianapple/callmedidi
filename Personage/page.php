<?php
get_header();
get_template_part('templates/head');

//Get the sidebar option

$class = "border-left";
$sidebarPos = px_opt('sidebar-position');
$sidebar      = px_get_meta('sidebar');

?>
    <!--Content-->
    <div id="main-content" class="main-content container container-vspace" page-type="default">

        <?php
        if($sidebar == 'no-sidebar' ){
            get_template_part('templates/loop-page');

        }
        else{
            $contentClass = 'col-md-8';
            $sidebarClass = 'col-md-4';

            if(1 == $sidebarPos){
                $contentClass .= ' float-right';
                $class = "border-right";

            }
            ?>
            <div class="row">
                <div class="<?php echo $contentClass; ?>">
                    <?php get_template_part('templates/loop-page');
                    ?>
                </div>
                <div class="<?php echo $sidebarClass; ?>"><?php px_get_sidebar($sidebar,$class); ?></div>
            </div>
        <?php } ?>
        <?php
        if(px_contactInMenu()){
            get_template_part('templates/section','contact');
        }
        ?>
    </div>

<?php get_footer(); ?>