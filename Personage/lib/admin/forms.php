<?php

include_once('admin-form.php');

$form = new PxAdminForm();
?>

<div class="px-container theme-settings">
    <input type="hidden" name="action" value="theme_save_options" />
    <div id="px-wrap">
        <?php echo $form->Px_GetHeader(); ?>
        <div class="theme-settings-body clear-after">
            <?php echo $form->Px_GetBody(); ?>
        </div>
    </div>
</div>