<?php

namespace App\Controller;


use App\Entity\MonitorHistory;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ServerController extends Controller
{
    /**
     * @Route("/server-manager", name="server_manager")
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find(1);

        $lastServersMonitorStates = [];
        foreach ($user->getServers() as $server) {
            $lastServersMonitorStates[] = $this->get('wm.monitor_history')->getLastMonitorHistory($server);
        }

        return $this->render('server/index.html.twig', [
            'monitorStates' => $lastServersMonitorStates,
        ]);
    }

}