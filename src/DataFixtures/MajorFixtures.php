<?php

namespace App\DataFixtures;

use App\Entity\Major;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MajorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $major = new Major;
        $major->setName("Bussiness");
        $major->setDescription("A business major is for students seeking a broad-based education.");
        $major->setQuantity("20");
        $major->setImage("https://www.thebalancecareers.com/thmb/8V0cBPmvnA6tspcKd4D9bg96MaE=/1500x1000/filters:fill(auto,1)/best-jobs-for-business-majors-2059628-v2-bc12c4996d7442c5bb31cdf4c8582ba5.png");
        $manager->persist($major);

        $manager->flush();
    }
}
