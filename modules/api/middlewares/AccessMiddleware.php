<?php

namespace App\Api\Middlewares;

use App\Api\ACL;
use App\Api\Controllers\BaseController;

class AccessMiddleware extends BaseController
{
    public function beforeExecuteRoute()
    {
        $controller = $this->dispatcher->getControllerName();
        $action = $this->dispatcher->getActionName();
        $acl = new ACL();

        if ($this->identity->isOrganisation()) {
            $role = 'Organisation';
        } elseif ($this->identity->isDeveloper()) {
            $role = 'Developer';
        } else {
            $role = 'Guest';
        }

        if (!$acl->isAllowed($role, $controller, $action)) {
            $this->buildErrorResponse(403, 'common.ACCESS_DENIED', [$acl]);
        }

    }

}