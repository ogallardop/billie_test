<?php


use App\Domain\TimeSync\EarthTime;
use App\Domain\TimeSync\EarthTimeSync;
use App\Domain\TimeSync\MarsTimeCalculator;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class EarthTimeSyncTest extends TestCase
{

    private Prophet $prophet;

    protected function setUp(): void
    {
        $this->prophet = new Prophet;
    }

    public function testSyncFailed()
    {
        $marsTimeCalculator = $this->prophet->prophesize(MarsTimeCalculator::class);
        $earthTime = $this->prophet->prophesize(EarthTime::class);

        $sync = new EarthTimeSync($marsTimeCalculator->reveal(),  $earthTime->reveal());

        $this->expectExceptionMessage('Date "2020-06-25" is invalid or does not match format "Y-m-d\TH:i:sP');

        $sync->sync('2020-06-25');

        $marsTimeCalculator->getMarsTimeFromEarth($earthTime)->shouldNotBeCalled();
    }

    public function testSyncSucceed()
    {
        $this->expectNotToPerformAssertions();

        $marsTimeCalculator = $this->prophet->prophesize(MarsTimeCalculator::class);
        $earthTime = $this->prophet->prophesize(EarthTime::class);
        $sync = new EarthTimeSync($marsTimeCalculator->reveal(),  $earthTime->reveal());

        $marsTimeCalculator->getMarsTimeFromEarth($earthTime)->shouldBeCalled();

        $sync->sync('2020-06-22T11:20:22-02:00');
    }
}
