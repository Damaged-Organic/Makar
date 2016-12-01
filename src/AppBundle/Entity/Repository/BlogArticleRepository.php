<?php
// src/AppBundle/Entity/Repository/BlogArticleRepository.php
namespace AppBundle\Entity\Repository;

use DateTime;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Query;

class BlogArticleRepository extends EntityRepository
{
    public function find($id)
    {
        //TODO: This is kludge for Sonata
        $id = ( is_array($id) ) ? $id['id'] : $id;

        $query = $this->createQueryBuilder('blogArticle')
            ->select('blogArticle')
            ->where('blogArticle.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }

    public function findActiveBlogArticles($maxResults, $firstResult = 0)
    {
        $query = $this->createQueryBuilder('blogArticle')
            ->select('blogArticle')
            ->where('blogArticle.isActive = :isActive')
            ->orderBy('blogArticle.date', 'DESC')
            ->setMaxResults($maxResults)
            ->setFirstResult($firstResult)
            ->setParameter('isActive', TRUE)
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function search($searchString)
    {
        $searchString = explode(" ", $searchString);

        $query = $this->createQueryBuilder('blogArticle')
            ->select('blogArticle');

        foreach($searchString as $searchKey => $searchWord) {
            $query
                ->orWhere('blogArticle.title LIKE :keyword'.$searchKey )
                ->orWhere('blogArticle.content LIKE :keyword'.$searchKey )
                ->setParameter('keyword'.$searchKey, '%'.$searchWord.'%')
            ;
        }

        $query = $query->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}
