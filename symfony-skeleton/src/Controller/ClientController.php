<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\UserType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ClientController extends AbstractController
{

    //check clients list
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


    /**
     * @Route("/clients/users_list", name="users_list")
     */
    public function usersList(EntityManagerInterface $doctrine)
    {
        $client = $this->getUser()->getId();
        $users = $doctrine->getRepository(User::class);

        $usersClient = $users->findBy(array('client' => $client));
        //dump($usersClient) ; exit();
        return $this->render("users/userslist.html.twig",
                ['user' => $usersClient]);
    }

    /**
     * @Route("/clients/add-new_user", name="add_user")
     */
    public function addNewUser(Request $request, EntityManagerInterface $doctrine)
    {
        $client= $this->getUser(); //client conected

        $user = new User();
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isVAlid()) {
            $user = $form->getData();

            $user->setDateCreation(new DateTime('now'));
            $user->setClient($client);

            $doctrine->persist($user);
            $doctrine->flush();

            return $this->redirectToRoute('users_list');

        };

        return $this->render('users/add_user.html.twig', [
            'addUserForm' => $form->createView(),
        ]);

    }

    /**
     * @Route("/clients/user/edit/{id}", name="edit_user")
     */
    public function editUser($id, Request $request, EntityManagerInterface $doctrine)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        //dump($user);exit();
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $user->setDateUpdate(new DateTime('now'));

            $doctrine->persist($user);
            $doctrine->flush();
            
            return $this->redirectToRoute('users_list');

        }   

        return $this->render('users/edit_user.html.twig', [
                'editUserForm' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/clients/user/delete/{id}", name="delete_user")
     */
    public function deleteUser($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        // dump($user);exit();
        if ($user === null) {
            return $this->redirectToRoute('users_list');
        }

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->remove($user);
        $doctrine->flush();

        return $this->redirectToRoute('users_list');
    }


    // Users filter    

    /**
     * @Route("clients/users_list/filter", name="users_filter")
     */
    public function filterUsers(Request $request)
    {
        $client = $this->getUser()->getId();
        $userSearch = $request->query->get('userSearch',null);
        //dump($userSearch);exit();

        $users =  $this->getDoctrine()->getRepository(User::class)->getUsersByFilter($userSearch, $client);
         //dump($users);exit();
            return $this->render("users/userslist.html.twig",
            ['user' => $users]);
    }



            // // check if user save in database:
            // /**
            //  * @Route("/clients/add-user", name="add_user")
            //  */
            // public function addNewUser(EntityManagerInterface $doctrine)
            // {
            //     $client= $this->getUser(); //get id conected client
            //     //dump($client);exit();
            //     $user = new User();

            //     $user->setName('Nombre Usuario1');
            //     $user->setLastName('Apellidos');
            //     $user->setTown('Town');
            //     $user->setCategory('X');
            //     $user->setAge(20);
            //     $user->setActive(0);
            //     $user->setDateCreation(new DateTime('now'));
            //     $user->setDateUpdate(new DateTime('now'));
            //     $user->setClient($client);

            //     $doctrine->persist($user);
            //     $doctrine->flush();

            //     return $this->render('users/userslist.html.twig');
            // }


}