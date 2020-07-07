<?php

namespace App\Vendor\Hronos;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\RegTrans;

class HronosDay
{
    public $currentUnixTime;
    public $currentDay;
    public $currentDayRender;

    public $summary;
    public $hl;
    public $growHl;
    public $countRows = 1;

    public $hronosDayItems = array();
    public $multiplicity = 1;

    public $typeCrit = 'success';

    function __construct($currentUnixTime, $summary, $hl, $regTrans)
    {
        $this->currentUnixTime = $currentUnixTime;
        $this->currentDay = (int) date('j', $this->currentUnixTime);
        $this->currentDayRender = date('j', $this->currentUnixTime);

        $this->summary = $summary;
        $this->hl = $hl;

        $this->setHronosDayItems($regTrans);
        $this->setTypeCrit();
    }

    public function setTypeCrit()
    {
        if ($this->summary <= 1000) {
            $this->typeCrit = 'danger';
        } else if ($this->summary <= 3000) {
            $this->typeCrit = 'warning';
        }
    }

    public function isCrit()
    {
        return $this->typeCrit != 'success' ? true : false;
    }
    public function isCritWarning()
    {
        return $this->typeCrit == 'warning' ? true : false;
    }
    public function isCritDanger()
    {
        return $this->typeCrit == 'danger' ? true : false;
    }

    public function setHronosDayItems($regTrans)
    {
        foreach ($regTrans as $transaction) {
            if ($this->hasTransaction($transaction)) {
                $this->createHronosDayItem($transaction);
                $this->countRows++;
            }
        }
    }

    public function hasTransaction($transaction)
    {
        if ($transaction->getCyclicity() == 'e_day') {
            return true;
        }

        if ($transaction->getCyclicity() == 'e_week'
            && date('N', strtotime('+1 day', $this->currentUnixTime)) == $transaction->getDay()) {
                return true;
        }

        if ($transaction->getCyclicity() == 'e_month'
            && $this->currentDay == $transaction->getDay()) {
                return true;
        }

        return false;
    }

    public function createHronosDayItem($transaction)
    {
        $hronosDayItem = new HronosDayItem($transaction);

        // incomes
        if ($transaction->getTypeTransaction() == 'incomes') {
            $this->growHl = (int)$transaction->getAmount()/10;
            $this->hl = $this->hl + $this->growHl;
            $this->summary = $hronosDayItem->summary = $this->summary + $transaction->getAmount() - $this->growHl;
        // expenses
        } elseif ($transaction->getTypeTransaction() == 'expenses') {
            $this->summary = $hronosDayItem->summary = $this->summary - $transaction->getAmount();
        }

        $this->hronosDayItems[] = $hronosDayItem;
    }
}
