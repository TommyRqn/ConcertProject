<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Concert;
use App\DataFixtures\BandFixture;
use App\DataFixtures\MemberFixture;
use App\DataFixtures\HallFixture;
use App\DataFixtures\ConcertHallFixture;
use App\DataFixtures\UserFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ConcertFixture extends Fixture implements DependentFixtureInterface
{
    public const CONCERT_REFERENCE = 'concert';

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i<10; $i++){
            $concert = new Concert();
            $concert->setDate(\DateTime::createFromFormat('d-m-Y', '15-08-202'.$i))
                    ->setTourName('Tournée');
            $concert->setHall($this->getReference(HallFixture::HALL_REFERENCE));
            $concert->setBand($this->getReference(BandFixture::BAND_REFERENCE));

            $manager->persist($concert);
        }

        $this->addReference(self::CONCERT_REFERENCE, $concert);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            BandFixture::class,
            MemberFixture::class,
            HallFixture::class,
            ConcertHallFixture::class,
            UserFixture::class,
        ];
    }
}
