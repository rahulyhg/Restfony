<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesItemsRepository")
 */
class SalesItems
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sales", inversedBy="salesItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sales_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $item_quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $item_price;

    /**
     * @ORM\Column(type="float")
     */
    private $item_discount;

    /**
     * @ORM\Column(type="float")
     */
    private $item_total;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $item_type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalesId(): ?Sales
    {
        return $this->sales_id;
    }

    public function setSalesId(?Sales $sales_id): self
    {
        $this->sales_id = $sales_id;

        return $this;
    }

    public function getItemId(): ?Products
    {
        return $this->item_id;
    }

    public function setItemId(?Products $item_id): self
    {
        $this->item_id = $item_id;

        return $this;
    }

    public function getItemQuantity(): ?int
    {
        return $this->item_quantity;
    }

    public function setItemQuantity(int $item_quantity): self
    {
        $this->item_quantity = $item_quantity;

        return $this;
    }

    public function getItemPrice(): ?float
    {
        return $this->item_price;
    }

    public function setItemPrice(float $item_price): self
    {
        $this->item_price = $item_price;

        return $this;
    }

    public function getItemDiscount(): ?float
    {
        return $this->item_discount;
    }

    public function setItemDiscount(float $item_discount): self
    {
        $this->item_discount = $item_discount;

        return $this;
    }

    public function getItemTotal(): ?float
    {
        return $this->item_total;
    }

    public function setItemTotal(float $item_total): self
    {
        $this->item_total = $item_total;

        return $this;
    }

    public function getItemType(): ?string
    {
        return $this->item_type;
    }

    public function setItemType(string $item_type): self
    {
        $this->item_type = $item_type;

        return $this;
    }
}
