<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesRepository")
 */
class Sales
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $sub_total;

    /**
     * @ORM\Column(type="float")
     */
    private $discount;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SalesItems", mappedBy="sales", orphanRemoval=true)
     */
    private $salesItems;

    public function __construct()
    {
        $this->salesItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubTotal(): ?float
    {
        return $this->sub_total;
    }

    public function setSubTotal(float $sub_total): self
    {
        $this->sub_total = $sub_total;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

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

    /**
     * @return Collection|SalesItems[]
     */
    public function getSalesItems(): Collection
    {
        return $this->salesItems;
    }

    public function addSalesItem(SalesItems $salesItem): self
    {
        if (!$this->salesItems->contains($salesItem)) {
            $this->salesItems[] = $salesItem;
            $salesItem->setSales($this);
        }

        return $this;
    }

    public function removeSalesItem(SalesItems $salesItem): self
    {
        if ($this->salesItems->contains($salesItem)) {
            $this->salesItems->removeElement($salesItem);
            // set the owning side to null (unless already changed)
            if ($salesItem->getSales() === $this) {
                $salesItem->setSales(null);
            }
        }

        return $this;
    }
}
