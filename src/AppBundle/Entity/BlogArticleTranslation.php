<?php
// src/AppBundle/Entity/BlogArticleTranslation.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="blog_articles_translations", indexes={
 *      @ORM\Index(name="blog_articles_translations_idx", columns={"locale", "object_id", "field"})
 * })
 */
class BlogArticleTranslation extends AbstractPersonalTranslation
{
    public function __construct($locale = NULL, $field = NULL, $content = NULL)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($content);
    }

    /**
     * @ORM\ManyToOne(targetEntity="BlogArticle", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $object;
}
