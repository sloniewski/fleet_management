<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            ['email' => 'admin@fleet.com', 'password' => 'admin', 'role' => 'ROLE_ADMIN'],
            ['email' => 'user@fleet.com', 'password' => 'user']
        ];

        foreach($users as $user_data) {
            $user = new User();
            $user->setEmail($user_data['email']);
            $user->setPassword(
                $this->passwordEncoder->encodePassword($user, $user_data['password'])
            );
            if(array_key_exists('role', $user_data)) $user->addRole($user_data['role']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
