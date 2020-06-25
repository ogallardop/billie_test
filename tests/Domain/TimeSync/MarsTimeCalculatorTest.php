<?php

use App\Domain\TimeSync\MarsTimeCalculator;
use \App\Domain\TimeSync\MarsTime;
use \App\Domain\TimeSync\EarthTime;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;


class MarsTimeCalculatorTest extends TestCase
{

    private Prophet $prophet;

    protected function setUp(): void
    {
        $this->prophet = new Prophet;
    }

    /**
     * @dataProvider calculationData
     */
    public function testCalculation($date, $mtc, $msd, $msdFormat)
    {
        $earthTime = new EarthTime();
        $earthTime->setDate($date);

        $calculator = new MarsTimeCalculator(new MarsTime());
        $marsTime = $calculator->getMarsTimeFromEarth($earthTime);

        $this->assertEquals($mtc, $marsTime->getMtc());
        $this->assertEquals($msd, $marsTime->getMsd());
        $this->assertEquals($msdFormat, $marsTime->formatMtc());
    }

    public function calculationData()
    {
        return [
            ['2020-06-22T11:20:22-02:00', '14.289143284084', '52069.59538097', '14:17:21'],
            ['2020-01-01T11:20:22-02:00', '5.3788270959631', '51901.224117796', '05:22:44'],
            ['2020-12-31T23:59:59-02:00', '23.320401496487', '52256.971683396', '23:19:13'],
            ['2020-06-25T00:00:00-02:00', '1.3266829634085', '52072.055278457', '01:19:36'],
        ];
    }
}
