<?php
declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\ResumeController;
use App\DTO\RepoDTO;
use App\DTO\RepoListDTO;
use App\DTO\ResumeDTO;
use App\DTO\UserDTO;
use App\Service\ResumeFormatter;
use App\Service\ResumeParser;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @group controller
 */
class ResumeControllerTest extends Unit
{
    /**
     * @test
     * @throws \Exception
     */
    public function givenHomeRouteWhenIndexActionThenRenderHomePage(): void
    {
        $parser = $this->makeEmpty(ResumeParser::class);
        $formatter = $this->makeEmpty(ResumeFormatter::class);
        $twig = $this->make(Environment::class, [
            'render' => Expected::once('Home page content')
        ]);

        $expected = (new Response())->setContent('Home page content');

        $controller = new ResumeController($parser, $formatter, $twig);
        $result = $controller->indexAction();


        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals($expected, $expected);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function givenValidUserWhenResumeGeneratorActionThenRenderResume(): void
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
        $resumeDto = (new ResumeDTO())
            ->setUser($user)
            ->setRepos($repoList);

        $parser = $this->getParserMock();
        $parser->expects($this->once())->method('parseUserResume')
            ->with('mxcl')
            ->willReturn($resumeDto);

        $formatter = $this->make(ResumeFormatter::class, [
            'format' => Expected::once(['Resume page content'])
        ]);
        $twig = $this->make(Environment::class, [
            'render' => Expected::once('Resume page content')
        ]);

        $expected = (new Response())->setContent('Resume page content');

        $controller = new ResumeController($parser, $formatter, $twig);
        $result = $controller->resumeGeneratorAction('mxcl');


        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals($expected, $expected);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function givenApiErrorWhenResumeGeneratorActionThenRenderErrorPage(): void
    {
        $user = (new UserDTO());
        $repoList = (new RepoListDTO());
        $resumeDto = (new ResumeDTO())
            ->setUser($user)
            ->setRepos($repoList)
            ->setErrors(['Not Found']);

        $parser = $this->getParserMock();
        $parser->expects($this->once())->method('parseUserResume')
            ->with('mxcl')
            ->willReturn($resumeDto);

        $formatter = $this->make(ResumeFormatter::class, [
            'formatErrors' => Expected::once(['Not Found'])
        ]);
        $twig = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render'])
            ->getMock();

        $twig->expects($this->once())->method('render')
            ->with('error.html.twig', [
                'errors' => ['Not Found'],
                'isApiResponse' => 1
            ])->willReturn('Error page content');

        $expected = (new Response())->setContent('Error page content');

        $controller = new ResumeController($parser, $formatter, $twig);
        $result = $controller->resumeGeneratorAction('mxcl');

        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals($expected, $expected);
    }

    /**
     * @return MockObject
     */
    private function getParserMock(): MockObject
    {
        return $this->getMockBuilder(ResumeParser::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['parseUserResume'])
            ->getMock();

    }
}
