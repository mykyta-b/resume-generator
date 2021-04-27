<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ResumeFormatter;
use App\Service\ResumeParser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ResumeController
{
    use RenderTrait;

    /**
     * @var ResumeParser
     */
    private ResumeParser $parser;
    /**
     * @var Environment
     */
    private Environment $twig;
    /**
     * @var ResumeFormatter
     */
    private ResumeFormatter $formatter;

    public function __construct(
        ResumeParser $parser,
        ResumeFormatter $formatter,
        Environment $twig
    ) {
        $this->parser = $parser;
        $this->twig = $twig;
        $this->formatter = $formatter;
    }

    /**
     * @Route("/",
     *     name="default",
     *     methods={"GET"}
     * )
     */
    public function indexAction()
    {
        return $this->render('index.html.twig', []);
    }

    /**
     * @Route("/{login}",
     *     name="resumeGenerator",
     *     methods={"GET"},
     *     requirements={"login" = "^[a-zA-Z\d][a-zA-Z\d_\-]{2,38}(?<=[^\-])$"}
     * )
     * @param string $login
     * @return Response
     */
    public function resumeGeneratorAction(string $login)
    {
        $resumeDTO = $this->parser->parseUserResume($login);

        if (!empty($resumeDTO->getErrors())) {
            return $this->render('error.html.twig', [
                'errors' => $this->formatter->formatErrors($resumeDTO),
                'isApiResponse' => 1
            ]);
        }

        return $this->render('resume.html.twig', [
            'htmlData' => $this->formatter->format($resumeDTO),
        ]);
    }
}
