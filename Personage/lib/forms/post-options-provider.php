<?php

require_once('ivalueprovider.php');

class PxPostOptionsProvider implements IValueProvider {

    public function Px_GetValue($key)
    {
        global $post;
        return get_post_meta( $post->ID, $key, true );
    }
}