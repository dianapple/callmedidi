<?php
//Build post query

$queryArgs = array(
	'post_type'      => 'skill',
	'posts_per_page' => -1
);

$query = new WP_Query($queryArgs);

if ( $query->have_posts() ){
	while ($query->have_posts()) { 
		
		$query->the_post();
		$id = get_the_ID();
		$title = get_post_meta($id, 'skill-item-title', true);
		$percent = get_post_meta($id, 'skill-item-percent', true);
        $sColor =  get_post_meta($id,'skill-start-color',true);
        $eColor =  get_post_meta($id,'skill-end-color',true);
        $color = array('sColor' => $sColor, 'eColor' => $eColor);
        if($percent > 100){
            $percent = 100;
        } elseif($percent < 0){
            $percent = 0;
        }


        ?>
    <div class="skill-chart-container col-md-3 col-sm-4 col-xs-4">
        <div class="skill-chart">
              <span class="chart-container" data-percent="100"  sColor="<?php echo $sColor;?>" eColor="<?php echo $eColor;?>">
              </span>
              <span class="chart" data-percent="<?php echo $percent; ?>"  sColor="<?php echo $sColor;?>" eColor="<?php echo $eColor;?>">
                  <div class="chart-text-container">
                      <span class="percent"></span>
                      <span class="experience"><?php echo $title; ?></span>
                  </div>
              </span>
        </div>
    </div>

<?php
    }
}
wp_reset_query();
?>