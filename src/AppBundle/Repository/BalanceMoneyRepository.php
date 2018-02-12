<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * BalanceMoneyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BalanceMoneyRepository extends EntityRepository
{
	public function totalSumOfMoney()
	{
		 $sumQuery = $this->_em->getRepository('AppBundle:BalanceMoney')
		->createQueryBuilder('t')
		->select('SUM(t.firstBalance) as totalSumOfMoney')
		->getQuery()
		->getSingleScalarResult();

		return $sumQuery;
	}
	
}
