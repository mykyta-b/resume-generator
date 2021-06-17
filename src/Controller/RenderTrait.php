<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

trait RenderTrait
{
    /**
     * @param string $view
     * @param array $param
     * @return Response
     */
    private function render(string $view, array $param): Response
    {
        $response = new Response();
        return $response->setContent(
            $this->twig->render($view, $param)
        );
    }
}
