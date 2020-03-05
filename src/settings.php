<?php
$settings = [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/twig/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'view' => [
            'template_path' => __DIR__ . '/../templates/twig/',
            'twig' => [
                'cache' => false,//'cache/twig',
                'debug' => true,
            ],
        ],
		'doctrine' => [
			// if true, metadata caching is forcefully disabled
			'dev_mode' => true,

			// path where the compiled metadata info will be cached
			// make sure the path exists and it is writable
			//'cache_dir' => __DIR__ . '/db_cache',

			// you should add any other path containing annotated entity classes
			//'metadata_dirs' => [__DIR__ . '/src/Entity'],

			'connection' => [
				'driver' => 'pdo_mysql',
				'host' => 'mysqldb',
				'port' => 3306,
				'dbname' => 'todo',
				'user' => 'todo',
				'password' => 'todo',
				//'charset' => 'utf-8'
			],
			'meta' => [
				'entity_path' => [
					__DIR__.'/ToDo/Entity'
				],
				'auto_generate_proxies' => true,
				'proxy_dir' =>  __DIR__.'/../cache/proxies',
				'cache' => null,
			],
		]
    ],
];

return $settings;
