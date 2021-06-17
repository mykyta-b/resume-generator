<?php

namespace App\EventListener;

use App\Controller\RenderTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class ExceptionListener
{
    use RenderTrait;

    /**
     * @var Environment
     */
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $code = $exception instanceof NotFoundHttpException ? Response::HTTP_BAD_REQUEST : Response::HTTP_INTERNAL_SERVER_ERROR;
        $response = $this->render("error.html.twig", [
            'errors' => [$exception->getMessage()],
        ]);
        $event->setResponse(
            new Response(
                $response,
                $code
            )
        );
    }
}
