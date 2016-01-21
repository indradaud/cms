<?php

namespace Landingo\Resources;

class Autoload
{

    public function register()
    {
        spl_autoload_register(array($this, 'loader'));
    }

    public function loader($class)
    {
        $class_dir = dirname(__FILE__) . '/';
        $vendor = 'Landingo\\Resources\\';
        $len = strlen($vendor);

        if(strncmp($vendor, $class, $len) !== 0)
        {
            return;
        }

        $relative_class = substr($class, $len);
        $file = $class_dir . str_replace('\\', '/', $relative_class) . '.php';

        if(!file_exists($file))
        {
            die("Class <i>{$relative_class}</i> not found !");
        }
        
        require $file;
    }
}