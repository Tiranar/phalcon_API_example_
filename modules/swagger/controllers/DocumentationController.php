<?php

namespace App\Swagger\Controllers;

use Phalcon\Mvc\Controller;

class DocumentationController extends Controller
{

    public function indexAction()
    {
        echo $this->simple_view->render('index.phtml');
        die();
    }

    public function nfAction()
    {
        $this->response->redirect('');
        $this->view->disable();
    }


}