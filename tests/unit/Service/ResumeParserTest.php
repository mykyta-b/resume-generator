<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\DTO\RepoDTO;
use App\DTO\RepoListDTO;
use App\DTO\ResumeDTO;
use App\DTO\UserDTO;
use App\Service\Gateway\ReposApiGateway;
use App\Service\Gateway\UserApiGateway;
use App\Service\ResumeParser;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;

/**
 * Class ResumeParserTest
 * @package App\Tests\Unit\Service
 * @group resumeparser
 * @group services
 */
class ResumeParserTest extends Unit
{

    /**
     * @test
     * @throws \Exception
     */
    public function givenValidUserWhenParseResumeThenReturnResponse()
    {
        $user = (new UserDTO())
            ->setLocation('Los Angeles, California')
            ->setName('Howel Thomas')
            ->setWebsite('http://example.com')
            ->setLogin('mxcl');
        $repoList = (new RepoListDTO())
            ->setRepos([
                           (new RepoDTO())
                               ->setLanguage("Ruby")
                               ->setSize(234)
                               ->setCreated(new \DateTime("2010-01-12")),

                       ]);
        $repoApi = $this->make(ReposApiGateway::class, [
            'getByLogin' => Expected::once($repoList),
        ]);

        $userApi = $this->make(UserApiGateway::class, [
            'getByLogin' => Expected::once($user),
        ]);

        $parser = new ResumeParser($userApi, $repoApi);

        $expected = (new ResumeDTO())->setUser($user)->setRepos($repoList);

        $result = $parser->parseUserResume('mxcl');

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function givenUserApiErrorWhenParseResumeThenReturnResponse()
    {
        $user = (new UserDTO())
            ->setMessage('Not Found');
        $repoList = (new RepoListDTO())
            ->setRepos([
                           (new RepoDTO())
                               ->setLanguage("Ruby")
                               ->setSize(234)
                               ->setCreated(new \DateTime("2010-01-12")),

                       ]);
        $repoApi = $this->make(ReposApiGateway::class, [
            'getByLogin' => Expected::once($repoList),
        ]);

        $userApi = $this->make(UserApiGateway::class, [
            'getByLogin' => Expected::once($user),
        ]);

        $parser = new ResumeParser($userApi, $repoApi);

        $expected = (new ResumeDTO())->setErrors(['Not Found']);

        $result = $parser->parseUserResume('mxcl');

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function givenReposApiErrorWhenParseResumeThenReturnResponse()
    {
        $user = (new UserDTO())
            ->setLocation('Los Angeles, California')
            ->setName('Howel Thomas')
            ->setWebsite('http://example.com')
            ->setLogin('mxcl');
        $repoList = (new RepoListDTO())
            ->setMessage('Not Found');
        $repoApi = $this->make(ReposApiGateway::class, [
            'getByLogin' => Expected::once($repoList),
        ]);

        $userApi = $this->make(UserApiGateway::class, [
            'getByLogin' => Expected::once($user),
        ]);

        $parser = new ResumeParser($userApi, $repoApi);

        $expected = (new ResumeDTO())->setErrors(['Not Found']);

        $result = $parser->parseUserResume('mxcl');

        $this->assertEquals($expected, $result);
    }
}
