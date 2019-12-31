<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $users = [
            ['email' => 'admin@fleet.com', 'password' => 'admin'],
            ['email' => 'user@fleet.com', 'password' => 'user']
        ];

        foreach($users as $user_data) {
            $user = new User();
            $user->setEmail($user_data['email']);
            $user->setPassword($user_data['password']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
