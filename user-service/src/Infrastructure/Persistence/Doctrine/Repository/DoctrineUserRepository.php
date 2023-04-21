<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineUser;
use Ramsey\Uuid\Uuid;

class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    public function findByEmail(string $email): ?User
    {
        $doctrineUser = $this->findOneBy(['email' => $email]);

        if (!$doctrineUser) {
            return null;
        }

        return new User(
            $doctrineUser->getId(),
            $doctrineUser->getEmail(),
            $doctrineUser->getFirstName(),
            $doctrineUser->getLastName()
        );
    }

    public function findAll(): array
    {
        $doctrineUsers = $this->findAll();

        $users = [];

        foreach ($doctrineUsers as $doctrineUser) {
            $users[] = new User(
                $doctrineUser->getId(),
                $doctrineUser->getEmail(),
                $doctrineUser->getFirstName(),
                $doctrineUser->getLastName()
            );
        }

        return $users;
    }

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function createNew(string $email, string $firstName, string $lastName): User
    {
        $doctrineUser = new DoctrineUser();

        $doctrineUser->setEmail($email);
        $doctrineUser->setFirstName($firstName);
        $doctrineUser->setLastName($lastName);

        $this->_em->persist($doctrineUser);
        $this->_em->flush();

        return new User(
            $doctrineUser->getId(),
            $doctrineUser->getEmail(),
            $doctrineUser->getFirstName(),
            $doctrineUser->getLastName()
        );

    }


}
