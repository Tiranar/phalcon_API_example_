<?php

namespace App\Api\Models;

class LessonsProgressStatus extends \App\Mappers\LessonsProgressStatus
{

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\UsersCoursesProgress', 'progress_status_id', ['alias' => 'UsersCoursesProgress']);
    }

}