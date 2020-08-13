<?php

namespace App\Api\Models;

class DevelopersAccountsOrganisations extends \App\Mappers\DevelopersAccountsOrganisations
{

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('dev_acc_id', 'App\Api\Models\DevelopersAccounts', 'id', ['alias' => 'DevelopersAccounts']);
        $this->belongsTo('org_id', 'App\Api\Models\Organisations', 'id', ['alias' => 'Organisations']);
    }

}