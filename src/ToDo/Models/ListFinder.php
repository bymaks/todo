<?php

namespace ToDo\Models;

use Anddye\Session\Helper;
use Doctrine\ORM\EntityManager;
use ToDo\Entity\TodoList;
use ToDo\Resource\TodolistResource;
use ToDo\Resource\UsersResource;

/**
 * Class ListFinder
 * @package ToDo\Models
 */
class ListFinder
{

	private $session;
	private $em;
	private $todoRes;

	public function __construct(Helper $session, EntityManager $em)
	{
		$this->session = $session;
		$this->em = $em;
		$this->todoRes = new TodolistResource($this->em);
	}

	/**
	 * @return array|object|TodoList|null
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
	public function findList()
	{
		if (!empty($this->session->get('userId'))) {
			$list = $this->todoRes->findByUser($this->session->get('userId'));
		} else {
			$list = $this->todoRes->findBySession($this->session->get('id'));
		}

		if (empty($list)) {//создаем новый

			$listN = new TodoList();
			$listN->setSessionId($this->session->get('id'));

			if (!empty($this->session->get('userId'))) {
				$userRes = New UsersResource($this->em);
				$user = $userRes->findById($this->session->get('userId'));
				if (!empty($user)) {
					$listN->setUser($user);
				}
			}

			$listN->setStatus(TodoList::STATUS_ENABLE);
			$listN->setCompliteStatus(TodoList::COMPILE_STATUS_TODO);
			$this->em->persist($listN);
			$this->em->flush();
			$this->em->refresh($listN);
			return $listN;
		} else {
			return $list;
		}
	}
}
