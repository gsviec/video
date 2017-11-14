<?php

namespace Phanbook\Seeder;

use Faker\Factory as Faker;
use Phalcon\Logger\Adapter\Stream;
use Phanbook\Models\Channels;

/**
 *
 */
class ChannelsSeeder extends Seeder
{
    public static function run()
    {
        //Truncate table before seeder data
        static::truncate('Channels');
        static::create();
    }
    public static function create()
    {
        $faker = Faker::create();
        $log   = new Stream('php://stdout');

        $log->info('Start ' . __CLASS__);
        /** @var Phalcon\Db\AdapterInterface $database */
        $database = self::getConnection();
        //$userIds     = Users::find(['columns' => 'id'])->toArray();
        $database->begin();
        for ($i = 0; $i <= self::CHANNELS_TOTAL; $i++) {

            $title       = $faker->company;
            $channels = new Channels();
            $channels->usersId = $i;
            $channels->uniqid = uniqid(true);
            $channels->name = $title;
            $channels->slug = \Phalcon\Tag::friendlyTitle($title);
            $channels->description = $faker->text;


            if (!$channels->save()) {
                var_dump($channels->getMessages());
                $channels->rollback();
                die;
            }

            $log->info('channels: ' . $channels->name);
        }
        $database->commit();
    }
}
