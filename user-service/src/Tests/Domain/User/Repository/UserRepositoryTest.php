<?php

namespace App\Tests\Domain\User\Repository;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    /** @var UserRepository */
    private UserRepository $userRepository;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
    }

    public function testFindAllReturnsArrayOfUsers()
    {
        $user1 = new User(0,'john.doe@example.com', 'John', 'Doe');
        $user2 = new User(1, 'jane.doe@example.com', 'Jane', 'Doe');

        $this->userRepository->method('findAll')->willReturn([$user1, $user2]);

        $users = $this->userRepository->findAll();

        $this->assertIsArray($users);
        $this->assertContainsOnlyInstancesOf(User::class, $users);
    }

    public function testFindByEmailReturnsUserOrNull()
    {
        $email = 'john.doe@example.com';
        $user = $this->userRepository->findByEmail($email);
        $this->assertNull($user);

        $user = new User(0,'john.doe@example.com', 'John', 'Doe');
        $this->userRepository->method('findByEmail')->willReturn($user);

        $user = $this->userRepository->findByEmail($email);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testNextIdentityReturnsString()
    {
        $testIdentity = '233y';
        $this->userRepository->method('nextIdentity')->willReturn($testIdentity);
        $identity = $this->userRepository->nextIdentity();
        $this->assertIsString($identity);
        $this->assertNotEmpty($identity);
    }

    public function testCreateNewReturnsUser()
    {
        $email = 'john.doe@example.com';
        $firstName = 'John';
        $lastName = 'Doe';

        $userMock = new User(0,$email, $firstName, $lastName);

        $this->userRepository->method('createNew')->willReturn($userMock);
        $user = $this->userRepository->createNew($email, $firstName, $lastName);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
    }
}
