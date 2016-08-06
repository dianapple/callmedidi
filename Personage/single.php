<?php
/**
 * Template for displaying all single posts.
 */

get_header();

?>
    <!--Content-->
    <div id="main-content" class="main-content container container-vspace single-post" page-type="single">

    <?php while ( have_posts() ) { the_post();?>

        <?php get_template_part( 'templates/single', get_post_type() ); ?>

    <?php } // end of the loop. ?>

    </div>


<?php get_footer(); ?>