<?php

namespace App\Domain\TimeSync;

class MarsTime
{
    private string $msd;
    private string $mtc;

    public function getMsd(): string
    {
        return $this->msd;
    }

    public function setMsd(string $msd): void
    {
        $this->msd = $msd;
    }

    public function getMtc(): string
    {
        return $this->mtc;
    }

    public function setMtc(string $mtc): void
    {
        $this->mtc = $mtc;
    }

    public function formatMtc()
    {
        $x = $this->mtc * 3600;
        $hh = floor($x / 3600);
        if ($hh < 10) $hh = "0" . $hh;
        $y = fmod($x, 3600);

        $mm = floor($y / 60);
        if ($mm < 10) $mm = "0" . $mm;

        $ss = round(fmod($y, 60));
        if ($ss < 10) $ss = "0" . $ss;
        return $hh . ":" . $mm . ":" . $ss;
    }
}