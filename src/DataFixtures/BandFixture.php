<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Band;

/*
 * Class BandFixture
*/
class BandFixture extends Fixture
{
    public const BAND_REFERENCE = 'band';

    public function load(ObjectManager $manager): void
    {
        $band = new Band();
        $band->setName('KEKW')
                ->setStyle('Rap')
                ->setPicture('test.png')
                ->setYearOfCreation(\DateTime::createFromFormat('d-m-Y', '17-12-2021'))
                ->setLastAlbumName('Ui');

        $manager->persist($band);
        
        $this->addReference(self::BAND_REFERENCE, $band);
        $manager->flush();
    }
}

