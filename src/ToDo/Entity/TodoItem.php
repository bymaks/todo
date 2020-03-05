<?php

namespace ToDo\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Class TodoItem
 *
 * @ORM\Table(name="todo_item", indexes={@ORM\Index(name="todo_list_id", columns={"todo_list_id"})})
 * @ORM\Entity
 *
 * @package ToDo\Entity
 *
 */
class TodoItem
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;
	const COMPILE_STATUS_DONE = 1;
	const COMPILE_STATUS_TODO = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="item_name", type="string", length=128, nullable=false)
	 */
	private $itemName;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="complite_status", type="boolean", nullable=false)
	 */
	private $compliteStatus = '0';

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="todo_list_id", type="integer", nullable=false)
	 */
	private $todoListId;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="status", type="boolean", nullable=false, options={"default"="1"})
	 */
	private $status = '1';

	/**
	 * @var TodoList
	 *
	 * @ORM\ManyToOne(targetEntity="TodoList", inversedBy="items")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="todo_list_id", referencedColumnName="id")
	 * })
	 */
	private $todoList;

	/**
	 * @param $property
	 * @return mixed
	 */
	public function __get($property)
	{
		if (property_exists(self::class, $property)) {
			return $this->$property;
		}
	}


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getItemName()
	{
		return $this->itemName;
	}

	/**
	 * @return bool|int
	 */
	public function getCompliteStatus()
	{
		return (empty($this->compliteStatus) ? self::COMPILE_STATUS_TODO : $this->compliteStatus);
	}

	/**
	 * @return bool|int
	 */
	public function getStatus()
	{
		return (empty($this->status) ? self::STATUS_DISABLE : $this->status);
	}

	/**
	 * @return TodoList
	 */
	public function getTodoList(): TodoList
	{
		return $this->todoList;
	}


	/**
	 * @param string $name
	 */
	public function setItemName(string $name)
	{
		if (!empty($name)) {
			$this->itemName = $name;
		}
	}

	/**
	 * @param int $compileStatus
	 */
	public function setCompliteStatus(int $compileStatus)
	{
		if (empty($compileStatus)) {
			$this->compliteStatus = self::COMPILE_STATUS_TODO;
		} else {
			$this->compliteStatus = self::COMPILE_STATUS_DONE;
		}
	}

	/**
	 * @param int $satus
	 */
	public function setStatus(int $satus)
	{
		if (empty($satus)) {
			$this->status = self::STATUS_DISABLE;
		} else {
			$this->status = self::STATUS_ENABLE;
		}
	}

	/**
	 * @param TodoList $todoList
	 */
	public function setTodoList(TodoList $todoList)
	{
		$this->todoList = $todoList;
	}


}
