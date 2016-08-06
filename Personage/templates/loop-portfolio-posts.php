<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mojde
 * Date: 28/10/13
 * Time: 08:09
 * To change this template use File | Settings | File Templates.
 */
$pid = 0;
if(is_page())
    $pid = get_the_ID();


//Build post query
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$portfolioPosts = ( px_get_meta('portfolio-posts')=="")?5 :px_get_meta('portfolio-posts');

 $queryArgs = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => $portfolioPosts,
        'paged'          => $paged
 );

$activeCat ="";

$query = new WP_Query($queryArgs);

while ($query->have_posts()) { $query->the_post();
    $terms = get_the_terms( get_the_ID(), 'skills' );


    if(0 != $pid)
        $permalink = esc_url(add_query_arg( 'pnt', $pid, get_permalink() ));
    else
        $permalink = get_permalink();

    ?>

    <div class="item <?php if($terms) { foreach ($terms as $term) { echo "term-$term->term_id "; } } ?>">
        <div class="item-wrap">
            <div class="item-image">
                <?php
                $thumbSize = "portfolio-thumb3-style1";

                if ( function_exists('has_post_thumbnail') && has_post_thumbnail() )
                    the_post_thumbnail($thumbSize);
                ?>
                <div class="item-image-overlay">

                    <div class="overlay-wrapper">
                        <div class="overlay">
                            <h3 class="overlay-title"><a href="<?php the_permalink(); ?>" class="overlay-link ajax-popup-link"><?php the_title(); ?></a></h3>
                            <?php $terms = px_implode_post_terms('skills');
                                  $activeCat .= $terms;

                            if($terms != null && strlen($terms))
                            {
                                ?>
                                <hr/>
                                <div class="overlay-category"><?php echo $terms; ?></div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <a href="<?php echo $permalink; ?>" class="item-image-link"></a>
            </div>
        </div>
    </div>

<?php }
wp_reset_query();
?>