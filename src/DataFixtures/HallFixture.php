<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hall;

class HallFixture extends Fixture
{
    public const HALL_REFERENCE = 'hall';

    public function load(ObjectManager $manager): void
    {
        $hall = new Hall();
        $hall->setName('Tony-Garnier')
                ->setCapacity(3000)
                ->setAvailable(1)
                ->setAddress('20 Pl. Docteurs Charles et Christophe Mérieux')
                ->setCity('Lyon 69007');

        $manager->persist($hall);

        $this->addReference(self::HALL_REFERENCE, $hall);
        $manager->flush();
    }
}
