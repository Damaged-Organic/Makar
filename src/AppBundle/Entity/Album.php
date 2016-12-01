<?php
// src/AppBundle/Entity/Album.php
namespace AppBundle\Entity;

use DateTime;

use Symfony\Component\Validator\Constraints as Assert,
    Symfony\Component\HttpFoundation\File\File;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo,
    Gedmo\Translatable\Translatable;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

use AppBundle\Entity\Utility\DoctrineMapping\IdMapper,
    AppBundle\Entity\Utility\DoctrineMapping\SlugMapper,
    AppBundle\Entity\AlbumTranslation,
    AppBundle\Entity\AlbumSong;

/**
 * @ORM\Table(name="albums")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AlbumRepository")
 *
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\AlbumTranslation")
 *
 * @Vich\Uploadable
 */
class Album implements Translatable
{
    const WEB_PATH = "/images/albums_covers/";

    use IdMapper,
        SlugMapper;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\OneToMany(targetEntity="AlbumTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @Assert\File(
     *     maxSize="2M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "image/gif"}
     * )
     *
     * @Vich\UploadableField(mapping="album_cover", fileNameProperty="coverName")
     */
    protected $coverFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $coverName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $year;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $songsNumber;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Gedmo\Translatable
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $rawContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $contentFormatter;

    /**
     * @ORM\Column(type="string", length=511, nullable=true)
     */
    protected $buyLink;

    /**
     * @ORM\OneToMany(targetEntity="AlbumSong", mappedBy="album", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $albumSongs;

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

    public function addTranslation(AlbumTranslation $t)
    {
        $this->translations->add($t);
        $t->setObject($this);
    }

    public function removeTranslation(AlbumTranslation $t)
    {
        $this->translations->removeElement($t);
    }

    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    public function setCoverFile($coverFile = NULL)
    {
        $this->coverFile = $coverFile;

        if( $coverFile instanceof File )
            $this->updatedAt = new DateTime;
    }

    public function getCoverFile()
    {
        return $this->coverFile;
    }

    public function getCoverPath()
    {
        return ( $this->coverName )
            ? self::WEB_PATH.$this->coverName
            : FALSE;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Album
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
     * Set coverName
     *
     * @param string $coverName
     * @return Album
     */
    public function setCoverName($coverName)
    {
        $this->coverName = $coverName;

        return $this;
    }

    /**
     * Get coverName
     *
     * @return string 
     */
    public function getCoverName()
    {
        return $this->coverName;
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

    /**
     * Set year
     *
     * @param \DateTime $year
     * @return Album
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set songsNumber
     *
     * @param integer $songsNumber
     * @return Album
     */
    public function setSongsNumber($songsNumber)
    {
        $this->songsNumber = $songsNumber;

        return $this;
    }

    /**
     * Get songsNumber
     *
     * @return integer 
     */
    public function getSongsNumber()
    {
        return $this->songsNumber;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Album
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
     * Set buyLink
     *
     * @param string $buyLink
     * @return Album
     */
    public function setBuyLink($buyLink)
    {
        $this->buyLink = $buyLink;

        return $this;
    }

    /**
     * Get buyLink
     *
     * @return string 
     */
    public function getBuyLink()
    {
        return $this->buyLink;
    }

    /**
     * Add albumSongs
     *
     * @param \AppBundle\Entity\AlbumSong $albumSongs
     * @return Album
     */
    public function addAlbumSong(AlbumSong $albumSong)
    {
        $albumSong->setAlbum($this);
        $this->albumSongs[] = $albumSong;

        return $this;
    }

    /**
     * Remove albumSongs
     *
     * @param \AppBundle\Entity\AlbumSong $albumSongs
     */
    public function removeAlbumSong(AlbumSong $albumSongs)
    {
        $this->albumSongs->removeElement($albumSongs);
    }

    /**
     * Get albumSongs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlbumSongs()
    {
        return $this->albumSongs;
    }
}
