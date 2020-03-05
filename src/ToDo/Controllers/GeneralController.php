<?php
/**
 * Created by PhpStorm.
 * User: rr
 * Date: 02/04/2019
 * Time: 19:47
 */

namespace ToDo\Controllers;


use Anddye\Session\Helper;
use Slim\Router;
use Slim\Views\Twig;
use \Doctrine\ORM\EntityManager;

class GeneralController
{

	public $view;
	public $router;
	public $session;
	public $em;

	public function __construct(EntityManager $em, Twig $view, Router $router, Helper $session)
	{
		$this->view = $view;
		$this->router = $router;
		$this->session = $session;
		$this->em = $em;
		$this->setCurrentSession();
	}

	private  function  setCurrentSession(){
		if( ($currnetId = $this->session->get('id'))==null){
			$this->session->set('id', uniqid('ToDoApp', true));
		}
	}
}
