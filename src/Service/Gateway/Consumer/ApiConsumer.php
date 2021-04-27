<?php
declare(strict_types=1);

namespace App\Service\Gateway\Consumer;

use App\DTO\RequestDTO;
use App\Service\Gateway\Consumer\Client\RequestAdapter;
use App\Service\Exception\RequestEmptyResponseException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ApiConsumer
{
    const DEFAULT_TIMEOUT = 15;

    /**
     * @var RequestAdapter
     */
    private RequestAdapter $requestAdapter;

    /**
     * @var array
     */
    private array $config;


    public function __construct(RequestAdapter $requestAdapter, ParameterBagInterface $params)
    {
        $this->requestAdapter = $requestAdapter;
        $this->config = $params->get('app.consumer.http_client.options');
    }

    /**
     * @param RequestDTO $requestDTO
     * @return string
     * @throws RequestEmptyResponseException
     */
    public function request(RequestDTO $requestDTO): string
    {
        $content = $this->requestAdapter->doRequest($requestDTO);

        if ($content === RequestAdapter::EMPTY_RESPONSE) {
            sleep( $this->getWaitInterval());
            $content = $this->requestAdapter->doRequest($requestDTO);
        }

        if ($content === RequestAdapter::EMPTY_RESPONSE) {
            throw new RequestEmptyResponseException($requestDTO->getUri());
        }

        return $content;
    }

    private function getWaitInterval(): int
    {
        return $this->config['timeout'] ?? self::DEFAULT_TIMEOUT;
    }
}

