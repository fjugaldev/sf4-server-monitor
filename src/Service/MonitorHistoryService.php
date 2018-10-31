<?php

namespace App\Service;


use App\Entity\Server;
use App\Entity\MonitorHistory;
use Doctrine\ORM\EntityManager;

class MonitorHistoryService
{
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function getLastMonitorHistory(Server $server) {
        return [
            "lastStatus" => $this->manager->getRepository(MonitorHistory::class)->getLastMonitorHistory($server->getId()),
            "uptime"     => $this->getUptime($server)
        ];
    }
    protected function getUptime(Server $server) {
        $todayHistory = $this->manager->getRepository(MonitorHistory::class)->getTodayMonitorHistory($server->getId());
        dump($todayHistory);die();
        return 88;
    }

}