<?php

namespace App\Api\Models;

class MediaExtensions extends \App\Mappers\MediaExtensions
{

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\Media', 'media_extension_id', ['alias' => 'Media']);
        $this->belongsTo('media_type_id', 'App\Api\Models\MediaTypes', 'id', ['alias' => 'MediaTypes']);
    }

}