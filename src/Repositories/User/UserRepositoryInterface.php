<?php

namespace App\Repositories\User;

use App\Document\User;

interface UserRepositoryInterface
{
    public function findUser(string $email): User;
}