<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artist;
use App\Entity\ArtCard;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtCardFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 300; $i++) {
            $artCard = new artCard();
            $artCard->setTitle($faker->word());
            $picture = $faker->randomElement([
                '_fixtures_art_1',
                '_fixtures_art_2',
                '_fixtures_art_3',
            ]);
            $artCard->setPictureArt($picture);
            $artCard->setDescription($faker->paragraph(5));
            $artCard->setCity($faker->city());
            $artCard->setCreateAt($faker->dateTimeBetween('-5 week', '-1 week'));
            $artCard->setPending($faker->boolean(chanceOfGettingTrue: 50));
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
