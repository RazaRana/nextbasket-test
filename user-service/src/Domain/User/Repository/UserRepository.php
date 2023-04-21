<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function createNew(string $email, string $firstName, string $lastName): User
    {
        return new User($this->nextIdentity(), $email, $firstName, $lastName);
    }
}
