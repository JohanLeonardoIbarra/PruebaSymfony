<?php

namespace App\Repositories;

use App\Document\Product;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class ProductRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $product)
    {
        $this->getDocumentManager()->persist($product);
        $this->getDocumentManager()->flush();
    }

    public function paginateProducts(string $q, int $limit = 0, int $offset = 0)
    {
        $qb = $this->createQueryBuilder(Product::class)
            //->text($q) //Pendiente por revisar
            ->limit($limit)
            ->skip($limit*$offset);


        $query = $qb->getQuery();

        return $query->execute();
    }
}