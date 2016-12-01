<?php
// src/AppBundle/Entity/Repository/EventRepository.php
namespace AppBundle\Entity\Repository;

use DateTime;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Query;

class EventRepository extends EntityRepository
{
    public function findActiveEvents($maxResults, $firstResult = 0)
    {
        $query = $this->createQueryBuilder('event')
            ->select('event')
            ->where('event.datetime >= :now')
            ->andWhere('event.isActive = :isActive')
            ->orderBy('event.datetime', 'ASC')
            ->setMaxResults($maxResults)
            ->setFirstResult($firstResult)
            ->setParameters([
                'now'      => new DateTime("NOW"),
                'isActive' => TRUE
            ])
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}
