<?php
declare(strict_types=1);

namespace Nerdery\ServiceProvider;

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
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * A ServiceProvider for registering services related
 * to Slim such as request handlers, routing and the
 * App service itself.
 */
class AppProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        /** Initialize App */
        $container[App::class] = function (Container $container): App {
            $app = new App($container);

            /** Configure CORS */
            $app->options('/{routes:.+}', function (Request $request, Response $response, $args) {
                return $response;
            });
            $app->add(function ($req, $res, $next) {
                $response = $next($req, $res);
                return $response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            });

            /** Register Endpoints */
            $app->group('/event', function (App $app) {
                $app->get('',ListEvents::class)->setName('event_index');
                $app->post('',CreateEvent::class)->setName('event_create');
                $app->get('/{id}',ReadEvent::class)->setName('event_read');
                $app->put('/{id}',UpdateEvent::class)->setName('event_update');
                $app->delete('/{id}',DeleteEvent::class)->setName('event_delete');
            });

            $app->group('/event/{id}/participant', function (App $app) {
                $app->get('',ListParticipants::class)->setName('participant_index');
                $app->post('',AddParticipant::class)->setName('participant_add');
                $app->delete('/{pid}',RemoveParticipant::class)->setName('participant_remove');
            });

            $app->group('/event/{id}/participant/{pid}/score', function (App $app) {
                $app->get('',ListScores::class)->setName('score_index');
                $app->post('',AddScore::class)->setName('score_add');
                $app->delete('/{sid}',RemoveScore::class)->setName('score_remove');
            });

            $app->group('/team', function (App $app) {
                $app->get('',ListTeams::class)->setName('team_index');
                $app->post('',CreateTeam::class)->setName('team_create');
                $app->get('/{id}',ReadTeam::class)->setName('team_read');
                $app->put('/{id}',UpdateTeam::class)->setName('team_update');
                $app->delete('/{id}',DeleteTeam::class)->setName('team_delete');
            });

            $app->group('/team/{id}/roster', function (App $app) {
                $app->get('',ListRoster::class)->setName('roster_index');
                $app->post('',AddRoster::class)->setName('roster_add');
                $app->delete('/{rid}',RemoveRoster::class)->setName('roster_remove');
            });

            $app->get('/', IndexAction::class)->setName('index');

            return $app;
        };
    }
}