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
                'host'     => getenv('DB_HOST'),
                'username' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'dbname'   => getenv('DB_NAME'),
                'charset'  => 'utf8',
            ]
        ],

        /**
         * Application settings
         */
        'application' => [
            /**
             * The site name, you should change it to your name website
             */
            'name'                => 'Gsviec',
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
            'tagline'             => 'Video PHP platform',

            'publicUrl'           => 'https://gsviec.com/',
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
            'debug'               => false,

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
                    'host' => getenv('REDIS_HOST'),
                    'port' => 6379,
                    'auth' => getenv('REDIS_PASSWORD'),
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
            'fromName'     => 'Gsviec',
            'fromEmail'    => 'no-reply@gsviec.com',
            'smtp'         => [
                'server'   => 'smtp.sendgrid.com',
                'port'     => '587',
                'security' => 'tls',
                'username' => getenv('MAIL_USERNAME'),
                'password' => getenv('MAIL_PASSWORD'),
            ]
        ],
        /**
         * Your client ID and client secret keys come from
         *
         * @link https://github.com/settings/applications/new
         */
        'github'      => [
            'clientId'     => '502507e5c401c3c85de5',
            'clientSecret' => '',
            'redirectUri'  => 'https://gsviec.com/oauth/github/access_token',
            'scopes'       => ['user', 'email']
        ],

        /**
         * Your client ID and client secret keys come from
         *
         * @link https://developers.facebook.com/
         */
        'facebook' => [
            'clientId' => '1315048085240441',
            'clientSecret' => '535233b0fe8b7576bc8b0b3d6c3ce130',
            'redirectUri'  =>'https://gsviec.com/oauth/facebook/access_token'
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
            'analytic' => 'UA-47328645-11',
            'apiKey' => getenv('GOOGLE_API'),
            'clientId' => getenv('GOOGLE_ID'),
            'clientSecret' => getenv('GOOGLE_SECRET'),
            'redirectUri' => 'https://gsviec.com/oauth/google/access_token'
        ],
        'disqus' => [
            'id' => 'gsviec',
            'keyId' => 'k1TgOK77THLLUgYi19RsYOqhD0go7CaMnV9ThFkwQfLgmZHs1BNl7887GMCb7ReF',
            'keySecret' => 'q47NR21I5GQWq80tMNcEjAPjQsJVAqYojOyWcEnMu3n3AaUWaVyPSZe4RR0ZvvNL',
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
            'REDIS_BACKEND'     => getenv('REDIS_HOST'),    // Set Redis Backend Info
            'REDIS_BACKEND_DB'  => '0',                 // Use Redis DB 0
            'COUNT'             => '1',                 // Run 1 worker
            'INTERVAL'          => '5',                 // Run every 5 seconds
            'QUEUE'             => '*',                 // Look in all queues
            'PREFIX'            => '__gsviec_',         // Prefix queues with test
            'VVERBOSE'          => '1',
            'APP_INCLUDE'       => 'cli'
        ],
        'amazon' => [
             's3' => [
                 'key' => getenv('AWS_KEY'),
                 'secret' => getenv('AWS_SECRET'),
                 'region' => getenv('AWS_REGION'),
                 'bucket' => getenv('AWS_BUCKET')
             ],
            'cloudFront' => [
                'url'    => getenv('CF_URL'),
                'keyId'  => getenv('CF_KEY'),
                'secret' => getenv('CF_SECRET_PATH') //var_path('key/pk-x.pem')
            ]
        ],
    ]
);
