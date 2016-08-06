<div class="search-form">
    <form action="<?php echo home_url( '/' ); ?>">
        <fieldset>
            <input type="text" name="s" placeholder="<?php _e('Find', TEXTDOMAIN);?>" data-defaultValue="<?php _e('Search something ...', TEXTDOMAIN);?>" value="">
            <input type="submit" value=">">
        </fieldset>
    </form>
    <div class="cursor" onselectstart="return false;"></div>
</div>
