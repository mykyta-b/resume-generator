<?php
declare(strict_types=1);

namespace App\Tests\Integration\Services\Gateway;

use App\DTO\RepoDTO;
use App\DTO\RepoListDTO;
use App\Service\Gateway\ReposApiGateway;

use App\Tests\Helpers\Traits\IntegrationTestMocks;
use App\Tests\Helpers\Traits\ReposApiMockTrait;
use Codeception\Stub;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ReposApiGatewayTest extends Unit
{
    use IntegrationTestMocks;
    use ReposApiMockTrait;

    /**
     * @test
     */
    public function givenInvalidApiResponseWhenGetByLoginThenReturnError(): void
    {
        $requiredResponse = $this->mockReposApiErrorResponse();
        $requestAdapter = $this->mockRequestAdapter($requiredResponse);
        $apiConsumer = $this->mockApiConsumer($requestAdapter);

        $container = $this->getModule('Symfony')->_getContainer();

        $config = $this->getUserApiGatewayConfig();
        $containerBag = Stub::makeEmpty(ParameterBagInterface::class, [
            'get' => Expected::once($config),
        ]);
        $logger = $this->makeEmpty(Logger::class, [
            'error' => Expected::once()
        ]);

        $userApi = new ReposApiGateway(
            $apiConsumer,
            $container->get('serializer'),
            $containerBag,
            $logger
        );

        $expected = (new RepoListDTO())->setMessage('Not Found');

        $result = $userApi->getByLogin('mxcl');

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function givenValidApiResponseWhenGetByLoginThenReturnValidResult(): void
    {
        $requiredResponse = $this->mockReposApiResponse();
        $requestAdapter = $this->mockRequestAdapter($requiredResponse);
        $apiConsumer = $this->mockApiConsumer($requestAdapter);

        $container = $this->getModule('Symfony')->_getContainer();

        $config = $this->getUserApiGatewayConfig();
        $containerBag = Stub::makeEmpty(ParameterBagInterface::class, [
            'get' => Expected::once($config),
        ]);
        $logger = $this->makeEmpty(Logger::class, [
            'error' => Expected::never()
        ]);

        $userApi = new ReposApiGateway(
            $apiConsumer,
            $container->get('serializer'),
            $containerBag,
            $logger
        );

        $expected = (new RepoListDTO())
            ->setRepos([
                           (new RepoDTO())
                               ->setLanguage('')
                               ->setSize(83)
                               ->setCreated(new \DateTime("2009-03-11 10:24:26.000000+0000")),
                           (new RepoDTO())
                               ->setLanguage("Objective-C")
                               ->setSize(1039)
                               ->setCreated(new \DateTime("2009-03-21 17:23:47.000000+0000")),
                           (new RepoDTO())
                               ->setLanguage("C")
                               ->setSize(123)
                               ->setCreated(new \DateTime("2009-06-09 22:43:00.000000+0000")),

                       ]);

        $result = $userApi->getByLogin('mxcl');

        $this->assertEquals($expected, $result);
    }
}
