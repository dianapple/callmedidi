<?php
$name        = $vars['key'];
$settings    = $vars['settings'];
$value       = $vars['val'];
$class       = px_array_value('class', $settings);
$title       = px_array_value('title', $settings, __('Upload Image', TEXTDOMAIN));
$referer     = px_array_value('referer', $settings);
$placeholder = px_array_value('placeholder', $settings);
$label       = px_array_value('label', $settings);//Optional value
?>
<div class="field upload-field clear-after <?php echo $class; ?>" data-title="<?php echo $title; ?>" data-referer="<?php echo $referer; ?>" >

    <?php if($label != ''){ ?>
        <label for="field-<?php echo $name; ?>"><?php echo $label; ?></label>
    <?php } ?>

    <input id="<?php echo $referer; ?>" type="text" name="<?php echo $name; ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo $placeholder; ?>" />
    <a data-referer="<?php echo $referer; ?>" href="#" class="upload-button"><?php _e('Browse', TEXTDOMAIN); ?></a>
</div>