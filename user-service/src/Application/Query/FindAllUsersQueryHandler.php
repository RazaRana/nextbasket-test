<?php

namespace App\Application\Query;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;

class FindAllUsersQueryHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(FindAllUsersQuery $query): array
    {
        $users = $this->userRepository->findAll();

        return array_map(fn (User $user) => $user->toArray(), $users);
    }
}
