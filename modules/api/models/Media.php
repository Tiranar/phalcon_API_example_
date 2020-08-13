<?php

namespace App\Api\Models;

class Media extends \App\Mappers\Media
{

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('lesson_id', 'App\Api\Models\Lessons', 'id', ['alias' => 'Lessons']);
        $this->belongsTo('media_extension_id', 'App\Api\Models\MediaExtensions', 'id', ['alias' => 'MediaExtensions']);
    }

}