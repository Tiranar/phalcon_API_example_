<?php

namespace App\Api\Models;

class UsersCourses extends \App\Mappers\UsersCourses
{

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('assigned_by_id', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
        $this->belongsTo('course_id', 'App\Api\Models\Courses', 'id', ['alias' => 'Courses']);
        $this->belongsTo('marketplace_id', 'App\Api\Models\Marketplace', 'id', ['alias' => 'Marketplace']);
        $this->belongsTo('organisation_id', 'App\Api\Models\Organisations', 'id', ['alias' => 'Organisations']);
        $this->belongsTo('user_id', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
    }

}