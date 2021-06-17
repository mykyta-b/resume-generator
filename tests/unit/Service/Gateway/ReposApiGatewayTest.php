<?php
declare(strict_types=1);


namespace App\Tests\Unit\Service\Gateway;


use App\DTO\ErrorDTO;
use App\DTO\RepoDTO;
use App\DTO\RepoListDTO;
use App\Service\Gateway\Consumer\ApiConsumer;
use App\Service\Gateway\ReposApiGateway;
use App\Tests\Helpers\Traits\ReposApiMockTrait;
use Codeception\Stub;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use DG\BypassFinals;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * @group reposapi
 * @group services
 */
class ReposApiGatewayTest extends Unit
{
    use ReposApiMockTrait;

    public function setUp(): void
    {
        BypassFinals::enable();
    }

    /**
     * @throws \Exception
     * @test
     */
    public function givenApiRequestReturnsValidResultWhenGetByLoginThenReturnResponse(): void
    {
        $apiConsumer = $this->make(ApiConsumer::class, [
            'request' => Expected::once('[
                valid json response
            ]')
        ]);
        $serializer = $this->getSerializerMock();
        $serializer->expects($this->exactly(2))->method('deserialize')->willReturnOnConsecutiveCalls(
            (new ErrorDTO()),
            [
                (new RepoDTO())
                    ->setLanguage("Ruby")
                    ->setSize(234)
                    ->setCreated(new \DateTime("2010-01-12")),
                (new RepoDTO())
                    ->setLanguage("Ruby")
                    ->setSize(2001)
                    ->setCreated(new \DateTime("2012-04-27")),

            ]
        );
        $config = [
            'users' => "https://api.github.com/users/<login>",
            'repos' => "https://api.github.com/users/<login>/repos?sort=created&direction=asc"
        ];
        $containerBag = Stub::makeEmpty(ParameterBagInterface::class, [
            'get' => Expected::once($config),
        ]);
        $logger = $this->makeEmpty(Logger::class, [
            'error' => Expected::never()
        ]);
        $expected = (new RepoListDTO())
            ->setRepos([
                           (new RepoDTO())
                               ->setLanguage("Ruby")
                               ->setSize(234)
                               ->setCreated(new \DateTime("2010-01-12")),
                           (new RepoDTO())
                               ->setLanguage("Ruby")
                               ->setSize(2001)
                               ->setCreated(new \DateTime("2012-04-27")),

                       ]);

        $repoApi = new ReposApiGateway($apiConsumer, $serializer,  $containerBag, $logger);

        $result = $repoApi->getByLogin('gitLoginNotExists');

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function givenApiRequestReturnErrorWhenGetByLoginThenReturnError():void
    {
        $apiConsumer = $this->make(ApiConsumer::class, [
            'request' => Expected::once($this->mockReposApiErrorResponse())
        ]);
        $serializer = $this->getSerializerMock();
        $serializer->expects($this->once())->method('deserialize')->willReturn(
            (new ErrorDTO())->setMessage('Not Found')
        );
        $config = [
            'users' => "https://api.github.com/users/<login>",
            'repos' => "https://api.github.com/users/<login>/repos?sort=created&direction=asc"
        ];
        $containerBag = Stub::makeEmpty(ParameterBagInterface::class, [
            'get' => Expected::once($config),
        ]);
        $logger = $this->makeEmpty(Logger::class, [
            'error' => Expected::once()
        ]);
        $expected = (new RepoListDTO())->setMessage('Not Found');

        $repoApi = new ReposApiGateway($apiConsumer, $serializer,  $containerBag, $logger);

        $result = $repoApi->getByLogin('gitLoginNotExists');

        $this->assertEquals($expected, $result);
    }

    /**
     * @return MockObject
     */
    private function getSerializerMock(): MockObject
    {
        return $this->getMockBuilder(Serializer::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['deserialize'])
            ->getMock();
    }
}
