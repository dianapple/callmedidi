<?php
//Build post query
$queryArgs = array(
	'post_type'      => 'experience',
	'posts_per_page' => -1
);

$query = new WP_Query($queryArgs);

if ( $query->have_posts() ){
	while ($query->have_posts()) { 
		
		$query->the_post();
		$id = get_the_ID();
		$title = get_post_meta($id, 'exp-item-title', true);
		$duration = get_post_meta($id, 'exp-item-duration', true);
		$description = get_post_meta($id, 'exp-item-description', true);
		$icon = get_post_meta($id, 'exp-item-icon', true);
		?>

        <div class="experience-part clearfix">
            <div class="title col-md-3 col-sm-4">
                <div>
                    <h3><?php echo $title ?></h3>
                    <div class="years"><?php echo $duration ?></div>
                </div>
                <div>
                    <div class="underline-box"></div>
                </div>
            </div>
            <div class="description col-md-9 col-sm-8">
                <span class="icon-<?php echo $icon; ?> icon"></span>
                <p class="text"><?php echo $description ?></p>
            </div>
        </div>

<?php }}
wp_reset_query();
?>