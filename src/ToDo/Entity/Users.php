<?php

namespace ToDo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="login", columns={"login"})})
 * @ORM\Entity
 */
class Users
{
	const STATUS_ENABLE = 1;

	const STATUS_DISABLE = 0;
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
	 * @ORM\Column(name="login", type="string", length=32, nullable=false)
	 */
	private $login;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password_hash", type="string", length=128, nullable=false)
	 */
	private $passwordHash;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="status", type="boolean", nullable=false, options={"default"="1"})
	 */
	private $status = '1';


	/**
	 * @var TodoList
	 *
	 * @OneToMany(targetEntity="TodoList", mappedBy="user")
	 */
	private $todoList;

	/**
	 * Users constructor.
	 */
	public function __construct()
	{
		$this->todoList = new ArrayCollection();
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
	public function getLogin()
	{
		return $this->login;
	}

	/**
	 * @return bool
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @return TodoList
	 */
	public function getTodoList(): TodoList
	{
		return $this->todoList;
	}

	/**
	 * @param string $login
	 */
	public function setLogin(string $login)
	{
		if (strlen($login) <= 32) {
			$this->login = $login;
		}
		//добавить обработчик ошибок

	}

	/**
	 * @param string $password
	 */
	public function setPassword(string $password)
	{
		if (!empty($password)) {
			$this->passwordHash = password_hash($password, PASSWORD_BCRYPT);
		}
		//добавить обработчик ошибок
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
	 * @param string $passwd
	 * @return bool
	 */
	public function checkPasswd(string $passwd){
		if(!empty($passwd)){
			$pwdHash = md5($passwd);
			if($pwdHash == $this->passwordHash){
				return true;
			}
		}
		return false;
	}

//	public function setTodoList(TodoList $todoList){
//		$this->todoList = $todoList;
//	}

}
