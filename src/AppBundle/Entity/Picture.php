<?php
// src/AppBundle/Entity/Picture.php
namespace AppBundle\Entity;

use DateTime;

use Symfony\Component\Validator\Constraints as Assert,
    Symfony\Component\HttpFoundation\File\File;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo,
    Gedmo\Translatable\Translatable;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

use AppBundle\Entity\Utility\DoctrineMapping\IdMapper;

/**
 * @ORM\Table(name="pictures")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PictureRepository")
 *
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\PictureTranslation")
 *
 * @Vich\Uploadable
 */
class Picture implements Translatable
{
    const WEB_PATH = "/images/pictures/";

    use IdMapper;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\OneToMany(targetEntity="PictureTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $year;

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "image/gif"}
     * )
     *
     * @Vich\UploadableField(mapping="picture", fileNameProperty="pictureName")
     */
    protected $pictureFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $pictureName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

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

    public function addTranslation(PictureTranslation $t)
    {
        $this->translations->add($t);
        $t->setObject($this);
    }

    public function removeTranslation(PictureTranslation $t)
    {
        $this->translations->removeElement($t);
    }

    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    public function setPictureFile($pictureFile = NULL)
    {
        $this->pictureFile = $pictureFile;

        if( $pictureFile instanceof File )
            $this->updatedAt = new DateTime;
    }

    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    public function getPicturePath()
    {
        return ( $this->pictureName )
            ? self::WEB_PATH.$this->pictureName
            : FALSE;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Picture
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
     * Set year
     *
     * @param string $year
     * @return Picture
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set pictureName
     *
     * @param string $pictureName
     * @return Picture
     */
    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;

        return $this;
    }

    /**
     * Get pictureName
     *
     * @return string 
     */
    public function getPictureName()
    {
        return $this->pictureName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Album
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
