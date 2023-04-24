<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;

interface UserRepositoryInterface
{
    public function findAllUsers(): array;
    public function findByEmail(string $email): ?User;
    public function nextIdentity(): string;
    public function createNew(string $email, string $firstName, string $lastName): User;
}
