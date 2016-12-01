<?php
// src/AppBundle/Entity/BlogArticleUploadedFile.php
namespace AppBundle\Entity;

use DateTime;

use Symfony\Component\HttpFoundation\File\File,
    Symfony\Component\HttpFoundation\File\UploadedFile,
    Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

use AppBundle\Entity\Utility\DoctrineMapping\IdMapper,
    AppBundle\Entity\BlogArticle;

/**
 * @ORM\Entity()
 * @ORM\Table(name="blog_article_uploaded_files")
 *
 * @Vich\Uploadable
 */
class BlogArticleUploadedFile
{
    const WEB_PATH = "/images/blog/";

    use IdMapper;

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "image/gif", }
     * )
     *
     * @Vich\UploadableField(mapping="blog_images", fileNameProperty="imageName")
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="BlogArticle", inversedBy="uploadedFile")
     * @ORM\JoinColumn(name="objectId", referencedColumnName="id")
     */
    protected $object;

    /**
     * To string
     */
    public function __toString()
    {
        return ( $this->imageName ) ? $this->imageName : "";
    }

    public function setImageFile($imageFile = NULL)
    {
        $this->imageFile = $imageFile;

        if( $imageFile instanceof File )
            $this->updatedAt = new DateTime;
    }

    public function getImagePath()
    {
        return ( $this->imageName )
            ? self::WEB_PATH.$this->imageName
            : FALSE;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set object
     *
     * @param \AppBundle\Entity\BlogArticle $object
     * @return BlogArticleUploadedFile
     */
    public function setObject(BlogArticle $object = null)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return \AppBundle\Entity\BlogArticle
     */
    public function getObject()
    {
        return $this->object;
    }
}
