<?php
// src/AppBundle/DataFixtures/ORM/LoadArticles.php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\BlogArticle;

class LoadArticles extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = (new BlogArticle)->setTitle('Это Ваша Жизнь')
            ->setContent('Это ваша жизнь и она уходит миг за мигом');

        $manager->persist($article);
        $manager->flush();

        $article->setTitle('This Is Your Life')
            ->setContent('This is your life, and it\'s ending one minute at a time')
            ->setTranslatableLocale('en');

        $manager->persist($article);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
