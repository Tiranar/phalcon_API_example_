<?php

namespace App\Api\Models;

class UsersOrganisations extends \App\Mappers\UsersOrganisations
{

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('organisation_id', 'App\Api\Models\Organisations', 'id', ['alias' => 'Organisations']);
        $this->belongsTo('user_id', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
    }

}