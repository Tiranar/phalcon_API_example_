<?php

namespace App\Api\Models;

class DevelopersAccounts extends \App\Mappers\DevelopersAccounts
{

    public static $hiddenAttributes = ['id', 'acc_secret', 'created_at', 'dev_token_issued_at', 'updated_at'];

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\DevelopersAccountsOrganisations', 'dev_acc_id', ['alias' => 'DevelopersAccountsOrganisations']);
    }

}