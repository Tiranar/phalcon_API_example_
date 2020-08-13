<?php

namespace App\Swagger;

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
                'App\Swagger\Controllers' => APP_PATH . '/modules/swagger/controllers/'
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
        $di->set('dispatcher', function () {

            $em = new EventsManager();

            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace('App\Swagger\Controllers\\');

            $dispatcher->setEventsManager($em);

            return $dispatcher;
        });

        $di->set('simple_view', function () {
            $view = new View();
            $view->setViewsDir(APP_PATH . '/modules/swagger/views/');
            return $view;
        });
    }
}