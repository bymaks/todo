<?php
/**
 * Created by PhpStorm.
 * User: rr
 * Date: 03/04/2019
 * Time: 17:20
 */

namespace ToDo;

use Doctrine\ORM\EntityManager;

/**
 * Class AbstractResource
 * @package ToDo
 * @property EntityManager $entityManager
 */
abstract class AbstractResource
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager = null;

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}
}
