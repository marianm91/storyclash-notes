<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user_reference';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->name);
            $user->setAvatar($faker->imageUrl(100, 100, 'people', true, 'Faker'));

            $manager->persist($user);

            $this->addReference(self::USER_REFERENCE . $i, $user);
        }

        $manager->flush();
    }
}
