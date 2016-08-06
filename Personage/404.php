<?php
/**
 * 404 (Page not found) template
 */

get_header();
?>
    <section id="404" class="container">
        <div class="page404">
            <div class="row">
                <div class="image"><img src="<?php echo THEME_IMAGES_URI ?>/404.png" alt="404" /></div>
                <div class="content col-md-5">
                    <div class="title"><?php _e('ERROR!', TEXTDOMAIN); ?></div>
                    <hr class="separator" />
                    <p class="subtitle"><?php _e('PAGE NOT FOUND', TEXTDOMAIN); ?></p>
                    <hr class="subtitle-separator" />
                    <div class="search-form">
                        <form action="<?php echo home_url( '/' ); ?>">
                            <fieldset>
                                <input type="text" name="s" placeholder="" data-defaultValue="<?php _e('Search something ...', TEXTDOMAIN);?>" value="">
                                <input type="submit" class="icon-search" value="">
                            </fieldset>
                        </form>
                        <div class="cursor" onselectstart="return false;"></div>
                    </div>
                    <p class="description"><?php _e('Sorry, the page you are looking for is not available. You can use the search box above if you like.', TEXTDOMAIN); ?></p>
                </div>
            </div>
            <?php
            if(px_contactInMenu()){
                get_template_part('templates/section','contact');
            }
            ?>
        </div>
    </section>
<?php get_footer();