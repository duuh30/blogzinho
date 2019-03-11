<?php

// cli-config.php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Container;

require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

require_once __DIR__ . '/src/dependencies.php';

ConsoleRunner::run(
    ConsoleRunner::createHelperSet($container['entityManager'])
);