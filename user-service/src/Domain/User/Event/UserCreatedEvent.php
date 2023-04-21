<?php

namespace App\Domain\User\Event;

class UserCreatedEvent
{
    private string $userId;
    private string $email;
    private string $firstName;
    private string $lastName;

    public function __construct(string $userId, string $email, string $firstName, string $lastName)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getUserId(): string
    {
        return $this->userId;
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
}
