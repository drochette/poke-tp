<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppUserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@example.fr');
        $user->setPassword($this->userPasswordHasher->hashPassword(new User(), 'password_user'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $userAdmin = new User();
        $userAdmin->setEmail('admin@example.fr');
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword(new User(), 'password_admin'));
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($userAdmin);

        $manager->flush();
    }
}
