<?php

namespace App\Api\Models;

class Certificates extends \App\Mappers\Certificates
{

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('course_id', 'App\Api\Models\Courses', 'id', ['alias' => 'Courses']);
        $this->belongsTo('org_id', 'App\Api\Models\Organisations', 'id', ['alias' => 'Organisations']);
        $this->belongsTo('user_id', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
    }

}