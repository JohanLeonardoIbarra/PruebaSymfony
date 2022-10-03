<?php

namespace App\Repositories;

use App\Document\Order;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

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