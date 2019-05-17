<?php
declare(strict_types=1);

namespace Nerdery\ServiceProvider;

use Doctrine\ORM\EntityManager;
use Nerdery\Action\AddParticipant;
use Nerdery\Action\AddRoster;
use Nerdery\Action\AddScore;
use Nerdery\Action\CreateEvent;
use Nerdery\Action\CreateTeam;
use Nerdery\Action\DeleteEvent;
use Nerdery\Action\DeleteTeam;
use Nerdery\Action\IndexAction;
use Nerdery\Action\ListEvents;
use Nerdery\Action\ListParticipants;
use Nerdery\Action\ListRoster;
use Nerdery\Action\ListScores;
use Nerdery\Action\ListTeams;
use Nerdery\Action\ReadEvent;
use Nerdery\Action\ReadTeam;
use Nerdery\Action\RemoveParticipant;
use Nerdery\Action\RemoveRoster;
use Nerdery\Action\RemoveScore;
use Nerdery\Action\UpdateEvent;
use Nerdery\Action\UpdateTeam;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * A ServiceProvider for registering services in a DI container.
 */
class DependencyProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        $container[IndexAction::class] = function (Container $container): IndexAction {
            return new IndexAction($container[EntityManager::class]);
        };

        $container[ListEvents::class] = function (Container $container): ListEvents {
            return new ListEvents($container[EntityManager::class]);
        };

        $container[CreateEvent::class] = function (Container $container): CreateEvent {
            return new CreateEvent($container[EntityManager::class]);
        };

        $container[ReadEvent::class] = function (Container $container): ReadEvent {
            return new ReadEvent($container[EntityManager::class]);
        };

        $container[UpdateEvent::class] = function (Container $container): UpdateEvent {
            return new UpdateEvent($container[EntityManager::class]);
        };

        $container[DeleteEvent::class] = function (Container $container): DeleteEvent {
            return new DeleteEvent($container[EntityManager::class]);
        };

        $container[ListTeams::class] = function (Container $container): ListTeams {
            return new ListTeams($container[EntityManager::class]);
        };

        $container[CreateTeam::class] = function (Container $container): CreateTeam {
            return new CreateTeam($container[EntityManager::class]);
        };

        $container[ReadTeam::class] = function (Container $container): ReadTeam {
            return new ReadTeam($container[EntityManager::class]);
        };

        $container[UpdateTeam::class] = function (Container $container): UpdateTeam {
            return new UpdateTeam($container[EntityManager::class]);
        };

        $container[DeleteTeam::class] = function (Container $container): DeleteTeam {
            return new DeleteTeam($container[EntityManager::class]);
        };

        $container[ListRoster::class] = function (Container $container): ListRoster {
            return new ListRoster($container[EntityManager::class]);
        };

        $container[AddRoster::class] = function (Container $container): AddRoster {
            return new AddRoster($container[EntityManager::class]);
        };

        $container[RemoveRoster::class] = function (Container $container): RemoveRoster {
            return new RemoveRoster($container[EntityManager::class]);
        };

        $container[ListParticipants::class] = function (Container $container): ListParticipants {
            return new ListParticipants($container[EntityManager::class]);
        };

        $container[AddParticipant::class] = function (Container $container): AddParticipant {
            return new AddParticipant($container[EntityManager::class]);
        };

        $container[RemoveParticipant::class] = function (Container $container): RemoveParticipant {
            return new RemoveParticipant($container[EntityManager::class]);
        };

        $container[ListScores::class] = function (Container $container): ListScores {
            return new ListScores($container[EntityManager::class]);
        };

        $container[AddScore::class] = function (Container $container): AddScore {
            return new AddScore($container[EntityManager::class]);
        };

        $container[RemoveScore::class] = function (Container $container): RemoveScore {
            return new RemoveScore($container[EntityManager::class]);
        };
    }
}