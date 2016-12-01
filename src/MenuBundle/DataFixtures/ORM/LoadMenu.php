<?php
// src/MenuBundle/DataFixtures/ORM/LoadMenu.php
namespace MenuBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use MenuBundle\Entity\Menu;

class LoadMenu extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $menuItem = (new Menu)
            ->setTitle("Главная")
            ->setRoute("index");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Homepage")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();

        // ---

        $menuItem = (new Menu)
            ->setTitle("Афиша")
            ->setRoute("events");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Events")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();

        // ---

        $menuItem = (new Menu)
            ->setTitle("Блог")
            ->setRoute("blog");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Blog")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();

        // ---

        $menuItem = (new Menu)
            ->setTitle("Музыка")
            ->setRoute("music");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Music")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();

        // ---

        $menuItem = (new Menu)
            ->setTitle("Книги")
            ->setRoute("books");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Books")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();

        // ---

        $menuItem = (new Menu)
            ->setTitle("Музыка")
            ->setRoute("music");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Music")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();

        // ---

        $menuItem = (new Menu)
            ->setTitle("Книги")
            ->setRoute("books");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Books")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();

        // ---

        $menuItem = (new Menu)
            ->setTitle("Картины")
            ->setRoute("pictures");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Pictures")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();

        // ---

        $menuItem = (new Menu)
            ->setTitle("Биография")
            ->setRoute("biography");
        $manager->persist($menuItem);
        $manager->flush();

        $menuItem->setTitle("Biography")
            ->setTranslatableLocale('en');
        $manager->persist($menuItem);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
