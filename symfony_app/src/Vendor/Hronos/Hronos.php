<?php

namespace App\Vendor\Hronos;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

use App\Entity\Budget;
use App\Entity\RegTrans;

class Hronos
{
    public $startUnixTime;
    public $startTih;
    public $startHl;

    public $endUnixTime;
    public $endTih;
    public $endHl;

    public $deltaTih;
    public $deltaHl;

    public $hronosDays = array();
    public $criticallyDays = array();
    public $criticallyDayWarning;
    public $criticallyDayDanger;
    public $criticallyDaysRender = array();

    public $maxCritDay;
    public $freeMoney;


    function __construct($budget, $regTrans)
    {
        $dateTime = new \DateTime();

        $this->startUnixTime = $currentUnixTime = (int) $dateTime->format('U');
        $this->startTih = $summary = $budget->getTih();
        $this->startHl = $hl = $budget->getHl();

        for ($i = 1; $i <= (int) $dateTime->format('t'); $i++) {
            $this->hronosDays[$i] = new HronosDay($currentUnixTime, $summary, $hl, $regTrans);

            $currentUnixTime = strtotime('+1 day', $currentUnixTime);
            $summary = $this->hronosDays[$i]->summary;
            $hl = $this->hronosDays[$i]->hl;
        }

        $this->endUnixTime = $currentUnixTime;
        $this->endTih = $summary;
        $this->endHl = $hl;

        $this->deltaTih = $this->endTih - $this->startTih;
        $this->deltaHl = $this->endHl - $this->startHl;

        $this->setFreeAndCriticalDays();
        $this->mergeSameRows();
    }

    public function setFreeAndCriticalDays()
    {
        $loop = 1;
        foreach ($this->hronosDays as $key => $hronosDay) {
            // criticallyDays
            if ($hronosDay->isCrit()) {
                $this->criticallyDays[] = $hronosDay;
            }

            // max crit and free money
            if ($loop == 1) {
                $keyMaxCrit = $key;
            } else if ($this->hronosDays[$key]->summary <= $this->hronosDays[$keyMaxCrit]->summary) {
                $keyMaxCrit = $key;
            }

            $loop++;
        }

        // ctir warning and danger
        $this->setCriticallyDayWarning();
        $this->setCriticallyDayDanger();
        $this->setCriticallyDaysRender();

        // max crit and free money
        $this->maxCritDay = $this->hronosDays[$keyMaxCrit];
        if ($this->maxCritDay->summary <= 0) {
            $this->freeMoney = 0;
        } else {
            $this->freeMoney = $this->maxCritDay->summary;
        }
    }

    public function setCriticallyDayWarning()
    {
        if ($this->hasCriticallyDays()) {
            foreach ($this->criticallyDays as $key => $criticallyDay) {
                if ($criticallyDay->isCritWarning()) {
                    $this->criticallyDayWarning = $criticallyDay;
                    break;
                } else {
                    $this->criticallyDayWarning = false;
                }
            }
        }
    }
    public function setCriticallyDayDanger()
    {
        if ($this->hasCriticallyDays()) {
            foreach ($this->criticallyDays as $key => $criticallyDay) {
                if ($criticallyDay->isCritDanger()) {
                    $this->criticallyDayDanger = $criticallyDay;
                    break;
                } else {
                    $this->criticallyDayDanger = false;
                }
            }
        }
    }
    public function hasCriticallyDays()
    {
        return $this->criticallyDays ? true : false;
    }

    public function setCriticallyDaysRender()
    {
        if ($this->hasCriticallyDayWarning()) {
            $this->criticallyDaysRender[] = $this->criticallyDayWarning;
        }
        if ($this->hasCriticallyDayDanger()) {
            $this->criticallyDaysRender[] = $this->criticallyDayDanger;
        }
    }

    public function hasCriticallyDayWarning()
    {
        return $this->criticallyDayWarning ? true : false;
    }
    public function hasCriticallyDayDanger()
    {
        return $this->criticallyDayDanger ? true : false;
    }

    public function mergeSameRows()
    {
        $multiplicity = 1;
        foreach ($this->hronosDays as $key => $hronosDay) {

            if ($key == 1) { continue; }

            $lastHronos = $this->hronosDays[$key-1];
            $currentHronos = $this->hronosDays[$key];

            if ($this->isSameRows($lastHronos, $currentHronos)) {
                $multiplicity++;
                $currentHronos->multiplicity = $multiplicity;

                // edit dayRender
                if ($multiplicity == 2) {
                    $currentHronos->currentDayRender = (string) $lastHronos->currentDayRender
                        . '-' . $currentHronos->currentDayRender;
                } else {
                    $currentHronos->currentDayRender = explode('-', $lastHronos->currentDayRender)[0]
                        . '-' . $currentHronos->currentDayRender;
                }

                unset($this->hronosDays[$key-1]);

            } else {
                $multiplicity = 1;
            }

            $currentHronos->currentDayRender = $currentHronos->currentDayRender
                . ' (' . date('D', $currentHronos->currentUnixTime) . ') ';
        }
    }

    public function isSameRows($lastHronos, $currentHronos)
    {
        if (count($currentHronos->hronosDayItems) == count($lastHronos->hronosDayItems)) {
            foreach ($currentHronos->hronosDayItems as $key => $value) {
                if ($currentHronos->hronosDayItems[$key]->transId == $lastHronos->hronosDayItems[$key]->transId) {

                    return true;
                } else {

                    return false;
                }
            }
        }

        return false;
    }
}
