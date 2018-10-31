<?php

namespace App\Controller;


use App\Entity\MonitorHistory;
use App\Entity\Server;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        return $this->render('dashboard/index.html.twig', array());
    }

    /**
     * @Route("/create-user/{name}/{email}/{password}", name="dashboard_create_user")
     * @param Request $email
     * @param Request $password
     * @return Response
     */
    public function createUserAction(UserPasswordEncoderInterface $encoder, $name, $email,$password) {
        $user = new User();
        $user->setName($name);
        $user->setSalt(sha1(time()));
        $user->setEmail($email);
        $user->setUsername($email);
        $user->setPlainPassword($password);
        $encodedPassword = $encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($encodedPassword);
        $user->setRoles(["ROLE_ADMIN"]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('User created succesfull!', 200);
    }

    /**
     * @Route("/create-monitor-history", name="dashboard_create_monitor_history")
     */
    public function createMonitorHistoryAction() {
        $em = $this->getDoctrine()->getManager();
        $monitor = new MonitorHistory();
        $server = $em->getRepository(Server::class)->find(1);
        $monitor->setServer($server);
        $monitor->setServerStatus("down");
        $monitor->setResponseCode(500);
        $monitor->setLoadTime(4.9);

        $em->persist($monitor);
        $em->flush();

        return new Response('Monitor history created!', 200);
    }
}