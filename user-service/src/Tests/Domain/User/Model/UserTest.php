<?php

namespace App\Tests\Domain\User\Model;

use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCanCreateUserInstance(): void
    {
        $user = new User('1', 'test@example.com', 'Test', 'User');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('1', $user->getId());
        $this->assertEquals('test@example.com', $user->getEmail());
        $this->assertEquals('Test', $user->getFirstName());
        $this->assertEquals('User', $user->getLastName());
    }

    public function testCanChangeUserEmail(): void
    {
        $user = new User('1', 'test@example.com', 'Test', 'User');

        $user->changeEmail('new-email@example.com');

        $this->assertEquals('new-email@example.com', $user->getEmail());
    }

    public function testCanChangeUserFirstName(): void
    {
        $user = new User('1', 'test@example.com', 'Test', 'User');

        $user->changeFirstName('New First Name');

        $this->assertEquals('New First Name', $user->getFirstName());
    }

    public function testCanChangeUserLastName(): void
    {
        $user = new User('1', 'test@example.com', 'Test', 'User');

        $user->changeLastName('New Last Name');

        $this->assertEquals('New Last Name', $user->getLastName());
    }

    public function testCanCreateUserFromArray(): void
    {
        $data = [
            'id' => '1',
            'email' => 'test@example.com',
            'firstName' => 'Test',
            'lastName' => 'User',
        ];

        $user = User::fromArray($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('1', $user->getId());
        $this->assertEquals('test@example.com', $user->getEmail());
        $this->assertEquals('Test', $user->getFirstName());
        $this->assertEquals('User', $user->getLastName());
    }

    public function testCanGetUserAsArray(): void
    {
        $user = new User('1', 'test@example.com', 'Test', 'User');

        $data = $user->toArray();

        $this->assertIsArray($data);
        $this->assertEquals('1', $data['id']);
        $this->assertEquals('test@example.com', $data['email']);
        $this->assertEquals('Test', $data['firstName']);
        $this->assertEquals('User', $data['lastName']);
    }

    /**
     * @throws UserAlreadyExistsException
     * @throws Exception
     */
    public function testCanEnsureUniqueEmail(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('findByEmail')->willReturn(null);

        $user = new User('1', 'test@example.com', 'Test', 'User');

        $user->ensureEmailIsUnique($userRepository);
        $this->expectNotToPerformAssertions();
    }
}
