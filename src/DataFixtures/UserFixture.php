<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public $passwordHasher;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->passwordHasher = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $plaintextPassword = 'admin';
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            $plaintextPassword
        );
        $admin->setFirstName('Tommy')
                ->setLastName('REQUENA')
                ->setEmail('tommy.requena69@gmail.com')
                ->setPassword($hashedPassword)
                ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $user = new User();
        $plaintextPassword = 'user';
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setFirstName('Tommy')
                ->setLastName('REQUENA')
                ->setEmail('tommy@gmail.com')
                ->setPassword($hashedPassword)
                ->setRoles(['ROLE_USER']);

        $manager->persist($user);

        $manager->flush();
    }
}
