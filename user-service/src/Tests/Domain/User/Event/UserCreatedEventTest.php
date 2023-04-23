<?php

namespace App\Tests\Domain\User\Event;

use App\Domain\User\Event\UserCreatedEvent;
use PHPUnit\Framework\TestCase;

class UserCreatedEventTest extends TestCase
{
    public function testGetUserId(): void
    {
        $event = new UserCreatedEvent('1', 'john@example.com', 'John', 'Doe');
        $this->assertEquals('1', $event->getUserId());
    }

    public function testGetEmail(): void
    {
        $event = new UserCreatedEvent('1', 'john@example.com', 'John', 'Doe');
        $this->assertEquals('john@example.com', $event->getEmail());
    }

    public function testGetFirstName(): void
    {
        $event = new UserCreatedEvent('1', 'john@example.com', 'John', 'Doe');
        $this->assertEquals('John', $event->getFirstName());
    }

    public function testGetLastName(): void
    {
        $event = new UserCreatedEvent('1', 'john@example.com', 'John', 'Doe');
        $this->assertEquals('Doe', $event->getLastName());
    }
}
