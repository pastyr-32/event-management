<?php
declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Container;

/** @var Container $container */
$container = require_once __DIR__ . '/src/config/bootstrap.php';
return ConsoleRunner::createHelperSet($container[EntityManager::class]);