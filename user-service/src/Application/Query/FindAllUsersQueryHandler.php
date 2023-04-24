<?php

namespace App\Application\Query;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Stamp\ResponseStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class FindAllUsersQueryHandler implements MiddlewareInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $query = $envelope->getMessage();
        if (!$query instanceof FindAllUsersQuery) {
            return $stack->next()->handle($envelope, $stack);
        }
        $users = $this->userRepository->findAllUsers();

        $usersArray = array_map(fn (User $user) => $user->toArray(), $users);
        return $stack->next()->handle($envelope->with(new ResponseStamp($usersArray)), $stack);
    }
}
