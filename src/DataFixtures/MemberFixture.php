<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Member;
use App\DataFixtures\BandFixture;
/*
 * Class MemberFixture
*/
class MemberFixture extends Fixture
{
    public const MEMBER_REFERENCE = 'member';

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i<10; $i++){
            $member = new Member();
            $member->setName('Requena'.$i)
                    ->setFirstName('Tommy'.$i)
                    ->setJob('Guitariste')
                    ->setBirthDate(\DateTime::createFromFormat('d-m-Y', '17-12-2001'))
                    ->setPicture('test.png');
            $member->setBand($this->getReference(BandFixture::BAND_REFERENCE));

            $manager->persist($member);
        }

        $this->addReference(self::MEMBER_REFERENCE, $member);
        $manager->flush();
    }
}
