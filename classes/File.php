<?php

namespace Landingo\Resources;

class File
{

    public static $filename = 'default.png';

    public function upload($dir, array $dataset)
    {
        $directory = $_SERVER['DOCUMENT_ROOT'] . '/' . $dir;

        $chk = self::verify($dataset['type'],$dataset['error'], $dataset['size']);

        if($chk)
        {
            $file = time() . "_{$dataset['name']}";
            $run = move_uploaded_file($dataset['tmp_name'], $directory . '/' . $file);
            
            if($run)
            {
                self::$filename = $file;
            }
        }
    }

    public function delete($dir, $filename)
    {
        if($filename !== 'default.png')
        {
            $filename = $_SERVER['DOCUMENT_ROOT'] . '/' . $dir . '/' . $filename;
            unlink($filename);
        }
    }

    private function verify($type, $error, $size)
    {
        $result = false;

        $mime_type = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');

        if($error < 1 && $size < 1828311 && in_array($type, $mime_type))
        {
            $result = true;
        }

        return $result;
    }
}