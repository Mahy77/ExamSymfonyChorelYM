<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article-> setTitle('Une énorme lune');
        $article-> setDescription('Une énorme lune est apparue dans le ciel cet après-midi!!');
        $article-> setImage('montagne-5f4cbb34d8e75.jpeg');
        $manager->persist($article);

        $manager->flush();
    }
}
