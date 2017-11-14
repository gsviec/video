<?php

namespace Phanbook\Seeder;
use Phalcon\DI\Injectable;
use Phalcon\DI\FactoryDefault;


/**
 *
 */
class Seeder
{
    const USERS_TOTAL = 20;
    const TAGS_TOTAL  = 30;
    const POSTS_TOTAL = 200;
    const CHANNELS_TOTAL = 50;
    public static function getConnection()
    {
        $di = FactoryDefault::getDefault();

        return $di->get('db');
    }
    public static function truncate($class)
    {
       // $class = static::class;
        $class = '\Phanbook\\Models\\' . $class;
        $object = $class::find();
        return $object->delete();
    }
}
