<?php

namespace App\Tests\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\User\Model\User;

use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineUserRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private ManagerRegistry|MockObject $managerRegistryMock;

    protected function setUp(): void
    {
        $this->managerRegistryMock = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @throws Exception
     */
    public function testCreateNewUser()
    {
        $email = 'john.doe@example.com';
        $firstName = 'John';
        $lastName = 'Doe';

        $user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->getMock();

        $user->method('getEmail')
            ->willReturn($email);

        $user->method('getFirstName')
            ->willReturn($firstName);

        $user->method('getLastName')
            ->willReturn($lastName);

        $repository = $this->getMockBuilder(DoctrineUserRepository::class)
            ->setConstructorArgs([$this->managerRegistryMock, new ClassMetadata(User::class)])
            ->onlyMethods(['createNew'])
            ->getMock();

        $repository->expects($this->any())
            ->method('createNew')
            ->willReturn($user);

        $createdUser = $repository->createNew($email, $firstName, $lastName);

        $this->assertSame($user, $createdUser);
        $this->assertSame($email, $createdUser->getEmail());
        $this->assertSame($firstName, $createdUser->getFirstName());
        $this->assertSame($lastName, $createdUser->getLastName());
    }

}
