<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepositoryFactory
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(): DoctrineUserRepository
    {
        return new DoctrineUserRepository($this->entityManager);
    }
}
