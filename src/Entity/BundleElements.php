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
     * @ORM\ManyToOne(targetEntity="App\Entity\Bundles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bundle_id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Products", inversedBy="bundleElements", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBundleId(): ?Bundles
    {
        return $this->bundle_id;
    }

    public function setBundleId(?Bundles $bundle_id): self
    {
        $this->bundle_id = $bundle_id;

        return $this;
    }

    public function getProductId(): ?Products
    {
        return $this->product_id;
    }

    public function setProductId(Products $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }
}
