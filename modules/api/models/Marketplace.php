<?php

namespace App\Api\Models;

class Marketplace extends \App\Mappers\Marketplace
{

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\UsersCourses', 'marketplace_id', ['alias' => 'UsersCourses']);
        $this->belongsTo('course_id', 'App\Api\Models\Courses', 'id', ['alias' => 'Courses']);
        $this->belongsTo('marketplace_status_id', 'App\Api\Models\MarketplaceStatuses', 'id', ['alias' => 'MarketplaceStatuses']);
        $this->belongsTo('organisation_id', 'App\Api\Models\Organisations', 'id', ['alias' => 'Organisations']);
        $this->belongsTo('reviewed_by', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
    }

}