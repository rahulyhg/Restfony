<?php

namespace App\Entity;

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
     * @ORM\OneToOne(targetEntity="App\Entity\Discounts", mappedBy="product_id", cascade={"persist", "remove"})
     */
    private $discounts;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\BundleElements", mappedBy="product_id", cascade={"persist", "remove"})
     */
    private $bundleElements;

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

    public function getDiscounts(): ?Discounts
    {
        return $this->discounts;
    }

    public function setDiscounts(Discounts $discounts): self
    {
        $this->discounts = $discounts;

        // set the owning side of the relation if necessary
        if ($this !== $discounts->getProductId()) {
            $discounts->setProductId($this);
        }

        return $this;
    }

    public function getBundleElements(): ?BundleElements
    {
        return $this->bundleElements;
    }

    public function setBundleElements(BundleElements $bundleElements): self
    {
        $this->bundleElements = $bundleElements;

        // set the owning side of the relation if necessary
        if ($this !== $bundleElements->getProductId()) {
            $bundleElements->setProductId($this);
        }

        return $this;
    }
}
