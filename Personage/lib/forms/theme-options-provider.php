<?php

require_once('ivalueprovider.php');

class PxThemeOptionsProvider implements IValueProvider {
    public function Px_GetValue($key)
    {
        return px_opt($key);
    }
}