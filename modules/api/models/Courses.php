<?php

namespace App\Api\Models;

class Courses extends \App\Mappers\Courses
{

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\Certificates', 'course_id', ['alias' => 'Certificates']);
        $this->hasMany('id', 'App\Api\Models\CoursesContributors', 'course_id', ['alias' => 'CoursesContributors']);
        $this->hasMany('id', 'App\Api\Models\Lessons', 'course_id', ['alias' => 'Lessons']);
        $this->hasMany('id', 'App\Api\Models\Marketplace', 'course_id', ['alias' => 'Marketplace']);
        $this->hasMany('id', 'App\Api\Models\UsersCourses', 'course_id', ['alias' => 'UsersCourses']);
        $this->hasMany('id', 'App\Api\Models\UsersCoursesProgress', 'course_id', ['alias' => 'UsersCoursesProgress']);
        $this->belongsTo('author_id', 'App\Api\Models\Users', 'id', ['alias' => 'Author']);
        $this->belongsTo('original_author_id', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
    }

}