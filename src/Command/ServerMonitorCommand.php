<?php

namespace App\Command;

use App\Entity\MonitorHistory;
use App\Entity\ResponseCode;
use App\Entity\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServerMonitorCommand extends Command
{
    protected $container;
    protected $em;

    public function __construct($name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('wallbox:monitor:run')

            // the short description shown while running "php bin/console list"
            ->setDescription('Monitor each defined server.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Monitor each defined server in order to alert when downtime is detected.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $servers = $this->em->getRepository(Server::class)->findBy([
            'isDisabled' => false,
        ]);

        /** @var Server $server */
        foreach($servers as $server) {
            $lastStatusVerification  = date_create($server->getLastStatusVerification()->format('Y-m-d H:i:s'));
            $now = date_create(); // Current time and date
            $diff  	= date_diff( $lastStatusVerification, $now);

            // If it's not time to execute monitor for this server, then continue.
            if ($diff->i < $server->getCheckEvery()) {
                continue;
            }

            // Set Monitor history
            $this->setMonitorHistory($this->checkResponse($this->checkServer($server->getUrl()), $server));

            // Update server last status verification.
            $server->setLastStatusVerification(date_create());
            $this->em->persist($server);
            $this->em->flush();
        }
    }

    protected function checkResponse(int $serverResponseCode, Server $server)
    {
        $responseCodes = $this->em->getRepository(ResponseCode::class)->findBy([
            'user' => $server->getOwner()->getId(),
            'code' => $serverResponseCode
        ]);

        $response = new \stdClass();
        $response->server = $server;
        $response->responseCode = $serverResponseCode;
        if (!empty($responseCodes)) {
            $response->serverStatus = 'up';
            $response->loadTime = $this->getLoadTime($server);

        } else {
            $response->serverStatus = 'down';
            $response->loadTime = 0;
        }

        return $response;
    }

    protected function setMonitorHistory(\stdClass $response)
    {
        $monitorHistory = new MonitorHistory();
        $monitorHistory->setServer($response->server);
        $monitorHistory->setResponseCode($response->responseCode);
        $monitorHistory->setServerStatus($response->serverStatus);
        $monitorHistory->setLoadTime($response->loadTime);

        $this->em->persist($monitorHistory);
        $this->em->flush();
    }

    protected function checkServer($url) : int
    {
        $ch = curl_init();

        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
        );
        curl_setopt_array( $ch, $options );
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $httpCode;
    }

    public function getLoadTime(Server $server) {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $start = $time;
        $url = file_get_contents($server->getUrl());
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;

        return round(($finish - $start), 2);
    }

}