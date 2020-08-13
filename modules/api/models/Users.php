<?php

namespace App\Api\Models;

class Users extends \App\Mappers\Users
{
    public static $hiddenAttributes = [
        'id',
        'last_seen_org_id',
        'avatar_id',
        'password',
        'confirm_code',
        'is_internal',
        'remember_token',
        'login_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\Certificates', 'user_id', ['alias' => 'Certificates']);
        $this->hasMany('id', 'App\Api\Models\Courses', 'author_id', ['alias' => 'AuthorCourses']);
        $this->hasMany('id', 'App\Api\Models\Courses', 'original_author_id', ['alias' => 'Courses']);
        $this->hasMany('id', 'App\Api\Models\CoursesContributors', 'user_id', ['alias' => 'CoursesContributors']);
        $this->hasMany('id', 'App\Api\Models\LessonComments', 'user_id', ['alias' => 'LessonComments']);
        $this->hasMany('id', 'App\Api\Models\Marketplace', 'reviewed_by', ['alias' => 'Marketplace']);
        $this->hasMany('id', 'App\Api\Models\UsersChatsMessages', 'receiver_id', ['alias' => 'UsersChatsMessages']);
        $this->hasMany('id', 'App\Api\Models\UsersCourses', 'assigned_by_id', ['alias' => 'AssignedBy']);
        $this->hasMany('id', 'App\Api\Models\UsersCourses', 'user_id', ['alias' => 'UsersCourses']);
        $this->hasMany('id', 'App\Api\Models\UsersCoursesProgress', 'user_id', ['alias' => 'UsersCoursesProgress']);
        $this->hasMany('id', 'App\Api\Models\UsersOrganisations', 'user_id', ['alias' => 'UsersOrganisations']);
        $this->belongsTo('last_seen_org_id', 'App\Api\Models\Organisations', 'id', ['alias' => 'Organisations']);
    }

}