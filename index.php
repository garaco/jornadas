<?php

require_once "vendor/autoload.php";

use App\Router\Router;

$r = new Router();

echo $r->run();
