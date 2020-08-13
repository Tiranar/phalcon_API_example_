<?php

namespace App\Api\Middlewares;

use App\Api\Controllers\BaseController;
use App\Api\Models\DevelopersAccounts;
use App\Api\Models\Organisations;

class IdentityMiddleware extends BaseController
{
    public function beforeExecuteRoute()
    {
        $token = $this->getToken();
        if ($token) {
            try {
                $token_decoded = $this->decodeToken($token);
                if ($token_decoded) {

                    if (!$this->identity->setToken($token, $token_decoded)) {
                        $this->buildErrorResponse(401, "common.WRONG_TOKEN");
                    }
                }
            } catch (\Exception $e) {
                $this->buildErrorResponse(401, "common.WRONG_TOKEN");
            }
        }

        return;
    }
}