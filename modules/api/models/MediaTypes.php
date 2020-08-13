<?php

namespace App\Api\Models;

class MediaTypes extends \App\Mappers\MediaTypes
{

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\MediaExtensions', 'media_type_id', ['alias' => 'MediaExtensions']);
    }

}