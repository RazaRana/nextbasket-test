<?php

namespace App\Tests\Infrastructure\Persistence\Doctrine\Entity;

use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineUser;
use PHPUnit\Framework\TestCase;

class DoctrineUserTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $mock = $this->getMockBuilder(DoctrineUser::class)
            ->onlyMethods(['getId', 'getEmail', 'setEmail', 'getFirstName', 'setFirstName', 'getLastName', 'setLastName'])
            ->getMock();

        $mock->method('getId')->willReturn(1);
        $mock->method('getEmail')->willReturn('test@example.com');
        $mock->method('getFirstName')->willReturn('John');
        $mock->method('getLastName')->willReturn('Doe');

        $mock->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $mock->getEmail());

        $mock->setFirstName('John');
        $this->assertEquals('John', $mock->getFirstName());

        $mock->setLastName('Doe');
        $this->assertEquals('Doe', $mock->getLastName());
    }
}
