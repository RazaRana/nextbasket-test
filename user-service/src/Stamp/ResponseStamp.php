<?php

namespace App\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

class ResponseStamp implements StampInterface
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
