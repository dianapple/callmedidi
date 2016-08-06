<?php
$name     = $vars['key'];
$settings = $vars['settings'];
$class    = px_array_value('class', $settings);//Optional value
$checked = px_array_value('checked', $settings);//Optional value
$label    = px_array_value('label', $settings);//Optional value
$value       = ( ( esc_attr( $this->Px_GetValue($name) ) == "") && (px_array_value('value', $settings) != "") ) ? px_array_value('value', $settings) : esc_attr( $this->Px_GetValue($name) );
$value      = strlen($value) ? $value : '1';
$current_value = ($class == 'text admin' || $class == 'background-image-type')?( ( esc_attr( $this->Px_GetValue($name) ) == "") && (px_array_value('value', $settings) != "") ) ? px_array_value('value', $settings) : esc_attr( $this->Px_GetValue($name) ):get_post_meta(get_the_ID(), $name, true);
?>
<div class="field checkbox-input <?php echo $class; ?>">
    <?php if($label != ''){ ?>
        <label for="field-<?php echo $name; ?>"><?php echo $label; ?></label>
    <?php } ?>
    <input type="checkbox" id="field-<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php echo ($current_value != '')?'checked="checked"':''; ?> />
</div>
<?php if (strpos ($class,'related')!== false){ ?>
    <div class="clearfix"></div>
<?php }