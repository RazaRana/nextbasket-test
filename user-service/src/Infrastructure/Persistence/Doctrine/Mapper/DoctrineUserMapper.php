<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineUser;
use JetBrains\PhpStorm\Pure;

class DoctrineUserMapper
{
    private EntityManagerInterface $entityManager;
    private UserRepositoryInterface $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepositoryInterface $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    #[Pure] public function mapToDomain(DoctrineUser $entity): ?User
    {

        return new User($entity->getId(),$entity->getEmail(),$entity->getFirstName(), $entity->getLastName());
    }

    public function mapToEntity(User $user, DoctrineUser $entity = null): DoctrineUser
    {
        if (!$entity) {
            $entity = new DoctrineUser();
            $user = $this->userRepository->createNew($user->getEmail(), $user->getFirstName(), $user->getLastName());
        }

        $entity->setEmail($user->getEmail());
        $entity->setFirstName($user->getFirstName());
        $entity->setLastName($user->getLastName());

        return $entity;
    }
}
