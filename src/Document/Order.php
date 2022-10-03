<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ODM\Document]
class Order
{
    #[ODM\Id]
    private $id;

    #[ODM\ReferenceOne(targetDocument: User::class)]
    private User $owner;

    #[ODM\Field(type: 'string')]
    #[Assert\NotBlank(message: 'The address field is required')]
    private string $address;

    #[ODM\ReferenceMany(targetDocument: Product::class)]
    private Collection $products;

    public function __toString(): string
    {
        return 'Address: '.$this->getAddress();
    }

    public function __construct()
    {
        $this->address = '';
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function setProducts(Collection $products): static
    {
        $this->products = $products;
        return $this;
    }
}