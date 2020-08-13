<?php

namespace App\Api\Middlewares;

use App\Api\Controllers\BaseController;
use Sinergi\BrowserDetector\Browser;

class ApiMiddleware extends BaseController
{

    public function beforeExecuteRoute()
    {
        $browser = new Browser();

        if ($browser->getName() !== Browser::UNKNOWN) {
            $this->buildErrorResponse(400, 'common.NOT_AJAX');
        }
        return;
    }

    /* public function beforeExecuteRoute()
     {
         $dev_acc = DevelopersAccounts::findFirst();

         $origin = 'TdChZPyRsFv1YVJlYpxV13g5eTu0fSQs';

         $decrypted = $this->encrypter->decryptString($dev_acc->acc_secret);

         $resp = [
            // 'key' => $key,
             'origin' => $origin,
             'decrypted' => $decrypted
         ];

         echo '<pre>';
         var_dump($resp);
         echo '</pre>';

         die();

         return;
     }
    */

}