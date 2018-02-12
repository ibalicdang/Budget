<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\BalanceMoney;
use AppBundle\Form\BalanceMoneyType;

use AppBundle\Entity\Expense;
use AppBundle\Form\ExpenseType;

class BudgetController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $getInfo = $em->getRepository('AppBundle:BalanceMoney')->FindAll();
        $getTotalMoney = $em->getRepository('AppBundle:BalanceMoney')->totalSumOfMoney();
        $getTotalExpense = $em->getRepository('AppBundle:Expense')->totalSumOfExpense();
        $mydatenow = new \DateTime();

        $getDiff = $getTotalMoney-$getTotalExpense;
        $balanceMoney = new BalanceMoney();
        $getMoneyInput = $this->createForm(new BalanceMoneyType(), $balanceMoney);
        $getMoneyInput->handleRequest($request);

        if ($getMoneyInput->isvalid()) {
            $myGetDatas = $getMoneyInput->get('firstBalance')->getData();
            $balanceMoney->setDateManipulation(new \DateTime());
            $balanceMoney->setTotalBalance($myGetDatas+$getDiff);
            if ($getDiff == 0) {
                $balanceMoney->setOldBalance($myGetDatas);
                $em->persist($balanceMoney);
                $em->flush();
            }else{
                $balanceMoney->setOldBalance($getDiff);
                $em->persist($balanceMoney);
                $em->flush();
            }
            

        return $this->redirectToRoute('homepage');
        }

        return $this->render('default/GetInput.html.twig',array(
            'mydatenow' => $mydatenow,
            'getTotalMoney'=> $getTotalMoney,
            'getInfo' => $getInfo,
            'getDiff' => $getDiff,
            'getMoneyInput'=> $getMoneyInput->createView(),
            'getTotalExpense'=> $getTotalExpense,
        ));
    }

    /**
    *@Route("/money-credit", name="money_credit")
    */
    public function creditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $getTotalMoney = $em->getRepository('AppBundle:BalanceMoney')->totalSumOfMoney();
        $getTotalExpense = $em->getRepository('AppBundle:Expense')->totalSumOfExpense();
        $getTotalMoneyTable = $em->getRepository('AppBundle:BalanceMoney')->FindAll();
        $getTotalExpenseTable = $em->getRepository('AppBundle:Expense')->FindAll();
        $now = new \DateTime();
        $getTotalExpenseToday = $em->getRepository('AppBundle:Expense')->totalSumOfExpenseToday($now);
        $getDiff = $getTotalMoney-$getTotalExpense;
        $mydatenow = new \DateTime();

        $expense = new Expense();
        $getExpenseInput = $this->createForm(new ExpenseType(), $expense);
        $getExpenseInput->handleRequest($request);
        if ($getExpenseInput->isvalid()) {
            $myGetDatas = $getExpenseInput->get('expenseValue')->getData();
            $expense->setDateManipulation(new \DateTime());
            $expense->setOldBalance($getDiff);
            $expense->setNewBalance($getDiff-$myGetDatas);
            $em->persist($expense);
            $em->flush();

        return $this->redirectToRoute('money_credit');
        }

        return $this->render('default/GetCredit.html.twig',array(
            'getTotalMoney'=> $getTotalMoney,
            'getTotalExpenseToday' => $getTotalExpenseToday,
            'getDiff' => $getDiff,
            'mydatenow' => $mydatenow,
            'getExpenseInput'=> $getExpenseInput->createView(),
            'getTotalExpense'=> $getTotalExpense,
            'getTotalMoneyTable' => $getTotalMoneyTable,
            'getTotalExpenseTable' => $getTotalExpenseTable,
        ));
    }

    /**
    *@Route("/view-all-credit-transaction/{fromDate}/{toDate}", name="view_all_credit_transaction")
    */
    public function viewAllCreditTransaction($fromDate,$toDate)
    {
         $em = $this->getDoctrine()->getManager();
    
         $getSearch = $em->getRepository('AppBundle:Expense')->findFromTo($fromDate,$toDate);
         $getDefaultSearch = $em->getRepository('AppBundle:Expense')->FindAll();

         $getTotalExpenseTable = $getSearch ? $getSearch : $getDefaultSearch;

         return $this->render('default/ViewAllCreditTransaction.html.twig',array(
            'getTotalExpenseTable' => $getTotalExpenseTable,
         ));
    }

    /**
    *@Route("/view-all-debit-transaction", name="view_all_debit_transaction")
    */
    public function viewAllDebitTransaction()
    {
         $em = $this->getDoctrine()->getManager();
         $getInfo = $em->getRepository('AppBundle:BalanceMoney')->FindAll();

         return $this->render('default/ViewAllDebitTransaction.html.twig',array(
            'getInfo' => $getInfo,
         ));
    }

    /**
    *@Route("/view-credit-transaction/{fromDate}/{toDate}", name="view_credit_transaction")
    */
    public function viewCreditTransaction($fromDate,$toDate)
    {
         $em = $this->getDoctrine()->getManager();
         $getSearch = $em->getRepository('AppBundle:Expense')->findFromToScalar($fromDate,$toDate);

         return new JsonResponse($getSearch);
    }   
}