<?php

namespace App\Api\Models;

class CoursesContributors extends \App\Mappers\CoursesContributors
{

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('course_id', 'App\Api\Models\Courses', 'id', ['alias' => 'Courses']);
        $this->belongsTo('user_id', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
    }

}