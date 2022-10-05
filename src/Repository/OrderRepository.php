<?php

namespace App\Repository;

use App\Document\Order;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class OrderRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $order)
    {
        $this->getDocumentManager()->persist($order);
        $this->getDocumentManager()->flush();
    }
}