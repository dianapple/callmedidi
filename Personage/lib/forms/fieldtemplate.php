<?php
require 'template.php';


class PxFieldTemplate extends PxTemplate {
    /* @var IValueProvider $valueProvider */
    private   $valueProvider = null;

    function __construct(IValueProvider $valueProvider, $templatesDir = '')
    {
        $this->valueProvider = $valueProvider;
        parent::__construct($templatesDir);
    }

    function Px_GetValue($key)
    {
        return $this->valueProvider->Px_GetValue($key);
    }

    public function Px_GetField($key, array $settings, array $vars=null)
    {
        $params = array('key' => $key, 'settings' => $settings);

        if($vars != null)
            $params = array_merge($vars, $params);

        return $this->Px_GetTemplate($settings['type'] . '-field', $params);
    }
}