<?php

namespace Landingo\Resources;

class Uri
{
    private static $_component = array();

    public static function get()
    {
        $request = self::getRequest();

        $result = array();

        if(isset($request[0]))
        {
            $result['module'] = $request[0];
            unset($request[0]);
        }

        if(isset($request[1]))
        {
            $result['page'] = $request[1];
            unset($request[1]);
        }

        if(isset($request[2]))
        {
            $result['act'] = $request[2];
            unset($request[2]);
        }

        $result['params'] = array_values($request);

        return $result;
    }

    public static function getRequest()
    {
        if(!isset($_SERVER['PATH_INFO']))
        {
            return array();
        }

        $prefix = explode('/', filter_var(rtrim($_SERVER['PATH_INFO'], '/'), FILTER_SANITIZE_URL));

        $result = array();

        foreach ($prefix as $key => $value) {
            
            if($value === '')
                continue;

            $result[] = $value;
        }

        return $result;
    }
}