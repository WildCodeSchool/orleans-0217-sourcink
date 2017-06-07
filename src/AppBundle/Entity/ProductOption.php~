<?php

namespace SI\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductOption
 *
 * @ORM\Table(name="product_option")
 * @ORM\Entity(repositoryClass="SI\AppBundle\Repository\ProductOptionRepository")
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
     * @return \SI\AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set product
     *
     * @param \SI\AppBundle\Entity\Product $product
     *
     * @return ProductOption
     */
    public function setProduct(\SI\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Add benefit
     *
     * @param \SI\AppBundle\Entity\Benefit $benefit
     *
     * @return ProductOption
     */
    public function addBenefit(\SI\AppBundle\Entity\Benefit $benefit)
    {
        $this->benefits[] = $benefit;

        return $this;
    }

    /**
     * Remove benefit
     *
     * @param \SI\AppBundle\Entity\Benefit $benefit
     */
    public function removeBenefit(\SI\AppBundle\Entity\Benefit $benefit)
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
     * @return \SI\AppBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param \SI\AppBundle\Entity\Status $status
     *
     * @return ProductOption
     */
    public function setStatus(\SI\AppBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get benefit
     *
     * @return \SI\AppBundle\Entity\Benefit
     */
    public function getBenefit()
    {
        return $this->benefit;
    }

    /**
     * Set benefit
     *
     * @param \SI\AppBundle\Entity\Benefit $benefit
     *
     * @return ProductOption
     */
    public function setBenefit(\SI\AppBundle\Entity\Benefit $benefit = null)
    {
        $this->benefit = $benefit;

        return $this;
    }
}
