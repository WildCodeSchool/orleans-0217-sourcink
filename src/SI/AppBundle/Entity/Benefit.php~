<?php

namespace SI\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Benefit
 *
 * @ORM\Table(name="benefit")
 * @ORM\Entity(repositoryClass="SI\AppBundle\Repository\BenefitRepository")
 */
class Benefit
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="ProductOption", mappedBy="benefit", cascade={"persist", "remove"})
     */
    private $productOptions;

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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Benefit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }



    public function __toString()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productOptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add productOption
     *
     * @param \SI\AppBundle\Entity\ProductOption $productOption
     *
     * @return Benefit
     */
    public function addProductOption(\SI\AppBundle\Entity\ProductOption $productOption)
    {
        $productOption->setBenefit($this);
        $this->productOptions[] = $productOption;

        return $this;
    }

    /**
     * Remove productOption
     *
     * @param \SI\AppBundle\Entity\ProductOption $productOption
     */
    public function removeProductOption(\SI\AppBundle\Entity\ProductOption $productOption)
    {
        $this->productOptions->removeElement($productOption);
    }

    /**
     * Get productOptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductOptions()
    {
        return $this->productOptions;
    }
}
