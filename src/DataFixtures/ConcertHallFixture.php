<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ConcertHall;
use App\DataFixtures\HallFixture;

class ConcertHallFixture extends Fixture
{
    public const CONCERT_HALL_REFERENCE = 'concert-hall';

    public function load(ObjectManager $manager): void
    {
        $concertHall = new ConcertHall();
        $concertHall->setName('Tony')
                    ->setTotalPlaces(1500)
                    ->setPresentation('Nouvelle hall');
        $concertHall->setHall($this->getReference(HallFixture::HALL_REFERENCE));

        $manager->persist($concertHall);
        
        $this->addReference(self::CONCERT_HALL_REFERENCE, $concertHall);
        $manager->flush();
    }

    
}
