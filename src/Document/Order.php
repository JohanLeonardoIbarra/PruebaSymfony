<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\Collection;

#[ODM\Document]
class Order
{
    #[ODM\Id]
    private $id;

    //private User $owner;

    private string $address;

    private $products;
}