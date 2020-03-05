<?php
/**
 * Created by PhpStorm.
 * User: rr
 * Date: 02/04/2019
 * Time: 19:49
 */

namespace ToDo\Controllers;


use Anddye\Session\Helper;
use Slim\Router;
use Slim\Views\Twig;
use ToDo\Resource\TodoitemResource;
use ToDo\Resource\TodolistResource;
use \Doctrine\ORM\EntityManager;

class SiteController extends GeneralController
{

    public function __construct(EntityManager $em, Twig $view, Router $router, Helper $session)
    {
        parent::__construct($em, $view, $router, $session);
    }

    public function index($request, $response, $args) {
        return $this->view->render($response, 'index-react.twig');
    }

	public function login($request, $response, $args) {
		return $this->view->render($response, 'login.twig');
	}

}
