<?php

namespace App\Domain\User\Exception;

use JetBrains\PhpStorm\Pure;
use Throwable;

class UserAlreadyExistsException extends \Exception
{
    #[Pure] public function __construct(string $email, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('User with email "%s" already exists.', $email);
        parent::__construct($message, $code, $previous);
    }
}
