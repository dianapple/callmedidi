<?php wp_nonce_field( 'theme-post-meta-form', THEME_NAME_SEO . '_post_nonce' ); ?>

<div class="px-container post-meta">
    <div class="px-main">
        <?php
            $this->Px_SetWorkingDirectory(px_path_combine(THEME_LIB, 'forms/templates'));
            echo $this->Px_GetTemplate('section', $vars);
        ?>
    </div>
</div>
