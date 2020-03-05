<?php
/**
 * Created by PhpStorm.
 * User: rr
 * Date: 03/04/2019
 * Time: 18:09
 */

namespace ToDo\Resource;


use ToDo\AbstractResource;
use ToDo\Entity\TodoItem;
use ToDo\Entity\TodoList;

/**
 * Class TodoitemResource
 * @package ToDo\Resource
 */
class TodoitemResource extends AbstractResource
{

	/**
	 * @param int $listId
	 * @return array
	 */
	public function findUnComplite(int $listId): array
	{
		if (!empty($listId)) {
			$todoItems = $this->entityManager->getRepository('ToDo\Entity\TodoItem')
				->findBy(['compliteStatus' => 0, 'todoListId' => $listId]);
			if ($todoItems) {
				return $todoItems;
			}
		}
		return [];
	}

	/**
	 * @param int $listId
	 * @return array
	 */
	public function findComplite(int $listId): array
	{
		if (!empty($listId)) {
			$todoItems = $this->entityManager
				->getRepository('ToDo\Entity\TodoItem')
				->findBy([
					'compliteStatus' => TodoItem::COMPILE_STATUS_DONE,
					'todoListId'     => $listId
				]);
			if ($todoItems) {
				return $todoItems;
			}
		}
		return [];
	}

	/**
	 * @param int $listId
	 * @return array|object[]
	 */
	public function findItemsByListId(int $listId)
	{
		if (!empty($listId)) {
			$todoItems = $this->entityManager
				->getRepository('ToDo\Entity\TodoItem')
				->findBy(['todoListId' => $listId]);
			if ($todoItems) {
				return $todoItems;
			}
		}
		return [];
	}
}
