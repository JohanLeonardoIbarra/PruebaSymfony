<?php

namespace App\Document;

use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

#[ODM\Document]
#[ODM\Index(keys: ['name' => 'text'])]
#[Unique('name', message: 'Product name already on use')]
class Product
{
    #[ODM\Id]
    private $id;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank(message: 'Product name is required')]
    private string $name;

    #[ODM\Field(type: "int")]
    #[Assert\PositiveOrZero]
    #[Assert\NotNull(message: 'Quantity is required')]
    private int $quantity;

    #[ODM\Field(type: "float")]
    #[Assert\PositiveOrZero]
    #[Assert\NotNull(message: 'Unitary price is required')]
    private float $unitPrice;

    public function __construct()
    {
        $this->name = '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }
}