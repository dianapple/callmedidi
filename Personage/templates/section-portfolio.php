<?php
/**
 * Portfolio Section
 */
//Build post query
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$postNum = px_opt('portfolio-num');
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$queryArgs = array(
    'post_type'      => 'portfolio',
    'posts_per_page' => $postNum,
    'paged'          => $paged
);
$query = new WP_Query($queryArgs);
$pmax = $query->max_num_pages;
$count_posts = wp_count_posts( 'portfolio' )->publish;
$class = (px_opt('animation')== "1")?'animation' : "";
require_once(THEME_LIB . '/portfolio-walker.php');
?>
    <section id="portfolio" class="container-fluid <?php echo $class ?>">
        <?php if(px_opt('portfolio-header') == '1'){ ?>
        <div class="container">
            <div class="row">
                <div class="portfolio-header-container col-md-9 col-sm-6 col-xs-6">
                    <?php if (px_opt('portfolio')){ ?>
                        <h2 class="portfolio-header"><?php echo px_opt('portfolio')?></h2>
                        <div class="underline-box"></div>
                    <?php } ?>
                </div>
                <div class="portfolio-filter-container col-md-3 col-sm-6 col-xs-6">
                    <?php get_template_part('templates/loop-portfolio','category');?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="portfolio-container">
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                $terms = get_the_terms( get_the_ID(), 'skills' );
                $pid = 0;
                $pid = (is_page())?get_the_ID():$pid;
                if(0 != $pid){
                    $permalink = add_query_arg( 'pnt', $pid, get_permalink() );
                } else {
                    $permalink = get_permalink();
                }
                ?>
                <article class="portfolio-item <?php if($terms) { foreach ($terms as $term) { echo "term-$term->term_id "; } } ?>">
                    <a href="<?php the_permalink(); ?>" class="portfolio-image-link ajax-popup-link">
                        <div class="photo">
                            <div class="overly"></div>
                            <span class="plus hor"></span>
                            <span class="plus ver"></span>
                            <?php
                            $thumbSize = "full";
                            $attachments = get_posts( $queryArgs );
                            $thumbId= get_post_thumbnail_id( get_the_ID() );
                            $image_attributes = wp_get_attachment_image_src( $thumbId , $thumbSize );
                            if ( $thumbId != ""  ) { ?>
                                <img src="<?php echo $image_attributes[0] ;?>">
                            <?php } ?>
                        </div>
                        <div class="description">
                            <h3 class="title"><?php the_title(); ?></h3>
                            <?php
                            $terms = px_implode_post_terms('skills');
                            if($terms != null && strlen($terms)) { ?>
                                <span class="category"><?php echo $terms; ?></span>
                            <?php } ?>
                        </div>
                    </a>
                </article>
            <?php } ?>
        </div>
        <?php if($count_posts>$postNum){ ?>
        <div class="container portfolio-loadmore">
            <div class="row">
                <div class="portfolio-pagination container">
                    <?php
                    if(USE_CUSTOM_PAGINATION)
                        px_get_pagination($query);
                    else
                        paginate_links($query);
                    ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </section>
<?php
wp_reset_query();
$queryArgs = array (
    'post_type'      => 'portfolio',
    'posts_per_page' =>  px_opt('portfolio-num'),
);

$query = new WP_Query($queryArgs);
$ppaged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
$pmax = $query->max_num_pages;
$count_posts = wp_count_posts( 'portfolio' )->publish;
$ppostperpage = px_opt('portfolio-num') ;
$maxPages =  ceil ($count_posts / $ppostperpage)  ;

wp_localize_script (
    'mainjs',
    'portfolio_data',
    array (
        'startPage' => $ppaged,
        'maxPages' => $maxPages,
        'nextLink' => next_posts($pmax, false),
        'loadingText' => __('Loading...', TEXTDOMAIN),
        'loadMoreText' => __('Load More', TEXTDOMAIN),
        'noMorePostsText' => __('No More Posts', TEXTDOMAIN)
    )
);