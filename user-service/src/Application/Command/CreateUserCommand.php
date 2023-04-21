<?php

namespace App\Application\Command;

class CreateUserCommand
{
    private string $id;
    private string $email;
    private string $firstName;
    private string $lastName;

    public function __construct(string $email, string $firstName, string $lastName)
    {
        $this->id = uniqid();
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
}
