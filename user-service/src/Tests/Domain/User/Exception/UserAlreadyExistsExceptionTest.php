<?php

namespace App\Tests\Domain\User\Exception;

use App\Domain\User\Exception\UserAlreadyExistsException;
use PHPUnit\Framework\TestCase;

class UserAlreadyExistsExceptionTest extends TestCase
{
    public function testErrorMessage()
    {
        $email = 'example@test.com';
        $exception = new UserAlreadyExistsException($email);
        $this->assertEquals(
            sprintf('User with email "%s" already exists.', $email),
            $exception->getMessage()
        );
    }
}
