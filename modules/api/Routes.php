<?php

namespace App\Api;

use Phalcon\Mvc\Router;

class Routes extends Router
{

    private static $url_suffix = '/api/';

    public function __construct($defaultRoutes = true)
    {
        parent::__construct($defaultRoutes);

        $this->removeExtraSlashes(true);

        $this->token_routes();
        $this->organisation_routes();
        $this->course_routes();

        $this->notFound([
            'module' => 'api',
            'controller' => 'system',
            'action' => 'notFound'
        ]);

        return $this;
    }


    private function token_routes()
    {

        $this->add(self::$url_suffix . 'tokens/developer_token', [
            'module' => 'api',
            'controller' => 'token',
            'action' => 'devToken'
        ], ['POST']);

        $this->add(self::$url_suffix . 'tokens/organisation_token', [
            'module' => 'api',
            'controller' => 'token',
            'action' => 'orgToken'
        ], ['POST']);

        $this->add(self::$url_suffix . 'tokens/validate', [
            'module' => 'api',
            'controller' => 'token',
            'action' => 'validate'
        ], ['POST']);

    }

    private function organisation_routes()
    {
        $this->add(self::$url_suffix . 'organisations/list', [
            'module' => 'api',
            'controller' => 'organisation',
            'action' => 'getList'
        ], ['GET']);

        $this->add(self::$url_suffix . 'organisations/list_users', [
            'module' => 'api',
            'controller' => 'organisation',
            'action' => 'getUsersList'
        ], ['GET']);

        $this->add(self::$url_suffix . 'organisations/create_user', [
            'module' => 'api',
            'controller' => 'organisation',
            'action' => 'createUser'
        ], ['POST']);
        
    }
    
    private function course_routes()
    {
        $this->add(self::$url_suffix . 'courses/list', [
            'module' => 'api',
            'controller' => 'course',
            'action' => 'getList'
        ], ['GET']);
    }
}