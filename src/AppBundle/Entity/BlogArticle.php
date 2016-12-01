<?php
// src/AppBundle/Entity/BlogArticle.php
namespace AppBundle\Entity;

use DateTime;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo,
    Gedmo\Translatable\Translatable;

use AppBundle\Entity\Utility\ErrorHandlerTrait,
    AppBundle\Entity\Utility\DoctrineMapping\IdMapper,
    AppBundle\Entity\Utility\DoctrineMapping\SlugMapper,
    AppBundle\Entity\BlogArticleTranslation,
    AppBundle\Entity\BlogArticleUploadedFile;

/**
 * @ORM\Table(name="blog_articles")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BlogArticleRepository")
 *
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\BlogArticleTranslation")
 */
class BlogArticle implements Translatable
{
    use ErrorHandlerTrait;

    use IdMapper,
        SlugMapper;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\OneToMany(targetEntity="BlogArticleTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    protected $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=false)
     *
     * @Gedmo\Translatable
     */
    protected $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $rawContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $contentFormatter;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $views;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    /**
     * @ORM\OneToMany(targetEntity="BlogArticleUploadedFile", mappedBy="object", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $uploadedFile;

    /**
     * @ORM\Column(type="string", length=511, nullable=true)
     */
    protected $videoLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $videoId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this
            ->setIsActive(TRUE)
            ->setDate(new DateTime("NOW"))
        ;

        $this->translations = new ArrayCollection;
    }

    /**
     * To string
     */
    public function __toString()
    {
        return ( $this->title ) ? $this->title : "";
    }

    /**
     * Set Gedmo locale
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(BlogArticleTranslation $t)
    {
        $this->translations->add($t);
        $t->setObject($this);
    }

    public function removeTranslation(BlogArticleTranslation $t)
    {
        $this->translations->removeElement($t);
    }

    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return BlogArticle
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlogArticle
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BlogArticle
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getContentShort($length)
    {
        return explode('#', wordwrap(strip_tags($this->content), $length, "#"))[0] . " ...";
    }

    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    }

    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
    }

    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return BlogArticle
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    public function incrementViews()
    {
        $this->views++;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return BlogArticle
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add uploadedFile
     *
     * @param BlogArticleUploadedFile $uploadedFile
     * @return $this
     */
    public function addUploadedFile(BlogArticleUploadedFile $uploadedFile)
    {
        $uploadedFile->setObject($this);
        $this->uploadedFile[] = $uploadedFile;

        return $this;
    }

    /**
     * Remove uploadedFile
     *
     * @param BlogArticleUploadedFile $uploadedFile
     */
    public function removeUploadedFile(BlogArticleUploadedFile $uploadedFile)
    {
        $this->uploadedFile->removeElement($uploadedFile);
    }

    /**
     * Get uploadedFile
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    public function setVideoLink($videoLink)
    {
        $this->videoLink = $videoLink;

        $this->setVideoId($this->videoLink);

        return $this;
    }

    public function getVideoLink()
    {
        return $this->videoLink;
    }

    public function setVideoId($videoLink)
    {
        $this->videoId = ( preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoLink, $match) )
            ? $match[1]
            : NULL;

        return $this;
    }

    public function getVideoId()
    {
        return $this->videoId;
    }
}
