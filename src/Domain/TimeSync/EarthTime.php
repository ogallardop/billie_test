<?php

namespace App\Domain\TimeSync;
use DateTimeImmutable;
use DateTimeZone;

class EarthTime
{
    private DateTimeImmutable $date;

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = new DateTimeImmutable($date, new DateTimeZone("UTC"));
    }
}