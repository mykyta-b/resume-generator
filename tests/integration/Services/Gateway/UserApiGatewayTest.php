<?php
declare(strict_types=1);

namespace App\Tests\Integration\Services\Gateway;

use App\DTO\UserDTO;
use App\Service\Gateway\Consumer\ApiConsumer;
use App\Service\Gateway\UserApiGateway;
use App\Tests\Helpers\Traits\IntegrationTestMocks;
use App\Tests\Helpers\Traits\UserApiMockTrait;
use Codeception\Stub;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class UserApiGatewayTest
 * @package App\Tests\Integration\Services\Gateway
 * @group integration
 */
class UserApiGatewayTest extends Unit
{
    use UserApiMockTrait;
    use IntegrationTestMocks;

    /**
     * @test
     */
    public function givenValidUserWhenGetByLoginThenReturnUserDto(): void
    {
        $requiredResponse = $this->mockUserApiResponse();
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

        $userApi = new UserApiGateway(
            $apiConsumer,
            $container->get('serializer'),
            $containerBag,
            $logger
        );

        $expected = (new UserDTO())
            ->setLogin('mxcl')
            ->setCreated(new \DateTime('2009-02-28T22:54:13Z'))
            ->setWebsite('https://mxcl.dev')
            ->setName('Max Howell')
            ->setLocation('Savannah, GA')
            ->setFollowers(6094)
            ->setPublicRepos(57)
            ->setAvatar('https://avatars.githubusercontent.com/u/58962?v=4')
        ;

        $result = $userApi->getByLogin('mxcl');

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function givenInvalidApiResponseWhenGetByLoginThenReturnError(): void
    {
        $requiredResponse = $this->mockUserApiErrorResponse();
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

        $userApi = new UserApiGateway(
            $apiConsumer,
            $container->get('serializer'),
            $containerBag,
            $logger
        );

        $expected = (new UserDTO())->setMessage('Not Found');

        $result = $userApi->getByLogin('mxcl');

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function givenEmptyApiResponseWhenGetByLoginThenReturnError(): void
    {
        $apiConsumer = $this->make(ApiConsumer::class, [
            'request' => Expected::once(''),
        ]);
        $container = $this->getModule('Symfony')->_getContainer();

        $config = $this->getUserApiGatewayConfig();
        $containerBag = Stub::makeEmpty(ParameterBagInterface::class, [
            'get' => Expected::once($config),
        ]);
        $logger = $this->makeEmpty(Logger::class, [
            'error' => Expected::once()
        ]);

        $userApi = new UserApiGateway(
            $apiConsumer,
            $container->get('serializer'),
            $containerBag,
            $logger
        );

        $expected = (new UserDTO())->setMessage('Bad response of github user api');

        $result = $userApi->getByLogin('mxcl');

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function givenEmptyArrayApiResponseWhenGetByLoginThenReturnError(): void
    {
        $requiredResponse = '[]';
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

        $userApi = new UserApiGateway(
            $apiConsumer,
            $container->get('serializer'),
            $containerBag,
            $logger
        );

        $expected = (new UserDTO())->setMessage('Bad response of github user api');

        $result = $userApi->getByLogin('mxcl');

        $this->assertEquals($expected, $result);
    }
}
