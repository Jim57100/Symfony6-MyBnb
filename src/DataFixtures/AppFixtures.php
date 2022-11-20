<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i = 1; $i <= 30; $i++) {

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 350, '1000x350', false, null, true);
            $city = $faker->city();
            $introduction = $faker->paragraph(2);
            $content = '<p>' . $faker->realText($faker->numberBetween(150, 250)) . '</p>';


            $ad = (new Ad())
            ->setTitle($title)
            ->setCoverImage($coverImage)
            ->setIntroduction($introduction)
            ->setContent($content)
            ->setPrice(mt_rand(40, 200))
            // ->setCity($city);
            ->setRooms(mt_rand(1, 3));

            for($j = 1; $j <= mt_rand(2,5); $j++) {
                $image = (new Image())
                    ->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);    
            }

            $manager->persist($ad);
        }

            

        $manager->flush();
    }
}
