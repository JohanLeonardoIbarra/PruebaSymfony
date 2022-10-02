<?php

namespace App\Repositories\User;

use App\Document\User;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class UserRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->findOneBy(["email" => $email]);
    }

    public function createUser(User $user): void
    {
        $this->getDocumentManager()->persist($user);
        $this->getDocumentManager()->flush();
    }
}