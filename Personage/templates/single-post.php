<?php

   $sidebar = px_opt('single-sidebar');

?>
<div class="row">
    <div class="col-md-9">
        <?php
        $format = get_post_format();

        if ( false === $format )
            $format = 'standard';

        get_template_part( 'templates/single', "post-$format" );

        if(px_contactInMenu()){
            get_template_part('templates/section','contact');
        }
        ?>
    </div>
    <div class="col-md-3">
        <?php px_get_sidebar($sidebar); ?>
    </div>
</div>

