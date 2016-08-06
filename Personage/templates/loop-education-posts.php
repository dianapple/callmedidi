<?php
//Build post query
$queryArgs = array(
	'post_type'      => 'education',
	'posts_per_page' => -1
);

$query = new WP_Query($queryArgs);

if ( $query->have_posts() ){
	while ($query->have_posts()) { 
		
		$query->the_post();
		$id = get_the_ID();
		$title = get_post_meta($id, 'education-item-title', true);
		$duration = get_post_meta($id, 'education-item-duration', true);
		$description = get_post_meta($id, 'education-item-description', true);
		$icon = get_post_meta($id, 'education-item-icon', true);
		?>

        <div class="education-part clearfix">
            <div class="content">
                <div class="title col-md-3 col-sm-4">
                    <div>
                        <div class="years"><?php echo $duration ?></div>
                    </div>
                    <div>
                        <h3><?php echo $title ?></h3>
                    </div>
                </div>
                <div class="description col-md-9 col-sm-8">
                    <span class="icon-<?php echo $icon ?> icon"></span>
                    <p class="text"><?php echo $description ?></p>
                </div>
            </div>
            <div class="underline-box"></div>
        </div>

<?php }}
wp_reset_query();
?>