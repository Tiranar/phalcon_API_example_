<?php

namespace App\Api\Controllers;


class SystemController extends BaseController
{
    /**
     * Not Found Action
     */
    public function notFoundAction()
    {
        $this->buildErrorResponse(404, 'common.THERE_HAS_BEEN_AN_ERROR');
    }
}