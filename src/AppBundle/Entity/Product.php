<?php

namespace AppBundle\Entity;

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
     * @ORM\OneToMany(targetEntity="ProductOption", mappedBy="product")
     */
    private $productoptions;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="Picture")
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
     * @param AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return AppBundle\Entity\Category
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
     * @param AppBundle\Entity\ProductOption $productoption
     *
     * @return Product
     */
    public function addProductoption(AppBundle\Entity\ProductOption $productoption)
    {
        $this->productoptions[] = $productoption;

        return $this;
    }

    /**
     * Remove productoption
     *
     * @param AppBundle\Entity\ProductOption $productoption
     */
    public function removeProductoption(AppBundle\Entity\ProductOption $productoption)
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
    public function setPicture(AppBundle\Entity\Picture $picture = null)
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
}
