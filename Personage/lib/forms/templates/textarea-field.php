<?php
$name     = $vars['key'];
$settings = $vars['settings'];
$class    = px_array_value('class', $settings);//Optional value
$label    = px_array_value('label', $settings);//Optional value
$placeholder = px_array_value('placeholder', $settings);//Optional value
?>

<div class="field textarea-input <?php echo $class; ?>">
    <?php if($label != ''){ ?>
        <label for="field-<?php echo $name; ?>"><?php echo $label; ?></label>
    <?php } ?>
    <textarea name="<?php echo $name; ?>" cols="30" rows="10" placeholder="<?php echo $placeholder; ?>" ><?php echo esc_textarea($this->Px_GetValue($name)); ?></textarea>
</div>