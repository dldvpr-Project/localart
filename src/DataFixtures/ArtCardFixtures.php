<?php

namespace App\DataFixtures;

use App\Entity\ArtCard;
use App\Entity\Artist;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArtCardFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 300; $i++) {
            $artCard = new artCard();
            $artCard->setTitle($faker->word());
            $artCard->setPictureArt('https://via.placeholder.com/400');
            $artCard->setDescription($faker->paragraph(5));
            $artCard->setCity($faker->city());
            $artCard->setCreateAt($faker->dateTimeBetween('-5 week', '-1 week'));
            $reference = $faker->numberBetween(0, 19);
            $artist = $this->getReference('artist_' . $reference);
            if ($artist instanceof Artist) {
                $artCard->setUser($artist);
            }
            $manager->persist($artCard);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return
            [
                UserFixtures::class,
            ];
    }
}
