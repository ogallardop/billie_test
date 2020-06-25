<?php

namespace App\Controller;

use App\Domain\TimeSync\EarthTime;
use App\Domain\TimeSync\EarthTimeSync;
use App\Domain\TimeSync\MarsTime;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TimeSyncController implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $earthDate = $request->get("date");

        /** @var EarthTimeSync $timeSync */
        $timeSync = $this->container->get('time_sync');

        $marsTime = $timeSync->sync($earthDate);
        return new JsonResponse(
            [
                'msd' => $marsTime->getMsd(),
                'mtc' => $marsTime->formatMtc(),
            ],
        );
    }
}