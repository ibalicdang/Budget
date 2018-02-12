<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BalanceMoney
 *
 * @ORM\Table(name="balance_money")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BalanceMoneyRepository")
 */
class BalanceMoney
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="FirstBalance", type="integer")
     */
    private $firstBalance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateManipulation", type="datetime")
     */
    private $dateManipulation;

    /**
     * @var int
     *
     * @ORM\Column(name="totalBalance", type="integer")
     */
    private $totalBalance;

    /**
     * @var int
     *
     * @ORM\Column(name="oldBalance", type="integer")
     */
    private $oldBalance;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstBalance
     *
     * @param integer $firstBalance
     * @return BalanceMoney
     */
    public function setFirstBalance($firstBalance)
    {
        $this->firstBalance = $firstBalance;

        return $this;
    }

    /**
     * Get firstBalance
     *
     * @return integer 
     */
    public function getFirstBalance()
    {
        return $this->firstBalance;
    }

    /**
     * Set dateManipulation
     *
     * @param \DateTime $dateManipulation
     * @return BalanceMoney
     */
    public function setDateManipulation($dateManipulation)
    {
        $this->dateManipulation = $dateManipulation;

        return $this;
    }

    /**
     * Get dateManipulation
     *
     * @return \DateTime 
     */
    public function getDateManipulation()
    {
        return $this->dateManipulation;
    }

    /**
     * Set totalBalance
     *
     * @param integer $totalBalance
     * @return BalanceMoney
     */
    public function setTotalBalance($totalBalance)
    {
        $this->totalBalance = $totalBalance;

        return $this;
    }

    /**
     * Get totalBalance
     *
     * @return integer 
     */
    public function getTotalBalance()
    {
        return $this->totalBalance;
    }

    /**
     * Set oldBalance
     *
     * @param integer $oldBalance
     * @return BalanceMoney
     */
    public function setOldBalance($oldBalance)
    {
        $this->oldBalance = $oldBalance;

        return $this;
    }

    /**
     * Get oldBalance
     *
     * @return integer 
     */
    public function getoldBalance()
    {
        return $this->oldBalance;
    }
}
