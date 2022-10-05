<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\EmbeddedDocument]
class OrderDetail
{
    #[ODM\Id]
    private string $id;

    #[ODM\ReferenceOne(targetDocument: Product::class)]
    private Product $product;

    #[ODM\Field(type: 'int')]
    private string $quantity;

    public function getId(): string
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): void
    {
        $this->quantity = $quantity;
    }
}