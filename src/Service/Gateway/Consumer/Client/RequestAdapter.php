<?php
declare(strict_types=1);

namespace App\Service\Gateway\Consumer\Client;

use App\DTO\RequestDTO;
use App\Service\Gateway\Consumer\Client\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RequestAdapter
{
    public const EMPTY_RESPONSE = '';
    private const REQUEST_INFO = "\nStatus code: [%d]";
    private const REQUEST_ERROR = "\nCrawling error code: [%d]; error message: %s";

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var array
     */
    private array $config;


    public function __construct(
        HttpClient $client,
        LoggerInterface $logger,
        ParameterBagInterface $params
    ) {
        $this->client = $client->getClient();
        $this->logger = $logger;
        $this->config = $params->get('app.consumer.request');
    }

    public function doRequest(RequestDTO $requestDTO): string
    {
        $url = trim($requestDTO->getUri());
        $options = $this->getRequestOptions();

        try {
            $result = $this->client->request($requestDTO->getMethod(), $url, $options);
            $statusCode = $result->getStatusCode();

            if (!in_array($statusCode, $this->getAllowedResponses())) {
                $logMessage =  vsprintf(self::REQUEST_INFO, [ $statusCode]);
                $this->logger->warning($logMessage);
                return self::EMPTY_RESPONSE;
            }

            return ((string)$result->getBody());
        } catch (GuzzleException $e) {
            $logMessage =  vsprintf(self::REQUEST_ERROR, [$e->getCode(), $e->getMessage()]);
            $this->logger->error($logMessage);
            return self::EMPTY_RESPONSE;
        }
    }

    private function getRequestOptions(): array
    {
        return $this->config['options'];
    }

    private function getAllowedResponses(): array
    {
        return $this->config['allowed_responses'];
    }
}
