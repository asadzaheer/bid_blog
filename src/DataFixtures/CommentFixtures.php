<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Badcow\LoremIpsum\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $generator = new Generator();
    $paragraphs = $generator->getParagraphs(20);

    for ($i = 0; $i < 20; $i++) {
      $random = rand(0, 9);
      $post = 'post.' . $random;
      $comment = new Comment();
      $comment->setPost($this->getReference($post));
      $comment->setContent($paragraphs[$i]);
      $manager->persist($comment);
    }

    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      PostFixtures::class,
    ];
  }
}
