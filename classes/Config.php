<?php

namespace Landingo\Resources;

class Config
{
    private $data = array();
    private $default = null;

    public function __construct()
    {
        $this->data = require dirname(__DIR__) . '/config/default.php';
    }

    public function get($key)
    {
        $segments = explode('.', $key);

        $data = $this->data;

        foreach ($segments as $segment) 
        {
            if(isset($data[$segment]))
            {
                $data = $data[$segment];
            }
            else
            {
                $data = $this->default;
                break;
            }
        }

        return $data;
    }

    public function close()
    {
        $this->data = array();
    }
}