<?php
// src/AppBundle/Entity/Repository/AlbumRepository.php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Query;

class AlbumRepository extends EntityRepository
{
    public function findOrderedByYear()
    {
        $query = $this->createQueryBuilder('album')
            ->select('album, albumSong')
            ->leftJoin('album.albumSongs', 'albumSong')
            ->orderBy('album.year', "DESC")
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}
