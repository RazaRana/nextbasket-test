<?php

namespace App\Domain\User\Model;

use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Repository\UserRepositoryInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class User
{
    private string $id;
    private string $email;
    private string $firstName;
    private string $lastName;

    public function __construct(string $id, string $email, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function changeEmail(string $email): void
    {
        $this->email = $email;
    }

    public function changeFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function changeLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    #[Pure] public static function create(string $id, string $email, string $firstName, string $lastName): self
    {
        return new self($id, $email, $firstName, $lastName);
    }

    #[Pure] public static function fromArray(array $data): self
    {
        return new self($data['id'], $data['email'], $data['firstName'], $data['lastName']);
    }

    #[ArrayShape(['id' => "string", 'email' => "string", 'firstName' => "string", 'lastName' => "string"])] public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function ensureEmailIsUnique(UserRepositoryInterface $userRepository): void
    {
        $existingUser = $userRepository->findByEmail($this->email);
        if ($existingUser && $existingUser->getId() !== $this->id) {
            throw new UserAlreadyExistsException(sprintf('User with email "%s" already exists', $this->email));
        }
    }
}
