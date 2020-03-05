<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig($c['settings']['view']['template_path'], $c['settings']['view']['twig']);
    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $c['request']->getUri()));
    $view->addExtension(new Twig_Extension_Debug());
    return $view;
};

$container['session'] = function ($c){
	return new Anddye\Session\Helper();
};

$container['em'] = function ($c) {
	$settings = $c->get('settings');
	$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
		$settings['doctrine']['meta']['entity_path'],
		$settings['doctrine']['meta']['auto_generate_proxies'],
		$settings['doctrine']['meta']['proxy_dir'],
		$settings['doctrine']['meta']['cache'],
		false
	);
	return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};

$container['ToDo\Controllers\SiteController'] = function ($c) {
    return new \ToDo\Controllers\SiteController($c->get('em'), $c['view'], $c['router'], $c['session']);
};
$container['ToDo\Controllers\AjaxController'] = function ($c) {
	return new \ToDo\Controllers\AjaxController($c->get('em'), $c['view'], $c['router'], $c['session']);
};

