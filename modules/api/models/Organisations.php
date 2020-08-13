<?php

namespace App\Api\Models;

class Organisations extends \App\Mappers\Organisations
{

    public static $hiddenAttributes = ['id', 'logo_id', 'cover_picture_id', 'created_at', 'updated_at', 'deleted_at'];

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\Certificates', 'org_id', ['alias' => 'Certificates']);
        $this->hasMany('id', 'App\Api\Models\DevelopersAccountsOrganisations', 'org_id', ['alias' => 'DevelopersAccountsOrganisations']);
        $this->hasMany('id', 'App\Api\Models\Marketplace', 'organisation_id', ['alias' => 'Marketplace']);
        $this->hasMany('id', 'App\Api\Models\Users', 'last_seen_org_id', ['alias' => 'Users']);
        $this->hasMany('id', 'App\Api\Models\UsersCourses', 'organisation_id', ['alias' => 'UsersCourses']);
        $this->hasMany('id', 'App\Api\Models\UsersOrganisations', 'organisation_id', ['alias' => 'UsersOrganisations']);
    }

}