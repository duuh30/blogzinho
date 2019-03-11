<?php

use Dotenv\Dotenv;

$env = Dotenv::create(__DIR__.'/../');
$env->load();

    /**
     * @param $data
     */
    function dd ($data) {
        var_dump($data);
        die;
    }

    return [
        'settings' => [
            'displayErrorDetails' => true, // set to false in production
            'addContentLengthHeader' => false, // Allow the web server to send the content-length header
            'determineRouteBeforeAppMiddleware' => false,

            // Monolog settings
            'logger' => [
                'name' => 'blog-challenge-logs',
                'path' => __DIR__ . '/../logs/blog-challenge.log',
                'level' => \Monolog\Logger::DEBUG,
            ],

            // Doctrine
            'doctrine' => [
                'cache_dir' => __DIR__.'/../var/doctrine',
                'metadata_dirs' => [__DIR__.'/../src/Domain/Mappings'],
                'dev_mode' => true,
                'connection'    => [
                    'driver'    => 'pdo_mysql',
                    'host'      => $_ENV['DB_HOST'],
                    'port'      => $_ENV['DB_PORT'],
                    'dbname'    => $_ENV['DB_NAME'],
                    'user'      => $_ENV['DB_USER'],
                    'password'  => $_ENV['DB_PASS'],
                    'charset'   => 'utf8'
                ]
            ]
        ],
];
