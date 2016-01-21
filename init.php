<?php

require_once 'classes/Autoload.php';

$loader = new Landingo\Resources\Autoload();
$loader->register();

$app = new Landingo\Resources\Application();
$app->start();