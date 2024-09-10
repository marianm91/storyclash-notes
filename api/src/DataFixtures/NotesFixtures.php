<?php

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\Reply;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class NotesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            for ($i = 0; $i < 10; $i++) {
                $note = new Note();
                $note->setContent($faker->sentence(10));

                // Assign random user from UserFixtures
                $randomUserReference = $this->getReference(UserFixtures::USER_REFERENCE . rand(0, 9));
                $note->setUser($randomUserReference);

                $manager->persist($note);

                if ($faker->boolean) {  // Some notes will have replies
                    for ($j = 0; $j < $faker->numberBetween(1, 5); $j++) {
                        $reply = new Reply();
                        $reply->setContent($faker->sentence(10));

                        // Assign random user from UserFixtures
                        $randomUserReference = $this->getReference(UserFixtures::USER_REFERENCE . rand(0, 9));
                        $reply->setUser($randomUserReference);

                        $reply->setParentNote($note); // Set parent note
                        $manager->persist($reply); // Make sure to persist the reply
                    }
                }
            }

            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
