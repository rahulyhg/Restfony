<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BundleElementsRepository")
 */
class BundleElements
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bundles", inversedBy="product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bundle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products", inversedBy="bundleElements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBundle(): ?Bundles
    {
        return $this->bundle;
    }

    public function setBundle(?Bundles $bundle): self
    {
        $this->bundle = $bundle;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }
}
