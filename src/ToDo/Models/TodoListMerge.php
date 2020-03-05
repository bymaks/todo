<?php


namespace ToDo\Models;

use Anddye\Session\Helper;
use Doctrine\ORM\EntityManager;
use ToDo\Entity\Users;
use ToDo\Resource\TodoitemResource;
use ToDo\Resource\TodolistResource;

/**
 * Class TodoListMerge
 * @package ToDo\Models
 *
 */
class TodoListMerge
{
	/**
	 * @var Helper
	 */
	private $session;

	/**
	 * @var EntityManager
	 */
	private $em;

	/**
	 * @var Users
	 */
	private $user;

	/**
	 * @var
	 */
	private $currentList;

	/**
	 * @var
	 */
	private $userList;

	public function __construct(Helper $session, EntityManager $em)
	{
		$this->session = $session;
		$this->em = $em;
	}

	/**
	 * @param Users $user
	 */
	public function setUser(Users $user)
	{
		if (!empty($user)) {
			$this->user = $user;
		}
	}

	/**
	 *
	 */
	public function mergeList()
	{
		$this->findCurrentList();
		$this->findListByUser();

		if (empty($this->userList)) {
			if (!empty($this->currentList)) {

			}
		} else {

		}

	}

	/**
	 *
	 */
	private function findCurrentList()
	{
		$listRes = new TodolistResource($this->em);
		$list = $listRes->findBySession($this->session->get('id'));
		if (!empty($list)) {
			$this->currentList = $list;
		} else {
			$this->currentList = null;
		}
	}

	/**
	 *
	 */
	private function findListByUser()
	{
		$listRes = new TodolistResource($this->em);
		$list = $listRes->findByUser($this->session->get('id'));
		if (!empty($list)) {
			$this->userList = $list;
		} else {
			$this->userList = null;
		}
	}

}
