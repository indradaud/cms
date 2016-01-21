<?php

namespace Landingo\Resources;

class Auth
{
    private static $data = array();
    private static $result = false;
    private static $_default = null;

    public static function isNot($session)
    {
        foreach ($session as $key => $value) 
        {
            if(isset($_SESSION["$key"]) && $_SESSION["$key"] === $value)
            {
                self::$data[] = 1;   
            }
            else
            {
                self::$data = array();
            }
        }

        $thisClass = __CLASS__;

        return new $thisClass();
    }

    public function cek()
    {
        $result = true;

        if(!self::$data)
        {
            $result = false;
        }

        return $result;
    }

    public function redirect($mode)
    {
        if(!self::$data)
        {
            $conf = new Config();
            $base_url = $conf->get('app.base_url');
            $conf->close();

            switch ($mode) 
            {
                case 'login':
                    header('location:' . $base_url .'/login.php');
                    break;

                case 500:
                    echo 'You dont have access on this page !';
                    break;
                
            }           
        }
    }
}