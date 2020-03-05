<?php


namespace ToDo\Resource;


use ToDo\AbstractResource;

/**
 * Class UsersResource
 * @package ToDo\Resource
 */
class UsersResource extends AbstractResource
{
	/**
	 * @param null $login
	 * @return array|object|null
	 */
	public function findByLogin($login = null)
	{
		if (!empty($login)) {
			$login = strval($login);
			if (strlen($login) < 32) {
				$user = $this->entityManager->getRepository('ToDo\Entity\Users')->findOneBy(['login' => $login]);
				if (!empty($user)) {
					return $user;
				}
			}
		}
		return [];
	}

	/**
	 * @param int $id
	 * @return array|object|null
	 */
	public function findById(int $id)
	{
		if (!empty($id)) {
			$user = $this->entityManager->getRepository('ToDo\Entity\Users')->findOneBy(['id' => $id]);
			if (!empty($user)) {
				return $user;
			}
		}
		return [];
	}
}
