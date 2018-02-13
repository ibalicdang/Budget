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
                $balanceMoney->setDeleteStatus(0);
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
        $getTotalMoneyTable = $em->getRepository('AppBundle:BalanceMoney')->findAll();
        $getTotalExpenseTable = $em->getRepository('AppBundle:Expense')->findBy(array('deleteStatus' => 0));
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
            $expense->setDeleteStatus(0);
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

    /**
    *@Route("/semi-delete-record/{id}", name="semi_delete_record")
    */
    public function semiDeleteRecord($id)
    {
         $em = $this->getDoctrine()->getManager();
         $semiDeleteRecord = $em->getRepository('AppBundle:Expense')->find($id);
         $semiDeleteRecord->setDeleteStatus(1);
         $em->persist($semiDeleteRecord);
         $em->flush();

         
         return $this->redirectToRoute('money_credit');
    }

    /**
    *@Route("/restore-deleted-record/{id}", name="restore_deleted_record")
    */
    public function restoreDeletedRecord($id)
    {
         $em = $this->getDoctrine()->getManager();
         $semiDeleteRecord = $em->getRepository('AppBundle:Expense')->find($id);
         $semiDeleteRecord->setDeleteStatus(0);
         $em->persist($semiDeleteRecord);
         $em->flush();

         
         return $this->redirectToRoute('records_deleted');
    }

    /**
    *@Route("/records-deleted", name="records_deleted")
    */
    public function deleteRecordDisplay(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $getTotalExpenseTable = $em->getRepository('AppBundle:Expense')->findBy(array('deleteStatus' => 1));


        return $this->render('default/DeleteRecordPermanently.html.twig',array(
            'getTotalExpenseTable' => $getTotalExpenseTable,
        ));
    } 

    /**
    *@Route("/records-deleted-permanently/{id}", name="records_deleted_permanently")
    */
    public function deleteRecordPermanentlyDisplay($id)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteRecordsPermanently = $em->getRepository('AppBundle:Expense')->find($id);
        $em->remove($deleteRecordsPermanently);
        $em->flush();

        return $this->redirectToRoute('records_deleted');
    }     
}