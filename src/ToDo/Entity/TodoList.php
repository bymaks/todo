<?php

namespace ToDo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * TodoList
 *
 * @ORM\Table(name="todo_list", indexes={@ORM\Index(name="session_id", columns={"session_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class TodoList
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
	 * @var string|null
	 *
	 * @ORM\Column(name="name_list", type="string", length=64, nullable=true)
	 */
	private $nameList;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="session_id", type="integer", nullable=false)
	 */
	private $sessionId;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="complit_status", type="boolean", nullable=false)
	 */
	private $complitStatus = '0';

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="status", type="boolean", nullable=false, options={"default"="1"})
	 */
	private $status = '1';

	/**
	 * @var Users
	 *
	 * @ORM\ManyToOne(targetEntity="Users", inversedBy="todoList")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 * })
	 */
	private $user;

	/**
	 * @var TodoItem
	 *
	 * @OneToMany(targetEntity="TodoItem", mappedBy="todoList")
	 */
	private $items;

	/**
	 * TodoList constructor.
	 */
	public function __construct(){
		$this->items = new ArrayCollection();
	}

	/**
	 * @param $property
	 * @return mixed
	 */
	public function __get($property){
		if(property_exists(self::class, $property)){
			return $this->$property;
		}
	}


	/**
	 * @return int
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @return string|null
	 */
	public function getNameList(){
		return $this->nameList;
	}

	/**
	 * @return int
	 */
	public function getSessionId(){
		return $this->sessionId;
	}

	/**
	 * @return bool
	 */
	public function getComplitStatus(){
		return $this->complitStatus;
	}

	/**
	 * @return bool
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 * @return Users
	 */
	public function getUser():Users{
		return $this->user;
	}

	/**
	 * @return ArrayCollection|TodoItem
	 */
	public function getItems(){
		return $this->items;
	}

	/**
	 * @return array
	 */
	public function getItemsAsArray(){
		$result = [];
		$listItems = $this->getItems();
		if(($countTodo = count($listItems)) >0){
			$key = 0;
			while ($key<$countTodo){
				$result[] = [
					'id' => $listItems[$key]->getId(),
					'itemName' => $listItems[$key]->getItemName(),
					'compliteStatus' => (empty($listItems[$key]->getCompliteStatus())?self::COMPILE_STATUS_TODO:self::COMPILE_STATUS_DONE)
				];
				$key++;
			}
		}
		return $result;
	}


	/**
	 * @param string $nameList
	 */
	public function setNameList(string $nameList){
		$this->nameList = $nameList;
	}

	/**
	 * @param string $session
	 */
	public function setSessionId(string $session){
		$this->sessionId = $session;
	}

	/**
	 * @param int $compileStatus
	 */
	public function setCompliteStatus(int $compileStatus){
		if(empty($compileStatus)){
			$this->compliteStatus = self::COMPILE_STATUS_TODO;
		}
		else{
			$this->compliteStatus = self::COMPILE_STATUS_DONE;
		}
	}

	/**
	 * @param int $satus
	 */
	public function setStatus(int $satus){
		if(empty($satus)){
			$this->status = self::STATUS_DISABLE;
		}
		else{
			$this->status = self::STATUS_ENABLE;
		}
	}

	/**
	 * @param Users $user
	 */
	public function setUser(Users $user){
		$this->user = $user;
	}



//	public function setItems(TodoItem $item){
//		$this->items = $item;
//	}


}
