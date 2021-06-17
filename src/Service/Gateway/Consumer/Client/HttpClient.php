<?php
declare(strict_types=1);

namespace App\Service\Gateway\Consumer\Client;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class HttpClient
{
    private array $httpClientOptions;

    public function __construct(ParameterBagInterface $params)
    {
        $this->httpClientOptions = $params->get('app.consumer.http_client.options');
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return new Client($this->httpClientOptions);
    }
}
