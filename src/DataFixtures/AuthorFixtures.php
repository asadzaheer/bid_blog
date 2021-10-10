<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $author1 = new Author();
    $author1->setName('Asad');
    $manager->persist($author1);
    $this->addReference('author.1', $author1);

    $author2 = new Author();
    $author2->setName('Imran');
    $manager->persist($author2);
    $this->addReference('author.2', $author2);

    $author3 = new Author();
    $author3->setName('Ali');
    $manager->persist($author3);
    $this->addReference('author.3', $author3);

    $author4 = new Author();
    $author4->setName('kamran');
    $manager->persist($author4);
    $this->addReference('author.4', $author4);

    $manager->flush();
  }
}
