<?php

namespace App\Api;

use App\Api\Classes\Identity;
use App\Api\Middlewares\AccessMiddleware;
use App\Api\Middlewares\ApiMiddleware;
use App\Api\Middlewares\CORSMiddleware;
use App\Api\Middlewares\IdentityMiddleware;
use App\Library\Encrypter;
use App\Library\Localisation;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View\Simple as View;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers the module auto-loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
                'App\Api\Controllers' => APP_PATH . '/modules/api/controllers/',
                'App\Api\Models' => APP_PATH . '/modules/api/models/',

                'App\Api\Requests\Token' => APP_PATH . '/modules/api/requests/token',
                'App\Api\Requests\User' => APP_PATH . '/modules/api/requests/user',

                'App\Api\Middlewares' => APP_PATH . '/modules/api/middlewares',
                'App\Api\Classes' => APP_PATH . '/modules/api/classes',
            ]
        );
        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        // Registering a dispatcher
        $di->set('dispatcher', function () use ($di) {

            $em = new EventsManager();

            $em->attach('dispatch:beforeExecuteRoute', new CORSMiddleware());
            $em->attach('dispatch:beforeExecuteRoute', new ApiMiddleware());
             $em->attach('dispatch:beforeExecuteRoute', new IdentityMiddleware());
            //todo: add Localisation middleware
             $em->attach('dispatch:beforeExecuteRoute', new AccessMiddleware());

            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace('App\Api\Controllers\\');

            $dispatcher->setEventsManager($em);

            return $dispatcher;
        });

        /**
         *  Shared Localisation
         */
        $di->setShared('localisation', function () {
            return new Localisation();
        });

        $di->setShared('identity', function () use ($di) {
            return new Identity($di);
        });

        $di->setShared('encrypter', function () use ($di) {
            $key = $di->getShared('config')['authentication']['encryption_key'];
            $key = base64_decode($key);
            return new Encrypter($key, 'AES-256-CBC');
        });

        /*$di->set('simple_view', function () {
            $view = new View();
            $view->setViewsDir(APP_PATH . '/modules/api/views/');
            return $view;
        });*/

    }
}