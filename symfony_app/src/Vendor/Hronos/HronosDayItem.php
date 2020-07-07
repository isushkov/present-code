<?php

namespace App\Vendor\Hronos;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\RegTrans;
use App\Entity\Budget;

class HronosDayItem
{
    public $transId;
    public $transType;
    public $transAmount;
    public $transDescription;

    public $summary;

    function __construct($transaction)
    {
        $this->transId = $transaction->getId();
        $this->transType = $transaction->getTypeTransaction();
        $this->transAmount = $transaction->getAmount();
        $this->transDescription = $transaction->getDescription();
    }
}
