<?php

/**
 * Date Class
 * 
 * @author      Indra Daud
 * @package     resources
 */

namespace Landingo\Resources;

class Date
{
    public static $_segments = array('length' => null, 'limiter' => ' ');

    public static function set(array $segment)
    {
       foreach ($segment as $key => $value) 
       {
           if(!array_key_exists($key, self::$_segments))
           {
                continue;
           }

           self::$_segments[$key] = $value;
       }
    }

    public static function convert($date)
    {
        $time = explode('-', date('D-d-M-Y',$date));

        $result['hari'] = self::getDay($time[0]) . ',';
        $result['tanggal'] = $time[1];
        $result['bulan'] = self::getMonth($time[2]);
        $result['tahun'] = $time[3];

        return implode(self::$_segments['limiter'], $result);
    }

    public static function getDay($prefix)
    {
        switch ($prefix) {

          case 'Sun':
            $day = 'Minggu';
          break;
          case 'Mon':
            $day = 'Senin';
          break;
          case 'Tue':
            $day = 'Selasa';
          break;
          case 'Wed':
            $day = 'Rabu';
          break;
          case 'Thu':
            $day = 'Kamis';
          break;
          case 'Fri':
            $day = 'Jum\'at';
          break;
          case 'Sat':
            $day = 'Sabtu';
          break;

        }

        return $day;
    }

    public static function getMonth($prefix)
    {
    switch ($prefix) 
    {
          case 'Jan':
            $month = 'Januari';
          break;
          case 'Feb':
            $month = 'February';
          break;
          case 'Mar':
            $month = 'Maret';
          break;
          case 'April':
            $month = 'April';
          break;
          case 'May':
            $month = 'Mei';
          break;
          case 'Jun':
            $month = 'Juni';
          break;
          case 'Jul':
            $month = 'Juli';
          break;
          case 'Aug':
            $month = 'Agustus';
          break;
          case 'Sep':
            $month = 'September';
          break;
          case 'Oct':
            $month = 'Oktober';
          break;
          case 'Nov':
            $month = 'November';
          break;
          case 'Dec':
            $month = 'Desember';
          break;
        }
        if(self::$_segments['length']){
          $month = substr($month, 0, self::$_segments['length']);
        }

        return $month;

    }
}