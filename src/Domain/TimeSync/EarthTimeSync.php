<?php

namespace App\Domain\TimeSync;

use Assert\Assertion;
use DateTimeInterface;

class EarthTimeSync
{
    const FORMAT = DateTimeInterface::RFC3339;

    private MarsTimeCalculator $marsTimeCalculator;
    private EarthTime $earthTime;

    public function __construct(MarsTimeCalculator $marsTimeCalculator, EarthTime $earthTime)
    {
        $this->marsTimeCalculator = $marsTimeCalculator;
        $this->earthTime = $earthTime;
    }

    public function sync(string $date) : ?MarsTime
    {
        Assertion::date($date, self::FORMAT);
        $this->earthTime->setDate($date);

        return $this->marsTimeCalculator->getMarsTimeFromEarth($this->earthTime);
    }
}