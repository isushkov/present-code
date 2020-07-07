<?php

namespace App\Vendor\TeoBudget;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RegTrans;

class TeoBudget
{
    public $incomes = 0;
    public $expenses = 0;
    public $detailExpenses = array();
    public $reserve = 0;
    public $freeMoney = 0;

    function __construct($regTrans)
    {
        $loop = 0;
        foreach ($regTrans as $transaction) {
            if ($transaction->getCyclicity() == 'e_day') { $days = 30; }
            if ($transaction->getCyclicity() == 'e_week') { $days = 4; }
            if ($transaction->getCyclicity() == 'e_month') { $days = 1; }
            $amount = $transaction->getAmount() * $days;

            if ($transaction->getTypeTransaction() == 'incomes') {
                $this->incomes = $this->incomes + $amount;

            } elseif ($transaction->getTypeTransaction() == 'expenses') {
                $this->expenses = $this->expenses + $amount;

                $this->detailExpenses[$loop]['description'] = $transaction->getDescription();
                $this->detailExpenses[$loop]['amount'] = $transaction->getAmount();
                $this->detailExpenses[$loop]['multi'] = $days;
                $this->detailExpenses[$loop]['result'] = $amount;
            }

            $loop++;
        }

        $this->reserve = $this->incomes / 10;
        $this->incomes = $this->incomes - $this->reserve;
        $this->freeMoney = $this->incomes - $this->expenses;
    }
}
