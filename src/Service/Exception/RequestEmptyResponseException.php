<?php
declare(strict_types=1);


namespace App\Service\Exception;


class RequestEmptyResponseException extends \Exception
{
    public function __construct(string $url) {
        $message = vsprintf("Empty response from api for url: %s", [$url]);
        parent::__construct($message, 0, null);
    }
}
