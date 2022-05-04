<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=5; $i++) {
            $student = new Student;
            $student->setName("Student $i");
            $student->setAge(rand(18,30));
            $student->setImage("https://cdn5.vectorstock.com/i/1000x1000/54/34/a-student-boy-cartoon-character-isolated-on-white-vector-36115434.jpg");
            $student->setDob(\DateTime::createFromFormat('Y-m-d','2022-02-08'));
            $student->setEmail("abc@fpt.edu.vn");
            $student->setAddress("abc");
            $manager->persist($student);
        }

        $manager->flush();
    }
}
