<?php

namespace App\Api\Models;

class LessonComments extends \App\Mappers\LessonComments
{

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('lesson_id', 'App\Api\Models\Lessons', 'id', ['alias' => 'Lessons']);
        $this->belongsTo('user_id', 'App\Api\Models\Users', 'id', ['alias' => 'Users']);
    }

}