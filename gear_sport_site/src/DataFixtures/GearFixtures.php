<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Gear;
use App\Entity\Category;
use App\Entity\Sport;
use App\Entity\SportCategory;

class GearFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for($i = 1; $i <=3; $i++){
            $category = new Category();
            $category->setName($faker->word());

            $manager->persist($category);
        }


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
