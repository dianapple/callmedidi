<?php
$name        = $vars['key'];
$settings    = $vars['settings'];
$class       = px_array_value('class', $settings);//Optional value
$label       = px_array_value('label', $settings);//Optional value
$placeholder = px_array_value('placeholder', $settings);//Optional value
$value       = ( ( esc_attr( $this->Px_GetValue($name) ) == "") && (px_array_value('value', $settings) != "") ) ? px_array_value('value', $settings) : esc_attr( $this->Px_GetValue($name) );

?>

<div class="field color-field clear-after <?php echo $class; ?>">
    <div class="label"><?php echo $label; ?></div>
    <div class="color-field-wrap clear-after">
        <input name="<?php echo $name; ?>" type="text" value="<?php echo $value ; ?>" class="colorinput" placeholder="<?php echo $placeholder; ?>" />
		<div class="color-view"></div>
	</div>
</div>