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
     * @ORM\OneToOne(targetEntity="Status")
     */
    private $status;

    /**
     * Get id
     *
     * @return int
     */


    /**
     * @ORM\ManyToOne(targetEntity="Benefit")
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
     * @param AppBundle\Entity\Product $product
     *
     * @return ProductOption
     */
    public function setProduct(AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Add benefit
     *
     * @param AppBundle\Entity\Benefit $benefit
     *
     * @return ProductOption
     */
    public function addBenefit(AppBundle\Entity\Benefit $benefit)
    {
        $this->benefits[] = $benefit;

        return $this;
    }

    /**
     * Remove benefit
     *
     * @param AppBundle\Entity\Benefit $benefit
     */
    public function removeBenefit(AppBundle\Entity\Benefit $benefit)
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
     * @return AppBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param AppBundle\Entity\Status $status
     *
     * @return ProductOption
     */
    public function setStatus(AppBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get benefit
     *
     * @return AppBundle\Entity\Benefit
     */
    public function getBenefit()
    {
        return $this->benefit;
    }

    /**
     * Set benefit
     *
     * @param AppBundle\Entity\Benefit $benefit
     *
     * @return ProductOption
     */
    public function setBenefit(AppBundle\Entity\Benefit $benefit = null)
    {
        $this->benefit = $benefit;

        return $this;
    }
}
