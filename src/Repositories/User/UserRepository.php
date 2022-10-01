<?php

namespace App\Repositories\User;

use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;

class UserRepository implements UserRepositoryInterface
{
    private DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function findUser(string $email): User
    {
        return $this->documentManager->getRepository(User::class)->findOneBy(["email" => $email]);
    }
}