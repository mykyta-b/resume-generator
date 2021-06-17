<?php
declare(strict_types=1);

namespace App\Service\Gateway;

use Exception;

class RequestErrorException extends Exception
{
    /**
     * RequestErrorException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
