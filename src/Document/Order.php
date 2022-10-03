<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document]
class Order
{
    #[ODM\Id]
    private $id;

    #[ODM\EmbedOne(targetDocument: User::class)]
    private $owner;

    private string $address;

    #[ODM\EmbedMany(targetDocument: Product::class)]
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Order
    {
        $this->address = $address;
        return $this;
    }

    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    public function setProducts(ArrayCollection $products): void
    {
        $this->products = $products;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return 'Address: '.$this->address.' Products: '.$this->products;
    }
}