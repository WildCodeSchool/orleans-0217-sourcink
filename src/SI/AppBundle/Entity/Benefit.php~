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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Set productoption
     *
     * @param \SI\AppBundle\Entity\ProductOption $productoption
     *
     * @return Benefit
     */
    public function setProductoption(\SI\AppBundle\Entity\ProductOption $productoption = null)
    {
        $this->productoption = $productoption;

        return $this;
    }

    /**
     * Get productoption
     *
     * @return \SI\AppBundle\Entity\ProductOption
     */
    public function getProductoption()
    {
        return $this->productoption;
    }
}
