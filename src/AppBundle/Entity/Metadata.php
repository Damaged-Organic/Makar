<?php
// src/AppBundle/Entity/Metadata.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo,
    Gedmo\Translatable\Translatable;

use AppBundle\Entity\Utility\DoctrineMapping\IdMapper,
    AppBundle\Entity\MetadataTranslation;

/**
 * @ORM\Table(name="metadata")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\MetadataRepository")
 *
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\MetadataTranslation")
 */
class Metadata implements Translatable
{
    use IdMapper;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\OneToMany(targetEntity="MetadataTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $route;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=1023, nullable=true)
     *
     * @Gedmo\Translatable
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $robots;

    /**
     * Constructor
     */
    public function __construct()
    {
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

    public function addTranslation(MetadataTranslation $t)
    {
        $this->translations->add($t);
        $t->setObject($this);
    }

    public function removeTranslation(MetadataTranslation $t)
    {
        $this->translations->removeElement($t);
    }

    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Metadata
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Metadata
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
     * Set description
     *
     * @param string $description
     * @return Metadata
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set robots
     *
     * @param string $robots
     * @return Metadata
     */
    public function setRobots($robots)
    {
        $this->robots = $robots;

        return $this;
    }

    /**
     * Get robots
     *
     * @return string
     */
    public function getRobots()
    {
        return $this->robots;
    }
}
