<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class userFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $user = new user();
            $user->setNickname($faker->userName());
            $user->setEmail($faker->email());
            $password = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $user = new user();
        $user->setNickname($faker->userName());
        $user->setEmail('admin@admin.com');
        $password = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new user();
        $user->setNickname($faker->userName());
        $user->setEmail('user@user.com');
        $password = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        for ($i = 0; $i < 20; $i++) {
            $artist = new Artist();
            $artist->setNickname($faker->userName());
            $artist->setEmail($faker->email());
            $password = $this->hasher->hashPassword($artist, 'password');
            $artist->setPassword($password);
            $artist->setRoles(['ROLE_ARTIST']);
            $artist->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
            $artist->setUrlProfilPicture("https://www.stevensegallery.com/400/600");
            $manager->persist($artist);
        }

        $manager->flush();
    }
}
