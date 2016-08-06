<?php
$name     = $vars['key'];
$settings = $vars['settings'];
$class    = px_array_value('class', $settings);//Optional value
$label    = px_array_value('label', $settings);//Optional value
$min      = px_array_value('min', $settings, 1);//Optional value
$max      = px_array_value('max', $settings, 100);//Optional value
$step     = px_array_value('step', $settings, 1);//Optional value
?>

<div class="field clear-after <?php echo $class; ?>">
    <div class="label"><?php echo $label; ?></div>
    <input name="<?php echo $name; ?>" type="range" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>"  value="<?php echo esc_attr( $this->Px_GetValue($name) ); ?>" />
</div>