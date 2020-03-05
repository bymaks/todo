<?php
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
// Application middleware

$app->add(new \Anddye\Middleware\SessionMiddleware([
	'autorefresh'   => true,
	'name'          => 'todoAppSession',
	'lifetime'      => '24 hour',
	'path'			=> '/',
]));
