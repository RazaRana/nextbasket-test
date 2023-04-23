<?php

namespace App\Tests\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineUser;
use App\Infrastructure\Persistence\Doctrine\Mapper\DoctrineUserMapper;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class DoctrineUserMapperTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testMapToDomain()
    {
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $doctrineUserMock = $this->createMock(DoctrineUser::class);

        $mapper = $this->getMockBuilder(DoctrineUserMapper::class)
            ->setConstructorArgs([$entityManagerMock, $userRepositoryMock])
            ->onlyMethods(['mapToDomain'])
            ->getMock();

        $user = new User(1, 'test@example.com', 'John', 'Doe');

        $mapper->expects($this->once())
            ->method('mapToDomain')
            ->with($doctrineUserMock)
            ->willReturn($user);

        $result = $mapper->mapToDomain($doctrineUserMock);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user, $result);
    }

}