<?php

use App\Kernel;

// router.php
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
}

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';


return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
