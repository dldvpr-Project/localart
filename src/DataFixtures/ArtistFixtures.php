<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class ArtistFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $artist = new Artist();
        $artist->setNickname('artist');
        $artist->setEmail('artist@artist.com');
        $password = $this->hasher->hashPassword($artist, 'password');
        $artist->setPassword($password);
        $artist->setRoles(['ROLE_ARTIST']);
        $artist->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
        $artist->setUrlProfilPicture("https://baconmockup.com/400/600/");
        $this->addReference('artist_0', $artist);
        $manager->persist($artist);


        for ($i = 1; $i < 20; $i++) {
            $artist = new Artist();
            $artist->setNickname($faker->userName());
            $artist->setEmail($faker->email());
            $password = $this->hasher->hashPassword($artist, 'password');
            $artist->setPassword($password);
            $artist->setRoles(['ROLE_ARTIST']);
            $artist->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
            $artist->setUrlProfilPicture("https://baconmockup.com/400/600/");
            $this->addReference('artist_' . $i, $artist);
            $manager->persist($artist);

        }
        $manager->flush();
    }
}
