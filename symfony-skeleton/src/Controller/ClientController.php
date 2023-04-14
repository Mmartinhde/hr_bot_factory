<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ClientController extends AbstractController
{

    // /**
    //  * @Route("/clients", name="clients")
    //  * 
    //  */
    // public function clientList(EntityManagerInterface $doctrine)
    // {
    //     $clientList = $doctrine->getRepository(Client::class);

    //     $client = $clientList->findAll();

    //     return $this->render("client.html.twig",
    //     ['client' => $client]);
    // }

}