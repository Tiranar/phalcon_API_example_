<?php

namespace App\Swagger;

use Phalcon\Mvc\Router;

class Routes extends Router
{

    public function __construct($defaultRoutes = true)
    {
        parent::__construct($defaultRoutes);

        $this->removeExtraSlashes(true);

        $this->setDefaultModule('swagger');
        $this->setDefaultController('documentation');
        $this->setDefaultAction('index');

        $this->add('/', [
            'module' => 'swagger',
            'controller' => 'documentation',
            'action' => 'index'
        ], ['GET']);

        $this->notFound([
            'module' => 'swagger',
            'controller' => 'documentation',
            'action' => 'nf'
        ]);

        return $this;
    }
}