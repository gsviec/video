<?php
namespace Phanbook\Tools;

class ShortId
{

    public static function encode($id)
    {
        $hashids = new \Hashids\Hashids('this is my salt');
        return $hashids->encode($id);
    }

    public static function decode($string)
    {
        $hashids = new \Hashids\Hashids('this is my salt');
        return $hashids->decode($string)[0];
    }

}
