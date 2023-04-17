<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class ClientFixture extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
         $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $letter = "A";
        for ( $i=0; $i < 3; $i++) {

            $client = new Client();
            $client->setEmail('client'.$i.'@hrweb.com');

            $password = $this->encoder->encodePassword($client, 'pass_1234');
            $client->setPassword($password);
            $client->setUsername('client'.''.$letter++);
            $client->setRoles(['ROLE_USER']);
            $client->setClientName('Cliente' . ' ' . $letter++);

            $manager->persist($client);
            $manager->flush();
        }
    }
}
