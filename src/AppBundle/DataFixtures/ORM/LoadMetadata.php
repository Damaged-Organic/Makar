<?php
// src/AppBundle/DataFixtures/ORM/LoadMetadata.php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Metadata;

class LoadMetadata extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $metadata = (new Metadata)
            ->setRoute("index")
            ->setRobots("index, follow")
            ->setTitle("Главная")
            ->setDescription("Добро пожаловать на личный сайт Андрея Вадимовича Макаревича. Здесь вы сможете узнать последние новости, расписание концертов, а также ознакомиться с его творчеством - музыкой, книгами и картинами. Приятного времяпрепровождения!");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Homepage")
            ->setDescription("Homepage description")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();

        // ---

        $metadata = (new Metadata)
            ->setRoute("events")
            ->setRobots("index, follow")
            ->setTitle("Афиша")
            ->setDescription("Расписание ближайших и предстоящих концертов Андрея Макаревича, покупка билетов на мероприятия.");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Events")
            ->setDescription("Events description")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();

        // ---

        $metadata = (new Metadata)
            ->setRoute("blog")
            ->setRobots("index, follow")
            ->setTitle("Блог")
            ->setDescription("Новости, мысли, события и анонсы непосредственно от Андрея Макаревича.");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Blog")
            ->setDescription("Blog description")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();

        // ---

        $metadata = (new Metadata)
            ->setRoute("music")
            ->setRobots("index, follow")
            ->setTitle("Музыка")
            ->setDescription("Основное направление творчества Андрея Макаревича - музыка, список сольных альбомов и записей с 'Машиной Времени', а также пластинки проектов 'Оркестр креольского танго', 'Джазовые Трансформации', 'ACAPELLA EXPRESSS' и прочих.");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Music")
            ->setDescription("Music description")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();

        // ---

        $metadata = (new Metadata)
            ->setRoute("books")
            ->setRobots("index, follow")
            ->setTitle("Книги")
            ->setDescription("Книги Андрея Макаревича, проза, рассказы, стихи, мемуары и воспоминания, коллекции, сборники, а также книги о кулинарии (в соавторстве с Марком Гарбером) и дайвинге (в соавторстве с Юрием Бельским).");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Books")
            ->setDescription("Books description")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();

        // ---

        $metadata = (new Metadata)
            ->setRoute("pictures")
            ->setRobots("index, follow")
            ->setTitle("Картины")
            ->setDescription("Изобразительное искусство авторства Андрея Макаревича, галерея картин и графики.");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Pictures")
            ->setDescription("Pictures description")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();

        // ---

        $metadata = (new Metadata)
            ->setRoute("biography")
            ->setRobots("index, follow")
            ->setTitle("Биография")
            ->setDescription("Биография Андрея Вадимовича Макаревича, советского и российского музыканта, певца, поэта, композитора, художника, продюсера, телеведущего, лидера и единственного бессменного участника рок-группы «Машина времени».");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Biography")
            ->setDescription("Biography description")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();

        // ---

        $metadata = (new Metadata)
            ->setRoute("feedback")
            ->setRobots("index, nofollow, noarchive")
            ->setTitle("Оставить сообщение")
            ->setDescription("Оставить личное сообщение для Андрея Макаревича");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Leave a message")
            ->setDescription("Feedback description")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();

        // ---

        $metadata = (new Metadata)
            ->setRoute("search")
            ->setRobots("index, nofollow, noarchive")
            ->setTitle("Найти что-то")
            ->setDescription("Поиск по личному блогу Андрея Макаревича");
        $manager->persist($metadata);
        $manager->flush();

        $metadata->setTitle("Find something")
            ->setDescription("Search description -- robots")
            ->setTranslatableLocale('en');
        $manager->persist($metadata);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
