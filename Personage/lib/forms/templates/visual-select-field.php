<?php
$name     = $vars['key'];
$settings = $vars['settings'];
$selected = $this->Px_GetValue($name);
$options  = $settings['options'];
$class    = px_array_value('class', $settings);
$label    = px_array_value('label', $settings);//Optional value
?>

<div class="field imageSelect <?php echo $class; ?>">
    <?php if($label != ''){ ?>
        <label for="field-<?php echo $name; ?>"><?php echo $label; ?></label>
    <?php } ?>
    <div class="imageHolder">
        <?php
        foreach($options as $key => $value)
        {
            $selectedClass = $value == $selected ? 'selected' : '';
            ?>
            <a href="#" class="<?php echo $key . ' ' . $selectedClass; ?>"><?php echo $value; ?></a>
        <?php
        }
        ?>
    </div>
    <input name="<?php echo $name; ?>" type="text" value="<?php echo $selected; ?>" />
</div>