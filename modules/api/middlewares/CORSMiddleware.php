<?php

namespace App\Api\Middlewares;


use App\Api\Controllers\BaseController;

class CORSMiddleware extends BaseController
{

    public function beforeExecuteRoute()
    {
        $this->response->setHeader("Access-Control-Allow-Credentials", 'true');
        $this->response->setHeader(
            "Access-Control-Allow-Headers",
            "Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type, Authorization"
        );
        $this->response->setHeader(
            "Access-Control-Allow-Methods",
            "GET, PATCH, PUT, POST, DELETE, OPTIONS"
        );
        $this->response->setHeader("Access-Control-Allow-Origin", $this->getDI()->get('request')->getHeader('Origin'));
        $this->response->setHeader(
            "Content-Type", "application/json; charset=UTF-8"
        );

        if ($this->request->isOptions()) {

            $content = array();
            $content["status"] = 200;
            $content["message"] = "OK";

            $this->response->setJsonContent($content);
            $this->response->setStatusCode(200, "OK");
            $this->response->send();
            die();
        }

        return true;
    }
}