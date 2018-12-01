<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BundlesRepository")
 */
class Bundles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BundleElements", mappedBy="bundle", orphanRemoval=true)
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BundleElements", mappedBy="bundle", orphanRemoval=true)
     */
    private $bundleElements;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->bundleElements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|BundleElements[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(BundleElements $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setBundle($this);
        }

        return $this;
    }

    public function removeProduct(BundleElements $product): self
    {
        if ($this->product->contains($product)) {
            $this->product->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getBundle() === $this) {
                $product->setBundle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BundleElements[]
     */
    public function getBundleElements(): Collection
    {
        return $this->bundleElements;
    }

    public function addBundleElement(BundleElements $bundleElement): self
    {
        if (!$this->bundleElements->contains($bundleElement)) {
            $this->bundleElements[] = $bundleElement;
        }

        return $this;
    }

    public function removeBundleElement(BundleElements $bundleElement): self
    {
        if ($this->bundleElements->contains($bundleElement)) {
            $this->bundleElements->removeElement($bundleElement);
        }

        return $this;
    }
}
