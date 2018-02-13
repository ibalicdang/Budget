<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expense
 *
 * @ORM\Table(name="expense")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpenseRepository")
 */
class Expense
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
     * @ORM\Column(name="expenseValue", type="integer")
     */
    private $expenseValue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateManipulation", type="datetime")
     */
    private $dateManipulation;

    /**
     * @var string
     *
     * @ORM\Column(name="myDiscription", type="string", length=255)
     */
    private $myDiscription;

    /**
     * @var int
     *
     * @ORM\Column(name="oldBalance", type="integer")
     */
    private $oldBalance;

    /**
     * @var int
     *
     * @ORM\Column(name="newBalance", type="integer")
     */
    private $newBalance;

    /**
     * @var int
     *
     * @ORM\Column(name="deleteStatus", type="integer", nullable=TRUE)
     */
    private $deleteStatus;

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
     * Set expenseValue
     *
     * @param integer $expenseValue
     * @return Expense
     */
    public function setExpenseValue($expenseValue)
    {
        $this->expenseValue = $expenseValue;

        return $this;
    }

    /**
     * Get expenseValue
     *
     * @return integer 
     */
    public function getExpenseValue()
    {
        return $this->expenseValue;
    }

    /**
     * Set dateManipulation
     *
     * @param \DateTime $dateManipulation
     * @return Expense
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
     * Set myDiscription
     *
     * @param string $lastName
     * @return Expense
     */
    public function setMyDiscription($myDiscription)
    {
        $this->myDiscription = $myDiscription;

        return $this;
    }

    /**
     * Get myDiscription
     *
     * @return string 
     */
    public function getMyDiscription()
    {
        return $this->myDiscription;
    }

    /**
     * Set oldBalance
     *
     * @param integer $oldBalance
     * @return Expense
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
    public function getOldBalance()
    {
        return $this->oldBalance;
    }

    /**
     * Set newBalance
     *
     * @param integer $newBalance
     * @return Expense
     */
    public function setNewBalance($newBalance)
    {
        $this->newBalance = $newBalance;

        return $this;
    }

    /**
     * Get newBalance
     *
     * @return integer 
     */
    public function getNewBalance()
    {
        return $this->newBalance;
    }

    /**
     * Set deleteStatus
     *
     * @param integer $deleteStatus
     * @return Expense
     */
    public function setDeleteStatus($deleteStatus)
    {
        $this->deleteStatus = $deleteStatus;

        return $this;
    }

    /**
     * Get deleteStatus
     *
     * @return integer 
     */
    public function getDeleteStatus()
    {
        return $this->deleteStatus;
    }


}
