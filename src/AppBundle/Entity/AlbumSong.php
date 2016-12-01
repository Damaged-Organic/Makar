<?php
// src/AppBundle/Entity/AlbumSong.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo,
    Gedmo\Translatable\Translatable;

use AppBundle\Entity\Utility\DoctrineMapping\IdMapper,
    AppBundle\Entity\AlbumSongTranslation,
    AppBundle\Entity\Album;

/**
 * @ORM\Table(name="albums_songs")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AlbumSongRepository")
 *
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\AlbumSongTranslation")
 */
class AlbumSong
{
    use IdMapper;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\OneToMany(targetEntity="AlbumTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $position;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 59,
     *      minMessage = "Некорректное значение секунд",
     *      maxMessage = "Некорректное значение секунд"
     * )
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $durationSeconds;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 59,
     *      minMessage = "Некорректное значение минут",
     *      maxMessage = "Некорректное значение минут"
     * )
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $durationMinutes;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="albumSongs")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     */
    protected $album;

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

    public function addTranslation(AlbumSongTranslation $t)
    {
        $this->translations->add($t);
        $t->setObject($this);
    }

    public function removeTranslation(AlbumSongTranslation $t)
    {
        $this->translations->removeElement($t);
    }

    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return AlbumSong
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return AlbumSong
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
     * Set durationSeconds
     *
     * @param integer $durationSeconds
     * @return AlbumSong
     */
    public function setDurationSeconds($durationSeconds)
    {
        $this->durationSeconds = $durationSeconds;

        return $this;
    }

    /**
     * Get durationSeconds
     *
     * @return integer
     */
    public function getDurationSeconds()
    {
        return $this->durationSeconds;
    }

    /**
     * Set durationMinutes
     *
     * @param integer $durationMinutes
     * @return AlbumSong
     */
    public function setDurationMinutes($durationMinutes)
    {
        $this->durationMinutes = $durationMinutes;

        return $this;
    }

    /**
     * Get durationMinutes
     *
     * @return integer
     */
    public function getDurationMinutes()
    {
        return $this->durationMinutes;
    }

    /**
     * Set album
     *
     * @param \AppBundle\Entity\Album $album
     * @return AlbumSong
     */
    public function setAlbum(Album $album = null)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album
     *
     * @return \AppBundle\Entity\Album
     */
    public function getAlbum()
    {
        return $this->album;
    }
}
