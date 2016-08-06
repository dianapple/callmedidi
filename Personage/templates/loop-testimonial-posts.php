<?php
//Build post query
$queryArgs = array(
	'post_type'      => 'testimonial',
	'posts_per_page' => -1
);

$query = new WP_Query($queryArgs);
?>
	<ul class="slides">
<?php
if ( $query->have_posts() ){
	while ($query->have_posts()) { 
		
		$query->the_post();
		$id = get_the_ID();
        $image = get_post_meta($id, 'testimonial-item-image', true);
		$title = get_post_meta($id, 'testimonial-item-title', true);
		$subtitle = get_post_meta($id, 'testimonial-item-subtitle', true);
		$description = get_post_meta($id, 'testimonial-item-description', true);
		?>


			<li>
				<p class="text"><?php echo $description ?></p>
				<span class="talker"><?php echo $title ?> / <?php echo $subtitle ?></span>
			</li>


<?php }}
?>
	</ul>
<?php
wp_reset_query();
?>