<?php
/**
 * Created by PhpStorm.
 * User: rr
 * Date: 02/04/2019
 * Time: 19:49
 */

namespace ToDo\Controllers;

use Doctrine\ORM\EntityManager;
use ToDo\Entity\TodoItem;
use ToDo\Entity\TodoList;
use ToDo\Entity\Users;
use ToDo\Models\TodoListMerge;
use ToDo\Resource\TodoitemResource;
use ToDo\Resource\TodolistResource;
use Anddye\Session\Helper;
use Slim\Router;
use Slim\Views\Twig;
use ToDo\Resource\UsersResource;

/**
 * Class AjaxController
 * @package ToDo\Controllers
 *
 */
final class AjaxController extends GeneralController
{
	private $todoList;

	public function __construct(EntityManager $em, Twig $view, Router $router, Helper $session)
	{
		parent::__construct($em, $view, $router, $session);
		$this->todoList = $todoList = new \ToDo\Resource\TodolistResource($em);
	}


	public function addItem($request, $response, $args)
	{
		$result = [];
		if (!empty($args['name'])) {
			$todoList = new TodolistResource($this->em);
			$newList = false;
			if (($list = $todoList->findBySession($this->session->get('id'))) == null) {
				$list = new TodoList();
				$list->setSessionId($this->session->get('id'));
				$list->setStatus(TodoList::STATUS_ENABLE);
				$list->setCompliteStatus(TodoList::COMPILE_STATUS_TODO);
				$newList = true;

			}
			$item = new TodoItem();
			$item->setItemName($args['name']);
			$item->setCompliteStatus(TodoItem::COMPILE_STATUS_TODO);
			$item->setStatus(TodoItem::STATUS_ENABLE);
			$item->setTodoList($list);

			if ($newList) {
				$this->em->persist($list);
			}
			$this->em->persist($item);
			$this->em->flush();

			$result = $list->getItemsAsArray();
		}
		return $response->withJSON($result);
	}

	public function updateItem($request, $response, $args)
	{
		$result = [];
		if (!empty($args['itemid'])) {
			$todoItem = $this->em->getRepository(TodoItem::class)->find($args['itemid']);
			if (!empty($todoItem)) {
				if (!empty($todoItem->getCompliteStatus())) {
					$todoItem->setCompliteStatus(TodoItem::COMPILE_STATUS_TODO);
				} else {
					$todoItem->setCompliteStatus(TodoItem::COMPILE_STATUS_DONE);
				}
				$this->em->flush();

				$list = $todoItem->getTodoList();
				$result = $list->getItemsAsArray();
			}
		}
		return $response->withJSON($result);

	}

	public function updateList($request, $response, $args)
	{
		$result = [];
		$todoList = new TodolistResource($this->em);
		if (($list = $todoList->findBySession($this->session->get('id'))) != null) {
			$todoItemRes = new TodoitemResource($this->em);
			$countItems = $todoItemRes->findUnComplite($list->getId());
			if (count($countItems) > 0) {//обновляем все до complite = 1
				foreach ($countItems as $objItem) {
					$objItem->setCompliteStatus(TodoItem::COMPILE_STATUS_DONE);
				}
			} else {//обновляем все до complite = 0
				foreach ($todoItemRes->findItemsByListId($list->getId()) as $objItem) {
					$objItem->setCompliteStatus(TodoItem::COMPILE_STATUS_TODO);
				}
			}
			$this->em->flush();
			$result = $list->getItemsAsArray();
		}
		return $response->withJSON($result);
	}

	public function deleteItem($request, $response, $args)
	{
		$result = [];
		if (!empty($args['itemid'])) {
			$todoItem = $this->em->getRepository(TodoItem::class)->find($args['itemid']);
			if (!empty($todoItem)) {
				$this->em->remove($todoItem);
				$this->em->flush();
			}
		}
		$todoList = new TodolistResource($this->em);
		if (($list = $todoList->findBySession($this->session->get('id'))) != null) {
			$result = $list->getItemsAsArray();
		}
		return $response->withJSON($result);
	}

	public function deleteComplite($request, $response, $args)
	{
		$result = [];

		$todoList = new TodolistResource($this->em);
		if (($list = $todoList->findBySession($this->session->get('id'))) != null) {
			$todoItemRes = new TodoitemResource($this->em);
			$compliteItems = $todoItemRes->findComplite($list->getId());
			foreach ($compliteItems as $objItem) {
				$this->em->remove($objItem);
			}
			$this->em->flush();

			$result = $list->getItemsAsArray();
		}
		return $response->withJSON($result);
	}

	public function all($request, $response, $args)
	{
		$todoList = new TodolistResource($this->em);
		if (($list = $todoList->findBySession($this->session->get('id'))) != null) {
			$result = $list->getItemsAsArray();
		} else {
			$this->session->set('id', uniqid('ToDoApp', true));
			$listN = new TodoList();
			$listN->setSessionId($this->session->get('id'));
			$listN->setStatus(TodoList::STATUS_ENABLE);
			$listN->setCompliteStatus(TodoList::COMPILE_STATUS_TODO);
			$this->em->persist($listN);
			$this->em->flush();
			$result = $listN->getItemsAsArray();
		}
		return $response->withJSON($result);
	}

	public function active($request, $response, $args)
	{
		$todoList = new TodolistResource($this->em);
		$result = [];
		if (($list = $todoList->findBySessionActive($this->session->get('id'))) != null) {
			$result = $list->getItemsAsArray();
		}
		return $response->withJSON($result);
	}

	public function completed($request, $response, $args)
	{
		$todoList = new TodolistResource($this->em);
		$result = [];
		if (($list = $todoList->findBySessionCompleted($this->session->get('id'))) != null) {
			$result = $list->getItemsAsArray();
		}
		return $response->withJSON($result);
	}
//***

	public function registration($request, $response, $args){
		$result = ['error'=>'empty data', 'errorCode'=>1, 'status'=>false];
		if(!empty($args['login']) && !empty($args['passwd']) && !empty($args['confirm'])) {
			if($args['passwd'] === $args['confirm']){
				//валидировать данные
				//создать пользователя
				//установтиь на ткущий лист значение полдьзователя
				$user = new Users();

				$user->setLogin(strval($args['login']));
				$user->setPassword(strval($args['passwd']));


				$userRes = new UsersResource($this->em);
				if(empty($userRes->findByLogin($user->getLogin()))){
					//можно сохранять уникальный
					$this->em->persist($user);
					$this->em->flush();

					$this->em->refresh($user);

					$merge = new TodoListMerge($this->session, $this->em);
					$merge->setUser($user);
					$this->session->set('userId', $user->getId());//совершив вход

					$result = ['error'=>'', 'errorCode'=>0, 'status'=>true];
				}
				else{
					$result = ['error'=>'not unique login', '', 'errorCode'=>2, 'status'=>false];
				}
			}
			else{
				$result = ['error'=>'passwd != confirm', 'errorCode'=>3, 'status'=>false];
			}
		}
		return $response->withJSON($result);
	}

	public function login($request, $response, $args){
		$result = ['error'=>'empty data', 'errorCode'=>5, 'status'=>false];
		if(!empty($args['login']) && !empty($args['passwd'])) {
			$userRes = new UsersResource($this->em);
			$user = $userRes->findByLogin($args['login']);
			if(!empty($user)){
				//можно сохранять уникальный
				if($user->checkPasswd($args['passwd'])){
					// авторизирован успешно
					$this->session->set('userId', $user->getId());//совершив вход
					$result = ['error'=>'', 'errorCode'=>0, 'status'=>true];
				}
				else{
					$result = ['error'=>'uncorrect password', 'errorCode'=>6, 'status'=>true];
				}
			}
			else{
				$result = ['error'=>'user not found', 'errorCode'=>4, 'status'=>false];
			}
		}
		return $response->withJSON($result);
	}

	public function namelogin($request, $response, $args){
		$userRes = new UsersResource($this->em);
		$result = ['login'=>null];
		if(!empty($this->session->get('userId'))){
			$user = $userRes->findById($this->session->get('userId'));
			$result = ['login'=>$user->getLogin()];
		}
		return $response->withJSON($result);
	}

	public function logout($request, $response, $args){
		$result=[];
		if(!empty($this->session->get('userId'))){
			$this->session->delete('userId');
		}
		return $response->withJSON($result);
	}
}

