<?php

namespace App\Repository;

use App\Document\Product;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class ProductRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $product): void
    {
        $this->getDocumentManager()->persist($product);
        $this->getDocumentManager()->flush();
    }

    public function paginateProducts(string $q, int $limit = 20)
    {
        $qb = $this->createQueryBuilder()
            ->field('name')->equals(new \MongoDB\BSON\Regex("$q"))
            ->limit($limit);
        $query = $qb->getQuery();

        return $query->execute();
    }
}