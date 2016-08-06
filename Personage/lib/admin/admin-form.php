<?php

require_once(THEME_LIB . '/forms/fieldtemplate.php');
require_once(THEME_LIB . '/forms/theme-options-provider.php');

class PxAdminForm extends PxFieldTemplate
{
    protected $template = array();

    function __construct()
    {
        $this->template = px_admin_get_form_settings();
        parent::__construct(new PxThemeOptionsProvider(), THEME_LIB . '/forms/templates');
    }

    public function Px_GetHeader()
    {
        return $this->Px_GetTemplate('admin-header');
    }

    public function Px_GetBody()
    {
        return $this->Px_GetTemplate('admin-sidebar') .
               $this->Px_GetTemplate('admin-panels');
    }

    public function Px_GetImage($filename, $alt='', $class='')
    {
        return $this->Px_GetTemplate('image', array('filename'=>$filename, 'alt'=>$alt, 'class'=>$class));
    }
}