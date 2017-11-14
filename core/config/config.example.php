<?php
/**
 * The base configuration for Phanbook
 *
 * The config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Application
 * * Languages
 * * Token google,github,facebook
 * * Mail
 *
 * @link https://github.com/phanbook/docs/config.md
 *
 * @package Phanbook
 */
use Phalcon\Session\Adapter\Redis;

return new \Phalcon\Config(
    [
        /**
         * The name of the database, username,password for Phanbook
         */
        'database'  => [
            'mysql'     => [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'phanbook',
                'dbname'   => 'gsviec_video',
                'charset'  => 'utf8',
            ],
            'mysql1'     => [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'phanbook',
                'dbname'   => 'lackky_dev',
                'charset'  => 'utf8',
            ],
        ],

        /**
         * Application settings
         */
        'application' => [
            /**
             * The site name, you should change it to your name website
             */
            'name'                => 'Phanbook',
            'httpStatusCode'      => 200, // 503
            'modelsDir'           => app_path('core/models/'),
            'baseUri'             => '/',
            'view' => [
                'viewsDir'          => app_path('views/'),
                'compiledPath'      => var_path('cache/volt/'),
                'compiledSeparator' => '_',
                'compiledExtension' => '.php',
                'paginator'         => [
                    'limit'             => 10,
                ],
            ],
            'repo'                => 'https://github.com/phanbook',

            'timezone'            => 'UTC',
            /**
             * In a few words, explain what this site is about.
             */
            'tagline'             => 'A Q&A, Discussion PHP platform',

            'publicUrl'           => 'http://video.gsviec.com/',
            /**
             * Change URL cdn if you want it
             */
            'staticBaseUri' => '/',
            /**
             * For developers: Phanbook debugging mode.
             *
             * Change this to true to enable the display of notices during development.
             * It is strongly recommended that plugin and theme developers use
             * in their development environments.
             */
            'debug'               => true,

            /**
             * The length password hash send to you when you forget password
             * you can change it
             */
            'passwdResetInterval' => 10,
            /**
             * You can see from
             *
             * @link https://docs.phalconphp.com/en/latest/reference/logging.html
             */
            'logger'              => [
                'enabled' => true,
                'path'    => 'log/',
                'format'  => '[%date %][%type %] %message % ',
            ],
            /**
             * Authentication Unique Keys and Salts. Change these to different unique key!
             *
             * @link https://docs.phalconphp.com/en/latest/api/Phalcon_Security.html
             */
            'cryptSalt'           => '92*)(@#9834$#3rt',
            /**
             * Time life cookie default is 8 day, you can change anything day
             *
             * @link https://docs.phalconphp.com/en/latest/reference/cookies.html
             */
            'cookieLifetime'      => 86400 * 8,
            /**
             * Improving Performance with Cache
             *
             * @link https://docs.phalconphp.com/en/latest/reference/cache.html
             */
            'cache'               => [
                'lifetime' => '86400',
                'prefix'   => 'cache_',
                'adapter'  => 'File',
                'cacheDir' => var_path('cache/html/'),
            ],
            'session'             => [
                'adapter' => Redis::class,
                'options' => [
                    'uniqueId' => 'video_gsviec_',
                    'host' => 'localhost',
                    'port' => 6379,
                    //'auth' => 'foobared',
                    'persistent' => true,
                    'lifetime' => 120000000,
                    'prefix' => 'gsviec_',
                    'index'  => 10
                ]
            ]
        ],

        'models' => [
            'metadata' => [ 'adapter' => 'Memory' ]
        ],

        /**
         * You need to change mail parameters below
         *
         * @link http://github.com/phanbook/docs/mail.md
         */
        'mail'        => [
            'templatesDir' => 'mail/',
            'fromName'     => 'Phanbook',
            'fromEmail'    => 'phanbook@no-reply',
            'smtp'         => [
                'server'   => 'smtp.sendgrid.com',
                'port'     => '587',
                'security' => 'tls',
                'username' => '',
                'password' => '@',
            ]
        ],
        /**
         * Your client ID and client secret keys come from
         *
         * @link https://github.com/settings/applications/new
         */
        'github'      => [
            'clientId'     => '7c3724d3a593eff3ebef',
            'clientSecret' => '0dede75fd2351242e51c69b4aa50ce130862ef05',
            'redirectUri'  => 'http://dev.phanbook.com/oauth/github/access_token',
            'scopes'       => ['user', 'email']
        ],

        /**
         * Your client ID and client secret keys come from
         *
         * @link https://developers.facebook.com/
         */
        'facebook' => [
            'clientId' => '375822529287502',
            'clientSecret' => 'b1f658bee406b846cd82f9cec3558662',
            'graphApiVersion' => 'v2.10',
            'redirectUri'  =>'http://dev.phanbook.com/oauth/facebook/access_token'
        ],

        /**
         * Set languages you want to it, you can see example
         *
         * @link http://github.com/phanbook/docs/lanuage.md
         */
        'language' => [
            'code' => 'vi',
            'gettext' => false
        ],

        /**
         * The parameter you get form
         *
         * @link http://www.google.com/analytics/
         */
        'google' => [
            'analytic' => 'xxxx',
            'apiKey' => 'AIzaSyDw2qKJiRMhCLifNi0PT60_MCXYhfUzPi0',
            'clientId' => '',
        ],
        'disqus' => [
            'id' => 'lackky-dev-site',
            'keyId' => '',
            'keySecret' => '',
        ],
        /**
         * The Elasticsearch parameters. You can change it or not
         *
         * @link https://www.elastic.co/blog/what-is-an-elasticsearch-index
         */
        'elasticsearch' => [
            'index' => 'lackky_video',
            'typeSearch'  => 'posts'
        ],

        'resque' => [
            'REDIS_BACKEND'     => 'localhost:6379',    // Set Redis Backend Info
            'REDIS_BACKEND_DB'  => '0',                 // Use Redis DB 0
            'COUNT'             => '1',                 // Run 1 worker
            'INTERVAL'          => '5',                 // Run every 5 seconds
            'QUEUE'             => '*',                 // Look in all queues
            'PREFIX'            => '__lackky_',         // Prefix queues with test
            'VVERBOSE'          => '1',
            'APP_INCLUDE'       => 'cli'
        ],
        'amazon' => [
             's3' => [
                 'key' => 'xx',
                 'secret' => 'xx',
                 'region'=>'us-east-1', //'ap-northeast-1',
                 'bucket' => 'video.youtube'
             ],
            'cloudFront' => [
                'url' => 'http://d9a4mhyi961pk.cloudfront.net',
                'keyId' => 'APKAJJVYWXGI7I2GYH2A', //cloudfront key pair id
                'secret' => var_path('key/pk-x.pem')
            ]
        ],
    ]
);
