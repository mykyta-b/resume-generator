<?php
declare(strict_types=1);

namespace App\Tests\Helpers\Traits;

use App\Service\Gateway\Consumer\ApiConsumer;
use App\Service\Gateway\Consumer\Client\HttpClient;
use App\Service\Gateway\Consumer\Client\RequestAdapter;
use Codeception\Stub;
use Codeception\Stub\Expected;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

trait IntegrationTestMocks
{
    /**
     * @return string[]
     */
    private function getUserApiGatewayConfig(): array
    {
        return [
            'users' => "https://api.github.com/users/<login>",
            'repos' => "https://api.github.com/users/<login>/repos?sort=created&direction=asc"
        ];
    }

    /**
     * @param string $requiredResponse
     * @return RequestAdapter
     * @throws \Exception
     */
    private function mockRequestAdapter(string $requiredResponse): RequestAdapter
    {
        $mock = new MockHandler(
            [
                new Response(200, [], $requiredResponse),
            ]
        );
        $config = [
            'allowed_responses' => [200, 404],
            'options' => ['http_errors' => false],
        ];

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $containerBag = Stub::makeEmpty(
            ParameterBagInterface::class,
            [
                'get' => Expected::once($config),
            ]
        );
        $logger = $this->makeEmpty(
            Logger::class,
            [
                'error' => Expected::never(),
            ]
        );

        $httpClient = $this->make(HttpClient::class, [
            'getClient' => $client
        ]);

        return new RequestAdapter($httpClient, $logger, $containerBag);
    }

    /**
     * @param RequestAdapter $requestAdapter
     * @return ApiConsumer
     * @throws \Exception
     */
    private function mockApiConsumer(RequestAdapter $requestAdapter): ApiConsumer
    {
        $containerBag = Stub::makeEmpty(
            ParameterBagInterface::class,
            [
                'get' => Expected::once(['timeout' => 15]),
            ]
        );
        return new ApiConsumer($requestAdapter, $containerBag);
    }
}
