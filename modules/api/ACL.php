<?php

namespace App\Api;

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl as Phalcon_Acl;
use Phalcon\Acl\Resource;

class ACL extends Memory
{
    /**
     * @var array
     */
    private $resources = [
        'Guest' => [
            'system' => ['notFound'],
            'token' => ['devToken']
        ],
        'Developer' => [
            'system' => ['notFound'],
            'token' => ['validate', 'orgToken'],
            'organisation' => ['getList']
        ],
        'Organisation' => [
            'system' => ['notFound'],
            'token' => ['validate'],
            // 'course' => ['getList'],
            'organisation' => ['getUsersList', 'createUser']
        ]
    ];

    /**
     * Identity constructor.
     */
    public function __construct()
    {
        // The default action is DENY access
        $this->setDefaultAction(Phalcon_Acl::DENY);

        /*
         * ROLES
         * PrimaryUser - can do anything (Guest, SubUser, and own things)
         * SubUser - can do most things (Guest and own things)
         * Guest - Public
         * */
        $this->addRole(new Role('Guest'));
        $this->addRole(new Role('Developer'));
        $this->addRole(new Role('Organisation'));


        //create Resources
        foreach ($this->resources as $arrResource) {
            foreach ($arrResource as $controller => $arrMethods) {
                $this->addResource(new Resource($controller), $arrMethods);
            }
        }

        foreach ($this->getRoles() as $objRole) {
            $roleName = $objRole->getName();

            // Guests
            if ($roleName == 'Guest') {
                foreach ($this->resources['Guest'] as $resource => $method) {
                    $this->allow($roleName, $resource, $method);
                }
            }

            // Developers
            if ($roleName == 'Developer') {
                foreach ($this->resources['Developer'] as $resource => $method) {
                    $this->allow($roleName, $resource, $method);
                }
            }

            // Organisations
            if ($roleName == 'Organisation') {
                foreach ($this->resources['Organisation'] as $resource => $method) {
                    $this->allow($roleName, $resource, $method);
                }
            }
        }

        return $this;

    }

}