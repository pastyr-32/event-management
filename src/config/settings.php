<?php
declare(strict_types=1);

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'team-service',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : APP_ROOT . '/var/logs/app.log',
            'level' => Monolog\Logger::DEBUG,
        ],

        // Doctrine settings
        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,

            // path where the compiled metadata info will be cached
            // make sure the path exists and it is writable
            'cache_dir' => APP_ROOT . '/var/doctrine',

            // you should add any other path containing annotated entity classes
            'metadata_dirs' => [APP_ROOT . '/src/Domain'],

            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => getenv('MYSQL_HOST'),
                'port' => getenv('MYSQL_PORT'),
                'dbname' => getenv('MYSQL_DATABASE'),
                'user' => getenv('MYSQL_USER'),
                'password' => getenv('MYSQL_PASSWORD')
            ]
        ]
    ],
];
