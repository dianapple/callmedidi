<?php

//Base class for generating html code from
//given template file
class PxTemplate
{
    protected $templatesDir  = 'templates';

    function __construct($templatesDir = '')
    {
        if($templatesDir != '')
            $this->templatesDir = $templatesDir;
    }

    function Px_SetWorkingDirectory($dir)
    {
        $this->templatesDir = $dir;
    }

    function Px_GetTemplate($file, $vars = array())
    {
        ob_start();
        require(px_path_combine($this->templatesDir, $file) . '.php');
        return ob_get_clean();
    }

}