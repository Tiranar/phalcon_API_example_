<?php

namespace App\Api\Models;

class UsersCoursesProgress extends \App\Mappers\UsersCoursesProgress
{

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('course_id', 'App\Api\Models\Courses', 'id', ['alias' => 'Courses']);
        $this->belongsTo('lesson_id', 'App\Api\Models\Lessons', 'id', ['alias' => 'Lessons']);
        $this->belongsTo('progress_status_id', 'App\Api\Models\LessonsProgressStatus', 'id', ['alias' => 'LessonsProgressStatus']);
        $this->belongsTo('user_id', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
    }

}