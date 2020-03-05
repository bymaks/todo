<?php
/**
 * Created by PhpStorm.
 * User: rr
 * Date: 03/04/2019
 * Time: 17:21
 */

namespace ToDo\Resource;

use ToDo\AbstractResource;
use ToDo\Entity\TodoList;

/**
 * Class TodolistResource
 * @package ToDo\Resource
 */
class TodolistResource extends AbstractResource
{

	/**
	 * @param string|null $session
	 * @return array|object|null
	 */
	public function findBySession($session = null)
	{
		if (!empty($session)) {
			$todoList = $this->entityManager->getRepository('ToDo\Entity\TodoList')->findOneBy(['sessionId' => $session]);
			if ($todoList) {
				return $todoList;
			}
		}
		return [];
	}

	/**
	 * @param string|null $session
	 * @return array|object|null
	 */
	public function findBySessionActive($session = null)
	{
		if (!empty($session)) {
			$todoList = $this->entityManager
				->getRepository('ToDo\Entity\TodoList')
				->findOneBy([
					'sessionId'     => $session,
					'complitStatus' => TodoList::COMPILE_STATUS_TODO
				]);
			if ($todoList) {
				return $todoList;
			}
		}
		return [];
	}

	/**
	 * @param string|null $session
	 * @return array|object|null
	 */
	public function findBySessionCompleted($session = null)
	{
		if (!empty($session)) {
			$todoList = $this->entityManager
				->getRepository('ToDo\Entity\TodoList')
				->findOneBy([
					'sessionId'     => $session,
					'complitStatus' => TodoList::COMPILE_STATUS_DONE
				]);
			if ($todoList) {
				return $todoList;
			}
		}
		return [];
	}
}
