<?php

namespace Phanbook\Seeder;

use Faker\Factory as Faker;
use Phalcon\Logger\Adapter\Stream;
use Phanbook\Models\Posts;
use Phanbook\Models\Users;
use Phalcon\Mvc\User\Component;

/**
 *
 */
class PostsSeeder extends Seeder
{
    public static function run()
    {
        //Truncate table before seeder data
        static::truncate('Posts');
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
        $img = 'http://app.phanbook.com/images/hotel/img-1.jpg';
        for ($i = 0; $i <= self::POSTS_TOTAL; $i++) {

            $title       = $faker->company;
            //$userRandId     = array_rand($userIds);
            $posts               = new Posts();
            $posts->usersId      = rand(1,5); //$userIds[$userRandId]['id'];
            $posts->type         = 'video';
            $posts->title        = $title;
            $posts->slug         = \Phalcon\Tag::friendlyTitle($title);
            $posts->setNumberViews(rand(5, 100));
            $posts->setNumberReply(rand(1, 20));
            $posts->categoryId   = 1;
            $posts->setDeleted(0);
            $posts->content      = $faker->text;
            $posts->sticked      = 'N';
            $posts->status       = Posts::PUBLISH_STATUS;
            $posts->locked       = 'N';
            $posts->deleted      = 1;
            $posts->acceptedAnswer = 'N';
            $posts->setTechOrder(Posts::VIDEO_YOUTUBE);
            $posts->duration = '1:33:22';
            $posts->thumbnail = self::getThumbnail();
            $posts->setVideoFilename(self::getVideoFilename());
            //d($posts->toArray());

            if (!$posts->save()) {
                var_dump($posts->getMessages());
                $database->rollback();
                die;
            }

            $log->info('posts: '.$posts->getTitle());
        }
        $database->commit();
    }

    protected static function getThumbnail()
    {
        $ids = ['0BfyV445Xmo', 'DDrcZiZVzHE', '5tnTVgK7cd4', 'BaHMzpoOxWk' ,'UhE2KGTrsCo'];

        $id = rand(0,4);

        return 'http://img.youtube.com/vi/' . $ids[$id] .'/mqdefault.jpg';

    }

    protected static function getVideoFilename()
    {
        $ids = ['0BfyV445Xmo', 'DDrcZiZVzHE', '5tnTVgK7cd4', 'BaHMzpoOxWk' ,'UhE2KGTrsCo'];

        $id = rand(0,4);

        return  $ids[$id];

    }
}
