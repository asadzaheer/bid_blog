<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Badcow\LoremIpsum\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $generator = new Generator();
    $words = $generator->getWords(10);
    $paragraphs = $generator->getParagraphs(10);

    for ($i = 0; $i < 10; $i++) {
      $random = rand(1, 4);
      $author = 'author.' . $random;
      $post = new Post();
      $post->setAuthor($this->getReference($author));
      $post->setTitle($words[$i]);
      $post->setContent($paragraphs[$i]);
      $manager->persist($post);
      $this->addReference('post.' . $i, $post);
    }

    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      AuthorFixtures::class,
    ];
  }
}
