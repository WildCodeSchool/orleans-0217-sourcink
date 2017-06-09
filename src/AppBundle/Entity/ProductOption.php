<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductOption
 *
 * @ORM\Table(name="product_option")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductOptionRepository")
 */
class ProductOption
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productoptions")
     */
    private $product;


    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Status")
     */
    private $status;

    /**
     * Get id
     *
     * @return int
     */

    /**
     * @ORM\ManyToOne(targetEntity="Benefit", inversedBy="productOptions")
     */
    private $benefit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->benefits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Get product
     *
     * @return AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set product
     *
     * @param Product $product
     *
     * @return ProductOption
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Add benefit
     *
     * @param Benefit $benefit
     *
     * @return ProductOption
     */
    public function addBenefit(Benefit $benefit)
    {
        $this->benefits[] = $benefit;

        return $this;
    }

    /**
     * Remove benefit
     *
     * @param Benefit $benefit
     */
    public function removeBenefit(Benefit $benefit)
    {
        $this->benefits->removeElement($benefit);
    }

    /**
     * Get benefits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBenefits()
    {
        return $this->benefits;
    }

    /**
     * Get status
     *
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param Status $status
     *
     * @return ProductOption
     */
    public function setStatus(Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get benefit
     *
     * @return Benefit
     */
    public function getBenefit()
    {
        return $this->benefit;
    }

    /**
     * Set benefit
     *
     * @param Benefit $benefit
     *
     * @return ProductOption
     */
    public function setBenefit(Benefit $benefit = null)
    {
        $this->benefit = $benefit;

        return $this;
    }
}
