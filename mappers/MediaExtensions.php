<?php

namespace App\Mappers;

/**
 * MediaExtensions
 * 
 * @package App\Mappers
 */
class MediaExtensions extends BaseMapper
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $media_type_id;

    /**
     *
     * @var string
     */
    public $media_extension;

    /**
     *
     * @var string
     */
    public $media_mime;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema($this->getDI()->getShared('config')->database->dbname);
        $this->setSource("media_extensions");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'media_extensions';
    }

}
