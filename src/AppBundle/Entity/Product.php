<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="ProductOption", mappedBy="product", cascade={"persist"})
     */
    private $productoptions;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="Picture", cascade={"persist"})
     */
    private $picture;

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
     * Set title
     *
     * @param string $title
     *
     * @return Product
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
     * Set text
     *
     * @param string $text
     *
     * @return Product
     */
    public function setText($text)
    {
        $this->text = $text;

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
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productoptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add productoption
     *
     * @param ProductOption $productoption
     *
     * @return Product
     */
    public function addProductoption(ProductOption $productoption)
    {
        $this->productoptions[] = $productoption;

        return $this;
    }

    /**
     * Remove productoption
     *
     * @param ProductOption $productoption
     */
    public function removeProductoption(ProductOption $productoption)
    {
        $this->productoptions->removeElement($productoption);
    }

    /**
     * Get productoptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductoptions()
    {
        return $this->productoptions;
    }

    /**
     * Set picture
     *
     * @param AppBundle\Entity\Picture $picture
     *
     * @return Product
     */
    public function setPicture(Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return AppBundle\Entity\Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function __toString()
    {
        return $this->text;
    }
}
