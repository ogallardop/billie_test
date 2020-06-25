<?php

namespace App\Domain\TimeSync;

class MarsTimeCalculator
{
    private MarsTime $marsTime;
    private const TAI_OFFSET = 37;

    public function __construct(MarsTime $marsTime)
    {
        $this->marsTime = $marsTime;
    }

    public function getMarsTimeFromEarth(EarthTime $earthTime)
    {
        $msd = $this->msd(
            $earthTime->getDate()->getTimestamp(),
        );

        $this->marsTime->setMsd($msd);
        $this->marsTime->setMtc($this->mtc($msd));

        return $this->marsTime;
    }

    private function msd($timestamp)
    {
        $millis = round($timestamp * 1000);
        $taiOffset = self::TAI_OFFSET;
        $jdUt = 2440587.5 + ($millis / 8.64E7);
        $jdTt = $jdUt + ($taiOffset + 32.184) / 86400;
        $j2000 = $jdTt - 2451545.0;
        return ((($j2000 - 4.5) / 1.027491252) + 44796.0 - 0.00096);
    }

    private function mtc($msd)
    {
        $first = 24 * $msd;
        return fmod($first, 24);
    }
}