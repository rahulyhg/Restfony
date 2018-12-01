<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
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
     * @ORM\OneToOne(targetEntity="App\Entity\Discounts", mappedBy="product", cascade={"persist", "remove"})
     */
    private $discount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BundleElements", mappedBy="product", orphanRemoval=true)
     */
    private $bundleElements;

    public function __construct()
    {
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

    public function getDiscount(): ?Discounts
    {
        return $this->discount;
    }

    public function setDiscount(Discounts $discount): self
    {
        $this->discount = $discount;

        // set the owning side of the relation if necessary
        if ($this !== $discount->getProduct()) {
            $discount->setProduct($this);
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
            $bundleElement->setProduct($this);
        }

        return $this;
    }

    public function removeBundleElement(BundleElements $bundleElement): self
    {
        if ($this->bundleElements->contains($bundleElement)) {
            $this->bundleElements->removeElement($bundleElement);
            // set the owning side to null (unless already changed)
            if ($bundleElement->getProduct() === $this) {
                $bundleElement->setProduct(null);
            }
        }

        return $this;
    }
}
