<?php

namespace SI\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="SI\AppBundle\Repository\CategoryRepository")
 * @Vich\Uploadable
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="category", fileNameProperty="categoryName")
     *
     * @var File
     */
    private $categoryFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $categoryName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="Picture")
     */
    private $picture;


    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $category
     *
     * @return Category
     */
    public function setCategoryFile(File $category = null)
    {
        $this->categoryFile = $category;

        if ($category)
            $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return File|null
     */
    public function getCategoryFile()
    {
        return $this->categoryFile;
    }

    /**
     * @param string $categoryName
     *
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Category
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Add product
     *
     * @param \SI\AppBundle\Entity\Product $product
     *
     * @return Category
     */
    public function addProduct(\SI\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \SI\AppBundle\Entity\Product $product
     */
    public function removeProduct(\SI\AppBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Get picture
     *
     * @return \SI\AppBundle\Entity\Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set picture
     *
     * @param \SI\AppBundle\Entity\Picture $picture
     *
     * @return Category
     */
    public function setPicture(\SI\AppBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
