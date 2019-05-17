<?php
declare(strict_types=1);

namespace Nerdery\ServiceProvider;

use Doctrine\ORM\EntityManager;
use Nerdery\Action\ListEndpoints;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;

/**
 * A ServiceProvider for registering services related to
 * Monolog in a DI container.
 */
class MonologProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        $container['logger'] = function ($container) {
            $settings = $container->get('settings')['logger'];

            $logger = new \Monolog\Logger($settings['name']);

            $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
            $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

            return $logger;
        };
    }
}