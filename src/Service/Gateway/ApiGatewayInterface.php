<?php

namespace App\Service\Gateway;

interface ApiGatewayInterface
{
    public function getByLogin(string $login);
}
