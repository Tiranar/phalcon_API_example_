<?php

namespace App\Api\Models;

class Lessons extends \App\Mappers\Lessons
{

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\LessonComments', 'lesson_id', ['alias' => 'LessonComments']);
        $this->hasMany('id', 'App\Api\Models\Media', 'lesson_id', ['alias' => 'Media']);
        $this->hasMany('id', 'App\Api\Models\UsersCoursesProgress', 'lesson_id', ['alias' => 'UsersCoursesProgress']);
        $this->belongsTo('course_id', 'App\Api\Models\Courses', 'id', ['alias' => 'Courses']);
    }

}